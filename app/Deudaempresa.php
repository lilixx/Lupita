<?php

namespace Lupita;

use Illuminate\Database\Eloquent\Model;

class Deudaempresa extends Model
{
  public function afiliaciondetalle()
  {
    return $this->belongsTo(Afiliaciondetalle::class);
  }

  public function prestamodetalle()
  {
    return $this->belongsTo(Prestamodetalle::class);
  }

  public function ahorrodetalle()
  {
    return $this->belongsTo(Ahorrodetalle::class);
  }
}
