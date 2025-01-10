<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="{{ route('dashboard') }}" class="logo d-flex align-items-center">
            <img src="{{ asset('assets/img/Icon.png') }}" alt="">
            <span class="d-none d-lg-block">{{ $storeSetting->nama_toko ?? 'Nama Toko Default' }}</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="d-flex align-items-center">
        <span class="d-none d-lg-block ms-3">{{ $storeSetting->alamat_toko ?? 'Alamat Default' }}</span>
    </div><!-- End Alamat Toko -->
    <div class="d-flex align-items-center">
        <span class="d-none d-lg-block ms-3">{{ $storeSetting->nama_pemilik ?? 'Nama Default' }}</span>
    </div>

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            <li class="nav-item d-block d-lg-none">
                <a class="nav-link nav-icon search-bar-toggle" href="#">
                    <i class="bi bi-search"></i>
                </a>
            </li><!-- End Search Icon-->

            <!-- Profile Dropdown -->
            <li class="nav-item dropdown pe-3">
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <img src="{{ $photoUrl }}" alt="Profile Photo" class="rounded-circle">
                    <span class="d-none d-md-block dropdown-toggle ps-2">{{ auth()->user()->username }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6>{{ auth()->user()->username }}</h6> 
                        <span>{{ auth()->user()->role }}</span>
                    </li>
                    <li><hr class="dropdown-divider"></li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('profile.show') }}">
                            <i class="bi bi-person"></i>
                            <span>My Profile</span>
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('profile.edit') }}">
                            <i class="bi bi-gear"></i>
                            <span>Account Settings</span>
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li><hr class="dropdown-divider"></li>

                    <li>
                        <form class="dropdown-item d-flex align-items-center" method="POST" action="{{ route('logout') }}">
                            @csrf
                            <i class="bi bi-box-arrow-right"></i>
                            <button class="dropdown-item" type="submit">Logout</button>
                        </form>
                    </li>
                </ul>
            </li><!-- End Profile Dropdown -->

        </ul>
    </nav><!-- End Icons Navigation -->

</header><!-- End Header -->
