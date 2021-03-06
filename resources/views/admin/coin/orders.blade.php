@extends('admin.layout.base')

@section('title', 'Users ')

@section('content')
<div class="content-area py-1">
    <div class="container-fluid">
        <div class="box box-block bg-white">
            <h5 class="mb-1">
                Coin Order History
            </h5>
            <table class="table table-striped table-bordered dataTable order-table">
                <thead>
                    <tr>
                        <th>@lang('admin.id')</th>
                        <th>User</th>
                        <th>Pair</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Side</th>
                        <th>Status</th>
                        <th>Price</th>
                        <th>Txn ID</th>
                        <th>Updated At</th>
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

    var table = $('.order-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: "{{ route('admin.coin.order.history') }}"
        },
        order: [[0, 'desc']],
        columns: [
            {data: 'id', name: 'id', searchable: false},
            {data: 'user_id', name: 'user_id', orderable: false},
            {data: 'pair', name: 'pair', orderable: false},
            {data: 'type', name: 'type', orderable: false, searchable: false},
            {data: 'amount', name: 'amount', orderable: false, searchable: false},
            {data: 'side', name: 'side', orderable: false, searchable: false},
            {data: 'status', name: 'status', orderable: false, searchable: false},
            {data: 'price', name: 'price', orderable: false, searchable: false},
            {data: 'txn_id', name: 'txn_id', orderable: false, searchable: false},
            {data: 'updated_at', name: 'updated_at', searchable: false},
        ],
    });

  });
</script>
  @endsection
