<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin\Login;
use Auth;
use Redirect;
use Session;

class AdminController extends Controller
{
    //
    public function index()
    {
        return view('admin.login');
    }

    public function loginSubmit(Request $request)
    {
        $loginmodel = new Login();
        $result = $loginmodel->validateLogin($request);
        if(count($result)>0){
            return Redirect::to('user');
        }
        else{
            return Redirect::to('login')->with('status', 'Authentication Failed!');
        }
    }

    public function resetpassword(){
        return view('admin.resetpassword');
    }
    
    public function changePassword(Request $request){
        $loginmodel = new Login();
        $result = $loginmodel->updatePassword($request);
        return Redirect::to('login');
    }

    public function logout(Request $request){
        Auth::logout(); // log the user out of our application
        Session::flush();
        return Redirect::to('login'); // redirect the user to the login screen
    }
}
