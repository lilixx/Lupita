<?php

namespace Lupita;

use Illuminate\Database\Eloquent\Model;

class Plazofijodetalle extends Model
{
  protected $fillable = [
      'plazofijo_id', 'intereses', 'numero', 'ir',
      'total', 'rock_ck', 'pagado', 'penalidad', 'valorpenalidad',
  ];

  public function plazofijo()
  {
    return $this->belongsTo(Plazofijo::class);
  }
}
