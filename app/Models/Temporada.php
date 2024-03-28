<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Temporada extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    

    // relacion uno a muchos inversa
    public function user(){
        return $this->BelongsTo('App\Models\User');
    }

    // relacion uno a muchos inversa
    public function packings(){
        return $this->hasmany('App\Models\CostoPacking');
    }

    public function materials(){
        return $this->hasmany('App\Models\Material');
    }

    public function anticipos(){
        return $this->hasmany('App\Models\Anticipo');
    }
    
   

    public function flets(){
        return $this->hasmany('App\Models\Flete');
    }

    public function fobs(){
        return $this->hasmany('App\Models\Fob');
    }

    public function masas(){
        return $this->hasmany('App\Models\Balancemasa');
    }

    public function masasdos(){
        return $this->hasmany('App\Models\Balancemasados');
    }

    public function masatres(){
        return $this->hasmany('App\Models\Balancemasatres');
    }
   

    public function masascuatros(){
        return $this->hasmany('App\Models\Balancemasacuatro');
    }

    public function exportacions(){
        return $this->hasmany('App\Models\Exportacion');
    }

    public function comisions(){
        return $this->hasmany('App\Models\Comision');
    }

    public function gastos(){
        return $this->hasmany('App\Models\Gasto');
    }

    public function detalles(){
        return $this->hasmany('App\Models\Detalle');
    }
}
