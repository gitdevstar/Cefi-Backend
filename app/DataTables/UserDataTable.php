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
}
