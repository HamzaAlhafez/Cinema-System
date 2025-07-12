<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promocode;
use App\Models\Purchasepromocode;
use App\Models\Promocodeusage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PromoCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $promocodes=Promocode::all();
        return view('dashboard.promocodes.index',compact('promocodes'));
    }
    public function ShowPromoCodes()
    {
        $AvailablePromoCodes = PromoCode::where('is_active', true)
        ->whereDate('expiry_date', '>=', now())
        ->whereColumn('used_count', '<', 'max_usage')
        ->orderBy('expiry_date')
        ->get();

    return view('user.ExploreCoupons', compact('AvailablePromoCodes'));
        

    }
    public function redeem(Request $request)
    {
        DB::beginTransaction();

        try {
            $Purchasepromocode = new Purchasepromocode();
            $Purchasepromocode->user_id=Auth::id();
            $Purchasepromocode->promocode_id=$request->promo_id;
            $Purchasepromocode->purchased_at=now();
            $Purchasepromocode->save();
            $user=Auth::user();
    $user->loyalty_points=$user->loyalty_points-$request->points_required;
    $user->save();
    DB::commit();






           
           
    
        } catch (\Exception $e) {
        
            DB::rollBack();
            return redirect()
            ->back()
            ->with([
                'flash' => 'error',
                'message' => 'Sorry! Purchase failed.'
            ]);
           
            
           
        }
        return redirect()->route('promocodes.Show.Mypromocodes')->with([
            'flash' => 'success',
            'message' => "🎉 Coupon purchased successfully! Thank you for using your loyalty points."
        ]);
       

    }
    public function ShowMypromocodes()
    {
        $userId = Auth::id(); 
    
        $purchasedPromocodes = Purchasepromocode::query()
            ->where('user_id', $userId)
            ->with('promocode')
            ->get();
        
        return view('user.MycouponPurchased', compact('purchasedPromocodes'));
        
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
   
private function VaildRequest(Request $request,$id=null)
    {
           $request->validate([
            'code' => ['required',Rule::unique('promocodes')->ignore($id),'max:20'],
            'type' => ['required',Rule::in(['points', 'discount'])],
            'description' => ['required','min:1'],
            'value' => ['required','integer','min:1'],
            'expiry_date' => ['required','date','after:today'],
            'max_usage' => ['required','integer','min:1'],
            
           




        ]);


    }
  

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->VaildRequest($request);
       // points_required
       //max_usage_per_user
        try {
            $Promocode = new Promocode();
            $Promocode->code=strip_tags($request->input('code'));
            $Promocode->type=strip_tags($request->input('type'));
            $Promocode->description=strip_tags($request->input('description'));
            $Promocode->value=strip_tags($request->input('value'));
            $Promocode->expiry_date=strip_tags($request->input('expiry_date'));
            $Promocode->max_usage=strip_tags($request->input('max_usage'));
            $Promocode->max_usage_per_user=strip_tags($request->input('max_usage_per_user'));
            $Promocode->points_required=strip_tags($request->input('points_required'));
            $Promocode->admin_id=Auth::guard('admin')->user()->id;

            $Promocode->save();
            
           

       
    
} catch (\Exception $e) {
    return redirect()->back()->withErrors(['error' => $e->getMessage()]);

}
session()->flash('add');
return redirect()->route('promocodes.index');






   }

       
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $this->VaildRequest($request,$id);
        try {
            $Promocode = Promocode::findorfail($id);
            $Promocode->code=strip_tags($request->input('code'));
            $Promocode->type=strip_tags($request->input('type'));
            $Promocode->description=strip_tags($request->input('description'));
            $Promocode->value=strip_tags($request->input('value'));
            $Promocode->expiry_date=strip_tags($request->input('expiry_date'));
            $Promocode->max_usage=strip_tags($request->input('max_usage'));
            $Promocode->max_usage_per_user=strip_tags($request->input('max_usage_per_user'));
            $Promocode->points_required=strip_tags($request->input('points_required'));
            $Promocode->save();
            
           

       
    
} catch (\Exception $e) {
    return redirect()->back()->withErrors(['error' => $e->getMessage()]);

}
session()->flash('edit');
return redirect()->route('promocodes.index');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $to_delete = Promocode::findOrFail($id);
            
          
            $purchaseCount = Purchasepromocode::where('promocode_id', $to_delete->id)->count();
            $usageCount = Promocodeusage::where('promocode_id', $to_delete->id)->count();
            
            if ($purchaseCount > 0 || $usageCount > 0) {
                session()->flash('promocodehasAssociated');
                return redirect()->route('promocodes.index');
            }
            
            $to_delete->delete();
            session()->flash('delete');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    
        return redirect()->route('promocodes.index');
       
}
}

