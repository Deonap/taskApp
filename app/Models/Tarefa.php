<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarefa extends Model
{
    use HasFactory;

    protected $table = 'tarefas';

    protected $fillable = [
        'projeto_id',
        'descricao',

    ];

    // Relação com o Projeto
    public function projeto()
    {
        return $this->belongsTo(Projeto::class, 'projeto_id');
    }

}
