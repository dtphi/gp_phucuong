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
  <link href="{{ url('images/icons/favicon-33x33.png') }}" rel="shortcut icon" />
  <link rel="icon" type="image/x-icon" href="<?php echo asset('images/icons/favicon.png'); ?>" />
  <!-- third-generation iPad with high-resolution Retina display: -->
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo asset('images/icons/favicon-144x144.png'); ?>">
  <!-- iPhone with high-resolution Retina display: -->
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo asset('images/icons/favicon-114x114.png'); ?>">
  <!-- first- and second-generation iPad: -->
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo asset('images/icons/favicon-72x72.png'); ?>">
  <!-- non-Retina iPhone, iPod Touch, and Android 2.1+ devices: -->
  <link rel="apple-touch-icon-precomposed" href="<?php echo asset('images/icons/favicon-57x57.png'); ?>">
  
  <?php echo $css->cssSetting['mapCss']; ?>
</head>
<body class="{{ $css->cssSetting['bodyClass'] }}">
  @if($css->cssSetting['isFireBaseAuth'])
    @if($css->cssSetting['isInternalLogin'])
      <script type="module">
        import { _getFbConfig, _deleteSessionItem } from "/js/appfirebasejs/9.1.3/auth/app-firebase-auth.js";
        // Import the functions you need from the SDKs you need
        import { initializeApp } from "/js/appfirebasejs/9.1.3/firebase-app.js";
        import { getAuth, signOut } from "/js/appfirebasejs/9.1.3/firebase-auth.js";
        // TODO: Add SDKs for Firebase products that you want to use
        // https://firebase.google.com/docs/web/setup#available-libraries

        // Initialize Firebase
        const initapp = initializeApp(_getFbConfig());
        const auth = getAuth(initapp);
        auth.onAuthStateChanged(user => {
          if (user) {
            signOut(auth);
          }
          _deleteSessionItem();
        });
      </script>  
    @endif

    @if(!$css->cssSetting['isInternalLogin'])
      @if(request()->is('admin/phone-verify'))
        <div data-path="{{request()->path()}}" id="container-firebase" class="container-fluid">
          @include('administrator-otp')
        </div>
      @endif

      <script type="module">
          // Import app
          import { _getFbConfig, _initAuth, _startAuth } from "/js/appfirebasejs/9.1.3/auth/app-firebase-auth.js";
          // Import the functions you need from the SDKs you need
          import { initializeApp } from "/js/appfirebasejs/9.1.3/firebase-app.js";
          import { getAuth, signInWithPhoneNumber, signOut, RecaptchaVerifier } from "/js/appfirebasejs/9.1.3/firebase-auth.js";
          // TODO: Add SDKs for Firebase products that you want to use
          // https://firebase.google.com/docs/web/setup#available-libraries

          // Initialize Firebase
          const initapp = initializeApp(_getFbConfig());
          _initAuth(getAuth(initapp), RecaptchaVerifier);
          _startAuth(signInWithPhoneNumber);
      </script>
    @endif
  @endif

  <div data-path="{{request()->path()}}" id="gp-phu-cuong">
    <component :is="this.$route.meta.layout || 'div'">
      <router-view></router-view>
    </component>
  </div>
  <!-- Scripts -->

  <?php echo $css->cssSetting['mapScript']; ?>
  <script src="{{ $css->cssSetting['pageDir'] }}" defer></script>

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