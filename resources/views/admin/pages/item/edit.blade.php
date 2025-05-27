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
                        <form action="{{ route('item.update', ['id' => $item->id]) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3 text-start">
                                        <label class="form-label"><strong>Nama</strong></label>
                                        <input type="text" name="name" class="form-control" value="{{ old('name', $item->name) }}">
                                    </div>
                                    <div class="col-md-6 mb-3 text-start">
                                        <label class="form-label"><strong>Spesifikasi</strong></label>
                                        <input type="text" name="specification" class="form-control" value="{{ old('specification', $item->specification) }}">
                                    </div>
                                    <div class="col-md-6 mb-3 text-start">
                                        <label class="form-label"><strong>Lokasi</strong></label>
                                        <input type="text" name="location" class="form-control" value="{{ old('location', $item->location) }}">
                                    </div>
                                    <div class="col-md-6 mb-3 text-start">
                                        <label class="form-label"><strong>Kondisi</strong></label>
                                        <input type="text" name="condition" class="form-control" value="{{ old('condition', $item->condition) }}">
                                    </div>
                                    <div class="col-md-6 mb-3 text-start">
                                        <label class="form-label"><strong>Sumber Dana</strong></label>
                                        <input type="text" name="funding_source" class="form-control" value="{{ old('funding_source', $item->funding_source) }}">
                                    </div>
                                    <div class="col-md-6 mb-3 text-start">
                                        <label class="form-label"><strong>Jenis Barang</strong></label>
                                        <select name="item_type" class="form-control">
                                            <option value="sarana" {{ old('item_type', $item->item_type) == 'sarana' ? 'selected' : '' }}>Sarana</option>
                                            <option value="prasarana" {{ old('item_type', $item->item_type) == 'prasarana' ? 'selected' : '' }}>Prasarana</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12 mb-3 text-start">
                                        <label class="form-label"><strong>Deskripsi</strong></label>
                                        <textarea name="description" class="form-control" rows="4">{{ old('description', $item->description) }}</textarea>
                                    </div>
                                    <div class="col-md-12 mb-3 text-start">
                                        <label class="form-label"><strong>Gambar</strong></label>
                                        <input type="file" name="image" class="form-control" accept="image/*">
                                        @if ($item->image)
                                            <div class="mt-2">
                                                <small>Gambar saat ini:</small><br>
                                                <img src="{{ Storage::url($item->image) }}" width="120" class="img-thumbnail" alt="Gambar Item">
                                            </div>
                                        @endif
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
