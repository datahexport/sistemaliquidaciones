<?php

namespace App\Imports;

use App\Models\Anticipo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Date;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date as SharedDate;

class AnticipoImport implements ToCollection, WithStartRow
    {   protected $temporada;

        public function __construct($temporada)
        {
            $this->temporada = $temporada;
        }
        /**
         * @return int
         */
        public function startRow(): int
        {
            return 2;
        }

        public function collection($rows)
        {  
            foreach($rows as $row){
                 Anticipo::create([ 
                    'temporada_id'=>$this->temporada,

                    'productor'   => $row[0], // PRODUCTOR (nombre del productor)
                    'cantidad_usd'=> $row[1], // CANTIDAD USD
                    'usd'         => $row[2], // USD
                    'tipo_cambio' => $row[3], // TIPO CAMBIO
                    'total'       => $row[4], // TOTAL
                    'fecha'       => Carbon::instance(SharedDate::excelToDateTimeObject($row[5])), // FECHA
                    'orden'       => $row[6], // ORDEN
                    'busqueda'    => $row[7] ?? null, // BUSQUEDA (nullable)
                    'incluir'     => $row[8] == 'yes' ? 'true' : 'false', // INCLUIR? (consideramos 'yes' o 'no' en los datos)
                    'moneda'      => $row[9], // MONEDA
                    'detalle'     => $row[10] ?? null, // DETALLE (nullable)
                
                ]);
            }
        }
}
