<?php

namespace App\Http\Controllers;

use App\Models\HallMaintenance;
use App\Models\Hall;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class HallMaintenanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $HallMaintenances = HallMaintenance::with('hall')->get();
        $halls = Hall::whereDoesntHave('shows')
            ->whereDoesntHave('HallMaintenances')
            ->get();

          return view('employee.Dashboard.HallMaintenances.index', compact('HallMaintenances', 'halls'));
        

      
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'hall_id' => ['required',Rule::exists(Hall::class, 'id')],
            'notes' => ['nullable','string' , 'min:1', 'max:255'],




        ]);

        try 
        {
            $HallMaintenance = new HallMaintenance();
            $HallMaintenance->hall_id=$request->hall_id;
            $HallMaintenance->employee_id=Auth::guard('employee')->user()->id;
            $HallMaintenance->start_date=now();
            $HallMaintenance->notes=$request->filled('notes') 
            ? strip_tags($request->input('notes'))
            : null;

           
            $HallMaintenance->save();
            return redirect()->back()->with([
                'flash' => 'success',
                'message' => 'Hall has been successfully added to maintenance' 
            ]);







        }
        catch(\Exception $e)
        {
            return redirect()->back()->with([
                'flash' => 'error',
                'message' => 'An error occurred while adding the hall to maintenance. Please try again'
            ]);

        }
       
    }

    /**
     * Display the specified resource.
     */
    public function show(HallMaintenance $hallMaintenance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HallMaintenance $hallMaintenance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HallMaintenance $hallMaintenance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $to_delete =HallMaintenance::findorfail($id);
            $to_delete->delete();
            return redirect()->back()->with([
                'flash' => 'success',
                'message' => 'Hall Remove from Maintenance  has been successfully' 
            ]);
                
              
           
            
           
            
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'flash' => 'error',
                'message' => 'An error occurred while Remove the hall from maintenance. Please try again'
            ]);
            
        }
        
    }
}
