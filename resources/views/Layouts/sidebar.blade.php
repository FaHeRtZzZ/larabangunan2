<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <!-- Compon ents Nav -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#menu-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-menu-button-wide"></i><span>Menu</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="menu-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li><a href="{{route('barang') }}"><i class="bi bi-circle"></i><span>Barang</span></a></li>
                <li><a href="{{ route('kategori.index') }}"><i class="bi bi-circle"></i><span>Kategori</span></a></li>
                <li><a class="nav-link" href="{{ route('profile.show') }}"><i class="bi bi-circle"></i></i><span>Profile</span></a></li>
                <!-- Add more components here -->
            </ul>
        </li>
        <!-- Transaksi Nav -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#transaksi-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-menu-button-wide"></i><span>Transaksi</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="transaksi-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li><a href="{{ route('penjualan.index') }}"><i class="bi bi-circle"></i><span>Transaksi Jual</span></a></li>
                <li><a href="{{ route('laporan.penjualan') }}"><i class="bi bi-circle"></i><span>Laporan Penjualan</span></a></li>
                <!-- Add more components here -->
            </ul>
        </li>
        <!-- Setting Nav -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#setting-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-menu-button-wide"></i><span>Setting</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="setting-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li><a href="{{ route('store-settings.index') }}"><i class="bi bi-circle"></i><span>Pengaturan Toko</span></a></li>
                <!-- Add more components here -->
            </ul>
        </li>   
        <!-- Add other navigation items here -->
    </ul>
</aside>
