<?php

namespace App\Common;

use Illuminate\Database\Eloquent\Model;
use DB;

class Common extends Model
{
    //
    public function checkValidation($request){
        // dd($request->all());
        $tableName = $request['tableName'];
        $fieldName = $request['fieldName'];
        $value = trim($request['value']);
        $fnct = $request['fnct'];
        $fields = explode("##", $fnct);
        $primaryName = $fields[0];
        $primaryValue = trim($fields[1]);
        // dd($fields);
        $user = array();
        if($value != ""){
            $user = DB::table($tableName)
                    ->where($primaryName,'=', $primaryValue)
                    ->where($fieldName,'=', $value)
                    ->get();
        }
        return count($user);
    }

    public function duplicateValidation($request){
        // dd($request->all());
        $tableName = $request['tableName'];
        $fieldName = $request['fieldName'];
        $value = trim($request['value']);
        // $fnct = $request['fnct'];
        // $fields = explode("##", $fnct);
        // $primaryName = $fields[0];
        // $primaryValue = trim($fields[1]);
        // dd($fields);
        $user = array();
        if($value != ""){
            $user = DB::table($tableName)
                    ->where($fieldName,'=', $value)
                    ->get();
        }
        return count($user);
    }

    public function dateFormat($date) {
        if (!isset($date) || $date == null || $date == "" || $date == "0000-00-00") {
            return "0000-00-00";
        } else {
            $dateArray = explode('-', $date);
            if (sizeof($dateArray) == 0) {
                return;
            }
            $newDate = $dateArray[2] . "-";

            $monthsArray = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
            $mon = 1;
            $mon += array_search(ucfirst($dateArray[1]), $monthsArray);

            if (strlen($mon) == 1) {
                $mon = "0" . $mon;
            }
            return $newDate .= $mon . "-" . $dateArray[0];
        }
    }

    public function humanDateFormat($date) {
        if ($date == null || $date == "" || $date == "0000-00-00" || $date == "0000-00-00 00:00:00") {
            return "";
        } else {
            $dateArray = explode('-', $date);
            $newDate = $dateArray[2] . "-";

            $monthsArray = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
            $mon = $monthsArray[$dateArray[1] - 1];

            return $newDate .= $mon . "-" . $dateArray[0];
        }
    }

    public function checkNameValidation($request)
    {
        $tableName = $request['tableName'];
        $fieldName = $request['fieldName'];
        $value = trim($request['value']);
        $fnct = $request['fnct'];
        $user = array();
        try {
            if(isset($fnct) && trim($fnct)!==''){
                $fields = explode("##", $fnct);
                $primaryName = $fields[0];
                $primaryValue = trim($fields[1]);
                if ($value != "") {
                    $user = DB::table($tableName)
                        ->where($primaryName, '!=', $primaryValue)
                        ->where($fieldName, '=', $value)
                        ->get();
                }
            }else{
                if ($value != "") {
                    $user = DB::table($tableName)
                        ->where($fieldName, '=', $value)
                        ->get();
                }
            }
        } catch (Exception $exc) {
            error_log($exc->getMessage());
        }
        return count($user);
    }

}
