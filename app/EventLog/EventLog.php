<?php

namespace App\EventLog;

use Illuminate\Database\Eloquent\Model;
use DB;
use session;
use App\Service\CommonService;

class EventLog extends Model
{
    //
	protected $table = 'event_log';

	public function addEventLog($subject, $eventType, $action, $resourceName) {

            $actor_id = session('userId');
            $common = new CommonService();
            $currentDateTime=$common->getDateTime();
            $data = array('actor'=>$actor_id,
                          'subject'=>$subject,
                          'event_type'=>$eventType,
                          'action'=>$action,
                          'resource_name'=>$resourceName,
                          'added_on'=> $currentDateTime
                        );
            DB::table('event_log')->insert($data);
    }
}
