<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\RolesService;
use Yajra\DataTables\Facades\DataTables;
use Redirect;
use Session;
use Illuminate\Support\Facades\File;


class RolesController extends Controller
{
    //

    public function index()
    {
        if(session('login')==true){
            return view('roles.index');
        }
        else{
            return Redirect::to('login')->with('status', 'Authentication Failed!');
        }
    }

    public function addrole(Request $request)
    {
        if(session('login')==true){
            if ($request->isMethod('post')) 
            {
                $addRole = new RolesService();
                $addRoleDetails = $addRole->saveRole($request);
                return Redirect::route('roles.index')->with('status', $addRoleDetails);
            }
            else{
                $RoleService = new RolesService();
                $resourceResult = $RoleService->getAllResource();
                // dd($resourceResult);
                return view('roles.addrole',array('resourceResult'=>$resourceResult));
            }
        }
        else{
            return Redirect::to('login')->with('status', 'Authentication Failed!');
        }
    }
}
