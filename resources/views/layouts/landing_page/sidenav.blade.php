<!-- Navbar & Hero Start -->
<div class="container-xxl position-relative p-0">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 px-lg-5 py-3 py-lg-0">
        <a href="" class="navbar-brand p-0">
            <h1 class="text-primary m-0"><i class="fa fa-utensils me-3"></i>Restoran</h1>
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
                    <!-- Menampilkan menu reservasi jika sudah login -->
                    <a href="/reservasi" class="nav-item nav-link {{ request()->is('reservasi') ? 'active' : '' }}">Reservasi</a>
                
                @endauth

                <a href="/contact" class="nav-item nav-link {{ request()->is('contact') ? 'active' : '' }}">Contact</a>
            </div>

            @auth
                <!-- Menampilkan profil pengguna jika sudah login -->
                <div class="navbar-nav ms-auto">
                    <!-- Dropdown untuk menampilkan username dan menu -->
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ auth()->user()->name }} <!-- Menampilkan nama pengguna -->
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="userMenu">
                            <!-- Menu Profile -->
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                            <!-- Menu Logout -->
                            <li><a class="dropdown-item" href="{{ route('logout') }}" 
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
                        </ul>
                    </div>
                </div>
                
                <!-- Form Logout -->
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                
                
            @else
                <!-- Menampilkan tombol daftar jika belum login -->
                <a href="/register" class="btn btn-primary py-2 px-4">Daftar</a>
            @endauth
        </div>                
    </nav>
</div>
<!-- Navbar & Hero End -->
