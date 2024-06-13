<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Balancemasacuatro extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeFilter($query,$filters){
        $query->when($filters['variedad'] ?? null, function ($query, $variedad) {
            $query->where('Variedad',$variedad);
        })->when($filters['semana'] ?? null, function ($query, $variedad) {
            $query->where('semana',$variedad);
        })->when($filters['calibre'] ?? null, function ($query, $variedad) {
            $query->where('CALIBRE',$variedad);
        });
    }
}
