@extends('layouts.my_admin_layout')
@section('title', 'Dashboard')
@section('content')
    <main class="content">
        <div class="container-fluid p-0">

            <h1 class="mb-4 fw-bold my-text-color text-capitalize">Selamat Datang, {{ Auth::user()->name }}</h1>
            <div class="row">
                <div class="col-12 d-flex">
                    <div class="w-100">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title
                                        text-uppercase">Total Pendapatan Bulan Ini</h5>
                                        <h1 class="mt-1 mb-3">Rp. {{ number_format($total_pendapatan) }}</h1>
                                        <div class="mb-1">
                                            @if($tipe == 'danger')
                                                <i class="text-danger fa fa-arrow-trend-down"></i>
                                            @else
                                                <i class="text-success fa fa-arrow-trend-up"></i>
                                            @endif
                                            <span class="text-{{$tipe}}"> <i class="mdi mdi-arrow-bottom-right"></i> {{$percentage}}% </span>
                                            <span class="text-muted">Since last month</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-lg-6 col-xl-6">
                                    <div class="card ms-2">
                                        <div class="card-body">
                                            <h5 class="card-title text-primary">
                                                Total Tagihan
                                            </h5>
                                            <h1 class="mt-1 mb-3">Rp. {{ number_format($total) }}</h1>
                                        </div>
                                    </div>
                                    <div class="card ms-2">
                                        <div class="card-body">
                                            <h5 class="card-title text-success">
                                                Sudah Dibayar
                                            </h5>
                                            <h1 class="mt-1 mb-3">Rp. {{ number_format($paid) }}</h1>
                                        </div>
                                    </div>
                                    <div class="card ms-2">
                                        <div class="card-body">
                                            <h5 class="card-title text-danger">
                                                Belum Dibayar
                                            </h5>
                                            <h1 class="mt-1 mb-3">Rp. {{ number_format($unpaid) }}</h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6 col-xl-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">Grafik Pembayaran</h5>
                                            <canvas id="myChart" width="400" height="400"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable();
            //chart js
            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($chart['labels']) !!},
                    datasets: [{
                        label: 'Total Dibayar',
                        data: {!! json_encode($chart['data']['total_paid']) !!},
                        backgroundColor: 'transparent',
                        borderColor: 'rgba(0, 255, 0)',
                        borderWidth: 3
                    }, {
                        label: 'Total Belum Dibayar',
                        data: {!! json_encode($chart['data']['total_unpaid']) !!},
                        backgroundColor: 'transparent',
                        borderColor: 'rgba(255, 0, 0)',
                        borderWidth: 3
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        });

    </script>
@endsection
