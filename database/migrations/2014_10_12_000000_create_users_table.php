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
            $table->string('id', 8)->primary();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('dating_code');
            $table->date('birthday');
            $table->enum('gender', ['male', 'female']);
            $table->string('phone_number');
            $table->string('image_path');
            $table->string('password');
            $table->enum('status', ['offline', 'online', 'banned']);
            $table->enum('role', ['user', 'admin'])->default('user');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
