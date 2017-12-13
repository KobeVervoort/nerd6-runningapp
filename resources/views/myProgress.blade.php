@extends ('layout')

@section ('header')

    <div class="header header--blue">

        @include('shared.nav-blue')

        <div class="header-container">

            @if($thisWeek)

            <h1 class="title title--white">Week {{$thisWeek->week}} Goals</h1>

            <div class="schedule">

                <h2 class="schedule__dates">{{$thisWeek->start_date->format('l d/m') . ' - ' . $thisWeek->end_date->format('l d/m')}}</h2>

                <p class="schedule__metric">
                    <i class="schedule__icon {{$thisWeek->distance_reached >= $thisWeek->distance_goal ? 'schedule__icon--success fa fa-check-square-o' : 'fa fa-square-o'}}"></i>
                    Run {{$thisWeek->distance_goal / 1000}}km in a single run
                </p>

                <p class="schedule__metric">
                    <i class="schedule__icon {{$thisWeek->frequency_reached >= $thisWeek->frequency_goal ? 'schedule__icon--success fa fa-check-square-o' : 'fa fa-square-o'}} schedule__icon"></i>
                    Go for {{$thisWeek->frequency_goal}} runs this week
                </p>

            </div>

            @endif

        </div>

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

    @if( count($weeklyGoals) == 0 )
        <p>Looks like you just began. Keep up the good work!</p>
    @else

        <div class="weeklyGoalscontainer">

            @foreach( $weeklyGoals as $goal )
                <div class="weeklyGoal">

                    <h3>Week {{ $goal->week }}</h3>

                    <div class="weeklyGoalElement">
                        <p>Distance goal</p>
                        <p>{{ $goal->distance_reached }} / {{ $goal->distance_goal }}</p>
                    </div>

                    <div class="weeklyGoalElement">
                        <p>Frequency goal</p>
                        <p>{{ $goal->frequency_reached }} / {{ $goal->frequency_goal }}</p>
                    </div>

                </div>
            @endforeach

        </div>

    @endif

@endsection