<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAboutTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('about_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('about_id')->unsigned()->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();

            $table->text('why_choose')->nullable();
            $table->text('why_choose_title_1')->nullable();
            $table->text('why_choose_desc_1')->nullable();

            $table->text('why_choose_title_2')->nullable();
            $table->text('why_choose_desc_2')->nullable();

            $table->text('why_choose_title_3')->nullable();
            $table->text('why_choose_desc_3')->nullable();

            $table->text('why_choose_title_4')->nullable();
            $table->text('why_choose_desc_4')->nullable();

            $table->string('locale')->index();
            $table->unique(['about_id','locale']);
            $table->foreign('about_id')->references('id')->on('abouts')->onDelete('cascade');
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
        Schema::dropIfExists('about_translations');
    }
}
