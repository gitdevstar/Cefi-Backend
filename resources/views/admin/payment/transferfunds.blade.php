@extends('admin.layout.base')

@section('title', 'Transfer Funds')

@section('content')

    <div class="content-area py-1">
        <div class="container-fluid">
            <div class="box box-block bg-white">
                <h5 class="mb-1">Coin2Stock Transfer</h5>
                <table class="table table-striped table-bordered dataTable" id="table-2">
                    <thead>
                        <tr>
							<th>No</th>
                            <th>User Name</th>                            
							<th>Coin</th>
							<th>Balance</th>
                            <th>Request Balance</th>
                            <th>Request Est.Amount</th>
                            <th>Margin Request</th>
                            <th>Stocks Balance</th>
                            <th>Date</th>
							<th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $index => $payment)
                        <tr>
                            <td>{{$index+1}}</td>                            
                            <td>{{isset($payment->user)?$payment->user['first_name']." ".$payment->user['last_name']:''}}</td>
                            <td>{{$payment->coin}}</td>
                            <td>{{$payment->user && $payment->user->coinwallet(8)&&$payment->user->coinwallet(8)->balance}}</td>
							<td>{{$payment->balance}}</td>
							<td>{{$payment->est_usdc}}</td>
							<td>{{$payment->check_margin == 1? 'True': 'False'}}</td>
                            <td>{{currency($payment->stock_balance)}}</td>
							<td>{{substr($payment->updated_at, 0, 10)}}</td>
							<td width="200px">
								@if($payment->status == 'processing')
								<div class="form-group row">
									<div class="col-xs-6">
										<a class="btn btn-info btn-block" href="{{ route('admin.request.funds.transfer.update', $payment->id ) }}">Transfer</a>
									</div>
									<div class="col-xs-6">
										<a class="btn btn-danger btn-block" href="{{ route('admin.request.funds.transfer.reject', $payment->id ) }}">Reject</a>
									</div>
								</div>
								@elseif($payment->status == 'approved')
                                <a class="btn btn-success btn-block" href="#">Approved</a>
								@else
                                <a class="btn btn-danger btn-block" href="#">Rejected</a>
                                @endif
							</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>User Name</th>                            
                            <th>Coin</th>
							<th>Balance</th>
                            <th>Request Balance</th>
                            <th>Request Est.Amount</th>
							<th>Margin Request</th>
                            <th>Stocks Balance</th>
                            <th>Date</th>
							<th>Actions</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
        </div>
    </div>
@endsection