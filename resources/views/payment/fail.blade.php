<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Failed</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: #f5f5f5; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .card { background: #fff; border-radius: 12px; box-shadow: 0 2px 16px rgba(0,0,0,.08); padding: 40px 32px; width: 100%; max-width: 440px; text-align: center; }
        .icon { font-size: 3.5rem; margin-bottom: 16px; }
        h1 { font-size: 1.5rem; color: #b91c1c; margin-bottom: 12px; }
        .reason { color: #555; font-size: .95rem; margin-bottom: 28px; line-height: 1.5; }
        .btn { display: inline-block; padding: 12px 28px; background: #b91c1c; color: #fff; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: .95rem; }
        .btn:hover { background: #991b1b; }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon">❌</div>
        <h1>Payment Failed</h1>
        <p class="reason">{{ $reason ?? 'Your payment could not be processed. Please try again.' }}</p>
        <a href="{{ route('checkout.show') }}" class="btn">Try Again</a>
    </div>
</body>
</html>
