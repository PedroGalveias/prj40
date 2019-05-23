<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Movement extends Authenticatable
{
    protected $table = "movimentos";

    use Notifiable;

    protected $fillable = [
        'data','id', 'hora_descolagem','num_licenca_piloto' ,'hora_aterragem', 'aeronave', 'num_diario', 'num_servico', 'piloto_id', 'natureza', 'aerodromo_partida', 'aerodromo_chegada', 'num_aterragens',
        'num_descolagens', 'num_pessoas', 'conta_horas_inicio', 'conta_horas_fim', 'tempo_voo', 'preco_voo', 'modo_pagamento', 'num_recibo', 'observacoes', 'tipo_instrucao', 'instrutor_id', 'confirmado'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getFormattedTypeAttribute()
    {
        switch ($this->type) {
            case 0:
                return 'Administrator';
            case 1:
                return ;
            case 2:
                return ;
        }

        return 'Unknown';
    }

    public function isAdmin()
    {
        return $this->type === '0';
    }

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


}