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

class AmrdataInterpretationExport implements FromCollection, WithHeadings, WithTitle
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    
    public function collection()
    {
        $data = DB::table('amr_surveillance')->select('*')->get();
        $antibioticArray = array();
        $anticol = DB::table('amr_antibiotics')->distinct()->get(['antibiotic']);
        $anticol = $anticol->toArray();
        for($k=0;$k<count($data);$k++){
            $antibiotics = DB::table('amr_antibiotics')
                            ->select('*')
                            ->where('amr_id','=',$data[$k]->amr_id)
                            ->get();
            $antibiotics = $antibiotics->toArray();
            for($a=0;$a<count($antibiotics);$a++){
                $antibioticArray[$data[$k]->amr_id][$antibiotics[$a]->antibiotic] = $antibiotics[$a]->interpretation;
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
        return 'amr_antibiotic_interpretation';
    }
}
