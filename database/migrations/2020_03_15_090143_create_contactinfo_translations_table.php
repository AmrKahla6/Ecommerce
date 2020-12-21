<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactinfoTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contactinfo_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contactinfo_id')->unsigned()->nullable();
            $table->string('location')->nullable();

            $table->string('locale')->index();
            $table->unique(['contactinfo_id','locale']);
            $table->foreign('contactinfo_id')->references('id')->on('contactinfos')->onDelete('cascade');
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
        Schema::dropIfExists('contactinfo_translations');
    }
}
