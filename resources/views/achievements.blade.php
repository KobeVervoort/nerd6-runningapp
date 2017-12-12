@extends ('layout')

@section ('header')

    <div class="header header--blue">

        @include('shared.nav-blue')

        <div class="header-container">

            <div>

                <div>
                    <p>Longest distance</p>
                    <p>{{ $longestRunLoggedIn  }}</p>
                </div>
                <div>
                    <p>Average speed</p>
                    <p>{{ $averageSpeedLoggedIn }}</p>
                </div>
                <div>
                    <p>Total achievements</p>
                    <p>{{ $totalAchievementsLoggedIn }} x <img style="height: 1.5em; width: auto;" src="img/medal-run-blue.png" alt="Medal icon"></p>
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

            <div>

                <div></div>
                <div>
                    <p style="font-weight: bold;">{{ $achievement->name }}</p>
                </div>
                <div>{{ $achievement->updated_at->diffForHumans() }}</div><!-- time ago -->

            </div>

        @endforeach
    @endif

    <h1 class="title">Weekly Summaries</h1>

@endsection