<?php

namespace App\Imports;

use App\Models\Razonsocial;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ProductorImport implements ToCollection, WithStartRow
    {  
       
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
                if($row[0]){
                    Razonsocial::firstOrCreate(
                        ['name' => $row[0]], // Busca solo por el nombre
                        [
                            'name' => $row[0], // Si no existe, usa name
                            'rut'  => $row[1], // Asigna rut
                            'csg'  => $row[2], // Asigna csg
                        ]
                    );
                }
                

            }
        }
}