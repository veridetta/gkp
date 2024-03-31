@extends('layouts.my_admin_layout')
@section('title', 'Kelola Kategori')
@section('content')
    <main class="content">
        <div class="container p-0">
            <h1 class="mb-3 fw-bold my-text-color">Kelola Kategori</h1>
            @include('components.flash-message')
            <div class="card">
                <div class="card-body">
                    <div class="d-flex mb-4 justify-content-end">
                        <a href="{{ route('admin.category.create') }}" class="btn my-bg text-white p-2 px-4"><i
                                class="fa fa-plus fa-fw"></i>
                            Tambah Kategori</a>
                    </div>
                    <div class="table-responsive">
                        <table id="datatable" class="table table-bordered rounded w-100">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Nama Tagihan</th>
                                    <th class="text-center">Tipe Iuran</th>
                                    <th class="text-center">Nominal</th>
                                    <th class="text-center">Keterangan</th>
                                    <th class="text-center"><i class="fa fa-cogs"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                @foreach ($data as $data)
                                    <tr>
                                        <td class="text-center">{{ $no++ }}</td>
                                        <td class="text-center">{{ $data->name }}</td>
                                        <td class="text-center">
                                            @if ($data->type == 'Bulanan')
                                                <span class="badge bg-primary">Bulanan</span>
                                            @else
                                                <span class="badge bg-secondary">Tidak Ditentukan</span>
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $data->amount_formatted }}</td>
                                        <td class="text-center">{{ $data->description }}</td>

                                        <td class="text-center">
                                            <a href="{{ route('admin.category.edit', [$data->id]) }}"
                                                class="btn my-bg text-white"><i class="fa fa-edit"></i></a>
                                            <form action="{{ route('admin.category.destroy', [$data->id]) }}"
                                                class="d-inline-block delete-btn" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger"><i
                                                        class="fa fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php $no++; ?>
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
                    "orderable": false,
                    "targets": 2
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
