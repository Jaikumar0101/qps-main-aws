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
        Schema::create('advertisements', function (Blueprint $table) {
            $table->id();
            $table->string('key',255)->nullable();
            $table->string('name',255)->nullable();
            $table->text('url')->nullable();
            $table->boolean('open_new_tab')->default(0);
            $table->integer('position')->default(0);
            $table->boolean('status')->default(0);
            $table->string('location')->nullable();
            $table->date('expire_at')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advertisements');
    }
};
