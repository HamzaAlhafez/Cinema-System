<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Hall;
use App\Models\Show;
use App\Models\Ticket;
use App\Models\User;
use carbon\carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Mail\EmailService;
use Illuminate\Support\Facades\Mail;

// index and store and search and update and destroy

class ShowController extends Controller
{

    public function index()
{
    $shows = Show::with(['movie', 'hall'])->get();
    return view('dashboard.shows.index', compact('shows'));
}


     public function Search(Request $request)
    {
        $request->validate([
    'textSearch' => ['required'],
]);

$textSearch = $request->textSearch;

try {



    $movies = Movie::where('title', $textSearch )->pluck('id')->first();



    $shows=Show::where('movie_id',$movies)->with('movie', 'hall')->get();




} catch (\Exception $e) {
    return redirect()->back()->withErrors(['error' => $e->getMessage()]);
}


if ($shows->count() > 0) {
    return view('dashboard.shows.index', compact('shows'));
} else {
     session()->flash('SearchFaild');
    return redirect()->route('shows.index');
}



    }


   



     private function VaildRequest(Request $request)
    {
           $request->validate([
            'movie_id' => ['required', Rule::exists(Movie::class, 'id')],
            'hall_id' => ['required', Rule::exists(Hall::class, 'id')],
            'date' => ['required', 'date','after_or_equal:today'],
            'price' => ['required', 'numeric', 'gte:0'],
            'start_time' => ['required', 'date_format:H:i'],
            'End_time' => ['required', 'date_format:H:i', 'after:start_time'],




        ]);


    }
    private function hasConflictingShow($hall_id, $date, $start_time, $end_time)
{
    return Show::where('hall_id', $hall_id)
        ->where('date', $date)
        ->where(function ($query) use ($start_time, $end_time) {
            $query->where('start_time', '<', $end_time)
                  ->where('end_time', '>', $start_time);
        })
        ->exists();
}






    public function store(Request $request)
{
    $this->VaildRequest($request);

    try {
        $hall = Hall::findOrFail($request->hall_id);
        
        
        $conflictingShow = $this->hasConflictingShow(
            $request->hall_id,
            $request->date,
            $request->start_time,
            $request->End_time
        );

        if ($conflictingShow) {
            
                session()->flash('conflictingShow');
                return redirect()->route('shows.index');
        }

        $Show = new Show();
        $Show->movie_id = strip_tags($request->input('movie_id'));
        $Show->hall_id = strip_tags($request->input('hall_id'));
        $Show->admin_id = Auth::guard('admin')->user()->id;
        $Show->date = strip_tags($request->input('date'));
        $Show->price = strip_tags($request->input('price'));
        $Show->start_time = strip_tags($request->input('start_time'));
        $Show->end_time = strip_tags($request->input('End_time'));
        $Show->remaining_seats = $hall->Capacity;
        $Show->save();
        $Show->load(['movie', 'hall']);
        $users = User::all();

foreach ($users as $user) {
    Mail::to($user->email)->send(new EmailService($Show, 'show'));
}
        // Mail::to('hamzaalafez@gmail.com')->send(new EmailService($Show, 'show'));
       


        session()->flash('add');
        return redirect()->route('shows.index');
        
    } catch (\Exception $e) {
        return redirect()->back()
            ->withInput()
            ->withErrors(['error' => $e->getMessage()]);
    }
    
}





    public function update(Request $request,$id)
    {
              $this->VaildRequest($request);

try {
    $hall=Hall::findorfail($request->hall_id);
    $Show =Show::findorfail($id);
   

    
   
$Show->movie_id = strip_tags($request->input('movie_id'));
$Show->hall_id =strip_tags($request->input('hall_id'));
$Show->date = strip_tags($request->input('date'));
$Show->price = strip_tags($request->input('price'));
$Show->start_time= strip_tags($request->input('start_time'));
$Show->end_time= strip_tags($request->input('End_time'));
$Show->remaining_seats=$hall->Capacity;
    $Show->save();
} catch (\Exception $e) {
     return redirect()->back()->withErrors(['error' => $e->getMessage()]);

}
session()->flash('edit');
return redirect()->route('shows.index');

    }


    public function destroy(string $id)
    {
         try {
             $to_delete=Show::findorfail($id);
             $tiket=Ticket::where('show_id',$id)->count();
             if ($to_delete->date >= Carbon::today() && $tiket > 0) {
                session()->flash('showExpirydateYet');
                return redirect()->route('shows.index');
            }
        $to_delete -> delete();
        session()->flash('delete');

        }
        catch (\Exception $e) {
     return redirect()->back()->withErrors(['error' => $e->getMessage()]);

}



       session()->flash('delete');
return redirect()->route('shows.index');

    }


   

}
