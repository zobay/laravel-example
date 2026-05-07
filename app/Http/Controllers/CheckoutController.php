<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\InitiateCheckoutAction;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Zobay\LaravelSslCommerz\Exceptions\PaymentInitiationException;

class CheckoutController extends Controller
{
    public function show(): View
    {
        $product = [
            'name'     => 'Premium Wireless Headphones',
            'price'    => 1500.00,
            'currency' => 'BDT',
        ];

        return view('checkout.product', compact('product'));
    }

    public function initiate(InitiateCheckoutAction $action): RedirectResponse
    {
        try {
            $session = $action->execute();
        } catch (PaymentInitiationException $e) {
            return redirect()->route('checkout.show')
                ->with('error', 'Unable to initiate payment: ' . $e->getMessage());
        }

        return redirect()->away($session->gatewayPageUrl);
    }
}
