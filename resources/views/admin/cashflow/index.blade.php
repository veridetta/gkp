@extends('layouts.my_admin_layout')
@section('title', 'Kelola Kas')
@section('content')
    <main class="content">
        <div class="container p-0">
            <h1 class="mb-3 fw-bold my-text-color">Kelola Kas</h1>
            @include('components.flash-message')
            <div class="card">
                <div class="card-body">
                    <div class="row mb-4 justify-content-end">
                        <div class="col-12 col-md-3 col-xl-3">
                            <a href="{{ route('admin.cashflow.create') }}" class="btn my-bg text-white p-2 px-4 ms-2 col-12"><i class="fa fa-plus fa-fw"></i>
                            Tambah Transaksi</a>
                        </div>
                        <div class="col-md-auto mt-1">
                            <a href="{{ route('admin.cashflow.print', ['month' => $month, 'year' => $year]) }}"  target="_blank"
                                class="btn btn-primary p-2 px-4 ms-2 col-12 "><i class="fa fa-print fa-fw"></i> Print</a>
                        </div>
                        <div class="col-md-auto mt-1">
                            <a href="{{ route('admin.cashflow.download', ['month' => $month, 'year' => $year]) }}" class="col-12  btn btn-success p-2 px-4 ms-2"  target="_blank"><i class="fa fa-download fa-fw"></i> Download</a>
                        </div>
                    </div>
                    <div class="d-flex mb-4 justify-content-end">
                        <h3 class="text-center">Saldo : Rp. {{ number_format($saldo, 0, ',', '.') }}</h3>
                    </div>
                    <form action="{{ route('admin.cashflow.filter') }}" method="POST">
                        @csrf
                        <div class="d-flex flex-wrap mb-4 justify-content-end">
                            <div class="col-md-auto align-self-stretch  mt-1">
                                <select name="month" id="month" class="form-select h-100">
                                    <option value="01" {{ $month == 1 ? 'selected' : '' }}>Januari</option>
                                    <option value="02" {{ $month == 2 ? 'selected' : '' }}>Februari</option>
                                    <option value="03" {{ $month == 3 ? 'selected' : '' }}>Maret</option>
                                    <option value="04" {{ $month == 4 ? 'selected' : '' }}>April</option>
                                    <option value="05" {{ $month == 5 ? 'selected' : '' }}>Mei</option>
                                    <option value="06" {{ $month == 6 ? 'selected' : '' }}>Juni</option>
                                    <option value="07" {{ $month == 7 ? 'selected' : '' }}>Juli</option>
                                    <option value="08" {{ $month == 8 ? 'selected' : '' }}>Agustus</option>
                                    <option value="09" {{ $month == 9 ? 'selected' : '' }}>September</option>
                                    <option value="10" {{ $month == 10 ? 'selected' : '' }}>Oktober</option>
                                    <option value="11" {{ $month == 11 ? 'selected' : '' }}>November</option>
                                    <option value="12" {{ $month == 12 ? 'selected' : '' }}>Desember</option>
                                </select>
                            </div>
                            <div class="col-md-auto align-self-stretch mt-1">
                                <select name="year" id="year" class="form-select h-100">
                                    @for ($i = 2021; $i <= date('Y'); $i++)
                                        <option value="{{ $i }}" {{ $year == $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-auto mt-1">
                                <button type="submit" class="btn my-bg text-white p-2 px-4 ms-2"><i class="fa fa-search fa-fw"></i></button>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table id="datatable" class="table table-bordered rounded w-100">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Tanggal</th>
                                    <th class="text-center">Keterangan</th>
                                    <th class="text-center">Masuk</th>
                                    <th class="text-center">Keluar</th>
                                    <th class="text-center">Bukti</th>
                                    <th class="text-center">Petugas</th>
                                    <th class="text-center"><i class="fa fa-cogs"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                @foreach ($data as $data)
                                    <tr>
                                        <td class="text-center">{{ $no++ }}</td>
                                        <td class="text-center">{{ $data->date }}</td>
                                        <td class="text-center">{{ $data->description }}</td>
                                        <td class="text-center">{{ 'Rp. ' . number_format($data->in, 0, ',', '.') }}
                                        </td>
                                        <td class="text-center">{{ 'Rp. ' . number_format($data->out, 0, ',', '.') }}
                                        </td>
                                        <td class="text-center">
                                            @if ($data->image)
                                                <a href="{{ url('storage/cashflow/' . $data->image) }}" target="_blank"
                                                    class="btn btn-primary"><i class="fa fa-eye"></i></a>
                                            @else
                                                <span class="badge bg-danger">Tidak ada bukti</span>
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $data->user->name }}</td>

                                        <td class="text-center">
                                                @if($data->type!=='iuran')
                                                <a href="{{ route('admin.cashflow.edit', [$data->id]) }}"
                                                    class="btn my-bg text-white"><i class="fa fa-edit"></i></a>
                                            <form action="{{ route('admin.cashflow.destroy', [$data->id]) }}"
                                                class="d-inline-block delete-btn" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger"><i
                                                        class="fa fa-trash"></i></button>
                                            </form>
                                            @else
                                            <p class="badge bg-success">Otomatis Terinput</p>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
