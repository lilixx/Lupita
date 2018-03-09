<?php

namespace Lupita;

use Illuminate\Database\Eloquent\Model;

class Prestamodetalle extends Model
{
  public function prestamo()
  {
    return $this->belongsTo(Prestamo::class);
  }
}
