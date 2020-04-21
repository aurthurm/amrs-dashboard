@extends('layouts.master')

@section('content')

<div class="bg-dark">
    <div class="container  m-b-30">
        <div class="row">
            <div class="col-8 text-white p-t-40 p-b-90">
                <h4 class="">
                   Edit Role Details
                </h4>
            </div>
            </div>
        </div>
    </div>
</div>

<div class="container  pull-up">
    
    <div class="card">
        <div class="alert alert-danger alert-dismissible fade show ml-5 mr-5 mt-2" id="showAlertdiv" role="alert" style="display:none"><span id="showAlertIndex"></span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div>
        <div id="show_alert" class="mt-4" style=""></div>
        <form class="form" action="/editrole/{{$role[0]->role_id}}" method="post" id="editrole">
            @csrf
            @php
                $fnct = "role_id##".($role[0]->role_id);
            @endphp
            <div class="card-header">
                {{-- <center>
                      <h4>  Add Role Details  </h4>
                </center> --}}
                <div class="float-right" style="font-size:15px;"><span class="mandatory">*</span> indicates required field &nbsp;</div>
            </div>
            <div class="card-body mt-2">
                
                    <div class="row">
                        <div class="form-group  col-md-6">
                            <label>Role Name <span class="mandatory">*</span></label>
                            <input type="text" value="{{$role[0]->role_name}}" class="form-control isRequired" onblur="checkNameValidation('roles', 'role_name', this.id,'{{$fnct}}', 'The role name that you entered already exist . Please enter another name.');" placeholder="Role Name" autocomplete="off" id="roleName" name="roleName" title="Please enter role name">
                        </div>
                        <div class="form-group  col-md-6">
                            <label>Role Code <span class="mandatory">*</span></label>
                            <input type="text" value="{{$role[0]->role_code}}" class="form-control isRequired" onblur="checkNameValidation('roles', 'role_code', this.id,'{{$fnct}}', 'The role code that you entered already exist . Please enter another code.');" placeholder="Role Code" autocomplete="off" id="roleCode" name="roleCode" title="Please enter role code">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Description <span class="mandatory">*</span></label>
                            <textarea class="form-control isRequired" id="description" name ="description" >{{$role[0]->role_description}}</textarea>
                        </div>
                        <div class="form-group  col-md-6">
                        <label>Status <span class="mandatory">*</span></label>
                            <div class="col-md-12">
                                <select class="form-control js-select2" style="width:100%;" id="status" name="status">
                                    <option value="active" {{ $role[0]->role_status == 'active' ?  'selected':''}}>Active</option>
                                    <option value="inactive" {{ $role[0]->role_status == 'inactive' ?  'selected':''}}>Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <b class="ml-2">Note: </b> <p class="form-control-static">Unless you choose "access" the people belonging to this role will not be able to access other rights like "add", "edit" etc.</p>
                    </div>
                    <div class = "row">
                        <label class="label-control" for="markAllOption">Check all Allowed/Denied
                            <input type="checkbox" checked data-toggle="toggle" onchange="checkAll(this);" data-on="Access" data-off="Denied" data-onstyle="dark" data-offstyle="primary">
                        </label>
                    </div>
                    <!-- <br/> -->
                    <div class = "row">
                    <?php $counter = 0; ?>
                    <?php foreach ($resourceResult as $value) { ?>
                    
                        <div class="col-md-4 col-xs-12 col-sm-12 mt-5">
                            <div class="card" style="border: 2px;border: 1px solid #2b2b50 !important;">
                                <div class="card-header " style="padding: 1rem 1.5rem; background-color:#2b2b50 !important;">
                                    <h4 class="card-title text-white"><?php echo ucwords($value->display_name);?></h4>
                                </div>
                                <div class="card-content collapse show">
                                
                                    <ul class="list-group list-group-flush">
                                    <?php foreach ($value->privilege as $privileges) { ?>
                                        <?php ++$counter; 
                                        if(isset($resourcePrivilegeMap[$role[0]->role_code][$value->resource_id][$privileges->privilege_name]) && $resourcePrivilegeMap[$role[0]->role_code][$value->resource_id][$privileges->privilege_name] == 'allow'){
                                            $allowActive = 'allow';
                                            $allowChecked = "checked";
                                        }else{
                                            $check = 0;
                                            $allowActive = 'deny';
                                            $allowChecked = "";
                                        }?>
                                        
                                        <li class="list-group-item">
                                            <label for="cekAllPrivileges<?php echo $counter;?>"><?php echo ucwords($privileges->display_name);?></label>
                                            <label class="float-right">
                                                <input type="checkbox" class="cekAllPrivileges" id="cekAllPrivileges<?php echo $counter;?>"
                                                name="resource['<?php echo $value->resource_id;?>']['<?php echo $privileges->privilege_name;?>']"
                                                value="<?php echo $allowActive;?>"
                                                data-toggle="toggle" data-on="Access" data-off="Denied" data-onstyle="dark" data-offstyle="primary"
                                                onchange='checkManual(this);' <?php echo $allowChecked;?>/>
                                            </label>
                                            
                                        </li>
                                    <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    <?php } ?>
                    </div>
                    <div class="col-md-12">
                        <a href="/roles" class="btn btn-default float-right mb-4 ml-4 mt-3" style="background-color:#eeeeeefa;" >Cancel</a>
                        <button type="button" class="btn btn-dark float-right mb-4 ml-3 mt-3" onclick="validateNow();return false;">Update Role</button>
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

function checkAll(obj){
    if ( $(obj).prop('checked') == true ) {
        $('input:checkbox').attr('checked','checked');
        $( '.cekAllPrivileges' ).val('allow');
        $( '.toggle' ).removeClass('btn btn-primary off');
        $( '.toggle' ).addClass('btn btn-dark');
    } else {
        $('input:checkbox').removeAttr('checked');
        $( '.cekAllPrivileges' ).val('deny');
        $( '.toggle' ).removeClass('btn btn-dark');
        $( '.toggle' ).addClass('btn btn-primary off');
        // $( '.toggle.off .toggle-group' ).css('left','-100px');
        // $( '.bootstrap-switch-container' ).css('margin-left','-75px');
    }
}

function checkManual(obj){
    if ( $(obj).prop('checked') == true ) {
        $( obj ).val('allow');
    } else {
        $( obj ).val('deny');
    }
}

 duplicateName = true;
    function validateNow() {
        flag = deforayValidator.init({
            formId: 'editrole'
        });
        
        if (flag == true) {
            if (duplicateName) {
                document.getElementById('editrole').submit();
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