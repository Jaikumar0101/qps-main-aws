<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetaDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meta_data', function (Blueprint $table) {
            $table->id();
            $table->string('model',128)->nullable();
            $table->bigInteger('model_id')->unsigned()->nullable();
            $table->string('title',110)->nullable();
            $table->string('description',160)->nullable();
            $table->string('os_image',255)->nullable();
            $table->text('keywords')->nullable();
            $table->string('author',128)->nullable();
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
        Schema::dropIfExists('meta_data');
    }
}
