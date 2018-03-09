<?php

namespace Lupita;

use Illuminate\Database\Eloquent\Model;

class Ahorro extends Model
{
    protected $fillable = [
        'socio_id', 'fechainicio', 'depositoinicial', 'dolar', 'dia15',
        'dia30', 'pausada', 'comentario',
    ];

    public function socio()
    {
      return $this->belongsTo(Socio::class);
    }

    public function beneficiario()
    {
      return $this->belongsTo(Beneficiario::class);
    }

    public function ahorrodetalles()
    {
       return $this->hasMany(Ahorrodetalle::class);
    }
}
