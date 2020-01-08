<?php

namespace App\Amrdata;
use DB;
use Illuminate\Database\Eloquent\Model;
use App\Service\CommonService;

class Amrdata extends Model
{
    protected $table = 'amr_surveillance';
    //

     public function getAmrdata($id)
    {
        $amr_surveillance = DB::table('amr_surveillance')
                ->where('amr_id','=', $id)
                ->get();
        return $amr_surveillance;

    }

    public function updateamrdata($request)
    {
        $data = $request->all();
        $commonservice = new  Common();
        $dob = $commonservice->dateFormat($data['dob']);
        $specDate = $commonservice->dateFormat($data['specDate']);
        $dateData = $commonservice->dateFormat($data['dateData']);
        // dd($data);
        $id = DB::table('amr_surveillance')
                ->where('amr_id', $data['amrId'])
                ->update(
                    ['laboratory' => $data['laboratoryName'],'origin' => $data['origin'],'patient_id' => $data['patientId'],'sex' => $data['gender'],'date_birth' => $dob,'age' => $data['age'],'pat_type' => $data['patientType'],'ward' => $data['ward'],'institut' => $data['institute'],'department' => $data['department'],'ward_type' => $data['wardType'],'spec_num' => $data['specNum'],'spec_date' => $specDate,'spec_type' => $data['specType'],'spec_code' => $data['specCode'],'spec_reas' => $data['specReas'],'isol_num' => $data['isolNum'],'organism' => $data['organism'],'org_type' => $data['orgType'],'serotype' => $data['serotype'],'beta_lact' => $data['betaLact'],'esbl' => $data['esbl'],'carbapenem' => $data['carbapenem'],'induc_cli' => $data['inducCli'],'comment' => $data['comment'],'date_data' => $dateData,'amk_nd30' => $data['amknd30'],'amc_nd20' => $data['amcnd20'],'amp_nd10' => $data['ampnd10'],'cip_nd5' => $data['cipnd5'],'gen_nd10' => $data['gennd10'],'cro_nd30' => $data['crond30'],'caz_nd30' => $data['caznd30'],'ctx_nd30' => $data['ctxnd30'],'fox_nd30' => $data['foxnd30'],'sxt_nd1_2' => $data['sxtnd12']]
                );
        // DB::table('user')->insert($data);
        
    }
}
