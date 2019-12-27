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
}
