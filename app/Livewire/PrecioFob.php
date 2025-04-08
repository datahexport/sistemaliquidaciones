<?php

namespace App\Livewire;

use App\Exports\PrecioOriginalExport;
use App\Imports\PreciosImport;
use App\Models\Balancemasacuatro;
use App\Models\Balancemasatres;
use App\Models\Fob;
use App\Models\Precio;
use App\Models\Proceso;
use App\Models\Tarifaprecio;
use App\Models\Temporada;
use App\Models\Ventacomercial;
use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class PrecioFob extends Component
{   use WithPagination;
    public $price_name, $fobid, $tarifaid, $tarifa, $preciofob, $familia,$unidad, $item, $descuenta, $categoria, $masaid, $preciomasa, $temporada,$razonsocial,$type,$precio_usd, $etiqueta, $empresa, $exportacionedit_id, $valor, $ctd=50;


    #[Url(history: true)]
    public $filters=[
        'variedad'=>'',
        'semana'=>'',
        'calibre'=>'',
        'exp'=>true,
        'com'=>true
    ];

    
    use WithFileUploads;

    public $archivo, $procesando;

    public function updatedArchivo()
    {
        $this->procesando = true;

        $this->validate([
            'archivo' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        Excel::import(new PreciosImport($this->temporada), $this->archivo);

        $this->procesando = false;

        session()->flash('mensaje', '¡Archivo importado con éxito!');
    }


   

    public function mount(Temporada $temporada){
        $this->temporada=$temporada;
    }

    public function render()
    {   $detalle_liquidacions=Balancemasatres::where('temporada_id', $this->temporada->id)
                                            ->select('Variedad_Real', 'semana', 'Calibre', 'Kilos_prod', 'Fob')
                                            ->get();

        $detalle_liquidacions2=Balancemasatres::filter($this->filters)->where('temporada_id', $this->temporada->id)
                                            ->select('Variedad_Real', 'semana', 'Calibre', 'Kilos_prod', 'Fob')
                                            ->get();

        $fobs=Fob::filter($this->filters)->where('temporada_id',$this->temporada->id)->get();
        $fobsall=Fob::where('temporada_id',$this->temporada->id)->get();

        $unique_variedades = $fobsall->pluck('n_variedad')
            ->map(fn($v) => trim($v))
            ->unique()
            ->sortBy(function ($item) {
                // Si es COMERCIAL (en mayúsculas), le damos un valor alto para que quede al final
                return strtoupper($item) === 'COMERCIAL' ? 'zzz' : $item;
            }, SORT_NATURAL | SORT_FLAG_CASE)
            ->values();
    
        //    dd($unique_variedades);
        $unique_semanas = $detalle_liquidacions->pluck('semana')
            ->unique()
            ->sortBy(function ($semana) {
                // Las semanas mayores a 25 (segundo semestre) deben ir primero
                // Les restamos 25 para que queden primero en el orden
                // Las otras las ordenamos después, sumándoles 52 para que vayan al final
                return $semana > 25 ? $semana - 25 : $semana + 52;
            })
            ->values(); // Opcional: para resetear los índices
    

        $unique_calibres = $detalle_liquidacions->pluck('Calibre')->unique()->sort();
        
        $unique_calibres2 = ['5J','4J','3J','2J','J','XL','L','JUP','COMERCIAL','PRE-CALIBRE'];


        return view('livewire.precio-fob',compact('fobs','fobsall','detalle_liquidacions','detalle_liquidacions2','unique_semanas','unique_variedades','unique_calibres','unique_calibres2'));
    }

    public function set_fobid($fobid){
        $this->fobid=$fobid;
        $this->preciofob=Fob::find($fobid)->fob_kilo_salida;
    }

    public function set_tarifaid($tarifaid){
        $this->tarifaid=$tarifaid;
        $this->tarifa=Tarifaprecio::find($tarifaid)->tarifa;
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
    }

    public function reset_tarifaid(){
        $this->reset(['tarifaid','tarifa']);
    }

    public function save_fobid(){
        $fob=Fob::find($this->fobid);
        $fob->update(['fob_kilo_salida'=>$this->preciofob]);    
        $this->reset(['preciofob','fobid']);
        
    }

    public function reset_fobid(){
        $this->reset(['preciofob','fobid']);
    }

    
    public function add_precio(){


        $detalle_liquidacions = Proceso::where('temporada_id', $this->temporada->id)
        ->select('VARIEDAD', 'SEMANA', 'CALIBRE_REAL', 'PESO_PRORRATEADO', 'fob_id')
        ->get();

        $unique_variedades = $detalle_liquidacions->pluck('VARIEDAD')->unique()->sort();
        $unique_semanas = $detalle_liquidacions->pluck('SEMANA')->unique()->sort();

        $detalle_liquidacions2 = Proceso::where('temporada_id', $this->temporada->id)
            ->select('VARIEDAD', 'SEMANA', 'CALIBRE_REAL', 'PESO_PRORRATEADO', 'fob_id')
            ->get();


        foreach ($unique_variedades as $variedad) {
            foreach ($unique_semanas as $semana) {
                $peso5J = 0;
                $peso4J = 0;
                $peso3J = 0;
                $peso2J = 0;
                $pesoJ = 0;
                $pesoXL = 0;
                $pesoL = 0;
                $pesoJUP = 0;

                $venta5J = 0;
                $venta4J = 0;
                $venta3J = 0;
                $venta2J = 0;
                $ventaJ = 0;
                $ventaXL = 0;
                $ventaL = 0;
                $ventaJUP = 0;

                foreach ($detalle_liquidacions2 as $detalle) {
                    if ($detalle->VARIEDAD == $variedad && $detalle->SEMANA == $semana) {
                     

                        $calibre=$detalle->CALIBRE_REAL;
                        
                        if ($detalle->fob) {
                        $produccion=$detalle->fob->fob_kilo_salida*floatval($detalle->PESO_PRORRATEADO);
                        } else {
                            $produccion=0;
                        }
                        

                        switch ($calibre) {
                            case '5J':
                                $peso5J += $detalle->PESO_PRORRATEADO;
                                $venta5J += $produccion;
                                break;
                            case '4J':
                                $peso4J += $detalle->PESO_PRORRATEADO;
                                $venta4J += $produccion;
                                break;
                            case '3J':
                                $peso3J += $detalle->PESO_PRORRATEADO;
                                $venta3J += $produccion;
                                break;
                            case '2J':
                                $peso2J += $detalle->PESO_PRORRATEADO;
                                $venta2J += $produccion;
                                break;
                            case 'J':
                                $pesoJ += $detalle->PESO_PRORRATEADO;
                                $ventaJ += $produccion;
                                break;
                            case 'XL':
                                $pesoXL += $detalle->PESO_PRORRATEADO;
                                $ventaXL += $produccion;
                                break;
                            case 'L':
                                $pesoL += $detalle->PESO_PRORRATEADO;
                                $ventaL += $produccion;
                                break;
                            case 'JUP':
                                $pesoJUP += $detalle->PESO_PRORRATEADO;
                                $ventaJUP += $produccion;
                                break;
                        }
                    }
                }

                $calibres = [
                    '5J' => ['venta' => $venta5J, 'peso' => $peso5J],
                    '4J' => ['venta' => $venta4J, 'peso' => $peso4J],
                    '3J' => ['venta' => $venta3J, 'peso' => $peso3J],
                    '2J' => ['venta' => $venta2J, 'peso' => $peso2J],
                    'J'  => ['venta' => $ventaJ, 'peso' => $pesoJ],
                    'XL' => ['venta' => $ventaXL, 'peso' => $pesoXL],
                    'L'  => ['venta' => $ventaL, 'peso' => $pesoL],
                    'JUP' => ['venta' => $ventaJUP, 'peso' => $pesoJUP],
                ];

                foreach ($calibres as $calibre => $data) {
                    if ($data['venta'] > 0 || $data['peso']>0) {
                        $exists = Fob::where('temporada_id', $this->temporada->id)
                            ->where('n_variedad', $variedad)
                            ->where('semana', $semana)
                            ->where('n_calibre', $calibre)
                            ->exists();

                        if (!$exists) {
                            
                            if ($data['peso']>0) {
                                Fob::create([
                                    'temporada_id'    => $this->temporada->id,
                                    'n_variedad'      => strtoupper($variedad),
                                    'semana'          => $semana,
                                    'n_calibre'       => $calibre,
                                    'suma_fob'        => floatval($data['venta']),
                                    'cant_kg'         => floatval($data['peso']),
                                    'fob_kilo_salida' => floatval($data['venta'] / $data['peso'])
                                ]);
                            } else {
                                Fob::create([
                                    'temporada_id'    => $this->temporada->id,
                                    'n_variedad'      => strtoupper($variedad),
                                    'semana'          => $semana,
                                    'n_calibre'       => $calibre,
                                    'suma_fob'        => floatval($data['venta']),
                                    'cant_kg'         => floatval($data['peso']),
                                    'fob_kilo_salida' => 0
                                ]);
                            }
                            
                        }
                    }
                }


                $this->render();
            }
        }
        


        $precio = Precio::firstOrCreate(
            ['name' => 'Precio Promedio', 'temporada_id' => $this->temporada->id],
            ['name' => 'Precio Promedio', 'temporada_id' => $this->temporada->id]
        );
        
        $precio2 = Precio::firstOrCreate(
            ['name' => 'Precio Ajustado', 'temporada_id' => $this->temporada->id],
            ['name' => 'Precio Ajustado', 'temporada_id' => $this->temporada->id]
        );

        

        $fobsall=Fob::where('temporada_id',$this->temporada->id)->get();

        $procesos=Proceso::where('temporada_id',$this->temporada->id)
                        ->whereIn('CRITERIO', ['EXPORTACIÓN', 'COMERCIAL EMBALADA'])
                        ->get();
        
        $procesos_comercial=Proceso::where('temporada_id',$this->temporada->id)
                        ->whereIn('TIPO', ['PRE-CALIBRE', 'COMERCIAL']) // Filtramos por TIPO
                        ->get();
                        
        $peso_total = Proceso::where('temporada_id', $this->temporada->id)
            ->whereIn('CRITERIO', ['EXPORTACIÓN', 'COMERCIAL EMBALADA'])
            ->sum('PESO_PRORRATEADO');

        $ventasall = Ventacomercial::where('temporada_id', $this->temporada->id)->get();
       
        
        $totalotrosgastos=$this->temporada->pti +
                $this->temporada->tecomex +
                $this->temporada->coface +
                $this->temporada->safe_cargo +
                $this->temporada->transportes +
                $this->temporada->gastos_de_exportacion +
                $this->temporada->fedex +
                $this->temporada->seguro_carga_fester +
                $this->temporada->seguro_carga_maerk +
                $this->temporada->asoex;
        
        foreach ($fobsall as $fob) {
            $sumafob=0;
            $sumakg=0;
            $totalprocesos=0;
            $totalmateriales=0;
            $totalotroscostos=0;

            $pesoComercial = 0;
            $pesoPrecalibre = 0;
        
            $ventaComercial = 0;
            $ventaPrecalibre = 0;

            $masa_comercial=0;
            $masa_precalibre=0;
            
            // Iterar sobre los procesos y filtrar los que coincidan con variedad, semana y calibre
            if ($fob->n_variedad=='COMERCIAL') {

                foreach ($ventasall as $detalle) {
                    if ($detalle->semana == $fob->semana && $detalle->tipo==$fob->n_calibre) {
                        // Determinar si es "Comercial" o "Precalibre"
                        $sumafob += $detalle->venta_usd; // Asumiendo que el valor FOB está en fob_value
                       
                    }
                }

              
                foreach ($procesos_comercial as $masa) {
                    if($masa->SEMANA==$fob->semana && $masa->TIPO== $fob->n_calibre){
                        $sumakg += floatval($masa->PESO_PRORRATEADO);
                    }
                }


                /*
                foreach ($procesos_comercial as $proceso) {
                    if ($proceso->SEMANA == $fob->semana && 
                        $proceso->TIPO == $fob->n_calibre) {
                        
                        // Sumar el valor FOB y el peso en kg
                        if($proceso->fob){
                            $sumafob += $proceso->fob->fob_kilo_salida*floatval($proceso->PESO_PRORRATEADO); // Asumiendo que el valor FOB está en fob_value
                        }
                        
                        $sumakg += floatval($proceso->PESO_PRORRATEADO);    // Asumiendo que el peso está en peso_kg

                        $totalprocesos+=$proceso->costo_proceso;

                        $totalmateriales+=$proceso->costo_materiales;
                        $totalotroscostos+=$proceso->otros_costos;
                    


                        
                    }
                }*/

            } else {
                foreach ($procesos as $proceso) {
                    if ($proceso->VARIEDAD == $fob->n_variedad && 
                        $proceso->SEMANA == $fob->semana && 
                        $proceso->CALIBRE_REAL == $fob->n_calibre) {
                        
                        // Sumar el valor FOB y el peso en kg
                        if($proceso->fob){
                            $sumafob += $proceso->fob->fob_kilo_salida*floatval($proceso->PESO_PRORRATEADO); // Asumiendo que el valor FOB está en fob_value
                        }
                        
                        $sumakg += floatval($proceso->PESO_PRORRATEADO);    // Asumiendo que el peso está en peso_kg

                        $totalprocesos+=$proceso->costo_proceso;

                        $totalmateriales+=$proceso->costo_materiales;
                        $totalotroscostos+=$proceso->otros_costos;
                    


                        
                    }
                }
            }
                
            

            // Calcular la tarifa
          

            if ($fob->n_calibre=="JUP") {
                if ($sumakg > 0) {
                    $tarifa = ($sumafob-($totalprocesos+$totalmateriales+$totalotroscostos))/$sumakg;
                } else {
                    $tarifa = 0;
                }
                // Crear el registro de Tarifaprecio si no existe ya
                Tarifaprecio::firstOrCreate([
                    'fob_id' => $fob->id,
                    'precio_id' => $precio->id,
                ], [
                    'suma_fob' => $sumafob-($totalprocesos+$totalmateriales+$totalotroscostos),
                    'suma_fob_fc' => $sumafob,
                    'cant_kg' => $sumakg,
                    'tarifa' => $tarifa,
                    'tarifa_fc' => $fob->fob_kilo_salida,
                    'costo_proceso' => $totalprocesos,
                    'costo_materiales' => $totalmateriales,
                    'otros_costos' => $totalotroscostos,
                ]);

                Tarifaprecio::firstOrCreate([
                    'fob_id' => $fob->id,
                    'precio_id' => $precio2->id,
                ], [
                    'suma_fob' => $sumafob-($totalprocesos+$totalmateriales+$totalotroscostos),
                    'suma_fob_fc' => $sumafob,
                    'cant_kg' => $sumakg,
                    'tarifa' => $tarifa,
                    'tarifa_fc' => $fob->fob_kilo_salida,
                    'costo_proceso' => $totalprocesos,
                    'costo_materiales' => $totalmateriales,
                    'otros_costos' => $totalotroscostos,
                ]);

            } else {
               
                    // Crear el registro de Tarifaprecio
                    // Crear el registro de Tarifaprecio si no existe ya para el primer precio
                    if ($fob->n_variedad=="COMERCIAL") {
                       $ingreso=$sumafob;
                       if ($sumakg > 0) {
                            $tarifa = ($sumafob)/$sumakg;
                        } else {
                            $tarifa = 0;
                        }
                    } else {
                        $ingreso=$sumafob * 0.92 - ($totalprocesos + $totalmateriales + $totalotroscostos);
                        if ($sumakg > 0) {
                            $tarifa = ($sumafob-($totalprocesos+$totalmateriales+$totalotroscostos)-$sumafob*0.08)/$sumakg;
                        } else {
                            $tarifa = 0;
                        }
                    }
                    

                    Tarifaprecio::firstOrCreate([
                        'fob_id' => $fob->id,
                        'precio_id' => $precio->id,
                    ], [
                        'suma_fob' => $ingreso,
                        'suma_fob_fc' => $sumafob,
                        'cant_kg' => $sumakg,
                        'tarifa' => $tarifa,
                        'tarifa_fc' => $fob->fob_kilo_salida,
                        'costo_proceso' => $totalprocesos,
                        'costo_materiales' => $totalmateriales,
                        'otros_costos' => $totalotroscostos,
                    ]);

                    // Crear el registro de Tarifaprecio si no existe ya para el segundo precio
                    Tarifaprecio::firstOrCreate([
                        'fob_id' => $fob->id,
                        'precio_id' => $precio2->id,
                    ], [
                        'suma_fob' => $ingreso,
                        'suma_fob_fc' => $sumafob,
                        'cant_kg' => $sumakg,
                        'tarifa' => $tarifa,
                        'tarifa_fc' => $fob->fob_kilo_salida,
                        'costo_proceso' => $totalprocesos,
                        'costo_materiales' => $totalmateriales,
                        'otros_costos' => $totalotroscostos,
                    ]);

            }
            
         
        }

       

        $this->reset('price_name');

    }

    public function excel_export(){

        return Excel::download(new PrecioOriginalExport($this->temporada->id),'Fobs_Precio_Original.xlsx');

    }

    

    public function precio_create() {
        $detalle_liquidacions = Balancemasatres::where('temporada_id', $this->temporada->id)
            ->select('Variedad_Real', 'semana', 'calibre_real', 'Kilos_prod', 'Fob')
            ->get();

        $unique_variedades = $detalle_liquidacions->pluck('Variedad_Real')->unique()->sort();
        $unique_semanas = $detalle_liquidacions->pluck('semana')->unique()->sort();

        $detalle_liquidacions2 = Balancemasatres::where('temporada_id', $this->temporada->id)
            ->select('Variedad_Real', 'semana', 'calibre_real', 'Kilos_prod', 'Fob')
            ->get();
    
        foreach ($unique_variedades as $variedad) {
            foreach ($unique_semanas as $semana) {
                $peso5J = 0;
                $peso4J = 0;
                $peso3J = 0;
                $peso2J = 0;
                $pesoJ = 0;
                $pesoXL = 0;
                $pesoL = 0;
                $pesoJUP = 0;
    
                $venta5J = 0;
                $venta4J = 0;
                $venta3J = 0;
                $venta2J = 0;
                $ventaJ = 0;
                $ventaXL = 0;
                $ventaL = 0;
                $ventaJUP = 0;
    
                foreach ($detalle_liquidacions2 as $detalle) {
                    if ($detalle->Variedad_Real == $variedad && $detalle->semana == $semana) {
                        /*
                        if ($detalle->Calibre=='5J' || $detalle->Calibre=='5JD' || $detalle->Calibre=='5JDD'){
                                $calibre='5J';
                                            
                            if ($detalle->Calibre=='5JD' || $detalle->Calibre=='5JDD'){
                                $color='Dark';
                            }else{
                                $color='Light';
                            }
                        }
                        if ($detalle->Calibre=='4J' || $detalle->Calibre=='4JD' || $detalle->Calibre=='4JDD'){
                                $calibre='4J';
                            if ($detalle->Calibre=='4JD' || $detalle->Calibre=='4JDD'){
                                $color='Dark';
                            }else{
                                $color='Light';
                            }
                        }
                        if ($detalle->Calibre=='3J' || $detalle->Calibre=='3JD' || $detalle->Calibre=='3JDD'){
                                $calibre='3J';
                            if ($detalle->Calibre=='3JD' || $detalle->Calibre=='3JDD'){
                                $color='Dark';
                            }else{
                            $color='Light';
                            }
                        }
                        if ($detalle->Calibre=='2J' || $detalle->Calibre=='2JD' || $detalle->Calibre=='2JDD'){
                                $calibre='2J';
                            if ($detalle->Calibre=='2JD' || $detalle->Calibre=='2JDD'){
                                    $color='Dark';
                            
                            }else{
                                $color='Light';
                            }
                        }
                        if ($detalle->Calibre=='J' || $detalle->Calibre=='JD' || $detalle->Calibre=='JDD'){
                                $calibre='J';
                            if ($detalle->Calibre=='JD' || $detalle->Calibre=='JDD'){
                                    $color='Dark';
                            }else{
                                $color='Light';
                            }
                        }
                        if ($detalle->Calibre=='XL' || $detalle->Calibre=='XLD' || $detalle->Calibre=='XLDD'){
                                $calibre='XL';
                            if ($detalle->Calibre=='XLD' || $detalle->Calibre=='XLDD'){
                                $color='Dark';
                            }else{
                                $color='Light';
                            }
                        }
                        if ($detalle->Calibre=='L' || $detalle->Calibre=='LD' || $detalle->Calibre=='LDD'){
                                $calibre='L';
                            if ($detalle->Calibre=='LD' || $detalle->Calibre=='LDD'){
                                $color='Dark';
                            }else{
                                $color='Light';
                            }
                        }
                        if ($detalle->Calibre=='JUP' || $detalle->Calibre=='JUPD' || $detalle->Calibre=='JUPDD'){
                                $calibre='JUP';
                            if ($detalle->Calibre=='XLD' || $detalle->Calibre=='XLDD'){
                                $color='Dark';
                            }else{
                                $color='Light';
                            }
                        }
                        */

                        $calibre=$detalle->calibre_real;

                        switch ($calibre) {
                            case '5J':
                                $peso5J += $detalle->Kilos_prod;
                                $venta5J += $detalle->Fob;
                                break;
                            case '4J':
                                $peso4J += $detalle->Kilos_prod;
                                $venta4J += $detalle->Fob;
                                break;
                            case '3J':
                                $peso3J += $detalle->Kilos_prod;
                                $venta3J += $detalle->Fob;
                                break;
                            case '2J':
                                $peso2J += $detalle->Kilos_prod;
                                $venta2J += $detalle->Fob;
                                break;
                            case 'J':
                                $pesoJ += $detalle->Kilos_prod;
                                $ventaJ += $detalle->Fob;
                                break;
                            case 'XL':
                                $pesoXL += $detalle->Kilos_prod;
                                $ventaXL += $detalle->Fob;
                                break;
                            case 'L':
                                $pesoL += $detalle->Kilos_prod;
                                $ventaL += $detalle->Fob;
                                break;
                            case 'JUP':
                                $pesoJUP += $detalle->Kilos_prod;
                                $ventaJUP += $detalle->Fob;
                                break;
                        }
                    }
                }
    
                $calibres = [
                    '5J' => ['venta' => $venta5J, 'peso' => $peso5J],
                    '4J' => ['venta' => $venta4J, 'peso' => $peso4J],
                    '3J' => ['venta' => $venta3J, 'peso' => $peso3J],
                    '2J' => ['venta' => $venta2J, 'peso' => $peso2J],
                    'J'  => ['venta' => $ventaJ, 'peso' => $pesoJ],
                    'XL' => ['venta' => $ventaXL, 'peso' => $pesoXL],
                    'L'  => ['venta' => $ventaL, 'peso' => $pesoL],
                    'JUP' => ['venta' => $ventaJUP, 'peso' => $pesoJUP],
                ];
    
                foreach ($calibres as $calibre => $data) {
                    if ($data['venta'] > 0 || $data['peso']>0) {
                        $exists = Fob::where('temporada_id', $this->temporada->id)
                            ->where('n_variedad', $variedad)
                            ->where('semana', $semana)
                            ->where('n_calibre', $calibre)
                            ->exists();
    
                        if (!$exists) {
                            
                            if ($data['peso']>0) {
                                Fob::create([
                                    'temporada_id'    => $this->temporada->id,
                                    'n_variedad'      => strtoupper($variedad),
                                    'semana'          => $semana,
                                    'n_calibre'       => $calibre,
                                    'suma_fob'        => floatval($data['venta']),
                                    'cant_kg'         => floatval($data['peso']),
                                    'fob_kilo_salida' => floatval($data['venta'] / $data['peso'])
                                ]);
                            } else {
                                Fob::create([
                                    'temporada_id'    => $this->temporada->id,
                                    'n_variedad'      => strtoupper($variedad),
                                    'semana'          => $semana,
                                    'n_calibre'       => $calibre,
                                    'suma_fob'        => floatval($data['venta']),
                                    'cant_kg'         => floatval($data['peso']),
                                    'fob_kilo_salida' => 0
                                ]);
                            }
                            
                        }
                    }
                }

    
                $this->render();
            }
        }


    }

    public function precio_create2(){
        $ventasall = Ventacomercial::where('temporada_id', $this->temporada->id)->get();
        $unique_semanas = $ventasall->pluck('semana')->unique()->sort();
        $masas = Proceso::where('temporada_id', $this->temporada->id)
            ->whereNull('fob_id')
            ->whereIn('TIPO', ['PRE-CALIBRE', 'COMERCIAL']) // Filtramos por TIPO
            ->get();

        foreach ($unique_semanas as $semana) {
            $pesoComercial = 0;
            $pesoPrecalibre = 0;
        
            $ventaComercial = 0;
            $ventaPrecalibre = 0;
        
            foreach ($ventasall as $detalle) {
                if ($detalle->semana == $semana) {
                    // Determinar si es "Comercial" o "Precalibre"
                    $tipo = $detalle->tipo;
                    
                    
        
                    switch ($tipo) {
                        case 'COMERCIAL':
                            $pesoComercial += $detalle->cantidad_kilos;
                            $ventaComercial += $detalle->venta_usd;
                        case 'PRE-CALIBRE':
                            $pesoPrecalibre += $detalle->cantidad_kilos;
                            $ventaPrecalibre += $detalle->venta_usd;
                          
                    }
                }
            }
            /*
                $masa_comercial=0;
                $masa_precalibre=0;
                foreach ($masas as $masa) {
                    if($masa->SEMANA==$semana && $masa->TIPO=="COMERCIAL"){
                        $masa_comercial+=$masa->PESO_PRORRATEADO;
                    }
                    if($masa->SEMANA==$semana && $masa->TIPO=="PRE-CALIBRE"){
                        $masa_precalibre+=$masa->PESO_PRORRATEADO;
                    }
                }
            */
            $tipos = [
                'COMERCIAL'  => ['venta' => $ventaComercial, 'peso' => $pesoComercial],
                'PRE-CALIBRE' => ['venta' => $ventaPrecalibre, 'peso' => $pesoPrecalibre],
            ];
        
            foreach ($tipos as $tipo => $data) {
                if ($data['venta'] > 0) {
                    $exists = Fob::where('temporada_id', $this->temporada->id)
                        ->where('n_variedad', 'COMERCIAL')
                        ->where('semana', $semana)
                        ->where('n_calibre', $tipo) // Aquí guardamos "Comercial" o "Precalibre"
                        ->exists();
        
                    if (!$exists) {
                        if ($data['peso'] > 0) {
                            Fob::create([
                                'temporada_id'    => $this->temporada->id,
                                'n_variedad'      => 'COMERCIAL',  // Variedad fija "Comercial"
                                'semana'          => $semana,
                                'n_calibre'       => $tipo,  // "Comercial" o "Precalibre"
                                'suma_fob'        => floatval($data['venta']),
                                'cant_kg'         => floatval($data['peso']),
                                'fob_kilo_salida' => floatval($data['venta'] / $data['peso'])
                            ]);
                        } else {
                            Fob::create([
                                'temporada_id'    => $this->temporada->id,
                                'n_variedad'      => 'COMERCIAL',
                                'semana'          => $semana,
                                'n_calibre'       => $tipo,
                                'suma_fob'        => floatval($data['venta']),
                                'cant_kg'         => floatval($data['peso']),
                                'fob_kilo_salida' => 0
                            ]);
                        }
                    }
                }
            }
        
            $this->render();
        }
    }
    
    public function precios_destroy_exportacion(){
        $fobs=Fob::where('n_variedad', '!=', 'COMERCIAL')->where('temporada_id',$this->temporada->id)->get();
        $fobIds = $fobs->pluck('id');

        // Selecciona los procesos cuyo fob_id esté dentro de $fobIds
        $procesos = Proceso::where('temporada_id', $this->temporada->id)
                        ->whereIn('fob_id', $fobIds)
                        ->get();
        
                        
        foreach($procesos as $proceso){
                $proceso->update(['fob_id'=>null]);
            }
                    
        foreach($fobs as $fob){
            $fob->delete();
        }

        
  
        return redirect()->route('temporada.precio.original',$this->temporada);
        
    }

    public function precios_destroy_comercial(){
        $fobs=Fob::where('n_variedad','COMERCIAL')->where('temporada_id',$this->temporada->id)->get();
        $fobIds = $fobs->pluck('id');

        // Selecciona los procesos cuyo fob_id esté dentro de $fobIds
        $procesos = Proceso::where('temporada_id', $this->temporada->id)
                        ->whereIn('fob_id', $fobIds)
                        ->get();

        foreach($procesos as $proceso){
                $proceso->update(['fob_id'=>null]);
            }
                    
        foreach($fobs as $fob){
            $fob->delete();
        }
        
  
        return redirect()->route('temporada.precio.original',$this->temporada);
        
    }

    public function subprecio_destroy($precio_id){
       
        $precio=Precio::find($precio_id);
        
        $precio->delete();

        return redirect()->route('temporada.precio.original',$this->temporada);
        
    }


    
}
