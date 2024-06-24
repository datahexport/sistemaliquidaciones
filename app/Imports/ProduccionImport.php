<?php

namespace App\Imports;

use App\Models\Proceso;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ProduccionImport implements ToCollection, WithStartRow
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
                Proceso::create([
                    'temporada_id' => $this->temporada,

                    'PROCESO' => $row[0],
                    'TURNO' => $row[1],
                    'PLANTA' => $row[2],
                    'FECHA' => Carbon::instance(Date::excelToDateTimeObject($row[3])),
                    'PRODUCTOR_RECEP_FACTURACION' => $row[4],
                    'VARIEDAD' => $row[5],
                    'ENVASES_ETIQ' => $row[6],
                    'COLOR' => $row[7],
                    'CALIBRE' => $row[8],
                    'CALIBRE_REAL' => $row[9],
                    'CANT' => $row[10],
                    'PESO_FINAL' => floatval($row[11]),
                    'PESO_PRORRATEADO' => floatval($row[12]),
                    'KG_VACIADO' => $row[13],
                    'PESO_CAJA' => $row[14],
                    'TIPO_CAJA' => $row[15],
                    'CAJA_EQ_5KG' => $row[16],
                    'TIPO' => $row[17],
                    'CRITERIO' => $row[18],
                    'COLOR_FINAL' => $row[19],
                    'BUSQUEDA_PROCESO' => $row[20],
                    'EXPORTADORA' => $row[21],
                    'NORMA' => $row[22],
                    'SEMANA' => $row[23],

                ]);
                
            }
        }
}
