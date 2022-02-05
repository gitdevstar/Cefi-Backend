@extends('admin.layout.base')

@section('title', 'Dashboard ')

@section('styles')
	<link rel="stylesheet" href="{{asset('main/vendor/jvectormap/jquery-jvectormap-2.0.3.css')}}">
@endsection

@section('content')

<div class="content-area py-1">
<div class="container-fluid">
    <div class="row row-md">
		<div class="col-md-4">
			<div class="box box-block bg-white tile tile-1 mb-2">
				<div class="t-icon right"><span class="bg-danger"></span><i class="ti-rocket"></i></div>
				<div class="t-content">
					<h6 class="text-uppercase mb-1">Total no. of Caronz</h6>
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="box box-block bg-white tile tile-1 mb-2">
				<div class="t-icon right"><span class="bg-danger"></span><i class="ti-rocket"></i></div>
				<div class="t-content">
					<h6 class="text-uppercase mb-1">Total no. of Market Users</h6>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="box box-block bg-white tile tile-1 mb-2">
				<div class="t-icon right"><span class="bg-danger"></span><i class="ti-rocket"></i></div>
				<div class="t-content">
					<h6 class="text-uppercase mb-1">Total no. of Wyretrade Users</h6>
				</div>
			</div>
		</div>
	</div>
	<div class="row row-md text-center">
		<div class="col-md-3">
			<div class="box box-block bg-white tile tile-1 mb-2">
				<div class="t-icon right"><span class="bg-primary"></span><i class="ti-view-grid"></i></div>
				<div class="t-content">
					<h6 class="text-uppercase mb-1">Total no. of Products</h6>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="box box-block bg-white tile tile-1 mb-2">
				<div class="t-icon right"><span class="bg-primary"></span><i class="ti-view-grid"></i></div>
				<div class="t-content">
					<h6 class="text-uppercase mb-1">Total no. of Rental Car</h6>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="box box-block bg-white tile tile-1 mb-2">
				<div class="t-icon right"><span class="bg-primary"></span><i class="ti-view-grid"></i></div>
				<div class="t-content">
					<h6 class="text-uppercase mb-1">Total no. of Hire Car</h6>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="box box-block bg-white tile tile-1 mb-2">
				<div class="t-icon right"><span class="bg-primary"></span><i class="ti-view-grid"></i></div>
				<div class="t-content">
					<h6 class="text-uppercase mb-1">Total no. of Sale Car</h6>
				</div>
			</div>
		</div>
	</div>
	<div class="row row-md text-center">
		<div class="col-md-4">
			<div class="box box-block bg-white tile tile-1 mb-2">
				<div class="t-icon right"><span class="bg-success"></span><i class="ti-bar-chart"></i></div>
				<div class="t-content">
					<h6 class="text-uppercase mb-1">PEPE remain balance for referral</h6>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="box box-block bg-white tile tile-1 mb-2">
				<div class="t-icon right"><span class="bg-success"></span><i class="ti-bar-chart"></i></div>
				<div class="t-content">
					<h6 class="text-uppercase mb-1">PEPE remain balance for stake</h6>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="box box-block bg-white tile tile-1 mb-2">
				<div class="t-icon right"><span class="bg-success"></span><i class="ti-bar-chart"></i></div>
				<div class="t-content">
					<h6 class="text-uppercase mb-1">PEPE remain balance for stocks</h6>
				</div>
			</div>
		</div>
	</div>
	<div class="row row-md text-center">

		<div class="col-lg-3 col-md-4 col-xs-6">
			<div class="box box-block bg-white tile tile-1 mb-2">
				<div class="t-icon right"><span class="bg-success"></span><i class="ti-bar-chart"></i></div>
				<div class="t-content">
					<h6 class="text-uppercase mb-1">Total Margin Amount</h6>
				</div>
			</div>
		</div>
		<div class="col-lg-3 col-md-4 col-xs-6">
			<div class="box box-block bg-white tile tile-1 mb-2">
				<div class="t-icon right"><span class="bg-success"></span><i class="ti-bar-chart"></i></div>
				<div class="t-content">
					<h6 class="text-uppercase mb-1">Today Interest Rate</h6>
				</div>
			</div>
		</div>

		<div class="col-lg-3 col-md-4 col-xs-6">
			<div class="box box-block bg-white tile tile-1 mb-2">
				<div class="t-icon right"><span class="bg-success"></span><i class="ti-bar-chart"></i></div>
				<div class="t-content">
					<h6 class="text-uppercase mb-1">balance of PEPE</h6>
				</div>
			</div>
		</div>
		<div class="col-lg-3 col-md-4 col-xs-6">
			<div class="box box-block bg-white tile tile-1 mb-2">
				<div class="t-icon right"><span class="bg-success"></span><i class="ti-bar-chart"></i></div>
				<div class="t-content">
					<h6 class="text-uppercase mb-1">balance of BNB(BSC)</h6>
				</div>
			</div>
		</div>

	</div>
	<div class="row row-md">
		<div class="col-lg-1 col-md-6 col-xs-12"></div>

		<div class="col-lg-3 col-md-6 col-xs-12">
			<div class="box box-block bg-white tile tile-1 mb-2" style="display: none">
				<div class="t-icon right"><span class="bg-warning"></span><i class="ti-rocket"></i></div>
				<div class="t-content">
					<h6 class="text-uppercase mb-1">@lang('admin.dashboard.fleets')</h6>
					<h1 class="mb-1"> </h1>
				</div>
			</div>
		</div>
		<div class="col-lg-3 col-md-6 col-xs-12">
			<div class="box box-block bg-white tile tile-1 mb-2" style="display: none">
				<div class="t-icon right"><span class="bg-success"></span><i class="ti-bar-chart"></i></div>
				<div class="t-content">
					<h6 class="text-uppercase mb-1">@lang('admin.dashboard.scheduled')</h6>
					<h1 class="mb-1"> </h1>
				</div>
			</div>
		</div>
	</div>

</div>
@endsection
