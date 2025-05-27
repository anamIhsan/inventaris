@extends('admin.template')

@section('title')
    Barang Keluar - Tambah
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
                        <form action="{{ route('exit-item.create') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="itemIdInput">Barang</label>
                                    <select name="item_id" class="form-control" id="itemIdInput">
                                        <option value="">-- Pilih Barang --</option>
                                        @foreach ($items as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('item_id') == $item->id ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="dateOutInput">Tanggal Keluar</label>
                                    <input type="date" name="date_out" class="form-control" id="dateOutInput"
                                        value="{{ old('date_out') }}">
                                </div>

                                <div class="form-group">
                                    <label for="quantityInput">Jumlah</label>
                                    <input type="number" name="quantity" class="form-control" id="quantityInput"
                                        placeholder="Masukkan jumlah..." value="{{ old('quantity') }}">
                                </div>

                                <div class="form-group">
                                    <label for="locationInput">Lokasi Tujuan</label>
                                    <input type="text" name="location" class="form-control" id="locationInput"
                                        placeholder="Masukkan lokasi tujuan..." value="{{ old('location') }}">
                                </div>

                                <div class="form-group">
                                    <label for="recipientInput">Penerima</label>
                                    <input type="text" name="recipient" class="form-control" id="recipientInput"
                                        placeholder="Masukkan nama penerima..." value="{{ old('recipient') }}">
                                </div>

                                <div class="form-group">
                                    <label for="notesInput">Catatan</label>
                                    <textarea name="notes" class="form-control" id="notesInput" rows="3" placeholder="Masukkan catatan tambahan...">{{ old('notes') }}</textarea>
                                </div>

                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Kirim</button>
                                <a href="{{ route('exit-item.index') }}" class="btn btn-danger">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
