<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->text('photo')->nullable();
            $table->string('fullname');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->enum('gender', ['Male', 'Famale']);
            $table->text('address')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->integer('status')->default(1);
            $table->rememberToken();
            $table->owners();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
