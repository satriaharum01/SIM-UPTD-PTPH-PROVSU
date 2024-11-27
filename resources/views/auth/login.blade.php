@extends('auth.app')

@section('content')
    <section class="material-half-bg">
        <div class="cover"></div>
    </section>
    <section class="login-content">
      <div class="logo text-center">
        <h1>{{env('APP_NAME')}}</h1>
      </div>
      <div class="login-box">
        @if(!empty($alertMessage)) 
          <div class="alert alert-danger">
            {{$alertMessage}}
          </div>
        @endif

        <form class="login-form" action="<?= route('custom.login') ?>" method="POST">
		@csrf
          <h3 class="login-head"><i class="bi bi-person me-2"></i>SIGN IN</h3>
          <div class="mb-3">
            <label class="form-label">USERNAME</label>
            <input
              type="text"
              name="email"
              class="form-control"
              required
            />
          </div>
          <div class="mb-3">
            <label class="form-label">PASSWORD</label>
            <input
              type="password"
              name="password"
              class="form-control"
              required
            />
          </div>
          <div class="mb-3">
            <div class="utility">
            </div>
          </div>
          <div class="mb-3 btn-container d-grid">
            <Button class="btn btn-primary btn-block"><i class="bi bi-box-arrow-in-right me-2 fs-5"></i>SIGN
              IN</Button>
          </div>
        </form>
      </div>
    </section>
@endsection