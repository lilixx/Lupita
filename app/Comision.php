<?php

namespace Lupita;

use Illuminate\Database\Eloquent\Model;

class Comision extends Model
{
    protected $fillable = [
        'valor', 'nombre'
    ];
}
