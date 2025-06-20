@extends('admin.template')

@section('title')
    Dashboard
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $suppliers }}</h3>

                            <p>Supplier</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-truck"></i>
                        </div>
                        <a href="{{ route('supplier.index') }}" class="small-box-footer">Info Selengkapnya <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $items }}</h3>

                            <p>Barang</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-boxes"></i>
                        </div>
                        <a href="{{ route('item.index') }}" class="small-box-footer">Info Selengkapnya <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $borrowings }}</h3>

                            <p>Peminjaman</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-dolly"></i>
                        </div>
                        <a href="{{ route('borrowing.index') }}" class="small-box-footer">Info Selengkapnya <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $users }}</h3>

                            <p>Pengguna</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="{{ route('user.index') }}" class="small-box-footer">Info Selengkapnya <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-6">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Barang Masuk 30 Hari Terakhir</h5>
                        </div>
                        <div class="card-body">
                            @if ($incomingItems->isEmpty())
                                <p class="text-muted">Belum ada barang masuk dalam 30 hari terakhir.</p>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Nama Barang</th>
                                                <th>Jumlah</th>
                                                <th>Tanggal Masuk</th>
                                                <th>Suplier</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($incomingItems as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item->items->name }}</td>
                                                    <td>{{ $item->quantity }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($item->entry_date)->format('d M Y') }}
                                                    </td>
                                                    <td>{{ $item->suppliers->name }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card-header bg-danger text-white">
                            <h5 class="mb-0">Barang Rusak 30 Hari Terakhir</h5>
                        </div>
                        <div class="card-body">
                            @if ($exitItems->isEmpty())
                                <p class="text-muted">Belum ada barang Rusak dalam 30 hari terakhir.</p>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Nama Barang</th>
                                                <th>Jumlah</th>
                                                <th>Tanggal Keluar</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($exitItems as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item->items->name }}</td>
                                                    <td>{{ $item->quantity }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($item->date_out)->format('d M Y') }}
                                                    </td>
                                                    <td>{{ $item->notes }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
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
@endpush
