@extends ('layout')

@section ('header')

    <div class="header header--blue">

        @include('shared.nav-blue')

        <h1 class="title title--white">This Week's Goals</h1>

    </div>

@endsection

@section ('content')

    <h1 class="title">My Runs</h1>

    @if($lastActivitiesLoggedIn->isEmpty())
        <p>You haven't run in the last week.</p>
    @else

        <ul class="activities-list">

        @foreach($lastActivitiesLoggedIn as $activity)

            <li class="activity">

                <div class="activity__header">

                    <div class="activity__user-info">

                        <img src="{{$authUser->avatar}}" alt="" class="activity__avatar">
                        <p class="activity__name">{{$authUser->firstname . ' ' . $authUser->lastname}}</p>

                    </div>

                    <p class="activity__date">{{$activity->endDate->diffForHumans()}}</p>

                </div>

                <div class="activity__body">

                    <p class="activity__name">{{ $activity->name }}</p>

                    <div class="activity__data">

                        <div class="activity__distance-info">

                            <p class="activity__label">distance</p>
                            <p class="activity__value">{{ $activity->distance / 1000 . "km" }}</p>

                        </div>

                        <div class="activity__pace-info">

                            <p class="activity__label">pace</p>
                            <p class="activity__value">{{ $activity->averageSpeed . "km/u"}}</p>

                        </div>

                        <div class="activity__time-info">

                            <p class="activity__label">time</p>
                            <p class="activity__value">{{ $activity->elapsedTime }}</p>

                        </div>

                    </div>

                </div>

            </li>

        @endforeach

        </ul>

    @endif

    <h1 class="title">Weekly Summaries</h1>

@endsection