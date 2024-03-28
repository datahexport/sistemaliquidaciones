<?php

namespace App\Imports;

use App\Models\CostoPacking;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class PackingImport implements ToCollection, WithStartRow
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
                 CostoPacking::create([ 
                    'temporada_id'=>$this->temporada,

                    'cliente'=> $row[0],
                    'especie'=> $row[1],
                    'n_productor'=> $row[2],
                    'csg'=> $row[3],
                    'kg'=> $row[4],
                    'total_usd'=> $row[5],
                    
                ]);
          
            }
        }
}
