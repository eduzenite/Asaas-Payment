<?php

namespace App\Http\Controllers\Configuracoes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MinhaContaController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, config("app.asaas_url")."myAccount/paymentCheckoutConfig/");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, '{
            "logoBackgroundColor": "'.$request->logoBackgroundColor.'",
            "infoBackgroundColor": "'.$request->infoBackgroundColor.'",
            "fontColor": "'.$request->fontColor.'"
            "enabled": '.$request->enabled.',
            "logoFile": "'.$request->logoFile.'"
        }');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          "Content-Type: multipart/form-data",
          "access_token: ".config("app.asaas_key")
        ));
        $response = curl_exec($ch);
        curl_close($ch);
        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, config("app.asaas_url")."myAccount/");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "access_token: ".config("app.asaas_key")
        ));
        $response = curl_exec($ch);
        curl_close($ch);
        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function paymentCheckoutConfig()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, config("app.asaas_url")."myAccount/paymentCheckoutConfig/");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "access_token: ".config("app.asaas_key")
        ));
        $response = curl_exec($ch);
        curl_close($ch);
        var_dump($response);
    }
}
