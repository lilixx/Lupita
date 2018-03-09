<?php

namespace Lupita;

use Illuminate\Database\Eloquent\Model;

class Fiador extends Model
{
    protected $fillable = [
        'socio_id',
    ];

    public function prestamos()
    {
       return $this->hasMany(Prestamo::class);
    }

    public function socio()
    {
      return $this->belongsTo(Socio::class);
    }
}
