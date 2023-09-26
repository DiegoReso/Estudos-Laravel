<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Event;
use App\Models\User;

class EventController extends Controller
{
    
    public function index() {

        $search = request('search');

        if($search){

            $events = Event::where([['title', 'like', '%'.$search.'%']])->get();

        }else{

            $events = Event::all();

        }

        
    
        return view('welcome',['events' => $events, 'search'=> $search]);

    }


    public function store(Request $request){

        $events = new Event;
        $events->title = $request->title;
        $events->city = $request->city;
        $events->private = $request->private;
        $events->description = $request->description;
        $events->items = $request->items;
        $events->date = $request->date;
        
        
        if($request->hasFile('image') && $request->image->isValid()){


            $extension = $request->image->extension();

            $imageName = md5($request->image->getClientOriginalName() . strtotime('now')) . "." . $extension;

            $request->image->move(public_path('/img/events'), $imageName);
            
            $events->image = $imageName;



        }
        
        
        $user = auth()->user();
        $events->user_id = $user->id;

        $events->save();

        return redirect('/')->with('msg', 'Evento criado com sucesso');

    }

    public function show($id){
        
        $event = Event::FindOrFail($id);

        $eventOwner = User::where('id', $event->user_id)->first();
        return view('events.show', ['event' => $event, 'eventOwner' => $eventOwner]);

    }

    public function create() {
        return view('events.create');
    }

    public function dashboard(){

        $user = auth()->user();

        $events = $user->events;
        
        $eventsAsParticipant = $user->eventsAsParticipant;

        
        return view('events.dashboard', ['events' => $events, 'eventsAsParticipant' => $eventsAsParticipant]);
    }

    public function destroy($id){

        Event::findOrFail($id)->delete();

        return redirect('/dashboard')->with('msg', 'Evento excluido com sucesso');

    }

    public function edit($id){

        $event = Event::findOrFail($id);


        return view('events.edit', ['event' => $event]);
    }


    public function update(Request $request){

        $data = $request->all();


        if($request->hasFile('image') && $request->image->isValid()){


            $extension = $request->image->extension();

            $imageName = md5($request->image->getClientOriginalName() . strtotime('now')) . "." . $extension;

            $request->image->move(public_path('/img/events'), $imageName);
            
            $data['image'] = $imageName;


        }
        

        Event::FindOrFail($request->id)->update($data);

        return redirect('/dashboard')->with('msg', 'Evento editado com sucesso');

    }


    public function joinEvent($id){

        $user = auth()->user();

        $user->eventsAsParticipant()->attach($id);

        $event = Event::findOrFail($id);
        
        return redirect('/dashboard')->with('msg', 'Voce esta participando de um evento ' . $event->title);
    }

}

