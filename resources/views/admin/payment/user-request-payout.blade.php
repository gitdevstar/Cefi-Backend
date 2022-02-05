@extends('admin.layout.base')

@section('title', 'User Request Payment ')

@section('content')

    <div class="content-area py-1">
        <div class="container-fluid">
            <div class="box box-block bg-white">
                <h5 class="mb-1">User Request Payment</h5>
                <table class="table table-striped table-bordered dataTable" id="table-2">
                    <thead>
                        <tr>
							<th>@lang('admin.payment.request_id')</th>
                            <th>User Name</th>                            
                            <th>Request Amount</th>
                            <th>Payable Amount</th>
                            <th>BankAccountNo</th>
							<th>BankRoutingNo</th>
							<th>BankName</th>
							<th>Wallet Balance</th>
                            <th>@lang('admin.payment.payment_status')</th>
							<th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($requestpayoutlist as $index => $payment)
                        <tr>
                            <td>{{$payment->id}}</td>                            
                            <td>{{$payment->user?$payment->user->first_name:''}} {{$payment->user?$payment->user->last_name:''}}</td>
                            <td>{{currency($payment->request_price)}}</td>
                            <td>{{currency($payment->withdraw_price)}}</td>
                            <td>{{$payment->user->payment?$payment->user->payment->bank_account_no:''}}</td>
                            <td>{{$payment->user->payment?$payment->user->payment->routing_no:''}}</td>
                            <td>{{$payment->user->payment?$payment->user->payment->bank_name:''}}</td>
                            <td>{{currency($payment->wallet_balance)}}</td>
                            <td>{{$payment->status}}</td>
							<td>
								@if($payment->status == 'unpaid')
                                <a class="btn btn-danger btn-block" href="{{ route('admin.user.updaterequestmoney', $payment->id ) }}">Pay</a>
                                @else
                                <a class="btn btn-success btn-block" href="#">Paid</a>
                                @endif
							</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>@lang('admin.payment.request_id')</th>
                            <th>User Name</th>                            
                            <th>Request Amount</th>
                            <th>Payable Amount</th>
                            <th>BankAccountNo</th>
							<th>BankRoutingNo</th>
							<th>BankName</th>
							<th>Wallet Balance</th>
                            <th>@lang('admin.payment.payment_status')</th>
							<th>Actions</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
        </div>
    </div>
@endsection