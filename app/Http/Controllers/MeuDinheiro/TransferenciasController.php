<?php

namespace App\Http\Controllers\MeuDinheiro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransferenciasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param string $dateCreated
     * @param string $type
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(
        $dateCreated,
        $type
    )
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, config("app.asaas_url")."transfers?dateCreated=$dateCreated&type=$type");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
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
        if($request->type == 'ASAAS_ACCOUNT'){
            $response = $this->contaAsaas($request);
        }elseif($request->type == 'BANK_ACCOUNT'){
            $response = $this->contaBancaria($request);
        }
        return response()->json($response);
    }

    function contaAsaas($request)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, config("app.asaas_url")."transfers");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, '{
          "value": '.$request->value.',
          "walletId": "'.$request->walletId.'"
        }');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "access_token: ".config("app.asaas_key")
        ));
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    function contaBancaria($request)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, config("app.asaas_url")."transfers");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, '{
            "value": '.$request->value.',
            "bankAccount": {
                "bank": {
                    "code": "'.$request->bank->code.'"
                },
                "accountName": "'.$request->accountName.'",
                "ownerName": "'.$request->ownerName.'",
                "ownerBirthDate": "'.$request->ownerBirthDate.'",
                "cpfCnpj": "'.$request->cpfCnpj.'",
                "agency": "'.$request->agency.'",
                "account": "'.$request->account.'",
                "accountDigit": "'.$request->accountDigit.'",
                "bankAccountType": "'.$request->bankAccountType.'",
            }
        }');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "access_token: ".config("app.asaas_key")
        ));
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
}
