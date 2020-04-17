@extends('layouts.master')

@section('content')

<div class="alert alert-danger alert-dismissible fade show ml-5 mr-5 mt-2" id="showAlertdiv" role="alert" style="display:none"><span id="showAlertIndex"></span>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
</div>

<div class="bg-dark">
    <div class="container  m-b-30">
        <div class="row">
            <div class="col-8 text-white p-t-40 p-b-90">
                <h4 class="">
                   Add User Details
                </h4>
            </div>
            </div>
        </div>
    </div>
</div>

<div class="container  pull-up">
    <div class="card">
        <div id="show_alert" class="mt-4" style=""></div>
        <form class="form" action="/adduserStore" method="post" id="adduserStore">
            @csrf
            <div class="card-header">
                {{-- <center>
                      <h4>  Add User Details  </h4>
                </center> --}}
                <div class="float-right" style="font-size:15px;"><span class="mandatory">*</span> indicates required field &nbsp;</div>
            </div>
            <div class="card-body mt-2">
                
                    <div class="row">
                        <div class="form-group  col-md-6">
                            <label>Name <span class="mandatory">*</span></label>
                            <input type="text" class="form-control isRequired" placeholder="Name" autocomplete="off" id="name" name="name" title="Please enter name">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Gender <span class="mandatory">*</span></label>
                            <div class="form-check">
                                <label class="form-check-label mt-2">
                                    <input type="radio" class="form-check-input" checked="true" name="gender" id="gender" value="male"> Male
                                </label>
                            
                                <label class="form-check-label mt-2 ml-5">
                                    <input type="radio" class="form-check-input" name="gender" id="gender" value="female"> Female
                                </label>

                                <label class="form-check-label mt-2 ml-5">
                                    <input type="radio" class="form-check-input" name="gender" id="gender" value="others"> Others
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group  col-md-6">
                            <label>Email <span class="mandatory">*</span></label>
                            <input type="email" class="form-control isRequired" placeholder="Email" autocomplete="off" id="email" name="email"  title="Please enter valid email address" onblur="duplicateValidation('users','email', this.id, 'Entered email is already exist.')" >
                        </div>
                        <div class="form-group col-md-6">
                            <label>DOB</label>
                            <input type="text" class="js-datepicker form-control" placeholder="Select a Date" id="dob" name="dob" >
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group  col-md-6">
                            <label>Password <span class="mandatory">*</span></label>
                            <input type="password" title="Please enter password" class="form-control isRequired" autocomplete="off" placeholder="Password" id="password" name="password">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Confirm Password <span class="mandatory">*</span></label>
                            <input type="password" class="form-control confirmPassword" id="confirmPassword" name="password" placeholder="Password" title="Please check your password and confirm password are same"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group  col-md-6">
                            <label>Mobile No <span class="mandatory">*</span></label>
                            <input type="tel" class="form-control isRequired" placeholder="Mobile Number" autocomplete="off" maxlength=10 id="phoneNo" name="phoneNo"  title="Please enter mobile number">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Alt Mobile No</label>
                            <input type="tel" class="form-control"  placeholder="Alt Mobile Number" autocomplete="off" maxlength=10 id="altPhoneNo" name="altPhoneNo"  title="Please enter alternate mobile number">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group  col-md-6">
                            <label>User Name <span class="mandatory">*</span></label>
                            <input type="text" class="form-control isRequired" title="Please enter an username" autocomplete="off" placeholder="User Name" id="username" name="username">
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
                        <div class="form-group  col-md-6">
                            <label>Roles <span class="mandatory">*</span></label>
                            <div class="col-md-12">
                                <select class="form-control js-select2" style="width:100%;" id="roleId" name="roleId">
                                    <option value="">Select Role</option>
                                    @foreach($role as $roles)
                                        <option value="{{ $roles->role_id }}">{{ $roles->role_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Address <span class="mandatory">*</span></label>
                            <textarea class="form-control isRequired" id="addrline1" name ="addrline1" > </textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <a href="/user" class="btn btn-default float-right mb-4 ml-4 mt-3" style="background-color:#eeeeeefa;" >Cancel</a>
                        <button type="button" class="btn btn-dark float-right mb-4 ml-3 mt-3" onclick="validateNow();return false;">Add User</button>
                    </div>
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
            formId: 'adduserStore'
        });
        
        if (flag == true) {
            if (duplicateName) {
                document.getElementById('adduserStore').submit();
            }
        }
        else{
            // Swal.fire('Any fool can use a computer');
            $('#show_alert').html(flag).delay(3000).fadeOut();
            $('#show_alert').css("display","block");
        }
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