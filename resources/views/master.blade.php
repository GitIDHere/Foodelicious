<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{env('APP_NAME')}}</title>
        @include('includes.styles')
    </head>
    <body class="preload">

        @include("theme._header")

        @yield('content')

        @include("theme._footer")

        <!-- JS -->
        @include('includes.scripts')

    </body>
</html>
