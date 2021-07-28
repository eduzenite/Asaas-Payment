<?php

use App\Http\Controllers\Clientes\ClienteController;
use App\Http\Controllers\Clientes\SerasaController;
use App\Http\Controllers\Configuracoes\ContasAsaasController;
use App\Http\Controllers\Configuracoes\InformacoesFiscaisController;
use App\Http\Controllers\Configuracoes\MinhaContaController;
use App\Http\Controllers\Configuracoes\NotificacaoController;
use App\Http\Controllers\Configuracoes\WebhookController;
use App\Http\Controllers\MeuDinheiro\AntecipacaoController;
use App\Http\Controllers\MeuDinheiro\ContasController;
use App\Http\Controllers\MeuDinheiro\ExtrartoController;
use App\Http\Controllers\MeuDinheiro\RecuperacaoController;
use App\Http\Controllers\MeuDinheiro\TransferenciasController;
use App\Http\Controllers\Pagamentos\AssinaturasController;
use App\Http\Controllers\Pagamentos\AssinaturasNotasController;
use App\Http\Controllers\Pagamentos\LinkImagemController;
use App\Http\Controllers\Pagamentos\LinkPagamentoController;
use App\Http\Controllers\Pagamentos\PagamentosController;
use App\Http\Controllers\Pagamentos\ParcelamentosController;
use App\Http\Controllers\Pagamentos\NotasFiscaisController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    "prefix" => "customers"
], function () {
    Route::post('/', [ClienteController::class, 'store'])->middleware('client');
    Route::get('{id}', [ClienteController::class, 'show'])->middleware('client');
    //Listar clientes - GET - {name?}/{email?}/{cpfCnpj?}/{groupName?}/{externalReference?}/{offset?}/{limit?}
    Route::get('{name?}/{email?}/{cpfCnpj?}/{groupName?}/{externalReference?}/{offset?}/{limit?}', [ClienteController::class, 'index'])->middleware('client');
    Route::patch('{id}', [ClienteController::class, 'update'])->middleware('client');
    Route::delete('{id}', [ClienteController::class, 'destroy'])->middleware('client');
    Route::post('{id}/restore', [ClienteController::class, 'restore'])->middleware('client');
});

Route::group([
    "prefix" => "payments"
], function () {
    Route::post('boleto', [PagamentosController::class, 'boleto'])->middleware('client');
    Route::post('cartao', [PagamentosController::class, 'cartao'])->middleware('client');
    Route::get('{id}', [PagamentosController::class, 'show'])->middleware('client');
    //Listar cobranças - GET - {customer?}/{billingType?}/{status?}/{subscription?}/{installment?}/{externalReference?}/{paymentDate?}/{anticipated?}/{paymentDate%5Bge%5D?}/{paymentDate%5Ble%5D?}/{dueDate%5Bge%5D?}/{dueDate%5Ble%5D?}/{offset?}/{limit?}
    Route::get('{customer?}/{billingType?}/{status?}/{subscription?}/{installment?}/{externalReference?}/{paymentDate?}/{anticipated?}/{paymentDate%5Bge%5D?}/{paymentDate%5Ble%5D?}/{dueDate%5Bge%5D?}/{dueDate%5Ble%5D?}/{offset?}/{limit?}', [PagamentosController::class, 'index']);
    Route::patch('{id}', [PagamentosController::class, 'update'])->middleware('client');
    Route::delete('{id}', [PagamentosController::class, 'destroy'])->middleware('client');
    Route::post('{id}/restore', [PagamentosController::class, 'restore'])->middleware('client');
    Route::post('{id}/refund', [PagamentosController::class, 'refund'])->middleware('client');
    Route::post('{id}/receiveInCash', [PagamentosController::class, 'receiveInCash'])->middleware('client');
    Route::post('{id}/undoReceivedInCash', [PagamentosController::class, 'undoReceivedInCash'])->middleware('client');
});

Route::group([
    "prefix" => "installments"
], function () {
    Route::post('parcelado', [ParcelamentosController::class, 'store'])->middleware('client');
    Route::get('{id}', [ParcelamentosController::class, 'show'])->middleware('client');
    //Listar parcelamentos - GET - {offset?}/{limit?}
    Route::get('{offset?}/{limit?}', [ParcelamentosController::class, 'index'])->middleware('client');
    Route::delete('{id}', [ParcelamentosController::class, 'destroy'])->middleware('client');
    Route::post('{id}/refund', [ParcelamentosController::class, 'refund'])->middleware('client');
});

Route::group([
    "prefix" => "subscriptions"
], function () {
    //Boleto e cartão
    Route::post('/', [AssinaturasController::class, 'store'])->middleware('client');
    Route::get('{id}', [AssinaturasController::class, 'show'])->middleware('client');
// Listar assinaturas - GET - {customer?}/{billingType?}/{offset?}/{limit?}/{includeDeleted?}/{externalReference?}
    Route::get('{customer?}/{billingType?}/{offset?}/{limit?}/{includeDeleted?}/{externalReference?}', [AssinaturasController::class, 'index'])->middleware('client');
    Route::get('{id}/payments', [AssinaturasController::class, 'payments'])->middleware('client');
    Route::post('{id}', [AssinaturasController::class, 'update'])->middleware('client');
    Route::delete('{id}', [AssinaturasController::class, 'destroy'])->middleware('client');
// Listar notas fiscais das cobranças de uma assinatura - GET - {offset?}/{limit?}/{status?}
    Route::get('{id}/invoices/{offset?}/{limit?}/{status?}', [AssinaturasNotasController::class, 'index'])->middleware('client');
    Route::post('{id}/invoiceSettings', [AssinaturasNotasController::class, 'store'])->middleware('client');
    Route::patch('{id}/invoiceSettings', [AssinaturasNotasController::class, 'update'])->middleware('client');
    Route::get('{id}/invoiceSettings', [AssinaturasNotasController::class, 'show'])->middleware('client');
    Route::delete('{id}/invoiceSettings', [AssinaturasNotasController::class, 'destroy'])->middleware('client');
});

Route::group([
    "prefix" => "paymentLinks"
], function () {
    Route::post('/', [LinkPagamentoController::class, 'store']);
    Route::put('/', [LinkPagamentoController::class, 'update']);
    Route::get('{id}', [LinkPagamentoController::class, 'show']);
// Listar link de pagamentos - GET - {active?}/{includeDeleted?}/{name?}/{offset?}/{limit?}
    Route::get('{active?}/{includeDeleted?}/{name?}/{offset?}/{limit?}', [LinkPagamentoController::class, 'index']);
    Route::delete('{id}', [LinkPagamentoController::class, 'destroy']);
    Route::post('{id}/restore', [LinkPagamentoController::class, 'restore']);
    Route::post('{id}/images', [LinkImagemController::class, 'store']);
    Route::get('{paymentLinkId}/images/{imageId}', [LinkImagemController::class, 'show']);
    Route::get('{id}/images', [LinkImagemController::class, 'index']);
    Route::delete('{id}/images', [LinkImagemController::class, 'destroy']);
    Route::post('{paymentLinkId}/images/{imageId}/setAsMain', [LinkImagemController::class, 'setAsMain']);
});

Route::group([
    "prefix" => "notifications"
], function () {
    Route::patch('{id}', [NotificacaoController::class, 'update']);
});

Route::group([
    "prefix" => "transfers"
], function () {
    Route::post('/', [TransferenciasController::class, 'store']);
    Route::get('/', [TransferenciasController::class, 'index']);
});

Route::group([
    "prefix" => "anticipations"
], function () {
    Route::post('/', [AntecipacaoController::class, 'store']);
    Route::post('simulate', [AntecipacaoController::class, 'simulate']);
    Route::get('{id}}', [AntecipacaoController::class, 'show']);
// Listar antecipações - GET - {payment?}/{installment?}/{status?}/{offset?}/{limit?}
    Route::get('{payment?}/{installment?}/{status?}/{offset?}/{limit?}', [AntecipacaoController::class, 'index']);
});

Route::group([
    "prefix" => "paymentDunnings"
], function () {
    Route::post('/', [RecuperacaoController::class, 'store']);
    Route::post('simulate', [RecuperacaoController::class, 'simulate']);
    Route::get('{id}', [RecuperacaoController::class, 'show']);
// Listar recuperações - GET - {status?}/{type?}/{payment?}/{requestStartDate?}/{requestEndDate?}/{offset?}/{limit?}
    Route::get('{status?}/{type?}/{payment?}/{requestStartDate?}/{requestEndDate?}/{offset?}/{limit?}', [RecuperacaoController::class, 'index']);
// Listar histórico de eventos - GET - {offset?}/{limit?}
    Route::get('{id}/history/{offset?}/{limit?}', [RecuperacaoController::class, 'history']);
// Listar pagamentos recebidos - GET - {offset?}/{limit?}
    Route::get('{id}/partialPayments/{offset?}/{limit?}', [RecuperacaoController::class, 'partialPayments']);
// Listar cobranças disponíveis para recuperação - GET - {offset?}/{limit?}
    Route::get('paymentsAvailableForDunning/{offset?}/{limit?}', [RecuperacaoController::class, 'paymentsAvailableForDunning']);
    Route::post('{id}/documents', [RecuperacaoController::class, 'documents']);
    Route::post('{id}/cancel', [RecuperacaoController::class, 'destroy']);
});

Route::group([
    "prefix" => "paymentDunnings"
], function () {
    Route::post('/', [ContasController::class, 'store']);
    Route::post('bill/simulate', [ContasController::class, 'simulate']);
    Route::get('{id}', [ContasController::class, 'show']);
// Listar pagamento de contas - GET - {offset?}/{limit?}
    Route::get('{offset?}/{limit?}', [ContasController::class, 'index']);
    Route::post('{id}/cancel', [ContasController::class, 'destroy']);
});

Route::group([
    "prefix" => "creditBureauReport"
], function () {
    Route::post('/', [SerasaController::class, 'store']);
    Route::get('{id}', [SerasaController::class, 'show']);
// Listar consultas - GET - {startDate?}/{endDate?}/{offset?}/{limit?}
    Route::get('{startDate?}/{endDate?}/{offset?}/{limit?}', [SerasaController::class, 'index']);
});

Route::group([
    "prefix" => "financialTransaction"
], function () {
    Route::get('/', [ExtrartoController::class, 'show']);
});

Route::group([
    "prefix" => "myAccount"
], function () {
    Route::get('/', [MinhaContaController::class, 'show']);
    Route::post('paymentCheckoutConfig', [MinhaContaController::class, 'store']);
    Route::get('paymentCheckoutConfig', [MinhaContaController::class, 'paymentCheckoutConfig']);
});

Route::group([
    "prefix" => "invoices"
], function () {
    Route::post('/', [NotasFiscaisController::class, 'store']);
    Route::put('{id}', [NotasFiscaisController::class, 'update']);
    Route::get('{id}', [NotasFiscaisController::class, 'show']);
// Listar notas fiscais - GET - {effectiveDate%5Bge%5D?}/{effectiveDate%5Ble%5D?}/{payment?}/{installment?}/{status?}/{offset?}/{limit?}
    Route::get('{effectiveDate%5Bge%5D?}/{effectiveDate%5Ble%5D?}/{payment?}/{installment?}/{status?}/{offset?}/{limit?}', [NotasFiscaisController::class, 'index']);
    Route::post('{id}/authorizeApi', [NotasFiscaisController::class, 'authorizeApi']);
    Route::post('{id}/cancel', [NotasFiscaisController::class, 'destroy']);
// Listar serviços municipais - GET - {description?}
    Route::get('municipalServices/{description?}', [NotasFiscaisController::class, 'municipalServices']);
});

Route::group([
    "prefix" => "municipalOptions"
], function () {
    Route::get('/', [InformacoesFiscaisController::class, 'index']);
    Route::post('customerFiscalInfo', [InformacoesFiscaisController::class, 'store']);
    Route::get('customerFiscalInfo', [InformacoesFiscaisController::class, 'show']);
});

Route::group([
    "prefix" => "webhook"
], function () {
    Route::post('/', [WebhookController::class, 'store']);
    Route::get('/', [WebhookController::class, 'show']);
    Route::post('invoice', [WebhookController::class, 'invoiceStore']);
    Route::get('invoice', [WebhookController::class, 'invoiceShow']);
});

Route::group([
    "prefix" => "accounts"
], function () {
    Route::post('/', [ContasAsaasController::class, 'accounts']);
    Route::get('/', [ContasAsaasController::class, 'accounts']);
});
