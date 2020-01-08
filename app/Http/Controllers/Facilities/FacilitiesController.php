<?php

namespace App\Http\Controllers\Facilities;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Facilities\Facilities;
use Yajra\DataTables\Facades\DataTables;
use DB;
use Redirect;
use Session;

class FacilitiesController extends Controller
{
    //

    public function index()
    {
        if(session('login')==true){
            return view('facilities.index');
        }
        else{
            return Redirect::to('login')->with('status', 'Authentication Failed!');
        }
    }

    public function getFacility(Request $request)
    {

        $data = Facilities::get();
        
        // dd($data);
        
        // dd($province);
        return DataTables::of($data)
                    ->addColumn('action', function($data){
                        $button = '<a href="/editfacility/'.$data->facility_id.'" name="edit" id="'.$data->facility_id.'" class="edit btn btn-dark btn-sm"><i class="mdi mdi-border-color"></i></a>';
                        // $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="edit" id="'.$data->id.'" class="delete btn btn-danger btn-sm">Delete</button>';
                        return $button;
                    })
                    ->addColumn('province', function($data){
                        $model = new Facilities();
                        $province = $model->getProvincebyId($data->province);
                        $province_name = $province[0]->province_name;
                        return $province_name;
                    })
                    ->addColumn('district', function($data){
                        $model = new Facilities();
                        $district = $model->getDistrictbyId($data->district);
                        $district_name = $district[0]->district_name;
                        return $district_name;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
   }


    public function addfacility()
    {
        $model = new Facilities();
        $province = $model->getProvince();
        if(session('login')==true){
            return view('facilities.addfacility',compact('province'));
        }
        else{
            return Redirect::to('login')->with('status', 'Authentication Failed!');
        }
    }

    public function addfacilityStore(Request $request)
    {
        $usermodel = new Facilities();
        $usermodel->savefacility($request);
        return Redirect::route('facilities.index')->with('status', 'Facility Added!');
    }

    public function getDistrict(Request $request)
    {
        $province = $request->val;
        $model = new Facilities();
        $district = $model->getDistrict($province);
        $options = '<option value="">Select District</option>';
        foreach($district as $districts){
            $options .= '<option value=" '.$districts->district_id.' "> '.$districts->district_name.' </option>';
        }
        return $options;
    }

    public function editfacility($id)
    {
        if(session('login')==true){
            $model = new Facilities();
            $data = $model->getfacility($id);
            $province = $model->getProvincebyId($data[0]->province);
            $province_name = $province[0]->province_name;
            $data[0]->province_name = $province_name;
            $district = $model->getDistrictbyId($data[0]->district);
            $district_name = $district[0]->district_name;
            $data[0]->district_name = $district_name;
            $province_all = $model->getProvince();
            $districtByProv = $model->getDistrict($data[0]->province);
            return view('facilities.editfacility',compact('data', 'province_all','districtByProv'));
        }
        else{
            return Redirect::to('login')->with('status', 'Authentication Failed!');
        }
    }

    public function editfacilityUpdate(Request $request)
    {
        $facilitymodel = new Facilities();
        $facilitymodel->updatefacility($request);
        return Redirect::route('facilities.index')->with('status', 'Facility details Updated!');
    }

}
