<!DOCTYPE html>
<html>
<head>
    <title>Nota Pembayaran - {{ $reservasi->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12px;
        }
        .container {
            max-width: 100%;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Nota Pembayaran</h2>
        </div>

        <div>
            <h3>Detail Reservasi</h3>
            <p><strong>ID Reservasi:</strong> {{ $reservasi->id_reservasi }}</p>
            <p><strong>Tanggal Reservasi:</strong> {{ $reservasi->tanggal_reservasi->format('d M Y H:i') }}</p>
            <p><strong>Meja:</strong>
                @foreach($reservasi->meja as $meja)
                    {{ $meja->nomor_meja }} 
                    (Lantai: {{ $meja->location->floor ?? 'Tidak diketahui' }}, 
                    {{ ucfirst($meja->location->name ?? 'tidak diketahui') }})
                    @if(!$loop->last), @endif
                @endforeach
            </p>
        </div>

        <div>
            <h3>Pesanan Menu</h3>
            <table>
                <thead>
                    <tr>
                        <th>Menu</th>
                        <th>Jumlah</th>
                        <th>Harga Satuan</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @php $totalHarga = 0; @endphp
                    @foreach($reservasi->menus as $menu)
                        @php
                            $subtotal = $menu->pivot->jumlah_pesanan * $menu->harga;
                            $totalHarga += $subtotal;
                        @endphp
                        <tr>
                            <td>{{ $menu->nama_menu }}</td>
                            <td>{{ $menu->pivot->jumlah_pesanan }}</td>
                            <td>Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" style="text-align:right;"><strong>Total Harga</strong></td>
                        <td><strong>Rp {{ number_format($totalHarga, 0, ',', '.') }}</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div>
            <h3>Detail Pembayaran</h3>
            <p><strong>Total Harga:</strong> Rp {{ number_format($totalHarga, 0, ',', '.') }}</p>
            <p><strong>Jumlah Pembayaran:</strong> Rp {{ number_format($reservasi->total_bayar, 0, ',', '.') }}</p>
            <p><strong>Metode Pembayaran:</strong> {{ str_replace('_', ' ', $reservasi->metode_pembayaran) }}</p>
            <p><strong>Media Pembayaran:</strong>
                @if($reservasi->media_pembayaran)
                    {{ strtoupper($reservasi->media_pembayaran) }} ({{ $reservasi->nomor_media }})
                @else
                    Tidak Ada
                @endif
            </p>
        </div>

        <div class="footer">
            <p>Terima kasih telah melakukan reservasi</p>
        </div>
    </div>
</body>
</html>