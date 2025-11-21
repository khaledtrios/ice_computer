<div class="page-header">
  <div class="header-wrapper row m-0">
    <form class="form-inline search-full col" action="#" method="get">
      <div class="form-group w-100">
        <div class="Typeahead Typeahead--twitterUsers">
          <div class="u-posRelative">
            <input class="demo-input Typeahead-input form-control-plaintext w-100" type="text"
              placeholder="Rechercher..." name="q" title="" autofocus />
            <div class="spinner-border Typeahead-spinner" role="status">
              <span class="sr-only">Chargement...</span>
            </div>
            <i class="close-search" data-feather="x"></i>
          </div>
          <div class="Typeahead-menu"></div>
        </div>
      </div>
    </form>
    <div class="header-logo-wrapper col-auto p-0">
      <div class="logo-wrapper">
        <a href="index.html">
          <img class="img-fluid for-light" src="{{asset('assets/images/logo/logo.png')}}" alt="Logo Ice-Computer" title="Logo de le platforme Ice-Computer" />
          <img class="img-fluid for-dark" src="{{asset('assets/images/logo-dark.png')}}"  alt="Logo-dark Ice-Computer" title="Logo-dark de le platforme Ice-Computer" />
        </a>
      </div>
      <div class="toggle-sidebar">
        <i class="status_toggle middle sidebar-toggle" data-feather="align-center"></i>
      </div>
    </div>
    <div class="nav-right col-xxl-7 col-xl-6 col-md-7 col-8 pull-right right-header p-0 ms-auto">

      <ul class="nav-menus">
        <li>
          <span class="header-search">
            <svg>
              <use href="{{asset('assets/svg/icon-sprite.svg#search')}}"></use>
            </svg>
          </span>
        </li>


        <li>
          <a href="{{ route('apercu', $boutique->slug) }}" target="_blank" class="btn btn-info rounded-pill px-3 py-2"
            title="Aperçu">
            Aperçu
          </a>
        </li>
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
        <li class="profile-nav onhover-dropdown p-0 py-0">
          <div class="d-flex profile-media">
            <img class="b-r-10" src="{{ asset('assets/images/dashboard/profile.png') }}" alt="Profile" />
            <div class="flex-grow-1">
              <span>{{Auth::user()->fullName()}}</span>
              <p class="mb-0">
                Boutique <i class="middle fa-solid fa-angle-down"></i>
              </p>
            </div>
          </div>

          <ul class="profile-dropdown onhover-show-div">
            <li>
              <a href="{{ route('boutique.edit') }}">
                <i data-feather="user"></i><span>Compte</span>
              </a>
            </li>
            <li>
              <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i data-feather="log-out"></i><span>Déconnexion</span>
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
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