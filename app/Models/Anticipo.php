<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anticipo extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeFilter($query, $filters)
    {
        // Filtro para 'productor' o 'busqueda' basado en 'razonsocial'
        $query->when($filters['razonsocial'] ?? null, function ($query, $serie) {
            $query->where('productor', 'like', '%' . $serie . '%')
                  ->orWhere('busqueda', 'like', '%' . $serie . '%');
        });
        
        $razonspropias = Razonsocial::where('is_propio', 1)->get()->pluck('name')->unique();

        $razonsexternas = Razonsocial::where('is_propio','0')->orWhereNull('is_propio')->get()->pluck('name')->unique();


        //dd($razonsexternas);

        $query->when(($filters['ispropio'] ?? false) || ($filters['nopropio'] ?? false), function ($query) use ($razonspropias, $razonsexternas, $filters) {
            // Si ispropio está activado
            if ($filters['ispropio']) {
                // Agrega la condición para los productores propios
                $query->whereIn('productor', $razonspropias);
            }
        
            // Si nopropio está activado
            if ($filters['nopropio']) {
                // Agrega la condición para los productores externos
                $query->orWhereIn('productor', $razonsexternas);
            }
        });
        
        // Si no hay filtros seleccionados, puedes asegurarte de que no se muestre nada
        if (!$filters['ispropio'] && !$filters['nopropio']) {
            // No se hace nada, lo que significa que no habrá resultados
            $query->whereRaw('1 = 0');
        }

    }
    


    
    
}
