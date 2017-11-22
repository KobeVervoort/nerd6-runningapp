@extends ('layout')

@section ('header')

    <div class="header header--blue">

        @include('shared.nav-blue')

    </div>

@endsection

@section ('content')

    @foreach($activities as $activity)

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

@endsection