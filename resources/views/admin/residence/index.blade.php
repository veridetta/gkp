@extends('layouts.my_admin_layout')
@section('title', 'Kelola Warga')
@section('content')
    <main class="content">
        <div class="container p-0">
            <h1 class="mb-3 fw-bold my-text-color">Kelola Warga</h1>
            @include('components.flash-message')
            <div class="card">
                <div class="card-body">
                    <div class="d-flex mb-4 justify-content-end">
                        <a href="{{ route('admin.residence.create') }}" class="btn my-bg text-white p-2 px-4"><i
                                class="fa fa-plus fa-fw"></i>
                            Tambah Warga</a>
                    </div>
                    <div class="table-responsive">
                        <table id="datatable" class="table table-bordered rounded w-100">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Nama</th>
                                    <th class="text-center">Jenis Kelamin</th>
                                    <th class="text-center">No HP</th>
                                    <th class="text-center">Blok</th>
                                    <th class="text-center">Nomor Rumah</th>
                                    <th class="text-center">Jabatan</th>
                                    <th class="text-center"><i class="fa fa-cogs"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                @foreach ($data as $data)
                                    <tr>
                                        <td class="text-center">{{ $no++ }}</td>
                                        <td class="text-center">{{ $data->name }}</td>
                                        <td class="text-center">{{ $data->sex }}</td>
                                        <td class="text-center">{{ $data->phone }}</td>
                                        <td class="text-center">{{ $data->block }}</td>
                                        <td class="text-center">{{ $data->home_number }}</td>
                                        <td class="text-center">
                                            @if($data->user)
                                                {{ $data->user->position->position->name }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.residence.edit', [$data->id]) }}"
                                                class="btn my-bg text-white mt-1"><i class="fa fa-edit"></i></a>
                                            {{-- <form action="{{ route('admin.residence.destroy', [$data->id]) }}"
                                                class="d-inline-block delete-btn" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger mt-1"><i
                                                        class="fa fa-trash"></i></button>
                                            </form> --}}
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
