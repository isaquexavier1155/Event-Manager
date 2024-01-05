<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;

class EventController extends Controller
{
    //action, rota principal da aplicação, compativel com a rota barra: / do arquivo web.phph
    //Todos os CRUDS da aplicação ficarão aqui na controller
    //chamando o model chamado Event da pasta Models com use acima
    //método all obtem todos os registros do banco de dados
    //model tem a finalidade de se conectar com a tabela do banco de dados
    public function index(){

        $search = request('search');

        if($search){
            $events = Event::where([
                ['title', 'like', '%'.$search.'%']
            ])->get();
        }else{
            $events = Event::all();
        }

        //dd($events); // Verifique os eventos aqui
        return view('welcome', ['events' => $events, 'search' => $search]);

    }

    // public function home(){
    //     return view('events.home');
    // }

    //pasta.nomedo arquivo
    public function create(){
        return view('events.create');
    }

    public function store(Request $request){
        $event = new Event;

        $event->title = $request->title;
        $event->date = $request->date;
        $event->city = $request->city;
        $event->private = $request->private;
        $event->description = $request->description;
        $event->items = $request->items;

        //Image Upload

        if($request->hasFile('image') && $request->file('image')->isValid()) {
            $requestImage = $request->image;
            $extension = $requestImage->extension();
            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;
            $requestImage->move(public_path('img/events'), $imageName);
            $event->image = $imageName;
        }

        $user = auth()->user();
        $event->user_id = $user->id;

        $event->save();

        return redirect('/')->with('msg', 'Evento criado com sucesso!');
    }

    public function storeTwo(Request $request){
        $event = new Event;

        $event->nome_campanha = $request->nome_campanha;
        $event->quantidade_bilhetes = $request->quantidade_bilhetes;
        $event->valor_bilhetes = $request->valor_bilhetes;
        $event->local_sorteio = $request->local_sorteio;
        $event->telefone = $request->telefone;
       

        //Image Upload

        if($request->hasFile('image') && $request->file('image')->isValid()) {
            $requestImage = $request->image;
            $extension = $requestImage->extension();
            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;
            $requestImage->move(public_path('img/events'), $imageName);
            $event->image = $imageName;
        }

        $user = auth()->user();
        $event->user_id = $user->id;

        $event->save();

        return redirect('/')->with('msg', 'Evento criado com sucesso!');
    }

    public function show($id){
        $event = Event::findOrFail($id);

        //para verificar se usuário ja se inscreveu para participar de evento
        $user = auth()->user();
        $hasUserJoined = false;
        if($user){
            $userEvents = $user->eventsAsParticipant->toArray();
            foreach($userEvents as $userEvent){
                if($userEvent['id'] == $id){
                    $hasUserJoined = true;
                }

            }
        }

        $eventOwner = User::where('id', $event->user_id)->first()->toArray();
        //envia dados das variaveis para o front end
        return view('events.show', ['event' => $event, 'eventOwner' =>$eventOwner, 'hasUserJoined' => $hasUserJoined]);
    }

    public function dashboard() {

        $user = auth()->user();
        $events = $user->events;
        $eventsAsParticipant = $user->eventsAsParticipant;
        return view('events.dashboard', 
        ['events' => $events, 'eventsasparticipant' => $eventsAsParticipant]
        );
    }
    public function destroy($id){
        Event::findOrFail($id)->delete();
        return redirect('')->with('msg', 'Evento excluído com sucesso!');
    }

    public function edit($id){
        $user = auth()->user();
        $event = Event::findOrFail($id);

        if($user->id != $event->user_id){
            return redirect('');
        }

        return view('events.edit', ['event' => $event]);
    }

    public function update(Request $request){
        $date = $request->all();

        if($request->hasFile('image') && $request->file('image')->isValid()) {
            $requestImage = $request->image;
            $extension = $requestImage->extension();
            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;
            $requestImage->move(public_path('img/events'), $imageName);
            $data['image'] = $imageName;
            Event::findOrFail($request->id)->update($data);
        }else{
             Event::findOrFail($request->id)->update($date);
        }

        return redirect('')->with('msg', 'Evento aditado com sucesso!');
    }

    public function joinEvent($id){
        $user = auth()->user();
        $user->eventsAsParticipant()->attach($id);
        $event = Event::findOrFail($id);
        return redirect('')->with('msg', 'Sua presença está confirmada no evento' . $event->title);
    }

    public function leaveEvent($id){
        $user = auth()->user();
        $user->eventsAsParticipant()->detach($id);
        $event = Event::findOrFail($id);
        return redirect('')->with('msg', 'Você saiu com sucesso do evento:' . $event->title);
    }

}


