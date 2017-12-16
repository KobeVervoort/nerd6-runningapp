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
                    <p class="my-achievements__metric my-achievements__metric--medal-counter">{{ $totalAchievementsLoggedIn }} x <img class="my-achievements__medal" style="height: 1.5em; width: auto;" src="img/medal-run-blue.png" alt="Medal icon"></p>
                </div>

            </div>

        </div>

    </div>

@endsection

@section ('content')

    <?php

        $congratulateAchievements = App\AchievementUser::orderBy('created_at', 'desc')->where('user_id', '=' , auth()->user()->id)->where('congratulated', '=', 0)->get();

        // Update congratulated=0 to congratulated=1
        foreach ($congratulateAchievements as $congratulate){
            $record = AchievementUser::find($congratulate->id);
            $record->congratulated = 1;
            $record->save();
        }

    ?>

    <h1 class="title">My Achievements</h1>

    @if($achievementsLoggedIn->isEmpty())
        <img style="width:60%; height: auto;display:block; margin:0 auto;margin-bottom:20px;" src="https://memegenerator.net/img/images/600x600/11745649/run-forrest-run.jpg" alt="Run forrest run">
    @else

        @if(count($congratulateAchievements) != 0)

            <div class="congratulate-achievement-container" style="border: 2px solid green; background-color: lightgreen; border-radius: 5px; padding: 20px;">

                <h2 style="font-size: 20px; font-weight: bold; color: white; margin-bottom: 20px;">You earned new achievements</h2>

            @foreach($congratulateAchievements as $congratulate)

                <div class="single-achievement" style="display: flex; justify-content: space-around;">

                    <div><img src="/public/img/medal-run-blue.png" alt="blue medal"></div>
                    <div>
                        <p style="font-weight: bold;">1 run</p>
                    </div>
                    <div>{{ $congratulate->updated_at->diffForHumans() }}</div><!-- time ago -->

                </div>

            @endforeach

            </div> <!-- end congratulate-achievement-container -->

        @endif


        @foreach($achievementsLoggedIn as $achievement)

            <div class="single-achievement">

                <div><img src="/public/img/medal-run-blue.png" alt="blue medal"></div>
                <div>
                    <p style="font-weight: bold;">1 run</p>
                </div>
                <div>{{ $achievement->updated_at->diffForHumans() }}</div><!-- time ago -->

            </div>

        @endforeach
    @endif

    <h1 class="title">Weekly Summaries</h1>

    @if($weeklyAchievements->isEmpty())
        <img style="width:60%; height: auto;display:block; margin:0 auto; margin-bottom:20px;" src="https://memegenerator.net/img/images/600x600/11745649/run-forrest-run.jpg" alt="Run forrest run">
    @else

        @foreach($weeklyAchievements as $achievement)

            <div class="single-achievement">

                <div><img src="/public/img/medal-run-blue.png" alt="blue medal"></div>
                <div>
                    <p style="font-weight: bold;">1 run</p>
                </div>
                <div>{{ $achievement->updated_at->diffForHumans() }}</div><!-- time ago -->

            </div>

        @endforeach
    @endif

@endsection