<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3 sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{Request::is('/') ? 'active' : ''}}" href="/upload-erm">
                    <i class="bi bi-house align-text-bottom"></i>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{Request::is('pasien') ? 'active' : ''}}" href="/upload-erm/pasien">
                    <i class="bi bi-people-fill align-text-bottom"></i>
                    Pasien
                </a>
            </li>
        </ul>
    </div>
</nav>
