<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>E-Ticket Jember 10k Trail Run</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px; }
        .container { max-width: 600px; background: #ffffff; padding: 30px; border-radius: 8px; margin: auto; }
        .header { text-align: center; border-bottom: 2px solid #22c55e; padding-bottom: 15px; }
        .header h2 { color: #15803d; margin: 0; }
        .ticket-info { margin: 20px 0; background: #f8fafc; padding: 15px; border-radius: 6px; }
        .ticket-info table { width: 100%; border-collapse: collapse; }
        .ticket-info td { padding: 8px 0; border-bottom: 1px dashed #cbd5e1; }
        .badge { background: #22c55e; color: #fff; padding: 4px 12px; border-radius: 12px; font-weight: bold; font-size: 12px; }
        .footer { text-align: center; margin-top: 25px; font-size: 12px; color: #64748b; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>JEMBER 10K TRAIL RUN</h2>
            <p>Bukti Pembayaran & E-Ticket Resmi</p>
        </div>

        <p>Halo, <strong>{{ $registration->full_name }}</strong>!</p>
        <p>Pembayaran pendaftaran kamu telah kami terima. Berikut adalah rincian E-Ticket resmi kamu:</p>

        <div class="ticket-info">
            <table>
                <tr>
                    <td><strong>Order ID</strong></td>
                    <td>: {{ $registration->order_id }}</td>
                </tr>
                <tr>
                    <td><strong>Status Pembayaran</strong></td>
                    <td>: <span class="badge">LUNAS</span></td>
                </tr>
                <tr>
                    <td><strong>Ukuran Jersey</strong></td>
                    <td>: {{ $registration->jersey_size }}</td>
                </tr>
                <tr>
                    <td><strong>Nomor WhatsApp</strong></td>
                    <td>: {{ $registration->whatsapp_number }}</td>
                </tr>
                <tr>
                    <td><strong>Tanggal Lunas</strong></td>
                    <td>: {{ $registration->paid_at?->format('d M Y, H:i') }} WIB</td>
                </tr>
            </table>
        </div>

        <p>Tunjukkan email ini saat pengambilan Race Pack (RPC). Sampai jumpa di garis start!</p>

        <div class="footer">
            <p>&copy; Panitia Jember 10k Trail Run. Email ini dikirim secara otomatis.</p>
        </div>
    </div>
</body>
</html>