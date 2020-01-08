<?php

namespace App\Service;
use App\Facilities\Facilities;
use App\EventLog\EventLog;
use DB;
use Redirect;

class FacilitiesService
{
    public function getallfacilities()
    {
       $model = new Facilities();
       $getfacility = $model->getallfacilities();
       return $getfacility;
    }

    public function getProvincebyId($province)
    {
      	$model = new Facilities();
        $province = $model->getProvincebyId($province);
       return $province;
    }

    public function getDistrictbyId($district)
    {
      	$model = new Facilities();
        $district = $model->getDistrictbyId($district);
        return $district;
    }

    public function getProvince()
    {
      	$model = new Facilities();
        $province = $model->getProvince();
        return $province;
    }

    public function getDistrict($district)
    {
      	$model = new Facilities();
        $district = $model->getDistrict($district);
        return $district;
    }

    public function getfacility($id)
    {
      	$model = new Facilities();
        $getfacility = $model->getfacility($id);
        return $getfacility;
    }

    public function savefacility($request)
    {
    	$data =  $request->all();
    	DB::beginTransaction();
    	try {
			$facilitymodel = new Facilities();
        	$addfacility = $facilitymodel->savefacility($request);
			if($addfacility>0){
				DB::commit();
				$subject = $addfacility;
				$eventType = 'Facility-Add';
				$action = 'has added the new Facility Detail name as - '.ucwords($data['facilityName']);
				$resourceName = 'Facilities';
				$eventLogDb = new EventLog();
				$eventLogDb->addEventLog($subject, $eventType, $action, $resourceName);
				$msg = 'Facility Added!';
				return $msg;
			}
	    }
	    catch (Exception $exc) {
	    	DB::rollBack();
	    	$exc->getMessage();
	    }
    }

    public function updatefacility($request)
    {
    	$data =  $request->all();
    	DB::beginTransaction();
    	try {
			$facilitymodel = new Facilities();
        	$updatefacility = $facilitymodel->updatefacility($request);
			if($updatefacility){
				DB::commit();
				$subject = $updatefacility;
				$eventType = 'Facility-Update';
				$action = 'has updated the Facility Detail name as - '.ucwords($data['facilityName']);
				$resourceName = 'Facilities';
				$eventLogDb = new EventLog();
				$eventLogDb->addEventLog($subject, $eventType, $action, $resourceName);
				$msg = 'Facility details Updated!';
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