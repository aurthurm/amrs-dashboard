<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Users\Users;
use App\Service\RolesService;
use App\Facilities\Facilities;
use App\Service\FacilitiesService;
use Yajra\DataTables\Facades\DataTables;
use App\Service\UsersService;
use DB;
use Redirect;
use Session;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(session('login')==true){
            return view('users.index');
        }
        else{
            return Redirect::to('login')->with('status', 'Authentication Failed!');
        }
    }

    public function getUser(Request $request)
    {
        $UsersService = new UsersService();
        $data = $UsersService->getalluser();
        return DataTables::of($data)
                    ->addColumn('action', function($data){
                        $button = '<a href="/edituser/'.$data->user_id.'" name="edit" id="'.$data->user_id.'" class="edit btn btn-dark btn-sm"><i class="mdi mdi-border-color"></i></a>';
                        // $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="edit" id="'.$data->id.'" class="delete btn btn-danger btn-sm">Delete</button>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);

   }

    public function adduser()
    {
        if(session('login')==true){
            $RoleService = new RolesService();
            $data = $RoleService->getAllRole();
            return view('users.adduser',array('role'=>$data));
        }
        else{
            return Redirect::to('login')->with('status', 'Authentication Failed!');
        }
    }

    public function userfacilitymap()
    {
        $facilityService = new FacilitiesService();
        $UsersService = new UsersService();
        $users = $UsersService->getalluser();
        $facilities = $facilityService->getallfacilities();
        if(session('login')==true){
            return view('users.userfacilitymap',compact('users','facilities'));
        }
        else{
            return Redirect::to('login')->with('status', 'Authentication Failed!');
        }
    }

    public function getuserfacilitymapById(Request $request){
        $UsersService = new UsersService();
        $userfacilitymap = $UsersService->getuserfacilitymapById($request);
        $options = '';
        $facilityService = new FacilitiesService();
        foreach($userfacilitymap as $list){
            $data = $facilityService->getfacility($list->facility_id);
            $options .= '<option value=" '.$list->facility_id.' "> '.$data[0]->facility_code.'  -  '.$data[0]->facility_name.' </option>';
        }
        $array = array();
        $array['removeoptions'] = $userfacilitymap;
        $array['options'] = $options;
        return $array;
    }

    public function edituser($id)
    {
        if(session('login')==true){
            $UsersService = new UsersService();
            $data = $UsersService->getuser($id);
            $RoleService = new RolesService();
            $role = $RoleService->getAllRole();
            return view('users.edituser',array('data'=>$data,'role'=>$role));
        }
        else{
            return Redirect::to('login')->with('status', 'Authentication Failed!');
        }
    }

    public function adduserStore(Request $request)
    {
        $UsersService = new UsersService();
        $adduser = $UsersService->saveuser($request);
        return Redirect::route('users.index')->with('status', $adduser);

    }

    public function userfacilitymapStore(Request $request)
    {
        $UsersService = new UsersService();
        $msg = $UsersService->saveuserfacilitymap($request);
        return Redirect::to('userfacilitymap')->with('status', $msg);
    }

    public function edituserUpdate(Request $request)
    {
        $UsersService = new UsersService();
        $msg = $UsersService->updateuser($request);
        return Redirect::route('users.index')->with('status', $msg);

    }

}
