<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class image extends Model
{
  use HasFactory;

  protected $fillable = ['path'];

  public function create()
  {
    // upload img to path first
    $filePath = 'somePath';

    $this->path = $filePath;
    $this->user_id = 'current user';
    $this->save();
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
