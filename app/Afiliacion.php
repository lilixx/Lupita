<?php

namespace Lupita;

use Illuminate\Database\Eloquent\Model;

class Afiliacion extends Model
{
    protected $fillable = [
        'socio_id', 'afiliacioncatalogo_id', 'pagoplanilla', 'pagado',
    ];

    public function afiliaciondetalle()
    {
      return $this->hasMany(Afiliaciondetalle::class);
    }

    public function afiliacioncatalogo()
    {
      return $this->belongsTo(Afiliacioncatalogo::class);
    }

    public function socio()
    {
      return $this->belongsTo(Socio::class);
    }
}
