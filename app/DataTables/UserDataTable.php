<?php

namespace App\DataTables;

use App\Models\User;
use Yajra\DataTables\DataTables;

class UserDataTable
{
    public function index()
    {
        $users = User::orderBy('id', 'desc')->get();
        return DataTables::of($users)
        // ->addColumn('action', function ($user) {
        //     return '<a href="#edit-'.$user->id.'" class="btn btn-xs btn-warning"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
        // })
        ->editColumn('created_at', function ($user) {
            return substr($user->created_at, 0, 10);
        })
        ->editColumn('balance', '$ {{$balance}}')
        ->removeColumn('password')
        ->make(true);
    }

    public function portfolio()
    {
        $users = User::orderBy('id', 'desc')->get();
        return DataTables::of($users)
        ->addColumn('portfolio', function ($user) {
            $portfolio = $user->portfolio();
            return "$ ".$portfolio['portfolio'];
        })
        ->addColumn('portfolio_change', function ($user) {
            $portfolio = $user->portfolio();
            return "$ ".$portfolio['portfolio_change_24h'];
        })
        ->addColumn('portfolio_change_percent', function ($user) {
            $portfolio = $user->portfolio();
            return $portfolio['portfolio_change_percentage_24h']." %";
        })
        ->removeColumn('password')
        ->removeColumn('balance')
        ->removeColumn('email')
        ->removeColumn('photo')
        ->removeColumn('phone_number')
        ->removeColumn('device')
        ->removeColumn('remember_token')
        ->removeColumn('created_at')
        ->make(true);
    }
}
