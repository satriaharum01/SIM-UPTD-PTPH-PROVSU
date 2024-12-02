
        <div class="header py-4">
          <div class="container">
            <div class="d-flex">
              <a class="align-items-center header-brand row" href="./index.html">
                <img src="{{asset('assets/img/logo.png')}}" class="header-brand-img" alt="tabler logo">
                <div class="ml-2 row flex-column ">
                  <h5 style="line-height: 10px;">DINAS KETAHANAN PANGAN TANAMAN PANGAN & HORTIKULTURA</h5>
                  <h6 style="line-height: 0px;">PROVINSI SUMATERA UTARA</h6>
                </div>
              </a>
              <div class="d-flex order-lg-2 ml-auto">
                <div class="dropdown">
                  <a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">
                    <span class="avatar" style="background-image: url(./demo/faces/female/25.jpg)"></span>
                    <span class="ml-2 d-none d-lg-block">
                      <span class="text-default">{{Auth::user()->name}}</span>
                      <small class="text-muted d-block mt-1">{{ ucfirst (Auth::user()->level)}}</small>
                    </span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                    <a class="dropdown-item" href="#">
                      <i class="dropdown-icon fe fe-user"></i> Profile
                    </a>
                    <a class="dropdown-item" href="#">
                      <i class="dropdown-icon fe fe-settings"></i> Settings
                    </a>
                    <a class="dropdown-item" href="#">
                      <span class="float-right"><span class="badge badge-primary">6</span></span>
                      <i class="dropdown-icon fe fe-mail"></i> Inbox
                    </a>
                    <a class="dropdown-item" href="#">
                      <i class="dropdown-icon fe fe-send"></i> Message
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">
                      <i class="dropdown-icon fe fe-help-circle"></i> Need help?
                    </a>
                    <a class="dropdown-item" href="#">
                      <i class="dropdown-icon fe fe-log-out"></i> Sign out
                    </a>
                  </div>
                </div>
              </div>
              <a href="#" class="header-toggler d-lg-none ml-3 ml-lg-0" data-toggle="collapse" data-target="#headerMenuCollapse">
                <span class="header-toggler-icon"></span>
              </a>
            </div>
          </div>
        </div>
        <div class="bg-azure-darkest header collapse d-lg-flex p-0" id="headerMenuCollapse">
          <div class="container">
            <div class="row align-items-center">
              <div class="col-lg order-lg-first">
                <ul class="nav nav-tabs border-0 flex-column flex-lg-row">
                  <li class="nav-item">
                    <a href="{{route('admin.dashboard')}}" class="nav-link {{ (request()->is('admin/dashboard')) ? 'active' : '' }}"><i class="fe fe-home"></i> Home</a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link"><i class="fe fe-users"></i> User</a>
                  </li>
                  <li class="nav-item dropdown">
                    <a href="{{route('admin.kabupaten')}}" class="nav-link {{ (request()->is('admin/kabupaten')) ? 'active' : '' }} {{ (request()->is('admin/kabupaten/*')) ? 'active' : '' }}"><i class="fe fe-grid"></i> Kabupaten</a>
                  </li>
                  <li class="nav-item dropdown">
                    <a href="{{route('admin.laporan')}}" class="nav-link {{ (request()->is('admin/laporan')) ? 'active' : '' }} {{ (request()->is('admin/laporan/*')) ? 'active' : '' }}"><i class="fe fe-file-text"></i> Laporan</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>