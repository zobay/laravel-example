<?php declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Zobay\LaravelSslCommerz\DTOs\ValidationRequest;
use Zobay\LaravelSslCommerz\DTOs\ValidationResult;
use Zobay\LaravelSslCommerz\Exceptions\OrderValidationException;
use Zobay\LaravelSslCommerz\Facades\SslCommerz;

class TransactionValidationController extends Controller
{
    public function show(): View
    {
        return view('transaction.validate');
    }

    public function validate(Request $request): View
    {
        $validated = $request->validate([
            'val_id'   => ['required', 'string'],
            'tran_id'  => ['required', 'string'],
            'amount'   => ['required', 'numeric', 'min:0.01'],
            'currency' => ['required', 'string', 'size:3'],
        ]);

        $result = null;
        $error  = null;

        try {
            $result = SslCommerz::validateOrder(new ValidationRequest(
                valId:    $validated['val_id'],
                tranId:   $validated['tran_id'],
                amount:   (float) $validated['amount'],
                currency: $validated['currency'],
            ));
        } catch (OrderValidationException $e) {
            $error = $e->getMessage();
        }

        return view('transaction.validate', compact('result', 'error'));
    }
}
