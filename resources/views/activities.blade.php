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

    <div class="container" style="display:flex;flex-direction:row;justify-content: space-around;">

        @foreach($activities as $activity)

            <div class="element"> <!-- verander class names (en nesting van elementen) zodat opmaak er verzorgd uitziet -->

                <h2>{{ $activity->name }}</h2>
                <p>Distance run: {{ $activity->distance }}</p>
                <p>Average speed: {{ $activity->averageSpeed }}</p>
            </div>

        @endforeach

    </div>


</div>

</body>
</html>