@extends('admin.layout.base')

@section('title', 'Users ')

@section('content')
<div class="content-area py-1">
    <div class="container-fluid">
        <div class="box box-block bg-white">
            <h5 class="mb-1">
                @lang('admin.users.Users')
            </h5>
            <table class="table table-striped table-bordered dataTable user-table">
                <thead>
                    <tr>
                        <th>@lang('admin.id')</th>
                        <th>@lang('admin.first_name')</th>
                        <th>@lang('admin.last_name')</th>
                        <th>@lang('admin.email')</th>
                        <th>Photo</th>
                        <th>@lang('admin.mobile')</th>
                        <th>Balance</th>
                        <th>Created At</th>
                        {{-- <th>Action</th> --}}
                    </tr>
                </thead>
                <tbody>

                </tbody>

            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
$(document).ready(function(){

    var table = $('.user-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: "{{ route('admin.user.index') }}"
        },
        order: [[0, 'desc']],
        columns: [
            {data: 'id', name: 'id'},
            {data: 'first_name', name: 'first_name', orderable: false},
            {data: 'last_name', name: 'last_name', orderable: false},
            {data: 'email', name: 'email', orderable: false},
            {data: 'photo', name: 'photo', orderable: false},
            {data: 'phone_number', name: 'phone_number', orderable: false},
            {data: 'balance', name: 'balance'},
            {data: 'created_at', name: 'created_at'},
            // {data: 'action', name: 'action', orderable: false},
        ],
        columnDefs: [
            {
                "render": function (data,type, row) {
                    return '<img src="'+data+'" width="100" />'
                },
                "targets": 4
            }
        ]
    });

  });
</script>
  @endsection
