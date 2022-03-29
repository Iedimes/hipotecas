<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleMh extends Model
{

    protected $table = 'IVMVIV';
    //protected $primaryKey = 'VivPer';
    //public $keyType = 'string';
    //public $timestamps = false;
    protected $connection = 'sqlsrv';
    public $incrementing = false;

    protected $fillable = [
        //'VivPer',
        //'VivDir'


    ];

    protected $appends = ['resource_url'];
    protected $with = ['localidad','dpto'];

    public function localidad()
    {
        return $this->hasOne(Localidad::class, 'CiuId', 'VivCiuId');
    }


    public function dpto()
    {
        return $this->hasOne(Dpto::class, 'DptoId', 'CiuDptoID');
    }


    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/mhs/'.$this->getKey());
    }

}



