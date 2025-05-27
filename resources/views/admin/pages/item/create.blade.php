@extends('admin.template')

@section('title')
    Barang - Tambah
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
                        <form action="{{ route('item.create') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="nameInput">Nama Barang</label>
                                    <input type="text" name="name" class="form-control" id="nameInput"
                                        placeholder="Masukkan nama barang..." value="{{ old('name') }}">
                                </div>

                                <div class="form-group">
                                    <label for="imageInput">Gambar</label>
                                    <input type="file" name="image" class="form-control" id="imageInput"
                                        accept="image/*">
                                </div>

                                <div class="form-group">
                                    <label for="specificationInput">Spesifikasi</label>
                                    <textarea name="specification" class="form-control" id="specificationInput" placeholder="Masukkan spesifikasi..."
                                        rows="3">{{ old('specification') }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="locationInput">Lokasi</label>
                                    <input type="text" name="location" class="form-control" id="locationInput"
                                        placeholder="Masukkan lokasi..." value="{{ old('location') }}">
                                </div>

                                <div class="form-group">
                                    <label for="conditionInput">Kondisi</label>
                                    <input type="text" name="condition" class="form-control" id="conditionInput"
                                        placeholder="Masukkan kondisi barang..." value="{{ old('condition') }}">
                                </div>

                                <div class="form-group">
                                    <label for="fundingInput">Sumber Dana</label>
                                    <input type="text" name="funding_source" class="form-control" id="fundingInput"
                                        placeholder="Masukkan sumber dana..." value="{{ old('funding_source') }}">
                                </div>

                                <div class="form-group">
                                    <label for="descriptionInput">Deskripsi</label>
                                    <textarea name="description" class="form-control" id="descriptionInput" placeholder="Masukkan deskripsi..."
                                        rows="3">{{ old('description') }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="typeInput">Jenis Barang</label>
                                    <select name="item_type" class="form-control" id="typeInput">
                                        <option value="">-- Pilih Jenis --</option>
                                        <option value="sarana" {{ old('item_type') == 'sarana' ? 'selected' : '' }}>Sarana
                                        </option>
                                        <option value="prasarana" {{ old('item_type') == 'prasarana' ? 'selected' : '' }}>
                                            Prasarana</option>
                                    </select>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Kirim</button>
                                <a href="{{ route('item.index') }}" class="btn btn-danger">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
