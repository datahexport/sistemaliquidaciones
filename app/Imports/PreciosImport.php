<?php

namespace App\Imports;

use App\Models\Fob;
use App\Models\Precio;
use App\Models\Tarifaprecio;
use App\Models\TuModelo;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class PreciosImport implements ToCollection, WithStartRow
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
        {  $precio = Precio::firstOrCreate(
                ['name' => 'Precio Promedio', 'temporada_id' => $this->temporada->id],
                ['name' => 'Precio Promedio', 'temporada_id' => $this->temporada->id]
            );
            
            $precio2 = Precio::firstOrCreate(
                ['name' => 'Precio Ajustado', 'temporada_id' => $this->temporada->id],
                ['name' => 'Precio Ajustado', 'temporada_id' => $this->temporada->id]
            );
            foreach($rows as $row){
                    $fob=Fob::where('n_variedad',$row[0])->where('semana',$row[1])->where('n_calibre',$row[2])->where('temporada_id',$this->temporada->id)->first();
                   
                    Tarifaprecio::firstOrCreate([
                        'fob_id' => $fob->id,
                        'precio_id' => $precio->id,
                    ], [
                        'suma_fob' => $row[6],
                        'suma_fob_fc' => $row[3],
                        'cant_kg' => $row[4],
                        'tarifa' => $row[8],
                        'tarifa_fc' => $row[5],
                        'costo_proceso' => $row[15],
                        'costo_materiales' => $row[16],
                        'otros_costos' => $row[17],
                    ]);

                    // Crear el registro de Tarifaprecio si no existe ya para el segundo precio
                    Tarifaprecio::firstOrCreate([
                        'fob_id' => $fob->id,
                        'precio_id' => $precio2->id,
                    ], [
                        'suma_fob' => $row[12],
                        'suma_fob_fc' => $row[13],
                        'cant_kg' => $row[14],
                        'tarifa' => $row[10],
                        'tarifa_fc' => $row[11],
                        'costo_proceso' => $row[15],
                        'costo_materiales' => $row[16],
                        'otros_costos' => $row[17],
                    ]);

                 
                
            }
        }
}
