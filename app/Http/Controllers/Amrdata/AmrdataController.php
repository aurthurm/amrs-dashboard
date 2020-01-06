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
            return DataTables::of($data)
                     ->editColumn('laboratory', function ($data) {
                            $model = new Facilities();
                            $facilityName = $model->getfacility($data->laboratory);
                            $facilityName = $facilityName[0]->facility_name;
                            // $dob = date("d-M-Y", strtotime($data->laboratory));
                            return $facilityName;
                        })
                    ->editColumn('date_birth', function ($data) {
                        $dob = date("d-M-Y", strtotime($data->date_birth));
                        return $dob;
                    })
                    ->editColumn('spec_date', function ($data) {
                        $dob = date("d-M-Y", strtotime($data->spec_date));
                        return $dob;
                    })
                    ->editColumn('date_data', function ($data) {
                        $dob = date("d-M-Y", strtotime($data->date_data));
                        return $dob;
                    })
                    ->make(true);
        }
        else{
            $data = DB::table('amr_surveillance')
                    ->join('facilities','facilities.facility_code','=','amr_surveillance.laboratory')
                    ->select('amr_surveillance.*')
                    ->get();
                    // dd($data);
            return DataTables::of($data)
                        ->editColumn('date_birth', function ($data) {
                            $dob = date("d-M-Y", strtotime($data->date_birth));
                            return $dob;
                        })
                        ->editColumn('spec_date', function ($data) {
                            $dob = date("d-M-Y", strtotime($data->spec_date));
                            return $dob;
                        })
                        ->editColumn('date_data', function ($data) {
                            $dob = date("d-M-Y", strtotime($data->date_data));
                            return $dob;
                        })
                        ->make(true);
        }

   }

   public function getFilterData(Request $request){
       $requestData = $request->all();
       $specimenDate = $request->input('specimenDate');
       $specimenDate = explode(' to ',$specimenDate);
       $startSpecimenDate = date("Y-m-d", strtotime($specimenDate[0]));
       $endSpecimenDate = date("Y-m-d", strtotime($specimenDate[1]));
    //    dd($startSpecimenDate);
       $data = DB::table('users')
            ->join('user_facility_map','user_facility_map.user_id','=','users.user_id')
            ->join('facilities','facilities.facility_id','=','user_facility_map.facility_id')
            ->join('amr_surveillance','facilities.facility_code','=','amr_surveillance.laboratory')
            ->where('users.user_id',session('userId'));
            if($request->input('facilityCode'))
                $data=$data->where('facilities.facility_code',$request->input('facilityCode'));
            if($request->input('gender'))
                $data=$data->where('amr_surveillance.sex',$request->input('gender'));
            if($request->input('specimenDate'))
                $data=$data->whereBetween('amr_surveillance.spec_date',[$startSpecimenDate,$endSpecimenDate]);
            $data ->select('amr_surveillance.*')
            ->get();
        //   return NULL;
        if(!empty($data)){
            return DataTables::of($data)
                    ->editColumn('date_birth', function ($data) {
                        $dob = date("d-M-Y", strtotime($data->date_birth));
                        return $dob;
                    })
                    ->editColumn('date_birth', function ($data) {
                        $dob = date("d-M-Y", strtotime($data->date_birth));
                        return $dob;
                    })
                    ->editColumn('spec_date', function ($data) {
                        $dob = date("d-M-Y", strtotime($data->spec_date));
                        return $dob;
                    })
                    ->editColumn('date_data', function ($data) {
                        $dob = date("d-M-Y", strtotime($data->date_data));
                        return $dob;
                    })
                    ->make(true);
        }
        else
            return 0;
   }
}
