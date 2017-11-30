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

            <ul class="user-list">
                @foreach($topWeeklyFiveRunners as $key => $runner)

                    <li class="user-list__item">
                        <div class="user-list__user-info {{$key === 0 ? "user-list__user-info--first" : ""}}">
                            <p class="user-list__rank"><!-- Number of rank--> {{ $key+1 }}</p>
                            <img src="{{ $runner->user->avatar }}" class="user-list__avatar"/>
                            <p class="user-list__name">{{ $runner->user->firstname . " " . $runner->user->lastname }}</p>
                        </div>
                        <p class="user-list__distance {{$key === 0 ? "user-list__distance--first" : ""}}">{{ round($runner->weeklyDistance / 1000, 2) }} km</p>
                    </li>

                @endforeach
            </ul>

        @endif

        <h1 class="title">Latest Runs</h1>

        @if(1 != 1)

            <p>No one in your group has run yet.</p>

        @else

            <ul class="activities-list">

                <div class="activities-list__header">

                    <div class="activities-list__user-info">

                        <img class="activities-list__avatar" src="{{ $lastActivityUsers->user->avatar }}" alt="Profile picture of {{ $lastActivityUsers->user->firstname . " " . $lastActivityUsers->user->lastname }}">
                        <p class="activities-list__name">{{ $lastActivityUsers->user->firstname . " " . $lastActivityUsers->user->lastname }}</p>

                    </div>

                    <p class="activities-list__date">{{$lastActivityUsers->endDate->diffForHumans()}}</p><!-- Time ago-->

                </div>

                <div class="activities-list__body">

                    <div class="activities-list__distance-info">

                        <p class="activities-list__label">distance</p>
                        <p class="activities-list__value">{{ $lastActivityUsers->distance / 1000 . "km" }}</p>

                    </div>

                    <div class="activities-list__pace-info">

                        <p class="activities-list__label">pace</p>
                        <p class="activities-list__value">{{ $lastActivityUsers->averageSpeed . "km/u"}}</p>

                    </div>

                    <div class="activities-list__time-info">

                        <p class="activities-list__label">time</p>
                        <p class="activities-list__value">{{ $lastActivityUsers->elapsedTime }}</p>

                    </div>

                </div>

            </ul>


        @endif

        <div class="footer">

            <p>{{ round($totalDistanceUsers / 1000, 2) . "km"  }}</p>
            <p>Insert inspiring quote</p>

        </div>

    </div>

@endsection
