<?php

namespace App\Http\Controllers;

use App\DataTables\WithdrawDataTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Admin;
use App\Models\Withdraw;
use App\Repositories\WithdrawRepository;

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


}
