<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--
    <meta property="og:title" content="{{$item->item_name}}" />
    <meta property="og:image" content="https://ia.media-imdb.com/images/rock.jpg" />
    <meta name="description" content="You received an E-gift">
-->
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    
    
    <!-- {{config('app')['api_base_url']}}storage/photos/item/400px/{{$photo['400px']}} -->
</head>
<body>
    <div id="app">
        <main class="container">
            @yield('content')
        </main>
    </div>
</body>
</html>
