<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::group([
    'namespace' => 'App\Http\Controllers\Auth',
],function (){

    Route::group([
        'prefix' => 'password',
        'as'=>'password.',
        'middleware' => "UserAuthRedirect"
    ],function (){

        Route::get('reset', 'ForgotPasswordController@showLinkRequestForm')->name('request');
        Route::post('email', 'ForgotPasswordController@sendResetLinkEmail')->name('email');
        Route::get('reset/{token}', 'ResetPasswordController@showResetForm')->name('reset');
        Route::post('reset', 'ResetPasswordController@reset')->name('update');

    });

    Route::group([
        'middleware' => 'UserAuthCheck',
    ],function (){

        Route::get('verify-email', 'EmailVerificationPromptController')
            ->name('verification.notice');

        Route::get('verify-email/{id}/{hash}', 'VerifyEmailController')
            ->middleware(['signed', 'throttle:6,1'])
            ->name('verification.verify');

        Route::post('email/verification-notification', 'EmailVerificationNotificationController@store')
            ->middleware('throttle:6,1')
            ->name('verification.send');

        Route::get('confirm-password', 'ConfirmablePasswordController@show')
            ->name('password.confirm');

        Route::post('confirm-password', 'ConfirmablePasswordController@store');

        Route::put('password', 'PasswordController@update')->name('password.update');

        Route::post('logout', 'LoginController@logout')->name('logout');
    });

});

Route::group([
    'namespace' =>'App\Livewire\Frontend\Auth',
    'middleware' => 'UserAuthRedirect'
],function (){

    Route::get('login','LoginPage')->name('login');
    Route::get('register','RegisterPage')->name('register');

});


Route::group([
    'middleware' => 'UserAuthCheck',
    'as'=>'frontend::',
],function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});


Route::group([
    'namespace' => 'App\Livewire\Frontend',
    'as'=>'frontend::',
],function (){

    Route::group([
        'namespace' => 'User',
        'middleware' => 'UserAuthCheck',
    ],function (){

        Route::get('dashboard','DashboardPage')->name('dashboard');

    });

    Route::group([
        'namespace' => 'Pages',
    ],function (){

        Route::get('/','HomePage')->name('home');
        Route::get('about','AboutUsPage')->name('about');
        Route::get('contact','ContactUsPage')->name('contact');

    });

});

Route::group([
    'namespace' =>'App\Livewire\Frontend\Auth',
    'middleware' => 'UserAuthRedirect'
],function (){

    Route::get('login','LoginPage')->name('login');
    Route::get('register','RegisterPage')->name('register');

});

//Route::get('test','App\Http\Controllers\TestController@Index');
//Route::post('test','App\Http\Controllers\TestController@Submit');
