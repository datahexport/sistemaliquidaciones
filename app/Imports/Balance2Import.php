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
                    'Contenedor' => $row[0],
                    'Fecha' => $row[1],
                    'Nave' => $row[2],
                    'DESTINO' => $row[3],
                    'Cliente' => $row[4],
                    'Sales_City' => $row[5],
                    'Tipo' => $row[6],
                    'Total_Venta' => $row[7],
                    'Flete_Maritimo_AEREO' => $row[8],
                    'Impuestos' => $row[9],
                    'Entrada_al_Mercado' => $row[10],
                    'Costos_logisticos' => $row[11],
                    'Flete_interior' => $row[12],
                    'Costos_en_mercado' => $row[13],
                    'Ajuste_de_Impuestos' => $row[14],
                    'Costo_Extra' => $row[15],
                    'REBATE' => $row[16],
                    'MAERK' => $row[17],
                    'Comisiones' => $row[18],
                    'Comision' => $row[19],
                    'Costos_Totales' => $row[20],
                    'Tipo_de_Cambio' => $row[21],
                    'Liq_RMB' => $row[22],
                    'Liq_USD' => $row[23],
                    'Nuevo_TC' => $row[24],
                    'Ajuste_Dif_TC' => $row[25],
                    'Liquidacion_USD' => $row[26],
                    'TC_FINAL' => $row[27],
                    'Cant_Cajas' => $row[28],
                    'KG_CONTENEDOR' => $row[29],
                    'OTROS_GASTOS' => $row[30],
                    'OTROS_COSTOS_SIN_MAERSK' => $row[31],
                    'Mes_Facturacion' => $row[32],
                    'No_Factura' => $row[33],
                    'Otros_Costos' => $row[34],
                    'Liq_sin_Maersk' => $row[35],
                    'Columna1' => $row[36]

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

