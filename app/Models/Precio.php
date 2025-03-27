<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Precio extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


     // relacion uno a muchos inversa
     public function tarifas(){
        return $this->hasmany('App\Models\Tarifaprecio');
    }
    
}
