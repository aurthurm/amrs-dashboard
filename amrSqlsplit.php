<?php

$DB_Server = "localhost"; //MySQL Server    
$DB_Username = "root"; //MySQL Username     
$DB_Password = "zaq12345";             //MySQL Password     
$DB_DBName = "amrs";         //MySQL Database Name  
$DB_TBLName = "amr_surveillance"; //MySQL Table Name   
$filename = "./excelfilename";         //File Name

$Connect = mysqli_connect($DB_Server, $DB_Username, $DB_Password,$DB_DBName) or die("Couldn't connect to MySQL:<br>" . mysqli_error() . "<br>" . mysqli_errno());
//select database   
$Db = mysqli_select_db($Connect,$DB_DBName) or die("Couldn't select database:<br>" . mysqli_error(). "<br>" . mysqli_errno());

$sql = "select * from amr_surveillance1";
$sqlAmr = "select * from amr_surveillance";
$sqlAmrantibiotics = "select * from amr_antibiotics";
$amrResult = $Connect->query($sqlAmr);
$amrAntiResult = $Connect->query($sqlAmrantibiotics);
$amrRowcount = mysqli_num_rows($amrResult);
$amrAntibioticsRowcount = mysqli_num_rows($amrAntiResult);
//execute query 
// $result = mysqli_query($Connect,$sql) or die("Couldn't execute query:<br>" . mysqli_error(). "<br>" . mysqli_errno());
$result = $Connect->query($sql);
// print_r(mysqli_num_fields($result));die;
while($row = $result->fetch_row())
{
    // $rows[]=$row;
    $amrRowcount++;
    $amrsurSql = 'INSERT into amr_surveillance (amr_id,country_a, laboratory, origin, patient_id, last_name, first_name, sex, date_birth, age, pat_type, ward, institut, department, ward_type, spec_num, spec_date, spec_type, spec_code, spec_reas, isol_num, organism, org_type, serotype, beta_lact, esbl, carbapenem, mrsa_scrn, induc_cli, comment, date_data) VALUES ("'.$amrRowcount.'","'.$row[1].'","'.$row[2].'","'.$row[3].'","'.$row[4].'","'.$row[5].'","'.$row[6].'","'.$row[7].'","'.$row[8].'","'.$row[9].'","'.$row[10].'","'.$row[11].'","'.$row[12].'","'.$row[13].'","'.$row[14].'","'.$row[15].'","'.$row[16].'","'.$row[17].'","'.$row[18].'","'.$row[19].'","'.$row[20].'","'.$row[21].'","'.$row[22].'","'.$row[23].'","'.$row[24].'","'.$row[25].'","'.$row[26].'","'.$row[27].'","'.$row[28].'","'.$row[29].'","'.$row[30].'")';
    $Connect->query($amrsurSql);

    for($j=31; $j<mysqli_num_fields($result);$j++)
    {
        if($row[$j]){
            $amrAntibioticsRowcount++;
            print_r($j);
            $amrAntibiotics = 'INSERT into amr_antibiotics(id,amr_id, antibiotic, value) VALUES ("'.$amrAntibioticsRowcount.'","'.$amrRowcount.'","'.mysqli_fetch_field_direct($result,$j)->name.'","'.$row[$j].'" )';
            $Connect->query($amrAntibiotics);

        }
        
        print "\n";
    }

}



?>

