<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detalle extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function temporada(){
        return $this->belongsTo('App\Models\Temporada');
    }

    public function scopeFilter($query,$filters){
        $query->when($filters['razonsocial'] ?? null,function($query,$serie){
            $query->where('n_productor','like','%'.$serie.'%')->orwhere('item','like','%'.$serie.'%')->orwhere('rut','like','%'.$serie.'%');
        });
    }

}
