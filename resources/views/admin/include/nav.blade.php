<div class="site-sidebar">
	<div class="custom-scroll custom-scroll-light">
		<ul class="sidebar-menu">
			<li>
				<a href="{{ route('admin.dashboard') }}" class="waves-effect  waves-light">
					<span class="s-icon"><i class="fa fa-building"></i></span>
					<span class="s-text">@lang('admin.include.dashboard')</span>
				</a>
			</li>
			<li class="menu-title">@lang('admin.include.members')</li>
            <li>
                <a href="{{ route('admin.user.index') }}">
                    <span class="s-icon"><i class="ti-crown"></i></span>
                    <span class="s-text">Users</span>
                </a>
            </li>
			<li>
				<a href="{{ route('admin.withdraw') }}" class="waves-effect waves-light">
					<span class="s-icon"><i class="ti-money"></i></span>
					<span class="s-text">Withdraw</span>
				</a>
			</li>
			<li>
				<a href="{{ route('admin.coin.portfolio') }}" class="waves-effect waves-light">
					<span class="s-icon"><i class="ti-money"></i></span>
					<span class="s-text">Coin Portfolios</span>
				</a>
			</li>
			<li>
				<a href="{{ route('admin.coin.deposit.history') }}" class="waves-effect waves-light">
					<span class="s-icon"><i class="ti-money"></i></span>
					<span class="s-text">Coin Deposits</span>
				</a>
			</li>
			<li>
				<a href="{{ route('admin.coin.order.history') }}" class="waves-effect waves-light">
					<span class="s-icon"><i class="ti-money"></i></span>
					<span class="s-text">Coin Orders</span>
				</a>
			</li>
			<li>
				<a href="{{ route('admin.cash.mobilecharge.history') }}" class="waves-effect waves-light">
					<span class="s-icon"><i class="ti-money"></i></span>
					<span class="s-text">Mobile Charges</span>
				</a>
			</li>
			<li>
				<a href="{{ route('admin.cash.bankcharge.history') }}" class="waves-effect waves-light">
					<span class="s-icon"><i class="ti-money"></i></span>
					<span class="s-text">Bank Charges</span>
				</a>
			</li>
			<li>
				<a href="{{ route('admin.cash.mobilepayout.history') }}" class="waves-effect waves-light">
					<span class="s-icon"><i class="ti-money"></i></span>
					<span class="s-text">Mobile Payouts</span>
				</a>
			</li>
			<li>
				<a href="{{ route('admin.cash.bankpayout.history') }}" class="waves-effect waves-light">
					<span class="s-icon"><i class="ti-money"></i></span>
					<span class="s-text">Bank Payouts</span>
				</a>
			</li>
			<li class="menu-title">@lang('admin.include.settings')</li>
			<li>
				<a href="{{ route('admin.payment.settings') }}" class="waves-effect  waves-light">
					<span class="s-icon"><i class="ti-settings"></i></span>
					<span class="s-text">Payment Settings</span>
				</a>
			</li>
			<li>
				<a href="{{ route('admin.settings') }}" class="waves-effect  waves-light">
					<span class="s-icon"><i class="ti-settings"></i></span>
					<span class="s-text">@lang('admin.include.site_settings')</span>
				</a>
			</li>

			<li class="menu-title">@lang('admin.include.account')</li>
			<li>
				<a href="{{ route('admin.profile') }}" class="waves-effect  waves-light">
					<span class="s-icon"><i class="ti-user"></i></span>
					<span class="s-text">@lang('admin.include.account_settings')</span>
				</a>
			</li>
			<li>
				<a href="{{ route('admin.password') }}" class="waves-effect  waves-light">
					<span class="s-icon"><i class="ti-exchange-vertical"></i></span>
					<span class="s-text">@lang('admin.include.change_password')</span>
				</a>
			</li>
			<li class="compact-hide">
				<a href="{{ url('/admin/logout') }}"
                            onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
					<span class="s-icon"><i class="ti-power-off"></i></span>
					<span class="s-text">@lang('admin.include.logout')</span>
                </a>

                <form id="logout-form" action="{{ url('/admin/logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
			</li>

		</ul>
	</div>
</div>
