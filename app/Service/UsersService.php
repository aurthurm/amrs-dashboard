<?php

namespace App\Service;
use App\Users\Users;
use App\EventLog\EventLog;
use DB;
use Redirect;

class UsersService
{
    public function getalluser()
    {
       $usermodel = new Users();
       $getuser = $usermodel->getalluser();
       return $getuser;
    }

    public function getuser($id)
    {
       $usermodel = new Users();
       $getuser = $usermodel->getuser($id);
       return $getuser;
    }

    public function getuserfacilitymapById($request){
        $usermodel = new Users();
        $userfacilitymap = $usermodel->getuserfacilitymapById($request);
        return $userfacilitymap;
    }

    public function saveuserfacilitymap($request){
        $data =  $request->all();
    	DB::beginTransaction();
    	try {
			$usermodel = new Users();
			$saveuserfacilitymap = $usermodel->saveuserfacilitymap($request);
			if($saveuserfacilitymap){
				DB::commit();
				$subject = $saveuserfacilitymap;
				$eventType = 'User Facility-Map';
				$action = 'has mapped the user facility which is - '.ucwords($data['userId']);
				$resourceName = 'Users';
				$eventLogDb = new EventLog();
				$eventLogDb->addEventLog($subject, $eventType, $action, $resourceName);
				$msg = 'User Facility Mapped!';
				return $msg;
			}
	    }
	    catch (Exception $exc) {
	    	DB::rollBack();
	    	$exc->getMessage();
	    }
    }

    public function saveuser($request)
    {
    	$data =  $request->all();
    	DB::beginTransaction();
    	try {
			$usermodel = new Users();
			$adduser = $usermodel->saveuser($request);
			if($adduser){
				DB::commit();
				$subject = $adduser;
				$eventType = 'User-Add';
				$action = 'has added the new User Detail name as - '.ucwords($data['name']);
				$resourceName = 'Users';
				$eventLogDb = new EventLog();
				$eventLogDb->addEventLog($subject, $eventType, $action, $resourceName);
				$msg = 'User Added!';
				return $msg;
			}
	    }
	    catch (Exception $exc) {
	    	DB::rollBack();
	    	$exc->getMessage();
	    }
    }

    public function updateuser($request)
    {
    	$data =  $request->all();
    	DB::beginTransaction();
    	try {
			$usermodel = new Users();
			$updateuser = $usermodel->updateuser($request);
			if($updateuser){
				DB::commit();
				$subject = $updateuser;
				$eventType = 'User-Update';
				$action = 'has updated the User Detail name as - '.ucwords($data['name']);
				$resourceName = 'Users';
				$eventLogDb = new EventLog();
				$eventLogDb->addEventLog($subject, $eventType, $action, $resourceName);
				$msg = 'User details Updated!';
				return $msg;
			}
	    }
	    catch (Exception $exc) {
	    	DB::rollBack();
	    	$exc->getMessage();
	    }
    }
    
}

?>