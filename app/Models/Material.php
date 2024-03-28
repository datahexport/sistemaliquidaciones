<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeFilter($query,$filters){
        $query->when($filters['razonsocial'] ?? null,function($query,$serie){
            $query->where('c_embalaje','like','%'.$serie.'%')->orwhere('descripcion','like','%'.$serie.'%');
        });
    }
}
