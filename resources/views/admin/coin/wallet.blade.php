@extends('admin.layout.base')

@section('title', 'Users ')

@section('styles')
<style>
    td.details-control {
        background: url('/asset/img/details_open.png') no-repeat center center;
        cursor: pointer;
    }
    tr.shown td.details-control {
        background: url('/asset/img/details_close.png') no-repeat center center;
    }
</style>
@endsection

@section('content')
<div class="content-area py-1">
    <div class="container-fluid">
        <div class="box box-block bg-white">
            <h5 class="mb-1">
                User Portfolio
            </h5>
            <table class="table table-striped table-bordered dataTable portfolio-table">
                <thead>
                    <tr>
                        <th></th>
                        <th>@lang('admin.id')</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Portfolio</th>
                        <th>Portfolio Change</th>
                        <th>Portfolio Change Percent</th>
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
// $(document).ready(function(){

    var portfolioTable = $('.portfolio-table').DataTable({
        processing: true,
        serverSide: true,
        dom: 'frtip',
        ajax: {
          url: "{{ route('admin.coin.portfolio') }}"
        },
        order: [1, 'desc'],
        columns: [
            {
                className: 'details-control',
                orderable: false,
                data: null,
                defaultContent: '',
                // width: '10%'
            },
            {data: 'id', name: 'id', searchable: false},
            {data: 'first_name', name: 'first_name', orderable: false},
            {data: 'last_name', name: 'last_name', orderable: false},
            {data: 'portfolio', name: 'portfolio', searchable: false},
            {data: 'portfolio_change', name: 'portfolio_change', orderable: false, searchable: false},
            {data: 'portfolio_change_percent', name: 'portfolio_change_percent', orderable: false, searchable: false},
        ],
        select: {
            style: 'os',
            selector: 'td:not(:first-child)'
        },
    });

// });

$('.portfolio-table tbody').on('click', 'td.details-control', function () {
    var tr = $(this).closest('tr');
    var row = portfolioTable.row( tr );

    if ( row.child.isShown() ) {
        // This row is already open - close it
        destroyChild(row);
        tr.removeClass('shown');
    }
    else {
        // Open this row
        createChild(row);
        tr.addClass('shown');
    }
} );

function createChild ( row ) {
    // This is the table we'll convert into a DataTable
    var table = $('<table id="detail-table" class="display" width="30%"/>');

    // Display it the child row
    row.child( table ).show();
    var rowData = row.data();
    // Initialise as a DataTable
    var coinsTable = table.DataTable( {
        processing: true,
        serverSide: true,
        dom: '',
        ajax: {
            url: "{{ route('admin.coin.wallet') }}",
            type: 'get',
            data: {
                'user': rowData.id,
            }
        },
        columns: [
            {title: 'Symbol', data: 'coin', name: 'coin', orderable: false},
            {title: 'Balance', data: 'balance', name: 'balance', orderable: false, searchable: false},
        ],
        select: true,
    } );
}

function destroyChild(row) {
    var table = $("table", row.child());
    table.detach();
    table.DataTable().destroy();

    // And then hide the row
    row.child.hide();
}
</script>
@endsection
