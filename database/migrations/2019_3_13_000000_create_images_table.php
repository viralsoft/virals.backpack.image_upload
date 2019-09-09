<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url');
            $table->timestamps();
        });

        Schema::create('model_has_images', function (Blueprint $table) {
            $table->integer('image_id')->unsigned();
            $table->morphs('model');

            $table->foreign('image_id')
                ->references('id')
                ->on('images')
                ->onDelete('cascade');

            $table->primary(['image_id', 'model_id', 'model_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('images');
        Schema::dropIfExists('model_has_images');
    }
}
