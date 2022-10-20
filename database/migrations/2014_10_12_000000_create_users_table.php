<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('codemeli')->nullable();
            $table->string('mobile',50)->unique();
            $table->string('email')->unique()->nullable();
            $table->string('avatar');
            $table->string('api_token')->unique();
            $table->enum('sex', ['man', 'woman']);
            $table->enum('role',['admin', 'user', 'bazres', 'unknown']);
            $table->enum('verification',['no','yes']);
            $table->string('token_2fa')->nullable();
            $table->dateTime('token_2fa_expiry')->nullable();
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
}
