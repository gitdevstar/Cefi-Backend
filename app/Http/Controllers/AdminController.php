<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Helpers\Helper;

use App\Models\User;
use App\Models\Admin;

use App\Repositories\WithdrawRepository;

use anlutro\LaravelSettings\Facade as Setting;

use App\DataTables\CoinWalletDataTable;
use App\DataTables\WithdrawDataTable;
use App\DataTables\CoinDepositDataTable;
use App\DataTables\CoinOrdersDataTable;
use App\DataTables\MobileChargeDataTable;
use App\DataTables\MobilePayoutDataTable;
use App\DataTables\BankChargeDataTable;
use App\DataTables\BankPayoutDataTable;
use App\DataTables\PayDataTable;
use App\DataTables\UserDataTable;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Dashboard.
     *
     * @param  \App\Model\User  $user
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $userCount = User::count();

        return view('admin.dashboard', compact('userCount'));
    }

    public function profile()
    {
        return view('admin.account.profile');
    }

    public function profile_update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|max:255|email|unique:admins',
            'picture' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
        ]);

        try {
            $admin = Auth::guard('admin')->user();
            $admin->name = $request->name;
            $admin->email = $request->email;

            if ($request->hasFile('picture')) {
                $admin->picture = $request->picture->store('admin/profile');
            }
            $admin->save();

            return redirect()->back()->with('flash_success', 'Profile Updated');
        } catch (\Exception $e) {
            return back()->with('flash_error', 'Something Went Wrong!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function password()
    {
        return view('admin.account.change-password');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function password_update(Request $request)
    {

        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        try {

            $Admin = Admin::find(Auth::guard('admin')->user()->id);

            if (password_verify($request->old_password, $Admin->password)) {
                $Admin->password = bcrypt($request->password);
                $Admin->save();

                return redirect()->back()->with('flash_success', 'Password Updated');
            }
        } catch (\Exception $e) {
            return back()->with('flash_error', 'Something Went Wrong!');
        }
    }

    public function withdrawList(Request $request, WithdrawDataTable $withdrawdatatable)
    {
        if($request->ajax()) {
            return $withdrawdatatable->index();
        }
        return view('admin.payment.withdraw');
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function settings()
    {
        return view('admin.settings.application');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function settings_store(Request $request)
    {
        $this->validate($request, [
            'site_title' => 'required',
            'site_icon' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
            'site_logo' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
        ]);

        if ($request->hasFile('site_icon')) {
            $site_icon = Helper::upload_picture($request->file('site_icon'));
            Setting::set('site_icon', $site_icon);
        }

        if ($request->hasFile('site_logo')) {
            $site_logo = Helper::upload_picture($request->file('site_logo'));
            Setting::set('site_logo', $site_logo);
        }

        if ($request->hasFile('site_email_logo')) {
            $site_email_logo = Helper::upload_picture($request->file('site_email_logo'));
            Setting::set('site_email_logo', $site_email_logo);
        }

        Setting::set('site_title', $request->site_title);
        Setting::set('store_link_android', $request->store_link_android);
        // Setting::set('store_link_ios', $request->store_link_ios);
        Setting::set('contact_number', $request->contact_number);
        Setting::set('contact_email', $request->contact_email);
        Setting::set('site_copyright', $request->site_copyright);
        Setting::save();

        return back()->with('flash_success', 'Settings Updated Successfully');
    }

    public function paymentSettings()
    {
        return view('admin.settings.payment');
    }

    public function storePaymentSettings(Request $request)
    {
        $this->validate($request, [
            'coin_trade_fee' => 'required',
            'usdc_withdraw_fee' => 'required',
            'paypal_withdraw_fee' => 'required',
            'cash_conversation_fee' => 'required',
        ]);

        Setting::set('coin_trade_fee', $request->coin_trade_fee);
        Setting::set('usdc_withdraw_fee', $request->usdc_withdraw_fee);
        Setting::set('paypal_withdraw_fee', $request->paypal_withdraw_fee);
        Setting::set('cash_conversation_fee', $request->cash_conversation_fee);
        Setting::save();

        return back()->with('flash_success', 'Settings Updated Successfully');
    }

    public function approveWithdraw(Request $request, WithdrawRepository $withRepo)
    {
        $id = $request->id;
        try {
            $withRepo->approve($id);
            return back()->with('flash_success', 'Approved successfully');
        } catch (\Exception $e) {
            return back()->with('flash_error', $e->getMessage());
        }
    }

    public function unApproveWithdraw(Request $request, WithdrawRepository $withRepo)
    {
        $id = $request->id;
        try {
            $withRepo->unapprove($id);
            return back()->with('flash_success', 'Unapproved successfully');
        } catch (\Exception $e) {
            return back()->with('flash_error', $e->getMessage());
        }
    }

    public function coinWallet(Request $request, CoinWalletDataTable $datatable)
    {
        $id = $request->user;
        return $datatable->wallets($id);
    }

    public function coinPortfolio(Request $request, UserDataTable $datatable)
    {
        if($request->ajax()) {
            return $datatable->portfolio();
        }
        return view('admin.coin.wallet');
    }

    public function coinDepositHistory(Request $request, CoinDepositDataTable $datatable)
    {
        if($request->ajax()) {
            return $datatable->index();
        }
        return view('admin.coin.deposit');
    }

    public function coinOrderHistory(Request $request, CoinOrdersDataTable $datatable)
    {
        if($request->ajax()) {
            return $datatable->index();
        }
        return view('admin.coin.orders');
    }

    public function cashPayHistory(Request $request, PayDataTable $datatable)
    {
        if($request->ajax()) {
            return $datatable->index();
        }
        return view('admin.cash.pay');
    }

    public function mobileChargeHistory(Request $request, MobileChargeDataTable $datatable)
    {
        if($request->ajax()) {
            return $datatable->index();
        }
        return view('admin.cash.mobilecharge');
    }
    public function mobilePayoutHistory(Request $request, MobilePayoutDataTable $datatable)
    {
        if($request->ajax()) {
            return $datatable->index();
        }
        return view('admin.cash.mobilepayout');
    }
    public function bankChargeHistory(Request $request, BankChargeDataTable $datatable)
    {
        if($request->ajax()) {
            return $datatable->index();
        }
        return view('admin.cash.bankcharge');
    }
    public function bankPayoutHistory(Request $request, BankPayoutDataTable $datatable)
    {
        if($request->ajax()) {
            return $datatable->index();
        }
        return view('admin.cash.bankpayout');
    }

}
