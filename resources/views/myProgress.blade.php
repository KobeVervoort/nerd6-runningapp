@extends ('layout')

@section ('header')

    <div class="header header--blue">

        @include('shared.nav-blue')

        <h1 class="title title--white">This Week's Goals</h1>

    </div>

@endsection

@section ('content')

    <h1 class="title">My Runs</h1>

    @if(isset($lastActivitiesLoggedIn))
        <p>You haven't run in the last week.</p>
    @else

        @foreach($lastActivitiesLoggedIn as $activity)

            <div class="activity">

                <div class="activity-info">
                    <div class="user-info">
                        <img src="{{$authUser->avatar}}" alt="" class="user-info__avatar">
                        <p class="user-info__name">{{$authUser->firstname . ' ' . $authUser->lastname}}</p>
                    </div>
                    <p class="activity-info__date">{{$activity->endDate->diffForHumans()}}</p>
                </div>

                <div class="activity-data">
                    <h2 class="activity-data__name">{{ $activity->name }}</h2>
                    <p class="activity-data__metric">Distance: {{ number_format($activity->distance/1000, 2, '.', '' )}} km</p>
                    <p class="activity-data__metric">Speed: {{ number_format($activity->averageSpeed * 3.6, 2, '.', '') }} km/h</p>
                </div>

            </div>

        @endforeach
    @endif

    <h1 class="title">Weekly Summaries</h1>

@endsection