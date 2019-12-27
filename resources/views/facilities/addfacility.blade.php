@extends('layouts.master')

@section('content')
{{-- {{$province}} --}}

<div class="alert alert-danger alert-dismissible fade show ml-5 mr-5 mt-2" id="showAlertdiv" role="alert" style="display:none"><span id="showAlertIndex"></span>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>

<div class="bg-dark">
    <div class="container  m-b-30">
        <div class="row">
            <div class="col-8 text-white p-t-40 p-b-90">
                <h4 class="">
                   Add Facility Details
                </h4>
            </div>
            </div>
        </div>
    </div>
</div>


<div class="container  pull-up">
    <div class="card">
        <div id="show_alert"  class="mt-4" style=""></div>
        <form class="form" action="/addfacilityStore" method="post" id="addfacilityStore">
            @csrf
            <div class="card-header">
                {{-- <center>
                      <h4>  Add Facility Details  </h4>
                </center> --}}
                <div class="float-right" style="font-size:15px;"><span class="mandatory">*</span> indicates required field &nbsp;</div>
            </div>
            <div class="card-body mt-2">
                
                    <div class="row">
                        <div class="form-group  col-md-6">
                            <label>Facility Name <span class="mandatory">*</span></label>
                            <input type="text" class="form-control isRequired" placeholder="Facility Name" autocomplete="off" id="facilityName" name="facilityName" title="Please enter name">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Facility Code <span class="mandatory">*</span></label>
                            <input type="text" class="form-control isRequired" placeholder="Facility Code" autocomplete="off" id="facilityCode" name="facilityCode" title="Please enter facility code" onblur="duplicateValidation('facilities','facility_code', this.id, 'Entered facility code is already exist.')">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group  col-md-6">
                            <label>Email <span class="mandatory">*</span></label>
                            <input type="email" class="form-control isRequired" placeholder="Email" autocomplete="off" id="email" name="email"  title="Please enter valid email address" >
                        </div>
                        <div class="form-group col-md-6">
                            <label>Facility Type <span class="mandatory">*</span></label>
                            <input type="text" class="form-control isRequired" placeholder="Facility Type" id="facilityType" name="facilityType" title="Please enter facility type"  onblur="duplicateValidation('facilities','facility_type', this.id, 'Entered facility type is already exist.')">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group  col-md-6">
                            <label>Province <span class="mandatory">*</span></label>
                            <div class="col-md-12">
                                <select class="form-control js-select2 isRequired" style="width:100%;" id="province" title="Please select province" name="province" onchange="getDistrict(this.value)">
                                        <option value="">Select Province</option>
                                    @foreach($province as $type)
                                        <option value="{{ $type->province_id }}">{{ $type->province_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>District <span class="mandatory">*</span></label>
                            <div class="col-md-12">
                                <select class="form-control js-select2 isRequired" style="width:100%;" id="district" name="district" title="Please select district">
                                    <option value="">Select District</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group  col-md-6">
                            <label>Mobile No <span class="mandatory">*</span></label>
                            <input type="tel" class="form-control isRequired" placeholder="Mobile Number" autocomplete="off" maxlength=10 id="phoneNo" name="phoneNo"  title="Please enter mobile number">
                        </div>
                        <div class="form-group  col-md-6">
                            <label>Status <span class="mandatory">*</span></label>
                            <div class="col-md-12">
                                <select class="form-control js-select2" style="width:100%;" id="status" name="status">
                                    <option value="active" selected>Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="form-group">
                            <label>Address <span class="mandatory">*</span></label>
                            <textarea class="form-control isRequired" id="addrline1" name ="addrline1" > </textarea>
                        </div>
                    </div>
                    <a href="/facilities" class="btn btn-default float-right mb-4 ml-4 mt-3" style="background-color:#eeeeeefa;" >Cancel</a>
                    <button type="button" class="btn btn-dark float-right mb-4 mt-3" onclick="validateNow();return false;">Save changes</button>
            </div>
        </form>
    </div>
</div>


<script>
 duplicateName = true;
    function validateNow() {
        flag = deforayValidator.init({
            formId: 'addfacilityStore'
        });
        
        if (flag == true) {
            if (duplicateName) {
                document.getElementById('addfacilityStore').submit();
            }
        }
        else{
            // Swal.fire('Any fool can use a computer');
            $('#show_alert').html(flag).delay(3000).fadeOut();
            $('#show_alert').css("display","block");
        }
    }

    function getDistrict(val){
        $.ajax({
            url: "{{ url('/getDistrict') }}",
            method: 'post',
            data: {
                val: val,
            },
            success: function(result){
                $('#district').html(result);
            }
        });
    }

    function duplicateValidation(tableName, fieldName, obj, msg)
    {
        // alert(fnct)
        checkValue = document.getElementById(obj).value;
        // alert(checkValue)
        if(checkValue!='')
        {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ url('/duplicateValidation') }}",
                method: 'post',
                data: {
                    tableName: tableName, fieldName: fieldName, value: checkValue,
                },
                success: function(result){
                    console.log(result)
                    if (result > 0)
                    {
                        $("#showAlertIndex").text(msg);
                        $('#showAlertdiv').show();
                        duplicateName = false;
                        document.getElementById(obj).value = "";
                        $('#'+obj).focus();
                        $('#'+obj).css('background-color', 'rgb(255, 255, 153)')
                        $('#showAlertdiv').delay(3000).fadeOut();
                    }
                    else {
                        duplicateName = true;
                    }
                }
            });
        }
    }


</script>
@endsection