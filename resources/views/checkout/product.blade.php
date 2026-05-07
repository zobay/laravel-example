<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: #f5f5f5; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .card { background: #fff; border-radius: 12px; box-shadow: 0 2px 16px rgba(0,0,0,.08); padding: 32px; width: 100%; max-width: 440px; }
        .product-icon { font-size: 3rem; margin-bottom: 16px; }
        .product-name { font-size: 1.3rem; font-weight: 600; color: #1a1a1a; margin-bottom: 6px; }
        .product-desc { color: #666; font-size: .9rem; margin-bottom: 24px; }
        .price-row { display: flex; align-items: baseline; gap: 6px; margin-bottom: 28px; }
        .currency { font-size: 1rem; font-weight: 600; color: #2d6a4f; }
        .amount { font-size: 2rem; font-weight: 700; color: #2d6a4f; }
        .divider { border: none; border-top: 1px solid #eee; margin-bottom: 24px; }
        .error { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; border-radius: 6px; padding: 10px 14px; margin-bottom: 20px; font-size: .9rem; }
        .btn { display: block; width: 100%; padding: 14px; background: #2d6a4f; color: #fff; border: none; border-radius: 8px; font-size: 1rem; font-weight: 600; cursor: pointer; letter-spacing: .01em; transition: background .15s; }
        .btn:hover { background: #1b4332; }
        .secure-note { text-align: center; margin-top: 14px; color: #999; font-size: .8rem; }
    </style>
</head>
<body>
    <div class="card">
        <div class="product-icon">🎧</div>
        <div class="product-name">{{ $product['name'] }}</div>
        <div class="product-desc">High-fidelity audio · Noise cancellation · 30hr battery</div>

        <div class="price-row">
            <span class="currency">{{ $product['currency'] }}</span>
            <span class="amount">{{ number_format($product['price'], 2) }}</span>
        </div>

        <hr class="divider">

        @if (session('error'))
            <div class="error">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('checkout.initiate') }}">
            @csrf
            <button type="submit" class="btn">Proceed to Checkout</button>
        </form>

        <p class="secure-note">🔒 Secured by SSLCommerz</p>
    </div>
</body>
</html>
