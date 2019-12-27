<?php

namespace App\Facilities;

use DB;
use Illuminate\Database\Eloquent\Model;

class Facilities extends Model
{
    //
    protected $table = 'facilities';
    public function savefacility($request)
    {
        //to get all request values
        $data = $request->all();
        // $dob = date("Y-m-d", strtotime( $data['dob']));
        $lastInsertedId = 0;
        $id = 0;
        if ($request->input('facilityName')!=null && trim($request->input('facilityName')) != '') {
            $id = DB::table('facilities')->insertGetId(
                ['facility_name' => $data['facilityName'],'facility_code' => $data['facilityCode'],'email' => $data['email'],'facility_type' => $data['facilityType'],'province' => $data['province'],'district' => $data['district'],'phone' => $data['phoneNo'],'address' => $data['addrline1'],'status' => $data['status']]
            );
            // DB::table('user')->insert($data);
        }
        return $id;
    }

    public function getProvince(){
        $province = DB::table('province')->get();
        return $province;
    }

    public function getProvincebyId($province_id){
        $province = DB::table('province')
                    ->where('province_id','=', $province_id)
                    ->get();
        return $province;
    }

    public function getDistrictbyId($district_id){
        $district = DB::table('district')
                    ->where('district_id','=', $district_id)
                    ->get();
        return $district;
    }


    public function getDistrict($province_id){
        $district = DB::table('district')
                    ->where('province_id','=', $province_id)
                    ->get();
        return $district;
    }

    public function getfacility($id)
    {
        $facility = DB::table('facilities')
                ->where('facility_id','=', $id)
                ->get();
        return $facility;

    }

    public function getallfacilities()
    {
        $facility = DB::table('facilities')
                ->get();
        return $facility;

    }

    public function updatefacility($request)
    {
        //to get all request values
        $data = $request->all();
        if ($request->input('facilityName')!=null && trim($request->input('facilityName')) != '') {
            $id = DB::table('facilities')
                    ->where('facility_id', $data['facilityId'])
                    ->update(
                        ['facility_name' => $data['facilityName'],'facility_code' => $data['facilityCode'],'email' => $data['email'],'facility_type' => $data['facilityType'],'province' => $data['province'],'district' => $data['district'],'phone' => $data['phoneNo'],'address' => $data['addrline1'],'status' => $data['status']]
                    );
            // DB::table('user')->insert($data);
        }
        
    }
    
}
