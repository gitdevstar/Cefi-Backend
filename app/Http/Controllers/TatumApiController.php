<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tatum\Tatum;
use TatumException;

class TatumApiController extends Controller
{
    //
    public function generateAllAccounts()
    {
        $tatum = new Tatum();

        $coins = ["ETH","BTC"];

        $customer = [
            "accountingCurrency" => "USD",
            "customerCountry" => "US",
            "externalId" => "123", // might be user ID
            "providerCountry" => "US"
        ];
        $data = array();
        try {

            foreach($coins as $coin) {
                try {

                    $wallet = $tatum->generateWallet($coin);
                    $wallet = json_decode($wallet);
                    // return response()->json($wallet);
                    $accountData = [
                        "currency"=> $coin,
                        "xpub" => $wallet->xpub,
                        "customer" => $customer,
                        "accountringCurrency" => "USD"
                    ];
                    $data["accounts"][] = $accountData;
                } catch (\Throwable $th) {
                    throw $th;
                }
            }
            try {
                $accounts = $tatum->createAccounts($data);
            } catch (\Throwable $th) {
                throw $th;
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }


        return response()->json(json_decode($accounts));
    }

    public function generateAccount(Request $request)
    {

        $tatum = new Tatum();

        $coin = $request->coin ?? "BTC";

        $customer = $request->customer ?? [
            "accountingCurrency" => "USD",
            "customerCountry" => "US",
            "externalId" => "123", // might be user ID
            "providerCountry" => "US"
        ];
        $wallet = $tatum->generateWallet($coin);
        $data = [
            "currency"=> $coin,
            "xpub" => $wallet->xpub,
            "customer" => $customer,
            "accountringCurrency" => "USD"
        ];

        $account = $tatum->createAccount($data);

        return response()->json($account);
    }

    public function getAccount(Request $request)
    {
        $id = $request->accountId ?? "61c3c770dad1c4141a42ab1c";
        $tatum = new Tatum();
        $account = $tatum->getAccountById($id);

        return response()->json(json_decode($account));
    }

    public function getAllAccountsByCustomer(Request $request)
    {
        $userId = $request->customerId ?? "61c3c770dad1c4dcc742ab1b";
        $tatum = new Tatum();
        $accounts = $tatum->getAccountsByCustomerId($userId);

        return response()->json(json_decode($accounts));
    }

    public function getAccountBalance(Request $request)
    {
        $id = $request->accountId ?? "61c3c867118cccd96946cf05";
        $tatum = new Tatum();
        $balance = $tatum->getAccountBalance($id);
        return response()->json(json_decode($balance));
    }

    public function generateDepositAddress(Request $request)
    {
        $coin = $request->coin ?? "ETH";
        $id = $request->accountId ?? "61c3c867118cccd96946cf05";
        $tatum = new Tatum();
        // $account = $tatum->getAccountById($id);
        // $account = json_decode($account);
        // $address = $tatum->generateAddressFromXPub($coin, $account->xpub, 0);
        $address = $tatum->generateDepositAddress($id);
        $address = json_decode($address);
        return response()->json($address->address);
    }

    public function getDepositAddresses(Request $request)
    {
        $id = $request->accountId ?? "61c3c867118cccd96946cf05";
        $tatum = new Tatum();
        $addresses = $tatum->getDepositAddressesForAccount($id);
        $addresses = json_decode($addresses);
        return response()->json($addresses);
    }

    public function getEthBalance(Request $request)
    {
        $address = $request->address ?? "0x7de968da493af071500ebe8180c5be8436572945";
        $tatum = new Tatum();
        $balance = $tatum->ethGetAccountBalance($address);
        return response()->json(json_decode($balance));
    }

    public function sendTransaction(Request $request)
    {
        $coin = $request->coin ?? "ETH";
        $sAddress = $request->sAddress ?? "0x7de968da493af071500ebe8180c5be8436572945"; //0x638f376f69397b7357588d790258b1F0C848Ba06
        $dAddress = $request->dAddress ?? "";
        $amount = $request->amount ?? "0.001";

        $tatum = new Tatum();
        $body = array();

        $privKey = "";
        $fromUTXO = "";

        switch($coin) {
            case "ETH":
                $body = [$coin, $privKey, $sAddress, $dAddress, $amount];
                $response = $tatum->sendEthereumTransaction($body);
                break;
            case "BTC":
                $body = [$fromUTXO, $sAddress, $dAddress];
                $response = $tatum->sendBitcoinTransaction($body);
                break;
            case "BCH":
                $body = [$fromUTXO, $sAddress, $dAddress];
                $response = $tatum->sendBcashTransaction($body);
                break;
            case "LTC":
                $body = [$fromUTXO, $sAddress, $dAddress];
                $response = $tatum->sendLitecoinTransaction($body);
                break;
        }

        return response()->json($response);
    }
}
