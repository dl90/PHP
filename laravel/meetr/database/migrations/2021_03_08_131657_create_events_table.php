<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {

            $table->string('title');
            $table->text('description')->nullable();
            $table->string('category')->nullable();
            $table->dateTime('datetime_starts');
            $table->dateTime('datetime_ends');
            $table->string('payer');
            $table->boolean('romantic_intentions');
            $table->string('location');

            $table->decimal('expected_guest_cost');
            $table->decimal('expected_total_cost');

            $table->unsignedBigInteger('host_id');
            $table->unsignedBigInteger('guest_id')->nullable();
            $table->foreign('host_id')->references('id')->on('users');
            $table->foreign('guest_id')->references('id')->on('users');

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
        Schema::dropIfExists('events');
    }
}
