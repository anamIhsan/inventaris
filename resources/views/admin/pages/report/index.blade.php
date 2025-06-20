@extends('admin.template')

@section('title')
    Laporan
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    {{-- FORM FILTER --}}
                    <form action="{{ route('report.filter') }}" method="POST">
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Filter Laporan</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="start_date">Mulai Tanggal</label>
                                        <input type="date" name="start_date" class="form-control" id="start_date"
                                            value="{{ $start ?? request('start_date') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="end_date">Sampai Tanggal</label>
                                        <input type="date" name="end_date" class="form-control" id="end_date"
                                            value="{{ $end ?? request('end_date') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="type">Laporan</label>
                                        <select name="type" class="form-control" id="type">
                                            <option value="">- Pilih Jenis Laporan -</option>
                                            <option value="incoming_item"
                                                {{ ($type ?? request('type')) == 'incoming_item' ? 'selected' : '' }}>Barang
                                                Masuk</option>
                                            <option value="exit_item"
                                                {{ ($type ?? request('type')) == 'exit_item' ? 'selected' : '' }}>Barang
                                                Rusak</option>
                                            <option value="stok_item"
                                                {{ ($type ?? request('type')) == 'stok_item' ? 'selected' : '' }}>Stok
                                                Barang</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Tampilkan</button>
                            </div>
                        </div>
                    </form>

                    {{-- TABEL HASIL LAPORAN --}}
                    @if (isset($data) && count($data))
                        <div class="card mt-4">
                            <div class="card-header">
                                <h4>Hasil Laporan - {{ ucfirst(str_replace('_', ' ', $type)) }}</h4>
                            </div>
                            <div class="card-body table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Barang</th>

                                            @if ($type === 'incoming_item')
                                                <th>Tanggal Masuk</th>
                                                <th>Jumlah</th>
                                                <th>Nama Supplier</th>
                                            @elseif ($type === 'exit_item')
                                                <th>Tanggal Keluar</th>
                                                <th>Jumlah</th>
                                                <th>Lokasi</th>
                                                <th>Penerima</th>
                                                <th>Keterangan</th>
                                            @elseif ($type === 'stok_item')
                                                <th>Kategori</th>
                                                <th>Stok</th>
                                                <th>Minimal Stok</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>

                                                @if ($type === 'incoming_item')
                                                    <td>{{ $item->items->name }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($item->entry_date)->format('d M Y') }}
                                                    </td>
                                                    <td>{{ $item->quantity }}</td>
                                                    <td>{{ $item->suppliers->name }}</td>
                                                @elseif ($type === 'exit_item')
                                                    <td>{{ $item->items->name }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($item->date_out)->format('d M Y') }}</td>
                                                    <td>{{ $item->quantity }}</td>
                                                    <td>{{ $item->location }}</td>
                                                    <td>{{ $item->recipient }}</td>
                                                    <td>{{ $item->notes }}</td>
                                                @elseif ($type === 'stok_item')
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ $item->categories->name ?? '-' }}</td>
                                                    <td>
                                                        {{ $item->stok }}
                                                        @if ($item->stok_warning)
                                                            <span class="badge bg-danger">Stok Rendah</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $item->minimum_stock }}</td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer">
                                {{-- FORM EXPORT PDF DIPISAH --}}
                                @if (isset($data) && count($data))
                                    <form action="{{ route('report.export-pdf') }}" method="POST" target="_blank"
                                        class="mt-3">
                                        @csrf
                                        <input type="hidden" name="start" value="{{ $start }}">
                                        <input type="hidden" name="end" value="{{ $end }}">
                                        <input type="hidden" name="type" value="{{ $type }}">
                                        <input type="hidden" name="data" value="{{ json_encode($data) }}">
                                        <button type="submit" class="btn btn-success">Export PDF</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @elseif(request('type'))
                        <div class="alert alert-warning mt-3">
                            Data tidak ditemukan untuk filter yang dipilih.
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if (session()->has('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
            })
        @endif
    </script>
@endpush
