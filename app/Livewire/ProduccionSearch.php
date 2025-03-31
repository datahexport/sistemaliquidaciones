<?php

namespace App\Livewire;

use App\Models\Proceso;
use App\Models\Razonsocial;
use App\Models\Temporada;
use App\Models\Variedad;
use Livewire\Attributes\Url;
use Livewire\Component;

class ProduccionSearch extends Component
{   public $temporada;

    #[Url(history: true)]
    public $filters=[
        'exportadora'=>'',
        'razonsocial'=>'',
        'especie'=>'',
        'variedad'=>'',
        'fromNumber'=>'',
        'toNumber'=>'',
        'fromDate'=>'',
        'toDate'=>'',
        'precioFob'=>'',
        'ncategoria'=>'',
        'exp'=>true,
        'com'=>true,
        'comem'=>true,
        'mie'=>'',
        'mn'=>'',
        'calibre'=>'',
        'etiqueta'=>'',
        'material'=>'',
        'mi'=>'',
        'semana'=>'',
        'embalaje'=>'',
        'norma'=>'',
        'fnorma'=>'',
        'tipo'=>'',
    ];

    public function mount(Temporada $temporada){
        $this->temporada=$temporada;
    }

    public function render()
    {   $procesos=Proceso::filter($this->filters)->where('temporada_id',$this->temporada->id)->paginate(250);
        $procesosall = Proceso::select([
                'PESO_PRORRATEADO',
                'CRITERIO',
                'PESO_CAJA',
                'PRODUCTOR_RECEP_FACTURACION',
                'VARIEDAD',
                'costo_proceso',
                'costo_materiales',
                'otros_costos',
                'gastos',
                'costo',
                'anticipos',
                'fob_id' // Incluimos el fob_id para la relación
            ])
            ->with([
                'fob' => function($query) {
                    $query->select('id', 'fob_kilo_salida')->with([
                        'tarifas' => function($query) {
                            $query->select('id', 'fob_id', 'tarifa_fc', 'tarifa');
                        }
                    ]);
                }
            ])
            ->where('temporada_id', $this->temporada->id)
            ->filter($this->filters)
            ->get();
        
        

        $procesosall2=Proceso::select([
            'TIPO',
            'especie',
            'VARIEDAD',
            'CALIBRE_REAL',
            'SEMANA'
        ])->where('temporada_id',$this->temporada->id)->get();

        $unique_tipos = $procesosall2->pluck('TIPO')->unique()->sort();

        
        $unique_especies = $procesosall2->pluck('especie')->unique()->sort();

      

        $unique_variedades = $procesosall->pluck('VARIEDAD')->unique()->sort();

        $unique_calibres = $procesosall2->pluck('CALIBRE_REAL')->unique()->sort();

        $unique_semanas = $procesosall2->pluck('SEMANA')->unique()->sort();

        $razons=Razonsocial::all();

        return view('livewire.produccion-search',compact('razons','unique_tipos','procesos','procesosall','procesosall2','unique_especies','unique_variedades','unique_calibres','unique_semanas'));
    }
}
