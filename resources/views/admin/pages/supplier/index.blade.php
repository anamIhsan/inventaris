@extends('admin.template')

@section('title')
    Supplier
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Data Supplier</h3>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <a href="{{ route('supplier.form-create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Tambah
                                </a>

                                <form action="{{ route('supplier.index') }}" method="GET" class="form-inline">
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control" placeholder="Cari supplier..." value="{{ request('search') }}">
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
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                        <th>Telepon</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($suppliers as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ \Illuminate\Support\Str::limit($item->address, 40, '...') }}</td>
                                            <td>{{ $item->phone }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <button type="button" class="btn btn-info btn-sm mr-1"
                                                        onclick="showDetail({{ $item->id }})">
                                                        <i class="fas fa-eye"></i> Detail
                                                    </button>
                                                    <a class="btn btn-warning btn-sm mr-1"
                                                        href="{{ route('supplier.form-update', ['id' => $item->id]) }}">
                                                        <i class="fas fa-pencil-alt"></i> Ubah
                                                    </a>

                                                    <form id="delete-form-{{ $item->id }}"
                                                        action="{{ route('supplier.delete', ['id' => $item->id]) }}"
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
                                            <td colspan="6" class="text-center">Data Supplier Tidak Tersedia.</td>
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
            const supplier = @json($suppliers->keyBy('id'));

            if (supplier[id]) {
                const data = supplier[id];
                Swal.fire({
                    title: `<strong>Detail Supplier</strong>`,
                    html: `
                        <form>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><strong>Nama</strong></label>
                                    <input type="text" class="form-control" value="${data.name}" disabled>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><strong>Telepon</strong></label>
                                    <input type="text" class="form-control" value="${data.phone}" disabled>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><strong>Alamat</strong></label>
                                    <textarea class="form-control" rows="5" disabled>${data.address}</textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><strong>Gambar</strong></label><br>
                                    <img src="/storage/${data.image.replace('public/', '')}" class="img-thumbnail w-100">
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
                Swal.fire('Oops', 'Data supplier tidak ditemukan.', 'error');
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
