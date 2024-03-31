@extends('layouts.my_admin_layout')
@section('title', 'Ubah Tagihan')
@section('content')
    <main class="content">
        <div class="container p-0">
            <h1 class="mb-3 fw-bold my-text-color">Ubah Tagihan</h1>
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.invoice.update', [$data->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="type" class="form-label">Kategori</label>
                            <select class="form-select" id="category_id" name="category_id" required>
                                <option value="">Pilih Kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @if ($data->category_id == $category->id) selected
                                @endif>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="type" class="form-label">Warga</label>
                            <select class="form-select" id="residence_id" name="residence_id" required>
                                <option value="">Pilih Warga</option>
                                @foreach ($residences as $resident)
                                    <option value="{{ $resident->id }}" @if ($data->residence_id == $resident->id) selected
                                @endif>{{ $resident->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Keterangan</label>
                            <textarea class="form-control" id="description" name="description"
                                required>{{ $data->description }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="type" class="form-label">Tipe</label>
                            <input type="text" class="form-control" id="type" name="type" value="{{ $data->type }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="amount" class="form-label">Jumlah</label>
                            <input type="number" class="form-control" id="amount" name="amount" value="{{ $data->amount }}"
                                required>
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
        $('#category_id').select2();
        $('#residence_id').select2();
    });
</script>
@endsection
