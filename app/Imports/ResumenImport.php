<?php

namespace App\Imports;

use App\Models\Resumen;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpParser\Node\Stmt\TryCatch;

class ResumenImport implements ToCollection, WithStartRow
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
                 Resumen::create([ 
                    'temporada_id'=>$this->temporada,
                    'especie'=> $row[0],
                    'variedad'=> $row[1],
                    'serie'=> $row[2],
                    'color'=> $row[3],
                    'cat'=> $row[4],
                    'cajas'=> $row[5],
                    'cajas_proceso'=> $row[6],
                    'kg_salida'=> $row[7],
                    'total_kg'=> $row[8],
                    'suma_de_dif'=> $row[9],
                    'rpn_kg'=> $row[10],
                    'rpn'=> $row[11],
                    'rpn_kg2'=> $row[12],
                    'rpn2'=> $row[13],
                    'suma_ret2'=>$row[14],
                    'suma_ret2_kg'=>$row[15],
                    'suma_rpn'=>$row[16],

                    'suma_rpn_kg3'=> $row[17],
                    'suma_rpn3'=> $row[18],
                    'suma_rpn_kg4'=> $row[19],
                    'suma_rpn4'=> $row[20]
                ]);
          
            }
        }
}
