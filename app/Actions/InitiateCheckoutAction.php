<?php declare(strict_types=1);

namespace App\Actions;

use Zobay\LaravelSslCommerz\Data\CustomerInfo;
use Zobay\LaravelSslCommerz\Data\PaymentRequest;
use Zobay\LaravelSslCommerz\Data\PaymentSession;
use Zobay\LaravelSslCommerz\Data\ProductInfo;
use Zobay\LaravelSslCommerz\Data\ShipmentInfo;
use Zobay\LaravelSslCommerz\Enums\ProductProfile;
use Zobay\LaravelSslCommerz\Enums\ShippingMethod;
use Zobay\LaravelSslCommerz\Facades\SslCommerz;

class InitiateCheckoutAction
{
    public function execute(): PaymentSession
    {
        $tranId = 'TXN-' . strtoupper(uniqid());

        $request = new PaymentRequest(
            tranId: $tranId,
            totalAmount: 1500.00,
            currency: 'BDT',
            successUrl: config('sslcommerz.success_url'),
            failUrl: config('sslcommerz.fail_url'),
            cancelUrl: config('sslcommerz.cancel_url'),
            ipnUrl: config('sslcommerz.ipn_url'),
            customer: new CustomerInfo(
                name: 'Demo Customer',
                email: 'customer@example.com',
                phone: '01700000000',
                address1: 'Dhaka',
                city: 'Dhaka',
                country: 'Bangladesh',
            ),
            shipment: new ShipmentInfo(
                method: ShippingMethod::No,
            ),
            product: new ProductInfo(
                name: 'Premium Wireless Headphones',
                category: 'Electronics',
                profile: ProductProfile::General,
            ),
        );

        return SslCommerz::initiatePayment($request);
    }
}
