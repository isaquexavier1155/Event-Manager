<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $casts = [
        'items' => 'array'
    ];

    protected $dates = ['date'];

    // Para indicar que esse evento pertence a um usuário
    public function user() {
        return $this->belongsTo('App\Models\User');
    }
}
