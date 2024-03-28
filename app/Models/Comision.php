<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comision extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function temporada(){
        return $this->belongsTo('App\Models\Temporada');
    }
}
