<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
  use HasFactory, Notifiable;

  protected $fillable = ['email', 'password'];
  protected $hidden = ['password', 'remember_token'];
  protected $casts = ['email_verified_at' => 'datetime'];

  // accessed as a property ($user.notes)
  public function notes()
  {
    return $this->hasOne(Note::class);
  }

  public function images()
  {
    return $this->hasMany(Image::class);
  }

  public function sites()
  {
    return $this->hasMany(Site::class);
  }

  public function todos()
  {
    return $this->hasMany(Todo::class);
  }
}
