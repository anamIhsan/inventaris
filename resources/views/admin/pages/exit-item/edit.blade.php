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
                        <form action="{{ route('exit-item.update', ['id' => $exitItem->id]) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3 text-start">
                                        <label for="itemIdInput" class="form-label"><strong>Barang</strong></label>
                                        <select name="item_id" class="form-control" id="itemIdInput">
                                            <option value="">-- Pilih Barang --</option>
                                            @foreach ($items as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ old('item_id', $exitItem->item_id) == $item->id ? 'selected' : '' }}>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3 text-start">
                                        <label for="dateOutInput" class="form-label"><strong>Tanggal Keluar</strong></label>
                                        <input type="date" name="date_out" class="form-control" id="dateOutInput"
                                            value="{{ old('date_out', $exitItem->date_out) }}">
                                    </div>

                                    <div class="col-md-6 mb-3 text-start">
                                        <label for="quantityInput" class="form-label"><strong>Jumlah</strong></label>
                                        <input type="number" name="quantity" class="form-control" id="quantityInput"
                                            value="{{ old('quantity', $exitItem->quantity) }}">
                                    </div>

                                    <div class="col-md-6 mb-3 text-start">
                                        <label for="locationInput" class="form-label"><strong>Lokasi</strong></label>
                                        <input type="text" name="location" class="form-control" id="locationInput"
                                            value="{{ old('location', $exitItem->location) }}">
                                    </div>

                                    <div class="col-md-6 mb-3 text-start">
                                        <label for="recipientInput" class="form-label"><strong>Penerima</strong></label>
                                        <input type="text" name="recipient" class="form-control" id="recipientInput"
                                            value="{{ old('recipient', $exitItem->recipient) }}">
                                    </div>

                                    <div class="col-md-6 mb-3 text-start">
                                        <label for="notesInput" class="form-label"><strong>Catatan</strong></label>
                                        <textarea name="notes" class="form-control" id="notesInput" rows="3" placeholder="Masukkan catatan tambahan...">{{ old('notes', $exitItem->notes) }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">Update</button>
                                <a href="{{ route('exit-item.index') }}" class="btn btn-secondary">Kembali</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
