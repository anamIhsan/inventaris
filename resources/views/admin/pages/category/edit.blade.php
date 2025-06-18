@extends('admin.template')

@section('title')
    Kategori - Ubah
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
                        <form action="{{ route('category.update', ['id' => $category->id]) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3 text-start">
                                        <label class="form-label"><strong>Nama</strong></label>
                                        <input type="text" name="name" class="form-control"
                                            value="{{ old('name', $category->name) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">Update</button>
                                <a href="{{ route('category.index') }}" class="btn btn-secondary">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
