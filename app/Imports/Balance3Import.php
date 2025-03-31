<?php

namespace App\Imports;

use App\Models\Balancemasatres;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class Balance3Import implements ToCollection, WithStartRow, WithChunkReading, WithBatchInserts
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

        public function chunkSize(): int
        {
            return 300; // Puedes probar 1000 o más si tu servidor lo aguanta
        }
    
        public function batchSize(): int
        {
            return 300;
        }

        public function collection($rows)
        {  
            foreach($rows as $row){
                Balancemasatres::create([
                    'temporada_id' => $this->temporada,
                   
                    'Temporada' => $row[0],
                    'Estado' => $row[1],
                    'Packing' => $row[2],
                    'Folio' => $row[3],
                    'N_GuiaSII_Rec' => $row[4],
                    'N_lote' => $row[5],
                    'Peido' => $row[6],
                    'Fecha_Emb' => $row[7],
                    'Cliente' => $row[8],
                    'CSG' => $row[9],
                    'Csg_Rot' => $row[10],
                    'Nombre_Huerto' => $row[11],
                    'Nombre_CSG_Rot' => $row[12],
                    'Nombre_Productor' => $row[13],
                    'Etiqueta' => $row[14],
                    'C_Envase' => $row[15],
                    'Envase' => $row[16],
                    'Especie' => $row[17],
                    'Variedad_Real' => $row[18],
                    'Variedad_Rot' => $row[19],
                    'Categoria' => $row[20],
                    'Calidad' => $row[21],
                    'Calibre' => $row[22],
                    'Cajas_INICIAL' => $row[23],
                    'Dif_Cajas' => $row[24],
                    'Cajas' => $row[25],
                    'Cajas_Pallet' => $row[26],
                    'Kilos_INICIAL' => $row[27],
                    'Dif_Kilos_proc' => $row[28],
                    'Kilos_prod' => $row[29],
                    'Kilos_emb' => $row[30],
                    'Proceso' => $row[31],
                    'Tipo_Pallet' => $row[32],
                    'Base_Pallet' => $row[33],
                    'Altura' => $row[34],
                    'C_Packing' => $row[35],
                    'C_Variedad_real' => $row[36],
                    'C_Variedad_Rot' => $row[37],
                    'C_Categoria' => $row[38],
                    'C_Cliente' => $row[39],
                    'C_Etiqueta' => $row[40],
                    'C_Especie' => $row[41],
                    'C_Recibidor' => $row[42],
                    'C_Mercado' => $row[43],
                    'Nave' => $row[44],
                    'Fecha_Salida' => Carbon::instance(Date::excelToDateTimeObject($row[45])),
                    'Exportador' => $row[46],
                    'Mercado' => $row[47],
                    'Despacho' => $row[48],
                    'Folio_Sag' => $row[49],
                    'Fecha_despacho' => Carbon::instance(Date::excelToDateTimeObject($row[50])),
                    'Recibidor_comprador' => $row[51],
                    'Numero_Inspeccion' => $row[53],
                    'Fecha_Inspeccion' => Carbon::instance(Date::excelToDateTimeObject($row[54])),
                    'Estado_Inspeccion' => $row[55],
                    'Guia_sii' => $row[56],
                    'Contenedor' => $row[57],
                    'Peso_Neto' => $row[58],
                    'Peso_Bruto' => $row[59],
                    'Fecha_Digitacion' => Carbon::instance(Date::excelToDateTimeObject($row[60])),
                    'N_Reserva' => $row[61],
                    'Fecha_Reserva' => Carbon::instance(Date::excelToDateTimeObject($row[62])),
                    'Planta' => $row[63],
                    'planta_despacho' => $row[64],
                    'liquidado' => $row[65],
                    'liq_real' => $row[66],
                    'liquidacion_ajuste' => $row[67],
                    'venta' => $row[68],
                    'retorno_productor' => $row[69],
                    'kg_liq' => $row[70],
                    'fob2' => $row[71],
                    'npk' => $row[72],
                    'fob_x_caja' => $row[73],
                    'ajuste_kilos' => $row[74],
                    'ajuste_final' => $row[75],
                    'semana' => $row[76],
                    'variedad_real2' => $row[77],
                    'calibre_real' => $row[78],
                    'productor_real' => $row[79],
                    'busqueda_proceso' => $row[80],
                    'observacion' => $row[81],
                    'cliente_china' => $row[82],
                    'transporte' => $row[83],
                    'mercado2' => $row[84],
                    'productor_facturacion' => $row[85],
                    'csg_fact' => $row[86],
                    'obs' => $row[87],
                    'unir_cad' => $row[88],
                    'caja_desp' => $row[89],
                    'comision' => $row[90],
                    'otros_costos' => $row[91],
                    'materiales' => $row[92],
                    'proceso2' => $row[93],
                    'tipo' => $row[94],


                    
                   
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
