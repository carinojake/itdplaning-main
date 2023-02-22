      <header class="header header-sticky mb-4">
        <div class="container-fluid">
          <button class="header-toggler px-md-0 me-md-3 d-md-none" type="button" onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">
            <svg class="icon icon-lg">
              <use xlink:href="{{ asset("vendors/@coreui/icons/sprites/free.svg#cil-menu") }}"></use>
            </svg>
          </button><a class="header-brand d-md-none" href="#">
            <svg width="118" height="46" alt="CoreUI Logo">
              <use xlink:href="{{ asset("assets/brand/coreui.svg#full")}}"></use>
            </svg></a>
          {{-- <form class="d-flex" role="search">
            <div class="input-group"><span class="input-group-text bg-light border-0 px-1" id="search-addon">
                <svg class="icon icon-lg my-1 mx-2 text-disabled">
                  <use xlink:href="{{ asset("vendors/@coreui/icons/sprites/free.svg#cil-search") }}"></use>
                </svg></span>
              <input class="form-control bg-light border-0" type="text" placeholder="Search..." aria-label="Search" aria-describedby="search-addon">
            </div>
          </form> --}}
          <?php
            use App\MenuBuilder\FreelyPositionedMenus;
            if(isset($appMenus['top menu'])){
                FreelyPositionedMenus::render( $appMenus['top menu'] , '', 'd-md-down-none');
            }
          ?>   
          <ul class="header-nav ms-auto">
            <li class="header-nav-item">
              <form id="select-locale-form" action="/locale" method="GET">
                <select name="locale" id="select-locale" class="form-select form-select-sm">
                    @foreach($locales as $locale)
                        @if($locale->short_name == $appLocale)
                            <option value="{{ $locale->short_name }}" selected>{{ $locale->name }}</option>
                        @else
                            <option value="{{ $locale->short_name }}">{{ $locale->name }}</option>
                        @endif
                    @endforeach
                </select>
              </form>
            </li>
            <li class="nav-item d-md-down-none">
              <a class="nav-link disabled"> {{ Auth::user()->firstname.' '.Auth::user()->lastname }}</a>
            </li>
          </ul>
          <ul class="header-nav">
            <li class="nav-item dropdown d-flex align-items-center"><a class="nav-link py-0" data-coreui-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <div class="avatar avatar-md"><img class="avatar-img" src="{{ asset("assets/img/avatars/3.jpg")}}" alt="{{ Auth::user()->email}}"><span class="avatar-status bg-success"></span></div></a>
              <div class="dropdown-menu dropdown-menu-end pt-0">
                {{-- <div class="dropdown-header bg-light py-2 dark:bg-white dark:bg-opacity-10">
                  <div class="fw-semibold">Account</div>
                </div><a class="dropdown-item" href="#">
                  <svg class="icon me-2">
                    <use xlink:href="{{ asset("vendors/@coreui/icons/sprites/free.svg#cil-bell") }}"></use>
                  </svg> Updates<span class="badge badge-sm bg-info-gradient ms-2">42</span></a><a class="dropdown-item" href="#">
                  <svg class="icon me-2">
                    <use xlink:href="{{ asset("vendors/@coreui/icons/sprites/free.svg#cil-envelope-open") }}"></use>
                  </svg> Messages<span class="badge badge-sm badge-sm bg-success ms-2">42</span></a><a class="dropdown-item" href="#">
                  <svg class="icon me-2">
                    <use xlink:href="{{ asset("vendors/@coreui/icons/sprites/free.svg#cil-task") }}"></use>
                  </svg> Tasks<span class="badge badge-sm bg-danger-gradient ms-2">42</span></a><a class="dropdown-item" href="#">
                  <svg class="icon me-2">
                    <use xlink:href="{{ asset("vendors/@coreui/icons/sprites/free.svg#cil-comment-square") }}"></use>
                  </svg> Comments<span class="badge badge-sm bg-warning-gradient ms-2">42</span></a> --}}
                <div class="dropdown-header bg-light py-2 dark:bg-white dark:bg-opacity-10">
                  <div class="fw-semibold">Settings</div>
                </div><a class="dropdown-item" href="#">
                  <svg class="icon me-2">
                    <use xlink:href="{{ asset("vendors/@coreui/icons/sprites/free.svg#cil-user") }}"></use>
                  </svg> Profile</a><a class="dropdown-item" href="#">
                  <svg class="icon me-2">
                    <use xlink:href="{{ asset("vendors/@coreui/icons/sprites/free.svg#cil-settings") }}"></use>
                  </svg> Settings</a>
                  {{-- <a class="dropdown-item" href="#">
                  <svg class="icon me-2">
                    <use xlink:href="{{ asset("vendors/@coreui/icons/sprites/free.svg#cil-credit-card") }}"></use>
                  </svg> Payments<span class="badge badge-sm bg-secondary-gradient text-dark ms-2">42</span></a><a class="dropdown-item" href="#">
                  <svg class="icon me-2">
                    <use xlink:href="{{ asset("vendors/@coreui/icons/sprites/free.svg#cil-file") }}"></use>
                  </svg> Projects<span class="badge badge-sm bg-primary-gradient ms-2">42</span></a> --}}
                <div class="dropdown-divider"></div>

                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                    <svg class="icon me-2">
                      <use xlink:href="{{ asset("vendors/@coreui/icons/sprites/free.svg#cil-account-logout") }}"></use>
                    </svg> {{ __('ออกจากระบบ') }}
                  </a>
                </form>
              </div>
            </li>
          </ul>
          <button class="header-toggler px-md-0 me-md-3 d-none" type="button" onclick="coreui.Sidebar.getInstance(document.querySelector('#aside')).show()">
            <svg class="icon icon-lg">
              <use xlink:href="{{ asset("vendors/@coreui/icons/sprites/free.svg#cil-applications-settings") }}"></use>
            </svg>
          </button>
        </div>
      </header>