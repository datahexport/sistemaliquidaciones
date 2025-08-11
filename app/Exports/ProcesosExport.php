<?php

namespace App\Exports;

use App\Models\Proceso;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProcesosExport implements FromCollection, WithHeadings, WithMapping
{
    protected $procesos;

    public function __construct($procesos)
    {
        $this->procesos = $procesos;
    }

    public function collection()
    {
        return $this->procesos;
    }

    public function headings(): array
    {
        return [
            'PROCESO', 'TURNO', 'PLANTA', 'FECHA', 'PRODUCTOR_RECEP_FACTURACION',
            'VARIEDAD', 'ENVASES_ETIQ', 'COLOR', 'CALIBRE', 'CALIBRE_REAL', 'CANT',
            'PESO_FINAL', 'PESO_PRORRATEADO', 'KG_VACIADO', 'PESO_CAJA', 'TIPO_CAJA',
            'CAJA_EQ_5KG', 'TIPO', 'CRITERIO', 'COLOR_FINAL', 'BUSQUEDA_PROCESO',
            'EXPORTADORA', 'NORMA', 'SEMANA',
            'LIQUIDACIÓN', 'LIQUIDACIÓN FINAL', 'COSTO', 'CAJA DIFERENCIAL',
            'OTROS GASTOS', 'COSTO PROCESO', 'COSTO MATERIALES', 'GASTOS', 'RNP'
        ];
    }

    public function map($masa): array
    {
        // Calcula valores como en la vista Blade
        $liquidacion = null;
        $liquidacionFinal = null;

        if ($masa->fob) {
            $peso = floatval($masa->PESO_PRORRATEADO);

            $liquidacion = $masa->fob->fob_kilo_salida * $peso;

            $ultimaTarifa = $masa->fob->tarifas->sortByDesc('created_at')->first();

            if ($ultimaTarifa) {
                $tarifa = $masa->CRITERIO === 'COMERCIAL'
                    ? $ultimaTarifa->tarifa
                    : $ultimaTarifa->tarifa_fc;

                $liquidacionFinal = $tarifa * $peso;
            }
        }

        return [
            $masa->PROCESO,
            $masa->TURNO,
            $masa->PLANTA,
            $masa->FECHA,
            $masa->PRODUCTOR_RECEP_FACTURACION,
            $masa->VARIEDAD,
            $masa->ENVASES_ETIQ,
            $masa->COLOR,
            $masa->CALIBRE,
            $masa->CALIBRE_REAL,
            $masa->CANT,
            $masa->PESO_FINAL,
            $masa->PESO_PRORRATEADO,
            $masa->KG_VACIADO,
            $masa->PESO_CAJA,
            $masa->TIPO_CAJA,
            $masa->CAJA_EQ_5KG,
            $masa->TIPO,
            $masa->CRITERIO,
            $masa->COLOR_FINAL,
            $masa->BUSQUEDA_PROCESO,
            $masa->EXPORTADORA,
            $masa->NORMA,
            $masa->SEMANA,

            // Columnas extra personalizadas
            $liquidacion ? number_format($liquidacion, 2) : '',
            $liquidacionFinal ? number_format($liquidacionFinal, 7,',','') : '',
            $masa->costo ?? '',
            $masa->caja_diferencial ?? '',
            $masa->otros_gastos ?? '',
            $masa->costo_proceso ?? '',
            $masa->costo_materiales ?? '',
            $masa->gastos ?? '',
            $masa->rnp ?? '',
        ];
    }
}