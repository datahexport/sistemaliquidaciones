<?php

namespace App\Imports;

use App\Models\Detalle;
use App\Models\Gasto;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class GastoImport implements ToCollection, WithStartRow
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
                 Detalle::create([ 
                    'temporada_id'=>$this->temporada,

                    'grupo'=> $row[0],
                    'rut'=> preg_replace('/[\.\-\s]+/', '', $row[1]),
                    'n_productor'=> $row[2],
                    'item'=> $row[3],
                    'fecha'=>  Carbon::instance(Date::excelToDateTimeObject($row[4])),
                    'cantidad'=> $row[5]
                   
                ]);
            }
        }
}