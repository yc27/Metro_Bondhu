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
Route::get('/inbox', 'AdminController@index')->name('dashboard.inbox');

// Inbox Control
Route::group(['prefix' => '/message'], function () {
    Route::get('/view/{id}', [
        'uses' => 'InboxController@viewMessage',
        'as'   => 'message.view',
    ]);

    Route::put('/mark/{id}', [
        'uses' => 'InboxController@markMessage',
        'as'   => 'message.mark',
    ]);

    Route::delete('/delete/{id}', [
        'uses' => 'InboxController@destroyMessage',
        'as'   => 'message.destroy',
    ]);

    Route::delete('/delete-all', [
        'uses' => 'InboxController@destroyAllMessage',
        'as'   => 'message.destroy.all',
    ]);

    Route::post('/search', [
        'uses' => 'InboxController@searchMessage',
        'as'   => 'message.search',
    ]);

    Route::post('/search/reset', [
        'uses' => 'InboxController@resetSearchMessage',
        'as'   => 'message.search.reset',
    ]);
});

// Profile Control
Route::group(['prefix' => '/profile'], function () {
    Route::post('/update/photo', [
        'uses' => 'ProfileController@updatePhoto',
        'as'   => 'profile.update.photo',
    ]);

    Route::post('/update', [
        'uses' => 'ProfileController@updateProfile',
        'as'   => 'profile.update',
    ]);
});

// Notice Control
Route::group(['prefix' => '/notice'], function () {
    Route::get('/show/{id}', [
        'uses' => 'NoticeController@showNotice',
        'as'   => 'notice.show',
    ]);

    Route::post('/store', [
        'uses' => 'NoticeController@storeNotice',
        'as'   => 'notice.store',
    ]);

    Route::delete('/delete/{id}', [
        'uses' => 'NoticeController@destroyNotice',
        'as'   => 'notice.destroy',
    ]);
});

// Routines Control
Route::group(['prefix' => '/routine'], function () {
    // Department
    Route::get('/get/departments', [
        'uses' => 'CommonController@getDepartments',
        'as'   => 'routine.get.departments',
    ]);
    
    Route::post('/store/department', [
        'uses' => 'RoutineController@storeDepartment',
        'as'   => 'routine.store.department',
    ]);

    Route::delete('/delete/department/{id}', [
        'uses' => 'RoutineController@destroyDepartment',
        'as'   => 'routine.destroy.department',
    ]);
    
    // Batch
    Route::get('/get/batches-id/{dept_id}', [
        'uses' => 'RoutineController@getBatchesId',
        'as'   => 'routine.get.batches-id',
    ]);
    
    Route::get('/get/batches/{dept_id}', [
        'uses' => 'CommonController@getBatches',
        'as'   => 'routine.get.batches',
    ]);
    
    Route::post('/store/batch', [
        'uses' => 'RoutineController@storeBatch',
        'as'   => 'routine.store.batch',
    ]);

    Route::delete('/delete/batch/{id}', [
        'uses' => 'RoutineController@destroyBatch',
        'as'   => 'routine.destroy.batch',
    ]);
    
    // Section
    Route::get('/get/sections-id/{batch_id}', [
        'uses' => 'RoutineController@getSectionsId',
        'as'   => 'routine.get.sections-id',
    ]);
    
    Route::get('/get/sections/{batch_id}', [
        'uses' => 'CommonController@getSections',
        'as'   => 'routine.get.sections',
    ]);
    
    Route::post('/store/section', [
        'uses' => 'RoutineController@storeSection',
        'as'   => 'routine.store.section',
    ]);

    Route::delete('/delete/section/{id}', [
        'uses' => 'RoutineController@destroySection',
        'as'   => 'routine.destroy.section',
    ]);

    // Teacher
    Route::get('get/teachers',[
        'uses' => 'RoutineController@getTeachers',
        'as'   => 'routine.get.teachers'
    ]);
    
    Route::post('/store/teacher', [
        'uses' => 'RoutineController@storeTeacher',
        'as'   => 'routine.store.teacher',
    ]);

    Route::delete('/delete/teacher/{id}', [
        'uses' => 'RoutineController@destroyTeacher',
        'as'   => 'routine.destroy.teacher',
    ]);

    // Subject
    Route::get('get/subjects',[
        'uses' => 'RoutineController@getSubjects',
        'as'   => 'routine.get.subjects'
    ]);
    
    Route::post('/store/subject', [
        'uses' => 'RoutineController@storeSubject',
        'as'   => 'routine.store.subject',
    ]);

    Route::delete('/delete/subject/{id}', [
        'uses' => 'RoutineController@destroySubject',
        'as'   => 'routine.destroy.subject',
    ]);

    // Period
    Route::post('/store/period', [
        'uses' => 'RoutineController@storePeriod',
        'as'   => 'routine.store.period',
    ]);

    Route::delete('/delete/period/{id}', [
        'uses' => 'RoutineController@destroyPeriod',
        'as'   => 'routine.destroy.period',
    ]);

    // Class Days
    Route::post('/store/class-days', [
        'uses' => 'RoutineController@storeClassDays',
        'as'   => 'routine.store.class-days',
    ]);

    // Session
    Route::get('/get/sessions', [
        'uses' => 'CommonController@getSessions',
        'as'   => 'routine.get.sessions',
    ]);
    
    Route::post('/store/session', [
        'uses' => 'RoutineController@storeSession',
        'as'   => 'routine.store.session',
    ]);

    Route::delete('/delete/session/{id}', [
        'uses' => 'RoutineController@destroySession',
        'as'   => 'routine.destroy.session',
    ]);

    // Routine
    Route::get('/search', [
        'uses' => 'CommonController@searchRoutine',
        'as'   => 'routine.search'
    ]);

    Route::post('/store', [
        'uses' => 'RoutineController@storeRoutine',
        'as'   => 'routine.store'
    ]);

    Route::delete('/delete/{id}', [
        'uses' => 'RoutineController@destroyRoutine',
        'as'   => 'routine.destroy'
    ]);

    Route::delete('/reset/{sessionId}/{departmentId}/{batchId}/{sectionId}', [
        'uses' => 'RoutineController@resetRoutine',
        'as'   => 'routine.reset'
    ]);

    Route::get('/download/pdf/{sessionId}/{departmentId}/{batchId}/{sectionId}', [
        'uses' => 'CommonController@downloadRoutinePDF',
        'as'   => 'routine.download.pdf'
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

    Route::put('/send-invitation/{id}', [
        'uses' => 'InvitationController@sendInvitation',
        'as'   => 'request.sendInvitation',
    ]);

    Route::delete('/delete/{id}', [
        'uses' => 'InvitationController@destroy',
        'as'   => 'request.destroy',
    ]);
});