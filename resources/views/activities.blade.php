<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/reset.css" type="text/css">
    <link rel="stylesheet" href="css/app.css" type="text/css">
    <title>NERD</title>
</head>
<body>

<header class="header">

    @include('shared.nav')

</header>

<div class="main">

    <div class="container">

        @foreach($activities as $activity)

            <p>Hallo</p>

        @endforeach

    </div>


</div>

</body>
</html>