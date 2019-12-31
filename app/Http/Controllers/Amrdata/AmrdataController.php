<?php

namespace App\Http\Controllers\Amrdata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Amrdata\Amrdata;
use App\Facilities\Facilities;
use Yajra\DataTables\Facades\DataTables;
use DB;
use Redirect;
use Session;

class AmrdataController extends Controller
{
    //
    public function index()
    {
        if(session('login')==true){
            $model = new Facilities();
            $facilityData = $model->getallfacilities();
            return view('amrdata.index',compact('facilityData'));
        }
        else{
            return Redirect::to('login')->with('status', 'Authentication Failed!');
        }
    }

    public function getamrdata(Request $request)
    {

        // $data = Users::latest()->get();
        if(session('role')=="user"){
            $data = DB::table('users')
            ->join('user_facility_map','user_facility_map.user_id','=','users.user_id')
            ->join('facilities','facilities.facility_id','=','user_facility_map.facility_id')
            ->join('amr_surveillance','facilities.facility_code','=','amr_surveillance.laboratory')
            ->where('users.user_id',session('userId'))
            ->select('amr_surveillance.*')
            ->get();
            // dd($data);
            return DataTables::of($data)->make(true);
        }
        else{
            $data = DB::table('amr_surveillance')
                    ->join('facilities','facilities.facility_code','=','amr_surveillance.laboratory')
                    ->select('amr_surveillance.*')
                    ->get();
                    // dd($data);
            return DataTables::of($data)
                        ->make(true);
        }

   }

   public function getFilterData(Request $request){
       $requestData = $request->all();
       $data = DB::table('users')
            ->join('user_facility_map','user_facility_map.user_id','=','users.user_id')
            ->join('facilities','facilities.facility_id','=','user_facility_map.facility_id')
            ->join('amr_surveillance','facilities.facility_code','=','amr_surveillance.laboratory')
            ->where('users.user_id',session('userId'));
            if($request->input('facilityCode'))
                $data=$data->where('facilities.facility_code',$request->input('facilityCode'));
            if($request->input('gender'))
                $data=$data->where('amr_surveillance.sex',$request->input('gender'));
            $data ->select('amr_surveillance.*')
            ->get();
        //   return NULL;
        if(!empty($data))
            return DataTables::of($data)->make(true);
        else
            return 0;
   }
}
