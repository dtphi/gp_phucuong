<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml/">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>GP-PhuCuong</title>
        <!-- Facebook Metadata /-->
        <meta property="og:url" content="https://giaophanphucuong.org/"/>
        <meta property="og:type" content="Website" />
        <meta property="og:locale" content="vi_VN" />
        <meta property="og:image" content="https://giaophanphucuong.org/Image/Picture/Logo/giaophanphucuong.org.png" />
        <meta property="og:description" content="Chuyên trang truyền thông Giáo Phận Phú Cường " />
        <meta property="og:title" content="GIÁO PHẬN PHÚ CƯỜNG " />
        <meta property="og:site_name" content="Giáo Phận Phú Cường" />

        <!--
        <link href='https://fonts.gstatic.com' crossorigin rel='preconnect' />
        <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,400italic,500,500italic,700,700italic&subset=latin,vietnamese' rel='stylesheet' type='text/css'>
        -->
        
        <!--[if lt IE 9]>
        <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/json2/20110223/json2.min.js"></script>    
        <script type="text/javascript" src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>   
        <script type="text/javascript" src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>  
        <![endif]-->

        <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=231785784518885&ev=PageView&noscript=1"
        /></noscript>

    </head>
    <body class="antialiased">
        <div id="gp-phu-cuong" class="relative items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
            <component :is="this.$route.meta.layout || 'div'">
              <router-view></router-view>
            </component>
        </div>
        <!-- Scripts -->
        <script src="{{ asset('js/app-front.js') }}" defer></script>
    </body>
</html>
