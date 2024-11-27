<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>{{env('APP_NAME')}} | {{$title}}</title>
    <!--====== Favicon Icon ======-->
    <link rel="shortcut icon" href="{{asset('static/assets/img/logo.png')}}" type="image/gif" />

    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <!-- Fonts and icons -->
    <script src="{{asset('static/assets/js/plugin/webfont/webfont.min.js')}}"></script>
    <script>
        WebFont.load({
            google: { "families": ["Lato:300,400,700,900"] },
            custom: { "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['{{asset("static/assets/css/fonts.min.css")}}'] },
            active: function () {
                sessionStorage.fonts = true;
            }
        });
    </script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <!-- CSS Files -->
    
    <link rel="stylesheet" type="text/css" href="{{asset('static/css/main.css')}}">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
 
  <!-- end plugin css -->

  @include('template.css')
</head>
<body class="app sidebar-mini">
    <!-- Header -->
    @include('template.header')
    <!-- Header -->

    <!-- Sidebar -->
    @include('template.sidebar')
    <!-- Sidebar -->
    
    <!-- Content -->
    <main class="app-content">
      @yield('content')

      @include('template.footer')
    </main>
    <!-- Content -->
    @yield('modal')
    <!-- Password Modal-->
    <div class="modal fade" id="gantiPassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header flex-row">
                    <h5 class="modal-title card-body p-0 text-center" id="exampleModalLabel">Ganti Password</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form id="compose-form" action="{{ route('set.password') }}" method="POST">
                <div class="modal-body">
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-4">Password Baru</label>
                        <div class="col-sm-8">
                          <input type="password" name="password" class="form-control" required>
                          <input type="text" name="current_url" class="form-control" hidden value="{{url()->full()}}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary text-white">Simpan</button>
                </div>
                
                </form>
            </div>
        </div>
    </div>
    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header flex-row">
                    <h5 class="modal-title card-body p-0 text-center" id="exampleModalLabel">Akan Logout?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Pilih "Logout" Untuk Mengakhiri Sesi.</div>
                <div class="modal-footer">
                    <button class="btn btn-danger" type="button" data-dismiss="modal">Cancel</button>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                    </form>
                    <a class="btn btn-primary text-white" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
                </div>
            </div>
        </div>
    </div>
  @include('template.js')
  @yield('custom_script')
</body>
</html>