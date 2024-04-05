<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Balancemasa extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

     // relacion uno a muchos inversa
    public function tabla2(){
        return $this->hasone('App\Models\Balancemasados','id_check','id_check');
    }

    public function costomaterial(){
        return $this->hasone('App\Models\Material','c_embalaje','c_embalaje');
    }

    public function scopeFilter($query,$filters){
        $query->when($filters['razonsocial'] ?? null, function ($query, $serie) {
            $query->where('productor_recep', 'like', '%' . $serie . '%');
        })->when($filters['precioFob'] ?? null, function ($query, $precioFob) {
            if ($precioFob == 'null') {
                $query->whereNull('precio_fob');
            }
        })->when($filters['variedad'] ?? null, function ($query, $variedad) {
            $query->where('variedad',$variedad);
        })->when($filters['norma'] || $filters['fnorma']  || $filters['mi'], function ($query) use ($filters) {
            $query->where(function ($query) use ($filters) {
                if ($filters['norma'] && $filters['fnorma'] && $filters['mi']) {
                    $query->orWhere('norma', 'DENTRO DE NORMA')
                          ->orWhere('norma', 'FUERA DE NORMA')
                          ->orWhere('norma', 'MERCADO INTERNO');
                }elseif ($filters['norma'] && $filters['fnorma']) {
                    $query->orwhere('norma', 'DENTRO DE NORMA')
                            ->orWhere('norma', 'FUERA DE NORMA');
                }elseif ($filters['norma'] && $filters['mi']) {
                    $query->orwhere('norma', 'DENTRO DE NORMA')
                        ->orwhere('norma', 'MERCADO INTERNO');
                }elseif ($filters['fnorma'] && $filters['mi']) {
                    $query->orwhere('norma', 'FUERA DE NORMA')
                        ->orwhere('norma', 'MERCADO INTERNO');
                }elseif ($filters['norma']) {
                    $query->where('norma', 'DENTRO DE NORMA');
                }elseif ($filters['fnorma']) {
                    $query->where('norma', 'FUERA DE NORMA');
                }elseif ($filters['mi']) {
                    $query->where('norma', 'MERCADO INTERNO');
                }
            });
        });
    }
    
}
