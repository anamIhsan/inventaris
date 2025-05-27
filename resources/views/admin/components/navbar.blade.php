<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item">
            <div class="d-flex align-items-center gap-3">
                @php
                    $token = Session::get('jwt');
                    $payload = JWTAuth::setToken($token)->getPayload();
                @endphp
                <img src="{{ Storage::url($payload->get('photo')) }}" class="rounded-circle" alt=""
                    width="40" height="40">
                <p class="mb-0 fw-semibold">{{ $payload->get('name') }} - {{ $payload->get('level') }}</p>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('auth.logout') }}">
                <i class="fas fa-sign-out-alt"></i>
                <span class="">Logout</span>
            </a>
        </li>
    </ul>
</nav>
