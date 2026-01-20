<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('theme_page_attributes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('theme_page_id');
            $table->string('key',255)->nullable();
            $table->longText('value')->nullable();
            $table->timestamps();

            $table->foreign('theme_page_id')->references('id')->on('theme_pages');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('theme_page_attributes');
    }
};
