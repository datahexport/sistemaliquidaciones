<?php

namespace App\Imports;

use App\Models\Exportacion;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ExportacionImport implements ToCollection, WithStartRow
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
            return 6;
        }

        public function collection($rows)
        {   $n=0;
            if ($n<3) {
                foreach($rows as $row){
                    Exportacion::create([ 
                       'temporada_id'=>$this->temporada,
                       'type'=> $row[7],
                       'precio_usd'=> $row[12]
                   ]);
               }
               $n+=1;
            }
           
        }
}