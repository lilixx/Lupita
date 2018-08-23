<?php

namespace Lupita;

use Illuminate\Database\Eloquent\Model;

class Cartera extends Model
{
  public function carteradetalles()
  {
     return $this->hasMany(Carteradetalle::class);
  }
  public function empresa()
  {
    return $this->belongsTo(Empresa::class);
  }
}
