# Laravel

```bash
# install
composer global require laravel/installer

laravel new example-app

php artisan serve
php artisan cache:clear

php artisan help make:[model|controller|migration]

# adding controller
php artisan make:controller <name>

php artisan route:list
```

## database

```bash
# need to create db first
php artisan migrate
php artisan migrate:rollback
php artisan migrate:fresh
php artisan migrate:fresh --seed

php artisan make:migration <migration name>

# seed
php artisan make:seeder <seeder class name> # generates seed template
php artisan db:seed # executes seed
php artisan db:seed --class=<seeder class name>

composer dump-autoload

# model (eloquent)
php artisan make:model <model name>
```

### model

```php
class Word extends model
{
    // referencing to parent invoked by $parent = model.sentence
    public function sentence()
    {
        return $this->belongsTo(Sentence::class, 'sentence_id');
    }

    // many to many
    public function quote()
    {
        return $this->belongsToMany(Quote::class, 'word_id')->withTimestamps();
    }
}

class Sentence extends model
{
    public function word()
    {
        return $this->hasMany(Word::class, 'word_id');
    }

    // many to many
    public function quote()
    {
        return $this->belongsToMany(Quote::class, 'sentence_id')->withTimestamps();
    }
}
```

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->string('title');
            $table->string('src');
            $table->string('mime_type');
            $table->text('description')->nullable();

            $table->unsignedBigInteger('event_id');
            $table->foreign('event_id')->references('id')->on('events');

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
        Schema::dropIfExists('photos');
    }
}
```

### query

```php
// db query
$user = \DB::table('users')->where('email', 'test@test.com')->first();

// eloquent query
using App\Models\User;
$user = User::where('email', 'test@test.com')->first();
```

## routing

```php
<?php


use App\Http\Controllers\AppController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () { return view('index'); });
Route::get('/register', function () { return view('register'); });

Route::get('/note/{slug}', [AppController::class, 'show'])->name('note.show');
Route::post('/note', [AppController::class, 'create'])->name('note.create');

// accessing named routes
redirect(route('note.show', $modelRef->slug))
```

## .blade.php

``` php
// ignores escape
{!! <script>alert('unescaped')</script> !!}

// template
@yeld('key', 'default value') // content

// some other file
@extends('path.to.template')
@section('key')
  some content
@endsection()
```
