<?php

namespace App\Users;
use DB;
use App\Service\UsersService;
use App\Service\CommonService;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table = 'users';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    //

    public function getalluser(){
        $data = Users::latest()->get();
        return $data;
    }


    public function saveuser($request)
    {
        //to get all request values
        $data = $request->all();
        $commonservice = new CommonService();
        $dob = $commonservice->dateFormat($data['dob']);
        // dd($data);
        $lastInsertedId = 0;
        $userId = rand();
        if ($request->input('username')!=null && trim($request->input('username')) != '') {
            $id = DB::table('users')->insert(
                ['user_id'=>$userId,'name' => $data['name'],'gender' => $data['gender'],'email' => $data['email'],'dob' => $dob,'password' => $data['password'],'phone' => $data['phoneNo'],'alt_phone' => $data['altPhoneNo'],'address' => $data['addrline1'],'username' => $data['username'],'status' => $data['status']]
            );
        }
        $result = DB::table('users')->select('user_id')
                    ->where('user_id','=', $userId)
                    ->get();
        $result = count($result);
        if($result>0)    
            return $userId;
    }

    public function updateuser($request)
    {
        $data = $request->all();
        $userId = "";
        $commonservice = new CommonService();
        $dob = $commonservice->dateFormat($data['dob']);
        if ($request->input('username')!=null && trim($request->input('username')) != '') {
            $id = DB::table('users')
                    ->where('user_id', $data['userId'])
                    ->update(
                        ['name' => $data['name'],'gender' => $data['gender'],'email' => $data['email'],'dob' => $dob,'phone' => $data['phoneNo'],'alt_phone' => $data['altPhoneNo'],'address' => $data['addrline1'],'username' => $data['username'],'status' => $data['status']]
                    );
            $userId = $data['userId'];
        }
        return $userId;
    }

    public function saveuserfacilitymap($request){
        $data = $request->all();
        $id = "";
        $facilityId = explode(',',$data['facilityid']);
        $user = DB::table('user_facility_map')
                ->where('user_id','=', $data['userId'])
                ->get();
        $users = $user->toArray();
        if(count($users)>0){
            $userFacility = DB::table('user_facility_map')->where('user_id','=',$data['userId'])->delete();
            if(count($facilityId)>0){
                for($i=0;$i<count($facilityId);$i++){
                    $id = DB::table('user_facility_map')->insert(['user_id'=>$data['userId'],'facility_id'=>$facilityId[$i]]);
                }
            }
        }
        else{
            if(count($facilityId)>0){
                for($i=0;$i<count($facilityId);$i++){
                    $id = DB::table('user_facility_map')->insert(['user_id'=>$data['userId'],'facility_id'=>$facilityId[$i]]);
                }
            }
        }
        return $id;
    }

    public function getuserfacilitymapById($request){
        $data = $request->all();
        $user = DB::table('user_facility_map')
                ->where('user_id','=', $data['val'])
                ->get();
        return $user;
    }


    public function getuser($id)
    {
        $user = DB::table('users')
                ->where('user_id','=', $id)
                ->get();
        return $user;

    }

}
