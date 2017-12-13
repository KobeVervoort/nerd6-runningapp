@extends ('layout')

@section ('header')

    <div class="header header--blue">

        @include('shared.nav-blue')

        <div class="header-container">

            <div class="my-achievements">

                <div class="my-achievements__block">
                    <h2 class="my-achievements__title">Longest distance</h2>
                    <p class="my-achievements__metric">{{ $longestRunLoggedIn  }}km</p>
                </div>

                <div class="my-achievements__block">
                    <h2 class="my-achievements__title">Average speed</h2>
                    <p class="my-achievements__metric">{{ round($averageSpeedLoggedIn, 2) }} km/h</p>
                </div>

                <div class="my-achievements__block">
                    <h2 class="my-achievements__title">Total achievements</h2>
                    <p class="my-achievements__metric my-achievements__metric--medal-counter">{{ $totalAchievementsLoggedIn }} x <img class="my-achievements__medal" style="height: 1.5em; width: auto;" src="img/medal-run-blue.png" alt="Medal icon"></p>
                </div>

            </div>

        </div>

    </div>

@endsection

@section ('content')

    <h1 class="title">My Achievements</h1>

    @if($achievementsLoggedIn->isEmpty())
        <img style="width:60%; height: auto;display:block; margin:0 auto;" src="https://memegenerator.net/img/images/600x600/11745649/run-forrest-run.jpg" alt="Run forrest run">
    @else

        @foreach($achievementsLoggedIn as $achievement)

            <div class="single-achievement">

                <div><img src="/public/img/medal-run-blue.png" alt="blue medal"></div>
                <div>
                    <p style="font-weight: bold;">1 run</p>
                </div>
                <div>{{ $achievement->updated_at->diffForHumans() }}</div><!-- time ago -->

            </div>

        @endforeach
    @endif

    <h1 class="title">Weekly Summaries</h1>

    @if($weeklyAchievements->isEmpty())
        <img style="width:60%; height: auto;display:block; margin:0 auto;" src="https://memegenerator.net/img/images/600x600/11745649/run-forrest-run.jpg" alt="Run forrest run">
    @else

        @foreach($weeklyAchievements as $achievement)

            <div class="single-achievement">

                <div><img src="/public/img/medal-run-blue.png" alt="blue medal"></div>
                <div>
                    <p style="font-weight: bold;">1 run</p>
                </div>
                <div>{{ $achievement->updated_at->diffForHumans() }}</div><!-- time ago -->

            </div>

        @endforeach
    @endif

@endsection