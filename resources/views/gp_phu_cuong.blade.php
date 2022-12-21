<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://ogp.me/ns/fb#">

<head prefix=" og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
    <!-- Google Tag Manager -->
    <!--<script type="text/javascript" async="" src="https://www.google-analytics.com/analytics.js"></script>
        <script type="text/javascript" async="" src="//www.googleadservices.com/pagead/conversion_async.js"></script>
        <script type="text/javascript" async="" src="https://www.google-analytics.com/analytics.js"></script>
        <script async="" src="https://www.googletagmanager.com/gtm.js?id=GTM-PZ6DTNG"></script>
        <script async="" src="https://www.googletagmanager.com/gtm.js?id=GTM-5CBQSN2"></script> 
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-5CBQSN2');</script>

		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-PZ6DTNG');</script>-->
    <!-- End Google Tag Manager -->

    <title>GP Phú Cường | {{$data->settings['meta_title']}}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="robots" content="index, follow">
    <meta name="VisitorTimeout" content="0">
    <meta name="VisitorPath" content="">

    <meta property="og:url" content="{{$data->settings['og_url']}}" />
    <meta property="og:type" content="website" />
    <meta property="og:locale" content="vi_VN" />
    <meta property="og:image" content="{{ $data->settings['og_image'] }}" />
    <meta property="og:image:width" content="{{$data->settings['og_width']}}" />
    <meta property="og:image:height" content="{{$data->settings['og_height']}}" />
    <meta property="og:description" content="{{ $data->settings['meta_description'] }}" />
    <meta property="og:title" content="{{$data->settings['meta_title']}}" />
    <meta property="og:site_name" content="Giáo Phận Phú Cường" />

    <meta name="author" content="GIÁO PHẬN PHÚ CƯỜNG">
    <meta name="title" content="{{$data->settings['meta_title']}}">
    <meta name="description" content="{{ $data->settings['meta_description'] }}">
    <meta name="keywords" content="{{ $data->settings['meta_keyword'] }}">

    <!-- basic favicon -->
    <link rel="shortcut icon" href="<?php echo asset('images/icons/favicon-33x33.png'); ?>">
    <link rel="icon" type="image/x-icon" href="<?php echo asset('images/icons/favicon.png'); ?>" />
    <link rel="icon" type="image/vnd.microsoft.icon" href="<?php echo asset('images/icons/favicon.png'); ?>" />
    <link rel="icon" sizes="16x16" href="<?php echo asset('images/icons/favicon-16x16.png'); ?>">
    <link rel="icon" sizes="49x49" href="<?php echo asset('images/icons/favicon-49x49.png'); ?>">
    <link rel="icon" sizes="64x64" href="<?php echo asset('images/icons/favicon-64x64.png'); ?>">

    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo asset('images/icons/favicon-60x60.png'); ?>">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo asset('images/icons/favicon-76x76.png'); ?>">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo asset('images/icons/favicon-120x120.png'); ?>">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo asset('images/icons/favicon-152x152.png'); ?>">

    <!-- third-generation iPad with high-resolution Retina display: -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo asset('images/icons/favicon-144x144.png'); ?>">
    <!-- iPhone with high-resolution Retina display: -->
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo asset('images/icons/favicon-114x114.png'); ?>">
    <!-- first- and second-generation iPad: -->
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo asset('images/icons/favicon-72x72.png'); ?>">
    <!-- non-Retina iPhone, iPod Touch, and Android 2.1+ devices: -->
    <link rel="apple-touch-icon-precomposed" href="<?php echo asset('images/icons/favicon-57x57.png'); ?>">
    <style type='text/css'>
        main h1,
        main h2,
        main h3,
        main h4,
        main h5,
        main h6{
            font-size: 1.5rem !important;
        }
    </style>
    <!-- Facebook Metadata /-->
    <meta property="fb:app_id" content="581209272088537" />
    <!--[if lt IE 9]>
        <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/json2/20110223/json2.min.js"></script>    
        <script type="text/javascript" src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>   
        <script type="text/javascript" src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>  
        <![endif]-->

    <!-- /*if ('serviceWorker' in navigator) {
                navigator.serviceWorker.register('/serviceworker.js', {
                    scope: '.'
                }).then(function (registration) {
                    console.log('Laravel PWA: ServiceWorker registration successful with scope: ', registration.scope);
                }, function (err) {
                    console.log('Laravel PWA: ServiceWorker registration failed: ', err);
                });
            }*/ -->
    <script type="text/javascript">
        // Initialize the service worker
        window.page = '<?php echo json_encode($data->settings['page']); ?>';
    </script>
</head>

<body class="antialiased">
    <!-- Google Tag Manager (noscript) -->
    <noscript>
        <img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=231785784518885&ev=PageView&noscript=1" />
        <!--<iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5CBQSN2" height="0" width="0" style="display:none;visibility:hidden"></iframe>
			<iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PZ6DTNG" height="0" width="0" style="display:none;visibility:hidden"></iframe>-->
    </noscript>
    <!-- End Google Tag Manager (noscript) -->
    <div id="gp-phu-cuong" class="relative items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
        <component :is="this.$route.meta.layout || 'div'">
            <router-view></router-view>
        </component>
    </div>
    <!-- Scripts -->
    <script src="{{ $data->settings['pageDir'] }}" async></script>
</body>

</html>