@extends('layouts.my_admin_layout')
@section('title', 'Ubah Kategori Tagihan')
@section('content')
    <main class="content">
        <div class="container p-0">
            <h1 class="mb-3 fw-bold my-text-color">Ubah Kategori Tagihan</h1>
            @include('components.flash-message')
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.category.update', [$data->id]) }}" method="POST">
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
                            <label for="type" class="form-label fw-bold my-text-color">Tipe</label>
                            <select class="form-select @error('type') is-invalid @enderror" id="type" name="type">
                                <option value="Bulanan" @if ($data->type == 'Bulanan') selected @endif>Bulanan</option>
                                <option value="Tidak Ditentukan" @if ($data->type == 'Tidak Ditentukan') selected @endif>Tidak
                                    Ditentukan</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="amount" class="form-label fw-bold my-text-color">Nominal</label>
                            <input type="number" class="form-control @error('amount') is-invalid @enderror" id="amount"
                                value="{{ old('amount', $data->amount) }}" name="amount">
                            @error('amount')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label fw-bold my-text-color">Keterangan</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                                name="description" rows="3">{{ old('description', $data->description) }}</textarea>
                            @error('description')
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
