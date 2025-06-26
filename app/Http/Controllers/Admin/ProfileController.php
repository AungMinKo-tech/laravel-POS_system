<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Hash;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use function PHPUnit\Framework\fileExists;

class ProfileController extends Controller
{
    //change password page
    public function changePasswordPage()
    {
        return view('admin.profile.changePassword');
    }

    //change password
    public function changePassword(Request $request)
    {
        $this->checkPasswordValidation($request);
        //login password vs typing password check
        $userRegisteredPassword = $request->user()->password; //user registered password

        if (Hash::check($request->oldPassword, $userRegisteredPassword)) {
            $userRegisteredPassword = Auth::user()->password; //get the currently logged-in user's password

            User::where('id', Auth::user()->id)->update([
                'password' => Hash::make($request->newPassword), //update the password
            ]);
            Alert::success('Success', 'စကားဝှက်ပြောင်းလဲပြီးပါပြီ။');
            return redirect('admin/dashboard');
            // Auth::logout(); //logout after password change
            // $request->session()->invalidate(); //invalidate the session
            // $request->session()->regenerateToken(); //regenerate the CSRF token
            // return redirect('/');
        } else {
            Alert::error('Fail', 'စကားဝှက်အဟောင်း မမှန်ပါ။');
            return back();
        }
    }

    //edit profile page
    public function editProfile(){
        return view('admin.profile.edit');
    }

    //update profile
    public function updateProfile(Request $request){

        $this->checkProfileValidation($request);

        $data = $this->getProfileData($request);

        if($request->hasFile('image')){
            if(Auth::user()->profile != null){
                //old upload user
                if(file_exists(public_path('profile/') . Auth::user()->profile)){
                    unlink(public_path('profile/') . Auth::user()->profile);
                }
            }
            $fileName = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('profile/') , $fileName);
            $data['profile'] = $fileName;
        }else{
            $data['profile'] = Auth::user()->profile;
        }

        User::where('id',Auth::user()->id)->update($data);

        Alert::success('Success Title', 'ကိုယ်ရေးအကျဉ်းကို အောင်မြင်စွာ ပြင်ဆင်ပြီးပါပြီ။');

        return redirect('admin/dashboard');
    }

    //password validation
    private function checkPasswordValidation($request)
    {
        $request->validate([
            'oldPassword' => 'required',
            'newPassword' => 'required|min:6|max:12',
            'confirmPassword' => 'required|min:6|max:12|same:newPassword',
        ], [
            'oldPassword.required' => 'စကားဝှက်ဟောင်း လိုအပ်ပါသည်။',
            'newPassword.required' => 'စကားဝှက်အသစ် လိုအပ်သည်။',
            'newPassword.min' => 'စကားဝှက်အသစ်သည် အနည်းဆုံး အက္ခရာ 6 လုံးရှိရမည်။',
            'newPassword.max' => 'စကားဝှက်အသစ်သည် အက္ခရာ 12 လုံးထက် မပိုရပါ။',
            'confirmPassword.required' => 'စကားဝှက်ကို အတည်ပြုရန် လိုအပ်ပါသည်။',
            'confirmPassword.min' => 'စကားဝှက်ကို အတည်ပြုရန် အနည်းဆုံး အက္ခရာ 6 လုံးရှိရမည်။',
            'confirmPassword.max' => 'စကားဝှက်ကို အတည်ပြုရန် အက္ခရာ 12 လုံးထက် မပိုရပါ။',
            'confirmPassword.same' => 'စကားဝှက်ကို အတည်ပြုရန် စကားဝှက်အသစ်နှင့် ကိုက်ညီရမည်။',
        ]);

        return redirect()->back()->with('success', 'Password changed successfully!');
    }

    //get profile data
    private function getProfileData($request){
        return [
            'name' => $request -> name,
            'email' => $request -> email,
            'phone' => $request -> phone,
            'nickname' => $request -> nickname,
            'address' => $request -> address,
            'profile' => $request -> image,
            'gender' => $request -> gender
        ];
    }

        //check profile validate
    private function checkProfileValidation($request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,' . Auth::user()->id,
            'phone' => 'required',
            'nickname' => '',
            'image' => 'mimes:jpg,png,jpeg,svg,webp,gif,heic',
            'gender' => '',
            'address' => 'max:200'
        ], [
            'name.required' => 'အမည် လိုအပ်ပါသည်။',
            'email.required' => 'email လိုအပ်ပါသည်။',
            'email.unique' => 'အခြား email နှင့်တူညီနေပါသည်။',
            'phone.required' => 'ဖုန်းနံပတ် လိုအပ်ပါသည်။',
            'address.max' => 'လိပ်စာသည် အက္ခရာ 200 လုံးထက် မပိုရပါ။'
        ]);
    }
}
