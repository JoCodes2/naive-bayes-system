        <!-- Menu -->

        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
            <div class="app-brand demo">
                <a href="index.html" class="app-brand-link">
                    <span class="app-brand-logo demo">
                        <img src="{{ asset('assets/assets/logonaivebayes.png') }}" alt="Logo" class="img-fluid"
                            width="50" height="50">
                    </span>
                    <span class="text-start app-brand-text fw-bold ms-2 ">
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
                <li class="menu-item {{ request()->is('/') ? 'active' : '' }}">
                    <a href="/" class="menu-link">
                        <i class="menu-icon fa-solid fa-user"></i>
                        <div data-i18n="Analytics">Pengguna</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('gejala') ? 'active' : '' }}">
                    <a href="/gejala" class="menu-link">
                        <i class="menu-icon fa-solid fa-virus"></i>
                        <div data-i18n="Analytics">Gejala Penyakit</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('penyakit') ? 'active' : '' }}">
                    <a href="/penyakit" class="menu-link">
                        <i class="menu-icon fa-solid fa-disease"></i>
                        <div data-i18n="Analytics">Penyakit</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('perawatan') ? 'active' : '' }}">
                    <a href="/perawatan" class="menu-link">
                        <i class="menu-icon fa-solid fa-hand-holding-medical"></i>
                        <div data-i18n="Analytics">Perawatan</div>
                    </a>
                </li>
            </ul>
        </aside>
        <!-- / Menu -->
