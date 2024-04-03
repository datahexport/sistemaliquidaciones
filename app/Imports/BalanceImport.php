<?php

namespace App\Imports;

use App\Models\Balancemasa;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class BalanceImport implements ToCollection, WithStartRow
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
                Balancemasa::create([
                    'temporada_id' => $this->temporada,

                    'proceso' => $row[0],
                    'planta' => $row[1],
                    'fecha' => Carbon::instance(Date::excelToDateTimeObject($row[2])),
                    'rut' => preg_replace('/[\.\-\s]+/', '', $row[3]),
                    'productor_recep' => $row[4],
                    'variedad' => $row[5],
                    'cod_embalaje' => $row[6],
                    'descripcion' => $row[7],
                    'envases' => $row[8],
                    'color' => $row[9],
                    'calibre' => $row[10],
                    'calibre_real' => $row[11],
                    'cantidad' => $row[12],
                    'peso_prorrateado' => $row[13],
                    'peso_caja' => $row[14],
                    'tipo_caja' => $row[15],
                    'caja_eq5' => $row[16],
                    'tipo' => $row[17],
                    'criterio' => $row[18],
                    'color_final' => $row[19],
                    'exportadora' => $row[20],
                    'norma' => $row[21],
                    'semana' => $row[22],
                    'csg' => $row[23]

                ]);
                
            }
        }
}
