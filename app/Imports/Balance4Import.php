<?php

namespace App\Imports;

use App\Models\Balancemasacuatro;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

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
                        'Sales_date' => $row[0],
                        'Arrival_Date' => $row[1],
                        'N_Pallet' => $row[2],
                        'Variedad' => strtoupper($row[3]),
                        'Etiqueta' => $row[4],
                        'Calibre_y_Color' => $row[5],
                        'Cajas' => $row[6],
                        'Precio_Venta_Yen' => $row[7],
                        'Total_Venta' => $row[8],
                        'Contenedor' => $row[9],
                        'PESO_TOTAL' => $row[10],
                        'CAJAS_DESPACHADAS' => $row[11],
                        'DIF' => $row[12],
                        'PESO_CAJA' => $row[13],
                        'COLOR' => $row[14],
                        'SIG_COLOR' => $row[15],
                        'CALIBRE' => $row[16],
                        'TC' => $row[17],
                        'VENTA_USD' => $row[18],
                        'COMISION' => $row[19],
                        'FLETE' => $row[20],
                        'OTROS_GASTOS' => $row[21],
                        'Apoyo_Liquidaciones' => $row[22],
                        'LIQ_CLIENTE' => $row[23],
                        'PROMOCION_ASOEX' => $row[24],
                        'SEGURO_CARGA' => $row[25],
                        'LIQ_PRODUCTOR' => $row[26],
                        'RETORNO_PRODUCTOR_ESTIMADO' => $row[27],
                        'NAVE' => $row[28],
                        'CLIENTE' => $row[29],
                        'PAIS' => $row[30],
                        'MERCADO' => $row[31],
                        'UNIR_CADE' => $row[32],
                        'semana' => $row[33],
                    ]);
                
            }
        }
}
