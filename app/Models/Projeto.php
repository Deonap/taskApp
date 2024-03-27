<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projeto extends Model
{
    use HasFactory;

    protected $table = 'projetos';

    protected $fillable = [
        'nome',
        'cliente_id',
        'tipo_cliente_id',
        'estado_projeto_id',
        'tempo_previsto',
        'observacoes',
        'tempo_gasto'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function estadoProjeto()
    {
        return $this->belongsTo(EstadoProjeto::class, 'estado_projeto_id');
    }

public function tipoCliente()
{
    return $this->belongsTo(TipoCliente::class, 'tipo_cliente_id');
}

public function users()
{
    return $this->belongsToMany(User::class, 'projeto_users')
                ->withPivot('prioridade', 'tempo_gasto', 'observacoes');
                 
}

    public function tarefas()
{
    return $this->hasMany(Tarefa::class);
}
}
