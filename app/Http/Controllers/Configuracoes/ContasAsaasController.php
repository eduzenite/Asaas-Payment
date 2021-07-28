<?php

namespace App\Http\Controllers\Configuracoes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContasAsaasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, config("app.asaas_url")."accounts");
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
        curl_setopt($ch, CURLOPT_URL, config("app.asaas_url")."accounts");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, '{
            "name": "'.$request->name.'",
            "email": "'.$request->email.'",
            "cpfCnpj": "'.$request->cpfCnpj.'",
            "companyType": "'.$request->companyType.'",
            "phone": "'.$request->phone.'",
            "mobilePhone": "'.$request->mobilePhone.'",
            "address": "'.$request->address.'",
            "addressNumber": "'.$request->addressNumber.'",
            "complement": "'.$request->complement.'",
            "province": "'.$request->province.'",
            "postalCode": "'.$request->postalCode.'",
        }');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "access_token: ".config("app.asaas_key")
        ));
        $response = curl_exec($ch);
        curl_close($ch);
        return response()->json($response);
    }
}
