<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function payment()
    {
        try {
            $payments = UserRequests::where('paid', 1)
                ->has('user')
                ->has('provider')
                ->has('payment')
                ->orderBy('user_requests.created_at', 'desc')
                ->get();

            return view('admin.payment.payment-history', compact('payments'));
        } catch (\Exception $e) {
            return back()->with('flash_error', 'Something Went Wrong!');
        }
    }

    public function request_payment()
    {
        try {
            $requestpayoutlist = ProviderWithdrawTransaction::all();
            // Log::info($requestpayoutlist->count());
            if ($requestpayoutlist->count() > 0)
                $requestpayoutlist = ProviderWithdrawTransaction::with('provider')
                    ->orderBy('provider_withdraw_transaction.created_at', 'desc')
                    ->get();
            return view('admin.payment.request-payout', compact('requestpayoutlist'));
        } catch (\Exception $e) {
            return back()->with('flash_error', 'Something Went Wrong');
        }
    }

    public function update_request_money(Request $request)
    {
        $Transaction = ProviderWithdrawTransaction::find($request->id);
        $provider_id = $Transaction->provider_id;

        $Provider = Provider::find($provider_id);

        if ($Provider->wallet_balance < $Transaction->request_price)
            return back()->with('flash_error', 'Insufficient funds');


        $Provider->wallet_balance -= $Transaction->request_price;
        $Provider->save();

        ProviderWithdrawTransaction::where('id', $request->id)->update(['status' => 'paid', 'wallet_balance' => $Provider->wallet_balance]);

        // if($request->status == 'accept')
        (new SendPushNotification)->sendPushToProvider($provider_id, "Accepted request money successful");
        // else
        // (new SendPushNotification)->sendPushToProvider($provider_id, "Denied request money");

        try {
            $requestpayoutlist = ProviderWithdrawTransaction::all();
            // Log::info($requestpayoutlist->count());
            if ($requestpayoutlist->count() > 0)
                $requestpayoutlist = ProviderWithdrawTransaction::with('provider')
                    ->orderBy('provider_withdraw_transaction.created_at', 'desc')
                    ->get();
            return view('admin.payment.request-payout', compact('requestpayoutlist'));
        } catch (\Exception $e) {
            return back()->with('flash_error', 'Something Went Wrong');
        }
    }

    public function request_user_payment()
    {
        try {
            $requestpayoutlist = UserWithdrawTransaction::all();
            // Log::info($requestpayoutlist->count());
            if ($requestpayoutlist->count() > 0)
                $requestpayoutlist = UserWithdrawTransaction::with('user')
                    ->orderBy('user_withdraw_transaction.id', 'desc')
                    ->get();
            return view('admin.payment.user-request-payout', compact('requestpayoutlist'));
        } catch (\Exception $e) {
            return back()->with('flash_error', 'Something Went Wrong');
        }
    }

    public function update_request_user_money(Request $request)
    {
        $Transaction = UserWithdrawTransaction::find($request->id);
        $user_id = $Transaction->user_id;

        $User = User::find($user_id);
        $User->wallet_balance -= $Transaction->request_price;
        $User->save();

        UserWithdrawTransaction::where('id', $request->id)->update(['status' => 'paid', 'wallet_balance' => $User->wallet_balance]);

        // if($request->status == 'accept')
        (new SendPushNotification)->sendPushToUser($User, "Accepted request money successful");
        // else
        // (new SendPushNotification)->sendPushToProvider($provider_id, "Denied request money");

        try {
            $requestpayoutlist = UserWithdrawTransaction::all();
            // Log::info($requestpayoutlist->count());
            if ($requestpayoutlist->count() > 0)
                $requestpayoutlist = UserWithdrawTransaction::with('user')
                    ->orderBy('user_withdraw_transaction.created_at', 'desc')
                    ->get();
            return view('admin.payment.user-request-payout', compact('requestpayoutlist'));
        } catch (\Exception $e) {
            return back()->with('flash_error', 'Something Went Wrong');
        }
    }


}
