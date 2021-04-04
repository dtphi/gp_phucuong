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
  
  <?php echo $css->cssSetting['mapCss']; ?>
</head>
<body class="{{ $css->cssSetting['bodyClass'] }}">
  <div id="gp-phu-cuong">
    <component :is="this.$route.meta.layout || 'div'">
      <router-view></router-view>
    </component>
  </div>
  <!-- Scripts -->

  <?php echo $css->cssSetting['mapScript']; ?>
  <script src="{{ asset('js/app-admin.js') }}" defer></script>
</body>
</html>