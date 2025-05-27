@extends('admin.template')

@section('title')
    Peminjaman
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Data Peminjaman</h3>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <a href="{{ route('borrowing.form-create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Tambah
                                </a>

                                <form action="{{ route('borrowing.index') }}" method="GET" class="form-inline">
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control"
                                            placeholder="Cari Peminjaman..." value="{{ request('search') }}">
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
                                        <th>Barang</th>
                                        <th>Jumlah</th>
                                        <th>Kondisi</th>
                                        <th>Tgl.Pinjam</th>
                                        <th>Tgl.Kembali</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($borrowings as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->items->name }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ $item->condition }}</td>
                                            <td>{{ $item->borrowed_at }}</td>
                                            <td>{{ $item->returned_at }}</td>
                                            <td class="project-state">
                                                @if ($item->status == 'dikembalikan')
                                                    <span class="badge badge-success">{{ $item->status }}</span>
                                                @elseif ($item->status == 'dipinjam')
                                                    <span class="badge badge-danger">{{ $item->status }}</span>
                                                @else
                                                    <span class="badge badge-secondary">{{ $item->status }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <a class="btn btn-warning btn-sm mr-1"
                                                        href="{{ route('borrowing.form-update', ['id' => $item->id]) }}">
                                                        <i class="fas fa-pencil-alt"></i> Ubah
                                                    </a>

                                                    <!-- Tombol Kembalikan hanya muncul jika status belum returned -->
                                                    @if ($item->status != 'dikembalikan')
                                                        <form id="returnForm-{{ $item->id }}"
                                                            action="{{ route('borrowing.return', $item->id) }}"
                                                            method="POST" style="display: inline;">
                                                            @csrf
                                                            <button type="button" class="btn btn-success btn-sm mr-1"
                                                                onclick="confirmReturn('returnForm-{{ $item->id }}')">
                                                                <i class="fas fa-undo"></i> Kembalikan
                                                            </button>
                                                        </form>
                                                    @endif

                                                    <form id="delete-form-{{ $item->id }}"
                                                        action="{{ route('borrowing.delete', ['id' => $item->id]) }}"
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
                                            <td colspan="9" class="text-center">Data Peminjaman Tidak Tersedia.</td>
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

    {{-- alert confirm return --}}
    <script>
        function confirmReturn(formId) {
            Swal.fire({
                title: 'Konfirmasi Pengembalian',
                text: "Apakah Anda yakin ingin menandai barang ini sebagai sudah dikembalikan?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, kembalikan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
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
