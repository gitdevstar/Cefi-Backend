<?php

namespace App\DataTables;

use App\Models\PayHistory;
use App\Models\User;
use Yajra\DataTables\DataTables;

class PayDataTable
{
    public function index()
    {
        $data = PayHistory::orderBy('id', 'desc')->get();
        return DataTables::of($data)
        ->editColumn('updated_at', function ($payment) {
            return substr($payment->updated_at, 0, 10);
        })
        ->editColumn('sender_id', function ($payment) {
            $user = User::find($payment->sender_id);
            return $user->first_name . ' ' . $user->last_name;
        })
        ->editColumn('receiver_id', function ($payment) {
            $user = User::find($payment->receiver_id);
            return $user->first_name . ' ' . $user->last_name;
        })
        ->make(true);
    }
}
