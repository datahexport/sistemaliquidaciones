<?php

namespace App\Exports;

use App\Models\Fob;
use App\Models\Temporada;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PrecioOriginalExport implements FromCollection, WithCustomStartCell, WithMapping, WithHeadings, ShouldAutoSize
{   use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    private $temporada;

    public function __construct($temporada_id) {
        $this->temporada = Temporada::find($temporada_id);
    }

    public function collection()
    {
        return Fob::where('temporada_id',$this->temporada->id)->get();
    }

    public function startCell(): string
    {
        return 'A1';
    }
    public function headings(): array
    {    if ($this->temporada->precios->count()>0){
            return[
                'Variedad',
                'Semana', 
                'Calibre',
                'Suma Fob',
                'Suma KG',
                'Tarifa',
                'Suma Fob P.Promedio',
                'Suma KG P.Promedio',
                'Tarifa P.Promedio',
                'Suma Costos',
                'Tarifa',
                'tarifa_fc',
                'suma_fob',
                'suma_fob_fc',
                'cant_kg',
                'costo_proceso',
                'costo_materiales',
                'otros_costos'

            ];
        }else{
                return[
                    'Variedad',
                    'Semana', 
                    'Calibre',
                    'Suma Fob',
                    'Suma KG',
                    'Promedio'
                ];
            }
    }

    public function map($fob): array
    {   if ($this->temporada->precios->count()>0){
            return [
                $fob->n_variedad,
                $fob->semana,
                $fob->n_calibre,
                round($fob->suma_fob,2),
                round($fob->cant_kg,2),
                round($fob->fob_kilo_salida,2),
                round($fob->tarifas->first()->suma_fob,2),
                round($fob->tarifas->first()->cant_kg,2),
                round($fob->tarifas->first()->tarifa,2),
                round(($fob->tarifas->first()->costo_proceso+$fob->tarifas->first()->costo_materiales+$fob->tarifas->first()->otros_costos),2),
                round($fob->tarifas->reverse()->first()->tarifa,2),
                round($fob->tarifas->reverse()->first()->tarifa_fc,2),
                round($fob->tarifas->reverse()->first()->suma_fob,2),
                round($fob->tarifas->reverse()->first()->suma_fob_fc,2),
                round($fob->tarifas->reverse()->first()->cant_kg,2),
                round($fob->tarifas->reverse()->first()->costo_proceso,2),
                round($fob->tarifas->reverse()->first()->otros_costos,2)
                
            ];
        }else{
            return [
                $fob->n_variedad,
                $fob->semana,
                $fob->n_calibre,
                round($fob->suma_fob,2),
                round($fob->cant_kg,2),
                round($fob->fob_kilo_salida,2),
            ];
        }
    }
    
}

