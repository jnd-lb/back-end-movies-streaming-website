<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEpisodeDownloadLinkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('episode_download_link', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('episode_id');
            $table->foreign('episode_id')->references('id')->on('episodes');

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
        Schema::dropIfExists('episode_download_link');
    }
}
