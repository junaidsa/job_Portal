<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
    $user = new User();
    $user->name = $request->name;
    $user->email = $request->email;
    $user->password = Hash::make($request->password);
    $user->save();
    session()->flash('success','You have Register Successfully.');
} else{
    return response()->json([
        'status' => false,
        'errors' => $validator->errors()
    ]);
}
    }
    // This method will show user registeraton page
    public function login(){
        return view('front.account.login');

    }

}
