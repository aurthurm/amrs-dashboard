@extends('layouts.master')
<style>
.dt-buttons.ui-buttonset{
    margin-left: 1rem;
}
.dt-button.ui-button.ui-state-default.ui-button-text-only.buttons-excel.buttons-html5{
    color: #fff;
    border-color: #32325d;
    background-color: #32325d;
    margin-bottom: 1rem;
}
</style>
@section('content')

        <div class="bg-dark">
            <div class="container  m-b-30">
                <div class="row">
                    <div class="col-8 text-white p-t-40 p-b-90">
                        <h4 class="">
                           AMR Surveillance Data
                        </h4>
                    </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container  pull-up">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                            @if (session('status'))
                                <div class="alert alert-success alert-dismissible fade show ml-5 mr-5 mt-4" role="alert" id="showAlertIndex" ><div class="text-center" style="font-size: 18px;"><b>
                                    {{ session('status') }}</b></div>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                </div>
                                <script>$('#showAlertIndex').delay(3000).fadeOut();</script>
                            @endif
                        <div class="card-body">
                            <div class = "row">
                                <div class ="col-md-12">
                                <a href = "/amrdata/export" class="btn btn-dark float-right">Export Data</a>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="form-group  col-md-3">
                                    <label>Facility Name </label>
                                    <div class="col-md-12">
                                        <select class="form-control js-select2 isRequired" id="facilityCode" name="facilityCode">
                                            <option value="">Select Facility Code</option>
                                            @foreach($facilityData as $type)
                                                <option value="{{ $type->facility_code }}">{{ $type->facility_name }}&nbsp;&nbsp;({{ $type->facility_code }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group  col-md-3">
                                    <label> Gender </label>
                                    <div class="col-md-12">
                                        <select class="form-control" id="gender">
                                            <option value="">Select Gender</option>
                                            <option value="m">Male</option>
                                            <option value="f">Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class=" form-group col-md-3">
                                    <label  >Select Date Range</label>
                                    <div class="m-b-10">
                                        <input type="text" id="specimenDate" name="dates" class="input-daterange form-control" >
                                    </div>
                                </div>
                                <div class="col-md-1 mt-4">
                                    <button class="btn btn-dark float-right" onclick="getFilterData();">Filter</button>
                                </div>
                                <div class="col-md-1 mt-4">
                                    <a href="/amrdata" class="btn btn-dark float-right">Reset</a>
                                </div>
                            </div>
                            
                            <br/>
                            <div class="table-responsive p-t-10">
                                <table id="amrDataTable" class="table" style="width:100%">
                                    <thead>
                                    <tr>
                                        
                                        <th>Action</th>
                                        <th>Laboratory</th>
                                        <th>Origin</th>
                                        <th>Patient Id</th>
                                        <th>Gender</th>
                                        <th>DOB</th>
                                        <th>Age</th>
                                        <th>Patient Type</th>
                                        <th>Ward</th>
                                        <th>Institute</th>
                                        <th>Department</th>
                                        <th>Ward Type</th>
                                        <th>Specimen Number</th>
                                        <th>Specimen Date</th>
                                        <th>Specimen Type</th>
                                        <th>Specimen Code</th>
                                        <th>Specimen Reas</th>
                                        <th>Isol Number</th>
                                        <th>organism</th>
                                        <th>Org Type</th>
                                        <th>Sero Type</th>
                                        <th>Beta Lact</th>
                                        <th>esbl</th>
                                        <th>carbapenem</th>
                                        <th>mrsa_scrn</th>
                                        <th>induc_cli</th>
                                        <th>comment</th>
                                        <th>date_data</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<script>

    $(document).ready(function () {
        var currentdate = new Date(); 
        var datetime =  currentdate.getDate() + "-"
                        + (currentdate.getMonth()+1)  + "-" 
                        + currentdate.getFullYear() + "-"  
                        + currentdate.getHours() + "-"  
                        + currentdate.getMinutes() + "-" 
                        + currentdate.getSeconds();
        $('.js-select2').select2();
        // $('input[name="dates"]').daterangepicker();
        var start = moment().subtract(3, 'months');
        var end = moment();

        function cb(start, end) {
            $('#specimenDate').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }
        // $('.input-daterange').daterangepicker('setDate', today);
        $('.input-daterange').daterangepicker({
            startDate: start,
            endDate: end,
            locale: { format: 'DD-MMM-YYYY' }
        }, cb);
        cb(start, end);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#amrDataTable').DataTable({
            //DataTable Options
            processing: true,
            serverSide: true,
            // responsive: true,
            // autoWidth: true,
            scrollX: true,
            
            ajax: {
                url:'{{ url("getamrdata") }}',
                type: 'POST',
            },
            dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'excel', text: 'Export',title:'AMRS-Data-'+datetime,
                    exportOptions: {
                        columns: 'th:not(:first-child)'
                    }
                }
            ],
            columns: [
                    {data: 'action', name: 'action', orderable: false},
                    { data: 'laboratory', name: 'laboratory' },
                    { data: 'origin', name: 'origin' },
                    { data: 'patient_id', name: 'patient_id' },
                    { data: 'sex', name: 'sex' },
                    { data: 'date_birth', name: 'date_birth' },
                    { data: 'age', name: 'age' },
                    { data: 'pat_type', name: 'pat_type' },
                    { data: 'ward', name: 'ward' },
                    { data: 'institut', name: 'institut' },
                    { data: 'department', name: 'department' },
                    { data: 'ward_type', name: 'ward_type' },
                    { data: 'spec_num', name: 'spec_num' },
                    { data: 'spec_date', name: 'spec_date' },
                    { data: 'spec_type', name: 'spec_type' },
                    { data: 'spec_code', name: 'spec_code' },
                    { data: 'spec_reas', name: 'spec_reas' },
                    { data: 'isol_num', name: 'isol_num' },
                    { data: 'organism', name: 'organism' },
                    { data: 'org_type', name: 'org_type' },
                    { data: 'serotype', name: 'serotype' },
                    { data: 'beta_lact', name: 'beta_lact' },
                    { data: 'esbl', name: 'esbl' },
                    { data: 'carbapenem', name: 'carbapenem' },
                    { data: 'mrsa_scrn', name: 'mrsa_scrn' },
                    { data: 'induc_cli', name: 'induc_cli' },
                    { data: 'comment', name: 'comment' },
                    { data: 'date_data', name: 'date_data' },
                    // { data: 'amk_nd30', name: 'amk_nd30' },
                    // { data: 'amc_nd20', name: 'amc_nd20' },
                    // { data: 'amp_nd10', name: 'amp_nd10' },
                    // { data: 'cip_nd5', name: 'cip_nd5' },
                    // { data: 'gen_nd10', name: 'gen_nd10' },
                    // { data: 'cro_nd30', name: 'cro_nd30' },
                    // { data: 'caz_nd30', name: 'caz_nd30' },
                    // { data: 'ctx_nd30', name: 'ctx_nd30' },
                    // { data: 'fox_nd30', name: 'fox_nd30' },
                    // { data: 'sxt_nd1_2', name: 'sxt_nd1_2' },
                ],
            order: [[0, 'desc']]
        });
        $( "#amrDataTable" ).removeClass( "no-footer" );

      
    });

    function getFilterData(){
        var currentdate = new Date(); 
        var datetime =  currentdate.getDate() + "-"
                        + (currentdate.getMonth()+1)  + "-" 
                        + currentdate.getFullYear() + "-"  
                        + currentdate.getHours() + "-"  
                        + currentdate.getMinutes() + "-" 
                        + currentdate.getSeconds();
        var specimenDate = $('#specimenDate').val();
        var facilityCode = $("#facilityCode").val();
        var gender = $("#gender").val();
        $('#amrDataTable').DataTable({
            //DataTable Options
            "destroy": true,
            // "language": {
            //     "infoEmpty": "No records available",
            // },
            processing: true,
            serverSide: true,
            // autoWidth: true,
            scrollX: true,
            scrollCollapse: false,

            ajax: {
                url: '{{ url("getFilterData") }}',
                type: 'POST',
                data: { facilityCode:facilityCode,gender:gender,specimenDate:specimenDate },
            },
            dom: 'lBfrtip',
            buttons: [
                {extend: 'excel', text: 'Export',title:'AMRS-Data-'+datetime,
                exportOptions: {
                    columns: 'th:not(:first-child)'
                }}
            ],
            columns: [
                    {data: 'action', name: 'action', orderable: false},
                    { data: 'laboratory', name: 'laboratory' },
                    { data: 'origin', name: 'origin' },
                    { data: 'patient_id', name: 'patient_id' },
                    { data: 'sex', name: 'sex' },
                    { data: 'date_birth', name: 'date_birth' },
                    { data: 'age', name: 'age' },
                    { data: 'pat_type', name: 'pat_type' },
                    { data: 'ward', name: 'ward' },
                    { data: 'institut', name: 'institut' },
                    { data: 'department', name: 'department' },
                    { data: 'ward_type', name: 'ward_type' },
                    { data: 'spec_num', name: 'spec_num' },
                    { data: 'spec_date', name: 'spec_date' },
                    { data: 'spec_type', name: 'spec_type' },
                    { data: 'spec_code', name: 'spec_code' },
                    { data: 'spec_reas', name: 'spec_reas' },
                    { data: 'isol_num', name: 'isol_num' },
                    { data: 'organism', name: 'organism' },
                    { data: 'org_type', name: 'org_type' },
                    { data: 'serotype', name: 'serotype' },
                    { data: 'beta_lact', name: 'beta_lact' },
                    { data: 'esbl', name: 'esbl' },
                    { data: 'carbapenem', name: 'carbapenem' },
                    { data: 'mrsa_scrn', name: 'mrsa_scrn' },
                    { data: 'induc_cli', name: 'induc_cli' },
                    { data: 'comment', name: 'comment' },
                    { data: 'date_data', name: 'date_data' },
                    // { data: 'amk_nd30', name: 'amk_nd30' },
                    // { data: 'amc_nd20', name: 'amc_nd20' },
                    // { data: 'amp_nd10', name: 'amp_nd10' },
                    // { data: 'cip_nd5', name: 'cip_nd5' },
                    // { data: 'gen_nd10', name: 'gen_nd10' },
                    // { data: 'cro_nd30', name: 'cro_nd30' },
                    // { data: 'caz_nd30', name: 'caz_nd30' },
                    // { data: 'ctx_nd30', name: 'ctx_nd30' },
                    // { data: 'fox_nd30', name: 'fox_nd30' },
                    // { data: 'sxt_nd1_2', name: 'sxt_nd1_2' },
                ],
            order: [[0, 'desc']]
        });
        // $.ajax({
        //     url: '{{ url("getFilterData") }}',
        //     type: 'POST',
        //     data: { facilityCode:facilityCode },
        //     success: function(response)
        //     {
        //         console.log(response);
        //     }
        // });
        $( "#amrDataTable" ).removeClass( "no-footer" );

    }

    function showAntibioticsDetails(obj,amrId) {
	    newRow = obj.parentNode.parentNode.parentNode.rowIndex+1;
	    len = document.getElementById("amrDataTable").rows[0].cells.length;
	    var x=document.getElementById("amrDataTable").insertRow(newRow);
	    cellId = "cell"+newRow;
	    x.innerHTML="<td colspan='11' id='"+cellId+"' style='border:2px solid #3c8dbc;'></td>";
	    obj.setAttribute("onclick", "hideAntibioticsDetails(this,"+amrId+")");
	    //AJAX SECTION
        $.ajax({
            url: "{{ url('/amrAntibioticsShow') }}",
            method: 'post',
            data: {
                amrId: amrId,
            },
            success: function(result){
                document.getElementById(cellId).innerHTML=result;
                $(obj).find('i').removeClass('mdi mdi-plus');
                $(obj).find('i').addClass('mdi mdi-minus');
            }
        });
    }

    function hideAntibioticsDetails(obj,amrId){
	    hideRow = obj.parentNode.parentNode.parentNode.rowIndex+1;
	    document.getElementById("amrDataTable").deleteRow(hideRow);
	    obj.setAttribute("onclick", "showAntibioticsDetails(this,"+amrId+")");
	    $(obj).find('i').removeClass('mdi mdi-minus');
	    $(obj).find('i').addClass('mdi mdi-plus');
    }

</script>

@endsection