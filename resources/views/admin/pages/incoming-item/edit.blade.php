@extends('admin.template')

@section('title')
    Barang Masuk - Ubah
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
                        <form action="{{ route('incoming-item.update', ['id' => $incomingItem->id]) }}" method="post"
                            enctype="multipart/form-data">
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
                                                    {{ old('item_id', $incomingItem->item_id) == $item->id ? 'selected' : '' }}>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3 text-start">
                                        <label for="entryDateInput" class="form-label"><strong>Tanggal
                                                Masuk</strong></label>
                                        <input type="date" name="entry_date" class="form-control" id="entryDateInput">
                                    </div>

                                    <div class="col-md-6 mb-3 text-start">
                                        <label for="quantityInput" class="form-label"><strong>Jumlah</strong></label>
                                        <input type="number" name="quantity" class="form-control" id="quantityInput"
                                            value="{{ old('quantity', $incomingItem->quantity) }}">
                                    </div>

                                    <div class="col-md-6 mb-3 text-start">
                                        <label for="supplierInput" class="form-label"><strong>Nama Supplier</strong></label>
                                        <select name="supplier_id" class="form-control" id="supplierInput">
                                            <option value="">-- Pilih Supplier --</option>
                                            @foreach ($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}"
                                                    {{ old('supplier_id', $incomingItem->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                                    {{ $supplier->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">Update</button>
                                <a href="{{ route('incoming-item.index') }}" class="btn btn-secondary">Kembali</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
