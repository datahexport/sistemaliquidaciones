<?php

namespace App\Imports;

use App\Models\Balancemasacuatro;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class Balance4Import implements ToCollection, WithStartRow
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
                Balancemasacuatro::create([
                    'temporada_id' => $this->temporada,
                    'id_check' => $row[0],
                    
                    'orden_interno_calibre' => $row[1],
                    'c_bodega_origen' => $row[2],
                    'n_bodega_origen' => $row[3],
                    'numero_trabajores' => $row[4],
                    'hora_termino' => $row[5],
                    'hora_inicio' => $row[6],
                    'horas_efectivas' => $row[7],
                    'c_recibidor' => $row[8],
                    'r_packing_origen' => $row[9],
                    'n_packing_origen' => $row[10],
                    'ns_packing_origen' => $row[11],
                    'c_packing_origen' => $row[12],
                    'nota_calidad' => $row[13],
                    'tratamiento' => $row[14],
                    'kg_aditivos' => $row[15],
                    'n_docaditivo' => $row[16],
                    'c_aditivo' => $row[17],
                    'n_aditivo' => $row[18],
                    'referencias' => $row[19],
                    'notas' => $row[20],
                    'csg' => $row[21],
                    'csg_productor' => $row[22],
                    'estado' => $row[23],
                    'id_marca_etiqueta' => $row[24],
                    'c_marca_etiqueta' => $row[25],
                    'n_marca_etiqueta' => $row[26],
                    'loter_unitec' => $row[27]
                                        
                ]);
                
            }
        }
}
