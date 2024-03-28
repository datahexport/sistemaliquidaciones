<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostoPacking extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeFilter($query,$filters){
        $query->when($filters['razonsocial'] ?? null,function($query,$razonsocial){
            $query->where('n_productor','like','%'.$razonsocial.'%')->orwhere('csg','like','%'.$razonsocial.'%');
        })->when($filters['especie'] ?? null,function($query,$especie){
            $query->where('especie','like','%'.$especie.'%');
        })->when($filters['variedad'] ?? null,function($query,$variedad){
            $query->where('variedad',$variedad);
        });
        
    }
}
