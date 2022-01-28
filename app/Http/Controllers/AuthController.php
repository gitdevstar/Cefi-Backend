<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

use App\Models\User;
use Illuminate\Support\Facades\Config;

class AuthController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            // 'device' => 'in:android,ios',
        ]);


        if (!Auth::attempt($credentials)) {
            return response()->json('Email and Password are not matched', 500);
        }

        $user = User::where('email', $request->email)->first();

        if($request->has('device')) {
            $user['device'] = $request->device;
            $user->save();
        }

        // if (! $user || ! Hash::check($request->password, $user->password)) {
        //     throw ValidationException::withMessages([
        //         'error' => ['The provided credentials are incorrect.'],
        //     ]);
        // }
        $token = $user->createToken($request->email)->plainTextToken;
        $user['token'] = 'Bearer '.$token;

        return response()->json(['message'=>'Logined successfully.', 'user' => $user]);
    }

    public function signup(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'phone_number' => 'required',
            'device' => 'required|in:android,ios',
        ]);

        $user = User::where('email', $request->email)->first();

        if($user) {
            return response()->json(['error' => 'You registerd with this email already'], 500);
        }

        $user = User::where('phone_number', $request->phone_number)->first();

        if($user) {
            return response()->json(['error' => 'You registerd with this phone number already'], 500);
        }

        // $result = (new OtpController)->requestForOtp($request->email, $request->phone_number);
        // if(!$result)
        //     return response()->json(['error' => 'Invalidate email or phone number.'], 500);

        User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password), //bycrypt($request->password)
            'device' => $request->device,
        ]);

        return response()->json(['message'=>'Registered successfully.']);


    }

    public function forgotPassword(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if(! $user) {
            return response()->json(['error' => 'No registered user.'], 500);
        }
        try {
            Config::set('otp.send-by.sms', 0);
            $result = (new OtpController)->requestForOtp($request->email, null);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status' => false, 'error'=>$th->getMessage()], 500);
        }

        return response()->json(['result' => $result]);
    }

    public function resetPassword(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user) {
            return response()->json(['error' => 'Not registered user.'], 500);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['status' => true, 'message' => "Updated your password."]);
    }

    public function validateOTP(Request $request)
    {
        $this->validate($request, [
            'uniqueId' => 'required',
            'otp' => 'required'
        ]);

        Config::set('otp.send-by.sms', 0);
        $result = (new OtpController)->validateOtp($request);

        return response()->json(['result' => $result]);
    }

    public function resendOTP(Request $request)
    {
        $this->validate($request, [
            'uniqueId' => 'required',
        ]);

        Config::set('otp.send-by.sms', 0);
        $result = (new OtpController)->resendOtp($request);

        return response()->json(['result' => $result]);
    }
}
