<div class="table-responsive">
    <table id="datatable" class="table table-bordered rounded w-100">
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">Tanggal Pembayaran</th>
                <th class="text-center">Nama Warga</th>
                <th class="text-center">Rumah</th>
                <th class="text-center">Jenis Iuran</th>
                <th class="text-center">Nominal</th>
                <th class="text-center">Status</th>
                <th class="text-center">Petugas</th>
                <th class="text-center"><i class="fa fa-cogs"></i></th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;?>
            @foreach ($data as $data)
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
                        if($payment){
                        ?>
                        <?php
                        }else{
                            ?>
                            <tr>
                                <td class="text-center">{{ $no++ }}</td>
                                <td class="text-center">{{ $date }}</td>
                                <td class="text-center">{{ $data->name }}</td>
                                <td class="text-center">{{ $data->block . '-' . $data->home_number }}</td>
                                <td class="text-center">{{ $category->name }}</td>
                                <td class="text-center">{{ 'Rp. ' . number_format($category->amount, 0, ',', '.') }}
                                </td>
                                <td class="text-center">{!!paymentStatus($status)!!}</td>
                                <td class="text-center">{{ $payment ? $payment->user->name : '-' }}</td>
                                <td class="text-center">
                                    @if($status == 'unpaid')
                                        <a href="{{ route('admin.payment.pay', [$bulan, $tahun, $category->id, $data->id]) }}" class="btn btn-info text-white mt-1">Bayar </a>
                                    @else
                                        {{-- <a href="{{ route('admin.payment.showPayment', [$data->id]) }}" target="_blank"
                                            class="btn my-bg text-white mt-1"><i class="fa fa-print"></i></a> --}}
                                        <form action="{{ route('admin.payment.destroy', [$payment_id]) }}" method="POST" class="d-inline delete-btn">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger text-white mt-1"><i class="fa fa-trash"></i></button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            <?php
                        }
                    }else{
                        ?>
                        <tr>
                            <td class="text-center">{{ $no++ }}</td>
                            <td class="text-center">{{ $date }}</td>
                            <td class="text-center">{{ $data->name }}</td>
                            <td class="text-center">{{ $data->block . '-' . $data->home_number }}</td>
                            <td class="text-center">{{ $category->name }}</td>
                            <td class="text-center">{{ 'Rp. ' . number_format($category->amount, 0, ',', '.') }}
                            </td>
                            <td class="text-center">{!!paymentStatus($status)!!}</td>
                            <td class="text-center">{{ $payment ? $payment->user->name : '-' }}</td>
                            <td class="text-center">
                                @if($status == 'unpaid')
                                    <a href="{{ route('admin.payment.pay', [$bulan, $tahun, $category->id, $data->id]) }}" class="btn btn-info text-white mt-1">Bayar </a>
                                @else
                                    <a href="{{ route('admin.payment.showPayment', [$data->id]) }}" target="_blank"
                                        class="btn my-bg text-white mt-1"><i class="fa fa-print"></i></a>
                                    <form action="{{ route('admin.payment.destroy', [$payment_id]) }}" method="POST" class="d-inline delete-btn">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger text-white mt-1"><i class="fa fa-trash"></i></button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
            @endforeach
        </tbody>
    </table>
</div>
