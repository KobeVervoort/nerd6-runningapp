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
                    'name' => 'Achievement 1',
                    'image' => '/public/img/medal-run-blue.png',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ),
                array( // 2
                    'name' => 'Achievement 2',
                    'image' => '/public/img/medal-run-blue.png',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ),
                array( // 3
                    'name' => 'Achievement 3',
                    'image' => '/public/img/medal-run-blue.png',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ),
                array( // 4
                    'name' => 'Achievement 4',
                    'image' => '/public/img/medal-run-blue.png',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ),
                array( // 5
                    'name' => 'Achievement 5',
                    'image' => '/public/img/medal-run-blue.png',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ),
                array( // 6
                    'name' => 'Achievement 6',
                    'image' => '/public/img/medal-run-blue.png',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ),
                array( // 7
                    'name' => 'Achievement 7',
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
