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

  <link rel="stylesheet" href="{{ asset('/administrator/javascript/font-awesome/css/font-awesome.css') }}">
  <link rel="stylesheet" href="{{ asset('administrator/plugins/mm/style.css') }}"></link>
  <script src="{{ asset('administrator/plugins/mm/mm.min.js') }}"></script>
  <div id="media-file-manager-content" style="display:none" class="modal-open">
  <div class="mce-container mce-panel mce-floatpanel mce-window mce-in" role="dialog" style="border-width: 1px; z-index: 655369999;min-height: 500; top: 15px; width:-webkit-fill-available">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" aria-hidden="true" onclick="document.getElementById('media-file-manager-content').style='display:none'">&times;</button>
          <h4 class="modal-title">Chọn hình ảnh</h4>
        </div>
        <div class="modal-body">
            <div id="modal-general-info-manager"></div>
        </div>
      </div>
    </div>
    </div>
  </div>
</body>
</html>