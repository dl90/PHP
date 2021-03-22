<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventsController extends Controller
{
    public function index(): string {

        $events = Event::all();
        return view('events.index')->withEvents($events);
    }
}
