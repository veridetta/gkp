<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Penjualan</title>
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
        }

        th, td {
            border: 1px solid #000;
            text-align: center;
            padding: 9px;
        }


        .cogs {
            font-size: 18px;
        }

        .cogs:hover {
            color: blue;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">

        {{-- <p style="text-align: left; line-height: 0.5;">Tanggal : {{ $data->payments->first()->created_at }}</p>
        <p style="text-align: left; line-height: 0.5;">Petugas : {{ $data->payments->first()->user->name }}</p>
        <p style="text-align: left; line-height: 0.5;">Warga : {{ $data->residence->name }}</p>
        <p style="text-align: left; line-height: 0.5;">Kategori : {{ $data->category->name }}</p>
        <p style="text-align: left; line-height: 0.5;">Keterangan : {{ $data->description }}</p>
        <p style="text-align: left; line-height: 0.5;">Jumlah : {{ $data->amount_formatted }}</p>
        <p style="text-align: left; line-height: 0.5;">Keterangan Pembayaran : {{ $data->payments->first()->description }}</p>
        <p style="text-align: left; line-height: 0.5;">Status : {{ $data->status }}</p>
        <h5 style="text-align: right; line-height: 0.5;">Terima kasih</h5> --}}
        <table>
            <body>
                <tr>
                    <td colspan="2" style="">
                        <h3 style=" line-height: 0;">{{ get_my_app_config('nama_web') }}</h3>
                        <h4 style=" line-height: 0.5; ">Kwitansi Pembayaran</h4>
                        <br>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left; padding:9px;border-right:none; padding-bottom:20px;"><br>Tanggal : {{ $data->payments->first()->created_at }}</td>
                    <td style="text-align: right; padding:9px; border-left:none;padding-bottom:20px;"><br>Petugas : {{ $data->payments->first()->user->name }}</td>
                </tr>
                <tr>
                    <td style="text-align: left;" colspan="2">
                        <p><b>Tagihan</b></p>
                        Warga : {{ $data->residence->name }}
                        <p style="text-align: left; line-height: 0.5;">Kategori Tagihan: {{ $data->category->name }}</p>
                        <p style="text-align: left; line-height: 0.5;">Keterangan Tagihan: {{ $data->description }}</p>
                        Jumlah : {{ $data->amount_formatted }}
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left;" colspan="2">
                        <p><b>Pembayaran</b></p>
                        Jumlah : {{ $data->amount_formatted }}
                        <p style="text-align: left; line-height: 0.5;">Keterangan Pembayaran : {{ $data->payments->first()->description }}</p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left;" colspan="2">
                        <h5 style="text-align: right; line-height: 0.5;">Terima kasih</h5>
                    </td>
                </tr>
            </body>
        </table>
    </div>
    <script>
        window.print();
    </script>
</body>
</html>
