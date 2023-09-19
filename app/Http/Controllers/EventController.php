<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Event;

class EventController extends Controller
{
    
    public function index() {

        $events = Event::all();
    
        return view('welcome',['events' => $events]);

    }


    public function store(Request $request){

        $events = new Event;
        $events->title = $request->title;
        $events->city = $request->city;
        $events->private = $request->private;
        $events->description = $request->description;
        
        $events->save();

        return redirect('/')->with('msg', 'Evento criado com sucesso');

    }



    public function create() {
        return view('events.create');
    }

}