@extends('admin.template')

@section('title')
    Peminjaman - Tambah
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Tambah Data</h3>
                        </div>
                        <form action="{{ route('borrowing.create') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="itemIdInput">Barang</label>
                                    <select name="item_id" class="form-control" id="itemIdInput">
                                        <option value="">-- Pilih Barang --</option>
                                        @foreach ($items as $item)
                                            @php
                                                $stok =
                                                    $item->incomingItems->sum('quantity') -
                                                    $item->exitItems->sum('quantity') -
                                                    $item->borrowings->where('status', 'dipinjam')->sum('quantity');
                                            @endphp
                                            <option value="{{ $item->id }}"
                                                {{ old('item_id') == $item->id ? 'selected' : '' }}
                                                {{ $stok <= $item->minimum_stock ? 'disabled' : '' }}>
                                                {{ $item->name }}
                                                {{ $stok <= $item->minimum_stock ? '(Stok Rendah)' : '' }}
                                                - Stok: {{ $stok }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="quantityInput">Jumlah</label>
                                    <input type="number" name="quantity" class="form-control" id="quantityInput"
                                        placeholder="Masukkan jumlah..." value="{{ old('quantity') }}">
                                </div>

                                <div class="form-group">
                                    <label for="borrowedAtInput">Tanggal Pinjam</label>
                                    <input type="date" name="borrowed_at" class="form-control" id="borrowedAtInput"
                                        value="{{ old('borrowed_at') }}">
                                </div>

                                <div class="form-group">
                                    <label for="returnedAtInput">Tanggal Kembali</label>
                                    <input type="date" name="returned_at" class="form-control" id="returnedAtInput"
                                        value="{{ old('returned_at') }}">
                                </div>

                                <div class="form-group">
                                    <label for="conditionInput">Kondisi Barang</label>
                                    <input type="text" name="condition" class="form-control" id="conditionInput"
                                        placeholder="Masukkan kondisi barang..." value="{{ old('condition') }}">
                                </div>

                                <div class="form-group">
                                    <label for="catatanInput">Catatan Tambahan</label>
                                    <textarea name="catatan" class="form-control" id="catatanInput" placeholder="Masukan Catatan..." rows="5">{{ old('catatan') }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="statusInput">Status</label>
                                    <input type="text" class="form-control" value="Diminta" disabled>
                                    <input type="hidden" name="status" value="diminta">
                                </div>

                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Kirim</button>
                                <a href="{{ route('borrowing.index') }}" class="btn btn-danger">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
