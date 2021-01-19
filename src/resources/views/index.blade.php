<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Giáo Phận Phú Cường</title>

  <!-- Fav Icon -->
  <link href="{{ url('favicon/favicon.ico') }}" rel="shortcut icon" />

  <!-- Font Awesome -->
  <link rel="stylesheet" href="/administrator/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="/administrator/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/administrator/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <!-- Custom style -->
  <link rel="stylesheet" href="/administrator/dist/css/custom.css">
</head>
<body class="hold-transition login-page">
<div id="gp-phu-cuong">
  <component :is="this.$route.meta.layout || 'div'">
    <router-view></router-view>
  </component>
</div>
<!-- Scripts -->
<!-- jQuery -->
<script src="/administrator/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="/administrator/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="/administrator/dist/js/adminlte.min.js"></script>

<script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>