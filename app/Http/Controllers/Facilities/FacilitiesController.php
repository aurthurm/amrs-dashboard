<?php

namespace App\Http\Controllers\Facilities;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Facilities\Facilities;
use App\Service\FacilitiesService;
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
        return DataTables::of($data)
                    ->addColumn('action', function($data){
                        $role = session('role');
                        $button = '';
                        if (isset($role['App\\Http\\Controllers\\Facilities\\FacilitiesController']['edit']) && ($role['App\\Http\\Controllers\\Facilities\\FacilitiesController']['edit'] == "allow")){
                            $button .= '<a href="/editfacility/'.$data->facility_id.'" name="edit" id="'.$data->facility_id.'" class="edit btn btn-dark btn-sm"><i class="mdi mdi-border-color"></i></a>';
                        }
                        return $button;
                    })
                    ->addColumn('province', function($data){
                        $facilityService = new FacilitiesService();
                        $province = $facilityService->getProvincebyId($data->province);
                        $province_name = $province[0]->province_name;
                        return $province_name;
                    })
                    ->addColumn('district', function($data){
                        $facilityService = new FacilitiesService();
                        $district = $facilityService->getDistrictbyId($data->district);
                        $district_name = $district[0]->district_name;
                        return $district_name;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
   }


    public function addfacility()
    {
        $facilityService = new FacilitiesService();
        $province = $facilityService->getProvince();
        if(session('login')==true){
            return view('facilities.addfacility',compact('province'));
        }
        else{
            return Redirect::to('login')->with('status', 'Authentication Failed!');
        }
    }

    public function addfacilityStore(Request $request)
    {
        $facilityService = new FacilitiesService();
        $msg = $facilityService->savefacility($request);
        return Redirect::route('facilities.index')->with('status', $msg);
    }

    public function getDistrict(Request $request)
    {
        $province = $request->val;
        $facilityService = new FacilitiesService();
        $district = $facilityService->getDistrict($province);
        $options = '<option value="">Select District</option>';
        foreach($district as $districts){
            $options .= '<option value=" '.$districts->district_id.' "> '.$districts->district_name.' </option>';
        }
        return $options;
    }

    public function editfacility($id)
    {
        if(session('login')==true){
            $facilityService = new FacilitiesService();
            $data = $facilityService->getfacility($id);
            $province = $facilityService->getProvincebyId($data[0]->province);
            $province_name = $province[0]->province_name;
            $data[0]->province_name = $province_name;
            $district = $facilityService->getDistrictbyId($data[0]->district);
            $district_name = $district[0]->district_name;
            $data[0]->district_name = $district_name;
            $province_all = $facilityService->getProvince();
            $districtByProv = $facilityService->getDistrict($data[0]->province);
            return view('facilities.editfacility',compact('data', 'province_all','districtByProv'));
        }
        else{
            return Redirect::to('login')->with('status', 'Authentication Failed!');
        }
    }

    public function editfacilityUpdate(Request $request)
    {
        $facilityService = new FacilitiesService();
        $msg = $facilityService->updatefacility($request);
        return Redirect::route('facilities.index')->with('status', $msg);
    }

}
