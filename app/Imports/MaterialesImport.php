<?php

namespace App\Imports;

use App\Models\Material;
use App\Models\Temporada;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class MaterialesImport implements ToModel, WithStartRow
{     protected $temporada;

    public function __construct(Temporada $temporada)
    {
        $this->temporada = $temporada;
    }
    
    // Método para saltar las primeras filas
    public function startRow(): int
    {
        return 2; // Comenzar en la segunda fila (ignorando la primera)
    }
    
    public function model(array $row)
    {   return new Material([
            'temporada_id'=>$this->temporada->id,
            'productor'     => $row[0],
            'fecha'     => Carbon::instance(Date::excelToDateTimeObject($row[1])),
            'material'    => $row[2],
            'cantidad'        => $row[3],
            'precio'     => $row[4],
            'dolar'       => $row[5],  // Tipo de cambio
            'orden'     => $row[6],
            'busqueda'    => $row[7],
        ]);
    }
}