@extends('admin.layout.base')

@section('title', 'CoinStock Withdraw')

@section('content')

    <div class="content-area py-1">
        <div class="container-fluid">
            <div class="box box-block bg-white">
                <h5 class="mb-1">Request CoinStock Withdraw</h5>
                <table class="table table-striped table-bordered dataTable" id="table-2">
                    <thead>
                        <tr>
							<th>No</th>
                            <th>User Name</th>                            
                            <th>Request Amount</th>
							<th>Coin</th>
                            <th>Payable Amount</th>
							<th>Address</th>
                            <th>Current Stocks Balance</th>
                            <th>Old Stocks Balance</th>
                            <th>Date</th>
                            <th>Status</th>
							<th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $index => $payment)
                        <tr>
                            <td>{{$index+1}}</td>                            
                            <td>{{$payment->user?$payment->user->first_name." ".$payment->user->last_name: 'No user'}}</td>
                            <td>{{$payment->req_amount}}</td>
							<td>{{$payment->coin}}</td>	
                            <td>{{currency($payment->payable_amount)}}</td>
							<td>{{$payment->address}}</td>
                            <td>{{$payment->user? currency($payment->user->stocks_balance): 0}}</td>
							<td>{{currency($payment->balance)}}</td>
							<td>{{substr($payment->updated_at, 0, 10)}}</td>
							<td>{{$payment->status}}</td>
							<td>
								@if($payment->status == 'pending')
                                    <a class="btn btn-danger btn-block" href="{{ route('admin.request.coinstock.withdraw.approve', $payment->id ) }}">Approve</a>
                                    <a class="btn btn-warning btn-block" href="{{ route('admin.request.coinstock.withdraw.unapprove', $payment->id ) }}">UnApprove</a>
                                @endif
							</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>User Name</th>                            
                            <th>Request Amount</th>
							<th>Coin</th>
                            <th>Payable Amount</th>
							<th>Address</th>
                            <th>Current Stocks Balance</th>
                            <th>Old Stocks Balance</th>
                            <th>Date</th>
                            <th>Status</th>
							<th>Actions</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
        </div>
    </div>
@endsection