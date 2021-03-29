<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class note extends Model
{
  use HasFactory;

  protected $fillable = ['note'];

  public function user(): User
  {
    return $this->belongsTo(User::class);
  }
}
