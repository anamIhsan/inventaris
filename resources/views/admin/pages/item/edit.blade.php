@extends('admin.template')

@section('title')
    Barang - Ubah
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
                        <form action="{{ route('item.update', ['id' => $item->id]) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3 text-start">
                                        <label class="form-label" for="categoryInput"><strong>Kategori</strong></label>
                                        <select name="category_id" class="form-control" id="categoryInput">
                                            <option value="">-- Pilih Kategori --</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('category_id', $item->category_id) == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3 text-start">
                                        <label class="form-label" for="nameInput"><strong>Nama Barang</strong></label>
                                        <input type="text" name="name" class="form-control" id="nameInput"
                                            placeholder="Masukkan nama barang..." value="{{ old('name', $item->name) }}">
                                    </div>

                                    <div class="col-md-6 mb-3 text-start">
                                        <label class="form-label" for="conditionInput"><strong>Kondisi</strong></label>
                                        <input type="text" name="condition" class="form-control" id="conditionInput"
                                            placeholder="Masukkan kondisi barang..."
                                            value="{{ old('condition', $item->condition) }}">
                                    </div>

                                    <div class="col-md-6 mb-3 text-start">
                                        <label class="form-label" for="priceInput"><strong>Harga</strong></label>
                                        <input type="number" name="price" class="form-control" id="priceInput"
                                            placeholder="Masukkan harga barang..." value="{{ old('price', $item->price) }}">
                                    </div>

                                    <div class="col-md-6 mb-3 text-start">
                                        <label class="form-label" for="fundingInput"><strong>Sumber Dana</strong></label>
                                        <input type="text" name="funding_source" class="form-control" id="fundingInput"
                                            placeholder="Masukkan sumber dana..."
                                            value="{{ old('funding_source', $item->funding_source) }}">
                                    </div>

                                    <div class="col-md-6 mb-3 text-start">
                                        <label class="form-label" for="descriptionInput"><strong>Deskripsi</strong></label>
                                        <textarea name="description" class="form-control" id="descriptionInput" rows="1"
                                            placeholder="Masukkan deskripsi...">{{ old('description', $item->description) }}</textarea>
                                    </div>

                                    <div class="col-md-12 mb-3 text-start">
                                        <label class="form-label" for="imageInput"><strong>Gambar</strong></label><br>
                                        @if ($item->image)
                                            <img src="{{ Storage::url($item->image) }}" alt="Gambar Barang"
                                                class="mb-2 img-thumbnail" width="100">
                                        @endif
                                        <input type="file" name="image" class="form-control" id="imageInput"
                                            accept="image/*">
                                        <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah
                                            gambar.</small>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">Update</button>
                                <a href="{{ route('item.index') }}" class="btn btn-secondary">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
