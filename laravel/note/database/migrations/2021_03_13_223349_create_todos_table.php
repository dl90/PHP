<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTodosTable extends Migration
{

  public function up()
  {
    Schema::create('todos', function (Blueprint $table) {
      $table->id();
      $table->timestamps();
      $table->string('todo');

      $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
    });
  }

  public function down()
  {
    Schema::dropIfExists('todos');
  }
}
