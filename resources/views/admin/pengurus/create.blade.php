@extends('layouts.my_admin_layout')
@section('title', 'Tambah Petugas')
@section('content')
    <main class="content">
        <div class="container p-0">
            <h1 class="mb-3 fw-bold my-text-color">Tambah Petugas</h1>
            @include('components.flash-message')
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.pengurus.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="residence_id" class="form-label">Pilih Warga</label>
                            <select class="form-select" id="residence_id" name="residence_id" required>
                                <option value="">Pilih Warga</option>
                                @foreach ($residences as $residence)
                                    <option value="{{ $residence->id }}">{{ $residence->name .' - '. $residence->block .' '. $residence->home_number }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="position_id" class="form-label">Jabatan</label>
                            <select class="form-select" id="position_id" name="position_id" required>
                                <option value="">Pilih Jabatan</option>
                                @foreach ($positions as $position)
                                    <option value="{{ $position->id }}">{{ $position->name }}</option>
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
        $('#position_id').select2();
    });
</script>
@endsection
