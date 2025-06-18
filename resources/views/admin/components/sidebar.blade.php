<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <div class="text-center">
        <a href="{{ route('dashboard.index') }}" class="brand-link">
            <span class="brand-text font-weight-light"><b>Inventaris</b> App</span>
        </a>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-3">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-header">SIDEBAR MENU</li>
                @php
                    $token = Session::get('jwt');
                    $payload = JWTAuth::setToken($token)->getPayload();
                    $level = $payload->get('level');
                @endphp

                <li class="nav-item">
                    <a href="{{ route('dashboard.index') }}"
                        class="nav-link {{ Route::is('dashboard.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('incoming-item.index') }}"
                        class="nav-link {{ Route::is('incoming-item.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-truck"></i>
                        <p>Barang Masuk</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('stok.index') }}" class="nav-link {{ Route::is('stok.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-boxes"></i>
                        <p>Stok Barang</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('borrowing.index') }}"
                        class="nav-link {{ Route::is('borrowing.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-people-carry"></i>
                        <p>Barang Keluar</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('exit-item.index') }}"
                        class="nav-link {{ Route::is('exit-item.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-dolly"></i>
                        <p>Barang Rusak</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="" class="nav-link {{ Route::is('item.stock') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file"></i>
                        <p>Laporan</p>
                    </a>
                </li>

                <li
                    class="nav-item {{ Request::is('user*') || Request::is('supplier*') || Request::is('item*') || Request::is('category*') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ Request::is('user*') || Request::is('supplier*') || Request::is('item*') || Request::is('category*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-thumbtack"></i>
                        <p>
                            Data Master
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('user.index') }}"
                                class="nav-link {{ Route::is('user.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pengguna</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('supplier.index') }}"
                                class="nav-link {{ Route::is('supplier.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Suplier</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('item.index') }}"
                                class="nav-link {{ Route::is('item.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data Barang</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('category.index') }}"
                                class="nav-link {{ Route::is('category.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kategori Barang</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>
