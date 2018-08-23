<?php

namespace Lupita;

use Illuminate\Database\Eloquent\Model;

class Prestamopausa extends Model
{
  protected $fillable = [
      'prestamo_id', 'cobrointere'
  ];
}
