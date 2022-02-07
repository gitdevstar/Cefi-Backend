<?php

namespace App\DataTables;

use App\Models\Withdraw;
use App\Models\User;
use Yajra\DataTables\DataTables;

class WithdrawDataTable
{
    public function index()
    {
        $data = Withdraw::orderBy('id', 'desc')->get();
        return DataTables::of($data)
        ->addColumn('action', function ($payment) {
            $approveurl = route('admin.withdraw.approve', $payment->id);
            $unapproveurl = route('admin.withdraw.unapprove', $payment->id);
            return $payment->status == 0 ? '<a href="'.$approveurl.'" class="btn btn-xs btn-danger">Pay</a> <a href="'.$unapproveurl.'" class="btn btn-xs btn-warning">Reject</a>': '';
        })
        // ->addColumn('balance', function ($payment) {
        //     $user = User::find($payment->user_id);
        //     return '$ '.$user->balance;
        // })
        ->editColumn('updated_at', function ($payment) {
            return substr($payment->updated_at, 0, 10);
        })
        ->editColumn('user_id', function ($payment) {
            $user = User::find($payment->user_id);
            return $user->first_name . ' ' . $user->last_name;
        })
        ->editColumn('status', function ($payment) {
            return $payment->status == 0 ? 'Unpaid' : ($payment->status == 2 ? 'Rejected' : 'Paid');
            // return $payment->status == 0 ? 'Unpaid' : ($payment->status == 2 ? 'Rejected' : '<i class="badge bg-success">Paid</i>');
        })
        // ->editColumn('amount', $kind == 'cash' ? '$ {{$amount}}' : '{{$amount}}')
        ->make(true);
    }
}
