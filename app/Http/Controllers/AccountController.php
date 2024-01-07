<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    // This method will show user registeraton page
    public function registration(){
        return view('front.account.registration');

    }

    public function processRegistration(Request  $request)
    {
$validator = validator::make($request->all(),[
    'name' => 'required',
    'email' => 'required|email:unique:users,email',
    'password' => 'required|min:5|same:confirm_password',
    'confirm_password' => 'required',

]);
if($validator->passes()){
    // dd('success');
    $user = new User();
    $user->name = $request->name;
    $user->email = $request->email;
    $user->password = Hash::make($request->password);
    $user->save();
     session()->flash('success','You have Register Successfully.');
    // dd('Registration successful');

} else{
    return response()->json([
        'status' => false,
        'errors' => $validator->errors()
    ]);
}
    }
    // This method will show user registeration page
    public function login(){
        return view('front.account.login');

    }
    public function authenticate(Request $request){
        $email = $request->email;
        $password = $request->password;
        $validator = Validator::make($request->all(),[
            'email' =>'required|email',
            'password' => 'required',
        ]);
        if($validator->fails()){
            return redirect()->route('account.login')->withErrors($validator)
            ->withInput($request->only('email'));
    }else{
if(Auth::attempt(['email' => $email, 'password' => $password])){

}else{
    return redirect()->route('account.login')->with('error','Invalid Credentials');
}
    }

}
    public function profile(){
        // return view('front.account.profile');
        echo "Profile created";
    }
}
