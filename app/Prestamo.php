<?php

namespace Lupita;

use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    protected $fillable = [
        'socio_id', 'fiador_id', 'tasacambio_id', 'monto', 'plazo',
        'cuota', 'num_cheque', 'cantcuotas', 'comision_id', 'parentescof',
    ];

    public function socio()
    {
      return $this->belongsTo(Socio::class);
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
