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

    public function scopeFilter($query,$filters){
        $query->when($filters['razonsocial'] ?? null,function($query,$search){
            $query->where('n_calibre','like','%'.$search.'%')
            ->orwhere('etiqueta','like','%'.$search.'%');
        })->when($filters['variedad'] ?? null,function($query,$variedad){
            $query->where('n_variedad',$variedad);
        });
    }
}
