<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountController extends Controller
{
    // This method will show user registeraton page
    public function registration(){
        return view('front.account.registration');

    }
    // This method will show user registeraton page
    public function login(){

    }
    public function processRegistration(Request  $request)
    {
$validator = validator::make($request->all(),[
    'name' => 'required',
    'email' => 'required|email',
    'password' => 'required|min:5|same:confirm_password',
    'confirm_password' => 'required',

]);
if ($validator->passess()) {
    # code...
}else{
return respnse()->json([
    'status' => false,
    'error' => $validator->errors()

]);
}
    }
}
