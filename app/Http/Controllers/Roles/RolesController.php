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
                $addRoleDetails = $addRole->saveRoles($request);
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


    // Get all the Role list
    public function getRole(Request $request)
    {
        $RoleService = new RolesService();
        $data = $RoleService->getAllRole();
        // $common=new CommonService();
        // $checkEdit = $common->allowDisplay('App\Http\Controllers\Roles\RolesController','edit');
        return DataTables::of($data)
                    ->editColumn('action', function ($data) {
                        $button ='';
                        $button = '<a href="/roles/edit/' . base64_encode($data->role_id) . '" name="edit" id="' . $data->role_id . '" class="btn btn-dark btn-sm" title="Edit"><i class="mdi mdi-border-color"></i></a/>';
                        // if($checkEdit){
                            // if($data->role_status=='active'){
                            //     $role_status="inactive";
                            //     $button = '<a href="/roles/edit/' . base64_encode($data->role_id) . '" name="edit" id="' . $data->role_id . '" class="btn btn-dark btn-sm" title="Edit"><i class="mdi mdi-border-color"></i></a/>
                            //     <button type="button" onclick="statusUpdate('.$data->role_id.',\''.$role_status.'\');return false;" class="btn btn-outline-primary-disabled btn-sm"/>Inactive</button>';
                            // }else{
                            //     $role_status="active";
                            //     $button = '<a href="/roles/edit/' . base64_encode($data->role_id) . '" name="edit" id="' . $data->role_id . '" class="btn btn-outline-primary btn-sm" title="Edit"><i class="ft-edit"></i></a/>
                            //     <button type="button" onclick="statusUpdate('.$data->role_id.',\''.$role_status.'\');return false;" class="btn btn-outline-primary-enabled btn-sm"/>Active</button>';
                            // }
                        // }
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
    }


}
