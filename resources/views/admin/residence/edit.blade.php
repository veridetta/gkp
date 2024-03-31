@extends('layouts.my_admin_layout')
@section('title', 'Ubah  Data Warga')
@section('content')
    <main class="content">
        <div class="container p-0">
            <h1 class="mb-3 fw-bold my-text-color">Ubah Data Warga</h1>
            @include('components.flash-message')
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.residence.update', [$data->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold my-text-color">Nama</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                value="{{ old('name', $data->name) }}" name="name">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="sex" class="form-label fw-bold my-text-color">Jenis Kelamin</label>
                            <select class="form-select @error('sex') is-invalid @enderror" id="sex" name="sex">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Laki-laki" {{ old('sex', $data->sex) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki
                                </option>
                                <option value="Perempuan" {{ old('sex', $data->sex) == 'Perempuan' ? 'selected' : '' }}>Perempuan
                                </option>
                            </select>
                            @error('sex')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label fw-bold my-text-color">No HP</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                                value="{{ old('phone', $data->phone) }}" name="phone">
                            @error('phone')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="block" class="form-label fw-bold my-text-color">Blok</label>
                            <input type="text" class="form-control @error('block') is-invalid @enderror" id="block"
                                value="{{ old('block', $data->block) }}" name="block">
                            @error('block')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="home_number" class="form-label fw-bold my-text-color">Nomor Rumah</label>
                            <input type="text" class="form-control @error('home_number') is-invalid @enderror" id="home_number"
                                value="{{ old('home_number', $data->home_number) }}" name="home_number">
                            @error('home_number')
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

@endsection
