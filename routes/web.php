<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\JobController;

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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/jobs', [JobController::class, 'index'])->name('jobs');
Route::get('/job/details/{id}', [JobController::class, 'details'])->name('jobDetails');
Route::post('/apply-job', [JobController::class, 'applyJob'])->name('applyJob');
Route::post('/save-job', [JobController::class, 'savejob'])->name('savejob');
Route::prefix('account')->group(function () {
    // Guest Router
    Route::group(['middleware' => 'guest'], function () {
        Route::get('/register', [AccountController::class, 'registration'])->name('account.registartion');
        Route::post('/process-register', [AccountController::class, 'processRegistration'])->name('account.processRegistration');
        Route::get('/login', [AccountController::class, 'login'])->name('account.login');
        Route::post('/authenticate', [AccountController::class, 'authenticate'])->name('account.authenticate');
    });
    // Authenticateded Router
    Route::group(['middleware' => 'auth'], function () {
        Route::put('/update-profile', [AccountController::class, 'updateProfile'])->name('account.updateProfile');
        Route::post('/check-password', [AccountController::class, 'checkPassword'])->name('account.checkPassword');
        Route::post('/update-password', [AccountController::class, 'updatePassword'])->name('account.updatePassword');
        Route::get('/profile', [AccountController::class, 'profile'])->name('account.profile');
        Route::get('/logout', [AccountController::class, 'logout'])->name('account.logout');
        Route::post('/update-profile-pic', [AccountController::class, 'updateProfilepic'])->name('account.updateProfilepic');
        Route::get('/create-job', [AccountController::class, 'createJob'])->name('account.create-Job');
        Route::post('/save-job', [AccountController::class, 'saveJob'])->name('account.saveJob');
        Route::get('/my-jobs', [AccountController::class, 'myJobs'])->name('account.myjobs');
        Route::get('/my-jobs/edit/{jobId}', [AccountController::class, 'editJob'])->name('account.editJob');
        Route::put('/update-job/{jobId}', [AccountController::class, 'updateJob'])->name('account.updateJob');
        Route::post('/delete-job', [AccountController::class, 'deleteJob'])->name('account.deletetJob');
        Route::get('/my-job-applications', [AccountController::class, 'myJobApplications'])->name('account.my-job-applications');
        Route::post('/delete-application-job', [AccountController::class, 'deleteAppliedjob'])->name('account.deletetAppliedjob');
        Route::get('/savejob', [AccountController::class, 'savejobList'])->name('account.savejob');
        Route::post('/delete-saveJob', [AccountController::class, 'deleteSaveJob'])->name('account.deletetSaveJob');
    });
});
