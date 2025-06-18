@extends('admin.template')

@section('title')
    Barang
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Data Barang</h3>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <a href="{{ route('item.form-create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Tambah
                                </a>

                                <form action="{{ route('item.index') }}" method="GET" class="form-inline">
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control"
                                            placeholder="Cari Barang..." value="{{ request('search') }}">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="submit">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Kategori</th>
                                        <th>Nama</th>
                                        <th>Kondisi</th>
                                        <th>Harga</th>
                                        <th>Sumber Dana</th>
                                        <th>Stok</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($items as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->categories->name }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->condition }}</td>
                                            <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                            <td>{{ $item->funding_source }}</td>
                                            <td>{{ $item->stok }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <button type="button" class="btn btn-info btn-sm mr-1"
                                                        onclick="showDetail({{ $item->id }})">
                                                        <i class="fas fa-eye"></i> Detail
                                                    </button>
                                                    <a class="btn btn-warning btn-sm mr-1"
                                                        href="{{ route('item.form-update', ['id' => $item->id]) }}">
                                                        <i class="fas fa-pencil-alt"></i> Ubah
                                                    </a>

                                                    <form id="delete-form-{{ $item->id }}"
                                                        action="{{ route('item.delete', ['id' => $item->id]) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-danger btn-sm"
                                                            onclick="confirmDelete('delete-form-{{ $item->id }}')">
                                                            <i class="fas fa-trash"></i> Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">Data Barang Tidak Tersedia.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- alert success --}}
    <script>
        if ({{ session()->has('success') }}) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
            })
        }
    </script>

    {{-- show detail --}}
    <script>
        function showDetail(id) {
            const item = @json($items->keyBy('id'));

            if (item[id]) {
                const data = item[id];
                Swal.fire({
                    title: `<strong>Detail Barang</strong>`,
                    html: `
                        <form>
                            <div class="row">
                                <div class="col-md-6 mb-3 text-start">
                                    <label class="form-label"><strong>Kategori</strong></label>
                                    <input type="text" class="form-control" value="${data.categories.name}" disabled>
                                </div>
                                <div class="col-md-6 mb-3 text-start">
                                    <label class="form-label"><strong>Nama</strong></label>
                                    <input type="text" class="form-control" value="${data.name}" disabled>
                                </div>
                                <div class="col-md-6 mb-3 text-start">
                                    <label class="form-label"><strong>Kondisi</strong></label>
                                    <input type="text" class="form-control" value="${data.condition}" disabled>
                                </div>
                                <div class="col-md-6 mb-3 text-start">
                                    <label class="form-label"><strong>Harga</strong></label>
                                    <input type="text" class="form-control" value="Rp ${Number(data.price).toLocaleString('id-ID')}" disabled>
                                </div>

                                <div class="col-md-6 mb-3 text-start">
                                    <label class="form-label"><strong>Sumber Dana</strong></label>
                                    <input type="text" class="form-control" value="${data.funding_source}" disabled>
                                </div>
                                <div class="col-md-6 mb-3 text-start">
                                    <label class="form-label"><strong>Deskripsi</strong></label>
                                    <textarea class="form-control" rows="1" disabled>${data.description}</textarea>
                                </div>
                                <div class="col-md-12 mb-3 text-start">
                                    <label class="form-label"><strong>Gambar</strong></label><br>
                                    <img src="/storage/${data.image.replace('public/', '')}" width="200" class="img-thumbnail">
                                </div>
                            </div>
                        </form>
                    `,
                    width: 600,
                    showCloseButton: true,
                    confirmButtonText: 'Tutup',
                    focusConfirm: false,
                });
            } else {
                Swal.fire('Oops', 'Data Barang tidak ditemukan.', 'error');
            }
        }
    </script>

    {{-- alert confirm delete --}}
    <script>
        function confirmDelete(formId) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        }
    </script>
@endpush
