<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('meta')

    <title>@yield('title', 'Film Festival')</title>

    <link rel="stylesheet" href="{{ elixir('css/app.css') }}" />
    @yield('css')

    <script src="/js/angular.min.js" type="text/javascript"></script>
    @yield('headerScripts')
</head>
<body>

    @yield('content')

    @yield('footerScripts')

</body>
</html>