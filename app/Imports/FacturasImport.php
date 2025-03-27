<?php

namespace App\Imports;

use App\Models\Factura;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class FacturasImport implements ToCollection, WithStartRow
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
                if(isset($row[6]) && isset($row[14])){
                    Factura::create([
                        'temporada_id' => $this->temporada,

                        'productor' => $row[0],
                        'mes_contabilizacion' => $row[1],
                        'tipo_docto' => $row[2],
                        'no_docto' => $row[3],
                        'monto_neto' => $row[4],
                        'iva' => $row[5],
                        'total' => $row[6],
                        'fecha' => Carbon::instance(Date::excelToDateTimeObject($row[7])),
                        'orden' => $row[8],
                        'busqueda' => $row[9],
                        'grupo' => $row[10],
                        'fecha_pago' => Carbon::instance(Date::excelToDateTimeObject($row[11])),
                        'neto' => $row[12],
                        'iva2' => $row[13],
                        'total2' => $row[14],
                        'saldo' => $row[15],
                        'tc' => $row[16], // Tasa de cambio
                        'cantidad' => $row[17],
                        'usd_kg' => $row[18], // Precio por kilogramo en USD
                        'dolares' => $row[19],
                        'valor' => $row[20],
                      

                    ]);
                }
                
            }
        }
}
