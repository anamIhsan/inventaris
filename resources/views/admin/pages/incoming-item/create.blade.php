@extends('admin.template')

@section('title')
    Barang Masuk - Tambah
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
                        <form action="{{ route('incoming-item.create') }}" method="post" enctype="multipart/form-data">
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
                                    <label for="entryDateInput">Tanggal Masuk</label>
                                    <input type="date" name="entry_date" class="form-control" id="entryDateInput"
                                        value="{{ old('entry_date') }}">
                                </div>

                                <div class="form-group">
                                    <label for="quantityInput">Jumlah</label>
                                    <input type="number" name="quantity" class="form-control" id="quantityInput"
                                        placeholder="Masukkan jumlah..." value="{{ old('quantity') }}">
                                </div>

                                <div class="form-group">
                                    <label for="supplierInput">Supplier</label>
                                    <select name="supplier_id" class="form-control" id="supplierInput">
                                        <option value="">-- Pilih Supplier --</option>
                                        @foreach ($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}"
                                                {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                                {{ $supplier->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Kirim</button>
                                <a href="{{ route('incoming-item.index') }}" class="btn btn-danger">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
