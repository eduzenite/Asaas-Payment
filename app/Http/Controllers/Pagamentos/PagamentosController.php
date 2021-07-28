<?php

namespace App\Http\Controllers\Pagamentos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PagamentosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * * @param string $customer,
     * * @param string $billingType,
     * * @param string $status,
     * * @param string $subscription,
     * * @param string $installment,
     * * @param string $externalReference,
     * * @param string $paymentDate,
     * * @param string $anticipated,
     * * @param string $paymentDatege,
     * * @param string $paymentDatele,
     * * @param string $dueDatege,
     * * @param string $dueDatele,
     * * @param string $offset,
     * * @param string $limit
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(
        $customer,
        $billingType,
        $status,
        $subscription,
        $installment,
        $externalReference,
        $paymentDate,
        $anticipated,
        $paymentDatege,
        $paymentDatele,
        $dueDatege,
        $dueDatele,
        $offset,
        $limit
    )
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, config("app.asaas_url") . "payments?customer=".$customer."&billingType=".$billingType."&status=".$status."&subscription=".$subscription."&installment=".$installment."&externalReference=".$externalReference."&paymentDate=".$paymentDate."&anticipated=".$anticipated."&paymentDate[ge] =".$paymentDatege."&paymentDate[le]=".$paymentDatele."&dueDate[ge]=".$dueDatege."&dueDate[le]=".$dueDatele."&offset=".$offset."&limit=".$limit."");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "access_token: " . config("app.asaas_key")
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
    public function boleto(Request $request)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, config("app.asaas_url") . "payments");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, '{
              "customer": "' . $request->customer . '",
              "billingType": "BOLETO",
              "dueDate": "' . $request->dueDate . '",
              "value": ' . $request->value . ',
              "description": "' . $request->description . '",
              "externalReference": "' . $request->externalReference . '",
              "discount": {
                "value": ' . $request->discount->value . ',
                "dueDateLimitDays": ' . $request->discount->dueDateLimitDays . '
              },
              "fine": {
                "value": ' . $request->fine->value . '
              },
              "interest": {
                "value": ' . $request->interest->value . '
              },
              "postalService": ' . $request->postalService . '
            }');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "access_token: " . config("app.asaas_key")
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
    public function cartao(Request $request)
    {
        global $ambiente;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, config("app.asaas_url") . "payments");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, '{
          "customer": "' . $request->customer . '",
          "billingType": "CREDIT_CARD",
          "dueDate": "' . $request->dueDate . '",
          "installmentCount": ' . $request->installmentCount . ',
          "installmentValue": ' . $request->installmentValue . ',
          "description": "' . $request->description . '",
          "externalReference": "' . $request->externalReference . '",
          "creditCard": {
            "holderName": "' . $request->creditCard->holderName . '",
            "number": "' . $request->creditCard->number . '",
            "expiryMonth": "' . $request->creditCard->expiryMonth . '",
            "expiryYear": "' . $request->creditCard->expiryYear . '",
            "ccv": "' . $request->creditCard->ccv . '"
          },
          "creditCardHolderInfo": {
            "name": "' . $request->creditCardHolderInfo->name . '",
            "email": "' . $request->creditCardHolderInfo->email . '",
            "cpfCnpj": "' . $request->creditCardHolderInfo->cpfCnpj . '",
            "postalCode": "' . $request->creditCardHolderInfo->postalCode . '",
            "addressNumber": "' . $request->creditCardHolderInfo->addressNumber . '",
            "addressComplement": "' . $request->creditCardHolderInfo->addressComplement . '",
            "phone": "' . $request->creditCardHolderInfo->phone . '"
          },
        }');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "access_token: " . config("app.asaas_key")
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
        curl_setopt($ch, CURLOPT_URL, config("app.asaas_url") . "payments/".$id);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "access_token: " . config("app.asaas_key")
        ));
        $response = curl_exec($ch);
        curl_close($ch);
        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, config("app.asaas_url") . "payments/".$id);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, '{
          "billingType": "'.$request->billingType.'",
          "dueDate": "'.$request->dueDate.'",
          "value": '.$request->value.',
          "description": "'.$request->description.'",
          "externalReference": "'.$request->externalReference.'",
          "discount": {
            "value": '.$request->discount->value.',
            "dueDateLimitDays": '.$request->discount->dueDateLimitDays.'
          },
          "fine": {
            "value": '.$request->fine->value.'
          },
          "interest": {
            "value": '.$request->interest->value.'
          },
          "postalService": '.$request->postalService.'
        }');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "access_token: " . config("app.asaas_key")
        ));
        $response = curl_exec($ch);
        curl_close($ch);
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, config("app.asaas_url") . "payments/".$id);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "access_token: " . config("app.asaas_key")
        ));
        $response = curl_exec($ch);
        curl_close($ch);
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore($id)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, config("app.asaas_url") . "payments/".$id."/restore");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "access_token: " . config("app.asaas_key")
        ));
        $response = curl_exec($ch);
        curl_close($ch);
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function refund($id)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, config("app.asaas_url") . "payments/".$id."/refund");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "access_token: " . config("app.asaas_key")
        ));
        $response = curl_exec($ch);
        curl_close($ch);
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function receiveInCash($id, Request $request)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, config("app.asaas_url") . "payments/".$id."/receiveInCash");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, '{
            "paymentDate": "'.$request->paymentDate.'",
            "value": '.$request->value.',
        }');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "access_token: " . config("app.asaas_key")
        ));
        $response = curl_exec($ch);
        curl_close($ch);
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function undoReceivedInCash($id)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, config("app.asaas_url") . "payments/".$id."/undoReceivedInCash");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "access_token: " . config("app.asaas_key")
        ));
        $response = curl_exec($ch);
        curl_close($ch);
        return response()->json($response);
    }
}
