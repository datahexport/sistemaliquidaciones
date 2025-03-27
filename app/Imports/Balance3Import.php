<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class Balance3Import implements ToCollection, WithStartRow, WithChunkReading, WithBatchInserts
{
    protected $temporada;

    public function __construct($temporada)
    {
        $this->temporada = $temporada;
    }

    public function startRow(): int
    {
        return 2;
    }

    public function chunkSize(): int
    {
        return 500; // Puedes probar 1000 o más si tu servidor lo aguanta
    }

    public function batchSize(): int
    {
        return 500;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            try {
                Balancemasatres::create([
                    'temporada_id' => $this->temporada,
                    'Temporada' => $row[0],
                    'Estado' => $row[1],
                    // ...
                    'Fecha_Salida' => $this->parseExcelDate($row[45]),
                    // ...
                    'Fecha_despacho' => $this->parseExcelDate($row[50]),
                    // ...
                    'Fecha_Inspeccion' => $this->parseExcelDate($row[54]),
                    // ...
                    'Fecha_Digitacion' => $this->parseExcelDate($row[60]),
                    'Fecha_Reserva' => $this->parseExcelDate($row[62]),
                    // ...
                ]);
            } catch (\Exception $e) {
                // Puedes loguear o manejar errores por fila si quieres
                \Log::error("Error al importar fila: ".$e->getMessage());
            }
        }
    }

    private function parseExcelDate($excelValue)
    {
        return $excelValue ? Carbon::instance(Date::excelToDateTimeObject($excelValue)) : null;
    }
}
