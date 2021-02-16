<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEpisodeStreamingLinkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('episode_streaming_link', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('episode_id');
            $table->foreign('episode_id')->references('id')->on('episodes');

            $table->unsignedBigInteger('streaming_link_id');
            $table->foreign('streaming_link_id')->references('id')->on('streaming_links');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('episode_streaming_link');
    }
}
