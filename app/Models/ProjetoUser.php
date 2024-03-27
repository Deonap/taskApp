<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjetoUser extends Model
{
    use HasFactory;
    protected $fillable = ['projeto_id', 'user_id', 'prioridade'];
}
