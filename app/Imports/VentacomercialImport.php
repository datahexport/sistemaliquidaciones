<?php

namespace App\Imports;

use App\Models\Ventacomercial;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class VentacomercialImport implements ToCollection, WithStartRow
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
                    Ventacomercial::create([
                        'temporada_id' => $this->temporada,
                        'fecha' => Carbon::instance(Date::excelToDateTimeObject($row[0])), // Fecha de la venta
                        'cliente' => $row[1], // Nombre del cliente
                        'cantidad_kilos' => $row[2], // Cantidad en Kilos
                        'cajas' => $row[3], // Número de cajas
                        'tipo' => $row[4], // Tipo de venta
                        'descripcion' => $row[5], // Descripción de la venta
                        'precio_unitario' => $row[6], // Precio Unitario
                        'total_iva_incluido' => $row[7], // Total con IVA incluido
                        'condicion_de_pago' => $row[8], // Condición de pago
                        'neto' => $row[9], // Neto
                        'iva' => $row[10], // IVA
                        'tc' => $row[11], // Tipo de cambio (TC)
                        'venta_usd' => $row[12], // Venta en USD
                        'semana' => $row[13], // Semana de la venta
                    ]);
               
                
            }
        }
}