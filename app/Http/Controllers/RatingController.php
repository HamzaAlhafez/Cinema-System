<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;
use App\Models\Ticket;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function create()
{
    $user = Auth::user();

    $ticket = Ticket::where('user_id', $user->id)
                ->where('Booking_Status', true)
                ->where('rated', false)
                ->first();
                

    if (!$ticket) {
        return redirect()->route('home');
    }

    return view('Rating.AddRating', compact('ticket'));
}
private function validateRating(Request $request)
{
    return $request->validate([
        'ticket_id'          => ['required', Rule::exists(Ticket::class, 'id')],
        'movie_quality'      => ['required','integer','between:1,5'],
        'hall_cleanliness'   => ['required','integer','between:1,5'],
        'seat_comfort'       => ['required','integer','between:1,5'],
        'sound_quality'      => ['required','integer','between:1,5'],
        'screen_quality'     => ['required','integer','between:1,5'],
        'food_quality'       => ['nullable','integer','between:1,5'],
        'staff_behavior'     => ['required','integer','between:1,5'],
        'overall_experience' => ['required','integer','between:1,5'],
        'comments'           => ['nullable','string','max:1000'],
    ], [
        'ticket_id.required'          => 'Ticket ID is required.',
        'ticket_id.exists'            => 'The selected ticket does not exist.',
        'movie_quality.required'      => 'Please rate the movie quality.',
        'movie_quality.integer'       => 'Movie quality must be an integer.',
        'movie_quality.between'       => 'Movie quality must be between 1 and 5.',
        'hall_cleanliness.required'   => 'Please rate the hall cleanliness.',
        'hall_cleanliness.integer'    => 'Hall cleanliness must be an integer.',
        'hall_cleanliness.between'    => 'Hall cleanliness must be between 1 and 5.',
        'seat_comfort.required'       => 'Please rate the seat comfort.',
        'seat_comfort.integer'        => 'Seat comfort must be an integer.',
        'seat_comfort.between'        => 'Seat comfort must be between 1 and 5.',
        'sound_quality.required'      => 'Please rate the sound quality.',
        'sound_quality.integer'       => 'Sound quality must be an integer.',
        'sound_quality.between'       => 'Sound quality must be between 1 and 5.',
        'screen_quality.required'     => 'Please rate the screen quality.',
        'screen_quality.integer'      => 'Screen quality must be an integer.',
        'screen_quality.between'      => 'Screen quality must be between 1 and 5.',
        'food_quality.integer'        => 'Food quality must be an integer.',
        'food_quality.between'        => 'Food quality must be between 1 and 5.',
        'staff_behavior.required'     => 'Please rate the staff behavior.',
        'staff_behavior.integer'      => 'Staff behavior must be an integer.',
        'staff_behavior.between'      => 'Staff behavior must be between 1 and 5.',
        'overall_experience.required' => 'Please rate your overall experience.',
        'overall_experience.integer'  => 'Overall experience must be an integer.',
        'overall_experience.between'  => 'Overall experience must be between 1 and 5.',
        'comments.string'             => 'Comments must be a string.',
        'comments.max'                => 'Comments cannot exceed 1000 characters.',
    ]);
}
   
    public function store(Request $request)
{
    $validatedData = $this->validateRating($request);
   
    DB::beginTransaction();

    try {
       

        $user = auth()->user();
        
        $ticket = Ticket::where('id', $request->ticket_id)
                        ->where('user_id', $user->id)
                        ->where('Booking_Status', true)
                        ->where('rated', false)
                        ->firstOrFail();

        Rating::create([
            'ticket_id' => $ticket->id,
            'user_id' => $user->id,
            'movie_quality' => $validatedData['movie_quality'],
            'hall_cleanliness' => $validatedData['hall_cleanliness'],
            'seat_comfort' => $validatedData['seat_comfort'],
            'sound_quality' => $validatedData['sound_quality'],
            'screen_quality' => $validatedData['screen_quality'],
            'food_quality' => $validatedData['food_quality'] ?? null,
            'staff_behavior' => $validatedData['staff_behavior'],
            'overall_experience' => $validatedData['overall_experience'],
            'comments' => $validatedData['comments'] ?? null,
        ]);

        $ticket->update(['rated' => true]);

        DB::commit();

        $nextTicket = Ticket::where('user_id', $user->id)
                            ->where('Booking_Status', true)
                            ->where('rated', false)
                            ->first();

        if ($nextTicket) {
            return redirect()->route('rating.create')
                             ->with([
                                 'flash' => 'success',
                                 'message' => '✅ Thanks! Please rate your next ticket.'
                             ]);
        }

        return redirect()->route('home')->with([
            'flash' => 'success',
            'message' => '✅ Thanks for rating your experience!'
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with([
            'flash' => 'error',
            'message' => '❌ An error occurred while processing your rating. Please try again.'
        ]);
        
      
    

   
   
    

    

}
}
public function myRatings()
{
    $user = auth()->user();

    
    $ratings = Rating::with(['ticket.show.movie'])
                    ->where('user_id', $user->id)
                    ->get();

    return view('Rating.myRatings', compact('ratings'));
}
public function edit($id)
{
    $rating = Rating::find($id);

    
    if ($rating->user_id !== auth()->id()) {
        abort(404); 
    }

    
    return view('Rating.updateRating', compact('rating'));
   
}
public function update(Request $request, $id)
{
    try {
      
        $validatedData = $this->validateRating($request);

       
        $rating = Rating::findOrFail($id);

        $rating->update([
            'movie_quality'      => $validatedData['movie_quality'],
            'hall_cleanliness'   => $validatedData['hall_cleanliness'],
            'seat_comfort'       => $validatedData['seat_comfort'],
            'sound_quality'      => $validatedData['sound_quality'],
            'screen_quality'     => $validatedData['screen_quality'],
            'food_quality'       => $validatedData['food_quality'] ?? null,
            'staff_behavior'     => $validatedData['staff_behavior'],
            'overall_experience' => $validatedData['overall_experience'],
            'comments'           => $validatedData['comments'] ?? null,
        ]);

        return redirect()->back()->with([
            'flash' => 'success',
            'message' => '✅ Rating updated successfully.'
        ]);

    } catch (\Exception $e) {
        return redirect()->back()->with([
            'flash' => 'error',
            'message' => '❌ An error occurred while processing your rating. Please try again.'
        ]);
    }
}


}
