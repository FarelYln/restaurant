<style>
    .navbar-dark.bg-dark {
        background-color: #000 !important; /* Warna hitam solid */
        color: #fff; /* Warna teks putih */
    }

    .navbar-dark.bg-dark .nav-link,
    .navbar-dark.bg-dark .dropdown-toggle {
        color: #fff !important; /* Teks tetap putih */
    }

    .navbar-dark.bg-dark .nav-link.active {
        color: #ffc107 !important; /* Teks menu aktif berwarna kuning */
    }

    .dropdown-menu {
        background-color: #333 !important; /* Dropdown tetap gelap */
        color: #fff;
    }

    .dropdown-menu .dropdown-item {
        color: #fff;
    }

    .dropdown-menu .dropdown-item:hover {
        background-color: #555 !important; /* Warna hover untuk dropdown */
        color: #fff;
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }
</style>

<div class="container-xxl position-relative p-0">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 px-lg-5 py-3 py-lg-0">
        <a href="" class="navbar-brand p-0">
            <h1 class="text-primary m-0"><i class="fa fa-utensils me-3"></i>Restoranto</h1>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="fa fa-bars"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0 pe-4">
                <a href="/" class="nav-item nav-link {{ request()->is('/') ? 'active' : '' }}">Beranda</a>
                <a href="/menu" class="nav-item nav-link {{ request()->is('menu') ? 'active' : '' }}">Menu</a>
                <a href="/profil" class="nav-item nav-link {{ request()->is('profil') ? 'active' : '' }}">Profil</a>

                @auth
                    <a href="/reservasi"
                        class="nav-item nav-link {{ request()->is('reservasi') ? 'active' : '' }}">Reservasi</a>
                @endauth

                <a href="/contact" class="nav-item nav-link {{ request()->is('contact') ? 'active' : '' }}">Contact</a>
            </div>

            @auth
                <div class="navbar-nav ms-auto">
                    <div class="dropdown">
                        <button class="btn dropdown-toggle d-flex align-items-center" type="button" id="userMenu"
                            data-bs-toggle="dropdown" aria-expanded="false"
                            style="background-color: transparent; border: none; color: #fff;">
                            <span>{{ auth()->user()->name }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('profile.edit') }}">
                                    <i class="bi bi-person me-2"></i> Profile
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @else
                <a href="/register" class="btn btn-primary py-2 px-4">Daftar</a>
            @endauth
        </div>
    </nav>
</div>
