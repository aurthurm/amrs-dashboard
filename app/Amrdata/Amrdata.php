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
    						->join('amr_antibiotics','amr_surveillance.amr_id','=','amr_antibiotics.amr_id')
			                ->where('amr_surveillance.amr_id','=', $id)
 							->select('amr_surveillance.*','amr_antibiotics.*')->get();
        return $amr_surveillance;

    }

    public function updateamrdata($request)
    {
        $data = $request->all();
        $commonservice = new CommonService();
        $dob = $commonservice->dateFormat($data['dob']);
        $specDate = $commonservice->dateFormat($data['specDate']);
        $dateData = $commonservice->dateFormat($data['dateData']);
        // dd($data);
        $id = DB::table('amr_surveillance')
                ->where('amr_id', $data['amrId'])
                ->update(
                    ['laboratory' => $data['laboratoryName'],'origin' => $data['origin'],'patient_id' => $data['patientId'],'sex' => $data['gender'],'date_birth' => $dob,'age' => $data['age'],'pat_type' => $data['patientType'],'ward' => $data['ward'],'institut' => $data['institute'],'department' => $data['department'],'ward_type' => $data['wardType'],'spec_num' => $data['specNum'],'spec_date' => $specDate,'spec_type' => $data['specType'],'spec_code' => $data['specCode'],'spec_reas' => $data['specReas'],'isol_num' => $data['isolNum'],'organism' => $data['organism'],'org_type' => $data['orgType'],'serotype' => $data['serotype'],'beta_lact' => $data['betaLact'],'esbl' => $data['esbl'],'carbapenem' => $data['carbapenem'],'mrsa_scrn' => $data['mrsaScrn'],'induc_cli' => $data['inducCli'],'comment' => $data['comment'],'date_data' => $dateData]
                );
        for($i = 1;$i <= $data['count'];$i++){
        	$value = $data['antibiotic'.$i];
	        $amr_antibiotics = DB::table('amr_antibiotics')
	        					->where([
	        						['amr_id','=', $data['amrId']],
	        						['id','=', $data['antibiotic'.$i]]
	        					])
				                ->update(
					                ['value' => $data[$value]]
					            );
	    }
        // DB::table('user')->insert($data);
        return $data['amrId'];
    }
}
