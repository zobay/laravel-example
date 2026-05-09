<?php declare(strict_types=1);

namespace App\Actions;

use Zobay\LaravelSslCommerz\DTOs\CustomerData;
use Zobay\LaravelSslCommerz\DTOs\PaymentRequestData;
use Zobay\LaravelSslCommerz\DTOs\PaymentResponseData;
use Zobay\LaravelSslCommerz\DTOs\ProductData;
use Zobay\LaravelSslCommerz\DTOs\ShipmentData;
use Zobay\LaravelSslCommerz\Enums\ProductProfile;
use Zobay\LaravelSslCommerz\Enums\ShippingMethod;
use Zobay\LaravelSslCommerz\Facades\SslCommerz;

class InitiateCheckoutAction
{
    public function execute(): PaymentResponseData
    {
        $tranId = 'TXN-' . strtoupper(uniqid());

        $request = new PaymentRequestData(
            tranId: $tranId,
            totalAmount: 1500.00,
            currency: 'BDT',
            successUrl: route('payment.success'),
            failUrl: route('payment.fail'),
            cancelUrl: route('payment.cancel'),
            customer: new CustomerData(
                name: 'Demo Customer',
                email: 'customer@example.com',
                phone: '01700000000',
                address1: 'Dhaka',
                city: 'Dhaka',
                country: 'Bangladesh',
            ),
            product: new ProductData(
                name: 'Premium Wireless Headphones',
                category: 'Electronics',
                profile: ProductProfile::General,
            ),
            shipment: new ShipmentData(
                method: ShippingMethod::No,
            ),
            ipnUrl: route('payment.ipn'),
        );

        return SslCommerz::initiatePayment($request);
    }
}
