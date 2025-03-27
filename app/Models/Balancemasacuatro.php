<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Balancemasacuatro extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    //detalle liquidacion

    public function scopeFilter($query,$filters){
        $query->when($filters['folio'] ?? null,function($query,$folio){
                $query->where('N_Pallet',$folio);
        })->when($filters['variedad'] ?? null,function($query,$variedad){
            $query->where('Variedad',$variedad);
        })->when($filters['calibre'] ?? null,function($query,$calibre){
            $query->where('CALIBRE',$calibre);
        })->when($filters['semana'] ?? null,function($query,$semana){
            $query->where('semana',$semana);
        });
    }
}
