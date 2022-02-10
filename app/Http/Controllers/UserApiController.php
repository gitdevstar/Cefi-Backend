<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Storage;

class UserApiController extends Controller
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

    public function update(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'first_name' => 'required',
            'last_name' => 'required',
            'phone_number' => 'required',
            'photo' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
        ]);

        $user = Auth::user();

        if($request->email != $user->email && User::where('email', $request->email)->count() > 0) {
            return response()->json(['error' => 'Your changed email is exist already.'], 500);
        }

        if($request->phone_number != $user->phone_number && User::where('phone_number', $request->phone_number)->count() > 0) {
            return response()->json(['error' => 'Your changed phone_number is exist already.'], 500);
        }

        $this->userRepository->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone_number' => $request->phone_number,
        ], $user->id);

        if($request->hasFile('photo')) {
            Storage::delete($user->photo);
            $user->photo = $request->photo->store('users');
            $user->save();
        }

        $user = Auth::user();

        return response()->json(['user' => $user]);
    }
}
