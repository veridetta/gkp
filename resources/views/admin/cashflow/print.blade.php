<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penerimaan dan Pengeluaran Kas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        h3, h4, h5 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
            font-size: 14px;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        .cogs {
            font-size: 18px;
        }

        .cogs:hover {
            color: blue;
            cursor: pointer;
        }

        @media print {
            @page {
                size: auto;
                margin: 0mm;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h3 style="line-height: 0.5">{{ get_my_app_config('nama') }}</h3>
        <h4 style="line-height: 0.5">{{ get_my_app_config('alamat') }}</h4>
        <h4 style="line-height: 0.5">Laporan Penerimaan dan Pengeluaran Kas</h4>
        <h5 style="line-height: 0.5">Bulan {{ getIndonesiaMonth($month) }} {{ $year }}</h5>
        <hr>
        <p style="line-height: 0.5">Dicetak pada : {{ date('d F Y H:i:s') }}</p>
        <p style="line-height: 0.5">Oleh : {{ auth()->user()->name }}</p>
        <p style="line-height: 0.5">Saldo Bulan Sebelumnya : Rp. {{ number_format($total_saldo_sebelumnya, 0, ',', '.') }}</p>
        <table id="datatable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th class="text-center">Keterangan</th>
                    <th class="text-center">Masuk</th>
                    <th class="text-center">Keluar</th>
                    {{-- <th class="text-center">Bukti</th> --}}
                    <th class="text-center">Petugas</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                @foreach ($data as $data)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $data->date }}</td>
                        <td>{{ $data->description }}</td>
                        <td>{{ 'Rp. ' . number_format($data->in, 0, ',', '.') }}</td>
                        <td>{{ 'Rp. ' . number_format($data->out, 0, ',', '.') }}</td>
                        {{-- <td>
                            @if ($data->image)
                                <a href="{{ url('storage/cashflow/' . $data->image) }}" target="_blank">Lihat</a>
                            @else
                                <span class="badge bg-danger">Tidak ada bukti</span>
                            @endif --}}
                        </td>
                        <td>{{ $data->user->name }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-center">Total</td>
                    <td class="text-center">{{ 'Rp. ' . number_format($total_in, 0, ',', '.') }}</td>
                    <td class="text-center">{{ 'Rp. ' . number_format($total_out, 0, ',', '.') }}</td>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td colspan="3" class="text-center">Saldo Akhir</td>
                    <td colspan="4" class="text-center">{{ 'Rp. ' . number_format($sisa, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td colspan="3" class="text-center">Saldo Bulan Sebelumnya</td>
                    <td colspan="4" class="text-center">{{ 'Rp. ' . number_format($total_saldo_sebelumnya, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td colspan="3" class="text-center">Total Saldo Akhir Bulan Ini</td>
                    <td colspan="4" class="text-center">{{ 'Rp. ' . number_format($total_saldo_sebelumnya + $sisa, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
    <script>
        window.print();
    </script>
</body>
</html>
