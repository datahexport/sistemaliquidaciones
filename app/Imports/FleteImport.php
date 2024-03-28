<?php

namespace App\Imports;

use App\Models\Flete;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class FleteImport implements ToCollection, WithStartRow
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
                 Flete::create([ 
                    'temporada_id'=>$this->temporada,

                    'grupo'=> $row[0],
                    'rut'=> $row[1],
                    'productor'=> $row[2],
                    'tarifa'=> $row[3]
                ]);
            }
        }
}