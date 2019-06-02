<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movimento extends Model
{

    public function aeronave()
    {
        return $this->belongsTo("App\Aeronave", "matricula", "aeronave");
    }

    protected $fillable = [
        'data', 'id', 'hora_descolagem', 'num_licenca_piloto', 'hora_aterragem', 'aeronave', 'num_diario', 'num_servico', 'piloto_id', 'natureza', 'aerodromo_partida', 'aerodromo_chegada', 'num_aterragens',
        'num_descolagens', 'num_pessoas', 'conta_horas_inicio', 'conta_horas_fim', 'tempo_voo', 'preco_voo', 'modo_pagamento', 'num_recibo', 'observacoes', 'tipo_instrucao', 'instrutor_id', 'confirmado',
        'validade_licenca_piloto','num_certificado_instrutor','validade_licenca_instrutor','num_licenca_instrutor','validade_certificado_piloto','num_certificado_piloto', 'tipo_licenca_piloto', 'classe_certificado_piloto', 'tipo_licenca_instrutor',
        'classe_certificado_instrutor', 'validade_certificado_instrutor'

    ];

}