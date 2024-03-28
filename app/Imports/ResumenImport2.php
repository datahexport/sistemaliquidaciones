<?php

namespace App\Imports;

use App\Models\Resumen;
use Maatwebsite\Excel\Concerns\ToModel;

class ResumenImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Resumen([ 
            'especie'=> $row[0],
            'variedad'=> $row[1],
            'serie'=> $row[2],
            'color'=> $row[3],
            'cat'=> $row[4],
            'cajas'=> $row[5],
            'cajas_proceso'=> $row[6],
            'kg_salida'=> $row[7],
            'total_kg'=> $row[8],
            'suma_de_dif'=> $row[9],
            'rpn_kg'=> $row[10],
            'rpn'=> $row[11],
            'rpn_kg2'=> $row[12],
            'rpn2'=> $row[13],
            'suma_rpn_kg3'=> $row[14],
            'suma_rpn3'=> $row[15],
            'suma_rpn_kg4'=> $row[16],
            'suma_rpn4'=> $row[17],
        ]);
    }
}
