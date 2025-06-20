@extends('admin.template')

@section('title')
    Peminjaman
@endsection

@section('content')
    @php
        $statusButtons = [
            'diminta' => ['disetujui', 'ditolak'],
            'disetujui' => ['dipinjam'],
            'ditolak' => [],
            'dipinjam' => ['dikembalikan'],
            'dikembalikan' => [],
        ];

        $showEdit = ['diminta', 'disetujui'];
        $showReturn = ['dipinjam'];
        $showDelete = ['diminta', 'disetujui', 'ditolak', 'dikembalikan'];
    @endphp

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Data Peminjaman</h3>
                        </div>

                        {{-- Tabs --}}
                        <ul class="nav nav-tabs" id="borrowTabs" role="tablist">
                            @foreach (['all' => 'Semua', 'diminta' => 'Diminta', 'disetujui' => 'Disetujui', 'ditolak' => 'Ditolak', 'dipinjam' => 'Dipinjam', 'dikembalikan' => 'Dikembalikan'] as $key => $label)
                                <li class="nav-item">
                                    <a class="nav-link {{ $loop->first ? 'active' : '' }}" id="{{ $key }}-tab"
                                        data-toggle="tab" href="#{{ $key }}" role="tab"
                                        aria-controls="{{ $key }}"
                                        aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                        {{ $label }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>

                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                @if ($payload->get('level') === 'User')
                                    <a href="{{ route('borrowing.form-create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Tambah
                                    </a>
                                @endif

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

                            <div class="tab-content" id="borrowTabsContent">
                                @foreach (['all' => 'Semua', 'diminta' => 'Diminta', 'disetujui' => 'Disetujui', 'ditolak' => 'Ditolak', 'dipinjam' => 'Dipinjam', 'dikembalikan' => 'Dikembalikan'] as $key => $label)
                                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                        id="{{ $key }}" role="tabpanel"
                                        aria-labelledby="{{ $key }}-tab">
                                        <table class="table table-bordered table-striped">
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
                                                    @if ($payload->get('level') === 'Administrator')
                                                        <th>Aksi</th>
                                                    @endif
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $filtered =
                                                        $key === 'all'
                                                            ? $borrowings
                                                            : $borrowings->where('status', $key);
                                                @endphp

                                                @forelse ($filtered as $item)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $item->users->name }}</td>
                                                        <td>{{ $item->items->name }}</td>
                                                        <td>{{ $item->quantity }}</td>
                                                        <td>{{ $item->condition }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($item->borrowed_at)->format('d M Y') }}
                                                        </td>
                                                        <td>{{ \Carbon\Carbon::parse($item->returned_at)->format('d M Y') }}
                                                        </td>
                                                        <td class="project-state">
                                                            <span
                                                                class="badge
                                                                {{ $item->status === 'dikembalikan'
                                                                    ? 'badge-info'
                                                                    : ($item->status === 'dipinjam'
                                                                        ? 'badge-warning'
                                                                        : ($item->status === 'ditolak'
                                                                            ? 'badge-danger'
                                                                            : ($item->status === 'disetujui'
                                                                                ? 'badge-primary'
                                                                                : ($item->status === 'diminta'
                                                                                    ? 'badge-dark'
                                                                                    : 'badge-secondary')))) }}">
                                                                {{ ucfirst($item->status) }}
                                                            </span>
                                                        </td>
                                                        @if ($payload->get('level') === 'Administrator')
                                                            <td>
                                                                <div class="d-flex flex-wrap align-items-center">
                                                                    {{-- Tombol Status --}}
                                                                    @php
                                                                        $statusButtons = [
                                                                            'diminta' => ['disetujui', 'ditolak'],
                                                                            'disetujui' => ['dipinjam'],
                                                                            'dipinjam' => [],
                                                                            'ditolak' => [],
                                                                            'dikembalikan' => [],
                                                                        ];

                                                                        $showEdit = in_array($item->status, [
                                                                            'diminta',
                                                                            'disetujui',
                                                                        ]);
                                                                        $showDelete = in_array($item->status, [
                                                                            'diminta',
                                                                            'disetujui',
                                                                            'ditolak',
                                                                            'dikembalikan',
                                                                        ]);
                                                                    @endphp

                                                                    {{-- Tombol Ubah --}}
                                                                    @if ($showEdit)
                                                                        <a class="btn btn-warning btn-sm mr-1"
                                                                            href="{{ route('borrowing.form-update', ['id' => $item->id]) }}">
                                                                            <i class="fas fa-pencil-alt"></i> Ubah
                                                                        </a>
                                                                    @endif

                                                                    {{-- Tombol Status Dinamis --}}
                                                                    @foreach ($statusButtons[$item->status] ?? [] as $status)
                                                                        <form
                                                                            action="{{ route('borrowing.update-status', $item->id) }}"
                                                                            method="POST" class="mr-1">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <input type="hidden" name="status"
                                                                                value="{{ $status }}">
                                                                            <button type="submit"
                                                                                class="btn btn-sm
                                                                            {{ $status === 'disetujui'
                                                                                ? 'btn-success'
                                                                                : ($status === 'ditolak'
                                                                                    ? 'btn-danger'
                                                                                    : ($status === 'dipinjam'
                                                                                        ? 'btn-warning'
                                                                                        : 'btn-secondary')) }}">
                                                                                {{ ucfirst($status) }}
                                                                            </button>
                                                                        </form>
                                                                    @endforeach

                                                                    {{-- Tombol Kembalikan --}}
                                                                    @if ($item->status === 'dipinjam')
                                                                        <form id="returnForm-{{ $item->id }}"
                                                                            action="{{ route('borrowing.update-status', $item->id) }}"
                                                                            method="POST" class="mr-1">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <input type="hidden" name="status"
                                                                                value="dikembalikan">
                                                                            <button type="button"
                                                                                class="btn btn-success btn-sm"
                                                                                onclick="confirmReturn('returnForm-{{ $item->id }}')">
                                                                                <i class="fas fa-undo"></i> Kembalikan
                                                                            </button>
                                                                        </form>
                                                                    @endif


                                                                    {{-- Tombol Hapus --}}
                                                                    @if ($showDelete)
                                                                        <form id="delete-form-{{ $item->id }}"
                                                                            action="{{ route('borrowing.delete', ['id' => $item->id]) }}"
                                                                            method="POST" class="mr-1">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="button"
                                                                                class="btn btn-danger btn-sm"
                                                                                onclick="confirmDelete('delete-form-{{ $item->id }}')">
                                                                                <i class="fas fa-trash"></i> Hapus
                                                                            </button>
                                                                        </form>
                                                                    @endif

                                                                </div>
                                                            </td>
                                                        @endif
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="9" class="text-center">Data Tidak Tersedia.</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                @endforeach
                            </div>

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
