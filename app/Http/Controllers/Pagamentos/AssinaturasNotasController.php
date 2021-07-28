<?php

namespace App\Http\Controllers\Pagamentos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AssinaturasNotasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  int $id
     * @param  int $offset
     * @param  int $limit
     * @param  string $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(
        $id,
        $offset,
        $limit,
        $status
    )
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, config("app.asaas_url")."subscriptions/$id/invoices?offset=$offset&limit=$limit&status=$status");
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
        curl_setopt($ch, CURLOPT_URL, config("app.asaas_url")."subscriptions/$id/invoiceSettings");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, '{
          "municipalServiceId": '.$request->municipalServiceId.',
          "municipalServiceCode": "'.$request->municipalServiceCode.'",
          "municipalServiceName": "'.$request->municipalServiceName.'",
          "deductions": '.$request->deductions.',
          "taxes": {
            "retainIss": '.$request->taxes->retainIss.',
            "iss": '.$request->taxes->iss.',
            "cofins": '.$request->taxes->cofins.',
            "csll": '.$request->taxes->csll.',
            "inss": '.$request->taxes->inss.',
            "ir": '.$request->taxes->ir.',
            "pis": '.$request->taxes->pis.'
          },
          "effectiveDatePeriod": "'.$request->effectiveDatePeriod.'",
          "daysBeforeDueDate": '.$request->daysBeforeDueDate.',
          "receivedOnly": '.$request->receivedOnly.',
          "observations": "'.$request->observations.'"
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
        curl_setopt($ch, CURLOPT_URL, config("app.asaas_url")."subscriptions/$id/invoiceSettings");
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
        curl_setopt($ch, CURLOPT_URL, config("app.asaas_url")."subscriptions/$id/invoiceSettings");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, '{
          "deductions": '.$request->deductions.',
          "taxes": {
            "retainIss": '.$request->taxes->retainIss.',
            "iss": '.$request->taxes->iss.',
            "cofins": '.$request->taxes->cofins.',
            "csll": '.$request->taxes->csll.',
            "inss": '.$request->taxes->inss.',
            "ir": '.$request->taxes->ir.',
            "pis": '.$request->taxes->pis.'
          },
          "effectiveDatePeriod": "'.$request->effectiveDatePeriod.'",
          "daysBeforeDueDate": '.$request->daysBeforeDueDate.',
          "receivedOnly": '.$request->receivedOnly.',
          "observations": "'.$request->observations.'"
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
        curl_setopt($ch, CURLOPT_URL, config("app.asaas_url")."subscriptions/$id/invoiceSettings");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "access_token: ".config("app.asaas_key")
        ));
        $response = curl_exec($ch);
        curl_close($ch);
        return response()->json($response);
    }
}
