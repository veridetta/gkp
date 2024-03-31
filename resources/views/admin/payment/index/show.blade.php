<div class="table-responsive">
    <table id="datatable" class="table table-bordered rounded w-100">
        <thead>
            <tr>
                <th class="text-center" rowspan="3">No</th>
                <th class="text-center" rowspan="3">Nama Warga</th>
                <th class="text-center" colspan="24">Bulan ({{ $tahun }})</th>
            </tr>
            <tr>
                @for($i = 1; $i <= 12; $i++)
                    <th class="text-center">{{ getIndonesiaMonth($i) }}</th>
                @endfor
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;?>
            @foreach ($data as $data)
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td class="text-center">{{ $data->name .' - '. $data->block . $data->home_number }}</td>
                    @for($i = 1; $i <= 12; $i++)
                        <?php
                        $payment = $data->payments()
                                        ->where('category_id', $category->id)
                                        ->where('month', $i)
                                        ->where('year', $tahun)
                                        ->first();
                        $status = $payment ? 'paid' : 'unpaid';
                        $payment_id = $payment ? $payment->id : null;
                        $date = $payment ? date('d/m/y', strtotime($payment->date)) : '-';

                        ?>
                        <td class="text-center">@if($payment) <span class="badge bg-success">{{$date}}</span> @else <span class="badge bg-danger">Belum</span> @endif</td>
                    @endfor
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
