@extends('admin.template')

@section('title')
    Supplier - Tambah
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
                        <form action="{{ route('supplier.create') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="nameInput">Nama</label>
                                    <input type="text" name="name" class="form-control" id="nameInput"
                                        placeholder="Masukan Nama..." value="{{ old('name') }}">
                                </div>
                                <div class="form-group">
                                    <label for="phoneInput">Telepon</label>
                                    <input type="text" name="phone" class="form-control" id="phoneInput"
                                        placeholder="Masukan Telepon..." value="{{ old('phone') }}">
                                </div>
                                <div class="form-group">
                                    <label for="addressInput">Alamat</label>
                                    <textarea name="address" class="form-control" id="addressInput" placeholder="Masukan Alamat..." rows="5">{{ old('address') }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="imageInput" class="form-label">Gambar</label>
                                    <input name="image" type="file" accept="image/*" class="form-control"
                                        id="imageInput">
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Kirim</button>
                                <a href="{{ route('supplier.index') }}" class="btn btn-danger">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
