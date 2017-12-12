<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAchievementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('achievements', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('image');
            $table->timestamps();
        });

        DB::table('achievements')->insert(
            array(
                array( // 1
                    'name' => '1 run',
                    'image' => '/public/img/medal-run-blue.png',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ),
                array( // 2
                    'name' => '5 runs',
                    'image' => '/public/img/medal-run-blue.png',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ),
                array( // 3
                    'name' => '10 runs',
                    'image' => '/public/img/medal-run-blue.png',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ),
                array( // 4
                    'name' => '20 runs',
                    'image' => '/public/img/medal-run-blue.png',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ),
                array( // 5
                    'name' => '50 runs',
                    'image' => '/public/img/medal-run-blue.png',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ),
                array( // 6
                    'name' => '100 runs',
                    'image' => '/public/img/medal-run-blue.png',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ),
                array( // 7
                    'name' => '200 runs',
                    'image' => '/public/img/medal-run-blue.png',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ),
                array( // 8
                    'name' => '1km run',
                    'image' => '/public/img/medal-run-blue.png',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ),
                array( // 9
                    'name' => '4km run',
                    'image' => '/public/img/medal-run-blue.png',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ),
                array( // 10
                    'name' => '8km run',
                    'image' => '/public/img/medal-run-blue.png',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ),
                array( // 11
                    'name' => '16km run',
                    'image' => '/public/img/medal-run-blue.png',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ),
                array( // 12
                    'name' => '20km run',
                    'image' => '/public/img/medal-run-blue.png',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ),
                array( // 13
                    'name' => '40km run',
                    'image' => '/public/img/medal-run-blue.png',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ),
                array( // 14
                    'name' => '100km run',
                    'image' => '/public/img/medal-run-blue.png',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ),
                array( // 15
                    'name' => '15min',
                    'image' => '/public/img/medal-run-blue.png',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ),
                array( // 16
                    'name' => '30min run',
                    'image' => '/public/img/medal-run-blue.png',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ),
                array( // 17
                    'name' => '1hour run',
                    'image' => '/public/img/medal-run-blue.png',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ),
                array( // 18
                    'name' => '2hours run',
                    'image' => '/public/img/medal-run-blue.png',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ),
                array( // 19
                    'name' => '4hours run',
                    'image' => '/public/img/medal-run-blue.png',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ),
                array( // 20
                    'name' => '5km/hour',
                    'image' => '/public/img/medal-run-blue.png',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ),
                array( // 21
                    'name' => '10km/hour',
                    'image' => '/public/img/medal-run-blue.png',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ),
                array( // 22
                    'name' => '15km/hour',
                    'image' => '/public/img/medal-run-blue.png',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ),
                array( // 23
                    'name' => '20km/hour',
                    'image' => '/public/img/medal-run-blue.png',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ),
                array( // 24
                    'name' => 'Running for 1week',
                    'image' => '/public/img/medal-run-blue.png',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ),
                array( // 25
                    'name' => 'Running for 1month',
                    'image' => '/public/img/medal-run-blue.png',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ),
                array( // 26
                    'name' => 'Running for 3months',
                    'image' => '/public/img/medal-run-blue.png',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ),
                array( // 27
                    'name' => 'Running for 6months',
                    'image' => '/public/img/medal-run-blue.png',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ),
                array( // 28
                    'name' => 'Running for a year',
                    'image' => '/public/img/medal-run-blue.png',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ),
                array( // 29
                    'name' => 'Top 5 best runners of your group',
                    'image' => '/public/img/medal-run-blue.png',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ),
                array( // 30
                    'name' => 'Best runner of your group',
                    'image' => '/public/img/medal-run-blue.png',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                )
            ) // close outer array
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('achievements');
    }
}
