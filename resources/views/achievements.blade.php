@extends ('layout')

@section ('header')

    <div class="header header--blue">

        @include('shared.nav-blue')

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
                <p>{{ $totalAchievementsLoggedIn }}</p>
            </div>

        </div>

    </div>

@endsection

@section ('content')

    <h1 class="title">My Achievements</h1>

    @if($achievementsLoggedIn->isEmpty())
        <p>You haven't received an achievement yet. Go the extra mile!</p>
    @else

        @foreach($achievementsLoggedIn as $achievement)

            <div>

                <div></div>
                <div>
                    <p style="font-weight: bold;">{{ $achievement->name }}</p><!-- Titel achievement -->
                    <p>{{ $achievement->description }}</p><!-- Description achievement -->
                </div>
                <div>{{ $achievement->updated_at->diffForHumans() }}</div><!-- time ago -->

            </div>

        @endforeach
    @endif

    <h1 class="title">Weekly Summaries</h1>

@endsection