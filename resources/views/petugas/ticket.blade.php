<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Tiket Parkir #{{ $parking->id }}</title>
    <style>
        body { font-family: sans-serif; }
        .ticket { border: 2px dashed #333; padding: 20px; width: 300px; }
        .qr { text-align: center; margin: 10px 0; }
        .info { margin-top: 10px; font-size: 14px; }
    </style>
</head>
<body>
    <div class="ticket">
        <h2 style="text-align:center;">Tiket Parkir</h2>
        <p><strong>ID Parkir:</strong> {{ $parking->id }}</p>
        <p><strong>Waktu Masuk:</strong> {{ $parking->check_in->format('d/m/Y H:i') }}</p>

        <div class="qr" style="text-align:center; margin:10px 0;">
            <img src="{{ public_path('qrcodes_tickets/' . $parking->qr_code) }}" alt="QR Code" width="150" height="150">
        </div>

        <div class="info">
            <p>Silakan simpan tiket ini untuk melakukan scan out.</p>
            <hr>
            <p><strong>Kebijakan Biaya Parkir:</strong></p>
            <ul>
                <li>Motor: Rp 3.000 untuk 3 jam pertama, Rp 2.000 per jam tambahan, maksimal Rp 10.000</li>
                <li>Mobil: 2x tarif motor, maksimal Rp 20.000</li>
                <li>Pastikan membawa tiket ini saat keluar untuk perhitungan pembayaran</li>
            </ul>
        </div>
    </div>
</body>
</html>
