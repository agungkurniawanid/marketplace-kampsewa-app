<div class="az-header">
    <div class="container">
        <div class="az-header-left">
            <a href="index.html" class="az-logo capitalize"><span></span> KampSewa.</a>
            <a href="" id="azMenuShow" class="az-header-menu-icon d-lg-none"><span></span></a>
        </div><!-- az-header-left -->
        <div class="az-header-menu">
            <div class="az-header-menu-header">
                <a href="index.html" class="az-logo"><span></span> azia</a>
                <a href="" class="close">&times;</a>
            </div><!-- az-header-menu-header -->
            <ul class="nav">
                <li class="nav-item {{ $title == 'Dashboard | Customer' ? 'active' : '' }} show">
                    <a href="/customer/dashboard/home" class="nav-link"><i class="typcn typcn-chart-area-outline"></i> Dashboard</a>
                </li>
                <li class="nav-item {{ $title == 'Iklan | Customer' ? 'active' : '' }}">
                    <a href="" class="nav-link with-sub"><i class="typcn typcn-shopping-bag"></i> Transaksi</a>
                    <nav class="az-menu-sub">
                        <a href="page-signin.html" class="nav-link">Penyewaan & Transaksi offline</a>
                        <a href="{{ route('buat-iklan.index', ['id_user' => Crypt::encrypt(session('id_user'))]) }}" class="nav-link">Buat Promosi / Iklan</a>
                    </nav>
                </li>
                <li class="nav-item {{ $title == 'Update Produk' ? 'active' : ''}} {{ $title == 'Detail Produk' ? 'active' : ''}} {{ $title == 'Tambah Produk' ? 'active' : '' }} {{ $title == 'Sedang Disewa | KampSewa' ? 'active' : '' }} {{ $title == 'Kelola Produk | KampSewa' ? 'active' : '' }} {{ $title == 'Produk Menu | KampSewa' ? 'active' : '' }}">
                    <a href="{{ route('menu-produk.index', ['id_user' => Crypt::encrypt(session('id_user'))]) }}" class="nav-link"><i class="typcn typcn-shopping-cart"></i>
                        Produk</a>
                </li>
                <li class="nav-item {{ $title == 'Menu Pengeluaran' ? 'active' : ''}} {{ $title == 'Menu Keuangan' ? 'active' : ''}}">
                    <a href="{{ route('keuangan.index', ['id_user' => Crypt::encrypt(session('id_user'))]) }}" class="nav-link"><i class="typcn typcn-chart-bar-outline"></i>
                        Keuangan & Laporan</a>
                </li>
            </ul>
        </div><!-- az-header-menu -->
        <div class="az-header-right">
            <div class="az-header-message">
                <a href="#"><i class="typcn typcn-messages"></i></a>
            </div><!-- az-header-message -->
            <div class="dropdown az-profile-menu">
                <a href="" class="az-img-user"><img src="{{ asset('assets/image/customers/profile/' . session('foto')) }}" alt=""></a>
                <div class="dropdown-menu">
                    <div class="az-dropdown-header d-sm-none">
                        <a href="" class="az-header-arrow"><i class="icon ion-md-arrow-back"></i></a>
                    </div>
                    <div class="az-header-profile">
                        <div class="az-img-user">
                            <img src="{{ asset('template/azia/img/faces/face1.jpg') }}" alt="">
                        </div><!-- az-img-user -->
                        <h6>Aziana Pechon</h6>
                        <span>Premium Member</span>
                    </div><!-- az-header-profile -->

                    <a href="" class="dropdown-item"><i class="typcn typcn-user-outline"></i> My Profile</a>
                    <a href="" class="dropdown-item"><i class="typcn typcn-edit"></i> Edit Profile</a>
                    <a href="" class="dropdown-item"><i class="typcn typcn-time"></i> Activity Logs</a>
                    <a href="" class="dropdown-item"><i class="typcn typcn-cog-outline"></i> Account
                        Settings</a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="dropdown-item"><i class="typcn typcn-power-outline"></i> Sign
                            Out</button></form>
                </div><!-- dropdown-menu -->
            </div>
        </div><!-- az-header-right -->
    </div><!-- container -->
</div><!-- az-header -->