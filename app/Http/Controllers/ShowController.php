<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Hall;
use App\Models\Show;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

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


    public function getAvailableHalls(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        // تحديد القاعات التي تم حجزها في نفس التاريخ والتوقيت
        $occupiedHalls = Show::where('date', $request->date)
        ->where(function ($query) use ($request) {
            $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                  ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                  ->orWhere(function ($q) use ($request) {
                      $q->where('start_time', '<', $request->end_time)
                        ->where('end_time', '>', $request->start_time);
                  });
        })
        ->pluck('hall_id');


        // جلب القاعات التي لم يتم حجزها في هذا التوقيت
        $availableHalls = Hall::whereNotIn('id', $occupiedHalls)->get();

        return response()->json($availableHalls);
    }



     private function VaildRequest(Request $request)
    {
           $request->validate([
            'movie_id' => ['required', Rule::exists(Movie::class, 'id')],
            'hall_id' => ['required', Rule::exists(Hall::class, 'id')],
            'date' => ['required', 'date', 'after:today'],
            'price' => ['required', 'numeric', 'gte:0'],
            'start_time' => ['required', 'date_format:H:i'],
'end_time' => ['required', 'date_format:H:i', 'after:start_time'],




        ]);


    }




    public function store(Request $request)
{
    $this->VaildRequest($request);

    // التحقق من أن القاعة غير محجوزة في نفس الوقت
    $isOccupied = Show::where('hall_id', $request->hall_id)
                      ->where('date', $request->date)
                      ->where(function($query) use ($request) {
                          $query->whereBetween('start_time', [$request->start_time, $request->End_time])
                                ->orWhereBetween('end_time', [$request->start_time, $request->End_time]);
                      })
                      ->exists();

    if ($isOccupied) {
        return redirect()->back()->withErrors(['hall_id' =>'This hall is busy at this time !'])->withInput();
    }

    try {
        $hall = Hall::findOrFail($request->hall_id);
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
    } catch (\Exception $e) {
        return redirect()->back()->withErrors(['error' => $e->getMessage()]);
    }

    session()->flash('add');
    return redirect()->route('shows.index');
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
$Show->end_time= strip_tags($request->input('end_time'));
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
        $to_delete -> delete();

        }
        catch (\Exception $e) {
     return redirect()->back()->withErrors(['error' => $e->getMessage()]);

}



       session()->flash('delete');
return redirect()->route('shows.index');

    }


    public function create()
    {
        $movies = Movie::all();
        $availableHalls = Hall::all(); // في البداية عرض جميع القاعات

        return view('dashboard.shows.create', compact('movies', 'availableHalls'));
    }

}
