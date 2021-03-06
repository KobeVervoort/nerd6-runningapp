@extends ('layout')

@section ('header')

    <div class="header">

        @include('shared.nav')

    </div>

@endsection

@section ('content')

    <div class="content">

        <div class="content-container">

            <h1 class="title">Top Runners</h1> <!--topWeekleFiveRunners-->

            <div class="container">
                @if($lastActivityUsers == null)

                    <div class="empty-state">
                        <img class="empty-state__snail" src="/img/snail.png" alt="">
                        <p class="empty-state__message">Get ahead of your friends, register the first run and reach the top of the charts</p>
                    </div>

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

            </div>

        </div>

        <div class="content-container">

            <h1 class="title">Latest Runs</h1>

            <div class="container">

                @if($lastActivityUsers == null)

                    <div class="empty-state">
                        <img class="empty-state__snail" src="/img/snail.png" alt="">
                        <p class="empty-state__message">There haven't yet been any runs recorded in your group</p>
                    </div>

                @else

                    <ul class="activities-list">

                        <li class="activity">

                            <div class="activity__header">

                                <div class="activity__user-info">

                                    <img class="activity__avatar" src="{{ $lastActivityUsers->user->avatar }}" alt="Profile picture of {{ $lastActivityUsers->user->firstname . " " . $lastActivityUsers->user->lastname }}">
                                    <p class="activity__name">{{ $lastActivityUsers->user->firstname . " " . $lastActivityUsers->user->lastname }}</p>

                                </div>

                                <p class="activity__date">{{$lastActivityUsers->endDate->diffForHumans()}}</p><!-- Time ago-->

                            </div>

                            <div class="activity__body">

                                <p class="activity__name">{{$lastActivityUsers->name}}</p>

                                <div class="activity__data">

                                    <div class="activity__distance-info">

                                        <p class="activity__label">distance</p>
                                        <p class="activity__value">{{ number_format(($lastActivityUsers->distance / 1000), 2) . "km" }}</p>

                                    </div>

                                    <div class="activity__pace-info">

                                        <p class="activity__label">pace</p>
                                        <p class="activity__value">{{ number_format(($lastActivityUsers->averageSpeed * 3.6), 2) . "km/u"}}</p>

                                    </div>

                                    <div class="activity__time-info">

                                        <p class="activity__label">time</p>
                                        <p class="activity__value">{{ gmdate("H:i:s", $lastActivityUsers->elapsedTime) }}</p>

                                    </div>

                                </div>

                            </div>

                        </li>

                    </ul>

                @endif

            </div>

        </div>

    </div>

    <div class="footer">

        <h1 style=" text-align: center; padding-top: 20px; font-size: 24px;">Group total distance</h1>

        <div class="footer__container">

            <p class="footer__metric">{{ round($totalDistanceUsers / 1000, 2) . "km"  }}</p>
            <p class="footer__quote">{{ $quote }}</p>

        </div>

    </div>

@endsection
