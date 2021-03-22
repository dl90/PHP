<?php

use App\Http\Controllers\StaticPageController;
use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EmailController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', fn() => view('welcome'));

Route::get('/', [StaticPageController::class, 'index']);
Route::get('/about', [StaticPageController::class, 'about']);
Route::get('/profile', function () {
  $names = ['John', 'Joe'];
  return view('profile')
    ->withNames($names)
    ->withBirthday('2000,01,02')
    ->withGender('male')
    ->withCity(request('city'));

  /*
  return view('profile', [
      'names' => $name,
      'birthday' => '2000,01,01',
      'gender' => 'male',
      'city' => request('city')
  ]);
  */
});

//Route::get('/events', [EventsController::class, 'index']);
Route::get('events', function () {
  $event = Event::find(1);
  return view('events.index', ['events' => $event->title]);
});

Route::get('/users', function () {
  $user = User::find(1);
  return $user->first_name;
});

Route::get('/email', [EmailController::class, 'sendEmail']);
