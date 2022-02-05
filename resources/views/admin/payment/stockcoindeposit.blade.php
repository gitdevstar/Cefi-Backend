@extends('admin.layout.base')

@section('title', 'CoinStock Deposit')

@section('content')

    <div class="content-area py-1">
        <div class="container-fluid">
            <div class="box box-block bg-white">
                <h5 class="mb-1">Request CoinStock Deposit</h5>
                <table class="table table-striped table-bordered dataTable" id="table-2">
                    <thead>
                        <tr>
							<th>No</th>
                            <th>User Email</th>                            
                            <th>Amount</th>
							<th>Coin</th>
							<th>Address</th>
                            <th>TXN ID</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $index => $payment)
                        <tr>
                            <td>{{$index+1}}</td>                            
                            <td>{{$payment->email}}</td>
                            <td>{{currency($payment->amount1)}}</td>
							<td>{{$payment->currency1}}</td>							
							<td>{{$payment->address}}</td>							
                            <td>{{$payment->txn_id}}</td>
							<td>{{substr($payment->updated_at, 0, 10)}}</td>
							
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>User Email</th>                            
                            <th>Amount</th>
							<th>Coin</th>
							<th>Address</th>
                            <th>TXN ID</th>
                            <th>Date</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
        </div>
    </div>
@endsection