<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
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
