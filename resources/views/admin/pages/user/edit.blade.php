@extends('admin.template')

@section('title')
    Pengguna - Ubah
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
                        <form action="{{ route('user.update', ['id' => $user->id]) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3 text-start">
                                        <label class="form-label"><strong>Nama</strong></label>
                                        <input type="text" name="name" class="form-control"
                                            value="{{ old('name', $user->name) }}">
                                    </div>
                                    <div class="col-md-6 mb-3 text-start">
                                        <label class="form-label"><strong>Email</strong></label>
                                        <input type="email" name="email" class="form-control"
                                            value="{{ old('email', $user->email) }}">
                                    </div>
                                    <div class="col-md-6 mb-3 text-start">
                                        <label class="form-label"><strong>Password</strong> <small
                                                class="text-muted">(Kosongkan jika tidak ingin diubah)</small></label>
                                        <input type="password" name="password" class="form-control"
                                            placeholder="Isi untuk mengubah password">
                                    </div>
                                    <div class="col-md-6 mb-3 text-start">
                                        <label class="form-label"><strong>Level</strong></label>
                                        <select name="level" class="form-control">
                                            <option value="Administrator"
                                                {{ old('level', $user->level) == 'Administrator' ? 'selected' : '' }}>
                                                Administrator</option>
                                            <option value="Manajemen"
                                                {{ old('level', $user->level) == 'Manajemen' ? 'selected' : '' }}>Manajemen
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3 text-start">
                                        <label class="form-label"><strong>Foto</strong></label>
                                        <input type="file" name="photo" class="form-control" accept="image/*">
                                        @if ($user->photo)
                                            <div class="mt-2">
                                                <small>Foto saat ini:</small><br>
                                                <img src="{{ Storage::url($user->photo) }}" width="120"
                                                    class="img-thumbnail" alt="Foto User">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">Update</button>
                                <a href="{{ route('user.index') }}" class="btn btn-secondary">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
