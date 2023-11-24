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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();

            $table->string('banner_image', 255)->required();
            $table->string('banner_title', 255)->nullable();
            $table->text('banner_description')->nullable();
            $table->text('banner_link')->nullable();
            $table->enum('banner_position', ['start', 'center', 'end'])->nullable();

            $table->owners();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
