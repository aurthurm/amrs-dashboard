<?php

namespace App\Exports;

use App\Amrdata\Amrdata;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use DB;
use Illuminate\Support\Facades\Schema;

class AmrdataExport implements FromCollection, WithHeadings, WithTitle
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct(string $sheets,array $amrData)
    {
        $this->facilityCode = $amrData['facilityCode'];
        $this->gender = $amrData['gender'];
        $this->startSpecimenDate = $amrData['startSpecimenDate'];
        $this->endSpecimenDate = $amrData['endSpecimenDate'];
    }

    public function collection()
    {
        $data = DB::table('users')
            ->join('user_facility_map','user_facility_map.user_id','=','users.user_id')
            ->join('facilities','facilities.facility_id','=','user_facility_map.facility_id')
            ->join('amr_surveillance','facilities.facility_code','=','amr_surveillance.laboratory')
            ->where('facilities.status','active')
            ->where('users.user_id',session('userId'));
            if($this->facilityCode)
                $data=$data->where('facilities.facility_code',$this->facilityCode);
            if($this->gender)
                $data=$data->where('amr_surveillance.sex',$this->gender);
            if($this->startSpecimenDate)
                $data=$data->whereBetween('amr_surveillance.spec_date',[$this->startSpecimenDate,$this->endSpecimenDate])
            ->select('amr_surveillance.*')
            ->get();
        $antibioticArray = array();
        $anticol = DB::table('amr_antibiotics')->distinct()->get(['antibiotic']);
        $anticol = $anticol->toArray();
        if(count($data)>0){
            for($k=0;$k<count($data);$k++){
                $antibiotics = DB::table('amr_antibiotics')
                                ->select('*')
                                ->where('amr_id','=',$data[$k]->amr_id)
                                ->get();
                $antibiotics = $antibiotics->toArray();
                for($a=0;$a<count($antibiotics);$a++){
                    $antibioticArray[$data[$k]->amr_id][$antibiotics[$a]->antibiotic] = $antibiotics[$a]->value;
                }
                foreach($data[$k] as $key => $value){
                    $amrData[$k][] = $value;
                }
                for($l=0;$l<count($anticol);$l++){
                    if(array_key_exists($anticol[$l]->antibiotic, $antibioticArray[$data[$k]->amr_id])){
                        $amrData[$k][] = $antibioticArray[$data[$k]->amr_id][$anticol[$l]->antibiotic];
                    }
                    else{
                        $amrData[$k][] = "";
                    }
                }
            }
            return collect([
                
                $amrData
            ]);
        }
        else{
            $msg = "There is no data in this specimen collection date range";
        }
    }

    public function headings(): array
    {
        $colForm = array();
        $col = Schema::getColumnListing('amr_surveillance');
        for($i=0;$i<count($col);$i++){
            $upperCol = strtoupper($col[$i]);
            array_push($colForm,$upperCol);
        }
        
        $anticol = DB::table('amr_antibiotics')->distinct()->get(['antibiotic']);
        for($j=0;$j<count($anticol);$j++){
            $label = explode('_',$anticol[$j]->antibiotic)[0];
            $label = strtoupper($label);
            array_push($colForm,strtoupper($anticol[$j]->antibiotic));
        }
        // dd($col);
        return [
            $colForm
        ];
    }

    public function title(): string
    {
        return 'amr_antibiotic_values';
    }
}
