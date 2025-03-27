<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Balancemasatres extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    //despachos

    public function scopeFilter($query,$filters){
        $query->when($filters['folio'] ?? null,function($query,$folio){
            if ($folio == 'vacio') {
                $query->whereNull('Fob');
            }elseif($folio == 'cero'){
                $query->where('Kilos_INICIAL',0);
            }else{
                $query->where('Folio',$folio);
            }
        })->when($filters['semana'] ?? null,function($query,$semana){
                $query->where('semana',$semana);
        })->when($filters['variedad'] ?? null,function($query,$variedad){
            $query->where('Variedad_Real',$variedad);
        })->when($filters['variedad2'] ?? null,function($query,$variedad){
            $query->where('Variedad_Rot',$variedad);
        })->when($filters['calibre'] ?? null,function($query,$calibre){
            $query->where('calibre_real',$calibre);
        });
    }

}
