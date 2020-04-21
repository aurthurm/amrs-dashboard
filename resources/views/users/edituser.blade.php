@extends('layouts.master')

@section('content')
<?php
    use App\Service\CommonService;
    $common = new CommonService();
    $dob = $common->humanDateFormat($data[0]->dob);
?>
<div class="bg-dark">
    <div class="container  m-b-30">
        <div class="row">
            <div class="col-8 text-white p-t-40 p-b-90">
                <h4 class="">
                   Edit User Details
                </h4>
            </div>
            </div>
        </div>
    </div>
</div>

<div class="container  pull-up">
        
    <div class="card">
        <div id="show_alert" style=""></div>
        <div class="alert alert-danger alert-dismissible fade show ml-5 mr-5 mt-2" id="showAlertdiv" role="alert" style="display:none"><span id="showAlertIndex"></span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div>
        <form class="form" action="/edituserUpdate" method="post" id="edituserUpdate">
            @csrf
            @php
                $fnct = "user_id##".($data[0]->user_id);
            @endphp
            <div class="card-header">
                <!-- <center>
                      <h4>  Edit User Details  </h4>
                </center> -->
                <div class="float-right" style="font-size:15px;"><span class="mandatory">*</span> indicates required field &nbsp;</div>
            </div>
            <div class="card-body mt-2">
                
                    <div class="row">
                        <div class="form-group  col-md-6">
                            <label>Name <span class="mandatory">*</span></label>
                            <input type="text" class="form-control isRequired" placeholder="Name" autocomplete="off" id="name" name="name" title="Please enter name" value="{{ $data[0]->name }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Gender <span class="mandatory">*</span></label>
                            <div class="form-check">
                                <label class="form-check-label mt-2">
                                    <input type="radio" class="form-check-input" {{ $data[0]->gender == 'male' ?  'checked':''}} checked name="gender" id="gender" value="male"> Male
                                </label>
                            
                                <label class="form-check-label mt-2 ml-5">
                                    <input type="radio" class="form-check-input" {{ $data[0]->gender == 'female' ?  'checked':''}} name="gender" id="gender" value="female"> Female
                                </label>

                                <label class="form-check-label mt-2 ml-5">
                                    <input type="radio" class="form-check-input" {{ $data[0]->gender == 'others' ?  'checked':''}} name="gender" id="gender" value="others"> Others
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group  col-md-6">
                            <label>Email <span class="mandatory">*</span></label>
                            <input type="email" class="form-control isEmail" placeholder="Email" autocomplete="off" id="email" name="email" onblur="checkNameValidation('users', 'email', this.id,'{{$fnct}}', 'The email id that you entered already exist . Please enter another email.');" value="{{ $data[0]->email }}"  title="Please enter valid email address" >
                        </div>
                        <div class="form-group col-md-6">
                            <label>DOB</label>
                            <input type="text" class="js-datepicker form-control" placeholder="Select a Date" id="dob" name="dob" value="{{ $dob }}" >
                        </div>
                    </div>
                   
                    <div class="row">
                        <div class="form-group  col-md-6">
                            <label>Mobile No <span class="mandatory">*</span></label>
                            <input type="tel" class="form-control isRequired" placeholder="Mobile Number" value="{{ $data[0]->phone }}" autocomplete="off" maxlength=10 id="phoneNo" name="phoneNo"  title="Please enter mobile number">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Alt Mobile No</label>
                            <input type="tel" class="form-control"  placeholder="Alt Mobile Number" value="{{ $data[0]->alt_phone }}" autocomplete="off" maxlength=10 id="altPhoneNo" name="altPhoneNo"  title="Please enter alternate mobile number">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group  col-md-6">
                            <label>User Name <span class="mandatory">*</span></label>
                            <input type="text" class="form-control isRequired" title="Please enter username" value="{{ $data[0]->username }}" autocomplete="off" placeholder="User Name" id="username" name="username">
                        </div>
                        <div class="form-group  col-md-6">
                            <label>Status <span class="mandatory">*</span></label>
                            <div class="col-md-12">
                                <select class="form-control js-select2" style="width:100%;" id="status" name="status">
                                    <option value="active" {{ $data[0]->status == 'active' ?  'selected':''}}>Active</option>
                                    <option value="inactive" {{ $data[0]->status == 'inactive' ?  'selected':''}}>Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group  col-md-6">
                            <label>Roles <span class="mandatory">*</span></label>
                            <div class="col-md-12">
                                <select class="form-control js-select2" style="width:100%;" id="roleId" name="roleId">
                                    <option value="">Select Role</option>
                                    @foreach($role as $roles)
                                        <option value="{{ $roles->role_id }}" {{ $data[0]->role_id == $roles->role_id ?  'selected':''}}>{{ $roles->role_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    <div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea class="form-control isRequired" id="addrline1" name ="addrline1"  >{{ $data[0]->address }}</textarea>
                        </div>
                    </div>
                    <a href="/user" class="btn btn-default float-right mb-4 ml-4 mt-3" style="background-color:#eeeeeefa;" >Cancel</a>
                    <button type="button" class="btn btn-dark float-right mb-4 mt-3" onclick="validateNow();return false;">Update user</button>
                    <input type="hidden" class="form-control" value="{{ $data[0]->user_id }}" id="userId" name="userId"/>
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
            formId: 'edituserUpdate'
        });
        
        if (flag == true) {
            if (duplicateName) {
                document.getElementById('edituserUpdate').submit();
            }
        }
        else{
            // Swal.fire('Any fool can use a computer');
            $('#show_alert').html(flag).delay(3000).fadeOut();
            $('#show_alert').css("display","block");
        }
    }
    function checkNameValidation(tableName, fieldName, obj, fnct, msg){
        checkValue = document.getElementById(obj).value;
    	if($.trim(checkValue)!= ''){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ url('/checkNameValidation') }}",
                method: 'post',
                data: {
                    tableName: tableName, fieldName: fieldName, value: checkValue,fnct: fnct,
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