<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjetoUser extends Model
{
    use HasFactory;
    protected $fillable = ['projeto_id', 'user_id', 'prioridade', 'tempo_gasto'];
    protected $primaryKey = ['projeto_id','user_id'];
    public $incrementing = false;

    protected function setKeysForSaveQuery($query)
    {
        return $query->where('projeto_id', $this->getAttribute('projeto_id'))
                    ->where('user_id', $this->getAttribute('user_id'));
    }


    public function projeto()
    {
        return $this->belongsTo(Projeto::class, 'projeto_id');
    }
    public function user()
    {
        return $this->belongsTo(Projeto::class, 'user_id');
    }
}
