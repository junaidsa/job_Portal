<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AccountController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
//if user Logged in == No And it access Login Profile Page then profile page it wiil redirect to login page user  page.
// });
Route::get('/',[HomeController::class,'index'])->name('home');
Route::prefix('account')->group(function () {
    // Guest Router
Route::group(['middleware' => 'guest'], function () {
    Route::get('/register',[AccountController::class,'registration'])->name('account.registartion');
    Route::post('/process-register',[AccountController::class,'processRegistration'])->name('account.processRegistration');
    Route::get('/login',[AccountController::class,'login'])->name('account.login');
    Route::post('/authenticate',[AccountController::class,'authenticate'])->name('account.authenticate');
});
// Authenticateded Router
Route::group(['middleware' => 'auth'], function () {
    Route::put('/update-profile',[AccountController::class,'updateProfile'])->name('account.updateProfile');
    Route::get('/profile',[AccountController::class,'profile'])->name('account.profile');
    Route::get('/logout', [AccountController::class, 'logout'])->name('account.logout');
    Route::post('/update-profile-pic', [AccountController::class, 'updateProfilepic'])->name('account.updateProfilepic');
    Route::get('/create-job', [AccountController::class, 'createJob'])->name('account.create-Job');
});
});

