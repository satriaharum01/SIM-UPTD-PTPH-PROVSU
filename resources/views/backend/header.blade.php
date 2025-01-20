
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
                    <span class="avatar" style="background-image: url({{asset('/assets/img/faces/'.Auth::user()->faces)}})"></span>
                    <span class="ml-2 d-none d-lg-block">
                      <span class="text-default">{{Auth::user()->name}}</span>
                      <small class="text-muted d-block mt-1">{{ ucfirst (Auth::user()->level)}}</small>
                    </span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                    <a class="dropdown-item" 
                    @if(Auth::user()->level == 'Admin Provinsi')
                      href="{{route('admin.profile')}}"
                    
                  @elseif(Auth::user()->level == 'Kordinator Kabupaten')
                  
                  href="{{route('kordinator.profile')}}"
                  @else

                  href="{{route('petugas.profile')}}"
                  @endif
                  >
                      <i class="dropdown-icon fe fe-user"></i> Profile
                    </a>
                    <!--
                    <a class="dropdown-item" href="#">
                      <i class="dropdown-icon fe fe-settings"></i> Log
                    </a>
-->
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
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
                  @if(Auth::user()->level == 'Admin Provinsi')
                  <li class="nav-item">
                    <a href="{{route('admin.dashboard')}}" class="nav-link {{ (request()->is('admin/dashboard')) ? 'active' : '' }}"><i class="fe fe-home"></i> Home</a>
                  </li>
                  <li class="nav-item dropdown">
                    <a href="{{route('admin.pengguna')}}" class="nav-link {{ (request()->is('admin/pengguna')) ? 'active' : '' }} {{ (request()->is('admin/pengguna/*')) ? 'active' : '' }}"><i class="fe fe-users"></i> Pengguna</a>
                  </li>
                  <li class="nav-item dropdown">
                    <a href="{{route('admin.kabupaten')}}" class="nav-link {{ (request()->is('admin/kabupaten')) ? 'active' : '' }} {{ (request()->is('admin/kabupaten/*')) ? 'active' : '' }}"><i class="fe fe-grid"></i> Kabupaten</a>
                  </li>
                  <li class="nav-item dropdown">
                    <a href="{{route('admin.tanaman')}}" class="nav-link {{ (request()->is('admin/tanaman')) ? 'active' : '' }} {{ (request()->is('admin/tanaman/*')) ? 'active' : '' }}"><i class="fa fa-leaf"></i> Tanaman</a>
                  </li>
                  <li class="nav-item dropdown">
                    <a href="{{route('admin.opt')}}" class="nav-link {{ (request()->is('admin/opt')) ? 'active' : '' }} {{ (request()->is('admin/opt/*')) ? 'active' : '' }}"><i class="fa fa-virus"></i> OPT</a>
                  </li>
                  <li class="nav-item dropdown">
                    <a href="{{route('admin.laporan')}}" class="nav-link {{ (request()->is('admin/laporan')) ? 'active' : '' }} {{ (request()->is('admin/laporan/*')) ? 'active' : '' }}"><i class="fe fe-file-text"></i> Laporan</a>
                  </li>
                  @elseif(Auth::user()->level == 'Kordinator Kabupaten')
                  <li class="nav-item">
                    <a href="{{route('kordinator.dashboard')}}" class="nav-link {{ (request()->is('kordinator/dashboard')) ? 'active' : '' }}"><i class="fe fe-home"></i> Home</a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('kordinator.petugas')}}" class="nav-link {{ (request()->is('kordinator/petugas')) ? 'active' : '' }} {{ (request()->is('kordinator/petugas/*')) ? 'active' : '' }}"><i class="fe fe-users"></i> Petugas</a>
                  </li>
                  <li class="nav-item dropdown">
                    <a href="{{route('kordinator.kecamatan')}}" class="nav-link {{ (request()->is('kordinator/kecamatan')) ? 'active' : '' }} {{ (request()->is('kordinator/kecamatan/*')) ? 'active' : '' }}"><i class="fe fe-grid"></i> Kecamatan</a>
                  </li>
                  <li class="nav-item dropdown">
                    <a href="{{route('kordinator.wilayah_kerja')}}" class="nav-link {{ (request()->is('kordinator/wilayah_kerja')) ? 'active' : '' }} {{ (request()->is('kordinator/wilayah_kerja/*')) ? 'active' : '' }}"><i class="fa fa-route"></i> Wilayah Kerja</a>
                  </li>
                  <li class="nav-item dropdown">
                    <a href="{{route('kordinator.laporan')}}" class="nav-link {{ (request()->is('kordinator/laporan')) ? 'active' : '' }} {{ (request()->is('kordinator/laporan/*')) ? 'active' : '' }}"><i class="fe fe-file-text"></i> Laporan</a>
                  </li>
                  @else
                  <li class="nav-item">
                    <a href="{{route('petugas.dashboard')}}" class="nav-link {{ (request()->is('petugas/dashboard')) ? 'active' : '' }}"><i class="fe fe-home"></i> Home</a>
                  </li>
                  <li class="nav-item dropdown">
                    <a href="{{route('petugas.laporan')}}" class="nav-link {{ (request()->is('petugas/laporan')) ? 'active' : '' }} {{ (request()->is('petugas/laporan/*')) ? 'active' : '' }}"><i class="fe fe-file-text"></i> Laporan</a>
                  </li>
                  @endif
                </ul>
              </div>
            </div>
          </div>
        </div>