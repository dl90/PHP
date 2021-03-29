<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotesTable extends Migration
{
  public function up()
  {
    Schema::create('notes', function (Blueprint $table) {
      $table->id();
      $table->timestamps();
      $table->longText('note');

      $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
    });
  }

  public function down()
  {
    Schema::dropIfExists('notes');
  }


}
