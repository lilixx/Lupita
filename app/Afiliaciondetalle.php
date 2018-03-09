<?php

namespace Lupita;

use Illuminate\Database\Eloquent\Model;

class Afiliaciondetalle extends Model
{
    public function afiliacion()
    {
      return $this->belongsTo(Afiliacion::class);
    }

}
