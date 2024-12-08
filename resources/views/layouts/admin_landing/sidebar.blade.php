        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-light navbar-light">
                <a href="index.html" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"><i class="fa fa-"></i>Restoranto</h3>
                </a>
               
                <div class="navbar-nav w-100">
                    <a href="/admin" class="nav-item nav-link {{ Request::is('admin') ? 'active' : '' }}">
                        <i class="fa fa-home me-2"></i>Dashboard
                    </a>
                    <a href="/admin/category"
                        class="nav-item nav-link {{ Request::is('admin/category') ? 'active' : '' }}">
                        <i class="fa fa-list me-2"></i>Kategori
                    </a>
                    <a href="/admin/menu" class="nav-item nav-link {{ Request::is('admin/menu') ? 'active' : '' }}">
                        <i class="fa fa-utensils me-2"></i>Menu
                    </a>                    
                    <a href="/admin/reservasi" class="nav-item nav-link {{ Request::is('admin/reservasi') ? 'active' : '' }}">
                        <i class="fa fa-calendar-alt me-2"></i>Reservasi
                    </a>
                    <a href="/admin/pembayaran" class="nav-item nav-link {{ Request::is('admin/pembayaran') ? 'active' : '' }}">
                        <i class="fa fa-credit-card me-2"></i>Pembayaran
                    </a>

                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i
                                class="far fa-file-alt me-2"></i>Pages</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="signin.html" class="dropdown-item">Sign In</a>
                            <a href="signup.html" class="dropdown-item">Sign Up</a>
                            <a href="404.html" class="dropdown-item">404 Error</a>
                            <a href="blank.html" class="dropdown-item">Blank Page</a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->
