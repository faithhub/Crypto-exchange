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
            $table->string('fname')->nullable();
            $table->string('lname')->nullable();
            $table->string('username');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('image')->nullable();
            $table->string('password');
            $table->string('verification_code')->nullable();
            $table->string('sms_code')->nullable();
            $table->tinyInteger('phone_verify')->default(0);
            $table->tinyInteger('email_verify')->default(0);
            $table->date('email_time')->nullable();
            $table->date('phone_time')->nullable();
            $table->integer('refer')->default(0);
            $table->tinyInteger('level')->default(0);
            $table->string('reference')->nullable();
            $table->integer('balance')->default(0);
            $table->integer('bonus')->default(0);
            $table->string('bank')->nullable();
            $table->integer('accountno')->nullable();
            $table->string('accountname')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->integer('verified')->nullable();
            $table->string('dob')->nullable();
            $table->string('gender')->nullable();
            $table->date('login_time')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('country')->nullable();
            $table->string('provider')->nullable();
            $table->text('provider_id')->nullable();
            $table->string('remember_token')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamp('email_verified_at')->nullable();
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
