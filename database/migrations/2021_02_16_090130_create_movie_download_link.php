<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovieDownloadLink extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movie_download_link', function (Blueprint $table) {
            $table->id();
          
            $table->unsignedBigInteger('visual_id');
            $table->foreign('visual_id')->references('id')->on('visuals');
            
            $table->unsignedBigInteger('download_link_id');
            $table->foreign('download_link_id')->references('id')->on('download_links');
       
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movie_download_link');
    }
}
