<?php

namespace App\Http\Controllers\Configuracoes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InformacoesFiscaisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, config("app.asaas_url")."customerFiscalInfo/municipalOptions");
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
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, config("app.asaas_url")."customerFiscalInfo");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, '{
          "object": "'.$request->object.'",
          "simplesNacional": '.$request->simplesNacional.',
          "rpsSerie": "'.$request->rpsSerie.'",
          "rpsNumber": '.$request->rpsNumber.',
          "loteNumber": '.$request->loteNumber.',
          "username": "'.$request->username.'",
          "specialTaxRegime": "'.$request->specialTaxRegime.'",
          "email": "'.$request->email.'",
          "serviceListItem": '.$request->serviceListItem.',
          "cnae": "'.$request->cnae.'",
          "culturalProjectsPromoter": '.$request->culturalProjectsPromoter.',
          "municipalInscription": "'.$request->municipalInscription.'",
          "stateInscription": '.$request->stateInscription.',
          "password": "'.$request->password.'",
          "accessToken": '.$request->accessToken.',
          "certificateFile": '.$request->certificateFile.',
          "certificatePassword": "'.$request->certificatePassword.'"
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
        curl_setopt($ch, CURLOPT_URL, config("app.asaas_url")."customerFiscalInfo");
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
}
