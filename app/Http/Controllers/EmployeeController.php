<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with('admin')->get();
        return view('dashboard.employees.index', compact('employees')); 
    }
    
    public function search(Request $request)
    {
        $request->validate([
            'textSearch' => ['required'],
        ]);
        
        $textSearch = $request->textSearch;
        
        try {
            $employees = Employee::where('name', $textSearch)->get();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
        
        if($employees->count() > 0) {
            return view('dashboard.employees.index', compact('employees'));
        } else {
            session()->flash('searchFailed');
            return redirect()->route('employees.index');
        }
    }
    
    private function validateRequest(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'regex:/^09[1-689][0-9]{7}$/', 'unique:employees'], // تغيير اسم الجدول
            'email' => ['required', 'string', 'email', 'unique:employees'], // تغيير اسم الجدول
            'password' => ['required', 'string', 'min:8'],
            'password-confirm' => ['required', 'string', 'same:password'],
        ]);
    }
    
    public function store(Request $request)
    {
        $this->validateRequest($request);
        
        try {
            $employee = new Employee();
            $employee->name = strip_tags($request->input('name'));
            $employee->email = strip_tags($request->input('email'));
            $employee->phone = strip_tags($request->input('phone'));
            $employee->password = Hash::make(strip_tags($request->input('password')));
            $employee->admin_id = Auth::guard('admin')->user()->id;
            $employee->save();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
        
        session()->flash('add');
        return redirect()->route('employees.index');
    }
    
    public function destroy(string $id)
    {
        try {
            $to_delete = Employee::findOrFail($id);
            $to_delete->delete();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
        
        session()->flash('delete');
        return redirect()->route('employees.index');
    }
}
