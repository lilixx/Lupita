<?php

namespace Lupita;

use Illuminate\Database\Eloquent\Model;

class Beneficiario extends Model
{
  protected $fillable = [
      'nombres', 'apellidos', 'num_cedula',
  ];
  public function ahorros()
  {
     return $this->hasMany(Ahorro::class);
  }
  public function beneficiarios()
  {
      return $this->belongsToMany('Lupita\Beneficiario')->withPivot('porcentaje')->withTimestamps();

  }
}
