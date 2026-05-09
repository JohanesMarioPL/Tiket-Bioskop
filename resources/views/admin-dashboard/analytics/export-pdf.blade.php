<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Analitik Penjualan Tiket Bioskop</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            color: #1f2937;
        }
        
        .header {
            background-color: #344152;
            color: #ffffff;
            padding: 30px 40px;
            position: relative;
        }
        .header h1 { margin: 0; font-size: 28px; font-weight: bold; tracking: 1px; }
        .header p { margin: 5px 0 0 0; font-size: 14px; font-weight: normal; }
        .print-date { position: absolute; right: 40px; top: 40px; font-size: 11px; }

        .content { padding: 30px 40px; }

        .section-title { font-size: 14px; font-weight: bold; color: #1f2937; margin-bottom: 5px; }
        .info-text { font-size: 12px; color: #475569; margin: 3px 0; }
        .divider { border-bottom: 1px solid #e2e8f0; margin: 15px 0 20px 0; }

        .metrics-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .metrics-table td { padding: 8px 5px; font-size: 12px; }
        .metrics-label { font-weight: bold; color: #475569; width: 45%; }
        .metrics-val-green { font-weight: bold; color: #15803d; }
        .metrics-val-dark { font-weight: bold; color: #1f2937; }

        .data-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .data-table th {
            background-color: #344152;
            color: #ffffff;
            font-weight: bold;
            font-size: 11px;
            padding: 10px 8px;
            text-align: left;
        }
        .data-table td {
            padding: 10px 8px;
            font-size: 11px;
            border-bottom: 1px solid #f1f5f9;
        }
        .data-table tbody tr:nth-child(even) { background-color: #f8fafc; }
        .col-id { font-weight: bold; color: #475569; }
        .col-total { font-weight: bold; color: #15803d; text-align: right; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }

        .footer {
            margin-top: 40px;
            font-size: 10px;
            font-style: italic;
            color: #9ca3af;
            line-height: 1.5;
        }
    </style>
</head>
<body>

    <div class="header">
        <h3>ADMINBIOSKOP</h3>
        <p>Laporan Analitik & Performa Penjualan Tiket Bioskop</p>
        <div class="print-date">Dicetak: {{ $printDate }}</div>
    </div>

    <div class="content">
        <div class="section-title">Informasi Periode Laporan</div>
        <div class="info-text">Periode Waktu: {{ $periodTitle }}</div>
        <div class="info-text">Rentang Tanggal: {{ $periodRange }}</div>
        
        <div class="divider"></div>

        <div class="section-title" style="margin-bottom: 10px;">Ringkasan Laporan</div>
        <table class="metrics-table">
            <tr>
                <td class="metrics-label">Total Pendapatan</td>
                <td class="metrics-val-green">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="metrics-label">Total Tiket Terjual</td>
                <td class="metrics-val-dark">{{ number_format($totalTiketTerjual, 0, ',', '.') }} Pcs</td>
            </tr>
            <tr>
                <td class="metrics-label">Total Transaksi Berhasil</td>
                <td class="metrics-val-dark">{{ number_format($transaksiSukses, 0, ',', '.') }} Order</td>
            </tr>
        </table>

        <div class="section-title">Daftar Riwayat Transaksi Pembelian</div>
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 15%;">Tanggal</th>
                    <th style="width: 27%;">ID Pesanan</th>
                    <th style="width: 28%;">Nama Pembeli</th>
                    <th style="width: 10%;" class="text-center">Jumlah Tiket</th>
                    <th style="width: 20%;" class="text-right">Total Pembayaran</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $trx)
                    <tr>
                        <td>{{ $trx->created_at->format('d M Y') }}</td>
                        <td class="col-id">#{{ $trx->transaction_code }}</td>
                        <td>{{ $trx->user->name ?? 'User Tidak Dikenal' }}</td>
                        <td class="text-center">{{ $trx->tickets->count() }} Pcs</td>
                        <td class="col-total">Rp {{ number_format($trx->total_amount, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center" style="padding: 20px; color:#9ca3af;">Tidak ada transaksi pada periode ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="footer">
            * Laporan ini dibuat secara otomatis dari Sistem AdminBioskop<br>
        </div>
    </div>

</body>
</html>