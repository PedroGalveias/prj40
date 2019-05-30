<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aeronave extends Model
{
    protected $primaryKey = 'matricula';
    public $timestamp = false;
    public $incrementing = false;

    public function movimento()
    {
        return hasMany("App\Movimento", "aeronave", "matricula");
    }

    protected $fillable = [
        'matricula', 'marca', 'modelo', 'num_lugares', 'conta_horas', 'preco_hora'
    ];
}
