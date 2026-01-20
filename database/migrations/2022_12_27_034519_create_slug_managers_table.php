<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlugManagersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slug_managers', function (Blueprint $table) {
            $table->id();
            $table->string('prefix',128)->nullable();
            $table->string('model',128)->nullable();
            $table->bigInteger('model_id')->unsigned()->nullable();
            $table->string('name',255)->nullable();
            $table->string('slug',255)->nullable();
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
        Schema::dropIfExists('slug_managers');
    }
}
