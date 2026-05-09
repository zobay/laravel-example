<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validate Transaction</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: #f5f5f5; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 24px; }
        .wrap { width: 100%; max-width: 520px; display: flex; flex-direction: column; gap: 20px; }
        .card { background: #fff; border-radius: 12px; box-shadow: 0 2px 16px rgba(0,0,0,.08); padding: 32px; }
        h1 { font-size: 1.3rem; font-weight: 700; color: #1a1a1a; margin-bottom: 6px; }
        .sub { color: #666; font-size: .875rem; margin-bottom: 24px; }
        .field { margin-bottom: 16px; }
        label { display: block; font-size: .85rem; font-weight: 600; color: #444; margin-bottom: 6px; }
        input, select { width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 8px; font-size: .95rem; color: #1a1a1a; outline: none; transition: border .15s; }
        input:focus, select:focus { border-color: #2d6a4f; }
        .field-error { color: #b91c1c; font-size: .8rem; margin-top: 4px; }
        .btn { display: block; width: 100%; padding: 12px; background: #2d6a4f; color: #fff; border: none; border-radius: 8px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: background .15s; }
        .btn:hover { background: #1b4332; }

        /* Alert */
        .alert { border-radius: 8px; padding: 12px 16px; font-size: .9rem; margin-bottom: 20px; }
        .alert-error { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }

        /* Result */
        .result-card { border-radius: 12px; box-shadow: 0 2px 16px rgba(0,0,0,.08); padding: 28px 32px; }
        .result-card.valid   { background: #f0fdf4; border: 1px solid #bbf7d0; }
        .result-card.invalid { background: #fef2f2; border: 1px solid #fecaca; }
        .result-header { display: flex; align-items: center; gap: 10px; margin-bottom: 20px; }
        .result-icon { font-size: 1.8rem; }
        .result-title { font-size: 1.15rem; font-weight: 700; }
        .result-card.valid   .result-title { color: #15803d; }
        .result-card.invalid .result-title { color: #b91c1c; }
        table { width: 100%; border-collapse: collapse; }
        td { padding: 9px 4px; border-bottom: 1px solid rgba(0,0,0,.06); font-size: .875rem; }
        td:first-child { font-weight: 600; color: #555; width: 48%; }
        td:last-child { color: #1a1a1a; word-break: break-all; }
        .badge { display: inline-block; padding: 2px 8px; border-radius: 99px; font-size: .75rem; font-weight: 700; }
        .badge-valid   { background: #dcfce7; color: #166534; }
        .badge-invalid { background: #fee2e2; color: #991b1b; }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="card">
            <h1>Validate Transaction</h1>
            <p class="sub">Enter the transaction details from SSLCommerz to verify its status.</p>

            @if ($error ?? null)
                <div class="alert alert-error">{{ $error }}</div>
            @endif

            <form method="POST" action="{{ route('transaction.validate') }}">
                @csrf

                <div class="field">
                    <label for="val_id">Validation ID <span style="color:#b91c1c">*</span></label>
                    <input type="text" id="val_id" name="val_id" value="{{ old('val_id') }}" placeholder="e.g. 25030417344..." autocomplete="off">
                    @error('val_id') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                <div class="field">
                    <label for="tran_id">Transaction ID <span style="color:#b91c1c">*</span></label>
                    <input type="text" id="tran_id" name="tran_id" value="{{ old('tran_id') }}" placeholder="e.g. TXN-ABC123..." autocomplete="off">
                    @error('tran_id') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                <div class="field">
                    <label for="amount">Amount <span style="color:#b91c1c">*</span></label>
                    <input type="number" id="amount" name="amount" value="{{ old('amount') }}" placeholder="e.g. 1500.00" step="0.01" min="0.01">
                    @error('amount') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                <div class="field">
                    <label for="currency">Currency <span style="color:#b91c1c">*</span></label>
                    <select id="currency" name="currency">
                        @foreach (['BDT', 'USD', 'EUR', 'GBP', 'SGD'] as $cur)
                            <option value="{{ $cur }}" @selected(old('currency', 'BDT') === $cur)>{{ $cur }}</option>
                        @endforeach
                    </select>
                    @error('currency') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                <button type="submit" class="btn">Validate Transaction</button>
            </form>
        </div>

        @if ($result ?? null)
            <div class="result-card {{ $result->isValid() ? 'valid' : 'invalid' }}">
                <div class="result-header">
                    <span class="result-icon">{{ $result->isValid() ? '✅' : '❌' }}</span>
                    <span class="result-title">{{ $result->isValid() ? 'Transaction Valid' : 'Transaction Invalid' }}</span>
                </div>
                <table>
                    <tr><td>Status</td><td><span class="badge {{ $result->isValid() ? 'badge-valid' : 'badge-invalid' }}">{{ $result->status->value }}</span></td></tr>
                    <tr><td>Transaction ID</td><td>{{ $result->tranId }}</td></tr>
                    <tr><td>Validation ID</td><td>{{ $result->valId }}</td></tr>
                    <tr><td>Amount</td><td>{{ $result->currency }} {{ number_format($result->amount, 2) }}</td></tr>
                    <tr><td>Store Amount</td><td>{{ $result->currency }} {{ number_format($result->storeAmount, 2) }}</td></tr>
                    <tr><td>Bank Tran ID</td><td>{{ $result->bankTranId }}</td></tr>
                    <tr><td>Card Type</td><td>{{ $result->cardType }}</td></tr>
                    <tr><td>Card Brand</td><td>{{ $result->cardBrand }}</td></tr>
                    @if ($result->cardNo)
                        <tr><td>Card No</td><td>{{ $result->cardNo }}</td></tr>
                    @endif
                    @if ($result->cardIssuer)
                        <tr><td>Card Issuer</td><td>{{ $result->cardIssuer }}</td></tr>
                    @endif
                    <tr><td>Risk Level</td><td>{{ $result->riskLevel }} — {{ $result->riskTitle }}</td></tr>
                </table>
            </div>
        @endif
    </div>
</body>
</html>
