<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fob extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function temporada(){
        return $this->belongsTo('App\Models\Temporada');
    }

     // relacion uno a muchos inversa
    public function tarifas(){
        return $this->hasmany('App\Models\Tarifaprecio');
    }

    public function scopeFilter($query,$filters){
        $query->when($filters['variedad'] ?? null,function($query,$variedad){
            $query->where('n_variedad',$variedad);
        })->when($filters['semana'] ?? null,function($query,$semana){
            $query->where('semana',$semana);
        })->when($filters['calibre'] ?? null,function($query,$calibre){
            $query->where('n_calibre',$calibre);
        })->when($filters['exp'] || $filters['com'], function ($query) use ($filters) {
            // Si hay algún filtro activo, aplicamos las condiciones
            $query->where(function ($query) use ($filters) {
                if ($filters['exp'] && $filters['com']) {
                    
                } elseif ($filters['exp']) {
                    $query->whereNot('n_variedad', 'COMERCIAL');
                } elseif ($filters['com']) {
                    $query->where('n_variedad', 'COMERCIAL');
                } 
            });
        }, function ($query) {
            // Si no hay ningún filtro activo, forzamos que no devuelva resultados
            $query->whereRaw('1 = 0');
        });
    }
}
