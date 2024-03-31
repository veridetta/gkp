<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Iuran Warga - {{ $category->name }}</title>
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

        .card {
            display: inline-block;
            width: 30%;
            margin-right: 10px;
        }

        .card-body {
            text-align: center;
        }

        .card-title {
            margin-bottom: 0;
        }

        .table {
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
        h3, h4, h5 {
            text-align: center;
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
        <h3>{{ get_my_app_config('nama') }}</h3>
        <h4>Laporan Iuran Warga - {{ $category->name }}</h4>
        <h5>Bulan {{ getIndonesiaMonth($bulan) }} {{ $tahun }}</h5>
        <hr>
        <p style="text-align: right;"><small>Dicetak pada: {{ date('d-m-Y H:i:s') }}</small></p>
        <p style="text-align: right;"><small>Oleh: {{ Auth::user()->name }}</small></p>

        <div class="d-flex mb-4 justify-content-end">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-primary">
                        Total Tagihan
                    </h5>
                    <h2 class="mt-1 mb-3">Rp. {{ number_format($total) }}</h2>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-success">
                        Sudah Dibayar
                    </h5>
                    <h2 class="mt-1 mb-3">Rp. {{ number_format($totalPaid) }}</h2>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-danger">
                        Belum Dibayar
                    </h5>
                    <h2 class="mt-1 mb-3">Rp. {{ number_format($totalUnpaid) }}</h2>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Tanggal Bayar</th>
                        <th class="text-center">Nama Warga</th>
                        <th class="text-center">Rumah</th>
                        <th class="text-center">Jenis Iuran</th>
                        <th class="text-center">Nominal</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Petugas</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    @foreach ($data as $data)
                        <tr>
                            <td class="text-center">{{ $no++ }}</td>
                            <?php
                                if($data->payments){
                                    $payment = $data->payments()
                                                    ->where('category_id', $category->id)
                                                    ->where('month', $bulan)
                                                    ->where('year', $tahun)
                                                    ->first();
                                    $status = $payment ? 'paid' : 'unpaid';
                                    $payment_id = $payment ? $payment->id : null;
                                    $date = $payment ? $payment->date : '-';
                                }else{
                                    $status = 'unpaid';
                                    $date = '-';
                                }
                                ?>
                            <td class="text-center">{{ $date }}</td>
                            <td class="text-center">{{ $data->name }}</td>
                            <td class="text-center">{{ $data->block . '-' . $data->home_number }}</td>
                            <td class="text-center">{{ $category->name }}</td>
                            <td class="text-center">{{ 'Rp. ' . number_format($category->amount, 0, ',', '.') }}
                            </td>
                            <td class="text-center">{!!paymentStatus($status)!!}</td>
                            <td class="text-center">{{ $payment ? $payment->user->name : '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script>
        window.print();
    </script>
</body>
</html>
