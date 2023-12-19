<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
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
    'email' => 'required|email',
    'password' => 'required|min:5|same:confirm_password',
    'confirm_password' => 'required',

]);
if ($validator->passes()) {
    // Code for when validation passes...
} else {
    return response()->json([
        'status' => false,
        'error' => $validator->errors()
    ]);
}
    }
    // This method will show user registeraton page
    public function login(){

    }

}
