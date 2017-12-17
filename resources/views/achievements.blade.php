@extends ('layout')

@section ('header')

    <div class="header header--blue">

        @include('shared.nav-blue')

        <div class="header-container">

            <div class="my-achievements">

                <div class="my-achievements__block">
                    <h2 class="my-achievements__title">Longest distance</h2>
                    <p class="my-achievements__metric">{{ $longestRunLoggedIn  }}km</p>
                </div>

                <div class="my-achievements__block">
                    <h2 class="my-achievements__title">Average speed</h2>
                    <p class="my-achievements__metric">{{ round($averageSpeedLoggedIn, 2) }} km/h</p>
                </div>

                <div class="my-achievements__block">
                    <h2 class="my-achievements__title">Total achievements</h2>
                    <p class="my-achievements__metric my-achievements__metric--medal-counter">{{ $totalAchievementsLoggedIn }} x <img class="my-achievements__medal" style="height: 1.5em; width: auto;" src="img/medal-run-white.png" alt="Medal icon"></p>
                </div>

            </div>

        </div>

    </div>

@endsection

@section ('content')

    <?php

        $congratulateAchievements = App\AchievementUser::orderBy('created_at', 'desc')->where('user_id', '=' , auth()->user()->id)->where('congratulated', '=', 0)->get();
        //echo count($congratulateAchievements);
    ?>

    @if(count($congratulateAchievements) != 0)

        @foreach($congratulateAchievements as $congratulate)

            <div class="congratulations">

                <p class="congratulations__congratulations">You've got a new achievement for: <span class="congratulations__congratulations congratulations__congratulations--emphasis">my first run</span></p>
                <p class="congratulations__time">{{ $congratulate->updated_at->diffForHumans() }}</p>

            </div>

        @endforeach
        


    @endif

    <h1 class="title">My Achievements</h1>

    @if($achievementsLoggedIn->isEmpty())
        <img style="width:60%; height: auto;display:block; margin:0 auto;margin-bottom:20px;" src="https://memegenerator.net/img/images/600x600/11745649/run-forrest-run.jpg" alt="Run forrest run">
    @endif

    <?php
    // Update congratulated=0 to congratulated=1
    foreach ($congratulateAchievements as $congratulate)
    {
        $record = App\AchievementUser::find($congratulate->id);
        $record->congratulated = 1;
        $record->save();
    }
    ?>

    <ul class="achievements-list">

    @foreach($achievementsLoggedIn as $achievement)

        <li class="achievement">

            <img src="/../img/medal-run-blue.png" alt="medal for achievement {{$achievement->achievement_id}}" class="achievement__medal">
            <p class="achievement__name">my first run</p>
            <p class="achievement__time">{{ $achievement->updated_at->diffForHumans() }}</p>

        </li>

    @endforeach

    </ul>

@endsection