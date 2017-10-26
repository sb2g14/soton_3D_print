<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">

        <title>Soton3dprint</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link href="/css/owl.carousel.min.css" rel="stylesheet">
        <link href="/css/owl.theme.green.css" rel="stylesheet">
        <link href="/css/hamburgers.css" rel="stylesheet">
        <link href="/css/bootstrap.min.css" rel="stylesheet">
        <link href="/css/font-awesome.min.css" rel="stylesheet">
        <link href="/css/app.css" rel="stylesheet">
        <link href="/css/parsley.css" rel="stylesheet">
        {!! Html::style('/css/sweetalert.css') !!}

    </head>

    <body>

       @include('layouts.header')

        <div class="slider">
            @yield('slider')
        </div>
        
        <div class="content">
            @yield('content')
        </div>
     
        @include('layouts.footer')

        <script src="/js/jquery-1.11.3.min.js"></script>
        <script src="/js/owl.carousel.min.js"></script>
        <script src="/js/bootstrap.min.js"></script>
        <script src="/js/app.js"></script>
        <script src="/js/parsley.min.js"></script>
        <script src="/js/sweetalert.min.js"></script>
         @yield('scripts')
         
    </body>
</html>