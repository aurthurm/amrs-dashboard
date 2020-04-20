<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Common\Common;
use DB;

class CommonController extends Controller
{
    //
    public function checkValidation(Request $request)
    {
        $commonmodel = new Common();
        $data = $commonmodel->checkValidation($request);
        return $data;
    }

    public function duplicateValidation(Request $request)
    {
        $commonmodel = new Common();
        $data = $commonmodel->duplicateValidation($request);
        return $data;
    }

    public function checkNameValidation(Request $request)
    {
        $commonService = new Common();
        $data = $commonService->checkNameValidation($request);
        return $data;
    }
    
}
