<?php

namespace Lupita;

use Illuminate\Database\Eloquent\Model;

class Plazofijo extends Model
{
    protected $fillable = [
        'socio_id', 'frecpagointere_id', 'formapagointere_id', 'numdoc',
        'vencimiento', 'monto', 'interesven', 'ir', 'tasainteres', 'diaplazo', 'debitoch', 'activo'
    ];

    public function beneficiarios()
    {
        return $this->belongsToMany('Lupita\Beneficiario')->withPivot('porcentaje')->withTimestamps();
    }

    public function socio()
    {
      return $this->belongsTo(Socio::class);
    }

    public function formapagointere()
    {
      return $this->belongsTo(Formapagointere::class);
    }

    public function frecpagointere()
    {
      return $this->belongsTo(Frecpagointere::class);
    }


}
