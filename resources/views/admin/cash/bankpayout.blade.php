@extends('admin.layout.base')

@section('title', 'Bank Payout Transactions')

@section('content')
<div class="content-area py-1">
    <div class="container-fluid">
        <div class="box box-block bg-white">
            <h5 class="mb-1">
                Mobile Payout Transactions
            </h5>
            <table class="table table-striped table-bordered dataTable bankpayout-table">
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
$(document).ready(function(){

    var table = $('.bankpayout-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: "{{ route('admin.cash.bankpayout.history') }}"
        },
        // order: [[0, 'desc']],
        columns: [
            {title: 'ID', data: 'id', name: 'id', searchable: false},
            {title: 'User', data: 'user_id', name: 'user_id', orderable: false},
            {title: 'Network', data: 'network', name: 'network', orderable: false},
            {title: 'Account Bank', data: 'account_bank', name: 'account_bank', orderable: false},
            {title: 'Account Number', data: 'account_number', name: 'account_number', orderable: false},
            {title: 'Currency', data: 'currency', name: 'currency', orderable: false, searchable: false},
            {title: 'Amount', data: 'amount', name: 'amount', orderable: false, searchable: false},
            {title: 'Fee', data: 'fee', name: 'fee', orderable: false, searchable: false},
            {title: 'Phone', data: 'phone', name: 'phone', orderable: false, searchable: false},
            {title: 'Status', data: 'status', name: 'status', orderable: false, searchable: false},
            {title: 'TXN ID', data: 'txn_id', name: 'txn_id', orderable: false, searchable: false},
            {title: 'TXN REF', data: 'tx_ref', name: 'tx_ref', orderable: false, searchable: false},
            {title: 'Updated At', data: 'updated_at', name: 'updated_at', searchable: false},
        ],
    });

  });
</script>
  @endsection
