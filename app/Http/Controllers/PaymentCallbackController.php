<?php declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Zobay\LaravelSslCommerz\Exceptions\OrderValidationException;
use Zobay\LaravelSslCommerz\Facades\SslCommerz;

class PaymentCallbackController extends Controller
{
    public function success(Request $request): View
    {
        $valId    = $request->input('val_id');
        $tranId   = $request->input('tran_id');
        $amount   = (float) $request->input('amount');
        $currency = $request->input('currency', 'BDT');

        try {
            $result = SslCommerz::validateOrder($valId, $tranId, $amount, $currency);
        } catch (OrderValidationException $e) {
            return view('payment.fail', [
                'reason' => 'Payment validation failed: ' . $e->getMessage(),
            ]);
        }

        if (! $result->isValid()) {
            return view('payment.fail', [
                'reason' => 'Payment status: ' . $result->status->value,
            ]);
        }

        return view('payment.success', [
            'tranId'   => $result->tranId,
            'valId'    => $result->valId,
            'amount'   => $result->amount,
            'currency' => $result->currency,
            'cardType' => $result->cardType,
        ]);
    }

    public function fail(Request $request): View
    {
        return view('payment.fail', [
            'reason' => $request->input('failedreason', 'Your payment could not be processed.'),
        ]);
    }

    public function cancel(): View
    {
        return view('payment.cancel');
    }

    public function ipn(Request $request): Response
    {
        if (! SslCommerz::verifyIpnHash($request->all())) {
            return response('Invalid IPN signature', 400);
        }

        return response('IPN received', 200);
    }
}
