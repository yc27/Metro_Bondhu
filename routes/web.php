<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);
Route::get('/register/request', 'Auth\RegisterController@requestInvitation')->name('requestInvitation');
Route::post('invitations', 'Auth\RegisterController@storeRequest')->name('storeInvitationRequest');

Route::get('/dashboard', 'AdminController@index')->name('dashboard');

//Invitation Request Control
Route::group(['prefix' => '/requests'], function () {
    Route::get('/show', [
        'uses' => 'InvitationController@show',
        'as'   => 'requests.show',
    ]);

    Route::put('/generate/token/{id}',     [
        'uses' => 'InvitationController@generateToken',
        'as'   => 'requests.generateToken',
    ]);

    Route::delete('/delete/{id}', [
        'uses' => 'InvitationController@destroy',
        'as'   => 'requests.destroy',
    ]);
});


Route::get('/home', 'HomeController@index')->name('home');