<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventController extends Controller
{
    //ation, rota principal da aplicação, compativel com a rota barra: / do arquivo web.phph
    //Todos os CRUDS da aplicação ficarão aqui na controller
    
    public function index(){
        $nome = "isaque";
        $arr = [10,20,30,40,50];
        $nomes = ["Matheus","Maria","João","Saulo"];
        return view('welcome', 
        [
            'nome' => $nome,
            'arr' => $arr,
            'nomes' => $nomes
        ]);

    }

    public function create(){
        return view('events.create');
    }

    public function contact(){
        return view('events.contact');
    }

    public function product(){
        return view('events.product');
    }


}
