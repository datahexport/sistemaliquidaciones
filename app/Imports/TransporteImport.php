<?php

namespace App\Imports;

use App\Models\Temporada;
use App\Models\Transporte;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class TransporteImport implements ToModel, WithStartRow
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
    {   return new Transporte([
            'temporada_id'=>$this->temporada->id,
            'productor'     => $row[0],
            'fecha'     => Carbon::instance(Date::excelToDateTimeObject($row[1])),
            'monto'    => $row[2],
            't_c'        => $row[3],
            'dolar'     => $row[4],
            'orden'       => $row[5],  // Tipo de cambio
            'busqueda'     => $row[6],
        ]);
    }
}