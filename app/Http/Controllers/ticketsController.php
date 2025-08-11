<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Show;
use App\Models\Ticket;
use App\Models\SeatReservation;
use App\Models\LoyaltyTransaction;
use Illuminate\Support\Facades\Auth;
use App\Models\Promocode;
use App\Models\Promocodeusage;
use App\Models\Purchasepromocode;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Mail\EmailService;
use Illuminate\Support\Facades\Mail;

class ticketsController extends Controller
{
    
    public function index()
    {
        try 
        {
            $tickets = Ticket::where('user_id', auth()->id())
            ->whereHas('show', function($query) {
                $query->where('date', '>', now()->toDateString())
                      ->orWhere(function($q) {
                          $q->whereDate('date', now()->toDateString())
                            ->whereTime('end_time', '>', now()->toTimeString());
                      });
            })
            ->with('show.movie', 'show.hall')
            ->get();
            return view('Reservations.MyReservations', compact('tickets'));

        }catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'An unexpected error occurred. Please try again.']);


        }
    }
       
        



    


    public function create()
    {

    }
    private function VaildRequest(Request $request)
    {
            $request->validate([
            'selected_seats' => 'required|string',
            'final_price' => 'required|numeric|min:1',
            'selected_count' => 'required|integer|min:1',
            'show_id' => ['required', Rule::exists(Show::class, 'id')]
        ]);


    }


    public function store(Request $request)
{
    
    $this->VaildRequest($request);
   
    
    


    DB::beginTransaction();

    try {
        $selectedSeats = array_map('intval', explode(',', $request->selected_seats));
        
        
        $this->lockAndCheckSeats($request->show_id, $selectedSeats);
        $couponCode = $request->input('coupon_code');

        $discount = $this->handlecouponcode($request);
        if($discount === 0 && $couponCode)
        {
            return redirect()->back()->with([
                'flash' => 'error',
                'message' => 'Booking failed: Invalid promo code. Reservation not  completed.'
            ]);

        }
        $ticket = $this->createTicket($request, $discount);
        
        $this->createSeatReservations($request, $ticket);
        $this->updateShowRemainingSeats($request);
        $this->handleLoyaltyPoints();
        $ticket->load(['show.movie', 'show.hall', 'seatReservations']); 

        $emailData = (object) [
           'ticket' => $ticket,
           'seats' => $ticket->seatReservations,
           'type' => 'booking'
       ];
       Mail::to(auth()->user()->email)->send(new EmailService($emailData, 'booking'));
        //   Mail::to('hamzaalafez@gmail.com')->send(new EmailService($emailData, 'booking'));
       
           
          
           
        

        DB::commit();
        
       
if ($couponCode) {
    if ($discount > 0) {
        $finalPrice = $request->final_price * (1 - ($discount / 100));
       
        return redirect()->route('ticket-foods.create', ['ticket_id' => $ticket->id])->with([
            'flash' => 'success',
            'message' => "🎉 Booking successful! $discount% discount applied. Final price: $finalPrice$. You have been awarded 100 points! 💯✨"
        ]);
    } 
      
}

       

return redirect()->route('ticket-foods.create', ['ticket_id' => $ticket->id])->with([
    'flash' => 'success',
    'message' => '✅Ticket booked successfully.You have been awarded 100 points! 💯✨'
]);
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with([
            'flash' => 'error',
            'message' => 'Booking failed: '
        ]);
    }
    
       
    

}
        
        
       
    

     




















    
    private function handleLoyaltyPoints(): void
{
    $user=Auth::user();
    $user->loyalty_points=$user->loyalty_points+100;

    $LoyaltyTransaction=new LoyaltyTransaction();
    $LoyaltyTransaction->user_id=Auth::user()->id;
    $LoyaltyTransaction->points=100;
    $LoyaltyTransaction->description="for the tiket";
    $user->save();
$LoyaltyTransaction->save();
}
private function updateShowRemainingSeats(Request $request): void
{
    $Show = Show::findOrFail($request->show_id);
  
    $Show->remaining_seats = $Show->remaining_seats - $request->selected_count;
    $Show->save();
}
private function createSeatReservations(Request $request, Ticket $ticket): void
{
    
    $selectedSeats = array_map('intval', explode(',', $request->selected_seats));
    $seatReservations = [];
            foreach ($selectedSeats as $seatNumber) {
                $seatReservations[] = [
                    'seat_number' => $seatNumber,
                    'show_id' => $request->show_id,
                    'ticket_id' => $ticket->id,
                    
                ];
            }
            SeatReservation::insert($seatReservations);
}
private function createTicket(Request $request,$discount): Ticket
{
    return Ticket::create([
        'show_id' => $request->show_id,
        'user_id' => Auth::id(),
        'Seats_Booked' => $request->selected_count,
        'tickets_Price' => $discount > 0 
    ? $request->final_price * (1 - ($discount / 100))
    : $request->final_price * 1,
    'Booking_Status' => false,
        'Booking_date' => now()
        
        
    ]);
}
private function lockAndCheckSeats(int $showId, array $seatNumbers): void
{
    
    $lockedSeats = SeatReservation::where('show_id', $showId)
        ->whereIn('seat_number', $seatNumbers)
        ->lockForUpdate()
        ->get();

    
    $unavailableSeats = [];
    foreach ($seatNumbers as $seat) {
        $existingSeat = $lockedSeats->firstWhere('seat_number', $seat);
        
        if ($existingSeat && $existingSeat->ticket_id !== null) {
            $unavailableSeats[] = $seat;
        }
    }

    if (!empty($unavailableSeats)) {
        throw new \Exception('Some seats are already booked: ' . implode(', ', $unavailableSeats));
    }
}
private function handlecouponcode(Request $request): int
{
    $couponCode = $request->input('coupon_code');
    $userId = Auth::id();

    if (!$couponCode) {
        return 0;
    }

    $coupon = $this->getValidLockedCoupon($couponCode);
    
    if (!$coupon) {
        return 0;
    }

    if (!$this->userPurchasedCoupon($userId, $coupon->id)) {
        return 0;
    }

    if ($this->userReachedUsageLimit($userId, $coupon)) {
        return 0;
    }

    return $this->applyCoupon($coupon, $userId);
}
private function getValidLockedCoupon(string $code): ?Promocode
{
    return Promocode::where('code', $code)
        ->where('type', 'discount')
        ->where('is_active', true)
        ->where('expiry_date', '>', now())
        ->whereColumn('used_count', '<', 'max_usage')
        ->lockForUpdate()
        ->first();
      
}
private function userPurchasedCoupon(int $userId, int $couponId): bool
{
    return Purchasepromocode::where('user_id', $userId)
        ->where('promocode_id', $couponId)
        ->exists();
}
private function userReachedUsageLimit(int $userId, Promocode $coupon): bool
{
    $usageCount = Promocodeusage::where('user_id', $userId)
        ->where('promocode_id', $coupon->id)
        ->count();

    return $usageCount >= $coupon->max_usage_per_user;
}
private function applyCoupon(Promocode $coupon, int $userId): int
{
    $coupon->increment('used_count');

    Promocodeusage::create([
        'user_id' => $userId,
        'promocode_id' => $coupon->id
    ]);

    if ($coupon->used_count >= $coupon->max_usage) {
        $coupon->update(['is_active' => false]);
    }

    return (int)$coupon->value;
}






    public function show(string $id)
    {
       
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
{
    try {
        $ticket = Ticket::with([
            'show.movie', 
            'show.hall'
        ])->findOrFail($id);

       
        if (auth()->id() !== $ticket->user_id) {
            abort(403, 'Unauthorized action');
        }

        
        $reservedSeatsExceptUser = SeatReservation::where('show_id', $ticket->show_id)
            ->where('ticket_id', '!=', $ticket->id)
            ->pluck('seat_number')
            ->toArray();

        $currentTicketSeats = $ticket->seatReservations
            ->pluck('seat_number')
            ->toArray();

        
        $viewData = [
            'ticket' => $ticket,
            'reservedSeatsExceptUser' => $reservedSeatsExceptUser,
            'currentTicketSeats' => $currentTicketSeats,
            'hallCapacity' => $ticket->show->hall->Capacity,
            'showPrice' => $ticket->show->price,
            'movieTitle' => $ticket->show->movie->title,
            'showDate' => $ticket->show->date,
            'showStartTime' => $ticket->show->start_time,
            'showEndTime' => $ticket->show->end_time,
            'hallName' => $ticket->show->hall->hall_name,
        ];

        return view('Reservations.TicketUpdate', $viewData);

    } 
        
     catch (\Exception $e) {
       
        return redirect()->back()->withErrors(['error' => 'An unexpected error occurred. Please try again.']);
    }
}
private function validateRequest(Request $request): void
{
    $request->validate([
        'selected_seats' => 'required|string',
        'final_price' => 'required|numeric|min:1',
        'seats_count' => 'required|integer|min:1'
    ]);
}
private function getTicketWithShow($id): Ticket
{
    return Ticket::with('show')->findOrFail($id);
}
private function authorizeUser(Ticket $ticket): void
{
    if (auth()->id() !== $ticket->user_id) {
        abort(403, 'Unauthorized action');
    }
}
private function validateShowTime(Ticket $ticket): bool
{
    $currentTime = Carbon::now('Asia/Damascus'); 
    $showDateTime = Carbon::parse(
        $ticket->show->date->format('Y-m-d') . ' ' . 
        $ticket->show->start_time->format('H:i:s'),
        'Asia/Damascus'
    );
    return $currentTime->diffInMinutes($showDateTime) < 60;
               
                
    
}
private function parseSelectedSeats(Request $request): array
{
    $selectedSeats = array_map('intval', explode(',', $request->selected_seats));
    sort($selectedSeats);
    return $selectedSeats;
}


private function getCurrentTicketSeats(Ticket $ticket): array
{
    $currentTicketSeats = $ticket->seatReservations->pluck('seat_number')->toArray();
    sort($currentTicketSeats);
    return $currentTicketSeats;
}


private function seatsUnchanged(array $selectedSeats, array $currentSeats): bool
{
    return $selectedSeats === $currentSeats;
}
private function deleteOldSeatReservations(Ticket $ticket): void
{
    SeatReservation::where('ticket_id', $ticket->id)
        ->whereHas('ticket', function($query) {
            $query->where('user_id', auth()->id());
        })
        ->delete();
}

private function createNewSeatReservations(Ticket $ticket, array $selectedSeats): void
{
    $seatReservations = [];
    foreach ($selectedSeats as $seatNumber) {
        $seatReservations[] = [
            'seat_number' => $seatNumber,
            'show_id' => $ticket->show_id,
            'ticket_id' => $ticket->id,
            
        ];
    }
    SeatReservation::insert($seatReservations);
}
private function updateTicketDetails(Ticket $ticket, Request $request, int $newSeatsCount): void
{
    $ticket->update([
        'Seats_Booked' => $newSeatsCount,
        'tickets_Price' => $request->final_price
    ]);
}
private function updateShowSeats(Ticket $ticket, int $oldSeatsCount, int $newSeatsCount): void
{
    $show = Show::find($ticket->show_id);
    $seatsDifference = $oldSeatsCount - $newSeatsCount;
    $show->remaining_seats += $seatsDifference;
    $show->save();
}
private function refundLoyaltyPoints(Ticket $ticket): void
{
    $user = auth()->user();
    $user->loyalty_points -= 100;
    $user->save();
    LoyaltyTransaction::create([
        'user_id' => $user->id,
        'points' => -100,
        'description' => "Refund for canceled ticket #{$ticket->id}"
    ]);

    
}

public function update(Request $request,$id)
{
    $this->validateRequest($request);
    $ticket = $this->getTicketWithShow($id);
    
    $this->authorizeUser($ticket);
   if ($this->validateShowTime($ticket))
   {
    return redirect()->back()->with([
        'flash' => 'info',
        'message' => 'Cannot Update ticket: Less than 1 hour remaining before the show starts!'
    ]);

   }

    $selectedSeats = $this->parseSelectedSeats($request);
    $currentTicketSeats = $this->getCurrentTicketSeats($ticket);

    if ($this->seatsUnchanged($selectedSeats, $currentTicketSeats)) {
        return redirect()->back()->with([
            'flash' => 'info',
            'message' => 'No changes were made to your seats.'
        ]);
    }

    DB::beginTransaction();

    try {
        $oldSeatsCount = $ticket->Seats_Booked;
        $newSeatsCount = (int)$request->seats_count;
        
        $this->deleteOldSeatReservations($ticket);
        $this->createNewSeatReservations($ticket, $selectedSeats);
        $this->updateTicketDetails($ticket, $request, $newSeatsCount);
        $this->updateShowSeats($ticket, $oldSeatsCount, $newSeatsCount);
        
        DB::commit();
        return redirect()->route('tickets.index')->with([
            'flash' => 'success',
            'message' => "Ticket updated successfully! Final price: {$request->final_price}$"
        ]);
        
        
        
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with([
            'flash' => 'error',
            'message' => 'Update failed: '
        ]);
        
    }
}
private function refundSeatsToShow(Ticket $ticket): void
{
    $seatsCount = $ticket->Seats_Booked;
    $show = $ticket->show;
    $show->remaining_seats += $seatsCount;
    $show->save();
}
   

    
    

   
    public function destroy($id)
    {
        
        DB::beginTransaction();

        try {
            $ticket = $this->getTicketWithShow($id);

            if ($this->validateShowTime($ticket))
            {
             return redirect()->back()->with([
                 'flash' => 'info',
                 'message' => 'Cannot Delete ticket: Less than 1 hour remaining before the show starts!'
             ]);
            }
             $this->deleteOldSeatReservations($ticket);
             $this->refundSeatsToShow($ticket);
             $this->refundLoyaltyPoints($ticket);
             $ticket->delete();
             DB::commit();
             return redirect()->back()->with([
                'flash' => 'success',
                'message' => "Ticket deleted successfully!"
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with([
                'flash' => 'error',
                'message' => 'Ticket deleted failed: '
            ]);
        }
    }
}
      

           
            
    
    

           

    
    
           
           
    
           
          
    
          
           
    
           
    
           
            
            
       
    
        
        
        
        
    
           
            
    
          
            
    
         
            

           
    
      
       

        
    

