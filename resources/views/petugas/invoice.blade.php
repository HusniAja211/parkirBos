<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Struk Parkir #{{ $parking->id }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .container { width: 300px; padding: 10px; border: 1px solid #000; }
        .qr { text-align: center; margin: 10px 0; }
        .info { margin-top: 10px; }
        hr { border: 1px dashed #000; }
    </style>
</head>
<body>
    <div class="container">
        <h3 style="text-align:center;">Struk Parkir</h3>
        <p><strong>ID Parkir:</strong> {{ $parking->id }}</p>
        <p><strong>Plat Nomor:</strong> {{ $payment->license_plate }}</p>
        <p><strong>Kategori:</strong> {{ $payment->kategori }}</p>
        <p><strong>Waktu Masuk:</strong> {{ $parking->check_in->format('d/m/Y H:i') }}</p>
        <p><strong>Waktu Keluar:</strong> {{ $parking->check_out->format('d/m/Y H:i') }}</p>
        <p><strong>Total Biaya:</strong> Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
        <p><strong>Uang Diterima:</strong> Rp {{ number_format($payment->cash, 0, ',', '.') }}</p>
        <p><strong>Kembalian:</strong> Rp {{ number_format($payment->change, 0, ',', '.') }}</p>

        <div class="info">
            <hr>
            <p>Silakan simpan struk ini untuk keluar parkir.</p>
        </div>
    </div>
</body>
</html>
