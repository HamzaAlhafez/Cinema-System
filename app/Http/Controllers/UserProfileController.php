<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserProfileController extends Controller
{
    public function index()
    {

        $user=Auth::guard('user')->user();
         return view('user.profile',compact('user'));

    }



    public function edit()
{
    $user = auth()->user();
    return view('user.edit', compact('user'));
}

    // تحديث بيانات المستخدم
    public function update(Request $request)
    {


        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . auth()->id(),
            'phone' => 'nullable|string|max:15', // يمكنك تعديل القواعد حسب الحاجة
        ]);

        $user = auth()->user(); // احصل على المستخدم الحالي
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone; // تأكد من أن لديك حقل الهاتف في نموذج المستخدم
        $user->save(); // احفظ التغييرات

        return redirect()->route('user.profile')->with('success', 'تم تحديث البيانات بنجاح!');
    }





    public function ChangePassword(Request $request)
{
    // التحقق من صحة المدخلات
    $request->validate([
        'currentPassword' => ['required', 'string', 'min:8'],
        'newPassword' => ['required', 'string', 'min:8'],
        'confirmPassword' => ['required', 'string', 'same:newPassword'],
    ]);

    // جلب المستخدم الحالي
    $user = auth()->user(); // باستخدام auth()->user() للوصول للمستخدم الحالي

    try {
        // التحقق من كلمة المرور الحالية
        if (!Hash::check($request->input('currentPassword'), $user->password)) {
            // إذا كانت كلمة المرور غير صحيحة
            session()->flash('CurrentpasswordFaild', 'The current password is incorrect.');
            return redirect()->back();
        }

        // تحديث كلمة المرور الجديدة
        $user->password = Hash::make($request->input('newPassword'));
        $user->save();

        // إرسال رسالة نجاح
        session()->flash('Passwordchangedsuccessfully', 'Your password has been successfully updated.');
        return redirect()->back();

    } catch (\Exception $e) {
        // في حال حدوث خطأ غير متوقع
        return redirect()->back()->withErrors(['error' => $e->getMessage()]);
    }
}

}
