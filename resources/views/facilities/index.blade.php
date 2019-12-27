@extends('layouts.master')

@section('content')

        <div class="bg-dark">
            <div class="container  m-b-30">
                <div class="row">
                    <div class="col-8 text-white p-t-40 p-b-90">
                        <h4 class="">
                           Facilities Details
                        </h4>
                    </div>
                    <div class="col-4 text-white p-t-40 p-b-90">
                        <a href="/addfacility" class="btn btn-light float-right"><i class="mdi mdi-account-plus mr-2"></i>Add Facility</a>
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
                                <div class="alert alert-success alert-dismissible fade show ml-5 mr-5 mt-4" role="alert" id="show_alert_index" ><div class="text-center" style="font-size: 18px;"><b>
                                    {{ session('status') }}</b></div>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                </div>
                                <script>$('#show_alert_index').delay(3000).fadeOut();</script>
                            @endif
                        <div class="card-body">
                           
                            <div class="table-responsive p-t-10">
                                <table id="example_tbl" class="table   " style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Province</th>
                                        <th>District</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Province</th>
                                        <th>District</th>
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#example_tbl').DataTable({
            //DataTable Options
            processing: true,
            serverSide: true,
            //  ajax: {
            //   url:  '{!! url("user.index") !!}',
            //   type: 'POST',
            //  },
            ajax: {
                url:'{{ url("getfacility") }}',
                type: 'POST',
            },
            columns: [
                    
                    { data: 'facility_name', name: 'facility_name' },
                    { data: 'email', name: 'email' },
                    { data: 'phone', name: 'phone' },
                    { data: 'province', name: 'province' },
                    { data: 'district', name: 'district' },
                    { data: 'status', name: 'status' },
                    {data: 'action', name: 'action', orderable: false},
                ],
            order: [[0, 'desc']]
        });
      
    });

</script>

@endsection