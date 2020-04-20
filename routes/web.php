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
if(session('login')==true){
	Route::get('/', function () {
	    return view('amrdata.index');
	});
}
else{
	Route::get('/', function () {
	    return Redirect::to('login')->with('status', 'Authentication Failed!');
	});
}
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
Route::post('/checkNameValidation', 'Common\CommonController@checkNameValidation');

// Route::get('/user', function () {
//     return view('user.index');
// });

//User Module

Route::get('/user', 'Users\UsersController@index')->name('users.index')->middleware('role-authorization');
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
Route::post('/amrAntibioticsShow', 'Amrdata\AmrdataController@amrAntibioticsShow');
Route::post('amrdata/export/', 'Amrdata\AmrdataController@export');
Route::get('amrdata/exportDownload/', 'Amrdata\AmrdataController@exportDownload');
// Route::get("/adduser", function()
// {
//    return View::make("adduser");
// });

//Role Module
Route::get('/roles', 'Roles\RolesController@index')->name('roles.index');
Route::post('/getRole', 'Roles\RolesController@getRole');
Route::get('/addrole', 'Roles\RolesController@addrole');
Route::post('/addrole', 'Roles\RolesController@addrole');
Route::get('/editrole/{id}', 'Roles\RolesController@editrole');
Route::post('/editrole/{id}', 'Roles\RolesController@editrole');

Route::get('/unauthorized', function()
{
    return view('error.not-authorized');
});