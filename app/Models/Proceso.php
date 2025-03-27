<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proceso extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function temporada(){
        return $this->belongsTo('App\Models\Temporada');
    }

    public function fob(){
        return $this->belongsTo('App\Models\Fob');
    }

    public function scopeFilter($query,$filters){
        $query->when($filters['razonsocial'] ?? null, function ($query, $serie) {
            $query->where('PRODUCTOR_RECEP_FACTURACION', 'like', '%' . $serie . '%');
        })->when($filters['precioFob'] ?? null, function ($query, $precioFob) {
            if ($precioFob == 'null') {
                $query->whereNull('fob_id');
            }if($precioFob == 'full') {
                $query->where('fob_id','>',0);
            }
        })->when($filters['variedad'] ?? null, function ($query, $variedad) {
            $query->where('VARIEDAD',$variedad);
        })->when($filters['tipo'] ?? null, function ($query, $tipo) {
            $query->where('TIPO',$tipo);
        })->when($filters['calibre'] ?? null, function ($query, $calibre) {
            $query->where('CALIBRE_REAL',$calibre);
        })->when($filters['semana'] ?? null, function ($query, $semana) {
            $query->where('SEMANA',$semana);
        })->when($filters['embalaje'] ?? null, function ($query, $embalaje) {
            $query->where('PESO_CAJA',$embalaje);
        })->when($filters['norma'] ?? null, function ($query, $norma) {
            if ($norma == 'dentro') {
                $query->where('NORMA','DENTRO DE NORMA');
            }if($norma == 'fuera') {
                $query->where('NORMA','FUERA DE NORMA');
            }
          
        })->when($filters['exp'] || $filters['com'] || $filters['comem'], function ($query) use ($filters) {
            // Si hay algún filtro activo, aplicamos las condiciones
            $query->where(function ($query) use ($filters) {
                if ($filters['exp'] && $filters['com'] && $filters['comem']) {
                    $query->orWhere('CRITERIO', 'EXPORTACIÓN')
                          ->orWhere('CRITERIO', 'COMERCIAL')
                          ->orWhere('CRITERIO', 'COMERCIAL EMBALADA');
                } elseif ($filters['exp'] && $filters['com']) {
                    $query->orWhere('CRITERIO', 'EXPORTACIÓN')
                          ->orWhere('CRITERIO', 'COMERCIAL');
                } elseif ($filters['exp'] && $filters['comem']) {
                    $query->orWhere('CRITERIO', 'EXPORTACIÓN')
                          ->orWhere('CRITERIO', 'COMERCIAL EMBALADA');
                } elseif ($filters['com'] && $filters['comem']) {
                    $query->orWhere('CRITERIO', 'COMERCIAL')
                          ->orWhere('CRITERIO', 'COMERCIAL EMBALADA');
                } elseif ($filters['exp']) {
                    $query->where('CRITERIO', 'EXPORTACIÓN');
                } elseif ($filters['com']) {
                    $query->where('CRITERIO', 'COMERCIAL');
                } elseif ($filters['comem']) {
                    $query->where('CRITERIO', 'COMERCIAL EMBALADA');
                }
            });
        }, function ($query) {
            // Si no hay ningún filtro activo, forzamos que no devuelva resultados
            $query->whereRaw('1 = 0');
        });
    }

}
