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

    public function scopeCalibre($query,$calibre){
        $query->when($calibre ?? null,function($query,$calibre){
            $query->where('n_calibre','like','%'.$calibre.'%')->orwhere('etiqueta','like','%'.$calibre.'%');
        });
    }
}
