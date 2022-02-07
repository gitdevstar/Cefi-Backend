@extends('admin.layout.base')

@section('title', 'Users ')

@section('content')
<div class="content-area py-1">
    <div class="container-fluid">
        <div class="box box-block bg-white">
            <h5 class="mb-1">
                Withdraw History
            </h5>
            <table class="table table-striped table-bordered dataTable withdraw-table">
                <thead>
                    <tr>
                        <th>@lang('admin.id')</th>
                        <th>User</th>
                        <th>To</th>
                        <th>Amount</th>
                        <th>Kind</th>
                        <th>Status</th>
                        <th>Txn ID</th>
                        <th>Updated At</th>
                        <th>Action</th>
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

    var table = $('.withdraw-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: "{{ route('admin.withdraw') }}"
        },
        order: [[0, 'desc']],
        columns: [
            {data: 'id', name: 'id', searchable: false},
            {data: 'user_id', name: 'user_id', orderable: false},
            {data: 'to', name: 'to', orderable: false},
            {data: 'amount', name: 'amount', orderable: false, searchable: false},
            {data: 'kind', name: 'kind', orderable: false, searchable: false},
            {data: 'status', name: 'status', orderable: false, searchable: false},
            {data: 'txn_id', name: 'txn_id', orderable: false, searchable: false},
            {data: 'updated_at', name: 'updated_at, searchable: false'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
    });

  });
</script>
  @endsection
