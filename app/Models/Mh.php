<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mh extends Model
{
    protected $table = 'mh';

    protected $fillable = [
        'codigo',
        'proyecto',
        'documento',
        'adjudicatario',
        'fecha_ins',
        'institucion_acreedora',
        'obs',
        'fecha_reins',

    ];


    protected $dates = [
        'fecha_ins',
        'fecha_reins',

    ];


    public $timestamps = false;

    protected $appends = ['resource_url'];
    protected $with = ['detallehipoteca','detallecartera','detallejuridico','detalleMh'];

    public function detalleMh()
    {
      return $this->hasOne(DetalleMh::class, 'VivPer')->latest('VivPer');
    }

    public function detallehipoteca()
     {
         return $this->hasOne(DetalleMh::class, 'VivPer', 'documento');
     }

     public function detallecartera()
     {
         return $this->hasOne(Cartera::class, 'PerCod', 'documento');
     }


    public function detallejuridico()
     {
        return $this->hasOne(Juridico::class, 'PerCod', 'documento');
     }


    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/mhs/'.$this->getKey());
    }


}
