<?php

namespace Lupita;

use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    protected $fillable = [
        'socio_id', 'fiador_id', 'tasacambio_id', 'monto', 'plazo', 'fechainicio',
        'cuota', 'num_cheque', 'cantcuotas', 'comision_id', 'parentescof', 'anticipo',
    ];

    public function socio()
    {
      return $this->belongsTo(Socio::class);
    }

    public function prestamocajachicas()
    {
       return $this->hasMany(Cajachica::class);
    }

    public function fiador()
    {
      return $this->belongsTo(Fiador::class);
    }

    public function comision()
    {
      return $this->belongsTo(Comision::class);
    }

}
