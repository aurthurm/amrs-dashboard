<?php

namespace App\Service;
use App\Amrdata\Amrdata;
use App\EventLog\EventLog;
use DB;
use Redirect;

class AmrdataService
{

	public function getAmrdata($id)
    {
    	$model = new  Amrdata();
        $data = $model->getAmrdata($id);
        return $data;
	}
	
	public function getAmrAntibiotics($id)
    {
    	$model = new  Amrdata();
        $data = $model->fetchAmrAntibiotics($id);
        return $data;
    }

    public function updateamrdata($request)
    {
    	$data =  $request->all();
    	DB::beginTransaction();
    	try {
			$amrdatamodel = new Amrdata();
			$updateamrdata = $amrdatamodel->updateamrdata($request);
			if($updateamrdata){
				DB::commit();
				$subject = $updateamrdata;
				$eventType = 'Amrdata-Update';
				$action = 'has updated the Amr data for the amrid - '.ucwords($data['amrId']);
				$resourceName = 'Amrdata';
				$eventLogDb = new EventLog();
				$eventLogDb->addEventLog($subject, $eventType, $action, $resourceName);
				$msg = 'Amrdata details Updated!';
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