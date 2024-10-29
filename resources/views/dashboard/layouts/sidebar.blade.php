<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">
            <div class="sb-sidenav-menu-heading">Core</div>

            <a class="nav-link {{ ($nav_active === 'dashboard')? 'active' : '' }}" href="{{ route('dashboard') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                Dashboard
            </a>

            @if (auth()->user()->role == '1')

            <div class="sb-sidenav-menu-heading">Master</div>

            <a class="nav-link {{ ($nav_active === 'menu-user')? 'active' : '' }}" href="{{ route('user.index') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                User
            </a>

            <a class="nav-link {{ ($nav_active === 'menu-lembaga-legislatif')? 'active' : '' }}" href="{{ route('lembaga-legislatif.index') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                Lembaga Legislatif
            </a>

            <a class="nav-link {{ ($nav_active === 'menu-tahun-pemilihan')? 'active' : '' }}" href="{{ route('tahun-pemilihan.index') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                Tahun Pemilihan
            </a>

            @elseif (auth()->user()->role == '2')

            <div class="sb-sidenav-menu-heading">Pendaftaran</div>

            <a class="nav-link {{ ($nav_active === 'menu-daftar-caleg')? 'active' : '' }}" href="{{ route('daftar-caleg.pilih_lembaga') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-user-tie"></i></div>
                Daftar Caleg
            </a>

            <div class="sb-sidenav-menu-heading">Setting</div>

            <a class="nav-link {{ ($nav_active === 'menu-data-partai')? 'active' : '' }}" href="{{ route('data-partai.index') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                Data Partai
            </a>

            @endif

            {{-- <div class="sb-sidenav-menu-heading">Interface</div>

            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                Layouts
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="layout-static.html">Static Navigation</a>
                    <a class="nav-link" href="layout-sidenav-light.html">Light Sidenav</a>
                </nav>
            </div> --}}
        </div>
    </div>
    <div class="sb-sidenav-footer">
        <div class="small">Logged in as:</div>
        {{ auth()->user()->nama }}
    </div>
</nav>