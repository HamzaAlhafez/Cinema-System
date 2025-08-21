<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee; 
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Show;
use App\Models\Ticket;
use Carbon\Carbon;

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
            'phone' => ['required', 'regex:/^09[1-689][0-9]{7}$/', 'unique:employees','unique:users','unique:admins'], 
            'email' => ['required', 'string', 'email', 'unique:employees','unique:users','unique:admins'], 
            'salary' => ['required', 'numeric', 'gte:0'], 
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
            $employee->salary = strip_tags($request->input('salary'));
            $employee->password = Hash::make(strip_tags($request->input('password')));
            $employee->admin_id = Auth::guard('admin')->user()->id;
            $employee->save();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
        
        session()->flash('add');
        return redirect()->route('employees.index');
    }
    public function updateSalary(Request $request, $id)
    {
        $request->validate([
            'salary' => ['required', 'numeric', 'gte:0'], 
            
            
           
        ]);
        try 
        {
            $employee=Employee::findorfail($id);
            $employee->salary=strip_tags($request->input('salary'));
            $employee->save();

        }
        catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
        session()->flash('edit');
        return redirect()->route('employees.index');



    }
    
    public function ShowMyAccount()
    {
        $employee = Auth::guard('employee')->user();
        return view('employee.Dashboard.Profile.MyAccount', compact('employee'));

    }
    public function ShowChangePassword()
    {
        return view('employee.Dashboard.Profile.ChangePassword');

    }
    public function updateAccount(Request $request)
    {
        $employee = Auth::guard('employee')->user();
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'regex:/^09[1-689][0-9]{7}$/','unique:users','unique:admins',Rule::unique('employees')->ignore($employee->id)], 
            'email' => ['required', 'string', 'email','unique:users','unique:admins',Rule::unique('employees')->ignore($employee->id)], 
           
        ]);
    
      
       
    
        try {
          
            $employee->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
            ]);
            return redirect()->back()->with([
                'flash' => 'success',
                'message' => 'Account updated successfully!'
            ]);
    
           
            
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'flash' => 'error',
                'message' => 'Error updating account try again later!'
            ]);
            
                       
        }
       
    }
    public function UpdatePassword(Request $request)
    {
        $request->validate([
            'current_password'      => ['required', 'string', 'min:8'],
            'password'              => ['required', 'string', 'min:8'],
            'password_confirmation' => ['required', 'string', 'same:password'],
        ]);
    
       
        $employee = Auth::guard('employee')->user();
    
        try {
            
            if (!Hash::check($request->input('current_password'), $employee->password)) {
               
                return redirect()->back()->with([
                    'flash' => 'error',
                    'message' => 'The current password is incorrect.'
                ]);
            }
    
            
            $employee->password = Hash::make($request->input('password'));
            $employee->save();
    
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'flash' => 'error',
                'message' => 'Error Change Password try again later!'
            ]);
        }
    
       
        return redirect()->back()->with([
            'flash' => 'success',
            'message' => 'Password changed successfully.'
        ]);
       


    }
    public function destroy($id)
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
