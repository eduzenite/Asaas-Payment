<?php

namespace App\Http\Controllers\Configuracoes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificacaoController extends Controller
{

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
        curl_setopt($ch, CURLOPT_URL, config("app.asaas_url")."notifications/$id");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, '{
          "enabled": '.$request->enabled.',
          "emailEnabledForProvider": '.$request->emailEnabledForProvider.',
          "smsEnabledForProvider": '.$request->smsEnabledForProvider.',
          "emailEnabledForCustomer": '.$request->emailEnabledForCustomer.',
          "smsEnabledForCustomer": '.$request->smsEnabledForCustomer.',
          "phoneCallEnabledForCustomer": '.$request->phoneCallEnabledForCustomer.'
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
