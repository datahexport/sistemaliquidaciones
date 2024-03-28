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
                    'id_check' => $row[0],
                    
                    
                    'n_familia_rotulacion' => $row[1],
                    'id_especie_rotulacion' => $row[2],
                    'c_especie_rotulacion' => $row[3],
                    'n_especie_rotulacion' => $row[4],
                    'id_variedad_rotulacion' => $row[5],
                    'c_variedad_rotulacion' => $row[6],
                    'n_variedad_rotulacion' => $row[7],
                    'id_empresa' => $row[8],
                    'ngd_recepcion' => $row[9],
                    'fecha_documento' => $row[10],
                    'fecha_documento_sh' => $row[11],
                    'id_linea_proceso' => $row[12],
                    'c_linea_proceso' => $row[13],
                    'n_linea_proceso' => $row[14],
                    'numero_gruia_recepcion' => $row[15],
                    'fecha_recepcion' => $row[16],
                    'id_turno' => $row[17],
                    'n_turno' => $row[18],
                    'id_tipo_proceso' => $row[19],
                    'n_tipo_proceso' => $row[20],
                    'id_condicion' => $row[21],
                    'c_condicion' => $row[22],
                    'n_condicion' => $row[23],
                    'id_grupo_proceso' => $row[24],
                    'c_grupo_proceso' => $row[25],
                    'n_grupo_proceso' => $row[26],
                    'peso_equivalente' => $row[27],
                    'id_cliente_packing' => $row[28],
                    'r_cliente_packing' => $row[29],
                    'c_cliente_packing' => $row[30],
                    'n_cliente_packing' => $row[31],
                    'fecha_cosecha_sf' => $row[32],
                    'fecha_produccion_sf' => $row[33],
                    'ngi_recepcion' => $row[34],
                    'creacion_tipo' => $row[35],
                    'c_marca' => $row[36],
                    'n_marca' => $row[37],
                    'id_variedad_comercial' => $row[38],
                    'c_variedad_comercial' => $row[39],
                    'n_variedad_comercial' => $row[40]
                    
                   
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
