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
                    'fecha' => Carbon::instance(Date::excelToDateTimeObject($row[1])),
                    'csg' => $row[2],
                    'productor_recep' => $row[3],
                    'variedad' => $row[4],
                    'envases' => $row[5],
                    'calibre' => $row[6],
                    'cantidad' => $row[7],
                    'peso_caja' => $row[8],
                    'tipo' => $row[9],
                    'color_final' => $row[10],
                    'semana' => $row[11]

                                      

                ]);
                
            }
        }
}
