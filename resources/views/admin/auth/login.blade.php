<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="noindex, nofollow">
  <title>Admin login · FMB Group</title>
  <link rel="icon" type="image/png" href="{{ asset('assets/images/fmb-favicon.png') }}">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap">
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/admin/admin.css') }}?v=1">
</head>
<body class="adm">
  <div class="adm-login">
    <div class="adm-login-card">
      <img src="{{ asset('assets/images/fmb-logo.png') }}" alt="FMB Group">
      <h1 class="h5 text-center mb-4">Admin panel</h1>
      @include('admin.partials.flash')
      <form method="post" action="{{ route('admin.login.submit') }}">
        @csrf
        <div class="form-group">
          <label for="email">Email</label>
          <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control" required autofocus autocomplete="username">
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input id="password" type="password" name="password" class="form-control" required autocomplete="current-password">
        </div>
        <div class="form-group custom-control custom-checkbox">
          <input type="checkbox" class="custom-control-input" id="remember" name="remember" value="1">
          <label class="custom-control-label" for="remember">Keep me logged in</label>
        </div>
        <button type="submit" class="btn btn-accent btn-block btn-lg">Log in</button>
      </form>
      <p class="text-center mt-4 mb-0"><a href="{{ url('/') }}" class="text-muted small"><i class="fa fa-arrow-left"></i> Back to website</a></p>
    </div>
  </div>
  <script src="{{ asset('assets/admin/admin.js') }}?v=1"></script>
</body>
</html>
