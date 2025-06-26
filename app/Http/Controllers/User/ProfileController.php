<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class ProfileController extends Controller
{
    //redriect edit page
    public function editProfile()
    {
        return view('user.editProfile');
    }

    //update profile
    public function updateProfile(Request $request)
    {
        // dd($request->toArray());

        $this->checkValidationProfile($request);

        $data = $this->getProfileData($request);

        if ($request->hasFile('image')) {
            if (Auth::user()->profile != null) {
                //old upload user
                if (file_Exists(public_path('profile/') . Auth::user()->profile)) {
                    unlink(public_path('profile/') . Auth::user()->profile);
                }
            }
            $fileName = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('profile/'), $fileName);
            $data['profile'] = $fileName;
        } else {
            $data['profile'] = Auth::user()->profile;
        }

        User::where('id', Auth::user()->id)->update($data);

        Alert::success('Success Title', 'ကိုယ်ရေးအကျဉ်းကို အောင်မြင်စွာ ပြင်ဆင်ပြီးပါပြီ။');

        return redirect()->route('user#Home');
    }

    //redirect change password page
    public function passwordChangePage()
    {
        return view('user.changePassword');
    }

    //update password
    public function passwordChange(Request $request)
    {

        $this->checkPasswordValidation($request);

         //login password vs typing password check
        $userRegisteredPassword = $request->user()->password; //user registered password

        if (Hash::check($request->oldPassword, $userRegisteredPassword)) {
            $userRegisteredPassword = Auth::user()->password;

            User::where('id', Auth::user()->id)->update([
                'password' => Hash::make($request->newPassword), //update the password
            ]);
            Alert::success('Success', 'စကားဝှက်ပြောင်းလဲပြီးပါပြီ။');
            return redirect('user/home');
        } else {
            Alert::error('Fail', 'စကားဝှက်အဟောင်း မမှန်ပါ။');
            return back();
        }

    }

    //get profile data
    private function getProfileData($request)
    {
        return [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'nickname' => $request->nickname,
            'address' => $request->address,
            'profile' => $request->image,
            'gender' => $request->gender
        ];
    }

    //check validation
    private function checkValidationProfile($request)
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

    //password check validation
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
    }
}
