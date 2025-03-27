<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fobdespacho extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function temporada(){
        return $this->belongsTo('App\Models\Temporada');
    }

    public function scopeFilter($query,$filters){
        $query->when($filters['folio'] ?? null,function($query,$folio){
            if ($folio == 'vacio') {
                $query->whereNull('suma_fob')->orwhere('suma_fob','Sin Venta');
            }elseif($folio == 'cero'){
                $query->where('cant_kg',0);
            }else{
                $query->where('folio',$folio);
            }
        });
    }
}