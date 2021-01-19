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
  
  <?php $css->mapCss() ?>
</head>
<body class="hold-transition login-page">
<div id="gp-phu-cuong">
  <component :is="this.$route.meta.layout || 'div'">
    <router-view></router-view>
  </component>
</div>
<!-- Scripts -->
<?php $css->mapScript() ?>
<script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>