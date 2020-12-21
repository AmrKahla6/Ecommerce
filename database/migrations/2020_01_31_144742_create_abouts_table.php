<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAboutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abouts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cover')->nullable();
            $table->string('image')->nullable();
            $table->string('video')->nullable();

            $table->string('why_choose_image_1')->nullable();
            $table->string('why_choose_image_2')->nullable();
            $table->string('why_choose_image_3')->nullable();
            $table->string('why_choose_image_4')->nullable();
       
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('abouts');
    }
}
