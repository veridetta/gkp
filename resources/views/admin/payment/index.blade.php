@extends('layouts.my_admin_layout')
@section('title', 'Kelola Pembayaran')
@section('content')
    <main class="content">
        <div class="container p-0">
            <h1 class="mb-3 fw-bold my-text-color">Kelola Pembayaran Bulan {{ getIndonesiaMonth($bulan) }} {{ $tahun }}</h1>
            @include('components.flash-message')
            <div class="card">
                <div class="card-body">
                    <div class="d-flex mb-4 justify-content-end">
                        <a href="{{ route('admin.payment.print', [$bulan, $tahun,$category_id]) }}" target="_blank" class="btn bg-info text-white p-2 px-4 ms-2"><i
                                class="fa fa-print fa-fw"></i>
                            Cetak</a>
                        <a href="{{ route('admin.payment.download', [$bulan, $tahun,$category_id]) }}" class="btn bg-success text-white p-2 px-4 ms-2" target="_blank"><i class="fa fa-download fa-fw"></i> Download</a>
                    </div>
                    <form action="{{ route('admin.payment.filter') }}" method="POST">
                        @csrf
                        <div class="d-flex flex-wrap mb-4 justify-content-end">
                            <div class="col-md-auto align-self-stretch  mt-1">
                                <select name="bulan" id="bulan" class="form-select h-100">
                                    <option value="01" {{ $bulan == 1 ? 'selected' : '' }}>Januari</option>
                                    <option value="02" {{ $bulan == 2 ? 'selected' : '' }}>Februari</option>
                                    <option value="03" {{ $bulan == 3 ? 'selected' : '' }}>Maret</option>
                                    <option value="04" {{ $bulan == 4 ? 'selected' : '' }}>April</option>
                                    <option value="05" {{ $bulan == 5 ? 'selected' : '' }}>Mei</option>
                                    <option value="06" {{ $bulan == 6 ? 'selected' : '' }}>Juni</option>
                                    <option value="07" {{ $bulan == 7 ? 'selected' : '' }}>Juli</option>
                                    <option value="08" {{ $bulan == 8 ? 'selected' : '' }}>Agustus</option>
                                    <option value="09" {{ $bulan == 9 ? 'selected' : '' }}>September</option>
                                    <option value="10" {{ $bulan == 10 ? 'selected' : '' }}>Oktober</option>
                                    <option value="11" {{ $bulan == 11 ? 'selected' : '' }}>November</option>
                                    <option value="12" {{ $bulan == 12 ? 'selected' : '' }}>Desember</option>
                                </select>
                            </div>
                            <div class="col-md-auto align-self-stretch mt-1">
                                <select name="tahun" id="tahun" class="form-select h-100">
                                @for ($i = 2021; $i <= date('Y'); $i++)
                                    <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                                </select>
                            </div>
                            <div class="col-md-auto align-self-stretch mt-1">
                                <select name="category_id" id="category_id" class="form-select h-100">
                                @foreach($categories as $c)
                                    <option value="{{ $c->id }}" {{ $category->id == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                                @endforeach
                            </select>
                            </div>
                            <div class="col-md-auto mt-1">
                                <button type="submit" class="btn my-bg text-white p-2 px-4"><i class="fa fa-search fa-fw"></i></button>
                            </div>
                        </div>
                    </form>
                    <div class="row mb-4 justify-content-end">
                        <div class="card me-2 col-12 col-md-3 col-xl-3">
                            <div class="card-body">
                                <h5 class="card-title text-primary">
                                    Total Tagihan
                                </h5>
                                <h1 class="mt-1 mb-3">Rp. {{ number_format($total) }}</h1>
                            </div>
                        </div>
                        <div class="card ms-2 col-12 col-md-3 col-xl-3">
                            <div class="card-body">
                                <h5 class="card-title text-success">
                                    Sudah Dibayar
                                </h5>
                                <h1 class="mt-1 mb-3">Rp. {{ number_format($totalPaid) }}</h1>
                            </div>
                        </div>
                        <div class="card ms-2 col-12 col-md-3 col-xl-3">
                            <div class="card-body">
                                <h5 class="card-title text-danger">
                                    Belum Dibayar
                                </h5>
                                <h1 class="mt-1 mb-3">Rp. {{ number_format($totalUnpaid) }}</h1>
                            </div>
                        </div>
                    </div>
                    <ul class="nav nav-tabs mb-4">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#all">Semua</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#paid">Sudah Dibayar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#unpaid">Belum Dibayar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#show">Mode Lihat</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane container active" id="all">
                            @include('admin.payment.index.all')
                        </div>
                        <div class="tab-pane container fade" id="paid">
                            @include('admin.payment.index.paid')
                        </div>
                        <div class="tab-pane container fade" id="unpaid">
                            @include('admin.payment.index.unpaid')
                        </div>
                        <div class="tab-pane container fade" id="show">
                            @include('admin.payment.index.show')
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            new DataTable('#datatable', {
                "columnDefs": [{
                    // "orderable": false,
                    // "targets": 2
                }]
            });

            const deleleBtn = document.querySelectorAll('.delete-btn')
            deleleBtn.forEach(el => {
                console.log(el)
                el.addEventListener('submit', function(e) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Apakah anda yakin?',
                        text: "Ingin menghapus data ini",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'Hapus',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit()
                        }
                    })
                })
            })
        })
    </script>
@endsection
