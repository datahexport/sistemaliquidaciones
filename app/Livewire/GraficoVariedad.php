<?php

namespace App\Livewire;

use App\Models\Proceso;
use App\Models\Temporada;
use App\Models\Variedad;
use Livewire\Attributes\Url;
use Livewire\Component;

class GraficoVariedad extends Component
{   public $temporada, $variedad;

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
        'ispropio'=>true,
        'nopropio'=>true,
        'mie'=>'',
        'mn'=>'',
        'calibre'=>'',
        'etiqueta'=>'',
        'material'=>'',
        'mi'=>'',
        'semana'=>'',
        'norma'=>'',
        'fnorma'=>'',
        'tipo'=>'',
        'variedad2'=>'',
        'folio'
      
    ];

    public function mount(Temporada $temporada, $variedad){
        $this->temporada=$temporada;
        $this->variedad=Variedad::find($variedad);
        $this->filters['variedad']=$this->variedad->name;
    }

    public function render()
    {   
        $unique_variedades = Variedad::where('temporada_id',$this->temporada->id)->get();

        $unique_calibres = ['4J','3J','2J','J','XL','L'];

        $masastotal=Proceso::select([
                'PESO_PRORRATEADO',
                'CRITERIO',
                'CALIBRE_REAL',
                'SEMANA',
                'PRODUCTOR_RECEP_FACTURACION',
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
        $unique_semanas = $masastotal->pluck('SEMANA')->unique()->sort();

        return view('livewire.grafico-variedad',compact('unique_variedades','unique_calibres','unique_semanas','masastotal'));
    }
}
