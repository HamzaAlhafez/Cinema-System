<?php

namespace App\Http\Controllers;

use App\Models\TicketFood;
use App\Models\Food;
use App\Models\Ticket;
use App\Models\FoodCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TicketFoodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   
    public function index()
    {
        $foods = Food::with('FoodCategory')->get();
        $categories = FoodCategory::all();
        return view('Food.ShowFood', [
            'foods' => $foods,
            'categories' => $categories
            
           
        ]);

        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorizeUser(request('ticket_id'));
        $foods = Food::with('FoodCategory')->get();
        $categories = FoodCategory::all();
      
       
        
        return view('Food.AddFood', [
            'ticketId' => request('ticket_id'),
            'foods' => $foods,
            'categories' => $categories
        ]);
         
    
        
    }

    /**
     * Store a newly created resource in storage.
     */
    private function authorizeUser($ticketid): void
    {
        $ticket= Ticket::find($ticketid);

       if (auth()->id() !== $ticket->user_id) {
        abort(403, 'Unauthorized action');
          }

    }

    

    
    public function store(Request $request)
    {
        
        $validated = $this->validateData($request);
        DB::beginTransaction();
    
        try {
            
           
            
            
            $totalPrice=$this->processOrder($validated);
            
           
           $ticketTotalPrice=$this->updateTicketPrice($request->ticket_id, $totalPrice);
            
            DB::commit();
            
           
            return redirect()->back()->with([
                'flash' => 'success',
                'message' => '✅ Items added successfully! Your Ticket total price is $' . number_format($ticketTotalPrice, 2)
            ]);
    
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with([
                'flash' => 'error',
                'message' => 'Failed to add item'
            ]);
     
        }
         
         
    }
       
            
       
        
       
    
    private function validateData(Request $request)
    {
        return $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'items' => 'required|array|min:1',
            'items.*.food_id' => 'required|exists:foods,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.total_price' => 'required|numeric|min:0'
        ]);
    }
    private function processOrder($validatedData)
    {
        $totalPrice = 0;
        
        foreach ($validatedData['items'] as $item) {
            $food = Food::find($item['food_id']);
            
            
            
            $food->stock -= $item['quantity'];
            $food->save();
            
            TicketFood::create([
                'ticket_id' => $validatedData['ticket_id'],
                'food_id' => $item['food_id'],
                'quantity' => $item['quantity'],
                'total_Price' => $item['total_price']
            ]);
            
            $totalPrice += $item['total_price'];
        }
        
        return $totalPrice;
    }

    private function updateTicketPrice($ticketId, $totalPrice)
    {
        $ticket = Ticket::find($ticketId);
        $ticket->tickets_Price += $totalPrice;
        $ticket->save();
        return $ticket->tickets_Price;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TicketFood $ticketFood)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TicketFood $ticketFood)
    {
        //
    }
}
