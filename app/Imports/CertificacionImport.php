<?php

namespace App\Imports;

use App\Models\Certificacion;
use App\Models\Temporada;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class CertificacionImport implements ToModel, WithStartRow
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
    {   return new Certificacion([
            'temporada_id'=>$this->temporada->id,
            'productor'     => $row[0],
            'fecha'     => Carbon::instance(Date::excelToDateTimeObject($row[1])),
            'material'    => $row[2],
            'cant'        => $row[3],
            'precio'     => $row[4],
            'precio_1'       => $row[5],  // Tipo de cambio
            'tc'     => $row[6],
            'dolar'    => $row[7],
            'orden' => $row[8],
            'busqueda'  => $row[9],
        ]);
    }
}