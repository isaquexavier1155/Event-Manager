<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comprador extends Model
{
    use HasFactory;

    protected $table = 'compradores';

    protected $fillable = [
        'nome_completo',
        'email',
        'telefone',
        'repeticao_telefone',
        'numeros_escolhidos',
        'id_campanha',
        'status_cobranca_bilhetes',
    ];
}
