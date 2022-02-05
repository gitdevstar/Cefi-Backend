<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

class UserController1 extends Controller
{
    /** @var  UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function search(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email'
        ]);

        $users = $this->userRepository->all($request->email);

        return response()->json(['users' => $users]);
    }

    public function user()
    {
        $user = Auth::user();

        return response()->json(['user' => $user]);
    }
}
