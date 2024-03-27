<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoProjeto extends Model
{
    use HasFactory;
    protected $table = 'estado_projetos';

    protected $fillable = ['nome', 'cor'];
}
