<?php

$DB_Server = "localhost"; //MySQL Server    
$DB_Username = "root"; //MySQL Username     
$DB_Password = "zaq12345";             //MySQL Password     
$DB_DBName = "amrs";         //MySQL Database Name  
$DB_TBLName = "amr_surveillance"; //MySQL Table Name   
$filename = "./excelfilename";         //File Name

if (isset($argc) && $argc > 1) {
    $startDate = $argv[1];
    if($argc > 2){
    	$endDate = $argv[2];
    }
    else{
    	$endDate = date("Y-m-d");
    }
}
else{
	$startDate = date('Y-m-d', strtotime('-2 days', strtotime(date("Y-m-d"))));
	$endDate = date("Y-m-d");
}
// $start_date = readline("Enter a Start Date (yyyy-mm-dd): ");
// $end_date = readline("Enter a End Date (yyyy-mm-dd): ");

// Output
$start_date = date('Y-m-d',strtotime($startDate));
$end_date = date('Y-m-d',strtotime($endDate));

$fileStart = date('Ymd',strtotime($startDate));
$fileEnd = date('Ymd',strtotime($endDate));
// print_r($start_date);
$rows=[];
$sql = "Select amr_surveillance.first_name,amr_surveillance.last_name,r_specimens.ENGLISH,amr_surveillance.spec_date,r_organisms.ORG_CLEAN,'Disk',LEFT(UPPER(amr_antibiotics.antibiotic),3),amr_antibiotics.value,'R' from amr_surveillance JOIN amr_antibiotics ON amr_surveillance.amr_id = amr_antibiotics.amr_id JOIN r_specimens ON amr_surveillance.spec_type = r_specimens.C_ENGLISH JOIN r_organisms ON amr_surveillance.organism = r_organisms.ORG WHERE r_organisms.STATUS='c' and amr_surveillance.spec_date BETWEEN '$start_date' AND '$end_date'";

$Connect = mysqli_connect($DB_Server, $DB_Username, $DB_Password,$DB_DBName) or die("Couldn't connect to MySQL:<br>" . mysqli_error() . "<br>" . mysqli_errno());
//select database   
$Db = mysqli_select_db($Connect,$DB_DBName) or die("Couldn't select database:<br>" . mysqli_error(). "<br>" . mysqli_errno());   
//execute query 
// $result = mysqli_query($Connect,$sql) or die("Couldn't execute query:<br>" . mysqli_error(). "<br>" . mysqli_errno());
$result = $Connect->query($sql);

header("Content-Type: application/xls");    
header("Content-Disposition: attachment; filename=excel.xls");  
header("Pragma: no-cache"); 
header("Expires: 0");
$sep = "\t"; //tabbed character

// for ($i = 0; $i < mysqli_num_fields($result); $i++) {
// echo mysqli_fetch_field_direct($result,$i)->name . "\t";
// }
print("\n");
if(file_exists('backlink/baclink_'.$fileStart.'_'.$fileEnd.'.xls')){
	unlink('backlink/baclink_'.$fileStart.'_'.$fileEnd.'.xls');
}
$columnHeader = '';  
$columnHeader = "First Name" . "\t" . "Last Name" . "\t"."Specimen type". "\t"."Specimen date". "\t"."Organism". "\t"."Antibiotic". "\t"."Method". "\t"."Measurement". "\t"."Interp". "\t";
if(! file_exists('backlink/')){
    mkdir('backlink/', 0755, true);
}
file_put_contents('backlink/baclink_'.$fileStart.'_'.$fileEnd.'.xls', $columnHeader."\n",FILE_APPEND);

    while($row = $result->fetch_row())
    {
        $schema_insert = "";
        for($j=0; $j<mysqli_num_fields($result);$j++)
        {
            if(!isset($row[$j]))
                $schema_insert .= "NULL".$sep;
            elseif ($row[$j] != "")
                $schema_insert .= "$row[$j]".$sep;
            else
                $schema_insert .= "".$sep;
        }
        $schema_insert = str_replace($sep."$", "", $schema_insert);
        $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
        $schema_insert .= "\n";
        print(trim($schema_insert));
        print "\n";
        
        file_put_contents('backlink/baclink_'.$fileStart.'_'.$fileEnd.'.xls', $schema_insert,FILE_APPEND);
    }   

?>

