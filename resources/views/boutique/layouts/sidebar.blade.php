<div class="sidebar-wrapper" data-sidebar-layout="stroke-svg">
    <div>
        <div class="logo-wrapper text-center py-4">
            <a href="{{ route('boutique.configuration') }}">
                <img class="img-fluid for-light" src="{{asset('assets/images/logo-dark.png')}}" alt="Logo" style="max-height: 50px;" />
                <img class="img-fluid for-dark" src="{{asset('assets/images/logo-dark.png')}}" alt="Logo" style="max-height: 50px;" />
            </a>
        </div>

        <nav class="sidebar-main">
            <div id="sidebar-menu">
                <ul class="sidebar-links list-unstyled" id="simple-bar">
                    <!-- Section Général -->
                    <li class="sidebar-main-title my-3">
                        <div class="d-flex align-items-center px-3">
                            <i class="fas fa-cog fa-lg me-2 "></i>
                            <h6 class="mb-0 text-uppercase fw-bold">Général</h6>
                        </div>
                    </li>

                    <li class="nav-item my-1">
                        <a class="nav-link py-3 d-flex align-items-center {{ request()->routeIs('boutique.configuration') ? 'active' : '' }}" 
                           href="{{ route('boutique.configuration') }}">
                            <i class="fas fa-store-alt fa-lg me-3"></i>
                            <span class="fs-6">Configuration Boutique</span>
                        </a>
                    </li>
                    
                    @if($config_type !== null)
                    <li class="nav-item my-1">
                        <a class="nav-link py-3 d-flex align-items-center {{ request()->routeIs('boutique.demandes.index') ? 'active' : '' }}" 
                           href="{{ route('boutique.demandes.index') }}">
                            <i class="fas fa-handshake fa-lg me-3"></i>
                            <span class="fs-6">Mes demandes</span>
                        </a>
                    </li>
                    @endif

                    <li class="nav-item my-1">
                        <a class="nav-link py-3 d-flex align-items-center {{ request()->routeIs('boutique.calendrier') ? 'active' : '' }}" 
                           href="{{ route('boutique.calendrier') }}">
                            <i class="fas fa-calendar-alt fa-lg me-3"></i>
                            <span class="fs-6">Calendrier</span>
                        </a>
                    </li>
                    
                    <li class="nav-item my-1">
                        <a class="nav-link py-3 d-flex align-items-center {{ request()->routeIs('boutique.clients') ? 'active' : '' }}" 
                           href="{{ route('boutique.clients') }}">
                            <i class="fas fa-users fa-lg me-3"></i>
                            <span class="fs-6">Clients</span>
                        </a>
                    </li>
                    
                    <li class="nav-item my-1">
                        <a class="nav-link py-3 d-flex align-items-center {{ request()->routeIs('boutique.produit-additionnels.index') ? 'active' : '' }}" 
                           href="{{ route('boutique.produit-additionnels.index') }}">
                            <i class="fab fa-product-hunt fa-lg me-3"></i>
                            <span class="fs-6">Produits additionnels</span>
                        </a>
                    </li>

                    <li class="sidebar-main-title my-3 mt-4">
                        <div class="d-flex align-items-center px-3">
                            <i class="fas fa-comments fa-lg me-2 "></i>
                            <h6 class="mb-0 text-uppercase fw-bold">Communication</h6>
                        </div>
                    </li>

                    <li class="nav-item my-1">
                        <a class="nav-link py-3 d-flex align-items-center {{ request()->routeIs('boutique.tikets') ? 'active' : '' }}" 
                           href="{{ route('boutique.tikets') }}">
                            <i class="fas fa-ticket-alt fa-lg me-3"></i>
                            <span class="fs-6">Tickets</span>
                        </a>
                    </li>

                    <li class="nav-item my-1">
                        <a class="nav-link py-3 d-flex align-items-center {{ request()->routeIs('boutique.integration') ? 'active' : '' }}" 
                           href="{{ route('boutique.integration') }}">
                            <i class="fas fa-plug fa-lg me-3"></i>
                            <span class="fs-6">Intégration</span>
                        </a>
                    </li>

                    <li class="sidebar-main-title my-3 mt-4">
                        <div class="d-flex align-items-center px-3">
                            <i class="fas fa-user-shield fa-lg me-2 "></i>
                            <h6 class="mb-0 text-uppercase fw-bold">Administration</h6>
                        </div>
                    </li>

                    <li class="nav-item my-1">
                        <a class="nav-link py-3 d-flex align-items-center {{ request()->routeIs('boutique.edit') ? 'active' : '' }}" 
                           href="{{ route('boutique.edit') }}">
                            <i class="fas fa-sliders-h fa-lg me-3"></i>
                            <span class="fs-6">Paramètres</span>
                        </a>
                    </li>
                </ul>

                <div class="sidebar-profile bg-light rounded-3 p-3 mt-auto mx-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <img class="img-50 rounded-circle me-3" src="" alt="Profile">
                            <div class="profile-details">
                                <h6 class="mb-0 fw-bold">John Doe</h6>
                                <span class="text-muted small">Administrateur</span>
                            </div>
                        </div>
                        <a href="logout.html" class="logout-btn text-muted">
                            <i class="fas fa-sign-out-alt fa-lg"></i>
                        </a>
                    </div>
                </div>
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

    .img-50 {
        width: 50px;
        height: 50px;
        object-fit: cover;
    }
</style>