@extends('admin.template')

@section('title')
    Pengguna - Tambah
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
                        <form action="{{ route('user.create') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="nameInput">Nama</label>
                                    <input type="text" name="name" class="form-control" id="nameInput"
                                        placeholder="Masukkan nama..." value="{{ old('name') }}">
                                </div>

                                <div class="form-group">
                                    <label for="emailInput">Email</label>
                                    <input type="email" name="email" class="form-control" id="emailInput"
                                        placeholder="Masukkan email..." value="{{ old('email') }}">
                                </div>

                                <div class="form-group">
                                    <label for="passwordInput">Password</label>
                                    <input type="password" name="password" class="form-control" id="passwordInput"
                                        placeholder="Masukkan password...">
                                </div>

                                <div class="form-group">
                                    <label for="photoInput">Foto</label>
                                    <input type="file" name="photo" class="form-control-file" id="photoInput">
                                </div>

                                <div class="form-group">
                                    <label for="levelInput">Level</label>
                                    <select name="level" class="form-control" id="levelInput">
                                        <option value="">-- Pilih Level --</option>
                                        <option value="Administrator"
                                            {{ old('level') == 'Administrator' ? 'selected' : '' }}>Administrator</option>
                                        <option value="Manajemen" {{ old('level') == 'Manajemen' ? 'selected' : '' }}>
                                            Manajemen</option>
                                    </select>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Kirim</button>
                                <a href="{{ route('user.index') }}" class="btn btn-danger">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
