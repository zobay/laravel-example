<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: #f5f5f5; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .card { background: #fff; border-radius: 12px; box-shadow: 0 2px 16px rgba(0,0,0,.08); padding: 40px 32px; width: 100%; max-width: 480px; text-align: center; }
        .icon { font-size: 3.5rem; margin-bottom: 16px; }
        h1 { font-size: 1.5rem; color: #2d6a4f; margin-bottom: 8px; }
        .sub { color: #666; font-size: .95rem; margin-bottom: 28px; }
        table { width: 100%; border-collapse: collapse; text-align: left; margin-bottom: 28px; }
        td { padding: 10px 4px; border-bottom: 1px solid #f0f0f0; font-size: .9rem; }
        td:first-child { font-weight: 600; color: #444; width: 45%; }
        td:last-child { color: #1a1a1a; word-break: break-all; }
        .btn { display: inline-block; padding: 12px 28px; background: #2d6a4f; color: #fff; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: .95rem; }
        .btn:hover { background: #1b4332; }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon">✅</div>
        <h1>Payment Successful</h1>
        <p class="sub">Your payment has been processed and verified.</p>

        <table>
            <tr><td>Transaction ID</td><td>{{ $tranId }}</td></tr>
            <tr><td>Validation ID</td><td>{{ $valId }}</td></tr>
            <tr><td>Amount</td><td>{{ $currency }} {{ number_format($amount, 2) }}</td></tr>
            <tr><td>Card Type</td><td>{{ $cardType }}</td></tr>
        </table>

        <a href="{{ route('checkout.show') }}" class="btn">Back to Shop</a>
    </div>
</body>
</html>
