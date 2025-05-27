@extends('admin.template')

@section('title')
    Barang Keluar - Ubah
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">Ubah Data</h3>
                        </div>
                        <form action="{{ route('borrowing.update', ['id' => $borrowing->id]) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-md-6 mb-3 text-start">
                                        <label for="nameInput" class="form-label"><strong>Nama Peminjam</strong></label>
                                        <input type="text" name="name" class="form-control" id="nameInput"
                                            value="{{ old('name', $borrowing->name) }}">
                                    </div>

                                    <div class="col-md-6 mb-3 text-start">
                                        <label for="itemIdInput" class="form-label"><strong>Barang</strong></label>
                                        <select name="item_id" class="form-control" id="itemIdInput">
                                            <option value="">-- Pilih Barang --</option>
                                            @foreach ($items as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ old('item_id', $borrowing->item_id) == $item->id ? 'selected' : '' }}>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3 text-start">
                                        <label for="quantityInput" class="form-label"><strong>Jumlah</strong></label>
                                        <input type="number" name="quantity" class="form-control" id="quantityInput"
                                            value="{{ old('quantity', $borrowing->quantity) }}">
                                    </div>

                                    <div class="col-md-6 mb-3 text-start">
                                        <label for="borrowedAtInput" class="form-label"><strong>Tanggal
                                                Pinjam</strong></label>
                                        <input type="date" name="borrowed_at" class="form-control" id="borrowedAtInput"
                                            value="{{ old('borrowed_at', $borrowing->borrowed_at) }}">
                                    </div>

                                    <div class="col-md-6 mb-3 text-start">
                                        <label for="returnedAtInput" class="form-label"><strong>Tanggal
                                                Kembali</strong></label>
                                        <input type="date" name="returned_at" class="form-control" id="returnedAtInput"
                                            value="{{ old('returned_at', $borrowing->returned_at) }}">
                                    </div>

                                    <div class="col-md-6 mb-3 text-start">
                                        <label for="conditionInput" class="form-label"><strong>Kondisi</strong></label>
                                        <input type="text" name="condition" class="form-control" id="conditionInput"
                                            value="{{ old('condition', $borrowing->condition) }}">
                                    </div>

                                    <div class="col-md-6 mb-3 text-start">
                                        <label for="statusInput">Status</label>
                                        <input type="text" class="form-control" value="{{ $borrowing->status }}"
                                            disabled>
                                        <input type="hidden" name="status" value="dipinjam">
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">Update</button>
                                <a href="{{ route('borrowing.index') }}" class="btn btn-secondary">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
