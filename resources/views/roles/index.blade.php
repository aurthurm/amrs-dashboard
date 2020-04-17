@extends('layouts.master')

@section('content')

        <div class="bg-dark">
            <div class="container  m-b-30">
                <div class="row">
                    <div class="col-8 text-white p-t-40 p-b-90">
                        <h4 class="">
                           Roles Details
                        </h4>
                    </div>
                    <div class="col-4 text-white p-t-40 p-b-90">
                        <a href="/addrole" class="btn btn-light float-right"><i class="mdi mdi-account-plus mr-2"></i>Add Role</a>
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
                           
                            <div class="table-responsive p-t-10">
                                <table id="rolesList" class="table   " style="width:100%">
                                <thead>
                                    <tr>
                                        <th style="display: none">Role Id</th>
                                        <th>Role Name</th>
                                        <th>Role Code</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th style="display: none">Role Id</th>
                                        <th>Role Name</th>
                                        <th>Role Code</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<script>

    $(document).ready(function () {
        getRole();
        
      
    });
    function getRole() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $('#rolesList').DataTable({
      processing: true,
      destroy: true,
      serverSide: true,
      scrollX: false,
      autoWidth: false,
      ajax: {
        url: '{{ url("getRole") }}',
        type: 'POST',
      },
      columns: [
                    
                    { data: 'role_id', name: 'role_id', visible: false },
                    { data: 'role_name', name: 'role_name',className : 'firstcaps' },
                    { data: 'role_code', name: 'role_code' },
                    { data: 'role_status', name: 'role_status',className : 'firstcaps' },
                    {data: 'action', name: 'action', orderable: false},
                ],
      order: [
        [0, 'desc']
      ]
    });
  }

</script>

@endsection