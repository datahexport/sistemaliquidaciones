<?php

namespace App\Imports;

use App\Models\Balancemasatres;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class Balance3Import implements ToCollection, WithStartRow
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
                Balancemasatres::create([
                    'temporada_id' => $this->temporada,
                   
                    'dest_nombre' => $row[0],
                    'fecha' => $row[1],
                    'traspaso' => $row[2],
                    'folio' => $row[3],
                    'CSG' => $row[4],
                    'prod_nombre' => $row[5],
                    'cli_nombre' => $row[6],
                    'Variedad_Real' => $row[7],
                    'Variedad_Rotulada' => $row[8],
                    'cate_nombre' => $row[9],
                    'enva_nombre' => $row[10],
                    'fec_emb' => $row[11],
                    'eti_nombre' => $row[12],
                    'calibre' => $row[13],
                    'Cajas' => $row[14],
                    'procesor' => $row[15],
                    'procesor2' => $row[16],
                    'kilos' => $row[17],
                    'guiasii' => $row[18],
                    'enva_id' => $row[19],

                    
                   
                    /* 'orden_interno_calibre' => $row[120],
                    'c_bodega_origen' => $row[121],
                    'n_bodega_origen' => $row[122],
                    'numero_trabajores' => $row[123],
                    'hora_termino' => $row[124],
                    'hora_inicio' => $row[125],
                    'horas_efectivas' => $row[126],
                    'c_recibidor' => $row[127],
                    'r_packing_origen' => $row[128],
                    'n_packing_origen' => $row[129],
                    'ns_packing_origen' => $row[130],
                    'c_packing_origen' => $row[131],
                    'nota_calidad' => $row[132],
                    'tratamiento' => $row[133],
                    'kg_aditivos' => $row[134],
                    'n_docaditivo' => $row[135],
                    'c_aditivo' => $row[136],
                    'n_aditivo' => $row[137],
                    'referencias' => $row[138],
                    'notas' => $row[139],
                    'csg' => $row[140],
                    'csg_productor' => $row[141],
                    'estado' => $row[142],
                    'id_marca_etiqueta' => $row[143],
                    'c_marca_etiqueta' => $row[144],
                    'n_marca_etiqueta' => $row[145],
                    'loter_unitec' => $row[146],*/
                ]);
                
            }
        }
}
