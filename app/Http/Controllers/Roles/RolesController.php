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
        // if(session('login')==true){
            return view('roles.index');
        // }
        // else{
        //     return Redirect::to('login')->with('status', 'Authentication Failed!');
        // }
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
        return DataTables::of($data)
                    ->editColumn('action', function ($data) {
                        $role = session('role');
                        $button ='';
                        if (isset($role['App\\Http\\Controllers\\Roles\\RolesController']['edit']) && ($role['App\\Http\\Controllers\\Roles\\RolesController']['edit'] == "allow")){
                            $button .= '<a href="/editrole/' . base64_encode($data->role_id) . '" name="edit" id="' . $data->role_id . '" class="btn btn-dark btn-sm" title="Edit"><i class="mdi mdi-border-color"></i></a/>';
                        }
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
    }

    public function editrole($id,Request $request)
    {
        if(session('login')==true){
            if ($request->isMethod('post')) 
            {
                $editRole = new RolesService();
                $editRoleDetails = $editRole->updateRoles($request,$id);
                return Redirect::route('roles.index')->with('status', $editRoleDetails);
            }
            else{
                $configFile =  "acl.config.json";
                if(file_exists(getcwd() . DIRECTORY_SEPARATOR . $configFile))
                    $config = json_decode(File::get( getcwd() . DIRECTORY_SEPARATOR . $configFile),true);
                else
                $config = array();
                $service = new RolesService();
                $role = $service->getRolesById($id);
                $resourceResult = $service->getAllResource();
                return view('roles.editrole',array('role'=>$role,'resourceResult'=>$resourceResult,'resourcePrivilegeMap' => $config));
            }
        }
        else{
            return Redirect::to('login')->with('status', 'Authentication Failed!');
        }
    }

}
