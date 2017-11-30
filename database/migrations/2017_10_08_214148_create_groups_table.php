<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name');
            $table->text('description');
            $table->integer('target_distance');
            $table->dateTime('end_date');
        });

        DB::table('groups')->insert(
            array(
                array( // 1
                    'name' => 'IMD goes 10 miles',
                    'description' => 'The students of IMD train to achieve their ultimate goal. Wanna join?',
                    'target_distance' => '16000',
                    'end_date' => \Carbon\Carbon::createFromFormat('d/m/Y', '14/04/2018'),
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ),
                array( // 2
                    'name' => 'The Nerd Running Club',
                    'description' => 'Join us nerds and run with us to get that 10 miles medal!',
                    'target_distance' => '20000',
                    'end_date' => \Carbon\Carbon::createFromFormat('d/m/Y', '14/04/2018'),
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now()
                ),
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
        Schema::dropIfExists('groups');
    }
}
