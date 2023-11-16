<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    //action, rota principal da aplicação, compativel com a rota barra: / do arquivo web.phph
    //Todos os CRUDS da aplicação ficarão aqui na controller
    //chamando o model chamado Event da pasta Models com use acima
    //método all obtem todos os registros do banco de dados
    //model tem a finalidade de se conectar com a tabela do banco de dados
    public function index(){
        $events = Event::all();
        //dd($events); // Verifique os eventos aqui
        return view('welcome', ['events' => $events]);

    }

    public function create(){
        return view('events.create');
    }

}
