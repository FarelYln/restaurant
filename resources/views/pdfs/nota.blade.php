<!DOCTYPE html>
<html>
<head>
    <title>Nota Pembayaran - {{ $reservasi->id }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap');
        
        body {
            font-family: 'Roboto', Arial, sans-serif;
            margin: 0;
            padding: 15px;
            background-color: #f4f4f4;
            color: #333;
            line-height: 1.4;
            font-size: 12px;
        }
        .invoice-container {
            background-color: white;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }
        .invoice-header h1 {
            margin: 0;
            color: #007bff;
            font-size: 18px;
        }
        .invoice-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .invoice-details div {
            width: 48%;
        }
        .invoice-details h3 {
            border-bottom: 1px solid #e0e0e0;
            padding-bottom: 5px;
            margin-bottom: 5px;
            color: #007bff;
            font-size: 14px;
        }
        .invoice-details p {
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            font-size: 11px;
        }
        th {
            background-color: #f8f9fa;
            color: #333;
            font-weight: bold;
            padding: 8px;
            text-align: left;
            border: 1px solid #e0e0e0;
            font-size: 11px;
        }
        td {
            padding: 8px;
            border: 1px solid #e0e0e0;
        }
        .total-row {
            font-weight: bold;
            background-color: #f8f9fa;
        }
        .payment-details {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            font-size: 12px;
        }
        .footer {
            text-align: center;
            margin-top: 10px;
            color: #6c757d;
            font-size: 10px;
            border-top: 1px solid #e0e0e0;
            padding-top: 10px;
        }
        .text-right {
            text-align: right;
        }
        @media print {
            body {
                padding: 0;
            }
            .invoice-container {
                box-shadow: none;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="invoice-header">
            <h1>Nota Pembayaran</h1>
            <div>
                <strong>ID Reservasi:</strong> {{ $reservasi->id_reservasi }}
            </div>
        </div>

        <div class="invoice-details">
            <div>
                <h3>Detail Reservasi</h3>
                <p><strong>Tanggal:</strong> {{ $reservasi->tanggal_reservasi->format('d M Y H:i') }}</p>
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
                <h3>Kontak</h3>
                <p><strong>Nama:</strong> {{ $reservasi->user->name }}</p>
                <p><strong>Email:</strong> {{ $reservasi->user->email }}</p>
            </div>
        </div>

        <h3>Detail Pesanan</h3>
        <table>
            <thead>
                <tr>
                    <th>Menu</th>
                    <th class="text-right">Jumlah</th>
                    <th class="text-right">Harga Satuan</th>
                    <th class="text-right">Subtotal</th>
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
                        <td class="text-right">{{ $menu->pivot->jumlah_pesanan }}</td>
                        <td class="text-right">Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                        <td class="text-right">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td colspan="3" class="text-right"><strong>Total Harga</strong></td>
                    <td class="text-right"><strong>Rp {{ number_format($totalHarga, 0, ',', '.') }}</strong></td>
                </tr>
            </tfoot>
        </table>

        <div class="payment-details">
            <h3>Detail Pembayaran</h3>
            <div class="invoice-details">
                <div>
                    <p><strong>Total Harga:</strong> Rp {{ number_format($totalHarga, 0, ',', '.') }}</p>
                    <p><strong>Metode Pembayaran:</strong> {{ str_replace('_', ' ', $reservasi->metode_pembayaran) }}</p>
                </div>
                <div>
                    <p><strong>Jumlah Pembayaran:</strong> Rp {{ number_format($reservasi->total_bayar, 0, ',', '.') }}</p>
                    <p><strong>Media Pembayaran:</strong>
                        @if($reservasi->media_pembayaran)
                            {{ strtoupper($reservasi->media_pembayaran) }} ({{ $reservasi->nomor_media }})
                        @else
                            Tidak Ada
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <div class="footer">
            <p>Terima kasih telah melakukan reservasi di restoran kami</p>
            <p>&copy; {{ date('Y') }} Restoran. All rights reserved.</p>
        </div>
    </div>
</body>
</html>