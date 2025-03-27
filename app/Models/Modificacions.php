<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modificacions extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function informe(){
        return $this->belongsTo('App\Models\Informe');
    }
}
