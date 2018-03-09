<?php

namespace Lupita;

use Illuminate\Database\Eloquent\Model;

class Ahorrodetalle extends Model
{
    protected $fillable = [
        'ahorro_id', 'concepto_id', 'rock_ck', 'debitos', 'creditos',
        'saldofinal', 'fecha',
    ];

    public function ahorro()
    {
      return $this->belongsTo(Ahorro::class);
    }

    public function concepto()
    {
      return $this->belongsTo(Concepto::class);
    }
}
