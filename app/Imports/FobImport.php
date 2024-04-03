<?php

namespace App\Imports;

use App\Models\Fob;
use App\Models\Fobnacional;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class FobImport implements ToCollection, WithStartRow
    {   protected $temporada,$type;

        public function __construct($temporada,$type)
        {
            $this->temporada = $temporada;
            $this->type = $type;
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
                if ($this->type=='nacional') {
                     Fobnacional::create([ 
                        'temporada_id'=>$this->temporada,

                        'n_variedad'=> $row[0],
                        'semana'=> trim($row[1]),
                        'etiqueta'=> trim($row[2]),
                        'n_calibre'=> trim($row[3]),
                        'color'=> trim($row[4]),
                        'categoria'=> trim($row[5]),
                        'fob_kilo_salida'=> $row[6]
                    
                    ]);
                } else {
                     Fob::create([ 
                        'temporada_id'=>$this->temporada,

                        'n_variedad'=> $row[0],
                        'semana'=> trim($row[1]),
                        'etiqueta'=> trim($row[2]),
                        'n_calibre'=> trim($row[3]),
                        'color'=> trim($row[4]),
                        'categoria'=> trim($row[5]),
                        'fob_kilo_salida'=> $row[6]
                    
                    ]);
                }
                
                

            }
        }
}