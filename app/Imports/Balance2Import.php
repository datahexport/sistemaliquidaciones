<?php

namespace App\Imports;

use App\Models\Balancemasa;
use App\Models\Balancemasados;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class Balance2Import implements ToCollection, WithStartRow
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
                Balancemasados::create([
                    'temporada_id' => $this->temporada,
                    'id_check' => $row[0],
                    'c_variedad' => $row[1],
                    'n_variedad' => $row[2],
                    'id_embalaje' => $row[3],
                    'c_embalaje' => $row[4],
                    'n_embalaje' => $row[5],
                    'cp1' => $row[6],
                    'cp2' => $row[7],
                    'peso_std_embalaje' => $row[8],
                    'peso_standard' => $row[9],
                    'id_contenedor' => $row[10],
                    'c_contenedor' => $row[11],
                    'n_contenedor' => $row[12],
                    'id_categoria' => $row[13],
                    'c_categoria' => $row[14],
                    'n_vategoria' => $row[15],
                    't_categoria' => $row[16],
                    'id_categoria_st' => $row[17],
                    'n_categoria_st' => $row[18],
                    'id_calibre' => $row[19],
                    'c_calibre' => $row[20],
                    'n_calibre' => $row[21],
                    'id_serie' => $row[22],
                    'c_serie' => $row[23],
                    'n_serie' => $row[24],
                    'id_etiqueta' => $row[25],
                    'c_etiqueta' => $row[26],
                    'n_etiqueta' => $row[27],
                    'id_plu' => $row[28],
                    'c_plu' => $row[29],
                    'n_plu' => $row[30],
                    'cantidad' => $row[31],
                    'peso_neto' => $row[32],
                    'id_productor_rotulacion' => $row[33],
                    'r_productor_rotulacion' => $row[34],
                    'c_productor_rotulacion' => $row[35],
                    'n_productor_rotulacion' => $row[36],
                    'ns_productor_rotulacion' => $row[37],
                    'cp1_productor_rotulacion' => $row[38],
                    'id_familia_rotulacion' => $row[39],
                    'c_familia_rotulacion' => $row[40]

                    
                    /*
                     'n_familia_rotulacion' => $row[80],
                    'id_especie_rotulacion' => $row[81],
                    'c_especie_rotulacion' => $row[82],
                    'n_especie_rotulacion' => $row[83],
                    'id_variedad_rotulacion' => $row[84],
                    'c_variedad_rotulacion' => $row[85],
                    'n_variedad_rotulacion' => $row[86],
                    'id_empresa' => $row[87],
                    'ngd_recepcion' => $row[88],
                    'fecha_documento' => $row[89],
                    'fecha_documento_sh' => $row[90],
                    'id_linea_proceso' => $row[91],
                    'c_linea_proceso' => $row[92],
                    'n_linea_proceso' => $row[93],
                    'numero_gruia_recepcion' => $row[94],
                    'fecha_recepcion' => $row[95],
                    'id_turno' => $row[96],
                    'n_turno' => $row[97],
                    'id_tipo_proceso' => $row[98],
                    'n_tipo_proceso' => $row[99],
                    'id_condicion' => $row[100],
                    'c_condicion' => $row[101],
                    'n_condicion' => $row[102],
                    'id_grupo_proceso' => $row[103],
                    'c_grupo_proceso' => $row[104],
                    'n_grupo_proceso' => $row[105],
                    'peso_equivalente' => $row[106],
                    'id_cliente_packing' => $row[107],
                    'r_cliente_packing' => $row[108],
                    'c_cliente_packing' => $row[109],
                    'n_cliente_packing' => $row[110],
                    'fecha_cosecha_sf' => $row[111],
                    'fecha_produccion_sf' => $row[112],
                    'ngi_recepcion' => $row[113],
                    'creacion_tipo' => $row[114],
                    'c_marca' => $row[115],
                    'n_marca' => $row[116],
                    'id_variedad_comercial' => $row[117],
                    'c_variedad_comercial' => $row[118],
                    'n_variedad_comercial' => $row[119],
                    'orden_interno_calibre' => $row[120],
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

