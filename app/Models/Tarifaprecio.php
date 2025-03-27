<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarifaprecio extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    public function fob(){
        return $this->belongsTo('App\Models\Fob');
    }

    public function precio(){
        return $this->belongsTo('App\Models\Precio');
    }
}
