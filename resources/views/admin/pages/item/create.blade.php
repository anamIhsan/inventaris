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
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="categoryInput" class="form-label"><strong>Kategori</strong></label>
                                        <select name="category_id" class="form-control" id="categoryInput">
                                            <option value="">-- Pilih Kategori --</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="nameInput" class="form-label"><strong>Nama Barang</strong></label>
                                        <input type="text" name="name" class="form-control" id="nameInput"
                                            placeholder="Masukkan nama barang..." value="{{ old('name') }}">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="conditionInput" class="form-label"><strong>Kondisi</strong></label>
                                        <input type="text" name="condition" class="form-control" id="conditionInput"
                                            placeholder="Masukkan kondisi barang..." value="{{ old('condition') }}">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="priceInput" class="form-label"><strong>Harga</strong></label>
                                        <input type="number" name="price" class="form-control" id="priceInput"
                                            placeholder="Masukkan Harga barang..." value="{{ old('price') }}">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="fundingInput" class="form-label"><strong>Sumber Dana</strong></label>
                                        <input type="text" name="funding_source" class="form-control" id="fundingInput"
                                            placeholder="Masukkan sumber dana..." value="{{ old('funding_source') }}">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="imageInput" class="form-label"><strong>Gambar</strong></label>
                                        <input type="file" name="image" class="form-control" id="imageInput"
                                            accept="image/*">
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="descriptionInput" class="form-label"><strong>Deskripsi</strong></label>
                                        <textarea name="description" class="form-control" id="descriptionInput" placeholder="Masukkan deskripsi..."
                                            rows="3">{{ old('description') }}</textarea>
                                    </div>
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
