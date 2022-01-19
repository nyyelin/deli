<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{asset('assets/images/logo.jpg')}}" rel="shortcut icon"/>
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/main.css')}}">
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom.css')}}">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Login - {{ config('app.name', 'Better Ways') }}</title>
  </head>
  <body>
    <section class="material-half-bg">
      <div class="cover"></div>
    </section>
    <section class="login-content">
      <div class="logo">
        <h1>{{ config('app.name', 'Better Ways') }}</h1>
      </div>
      <div class="login-box">
        <form class="login-form" method="POST" action="{{ route('login') }}">
            @csrf
          <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>SIGN IN</h3>
          <div class="form-group">
            <label class="control-label">Email</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email Address">
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="form-group">
            <label class="control-label">Password</label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="form-group">
            <div class="utility">
              <div class="animated-checkbox">
                <label>
                  <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}><span class="label-text">Remember Me</span>
                </label>
              </div>
            </div>
          </div>
          <div class="form-group btn-container">
            <button class="btn btn-primary btn-block" type="submit"><i class="fa fa-sign-in fa-lg fa-fw"></i>SIGN IN</button>
          </div>
        </form>
      </div>

      {{-- <div class="row mt-5">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Admin Account</h4>
                </div>
                <div class="card-body">
                    <p class="card-text">admin@gmail.com</p>
                    <p class="card-text">123456789</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Staff Account</h4>
                </div>
                <div class="card-body">
                    <p class="card-text">staff@gmail.com</p>
                    <p class="card-text">12345678</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">DeliMan Account</h4>
                </div>
                <div class="card-body">
                    <p class="card-text">deliveryman1@gmail.com, deliveryman2@gmail.com</p>
                    <p class="card-text">12345678</p>
                </div>
            </div>
        </div>

          <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Client Account</h4>
                </div>
                <div class="card-body">
                    <p class="card-text">client1@gmail.com, client2@gmail.com</p>
                    <p class="card-text">12345678</p>
                </div>
            </div>
          </div>
      </div> --}}
    </section>
  
    <!-- Essential javascripts for application to work-->
    <script src="{{ asset('assets/js/jquery-3.3.1.min.js')}}"></script>
    <script src="{{ asset('assets/js/popper.min.js')}}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('assets/js/main.js')}}"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="{{ asset('assets/js/plugins/pace.min.js')}}"></script>
    <script type="text/javascript">
      // Login Page Flipbox control
      $('.login-content [data-toggle="flip"]').click(function() {
        $('.login-box').toggleClass('flipped');
        return false;
      });
    </script>
  </body>
</html>