{{-- @dd(auth()->user()->nama) --}}
<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3 sidebar-sticky">
        <ul class="nav flex-column">
            <h6
                class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase">
                <span>User</span>
            </h6>
            <li class="nav-item">
                <a class="nav-link" href="javascript:void(0)">
                    <i class="bi bi-person-circle"></i>
                    {{ session()->get('pegawai')->nama }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/upload-erm/logout">
                    <i class="bi bi-box-arrow-left"></i>
                    Logout
                </a>
            </li>
            <hr />
            {{-- 
            <li class="nav-item">
                <a class="nav-link {{Request::is('/') ? 'active' : ''}}" href="/upload-erm">
                    <i class="bi bi-house align-text-bottom"></i>
                    Dashboard
                </a>
            </li> --}}
            <li class="nav-item">
                <a class="nav-link {{ Request::is('pasien') ? 'active' : '' }}" href="/upload-erm/pasien">
                    <i class="bi bi-people-fill align-text-bottom"></i>
                    Pasien
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('poliklinik') ? 'active' : '' }}" href="/upload-erm/poliklinik">
                    <i class="bi bi-bandaid-fill align-text-bottom"></i>
                    Poliklinik
                </a>
            </li>

        </ul>
    </div>
</nav>
