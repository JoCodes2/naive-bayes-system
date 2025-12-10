<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="/" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ asset('assets/assets/logonaivebayes.png') }}" alt="Logo" class="img-fluid" width="50"
                    height="50">
            </span>
            <span class="text-start app-brand-text fw-bold ms-2">
                <small>Cabi</small><br>
                <small>Sense</small><br>
                <small>Tadulako Pride</small>
            </span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">

        <!-- ==================== PENGATURAN AKUN ==================== -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Analisis</span>
        </li>

        <li class="menu-item {{ request()->is('/') ? 'active' : '' }}">
            <a href="/" class="menu-link">
                <i class="menu-icon  fa-solid fa-stethoscope"></i>
                <div>Diagnosa</div>
            </a>
        </li>
         <li class="menu-item {{ request()->is('/riwayat') ? 'active' : '' }}">
            <a href="/riwayat" class="menu-link">
                <i class="menu-icon fa-solid fa-clock-rotate-left"></i>
                <div>Riwayat</div>
            </a>
        </li>

        <!-- ==================== DATA MASTER ==================== -->
        <li class="menu-header small text-uppercase mt-3">
            <span class="menu-header-text">Data Master</span>
        </li>

        <li class="menu-item {{ request()->is('gejala') ? 'active' : '' }}">
            <a href="/gejala" class="menu-link">
                <i class="menu-icon fa-solid fa-virus"></i>
                <div>Gejala Penyakit</div>
            </a>
        </li>
        <li class="menu-item {{ request()->is('parameter-lingkungan') ? 'active' : '' }}">
            <a href="/parameter-lingkungan" class="menu-link">
                <i class="menu-icon fa-solid fa-hand-holding-droplet"></i>
                <div>Parameter Lingkungan</div>
            </a>
        </li>
        <li class="menu-item {{ request()->is('penyakit') ? 'active' : '' }}">
            <a href="/penyakit" class="menu-link">
                <i class="menu-icon fa-solid fa-virus-covid"></i>
                <div>Penyakit</div>
            </a>
        </li>
        <li class="menu-item {{ request()->is('aturan-gejala') ? 'active' : '' }}">
            <a href="/aturan-gejala" class="menu-link">
                <i class="menu-icon fa-solid fa-book-medical"></i>
                <div>Aturan Gejala</div>
            </a>
        </li>
        <li class="menu-item {{ request()->is('aturan-penyakit-lingkungan') ? 'active' : '' }}">
            <a href="/aturan-penyakit-lingkungan" class="menu-link">
                <i class="menu-icon fa-solid fa-book-dead"></i>
                <div>Aturan Penyakit & Lingkungan</div>
            </a>
        </li>
    </ul>
</aside>
<!-- / Menu -->
