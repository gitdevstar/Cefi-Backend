@extends('admin.layout.base')

@section('title', 'Payment Settings ')

@section('content')

<div class="content-area py-1">
    <div class="container-fluid">
    	<div class="box box-block bg-white">
			<h5>Payment Settings</h5>

            <form class="form-horizontal" action="{{ route('admin.payment.settings.store') }}" method="POST" enctype="multipart/form-data" role="form">
            	{{csrf_field()}}

				<div class="form-group row">
					<label for="coin_trade_fee" class="col-xs-2 col-form-label">Coin Trading Fee(%)</label>
					<div class="col-xs-10">
						<input class="form-control" type="text" value="{{ Setting::get('coin_trade_fee', 4)  }}" name="coin_trade_fee" required id="coin_trade_fee" placeholder="%">
					</div>
				</div>
				<div class="form-group row">
					<label for="usdc_withdraw_fee" class="col-xs-2 col-form-label">USDC Withdraw Fee (USDC)</label>
					<div class="col-xs-10">
						<input class="form-control" type="text" value="{{ Setting::get('usdc_withdraw_fee', 30)  }}" name="usdc_withdraw_fee" required id="usdc_withdraw_fee" placeholder="USDC">
					</div>
				</div>
				<div class="form-group row">
					<label for="paypal_withdraw_fee" class="col-xs-2 col-form-label">Paypal Withdraw Fee ($)</label>
					<div class="col-xs-10">
						<input class="form-control" type="text" value="{{ Setting::get('paypal_withdraw_fee', 25)  }}" name="paypal_withdraw_fee" required id="paypal_withdraw_fee" placeholder="$">
					</div>
				</div>
				<div class="form-group row">
					<label for="cash_conversation_fee" class="col-xs-2 col-form-label">Cash Conversation Fee (%)</label>
					<div class="col-xs-10">
						<input class="form-control" type="text" value="{{ Setting::get('cash_conversation_fee', 8)  }}" name="cash_conversation_fee" required id="cash_conversation_fee" placeholder="%">
					</div>
				</div>


				<div class="form-group row">
					<label for="zipcode" class="col-xs-2 col-form-label"></label>
					<div class="col-xs-10">
						<button type="submit" class="btn btn-primary">Update</button>
					</div>
				</div>
			</form>
		</div>
    </div>
</div>
@endsection
