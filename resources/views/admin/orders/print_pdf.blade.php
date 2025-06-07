<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Data Pengiriman</title>
</head>

<body style="font-family: sans-serif; font-size: 12px; margin: 20px;">
    <h2 style="text-align: center;">Data Pengiriman Produk</h2>

    <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
        <!-- Pengirim -->
        <div>
            <h4>Data Pengirim</h4>
            <p><strong>Nama:</strong> {{ $store->name }}</p>
            <p><strong>Alamat:</strong> {{ $store->address }}</p>
            <p><strong>No. HP:</strong> {{ $store->phone }}</p>
        </div>

        <!-- Penerima -->
        <div style="width: 48%;">
            <h4>Data Penerima</h4>
            <p> {{ $order->alamat_pengiriman }}</p>
        </div>
    </div>

    <!-- Informasi Umum -->
    <div style="margin-bottom: 20px;">
        <p><strong>Ekspedisi:</strong> {{ $order->ongkir->ekspedisi }}</p>
        <p><strong>Paket:</strong> {{ $order->ongkir->layanan }}</p>
        <p><strong>Tanggal Pemesanan:</strong> {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y H:i') }}</p>
    </div>

    <!-- Tabel Produk -->
    <h4>Daftar Produk</h4>
    <table style="width: 100%; border-collapse: collapse; font-style: ce" border="1" cellpadding="5">
        <thead>
            <tr>
                <th>No</th>
                <th>Produk</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->orderItems as $item)
                <tr>
                    <td style="text-align: center; vertical-align: middle;">{{ $loop->iteration }}</td>
                    <td style="text-align: center; vertical-align: middle;">{{ $item->product->name }}</td>
                    <td style="text-align: center; vertical-align: middle;">{{ $item->quantity }}</td>
                </tr>
            @endforeach
        </tbody>
        {{-- <tfoot>
            <tr>
                <td colspan="4" style="text-align: right;"><strong>Total</strong></td>
                <td><strong>Rp{{ number_format($order->total, 0, ',', '.') }}</strong></td>
            </tr>
        </tfoot> --}}
    </table>
</body>

</html>
