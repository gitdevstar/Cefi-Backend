@extends('admin.layout.base')

@section('title', 'Site Settings ')

@section('content')

<div class="content-area py-1">
    <div class="container-fluid">
    	<div class="box box-block bg-white">
			<h5>@lang('admin.setting.Site_Settings')</h5>

            <form class="form-horizontal" action="{{ route('admin.settings.store') }}" method="POST" enctype="multipart/form-data" role="form">
            	{{csrf_field()}}

				<div class="form-group row">
					<label for="site_title" class="col-xs-2 col-form-label">@lang('admin.setting.Site_Name')</label>
					<div class="col-xs-10">
						<input class="form-control" type="text" value="{{ Setting::get('site_title', 'Ryder')  }}" name="site_title" required id="site_title" placeholder="Site Name">
					</div>
				</div>

				<div class="form-group row">
					<label for="site_logo" class="col-xs-2 col-form-label">@lang('admin.setting.Site_Logo')</label>
					<div class="col-xs-10">
						@if(Setting::get('site_logo')!='')
	                    <img style="height: 90px; margin-bottom: 15px;" src="{{ Setting::get('site_logo', asset('logo-black.png')) }}">
	                    @endif
						<input type="file" accept="image/*" name="site_logo" class="dropify form-control-file" id="site_logo" aria-describedby="fileHelp">
					</div>
				</div>


				<div class="form-group row">
					<label for="site_icon" class="col-xs-2 col-form-label">@lang('admin.setting.Site_Icon')</label>
					<div class="col-xs-10">
						@if(Setting::get('site_icon')!='')
	                    <img style="height: 90px; margin-bottom: 15px;" src="{{ Setting::get('site_icon') }}">
	                    @endif
						<input type="file" accept="image/*" name="site_icon" class="dropify form-control-file" id="site_icon" aria-describedby="fileHelp">
					</div>
				</div>

                <div class="form-group row">
                    <label for="site_copyright" class="col-xs-2 col-form-label">@lang('admin.setting.Copyright_Content')</label>
                    <div class="col-xs-10">
                        <input class="form-control" type="text" value="{{ Setting::get('site_copyright', '&copy; '.date('Y').' Joiint') }}" name="site_copyright" id="site_copyright" placeholder="Site Copyright">
                    </div>
                </div>
				
				<div class="form-group row">
                    <label for="store_link_android" class="col-xs-2 col-form-label">App Download URL</label>
                    <div class="col-xs-10">
                        <input class="form-control" type="text" value="{{ Setting::get('store_link_android') }}" name="store_link_android" id="store_link_android" placeholder="App Download URL">
                    </div>
                </div>

				

				<div class="form-group row">
					<label for="provider_select_timeout" class="col-xs-2 col-form-label">@lang('admin.setting.Provider_Accept_Timeout')</label>
					<div class="col-xs-10">
						<input class="form-control" type="number" value="{{ Setting::get('provider_select_timeout', '60')  }}" name="provider_select_timeout" required id="provider_select_timeout" placeholder="Provider Timout">
					</div>
				</div>

				<div class="form-group row">
					<label for="provider_search_radius" class="col-xs-2 col-form-label">@lang('admin.setting.Provider_Search_Radius')</label>
					<div class="col-xs-10">
						<input class="form-control" type="number" value="{{ Setting::get('provider_search_radius', '100')  }}" name="provider_search_radius" required id="provider_search_radius" placeholder="Provider Search Radius">
					</div>
				</div>

				<div class="form-group row">
					<label for="sos_number" class="col-xs-2 col-form-label">@lang('admin.setting.SOS_Number')</label>
					<div class="col-xs-10">
						<input class="form-control" type="number" value="{{ Setting::get('sos_number', '911')  }}" name="sos_number" required id="sos_number" placeholder="SOS Number">
					</div>
				</div>

				<div class="form-group row">
					<label for="contact_number" class="col-xs-2 col-form-label">@lang('admin.setting.Contact_Number')</label>
					<div class="col-xs-10">
						<input class="form-control" type="number" value="{{ Setting::get('contact_number', '911')  }}" name="contact_number" required id="contact_number" placeholder="Contact Number">
					</div>
				</div>

				<div class="form-group row">
					<label for="contact_email" class="col-xs-2 col-form-label">@lang('admin.setting.Contact_Email')</label>
					<div class="col-xs-10">
						<input class="form-control" type="email" value="{{ Setting::get('contact_email', '')  }}" name="contact_email" required id="contact_email" placeholder="Contact Email">
					</div>
				</div>


				<div class="form-group row">
					<label for="map_key" class="col-xs-2 col-form-label">@lang('admin.setting.map_key')</label>
					<div class="col-xs-10">
						<input class="form-control" type="text" value="{{ Setting::get('map_key')  }}" name="map_key" required id="map_key" placeholder="@lang('admin.setting.map_key')">
					</div>
				</div>
				
				<div class="form-group row">
					<label for="twilio_account_sid" class="col-xs-2 col-form-label">Twilio Account SID</label>
					<div class="col-xs-10">
						<input class="form-control" type="text" value="{{ Setting::get('twilio_account_sid')  }}" name="twilio_account_sid" required id="twilio_account_sid" placeholder="">
					</div>
				</div>
				
				<div class="form-group row">
					<label for="twilio_auth_token" class="col-xs-2 col-form-label">Twilio Auth Token</label>
					<div class="col-xs-10">
						<input class="form-control" type="text" value="{{ Setting::get('twilio_auth_token')  }}" name="twilio_auth_token" required id="twilio_auth_token" placeholder="">
					</div>
				</div>
				
				<div class="form-group row">
					<label for="twilio_number" class="col-xs-2 col-form-label">Twilio Number</label>
					<div class="col-xs-10">
						<input class="form-control" type="text" value="{{ Setting::get('twilio_number')  }}" name="twilio_number" required id="twilio_number" placeholder="">
					</div>
				</div>


				<div class="form-group row">
					<label for="zipcode" class="col-xs-2 col-form-label"></label>
					<div class="col-xs-10">
						<button type="submit" class="btn btn-primary">@lang('admin.setting.Update_Site_Settings')</button>
					</div>
				</div>
			</form>
		</div>
    </div>
</div>
@endsection