<?php

namespace App\Imports;

use App\Models\Comision;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ComisionImport implements ToCollection, WithStartRow
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
                 Comision::create([ 
                    'temporada_id'=>$this->temporada,

                    'productor'=> $row[1],
                    'comision'=> $row[2]
                    
                    /*'flete_huerto'=> $row[3],
                    'minimo_garantizado'=> $row[4],
                    'rebate'=> $row[5],
                    'tarifa_premium'=> $row[6],
                    'comparativa'=> $row[7],
                    'descuento_fruta_comercial'=> $row[8],
                    'cumplimiento'=> $row[9]*/
                ]);
            }
        }
}