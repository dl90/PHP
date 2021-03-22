<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email_address')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->unsignedInteger('number_of_ghosts');
            $table->string('phone_number');
            $table->timestamp('phone_verified_at')->nullable();
            $table->string('username');
            $table->string('password');
            $table->string('sexuality');
            $table->string('looking_for')->nullable();
            $table->text('likes')->nullable();
            $table->text('about_me')->nullable();
            $table->date('birthdate')->nullable();

            $table->id();
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
