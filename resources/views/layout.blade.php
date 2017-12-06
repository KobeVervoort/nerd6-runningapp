<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/reset.css" type="text/css">
    <link rel="stylesheet" href="css/app.css" type="text/css">
    <title>Nerd Running</title>
    <script src="https://use.fontawesome.com/7e5e4f22bf.js"></script>
</head>
<body>

    @yield('header')

    <div class="main">

        @yield('content')

    </div>


</body>
</html>