<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStreamingLinkVisualTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('streaming_link_visual', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('visual_id');
            $table->foreign('visual_id')->references('id')->on('visuals');

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
        Schema::dropIfExists('streaming_link_visual');
    }
}
