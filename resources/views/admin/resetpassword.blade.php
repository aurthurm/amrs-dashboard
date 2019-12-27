@extends('layouts.master')

@section('content')
    <div id="showAlert"></div>
    <div class="alert alert-danger alert-dismissible fade show ml-5 mr-5 mt-2" id="showAlertdiv" role="alert" style="display:none"><span id="showAlertIndex"></span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
    </div>

        <div class="bg-dark">
            <div class="container  m-b-30">
                <div class="row">
                    <div class="col-8 text-white p-t-40 p-b-90">
                        <h4 class="">
                           Reset Password
                        </h4>
                    </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container  pull-up">
            <div class="row">
                <div class="col-2">
                </div>
                <div class="col-6">
                    <div class="card">
                        <form class="form" action="/changePassword" method="post" id="changePassword">
                            @csrf
                            <div class="card-header">
                                <center>
                                        <h4>  Reset Password  </h4>
                                </center>
                                <div class="float-right" style="font-size:15px;"><span class="mandatory">*</span> indicates required field &nbsp;</div>
                            </div>
                            <div class="card-body mt-2">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="inputEmail4">Current Password <span class="mandatory">*</span></label>
                                        <input type="password" name="currentpassword" id="currentpassword" class="form-control isRequired" placeholder="Password"  title="Please enter your current password" onblur="checkNameValidation('users','password', this.id, 'user_id## {{session('userId')}}', 'Entered current password is wrong.')"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="inputPassword4">New Password <span class="mandatory">*</span></label>
                                            <input type="password" title="Please enter password" class="form-control isRequired" autocomplete="off" placeholder="New Password" id="password" name="password">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <label>Confirm Password <span class="mandatory">*</span></label>
                                                <input type="password" class="form-control confirmPassword" id="confirmPassword" name="password" placeholder="Confirm Password" title="Please check your password and confirm password are same"/>
                                        </div>
                                    </div>
                                </div>
                                <center>
                                    <div class="form-group mt-3">
                                        <button class="btn btn-dark" onclick="validateNow();return false;">Reset</button>
                                    </div>
                                </center>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

<script>

duplicateName = true;
function validateNow() {

    flag = deforayValidator.init({
        formId: 'changePassword'
    });

    if (flag == true) {
        if (duplicateName) {
            document.getElementById('changePassword').submit();
        }
    }
    else{
        $('#showAlert').html(flag).delay(3000).fadeOut();
        $('#showAlert').css("display","block");
    }
}

function checkNameValidation(tableName, fieldName, obj, fnct, msg)
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
            url: "{{ url('/checkValidation') }}",
            method: 'post',
            data: {
                tableName: tableName, fieldName: fieldName, value: checkValue, fnct: fnct
            },
            success: function(result){
                console.log(result)
                if (result == 0)
                {
                    $("#showAlertIndex").text(msg);
                    $('#showAlertdiv').show();
                    duplicateName = false;
                    document.getElementById(obj).value = "";
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