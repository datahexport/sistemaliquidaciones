<?php

namespace App\Imports;

use App\Models\AnalisisMultiresiduo;
use App\Models\AnalisisMultiresiduos;
use App\Models\Orden;
use App\Models\Temporada;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class OrdenImport implements ToModel, WithStartRow
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
    {   return new AnalisisMultiresiduo([
            'temporada_id'=>$this->temporada->id,
            'fecha'     => Carbon::instance(Date::excelToDateTimeObject($row[0])),
            'orden'     => $row[1],
            'precio'    => $row[2],
            'uf'        => $row[3],
            'total'     => $row[4],
            't_c'       => $row[5],  // Tipo de cambio
            'dolar'     => $row[6],
            'orden2'    => $row[7],
            'productor' => $row[8],
            'busqueda'  => $row[9],
        ]);
    }
}