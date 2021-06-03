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

        <link rel="dns-prefetch" href="//staticxx.facebook.com">
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
