@extends('layouts.master')
<style>
    .select2-selection__choice {
        color: black !important;
    }

    button#search_rightAll,
    button#search_rightSelected,
    button#search_leftSelected,
    button#search_leftAll {
        background-color: #e1effe;
        color: dimgray;
    }

    button#search_rightAll:hover,
    button#search_rightSelected:hover,
    button#search_leftSelected:hover,
    button#search_leftAll:hover {
        background-color: #dbe4ef;
        color: black;
        font-weight: 700;
    }

    button#search2_rightAll,
    button#search2_rightSelected,
    button#search2_leftSelected,
    button#search2_leftAll {
        background-color: #e1effe;
        color: dimgray;
    }

    button#search2_rightAll:hover,
    button#search2_rightSelected:hover,
    button#search2_leftSelected:hover,
    button#search2_leftAll:hover {
        background-color: #dbe4ef;
        color: black;
        font-weight: 700;
    }

    #search option {
        display: none;
    }
</style>
@section('content')

<div class="alert alert-danger alert-dismissible fade show ml-5 mr-5 mt-4" id="showAlertdiv" role="alert" style="display:none"><span id="showAlertIndex"></span>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>

<div class="bg-dark">
    <div class="container  m-b-30">
        <div class="row">
            <div class="col-8 text-white p-t-40 p-b-90">
                <h4 class="">
                    User Facility Map
                </h4>
            </div>
            </div>
        </div>
    </div>
</div>

<div class="container  pull-up">
        
    <div class="card">
        <div id="show_alert" style=""></div>
         @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show ml-5 mr-5 mt-4" role="alert" id="show_alert_index" ><div class="text-center" style="font-size: 18px;"><b>
                {{ session('status') }}</b></div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <script>$('#show_alert_index').delay(3000).fadeOut();</script>
        @endif
        <form class="form" action="/userfacilitymapStore" method="post" id="userfacilitymapStore">
            @csrf
            <div class="card-header">
                {{-- <center>
                      <h4> User Facility Map </h4>
                </center> --}}
                <div class="float-right" style="font-size:15px;"><span class="mandatory">*</span> indicates required field &nbsp;</div>
            </div>
            <div class="card-body mt-3">
                <div class="row mt-2">
                    <div class="col-md-2">
                        <label>User <span class="mandatory">*</span></label>
                    </div>
                    <div class="col-md-6">
                        <select class="form-control isRequired" id="userId" name="userId" title="Please select an user" onchange="getuserfacilitymapById(this.value)">
                            <option value="">Select User</option>
                            @foreach($users as $type)
                                <option value="{{ $type->user_id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <br/>
                <div class="display-fields mt-5">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="">Facilities<span class="mandatory">*</span></label>
                        <div class="col-sm-4">
                            {{-- <input type="text" name="q2" class="form-control" placeholder="Search..."> --}}
                            <select id="search2" class="form-control" size="8" multiple="multiple" placeholder="Select Facility Code" title="Please select Facility Code">
                                 @foreach($facilities as $type)
                            <option value="{{ $type->facility_id }}">{{ $type->facility_code }}  -  {{ $type->facility_name }}</option>
                                @endforeach
                            </select>
                        </div>
                
                        <div class="col-md-2">
                            <button type="button" id="search2_rightAll" onclick="setReqValue()" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i> &gt;&gt; </button>
                            <button type="button" id="search2_rightSelected" onclick="setReqValue()" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"> &gt; </i></button>
                            <button type="button" id="search2_leftSelected" onclick="setDisplayValue()" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i>
                                &lt; </button> <button type="button" id="search2_leftAll" onclick="setDisplayValue()" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i>
                                    &lt;&lt; </button> </div> <div class="col-sm-4">
                                        {{-- <input type="text" name="q2" class="form-control" placeholder="Search..."> --}}
                            <select name="to2[]" id="search2_to" class="form-control" size="8" multiple="multiple">
                            </select>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="facilityid" id="facilityid" />
                <input type="hidden" name="facilitycode" id="facilitycode" />
                
                <button type="button" class="btn btn-dark float-right mb-4 mt-4" onclick="validateNow();return false;">Submit</button>
            </div>
        </form>
    </div>
</div>

<script src="{{asset('/assets/js/multiselect.min.js') }}"></script>
<script>
 duplicateName = true;
    function validateNow() {
        setDisplayValue();
        $('#search2_to option').each(function(j, selected) {
            selVal2[j] = $(selected).val();
            // selDataValue2[j] = selected.attributes['data-index'].nodeValue;
        });
        $("#facilityid").val(selVal2);
        // $("#facilitycode").val(selDataValue2);
        flag = deforayValidator.init({
            formId: 'userfacilitymapStore'
        });
        if (flag == true) {
            if (duplicateName) {
                document.getElementById('userfacilitymapStore').submit();
            }
        }
        else{
            // Swal.fire('Any fool can use a computer');
            $('#show_alert').html(flag) .delay(3000).fadeOut();
            $('#show_alert').css("display","block");
        }
    }

var selVal = [];
var selDataValue = [];

var selVal2 = [];
var selDataValue2 = [];

$(document).ready(function($) {


$('#search2').multiselect({
    search: {
        left: '<input type="text" name="q2" class="form-control" placeholder="Search..." />',
        right: '<input type="text" name="q2" class="form-control" placeholder="Search..." />',
    },
    fireSearch: function(value) {
        return value.length > 0;
    },
    sort: false,
});

$("#search2_rightAll").click(function() {
    setReqValue();
});
$("#search2_rightSelected").click(function() {
    setReqValue();
});
$("#search2_leftSelected").click(function() {
    setReqValue();
});
$("#search2_leftAll").click(function() {
    setReqValue();
});
$("#search_rightAll").click(function() {
    setReqValue();
});
$("#search_rightSelected").click(function() {
    setReqValue();
});
$("#search_leftSelected").click(function() {
    setDisplayValue();
});
$("#search_leftAll").click(function() {
    setDisplayValue();
});

setReqValue();
setDisplayValue();
});

function setDisplayValue() {
var seletedVal = [];

$('#search option').each(function(i, selected) {
    seletedVal[i] = $(selected).val();
});


$('#search2 option').each(function(j, selected) {
    var atrIndex = $("#search_to option[value='" + $(selected).val() + "']").attr('data-index');
    if (seletedVal.indexOf($(selected).val()) == "-1") {
        $("#search").append("<option data-index='" + atrIndex + "' value='" + $(selected).val() + "'>" + $(selected).val() + "</option>");
    }
    $("#search_to option[value='" + $(selected).val() + "']").remove();
});
setReqValue();
}

function setReqValue() {
//first get all search_to options
$('#search2 option').each(function(j, selected) {
    $("#search option[value='" + $(selected).val() + "']").hide();
    $("#search_to option[value='" + $(selected).val() + "']").hide();
});
$('#search2_to option').each(function(j, selected) {
    $("#search option[value='" + $(selected).val() + "']").show();
    $("#search_to option[value='" + $(selected).val() + "']").show();
    //$("#search").find('option[value="'+$(selected).val()+'"]').show();
});

}


function getuserfacilitymapById(val){
    // $('#search2_to').html('');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "{{ url('/getuserfacilitymapById') }}",
        method: 'post',
        data: {
            val: val,
        },
        success: function(result){
            console.log(result);
            $('#search2_to').html(result['options'])
            var selectobject = document.getElementById("search2");
            for(i=0;i<result['removeoptions'].length;i++){
                $("#search2 option[value='"+result['removeoptions'][i]['facility_id']+"']").remove();
            }
        }
    });
}

</script>
@endsection