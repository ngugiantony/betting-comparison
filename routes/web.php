<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\OTPVerificationController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuardianController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\SubscriptionController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/otp/enter', [OTPVerificationController::class, 'enterOTP'])->name('otp.enter');
Route::post('/otp/validate', [OTPVerificationController::class, 'validateOTP'])->name('otp.validate');

Route::prefix('/admin')->middleware(['isAdmin'])->group(function(){
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/teachers', [AdminController::class, 'get_teachers'])->name('get_teachers');
    Route::post('/teachers', [AdminController::class, 'store_teachers'])->name('store_teachers');
    Route::get('/getTeachers', [AdminController::class, 'display_Teachers'])->name('teachers.list');
    Route::get('/teacher-profile', [AdminController::class, 'teacher_profile'])->name('teacher_profile');

    Route::get('/customers', [AdminController::class, 'get_customers'])->name('get_customers');
    Route::get('/view_students', [AdminController::class, 'get_students'])->name('view_students');
    Route::put('/edit_account_status/{id}', [AdminController::class, 'update_student_account'])->name('update_student_account_status');
    Route::delete('/delete-students/{id}', [AdminController::class, 'destroy_student_account'])->name('destroy_student_account');

    Route::get('/transactions', [AdminController::class, 'get_transactions'])->name('get_transactions');


    Route::get('/sms', [AdminController::class, 'get_sms'])->name('get_sms');



    Route::get('/view-parent/{id}', [AdminController::class,'parent_details'])->name('view_parent_details');
});

Route::prefix('parent')->middleware(['isParent'])->group(function(){
    Route::get('/', [GuardianController::class, 'index'])->name('parent.dashboard');
    Route::get('/create_students', [GuardianController::class, 'createStudent'])->name('get_students');
    Route::post('/students', [GuardianController::class, 'store'])->name('store_student');
    ///
    Route::post('/stk-push', [GuardianController::class, 'activateStudent'])->name('stk_push');
    ///
    ///
    Route::post('/edit-students/{id}', [GuardianController::class, 'update'])->name('update_student');
    Route::delete('/delete-students/{id}', [GuardianController::class, 'destroy'])->name('delete_student');

    Route::get('/view-students/{id}', [GuardianController::class,'student_details'])->name('view_student_details');
    Route::get('/profile', [GuardianController::class, 'parent_profile'])->name('parent_profile');

    Route::resource('matches', MatchController::class)->only(['index', 'show']); 
    Route::get('/orbitech', [MatchController::class, 'orbitech'])->name('orbitech');
    Route::get('pricing', [PricingController::class, 'index'])->name('pricing.index');
     Route::post('subscribe/{plan}', [PricingController::class, 'subscribe'])->name('subscribe');

    // Stripe
    Route::post('payment/stripe/{plan}', [SubscriptionController::class, 'stripeCheckout'])->name('stripe.checkout');
    Route::get('payment/stripe/success/{plan}', [SubscriptionController::class, 'stripeSuccess'])->name('stripe.success');

    // PayPal
    Route::post('payment/paypal/{plan}', [SubscriptionController::class, 'paypalCheckout'])->name('paypal.checkout');
    Route::get('payment/paypal/return/{plan}', [SubscriptionController::class, 'paypalReturn'])->name('paypal.return');
    Route::get('payment/paypal/cancel', [SubscriptionController::class, 'paypalCancel'])->name('paypal.cancel');

    // Subscriptions
    Route::post('subscription/{subscription}/cancel', [SubscriptionController::class, 'cancel'])->name('subscription.cancel');


});
