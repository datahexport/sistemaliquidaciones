<?php

namespace App\Livewire;

use App\Models\Fob;
use App\Models\Proceso;
use App\Models\Tarifaprecio;
use App\Models\Temporada;
use App\Models\Variedad;
use App\Models\Ventacomercial;
use Livewire\Attributes\Url;
use Livewire\Component;

class GraficoVariedad extends Component
{   public $temporada, $variedad, $tarifaid, $tarifa;

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

    public function set_tarifaid($tarifaid){
        $this->tarifaid=$tarifaid;
        $this->tarifa=Tarifaprecio::find($tarifaid)->tarifa;
    }

    public function save_tarifaid(){
        $tarifa=Tarifaprecio::find($this->tarifaid);
        $this->tarifa=floatval(str_replace(',', '.', $this->tarifa));
        $tarifa->update(['tarifa'=>$this->tarifa]);  
        $procesos=Proceso::where('temporada_id',$this->temporada->id)
            ->whereIn('CRITERIO', ['EXPORTACIÓN', 'COMERCIAL EMBALADA'])
            ->get();
        
        $procesos_comercial=Proceso::where('temporada_id',$this->temporada->id)
            ->whereIn('TIPO', ['PRE-CALIBRE', 'COMERCIAL']) // Filtramos por TIPO
            ->get();

        $ventasall = Ventacomercial::where('temporada_id', $this->temporada->id)->get();

        $sumafob=0;
        $sumakg=0;
        $totalprocesos=0;
        $totalmateriales=0;
        $totalotroscostos=0;
        
        if ($tarifa->fob->n_variedad=='COMERCIAL') {

            foreach ($ventasall as $detalle) {
                if ($detalle->semana == $tarifa->fob->semana && $detalle->tipo==$tarifa->fob->n_calibre) {
                    // Determinar si es "Comercial" o "Precalibre"
                    $sumafob += $detalle->venta_usd; // Asumiendo que el valor FOB está en fob_value
                   
                }
            }

          
            foreach ($procesos_comercial as $masa) {
                if($masa->SEMANA==$tarifa->fob->semana && $masa->TIPO== $tarifa->fob->n_calibre){
                    $sumakg += floatval($masa->PESO_PRORRATEADO);
                }
            }

        } else {
            foreach ($procesos as $proceso) {
                if ($proceso->VARIEDAD == $tarifa->fob->n_variedad && 
                    $proceso->SEMANA == $tarifa->fob->semana && 
                    $proceso->CALIBRE_REAL == $tarifa->fob->n_calibre) {
                    if($proceso->fob){
                        // Sumar el valor FOB y el peso en kg
                        $sumafob += $this->tarifa*floatval($proceso->PESO_PRORRATEADO); // Asumiendo que el valor FOB está en fob_value
                    }
                    $sumakg += floatval($proceso->PESO_PRORRATEADO);    // Asumiendo que el peso está en peso_kg

                    $totalprocesos+=$proceso->costo_proceso;

                    $totalmateriales+=$proceso->costo_materiales;
                    $totalotroscostos+=$proceso->otros_costos;
                    
                }
            }
        }
        

        // Calcular la tarifa
      
        if ($tarifa->fob->n_calibre=="JUP") {
            // Crear el registro de Tarifaprecio
            $tarifa->update([
                'suma_fob' => $sumafob,
                'suma_fob_fc' => (($sumafob+$totalprocesos+$totalmateriales+$totalotroscostos)),
                'cant_kg' => $sumakg,
                'tarifa' => $this->tarifa,
                'tarifa_fc' => (($sumafob+$totalprocesos+$totalmateriales+$totalotroscostos))/$sumakg,
                'costo_proceso' => $totalprocesos,
                'costo_materiales' => $totalmateriales,
                'otros_costos' => $totalotroscostos,
            ]);
        }else{
            // Crear el registro de Tarifaprecio
            if ($tarifa->fob->n_variedad=="COMERCIAL") {
                $tarifa->update([
                    'suma_fob' => $sumafob,
                    'suma_fob_fc' => (($sumafob+$totalprocesos+$totalmateriales+$totalotroscostos)),
                    'cant_kg' => $sumakg,
                    'tarifa' => $this->tarifa,
                    'tarifa_fc' => (($sumafob+$totalprocesos+$totalmateriales+$totalotroscostos))/$sumakg,
                    'costo_proceso' => $totalprocesos,
                    'costo_materiales' => $totalmateriales,
                    'otros_costos' => $totalotroscostos,
                ]);

             } else {

                $tarifa->update([
                    'suma_fob' => $sumafob,
                    'suma_fob_fc' => (($sumafob+$totalprocesos+$totalmateriales+$totalotroscostos)/0.92),
                    'cant_kg' => $sumakg,
                    'tarifa' => $this->tarifa,
                    'tarifa_fc' => (($sumafob+$totalprocesos+$totalmateriales+$totalotroscostos)/0.92)/$sumakg,
                    'costo_proceso' => $totalprocesos,
                    'costo_materiales' => $totalmateriales,
                    'otros_costos' => $totalotroscostos,
                ]);

             }
             
           

        }

            
        
          
        $this->reset(['tarifaid','tarifa']);
        return redirect(route('temporada.graficovariedad', ['variedad' => $this->variedad->id, 'temporada' => $this->temporada->id]));

    }


    public function setback_tarifaid($tarifaid){
        /*
            $this->tarifaid=$tarifaid;
            $this->tarifa=Tarifaprecio::find($tarifaid)->tarifa;
        */
        $tarifa=Tarifaprecio::find($tarifaid);
        $fob=$tarifa->fob;
        $tarifa->update(['tarifa'=> $fob->tarifas->first()->tarifa,
                        'tarifa_fc'=> $fob->tarifas->first()->tarifa_fc,
                        'suma_fob'=> $fob->tarifas->first()->suma_fob,
                        'suma_fob_fc'=> $fob->tarifas->first()->suma_fob_fc]);
            return redirect(route('temporada.graficovariedad', ['variedad' => $this->variedad->id, 'temporada' => $this->temporada->id]));

    }

    public function mount(Temporada $temporada, $variedad){
        $this->temporada=$temporada;
        $this->variedad=Variedad::find($variedad);
        $this->filters['variedad']=$this->variedad->name;
    }

    public function render()
    {   
        $fobsall=Fob::where('temporada_id',$this->temporada->id)->where('n_variedad',$this->variedad->name)->get();

        $unique_variedades = Variedad::where('temporada_id',$this->temporada->id)->get();
    
        //    dd($unique_variedades);
        $unique_semanas = $fobsall->pluck('semana')
            ->unique()
            ->sortBy(function ($semana) {
                // Las semanas mayores a 25 (segundo semestre) deben ir primero
                // Les restamos 25 para que queden primero en el orden
                // Las otras las ordenamos después, sumándoles 52 para que vayan al final
                return $semana > 25 ? $semana - 25 : $semana + 52;
            })
            ->values(); // Opcional: para resetear los índices
    
        $unique_calibres = ['5J','4J','3J','2J','J','XL','L','JUP','COMERCIAL','PRE-CALIBRE'];

        return view('livewire.grafico-variedad',compact('unique_variedades','unique_calibres','unique_semanas','fobsall'));
    }
}
