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

                @if ($level === 'Administrator' || $level === 'Manajemen' || $level === 'User')
                    <li class="nav-item">
                        <a href="{{ route('dashboard.index') }}"
                            class="nav-link {{ Route::is('dashboard.index') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-th"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                @endif

                @if ($level === 'Administrator' || $level === 'Manajemen')
                    <li class="nav-item">
                        <a href="{{ route('supplier.index') }}"
                            class="nav-link {{ Route::is('supplier.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-truck"></i>
                            <p>Suplier</p>
                        </a>
                    </li>

                    <li
                        class="nav-item {{ Request::is('item*') || Request::is('incoming-item*') || Request::is('exit-item*') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ Request::is('item*') || Request::is('incoming-item*') || Request::is('exit-item*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-boxes"></i>
                            <p>Barang <i class="fas fa-angle-left right"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('item.index') }}"
                                    class="nav-link {{ Request::is('item*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Data Barang</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('incoming-item.index') }}"
                                    class="nav-link {{ Request::is('incoming-item*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Barang Masuk</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('exit-item.index') }}"
                                    class="nav-link {{ Request::is('exit-item*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Barang Keluar</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                @if (in_array($level, ['Administrator', 'Manajemen', 'User']))
                    <li class="nav-item">
                        <a href="{{ route('borrowing.index') }}"
                            class="nav-link {{ Route::is('borrowing.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-dolly"></i>
                            <p>Peminjaman</p>
                        </a>
                    </li>
                @endif

                @if ($level === 'Administrator')
                    <li class="nav-item">
                        <a href="{{ route('user.index') }}"
                            class="nav-link {{ Route::is('user.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Pengguna</p>
                        </a>
                    </li>
                @endif

            </ul>
        </nav>
    </div>
</aside>
