<?php

namespace Lupita;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $fillable = [
        'nombre', 'direccion', 'telefono',
    ];
}
