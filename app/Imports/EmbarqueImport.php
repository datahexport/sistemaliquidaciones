<?php

namespace App\Imports;

use App\Models\Embarque;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class EmbarqueImport implements ToCollection, WithStartRow
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
                 Embarque::create([ 
                    'temporada_id'=>$this->temporada,

                    't_contenedor' => $row[0],
                    'n_destinatario' => $row[1],
                    'etd' => $row[2],
                    'eta' => $row[3],
                    'semana_zarpe' => $row[4], // Cambiado a 'semana_zarpe' para que coincida con la migración anterior
                    'semana_arribo' => $row[5],
                    'n_pais_destino' => $row[6],
                    'n_embarque' => $row[7],
                    'folio' => $row[8],
                    'r_productor' => $row[9],
                    'c_proveedor' => $row[10], // Cambiado a 'c_proveedor' para que coincida con la migración anterior
                    'n_productor' => $row[11],
                    'booking' => $row[12],
                    'n_puerto_origen' => $row[13],
                    'n_puerto_destino' => $row[14],
                    'n_nave' => $row[15],
                    'transporte' => $row[16],
                    'fecha_despacho' => $row[17],
                    'n_exportadora_embarque' => $row[18]
                   
                ]);
            }
        }
}