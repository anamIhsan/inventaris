@extends('admin.template')

@section('title')
    Supplier - Ubah
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
                        <form action="{{ route('supplier.update', ['id' => $supplier->id]) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="nameInput">Nama</label>
                                    <input type="text" name="name" class="form-control" id="nameInput"
                                        placeholder="Masukan Nama..." value="{{ old('name', $supplier->name) }}">
                                </div>
                                <div class="form-group">
                                    <label for="phoneInput">Telepon</label>
                                    <input type="text" name="phone" class="form-control" id="phoneInput"
                                        placeholder="Masukan Telepon..." value="{{ old('phone', $supplier->phone) }}">
                                </div>
                                <div class="form-group">
                                    <label for="addressInput">Alamat</label>
                                    <textarea name="address" class="form-control" id="addressInput" placeholder="Masukan Alamat..." rows="5">{{ old('address', $supplier->address) }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="imageInput" class="form-label">Gambar</label>
                                    <input name="image" type="file" accept="image/*" class="form-control"
                                        id="imageInput">
                                    @if ($supplier->image)
                                        <div class="mt-2">
                                            <small>Gambar saat ini:</small><br>
                                            <img src="{{ Storage::url($supplier->image) }}" width="120"
                                                alt="Gambar Supplier">
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">Update</button>
                                <a href="{{ route('supplier.index') }}" class="btn btn-secondary">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
