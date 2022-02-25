<?php

namespace App\DataTables;

use App\Models\BankPayout;
use App\Models\User;
use Yajra\DataTables\DataTables;

class BankPayoutDataTable
{
    public function index()
    {
        $data = BankPayout::orderBy('id', 'desc')->get();
        return DataTables::of($data)
        ->editColumn('updated_at', function ($payment) {
            return substr($payment->updated_at, 0, 10);
        })
        ->editColumn('user_id', function ($payment) {
            $user = User::find($payment->user_id);
            return $user->first_name . ' ' . $user->last_name;
        })
        ->make(true);
    }
}
