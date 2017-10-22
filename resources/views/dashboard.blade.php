@extends ('layout')

@section ('content')

    <div class="container">

        @if(empty($activities))

            <p>No other activities found.</p>

        @else

            @foreach($activities as $activity)

                <div class="activity">

                    <div class="activity-info">
                        <div class="user-info">
                            <img src="{{$activity->user->avatar}}" alt="" class="user-info__avatar">
                            <p class="user-info__name">{{$activity->user->firstname . ' ' . $activity->user->lastname}}</p>
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

    </div>

@endsection