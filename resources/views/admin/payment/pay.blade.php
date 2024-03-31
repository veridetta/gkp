@extends('layouts.my_admin_layout')
@section('title', 'Bayar Tagihan')
@section('content')
    <main class="content">
        <div class="container p-0">
            <h1 class="mb-3 fw-bold my-text-color">Bayar Tagihan</h1>
            @include('components.flash-message')
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.payment.pay', [$bulan, $tahun, $category_id, $residence_id]) }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="mb-3">
                            <label for="type" class="form-label">Warga</label>
                            <select class="form-select" id="residence_id" name="residence_id" required>
                                <option value="{{$residence->id}}">{{$residence->name}}</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Kategori Tagihan</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $data->name }}"
                                disabled>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Keterangan Tagihan</label>
                            <textarea class="form-control" id="" name=""
                                disabled>{{ $data->description }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Keterangan Pembayaran</label>
                            <textarea class="form-control" id="description" name="description"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="amount" class="form-label">Jumlah</label>
                            <input type="number" class="form-control" id="amount" name="amount" value="{{ $data->amount }}"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="date" class="form-label">Tanggal Pembayaran</label>
                            <input type="date" class="form-control" id="date" name="date" required>
                        </div>
                        <div class="mb-3">
                            <label for="month" class="form-label">Bulan</label>
                            <?php
                            $bulan_a = array(
                                '01' => 'Januari',
                                '02' => 'Februari',
                                '03' => 'Maret',
                                '04' => 'April',
                                '05' => 'Mei',
                                '06' => 'Juni',
                                '07' => 'Juli',
                                '08' => 'Agustus',
                                '09' => 'September',
                                '10' => 'Oktober',
                                '11' => 'November',
                                '12' => 'Desember'
                            );?>
                            <select class="form-select" id="month" name="month[]" required>
                                <option value="">Pilih Bulan</option>
                                @foreach ($bulan_a as $key => $value)
                                    <option value="{{ $key }}" @if ($key == $bulan) selected @endif>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="year" class="form-label">Tahun</label>
                            <?php
                            $tahun_a = array(
                                '2021' => '2021',
                                '2022' => '2022',
                                '2023' => '2023',
                                '2024' => '2024',
                                '2025' => '2025',
                                '2026' => '2026',
                                '2027' => '2027',
                                '2028' => '2028',
                                '2029' => '2029',
                                '2030' => '2030'
                            );?>
                            <select class="form-select" id="year" name="year" required>
                                <option value="">Pilih Tahun</option>
                                @foreach ($tahun_a as $key => $value)
                                    <option value="{{ $key }}" @if ($key == $tahun) selected @endif>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn my-bg text-white p-2 px-4"><i class="fa fa-save fa-fw"></i>
                                Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('#residence_id').select2();
        //select2 bulan multiple
        $('#month').select2({
            placeholder: "Pilih Bulan",
            allowClear: true,
            //multiple
            multiple: true,
        });
    });
</script>
@endsection
