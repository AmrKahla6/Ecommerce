<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoverpagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coverpages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cover_blog')->nullable(); 
            $table->string('cover_blog_deatails')->nullable(); 
            $table->string('cover_cart')->nullable(); 
            $table->string('cover_checkout')->nullable(); 
            $table->string('cover_contact')->nullable(); 
            $table->string('cover_login')->nullable(); 
            $table->string('cover_shop')->nullable(); 
            $table->string('cover_product_details')->nullable(); 
            $table->string('cover_favourite')->nullable(); 
            $table->string('cover_testimations')->nullable();
            $table->string('cover_footer')->nullable(); 
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
        Schema::dropIfExists('coverpages');
    }
}
