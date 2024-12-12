        <!-- Sidebar Start -->

        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-light navbar-light">
                <a href="index.html" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"><i class="fa fa-"></i>Restoranto</h3>
                </a>
               
                <div class="navbar-nav w-100">
                    <a href="/dashboard" class="nav-item nav-link {{ Request::is('admin') ? 'active' : '' }}">
                        <i class="fa fa-home me-2"></i>Dashboard
                    </a>
                    <a href="/admin/category"
                        class="nav-item nav-link {{ Request::is('admin/category') ? 'active' : '' }}">
                        <i class="fa fa-list me-2"></i>Kategori
                    </a>
                    <a href="/admin/menu" class="nav-item nav-link {{ Request::is('admin/menu') ? 'active' : '' }}">
                        <i class="fa fa-utensils me-2"></i>Menu
                    </a>              
                    <a href="/admin/location" class="nav-item nav-link {{ Request::is('admin/location') ? 'active' : '' }}">
                        <i class="fa fa-map-marker me-2"></i>Lokasi
                    </a>
                    <a href="/admin/meja" class="nav-item nav-link {{ Request::is('admin/meja') ? 'active' : '' }}">
                        <i class="fa fa-table me-2"></i>Meja
                    </a>      
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-calendar-alt me-2"></i>Reservasi
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="/admin/reservasi" class="dropdown-item {{ Request::is('admin/reservasi') ? 'active' : '' }}">
                                <i class="fa fa-calendar me-2"></i>Reservasi
                            </a>
                            <a href="/admin/reservasi/history" class="dropdown-item {{ Request::is('admin/reservasi/history') ? 'active' : '' }}">
                                <i class="fa fa-history me-2"></i>History Reservasi
                            </a>
                        </div>
                    </div>
                    <a href="/admin/pembayaran" class="nav-item nav-link {{ Request::is('admin/pembayaran') ? 'active' : '' }}">
                        <i class="fa fa-credit-card me-2"></i>Pembayaran
                    </a>
                    
                </div>
            </nav>
        </div>


        <!-- Sidebar End -->
