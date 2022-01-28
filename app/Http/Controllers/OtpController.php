<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Ferdous\OtpValidator\Object\OtpRequestObject;
use Ferdous\OtpValidator\OtpValidator;
use Ferdous\OtpValidator\Object\OtpValidateRequestObject;
use Ferdous\OtpValidator\Services\OtpService;

class OtpController extends Controller
{
    /**
     * @return array
     */
    public function requestForOtp($email, $phone)
    {
        return OtpValidator::requestOtp(
            new OtpRequestObject(OtpService::otpGenerator(), 'api', $phone, $email)
        );
    }

    /**
     * @param Request $request
     * @return array
     */
    public function validateOtp(Request $request)
    {
        $uniqId = $request->input('uniqueId');
        $otp = $request->input('otp');
        return OtpValidator::validateOtp(
            new OtpValidateRequestObject($uniqId,$otp)
        );
    }

    /**
     * @param Request $request
     * @return array
     */
    public function resendOtp(Request $request)
    {
        $uniqueId = $request->input('uniqueId');
        return OtpValidator::resendOtp($uniqueId);
    }

}
