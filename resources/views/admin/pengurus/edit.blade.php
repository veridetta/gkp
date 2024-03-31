@extends('layouts.my_admin_layout')
@section('title', 'Ubah Petugas')
@section('content')
    <main class="content">
        <div class="container p-0">
            <h1 class="mb-3 fw-bold my-text-color">Ubah Petugas</h1>
            @include('components.flash-message')
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.pengurus.update', [$data->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        {{-- {{dd($data->residence)}} --}}
                        <div class="mb-3">
                            <label for="residence_id" class="form-label fw-bold my-text-color">Nama Warga</label>
                            <select class="form-select @error('residence_id') is-invalid @enderror" id="residence_id" name="residence_id">
                                <option value="{{ $data->residence->id }}">{{ $data->residence->name .' - '. $data->residence->block . $data->residence->home_number }}</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold my-text-color">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                value="{{ old('email', $data->email) }}" name="email">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="position_id" class="form-label fw-bold my-text-color">Jabatan</label>
                            <select class="form-select @error('position_id') is-invalid @enderror" id="position_id" name="position_id">
                                <option value="">Pilih Jabatan</option>
                                @foreach ($positions as $position)
                                    <option value="{{ $position->id }}" @if (old('position_id', $data->position->position_id) == $position->id) selected @endif>{{ $position->name }}</option>
                                @endforeach
                            </select>
                            @error('role')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold my-text-color">Password <span
                                    class="text-muted text-small">- Biarkan kosong jika tidak ingin mengubah password</span></label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                                name="password">
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
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

        $('#position_id').select2({

        });
    });
</script>
@endsection
