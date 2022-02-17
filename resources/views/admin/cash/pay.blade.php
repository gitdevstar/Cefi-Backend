@extends('admin.layout.base')

@section('title', 'Users ')

@section('content')
<div class="content-area py-1">
    <div class="container-fluid">
        <div class="box box-block bg-white">
            <h5 class="mb-1">
                Cash Pay History
            </h5>
            <table class="table table-striped table-bordered dataTable pay-table">
                <thead>
                    <tr>
                        <th>@lang('admin.id')</th>
                        <th>Sender</th>
                        <th>Receiver</th>
                        <th>Amount</th>
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

    var table = $('.pay-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: "{{ route('admin.cash.pay.history') }}"
        },
        order: [[0, 'desc']],
        columns: [
            {data: 'id', name: 'id', searchable: false},
            {data: 'sender_id', name: 'sender_id', orderable: false},
            {data: 'receiver_id', name: 'receiver_id', orderable: false},
            {data: 'amount', name: 'amount', orderable: false, searchable: false},
            {data: 'updated_at', name: 'updated_at', searchable: false},
        ],
    });

  });
</script>
  @endsection
