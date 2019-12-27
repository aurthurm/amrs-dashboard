<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Users\Users;
use App\Facilities\Facilities;
use Yajra\DataTables\Facades\DataTables;
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
        return view('users.index');
        // $user = User::select('name','email','mobile_no','username','status');
        // return Datatables::of($user)->make(true);
    }

    public function getUser(Request $request)
    {

        $data = Users::latest()->get();
        return DataTables::of($data)
                    ->addColumn('action', function($data){
                        $button = '<a href="/edituser/'.$data->user_id.'" name="edit" id="'.$data->user_id.'" class="edit btn btn-dark btn-sm"><i class="mdi mdi-border-color"></i></a>';
                        // $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="edit" id="'.$data->id.'" class="delete btn btn-danger btn-sm">Delete</button>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        
        // return \Datatables::of(User::query())->make(true);

   }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adduser()
    {
        return view('users.adduser');
    }

    public function userfacilitymap()
    {
        $usermodel = new Users();
        $facilitymodel = new Facilities();
        $users = $usermodel->getalluser();
        $facilities = $facilitymodel->getallfacilities();
        return view('users.userfacilitymap',compact('users','facilities'));
    }

    public function getuserfacilitymapById(Request $request){
        $usermodel = new Users();
        $userfacilitymap = $usermodel->getuserfacilitymapById($request);
        $options = '';
        $facilitymodel = new Facilities();
        foreach($userfacilitymap as $list){
            $data = $facilitymodel->getfacility($list->facility_id);
            $options .= '<option value=" '.$list->facility_id.' "> '.$data[0]->facility_code.'  -  '.$data[0]->facility_name.' </option>';
        }
        $array = array();
        $array['removeoptions'] = $userfacilitymap;
        $array['options'] = $options;
        return $array;
    }

    public function edituser($id)
    {
        //
        $usermodel = new Users();
        $data = $usermodel->getuser($id);
        // dd($data[0]->id);
        // $data1 = array(
        //     'id' => $data->id
        //     );
        // $data = $data->toArray();
        // dd($data1);
        return view('users.edituser')->with('data', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function adduserStore(Request $request)
    {
        $usermodel = new Users();
        $usermodel->saveuser($request);
        return Redirect::route('users.index')->with('status', 'User Added!');
        //
    }

    public function userfacilitymapStore(Request $request)
    {
        $usermodel = new Users();
        $usermodel->saveuserfacilitymap($request);
        return Redirect::to('userfacilitymap')->with('status', 'User Facility Mapped!');
        //
    }

    public function edituserUpdate(Request $request)
    {
        $usermodel = new Users();
        $usermodel->updateuser($request);
        $deleted_message = "Some message that shows that something was deleted";
        return Redirect::route('users.index')->with('status', 'User details Updated!');
        // return view('user.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
