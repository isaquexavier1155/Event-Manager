<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rifa extends Model
{
    use HasFactory;

    protected $table = 'rifas';

    protected $fillable = [
        'nome_campanha',
        'quantidade_bilhetes',
        'valor_bilhetes',
        'local_sorteio',
        'telefone',
        'txId',
        'descricao',
        'imagem',
    ];

        // Para indicar que esse evento pertence a um usuário
        public function user() {
            return $this->belongsTo('App\Models\User');
        }
    
        public function users(){
           return $this->belongsToMany('App\Models\User');
        }
}
