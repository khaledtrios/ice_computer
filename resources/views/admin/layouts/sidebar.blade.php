<div class="sidebar-wrapper" data-sidebar-layout="stroke-svg">
    <div>
        <div class="logo-wrapper text-center py-4">
            <a href="{{ route('superadmin.boutiques.list') }}">
                <img class="img-fluid for-light" src="{{asset('assets/images/logo-dark.png')}}" alt="Logo"
                    style="max-height: 50px;" />
                <img class="img-fluid for-dark" src="{{asset('assets/images/logo-dark.png')}}" alt="Logo"
                    style="max-height: 50px;" />
            </a>
        </div>

        <nav class="sidebar-main">
            <div id="sidebar-menu">
                <ul class="sidebar-links list-unstyled" id="simple-bar">
                    <!-- Section Boutiques -->
                    <li class="sidebar-main-title my-3">
                        <div class="d-flex align-items-center px-3">
                            <i class="fas fa-store fa-lg me-2 "></i>
                            <h6 class="mb-0 text-uppercase fw-bold">Boutiques</h6>
                        </div>
                    </li>

                    <li class="nav-item my-1">
                        <a class="nav-link py-3 d-flex align-items-center {{ request()->routeIs('superadmin.boutiques.list') ? 'active' : '' }}"
                            href="{{ route('superadmin.boutiques.list') }}">
                            <i class="fas fa-users fa-lg me-3"></i>
                            <span class="fs-6">Liste boutiques</span>
                        </a>
                    </li>

                    <!-- Section Listes -->
                    <li class="sidebar-main-title my-3 mt-4">
                        <div class="d-flex align-items-center px-3">
                            <i class="fas fa-list fa-lg me-2 "></i>
                            <h6 class="mb-0 text-uppercase fw-bold">Listes</h6>
                        </div>
                    </li>

                    <li class="nav-item my-1">
                        <a class="nav-link py-3 d-flex align-items-center {{ request()->routeIs('superadmin.materiels.index') ? 'active' : '' }}"
                            href="{{ route('superadmin.materiels.index') }}">
                            <i class="fas fa-laptop fa-lg me-3"></i>
                            <span class="fs-6">Liste Matériels</span>
                        </a>
                    </li>

                    <li class="nav-item my-1">
                        <a class="nav-link py-3 d-flex align-items-center {{ request()->routeIs('superadmin.marques.index') ? 'active' : '' }}"
                            href="{{ route('superadmin.marques.index') }}">
                            <i class="fas fa-tag fa-lg me-3"></i>
                            <span class="fs-6">Liste Marques</span>
                        </a>
                    </li>

                    <li class="nav-item my-1">
                        <a class="nav-link py-3 d-flex align-items-center {{ request()->routeIs('superadmin.modeles.index') ? 'active' : '' }}"
                            href="{{ route('superadmin.modeles.index') }}">
                            <i class="fas fa-mobile-alt fa-lg me-3"></i>
                            <span class="fs-6">Liste Modèles</span>
                        </a>
                    </li>

                    <li class="nav-item my-1">
                        <a class="nav-link py-3 d-flex align-items-center {{ request()->routeIs('superadmin.pannes.index') ? 'active' : '' }}"
                            href="{{ route('superadmin.pannes.index') }}">
                            <i class="fas fa-tools fa-lg me-3"></i>
                            <span class="fs-6">Liste Pannes</span>
                        </a>
                    </li>

                    <li class="nav-item my-1">
                        <a class="nav-link py-3 d-flex align-items-center {{ request()->routeIs('superadmin.domains.index') ? 'active' : '' }}"
                            href="{{ route('superadmin.domains.index') }}">
                            <i class="fas fa-globe fa-lg me-3"></i>
                            <span class="fs-6">Liste domains</span>
                        </a>
                    </li>

                    <!-- Section Support -->
                    <li class="sidebar-main-title my-3 mt-4">
                        <div class="d-flex align-items-center px-3">
                            <i class="fas fa-headset fa-lg me-2 "></i>
                            <h6 class="mb-0 text-uppercase fw-bold">Support</h6>
                        </div>
                    </li>

                    <li class="nav-item my-1">
                        <a class="nav-link py-3 d-flex align-items-center {{ request()->routeIs('superadmin.tickets.index') ? 'active' : '' }}"
                            href="{{ route('superadmin.tickets.index') }}">
                            <i class="fas fa-ticket-alt fa-lg me-3"></i>
                            <span class="fs-6">Tickets</span>
                        </a>
                    </li>
                </ul>


            </div>
        </nav>
    </div>
</div>

<style>
    .nav-link {
        transition: all 0.3s ease;
        border-radius: 8px;
        margin: 0 10px;
        color: #495057;
    }

    .nav-link:hover {
        background-color: rgba(0, 123, 255, 0.1);
        transform: translateX(5px);
        color: #0d6efd;
    }

    .nav-link.active {
        background-color: rgba(0, 123, 255, 0.2);
        font-weight: 600;
        color: #0d6efd;
        border-left: 4px solid #0d6efd;
    }

    .sidebar-main-title h6 {
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }

    .logout-btn {
        transition: all 0.3s;
    }

    .logout-btn:hover {
        color: #dc3545 !important;
        transform: scale(1.1);
    }
</style>