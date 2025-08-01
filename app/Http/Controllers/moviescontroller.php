<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Categorie;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;




// index and search and saveimage and update and store and destroy


class moviescontroller extends Controller
{

    public function index()
    {
        $movies = Movie::with('Categorie')->get();
        return view('dashboard.movies.index',compact('movies'));

    }
    public function Search(Request $request)
    {
       // dd($request->all());
       if($request->textSearch==null)
       {
        return redirect()->back();

       }
          $request->validate([
             'textSearch' => ['required'],



            ]);

            $textSearch=$request->textSearch;

            try
       {
        $movies = Movie::where('title', 'LIKE', "%{$textSearch}%")->get();


       }

       catch (\Exception $e) {

        return redirect()->back()->withErrors(['error' => $e->getMessage()]);

}


       if($movies->count() > 0)
       {
        return view('dashboard.movies.index',compact('movies'));

       }
       else
       {
         session()->flash('SearchFaild');

        return redirect()->route('movies.index');

       }


    }






    public function SaveImage($title,$image,$folder)
    {

        $file_extension=$image -> getClientOriginalExtension() ;
        $file_name=$title . '.' .$file_extension;
        $path=$folder;

        $image -> move($path,$file_name);
        return $file_name;

    }

     private function VaildRequest(Request $request)
    {
           $request->validate([
            'title' => ['required', 'min:1', 'max:255','unique:movies'],
            'Categories_id' => ['required', Rule::exists(Categorie::class, 'id')],
            'language' => ['required', 'min:1', 'max:255'],
             'rating' => ['required', 'numeric', 'lte:5', 'gte:0'],
             'productiondate' => ['required', 'date'],
            'director' => ['required', 'min:1', 'max:255'],
              'Actors' => ['required', 'min:1', 'string'],
             'storeline' => ['required', 'min:1', 'string'],

    ]);


    }
    private function VaildRequestupdate(Request $request,$id)
    {
           $request->validate([
            'title' => ['required', 'min:1', 'max:255',Rule::unique('movies')->ignore($id)],
            'Categories_id' => ['required', Rule::exists(Categorie::class, 'id')],
            'language' => ['required', 'min:1', 'max:255'],
             'rating' => ['required', 'numeric', 'lte:5', 'gte:0'],
             'productiondate' => ['required', 'date'],
            'director' => ['required', 'min:1', 'max:255'],
              'Actors' => ['required', 'min:1', 'string'],
             'storeline' => ['required', 'min:1', 'string'],
        ]);

    }



    public function store(Request $request)
    {
        // dd($request->all());
    $filename = $this->SaveImage($request->title, $request->image, 'imagesmoives/moive');
 $this->VaildRequest($request);

 try {
    $Moive = new Movie();
 $Moive->title = strip_tags($request->input('title'));
 $Moive->categorie_id =strip_tags($request->input('Categories_id'));
 $Moive->image = $filename;
 $Moive->storyline = strip_tags($request->input('storeline'));
 $Moive->rating = strip_tags($request->input('rating'));
 $Moive->language = strip_tags($request->input('language'));
 $Moive->production_date = strip_tags($request->input('productiondate'));
 $Moive->director = strip_tags($request->input('director'));
 $Moive->Actors = strip_tags($request->input('Actors'));
 $Moive->admin_id=Auth::guard('admin')->user()->id;
      $Moive->save();
     }
     catch (\Exception $e) {
      return redirect()->back()->withErrors(['error' => $e->getMessage()]);
}

    session()->flash('add');
    return redirect()->route('movies.index');
       }



     public function update(Request $request,$id)

     {
        // dd($request->all());
         $this->VaildRequestupdate($request,$id);
         try
         {
             $Moive=Movie::findorfail($id);
        $Moive->title = strip_tags($request->input('title'));
 $Moive->categorie_id =strip_tags($request->input('Categories_id'));

 $Moive->storyline = strip_tags($request->input('storeline'));
 $Moive->rating = strip_tags($request->input('rating'));
 $Moive->language = strip_tags($request->input('language'));
 $Moive->production_date = strip_tags($request->input('productiondate'));
 $Moive->director = strip_tags($request->input('director'));
 $Moive->Actors = strip_tags($request->input('Actors'));


 if($request->image!=null)
 {
    $destiantion='imagesmoives/moive/'.$Moive->image;

 if(file::exists($destiantion))
 {
    file::delete($destiantion);

}
 $filename = $this->SaveImage($request->title, $request->image, 'imagesmoives/moive');
 $Moive->image = $filename;

}
 $Moive->save();

         }
         catch (\Exception $e) {
     return redirect()->back()->withErrors(['error' => $e->getMessage()]);

}
session()->flash('edit');
return redirect()->route('movies.index');

   }

   public function destroy(string $id)
{
    try {

        $showsCount = \DB::table('shows')->where('movie_id', $id)->count();

        if ($showsCount > 0) {
            session()->flash('MoiveHaveShow');

            return redirect()->back();

        }



        $to_delete = Movie::findOrFail($id);
         $destiantion='imagesmoives/moive/'.$to_delete->image;
             if(file::exists($destiantion))
{
    file::delete($destiantion);

}


        $to_delete->delete();


    } catch (\Exception $e) {
        return redirect()->back()->withErrors(['error' => $e->getMessage()]);
    }

    session()->flash('delete');
    return redirect()->route('movies.index');
}



}
















































