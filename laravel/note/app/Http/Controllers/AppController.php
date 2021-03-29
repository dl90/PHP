<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Note;
use App\Models\Site;
use App\Models\Todo;
use Illuminate\Support\Facades\Storage;
use mysql_xdevapi\Exception;

class AppController extends Controller
{
  public function show()
  {
    $user = auth()->user();
    return view('note', [
      'user_email' => $user->email,
      'images' => $user->images()->get(),
      'notes' => $user->notes()->first(),
      'sites' => $user->sites()->get(),
      'todos' => $user->todos()->get()
    ]);
  }

  public function update()
  {
    request()->validate(['note' => 'required']);
    $user = auth()->user();

    if (request()->hasFile('image')) {
      $files = request('image');
      $existing_files = $user->images()->get();

      if (count($existing_files) + count($files) <= 4) {
        foreach ($files as $file) {
          // $path = $file->store('user_images');
          $path = Storage::disk('local')->put('/private-uploads/images', $file);
          $new_image = new Image();
          $new_image->path = $path;
          $new_image->user_id = $user->id;
          $new_image->save();
        }
      } else {
        return view('note', [
          'user_email' => $user->email,
          'message' => 'Exceeded 4 images per user, please delete some first.',
          'images' => $user->images()->get(),
          'notes' => $user->notes()->first(),
          'sites' => $user->sites()->get(),
          'todos' => $user->todos()->get()
        ]);
      }
    }

    if (request('img_del_ids')) {
      foreach (request('img_del_ids') as $id) {
        $image = $user->images()->find($id);
        try {
          Storage::disk('local')->delete($image->path);
          if ($image) $image->delete();
        } catch (Exception $e) {
          return view('note', [
            'user_email' => $user->email,
            'message' => 'Something went wrong.',
            'images' => $user->images()->get(),
            'notes' => $user->notes()->first(),
            'sites' => $user->sites()->get(),
            'todos' => $user->todos()->get()
          ]);
        }
      }
    }

    $og_note = $user->notes()->first();
    if ($og_note) {
      $og_note->update(['note' => request('note')]);
    } else {
      $new_note = new Note();
      $new_note->note = request('note');
      $new_note->user_id = $user->id;
      $new_note->save();
    }

    $og_sites = $user->sites()->get();
    for ($i = 0; $i < count(request('sites_id')); $i++) {
      if (request('sites')[$i] && $og_sites->find(request('sites_id')[$i])) {
        $og_sites[$i]->update(['link' => request('sites')[$i]]);
      } else if (!request('sites')[$i] && $og_sites->find(request('sites_id')[$i])) {
        $og_sites[$i]->delete();
      } else if (request('sites')[$i]) {
        $new_site = new Site();
        $new_site->link = request('sites')[$i];
        $new_site->user_id = $user->id;
        $new_site->save();
      }
    }

    $og_todos = $user->todos()->get();
    for ($i = 0; $i < count(request('todos_id')); $i++) {
      if (request('todos')[$i] && $og_todos->find(request('todos_id')[$i])) {
        $og_todos[$i]->update(['todo' => request('todos')[$i]]);
      } else if (!request('todos')[$i] && $og_todos->find(request('todos_id')[$i])) {
        $og_todos[$i]->delete();
      } else if (request('todos')[$i]) {
        $new_todo = new Todo();
        $new_todo->todo = request('todos')[$i];
        $new_todo->user_id = $user->id;
        $new_todo->save();
      }
    }

    return view('note', [
      'user_email' => $user->email,
      'message' => 'Saved',
      'images' => $user->images()->get(),
      'notes' => $user->notes()->first(),
      'sites' => $user->sites()->get(),
      'todos' => $user->todos()->get()
    ]);
  }
}