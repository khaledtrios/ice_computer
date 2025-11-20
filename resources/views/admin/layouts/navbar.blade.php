<div class="page-header">
  <div class="header-wrapper m-0">
    <div class="nav-right col-xxl-7 col-xl-6 col-md-7 col-8 pull-right right-header p-0 ms-auto">
      <ul class="nav-menus">
        <!-- Notifications -->
        <li class="onhover-dropdown">
          <div class="notification-box">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor"
              stroke-width="2" viewBox="0 0 24 24">
              <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
              <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
            </svg>
            <span class="badge rounded-pill badge-danger">{{ $notifications->count() }}</span>
          </div>
          <div class="onhover-show-div notification-dropdown">
            <h6 class="f-18 mb-3">Notifications</h6>

             @if($notifications->isEmpty())
           <p class="text-center text-muted">Aucune notification</p>
            @else
              <ul class="notification-list">
                @foreach($notifications as $notification)
              <li class="notification-item">
              <div class="d-flex align-items-center">
              <div class="notification-icon bg-light-primary">
              <!-- Icône cloche exemple -->
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14z" />
              </svg>
              </div>
              <div class="notification-content">
              <p class="mb-0">{{ $notification->message }}</p>
              <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
              </div>
              </div>
              </li>
            @endforeach
              </ul>
      @endif

          </div>
        </li>

        <!-- Compte utilisateur -->
        <li class="profile-nav onhover-dropdown pe-0 py-0">
          <div class="d-flex profile-media align-items-center">
            <div class="flex-grow-1 ms-2">
              <span>Administrateur</span>
              <p class="mb-0 text-muted">SuperAdmin <i class="fa-solid fa-angle-down ms-1"></i></p>
            </div>
          </div>
          <ul class="profile-dropdown onhover-show-div">
            <li class="divider"></li>
            <li>
              <a href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                  stroke="currentColor" stroke-width="2">
                  <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                  <polyline points="16 17 21 12 16 7"></polyline>
                  <line x1="21" y1="12" x2="9" y2="12"></line>
                </svg>
                <span>Déconnexion</span>
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
              </form>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</div>

<style>
  /* Notifications */
  .notification-box {
    position: relative;
    cursor: pointer;
    padding: 10px 15px;
  }

  .notification-dropdown {
    width: 320px;
    padding: 15px;
    right: 0;
    left: auto !important;
  }

  .notification-list {
    list-style: none;
    padding: 0;
    margin: 0;
  }

  .notification-item {
    padding: 10px 0;
    border-bottom: 1px solid #f1f1f1;
  }

  .notification-item:last-child {
    border-bottom: none;
  }

  .notification-icon {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 12px;
  }

  .notification-content p {
    margin-bottom: 2px;
    font-size: 14px;
  }

  .notification-content small {
    font-size: 12px;
  }

  .view-all {
    display: block;
    text-align: center;
    margin-top: 10px;
    font-size: 13px;
    color: #7366ff;
  }
</style>