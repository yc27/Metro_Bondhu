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

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');
Route::post('/store/message', 'HomeController@storeMessage')->name('store.message');

Auth::routes(['verify' => true]);
Route::get('/register/request', 'Auth\RegisterController@requestInvitation')->name('requestInvitation');
Route::post('/invitations', 'Auth\RegisterController@storeRequest')->name('storeInvitationRequest');

Route::get('/dashboard', 'AdminController@index')->name('dashboard');

// Inbox Control
Route::group(['prefix' => '/message'], function () {
    Route::get('/view/{id}', [
        'uses' => 'AdminController@viewMessage',
        'as'   => 'message.view',
    ]);

    Route::put('/mark/{id}', [
        'uses' => 'AdminController@markMessage',
        'as'   => 'message.mark',
    ]);

    Route::delete('/delete/{id}',     [
        'uses' => 'AdminController@destroyMessage',
        'as'   => 'message.destroy',
    ]);
});

// Transport Control
Route::group(['prefix' => '/transport'], function () {
    // Schedules
    Route::get('/show/schedules', [
        'uses' => 'TransportController@showSchedules',
        'as'   => 'transport.show.schedules',
    ]);

    Route::get('/get/schedule/{id}', [
        'uses' => 'TransportController@getSchedule',
        'as'   => 'transport.get.schedule',
    ]);

    Route::get('/get/stoppages/{id}', [
        'uses' => 'TransportController@getStoppages',
        'as'   => 'transport.get.stoppages',
    ]);

    Route::put('/store/schedule', [
        'uses' => 'TransportController@storeSchedule',
        'as'   => 'transport.store.schedule',
    ]);

    Route::delete('/delete/schedule/{id}', [
        'uses' => 'TransportController@destroySchedule',
        'as'   => 'transport.destroy.schedule',
    ]);

    // Routes
    Route::get('/show/routes', [
        'uses' => 'TransportController@showRoutes',
        'as'   => 'transport.show.routes',
    ]);
});

// Invitation Request Control
Route::group(['prefix' => '/request'], function () {
    Route::get('/show', [
        'uses' => 'InvitationController@show',
        'as'   => 'request.show',
    ]);

    Route::put('/send-invitation/{id}',     [
        'uses' => 'InvitationController@sendInvitation',
        'as'   => 'request.sendInvitation',
    ]);

    Route::delete('/delete/{id}', [
        'uses' => 'InvitationController@destroy',
        'as'   => 'request.destroy',
    ]);
});