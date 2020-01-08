@extends('layouts.master')

@section('content')

<?php
    use App\Service\CommonService;
    $common = new Common();
    $dob = $common->humanDateFormat($data[0]->date_birth);
    $specDate = $common->humanDateFormat($data[0]->spec_date);
    $dateData = $common->humanDateFormat($data[0]->date_data);
?>

<div class="bg-dark">
    <div class="container  m-b-30">
        <div class="row">
            <div class="col-8 text-white p-t-40 p-b-90">
                <h4 class="">
                   Edit AMR Data
                </h4>
            </div>
            </div>
        </div>
    </div>
</div>

<div class="container  pull-up">
        <div id="show_alert" style=""></div>
    <div class="card">
        <form class="form" action="/amrdataUpdate" method="post" id="amrdataUpdate">
            @csrf
            <div class="card-header">
                <div class="float-right" style="font-size:15px;"><span class="mandatory">*</span> indicates required field &nbsp;</div>
            </div>
            <div class="card-body mt-2">
                
                    <div class="row">
                        <div class="form-group  col-md-6">
                            <label>Laborartory <span class="mandatory">*</span></label>
                            <div class="col-md-12">
                                <select class="form-control js-select2 isRequired" style="width:100%;" id="laboratoryName" name="laboratoryName">
                                    <option value="">Select Facility Name</option>
                                    @foreach($facilityName as $type)
                                        <option value="{{$type->facility_code}}" {{ $type->facility_code == $data[0]->laboratory ? 'selected':'' }}>{{ $type->facility_name }}({{ $type->facility_code }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- <input type="text" class="form-control isRequired" placeholder="Laboratory Name" autocomplete="off" id="laboratoryatoryName" name="laboratoryName" title="Please enter name" value="{{$data[0]->laboratory}}"> -->
                        </div>
                        <div class="form-group col-md-6">
                            <label>Origin</label>
                            <input type="text" class="form-control" placeholder="Origin Code" autocomplete="off" id="origin" name="origin" title="Please enter Origin" value="{{$data[0]->origin}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group  col-md-6">
                            <label>Patient Id</label>
                            <input type="text" class="form-control" placeholder="Patient Id" autocomplete="off" id="patientId" name="patientId"  title="Please enter valid Patient Id address" value="{{$data[0]->patient_id}}">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Gender <span class="mandatory">*</span></label>
                            <div class="form-check">
                                <label class="form-check-label mt-2">
                                    <input type="radio" class="form-check-input" {{ $data[0]->sex == 'm' ?  'checked':''}} checked name="gender" id="gender" value="m"> Male
                                </label>
                            
                                <label class="form-check-label mt-2 ml-5">
                                    <input type="radio" class="form-check-input" {{ $data[0]->sex == 'f' ?  'checked':''}} name="gender" id="gender" value="f"> Female
                                </label>

                                <label class="form-check-label mt-2 ml-5">
                                    <input type="radio" class="form-check-input" {{ $data[0]->sex == 'o' ?  'checked':''}} name="gender" id="gender" value="o"> Others
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>DOB<span class="mandatory">*</span></label>
                            <input type="text" class="js-datepicker form-control isRequired" placeholder="Select a Date" id="dob" name="dob" value="{{ $dob }}" >
                        </div>
                        <div class="form-group col-md-6">
                            <label>Age</label>
                            <input type="text" class="form-control" placeholder="Enter an Age" id="age" name="age" value="{{ $data[0]->age }}" >
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group  col-md-6">
                            <label>Patient Type</label>
                            <input type="text" class="form-control" value="{{$data[0]->pat_type}}" placeholder="Enter a patient type" id="patientType" name="patientType"  title="Please enter patient type">
                        </div>
                        <div class="form-group  col-md-6">
                            <label>Ward</label>
                             <input type="text" class="form-control" value="{{$data[0]->ward}}" placeholder="Enter the Ward" id="ward" name="ward"  title="Please enter the Ward">
                        </div>
                    </div>
                    <div class="row">
                         <div class="form-group  col-md-6">
                            <label>Institute</label>
                            <input type="text" class="form-control" value="{{$data[0]->institut}}" placeholder="Enter a Institute" id="institute" name="institute"  title="Please enter Institute">
                        </div>
                        <div class="form-group  col-md-6">
                            <label>Department</label>
                            <input type="text" class="form-control" value="{{$data[0]->department}}" placeholder="Enter the Department" id="department" name="department"  title="Please enter department">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group  col-md-6">
                            <label>Ward Type</label>
                            <input type="text" class="form-control" value="{{$data[0]->ward_type}}" placeholder="Enter a ward type" id="wardType" name="wardType"  title="Please enter ward type">
                        </div>
                        <div class="form-group  col-md-6">
                            <label>Specimen Number</label>
                            <input type="text" class="form-control" value="{{$data[0]->spec_num}}" placeholder="Enter a specimen number" id="specNum" name="specNum"  title="Please enter specimen number">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group  col-md-6">
                            <label>Specimen Date<span class="mandatory">*</span></label>
                             <input type="text" class="js-datepicker form-control isRequired" placeholder="Select a Date" id="specDate" name="specDate" value="{{ $specDate }}" >
                        </div>
                        <div class="form-group  col-md-6">
                            <label>Specimen Type</label>
                            <input type="text" class="form-control" value="{{$data[0]->spec_type}}" placeholder="Enter a specimen type" id="specType" name="specType"  title="Please enter specimen type">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group  col-md-6">
                            <label>Specimen Code</label>
                            <input type="text" class="form-control" value="{{$data[0]->spec_code}}" placeholder="Enter a specimen code" id="specCode" name="specCode"  title="Please enter specimen code">
                        </div>
                        <div class="form-group  col-md-6">
                            <label>Specimen Reas</label>
                            <input type="text" class="form-control" value="{{$data[0]->spec_reas}}" placeholder="Enter a specimen reas" id="specReas" name="specReas"  title="Please enter specimen reas">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group  col-md-6">
                            <label>Isol Number</label>
                            <input type="text" class="form-control" value="{{$data[0]->isol_num}}" placeholder="Enter a isol number" id="isolNum" name="isolNum"  title="Please enter isol number">
                        </div>
                        <div class="form-group  col-md-6">
                            <label>Organism</label>
                            <input type="text" class="form-control" value="{{$data[0]->organism}}" placeholder="Enter a organism" id="organism" name="organism"  title="Please enter organism">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group  col-md-6">
                            <label>Organism Type</label>
                            <input type="text" class="form-control" value="{{$data[0]->org_type}}" placeholder="Enter a organism type" id="orgType" name="orgType"  title="Please enter organism type">
                        </div>
                       <div class="form-group  col-md-6">
                            <label>Serotype</label>
                            <input type="text" class="form-control" value="{{$data[0]->serotype}}" placeholder="Enter a serotype" id="serotype" name="serotype"  title="Please enter serotype">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group  col-md-6">
                            <label>Beta Lact</label>
                            <input type="text" class="form-control" value="{{$data[0]->beta_lact}}" placeholder="Enter a beta lact" id="betaLact" name="betaLact"  title="Please enter beta lact">
                        </div>
                       <div class="form-group  col-md-6">
                            <label>Esbl</label>
                            <input type="text" class="form-control" value="{{$data[0]->esbl}}" placeholder="Enter a esbl" id="esbl" name="esbl"  title="Please enter esbl">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group  col-md-6">
                            <label>Carbapenem</label>
                            <input type="text" class="form-control" value="{{$data[0]->carbapenem}}" placeholder="Enter a carbapenem" id="carbapenem" name="carbapenem"  title="Please enter carbapenem">
                        </div>
                        <div class="form-group  col-md-6">
                            <label>Mrsa Screen</label>
                            <input type="text" class="form-control" value="{{$data[0]->mrsa_scrn}}" placeholder="Enter a mrsa screen" id="betaLact" name="betaLact"  title="Please enter mrsa screen">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group  col-md-6">
                            <label>Induc cli</label>
                            <input type="text" class="form-control" value="{{$data[0]->induc_cli}}" placeholder="Enter a induc cli" id="inducCli" name="inducCli"  title="Please enter induc cli">
                        </div>
                        <div class="form-group  col-md-6">
                            <label>Comment</label>
                            <input type="text" class="form-control" value="{{$data[0]->comment}}" placeholder="Enter a comment" id="comment" name="comment"  title="Please enter comment">
                        </div>
                    </div>
                    <div class="row">
                       <div class="form-group  col-md-6">
                            <label>Date Data<span class="mandatory">*</span></label>
                             <input type="text" class="js-datepicker form-control isRequired" placeholder="Select a Date" id="dateData" name="dateData" value="{{ $dateData }}" >
                        </div>
                        <div class="form-group  col-md-6">
                            <label>Amk nd30</label>
                            <input type="text" class="form-control" value="{{$data[0]->amk_nd30}}" placeholder="Enter a amk nd30" id="amknd30" name="amknd30"  title="Please enter amk nd30">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group  col-md-6">
                            <label>Amk nd30</label>
                            <input type="text" class="form-control" value="{{$data[0]->amc_nd20}}" placeholder="Enter a amk nd30" id="amcnd20" name="amcnd20"  title="Please enter amk nd30">
                        </div>
                        <div class="form-group  col-md-6">
                            <label>Amp nd10</label>
                            <input type="text" class="form-control" value="{{$data[0]->amp_nd10}}" placeholder="Enter a amp nd10" id="ampnd10" name="ampnd10"  title="Please enter amp nd10">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group  col-md-6">
                            <label>Cip nd5</label>
                            <input type="text" class="form-control" value="{{$data[0]->cip_nd5}}" placeholder="Enter a cip nd5" id="cipnd5" name="cipnd5"  title="Please enter cip nd5">
                        </div>
                        <div class="form-group  col-md-6">
                            <label>Gen nd10</label>
                            <input type="text" class="form-control" value="{{$data[0]->gen_nd10}}" placeholder="Enter a gen nd10" id="gennd10" name="gennd10"  title="Please enter gen nd10">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group  col-md-6">
                            <label>Cro nd30</label>
                            <input type="text" class="form-control" value="{{$data[0]->cro_nd30}}" placeholder="Enter a cro nd30" id="crond30" name="crond30"  title="Please enter cro nd30">
                        </div>
                        <div class="form-group  col-md-6">
                            <label>Caz nd30</label>
                            <input type="text" class="form-control" value="{{$data[0]->caz_nd30}}" placeholder="Enter a caz nd30" id="caznd30" name="caznd30"  title="Please enter caz nd30">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group  col-md-6">
                            <label>Ctx nd30</label>
                            <input type="text" class="form-control" value="{{$data[0]->ctx_nd30}}" placeholder="Enter a ctx nd30" id="ctxnd30" name="ctxnd30"  title="Please enter ctx nd30">
                        </div>
                        <div class="form-group  col-md-6">
                            <label>Fox nd30</label>
                            <input type="text" class="form-control" value="{{$data[0]->fox_nd30}}" placeholder="Enter a fox nd30" id="foxnd30" name="foxnd30"  title="Please enter fox nd30">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group  col-md-6">
                            <label>Sxt nd1 2</label>
                            <input type="text" class="form-control" value="{{$data[0]->sxt_nd1_2}}" placeholder="Enter a sxt_nd1_2" id="sxtnd12" name="sxtnd12"  title="Please enter sxt_nd1_2">
                        </div>
                    </div>
                    <a href="/amrdata" class="btn btn-default float-right mb-4 ml-4 mt-3" style="background-color:#eeeeeefa;" >Cancel</a>
                    <button type="button" class="btn btn-dark float-right mb-4 mt-3" onclick="validateNow();return false;">Update changes</button>
                    <input type="hidden" class="form-control" value="{{ $data[0]->amr_id }}" id="amrId" name="amrId"/>
                </div>
        </form>
    </div>
</div>


<script>
    $(function(){
        $( ".js-datepicker" ).datepicker({ 
        format: 'dd-M-yyyy',
        changeMonth: true,
        changeYear: true,
        autoclose: true });
    });


 duplicateName = true;
    function validateNow() {
        flag = deforayValidator.init({
            formId: 'amrdataUpdate'
        });
        
        if (flag == true) {
            if (duplicateName) {
                document.getElementById('amrdataUpdate').submit();
            }
        }
        else{
            // Swal.fire('Any fool can use a computer');
            $('#show_alert').html(flag).delay(3000).fadeOut();
            $('#show_alert').css("display","block");
        }
    }


</script>
@endsection