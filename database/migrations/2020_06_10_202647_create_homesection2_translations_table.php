<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHomesection2TranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('homesection2_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('homesection2_id')->unsigned()->nullable();

            $table->string('title')->nullable();
            $table->string('description')->nullable();
            
            $table->string('locale')->index();
            $table->unique(['homesection2_id','locale']);
            $table->foreign('homesection2_id')->references('id')->on('homesection2s')->onDelete('cascade');
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
        Schema::dropIfExists('homesection2_translations');
    }
}
