@extends ('layout')

@section ('header')

    <div class="header">

        @include('shared.nav')

    </div>

@endsection

@section ('content')



    <div class="container">

    <h1 class="title">Top Runners</h1> <!--topWeekleFiveRunners-->

        @if(1 != 1)

            <p>No one in your group has run yet.</p>

        @else

            @foreach($topWeeklyFiveRunners as $key => $runner)

                <div style="display: flex; flex-wrap: wrap; flex-direction: row;">
                    <p><!-- Number of rank--> {{ $key+1 }}</p>
                    <img src="{{ $runner->user->avatar }}" style="height: 50px; width: 50px;"/>
                    <p>{{ $runner->user->firstname . " " . $runner->user->lastname }}</p>
                    <p>{{ round($runner->weeklyDistance / 1000, 2) }} km</p>
                </div>

            @endforeach

        @endif

    <h1 class="title">Latest Runs</h1>

        @if($lastActivityUsers->isEmpty())

            <p>No one in your group has run yet.</p>

        @else

            <div style="display: flex; flex-wrap: wrap; flex-direction: row;">

                <img src="{{ $lastActivityUsers->user->avatar }}" style="height: 50px; width: 50px;" alt="Profile picture of {{ $lastActivityUsers->user->firstname . " " . $lastActivityUsers->user->lastname }}">
                <p>{{ $lastActivityUsers->user->firstname . " " . $lastActivityUsers->user->lastname }}</p>
                <p>{{$lastActivityUsers->endDate->diffForHumans()}}</p><!-- Time ago-->

            </div>
            <p>{{ $lastActivityUsers->name }}</p>
            <div style="display: flex; flex-wrap: wrap; flex-direction: row; justify-content: space-between">

                <div><!-- distance -->
                    <p>Distance</p>
                    <p>{{ $lastActivityUsers->distance / 1000 . "km" }}</p>
                </div>
                <div><!-- pace -->
                    <p>Pace</p>
                    <p>{{ $lastActivityUsers->averageSpeed . "km/u"}}</p>
                </div>
                <div><!-- time -->
                    <p>Time</p>
                    <p>{{ $lastActivityUsers->elapsedTime }}</p><!-- in seconden! -->
                </div>

            </div>


        @endif

        <div style="display: flex; flex-wrap: wrap; flex-direction: row; justify-content: space-between;text-align: center;">

            <p style="flex-basis: 40%;">{{ round($totalDistanceUsers / 1000, 2) . "km"  }}</p>
            <p style="flex-basis: 40%;">Insert inspiring quote</p>

        </div>

    </div>

@endsection