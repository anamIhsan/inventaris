<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inventaris | @yield('title')</title>

    <!-- Header -->
    @include('admin.components.header')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        @include('admin.components.navbar')

        <!-- Sidebar -->
        @include('admin.components.sidebar')

        <!-- Main Content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">@yield('title')</h1>
                        </div>
                    </div>
                    @if ($errors->any())
                        {{-- muncul error jika ada pesan error dari controller withErrors() --}}
                        <div class="alert alert-danger">
                            <ul>
                                {{-- menampilkan semua list error --}}
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Content -->
            @yield('content')
        </div>
        <!-- Footer -->
        @include('admin.components.footer')
    </div>
    <!-- Script -->
    @include('admin.components.script')

    @stack('scripts')
</body>

</html>
