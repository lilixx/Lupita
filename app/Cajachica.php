<?php

namespace Lupita;

use Illuminate\Database\Eloquent\Model;

class Cajachica extends Model
{
  protected $fillable = [
      'ingreso', 'egreso', 'total', 'prestamo_id', 'num_doc',
  ];
}
