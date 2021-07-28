<?php

namespace App\Http\Controllers\MeuDinheiro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AntecipacaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param string $payment,
     * @param string $installment,
     * @param string $status,
     * @param int $offset,
     * @param int $limit
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(
        $payment,
        $installment,
        $status,
        $offset,
        $limit
    )
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, config("app.asaas_url")."anticipations?payment=$payment&installment=$installment&status=$status&offset=$offset&limit=$limit");
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
        curl_setopt($ch, CURLOPT_URL, config("app.asaas_url")."anticipations");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
            '{
            "agreementSignature": "'.$request->agreementSignature.'",
            "installment": '.$request->installment.',
            "payment": "'.$request->payment.'",
            "documents": '.$request->documents.'
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
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, config("app.asaas_url")."anticipations/$id");
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
     * Remove the specified resource from storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function simulate($request)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, config("app.asaas_url")."anticipations/simulate");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, '{
          "installment": '.$request->installment.',
          "payment": "'.$request->payment.'"
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
