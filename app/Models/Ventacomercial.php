<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ventacomercial extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function temporada(){
        return $this->belongsTo('App\Models\Temporada');
    }

    public function scopeFilter($query,$filters){
        $query->when($filters['cliente'] ?? null,function($query,$cliente){
              $query->where('cliente',$cliente);
        })->when($filters['tipo'] ?? null,function($query,$tipo){
            $query->where('tipo',$tipo);
        })->when($filters['semana'] ?? null,function($query,$semana){
            $query->where('semana',$semana);
        });
    }
}
