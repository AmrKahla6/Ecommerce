<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHomesection1TranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('homesection1_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('homesection1_id')->unsigned()->nullable();

            $table->string('title')->nullable();
            $table->string('button')->nullable();
            $table->string('description')->nullable();
            
            $table->string('locale')->index();
            $table->unique(['homesection1_id','locale']);
            $table->foreign('homesection1_id')->references('id')->on('homesection1s')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('homesection1_translations');
    }
}
