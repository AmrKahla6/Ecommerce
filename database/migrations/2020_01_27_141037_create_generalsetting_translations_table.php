<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeneralsettingTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('generalsetting_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('generalsetting_id')->unsigned()->nullable();

            $table->string('title_of_div_6_of_home_section_2')->nullable();
            $table->string('desc_of_div_6_of_home_section_2')->nullable();
            $table->string('button_of_div_6_of_home_section_2')->nullable();

            $table->string('title_politic_register_company')->nullable();
            $table->text('desc_of_politic_register_company')->nullable();
            $table->string('title_politic_register_user')->nullable();
            $table->text('desc_of_politic_register_user')->nullable();
            $table->longText('terms_condition')->nullable();

            $table->string('desc_in_above_navbar')->nullable();
            $table->string('get_touch')->nullable();
            $table->string('desc_get_touch')->nullable();
            $table->string('copy_right')->nullable();
            $table->string('title_of_shipping')->nullable();
            $table->string('title_of_track_order')->nullable();
            $table->string('title_of_fqa')->nullable();
            $table->string('title_of_returns')->nullable();

            $table->string('locale')->index();
            $table->unique(['generalsetting_id','locale']);
            $table->foreign('generalsetting_id')->references('id')->on('generalsettings')->onDelete('cascade');
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
        Schema::dropIfExists('generalsetting_translations');
    }
}
