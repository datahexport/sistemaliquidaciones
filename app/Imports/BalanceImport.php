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
                    'tipo' => $row[15],
                    'criterio' => $row[16],
                    'color_final' => $row[17],
                    'exportadora' => $row[18],
                    'norma' => $row[19],
                    'semana' => $row[20],
                    'csg' => $row[21],
                    'fob' => $row[22],
                    'fob_nacional' => $row[23],
                    'costo' => $row[24],
                    'costo_nacional' => $row[25],
                    'margen' => $row[26]

                ]);
                
            }
        }
}
