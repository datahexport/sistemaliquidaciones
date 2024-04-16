<?php

namespace App\Imports;

use App\Models\Anticipo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Date;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date as SharedDate;

class AnticipoImport implements ToCollection, WithStartRow
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
                 Anticipo::create([ 
                    'temporada_id'=>$this->temporada,

                    'grupo'=> $row[0],
                    'rut'=> preg_replace('/[\.\-\s]+/', '', $row[1]),
                    'n_productor'=> $row[2],
                    'fecha'=>  Carbon::instance(SharedDate::excelToDateTimeObject($row[3])),
                    'cantidad'=> floatval($row[4])
                
                ]);
            }
        }
}
