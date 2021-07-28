<?php

namespace App\Http\Controllers\Pagamentos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotasFiscaisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  string $effectiveDatege
     * @param  string $effectiveDatele
     * @param  string $payment
     * @param  string $installment
     * @param  string $externalReference
     * @param  string $status
     * @param  int $offset
     * @param  int $limit
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(
        $effectiveDatege,
        $effectiveDatele,
        $payment,
        $installment,
        $externalReference,
        $status,
        $offset,
        $limit
    )
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, config("app.asaas_url")."invoices?effectiveDate[ge]=$effectiveDatege&effectiveDate[le]=$effectiveDatele&payment=$payment&installment=$installment&externalReference=$externalReference&status=$status&offset=$offset&limit=$limit");
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, config("app.asaas_url")."invoices");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, '{
          "payment": "pay_637959110194",
          "installment": null,
          "serviceDescription": "Nota fiscal da Fatura 101940. \nDescrição dos Serviços: ANÁLISE E DESENVOLVIMENTO DE SISTEMAS",
          "observations": "Mensal referente aos trabalhos de Junho.",
          "value": 300,
          "deductions": 0,
          "effectiveDate": "2018-07-03",
          "externalReference": null,
          "taxes": {
            "retainIss": false,
            "iss": 3,
            "cofins": 3,
            "csll": 1,
            "inss": 0,
            "ir": 1.5,
            "pis": 0.65
          },
          "municipalServiceId": null,
          "municipalServiceCode": "1.01",
          "municipalServiceName": "Análise e desenvolvimento de sistemas"
        }');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "access_token: ".config("app.asaas_key")
        ));
        $response = curl_exec($ch);
        curl_close($ch);
        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, config("app.asaas_url")."invoices/{id}");
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, config("app.asaas_url")."invoices/id");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, '{
          "serviceDescription": "Nota fiscal da Fatura 101940. \nDescrição dos Serviços: ANÁLISE E DESENVOLVIMENTO DE SISTEMAS",
          "observations": "Mensal referente aos trabalhos de Junho.",
          "value": 300,
          "deductions": 10,
          "effectiveDate": "2018-07-03",
          "externalReference": null,
          "taxes": {
            "retainIss": false,
            "iss": 3,
            "cofins": 3,
            "csll": 1,
            "inss": 0,
            "ir": 1.5,
            "pis": 0.65
          }
        }');
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
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, config("app.asaas_url")."invoices/{id}/cancel");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
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
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function authorizeApi($id)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, config("app.asaas_url")."invoices/{id}/authorize");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
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
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function municipalServices($id)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, config("app.asaas_url")."invoices/municipalServices?description=");
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
