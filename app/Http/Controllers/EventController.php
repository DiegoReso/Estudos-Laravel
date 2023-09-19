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
        
        if($request->hasFile('image') || $request->file('image')->isValid()){

            $extension = $request->image->extension();

            $imageName = md5($request->image->getClientOriginalName() .strtotime('now') ). "." . $extension;

            $request->image->move(public_path('/events/img'), $imageName);

            $events->image = $imageName;
        }

        $events->save();

        return redirect('/')->with('msg', 'Evento criado com sucesso');

    }



    public function create() {
        return view('events.create');
    }

}