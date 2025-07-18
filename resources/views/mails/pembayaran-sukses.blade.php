<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Konfirmasi Pembayaran</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 30px;
        }

        .email-container {
            max-width: 600px;
            background-color: #ffffff;
            padding: 30px;
            margin: auto;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        h2 {
            color: #2c3e50;
        }

        p {
            color: #555;
            line-height: 1.6;
        }

        .order-summary {
            margin-top: 20px;
            border-collapse: collapse;
            width: 100%;
        }

        .order-summary th,
        .order-summary td {
            border: 1px solid #eaeaea;
            padding: 10px;
            text-align: left;
        }

        .order-summary th {
            background-color: #f0f0f0;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 13px;
            color: #999;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <h2>Halo, {{ $order->user->name }}!</h2>

        <p>Terima kasih telah melakukan pembelian di <strong>Toko RD iPhone House</strong>. Kami telah menerima
            pembayaran
            Anda
            dengan detail sebagai berikut:</p>

        <table class="order-summary">
            <tr>
                <th>Kode Pesanan</th>
                <td>{{ $order->order_code }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td><strong style="color:green;">{{ ucfirst($order->status) }}</strong></td>
            </tr>
            <tr>
                <th>Metode Pembayaran</th>
                <td>{{ $order->midtrans_payment_type ?? '-' }}</td>
            </tr>
            <tr>
                <th>Total Pembayaran</th>
                <td>
                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                </td>
            </tr>
        </table>

        <p>Pesanan Anda akan segera kami proses dan kirim. Anda dapat memantau status pesanan melalui akun anda.</p>

        <p>Jika ada pertanyaan atau butuh bantuan, silakan hubungi kami.</p>

        <p>Salam hangat,<br><strong>RD iPhone House</strong></p>

        <div class="footer">
            &copy; {{ date('Y') }} RD iPhone House. Semua Hak Dilindungi.
        </div>
    </div>
</body>

</html>
