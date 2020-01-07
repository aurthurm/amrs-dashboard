<?php

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
    return view('layouts.master');
});

Route::get('/login', function () {
    return view('admin.login');
});

Route::post('/login_submit', 'Admin\AdminController@loginSubmit');
Route::post('/logout', 'Admin\AdminController@logout');

//Reset Password
Route::get('/resetPassword', 'Admin\AdminController@resetpassword')->name('admin.resetpassword');
Route::post('/changePassword', 'Admin\AdminController@changePassword');

//common function
Route::post('/checkValidation', 'Common\CommonController@checkValidation');
Route::post('/duplicateValidation', 'Common\CommonController@duplicateValidation');

// Route::get('/user', function () {
//     return view('user.index');
// });

//User Module

Route::get('/user', 'Users\UsersController@index')->name('users.index');
Route::get('/deny', 'Users\UsersController@deny')->name('users.deny');
Route::post('/getuser', 'Users\UsersController@getUser')->name('users.get');
// Route::resource('/user','User\UserController');
Route::get('/adduser', 'Users\UsersController@adduser');
Route::get('/userfacilitymap', 'Users\UsersController@userfacilitymap');
Route::get('/edituser/{id}', 'Users\UsersController@edituser');
Route::post('/getuserfacilitymapById', 'Users\UsersController@getuserfacilitymapById');

Route::post('/adduserStore', 'Users\UsersController@adduserStore');
Route::post('/userfacilitymapStore', 'Users\UsersController@userfacilitymapStore');
Route::post('/edituserUpdate', 'Users\UsersController@edituserUpdate');

//Facility Module

Route::get('/facilities', 'Facilities\FacilitiesController@index')->name('facilities.index');
Route::post('/getfacility', 'Facilities\FacilitiesController@getFacility')->name('facilities.get');
Route::get('/addfacility', 'Facilities\FacilitiesController@addfacility');
Route::post('/addfacilityStore', 'Facilities\FacilitiesController@addfacilityStore');
Route::get('/editfacility/{id}', 'Facilities\FacilitiesController@editfacility');
Route::post('/editfacilityUpdate', 'Facilities\FacilitiesController@editfacilityUpdate');
Route::post('/getDistrict', 'Facilities\FacilitiesController@getDistrict');

//AMR data
Route::get('/amrdata', 'Amrdata\AmrdataController@index')->name('amrdata.index');
Route::post('/getamrdata', 'Amrdata\AmrdataController@getamrdata')->name('amrdata.get');
Route::post('/getFilterData', 'Amrdata\AmrdataController@getFilterData');
Route::get('/editamrdata/{id}', 'Amrdata\AmrdataController@editamrdata');
Route::post('/amrdataUpdate', 'Amrdata\AmrdataController@amrdataUpdate');

// Route::get("/adduser", function()
// {
//    return View::make("adduser");
// });

