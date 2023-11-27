<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class RequestProcessing
{

    public static function VerifyMessage($message, $signature)
    {
        if (!$cert_store = file_get_contents("sign_keys/uccEngineConsDefaultpublic.pfx")) {
            echo "Error: Unable to read the cert file\n";
            exit;
        }

        if (openssl_pkcs12_read($cert_store, $cert_info, "uccEngineConsDefault1234")) {
            // echo "Certificate Information\n";
            $public_key = $cert_info['extracerts'][0];
        }

        $isValid = openssl_verify(implode(',', $message), base64_decode($signature), $public_key, OPENSSL_ALGO_SHA1);

        // if ($isValid === 1) {
        //     echo "Signature is valid!\n";
        // } elseif ($isValid === 0) {
        //     echo "Signature is invalid!\n";
        // } else {
        //     echo "Error during verification: " . openssl_error_string() . "\n";
        // }

        return $isValid;
    }

    public static function SignRequest($bill)
    {
        $data = file_get_contents(storage_path('sign_keys/uccEngineprivate.pfx'));
        $certPassword = "uccEngine1234";
        openssl_pkcs12_read($data, $certs, $certPassword);
        $keys =  $certs;

        $private_key = $keys['pkey'];
        openssl_sign(implode(',', $bill), $signature, $private_key, "sha1WithRSAEncryption");

        $message = base64_encode($signature);

        return $message;
    }



    public static function SignRequest1($request)
    {
        $pfxFilePath = storage_path('sign_keys/uccEngineprivate.pfx');

        // Example PFX file password
        $pfxFilePassword = 'uccEngine1234';

        // Load the private key from the PFX file
        $privateKey = null;
        openssl_pkcs12_read(file_get_contents($pfxFilePath), $privateKey, $pfxFilePassword);

        // Sign the data using the private key
        $signature = null;
        openssl_sign($request, $signature, $privateKey['pkey']);

        // Encode the signature as base64
        $base64Signature = base64_encode($signature);

        return response()->json(['signature' => $base64Signature]);
    }
}
