<?php

namespace App\Users;
use DB;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table = 'users';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    //
    public function saveuser($request)
    {
        //to get all request values
        $data = $request->all();
        // $dob = date("Y-m-d", strtotime( $data['dob']));
        // dd($data);
        $lastInsertedId = 0;
        $userId = rand();
        if ($request->input('username')!=null && trim($request->input('username')) != '') {
            $id = DB::table('users')->insert(
                ['user_id'=>$userId,'name' => $data['name'],'gender' => $data['gender'],'email' => $data['email'],'dob' => $data['dob'],'password' => $data['password'],'phone' => $data['phoneNo'],'alt_phone' => $data['altPhoneNo'],'address' => $data['addrline1'],'username' => $data['username'],'status' => $data['status']]
            );
            // DB::table('user')->insert($data);
        }
        
    }

    public function saveuserfacilitymap($request){
        $data = $request->all();
        $facilityId = explode(',',$data['facilityid']);
        $user = DB::table('user_facility_map')
                ->where('user_id','=', $data['userId'])
                ->get();
        $users = $user->toArray();
        if(count($users)>0){
            $userFacility = DB::table('user_facility_map')->where('user_id','=',$data['userId'])->delete();
            if(count($facilityId)>1){
                for($i=0;$i<count($facilityId);$i++){
                    DB::table('user_facility_map')->insert(['user_id'=>$data['userId'],'facility_id'=>$facilityId[$i]]);
                }
            }
        }
        else{
            if(count($facilityId)>1){
                for($i=0;$i<count($facilityId);$i++){
                    DB::table('user_facility_map')->insert(['user_id'=>$data['userId'],'facility_id'=>$facilityId[$i]]);
                }
            }
        }
    }

    public function getuserfacilitymapById($request){
        $data = $request->all();
        $user = DB::table('user_facility_map')
                ->where('user_id','=', $data['val'])
                ->get();
        return $user;
    }

    public function updateuser($request)
    {
        //to get all request values
        $data = $request->all();
        if ($request->input('username')!=null && trim($request->input('username')) != '') {
            $id = DB::table('users')
                    ->where('user_id', $data['userId'])
                    ->update(
                        ['name' => $data['name'],'gender' => $data['gender'],'email' => $data['email'],'dob' => $data['dob'],'phone' => $data['phoneNo'],'alt_phone' => $data['altPhoneNo'],'address' => $data['addrline1'],'username' => $data['username'],'status' => $data['status']]
                    );
            // DB::table('user')->insert($data);
        }
        
    }

    public function getuser($id)
    {
        $user = DB::table('users')
                ->where('user_id','=', $id)
                ->get();
        return $user;

    }

    public function getalluser()
    {
        $user = DB::table('users')
                ->get();
        return $user;
    }
}
