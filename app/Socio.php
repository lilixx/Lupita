<?php

namespace Lupita;

use Illuminate\Database\Eloquent\Model;

class Socio extends Model
{
    protected $fillable = [
        'empresa_id', 'nombres', 'apellidos', 'fecha_nac',
         'lugar_nac', 'nacionalidad', 'estado_civil', 'nombre_conyuge', 'num_hijos', 'num_cedula', 'num_licencia',
         'num_inss', 'direccion_casa', 'telf_casa', 'telf_trabajo', 'cargo', 'sueldo', 'comentario', 'sexo',
         'municipio', 'ciudad', 'departamento', 'antiguedad', 'otrosingresos', 'origenoting',
    ];

    public function afiliacions()
    {
       return $this->hasMany(Afiliacion::class);
    }

    public function empresa()
    {
      return $this->belongsTo(Empresa::class);
    }

    public function ahorro()
    {
       return $this->hasOne(Ahorro::class);
    }
}
