<?php

namespace App\Livewire;

use App\Exports\PrecioOriginalExport;
use App\Models\Ajustecosto;
use App\Models\Balancemasatres;
use App\Models\Fob;
use App\Models\Precio;
use App\Models\Proceso;
use App\Models\Tarifaprecio;
use App\Models\Temporada;
use App\Models\Ventacomercial;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class AjusteCostos extends Component
{   use WithPagination;
    public $price_name, $fobid, $tarifaid, $tarifa, $preciofob, $familia,$unidad, $item, $descuenta, $categoria, $masaid, $preciomasa, $temporada,$razonsocial,$type,$precio_usd, $etiqueta, $empresa, $exportacionedit_id, $valor, $ctd=500;


    #[Url(history: true)]
    public $filters=[
        'variedad'=>'',
        'semana'=>'',
        'calibre'=>'',
        'exp'=>true,
        'com'=>true
    ];

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

        $fobs=Ajustecosto::filter($this->filters)->where('temporada_id',$this->temporada->id)->paginate($this->ctd);
        $fobsall=Ajustecosto::filter($this->filters)->where('temporada_id',$this->temporada->id)->get();

        $unique_variedades = $detalle_liquidacions->pluck('Variedad_Real')->unique()->sort();
        $unique_semanas = $detalle_liquidacions->pluck('semana')->unique()->sort();

        $unique_calibres = $detalle_liquidacions->pluck('Calibre')->unique()->sort();

        $unique_calibres2 = ['5J','4J','3J','2J','J','XL','L','JUP','COMERCIAL','PRE-CALIBRE'];

        return view('livewire.ajuste-costos',compact('fobs','fobsall','detalle_liquidacions','detalle_liquidacions2','unique_semanas','unique_variedades','unique_calibres','unique_calibres2'));
    }


    public function set_fobid($fobid){
        $this->fobid=$fobid;
        $this->preciofob=Fob::find($fobid)->fob_kilo_salida;
    }

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
        $sumafob=0;
        $sumakg=0;
        $totalprocesos=0;
        $totalmateriales=0;
        $totalotroscostos=0;
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
    
        $nro2=0;

        $masas = Proceso::where('temporada_id', $this->temporada->id)
            ->get();

        $fobsall=Ajustecosto::where('temporada_id',$this->temporada->id)->get();

        foreach($masas as $masa){

            if($masa->CRITERIO=="COMERCIAL"){
                $masa->update([ 'costo'=>floatval($masa->costo_proceso),
                    ]);
            }else{
                foreach ($fobsall as $fob){
                        
                            
                    if ($fob->n_calibre==$masa->CALIBRE_REAL && $fob->n_variedad==$masa->VARIEDAD && $fob->semana==$masa->SEMANA){
                        
                    
                            
                        
                            $masa->update([ 'costo'=>$masa->PESO_PRORRATEADO*$fob->tarifa_costo,
                                                            ]);

                            $nro2+=1;
                            
                            break;
                    }

                    
                }
            }
        }
        
        
    }

    public function excel_export(){

        return Excel::download(new PrecioOriginalExport($this->temporada->id),'Fobs_Precio_Original.xlsx');

    }

    

    public function precio_create() {
       

        $fobsall=Fob::where('temporada_id',$this->temporada->id)->get();

        $procesos=Proceso::where('temporada_id',$this->temporada->id)
                        ->whereIn('CRITERIO', ['EXPORTACIÓN', 'COMERCIAL EMBALADA', 'COMERCIAL'])
                        ->get();
                        
        
                        foreach ($fobsall as $fob) {
                            $sumafob = 0;
                            $totalprocesos = 0;
                            $totalmateriales = 0;
                            $totalotroscostos = 0;
                        
                            $sumakg22 = 0;
                            $sumakg25 = 0;
                            $sumakg5 = 0;
                            $sumakg10 = 0;
                            $sumakgcom = 0;
                        
                            $cajadiferencial22 = 0;
                            $cajadiferencial25 = 0;
                            $cajadiferencial5 = 0;
                            $cajadiferencial10 = 0;
                            $cajadiferencialcom = 0;
                        
                                // Iterar sobre los procesos y filtrar los que coincidan con variedad, semana y calibre
                                foreach ($procesos->where('CALIBRE_REAL', $fob->n_calibre)
                                                ->where('VARIEDAD', $fob->n_variedad)
                                                ->where('SEMANA', $fob->semana) as $proceso) {
                                                    
                                    
                                    if ($proceso->PESO_CAJA == "2.2") {
                                        $sumakg22 += floatval($proceso->PESO_PRORRATEADO);
                                        $cajadiferencial22 += floatval($proceso->costo_proceso + $proceso->costo_materiales + $proceso->otros_costos);
                                    
                                    } elseif ($proceso->PESO_CAJA == "2.5") {
                                        $sumakg25 += floatval($proceso->PESO_PRORRATEADO);
                                        $cajadiferencial25 += floatval($proceso->costo_proceso + $proceso->costo_materiales + $proceso->otros_costos);
                                    
                                    } elseif ($proceso->PESO_CAJA == "5") {
                                        $sumakg5 += floatval($proceso->PESO_PRORRATEADO);
                                        $cajadiferencial5 += floatval($proceso->costo_proceso + $proceso->costo_materiales + $proceso->otros_costos);
                                    
                                    } elseif ($proceso->PESO_CAJA == "10") {
                                        $sumakg10 += floatval($proceso->PESO_PRORRATEADO);
                                        $cajadiferencial10 += floatval($proceso->costo_proceso + $proceso->costo_materiales + $proceso->otros_costos);
                                    }
                                    if ($proceso->CRITERIO == "COMERCIAL") {
                                        $sumakgcom += floatval($proceso->PESO_PRORRATEADO);
                                        $cajadiferencialcom += floatval($proceso->costo_proceso + $proceso->costo_materiales + $proceso->otros_costos);
                                    }
                                }



                        
                            $totalkgs = $sumakg22 + $sumakg25 + $sumakg5 + $sumakg10 + $sumakgcom;

                            
                            if($totalkgs>0){
                                $tarifa=floatval(($cajadiferencial22 + $cajadiferencial25 + $cajadiferencial5 + $cajadiferencial10+ $cajadiferencialcom) / $totalkgs);
                            }else{
                                $tarifa=0;
                            }


                        
                            Ajustecosto::updateOrCreate(
                                [
                                    'temporada_id' => $this->temporada->id,
                                    'n_variedad' => $fob->n_variedad,
                                    'semana' => $fob->semana,
                                    'n_calibre' => $fob->n_calibre,
                                ],
                                [
                                    'suma_caja_diferencial_22' => $cajadiferencial22,
                                    'peso_caja_diferencial_22' => $sumakg22,
                                    'suma_caja_diferencial_25' => $cajadiferencial25,
                                    'peso_caja_diferencial_25' => $sumakg25,
                                    'suma_caja_diferencial_5' => $cajadiferencial5,
                                    'peso_caja_diferencial_5' => $sumakg5,
                                    'suma_caja_diferencial_10' => $cajadiferencial10,
                                    'peso_caja_diferencial_10' => $sumakg10,
                                    'suma_caja_diferencial_com' => $cajadiferencialcom,
                                    'peso_caja_diferencial_com' => $sumakgcom,
                                    'suma_caja_diferencial_total' => $cajadiferencial22 + $cajadiferencial25 + $cajadiferencial5 + $cajadiferencial10 + $cajadiferencialcom,
                                    'peso_caja_diferencial_total' => $totalkgs,
                                    'tarifa_costo' => $tarifa,
                                ]
                            );
                            
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
                            break;
                        case 'PRE-CALIBRE':
                            $pesoPrecalibre += $detalle->cantidad_kilos;
                            $ventaPrecalibre += $detalle->venta_usd;
                            break;
                    }
                }
            }

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
        
            $tipos = [
                'COMERCIAL'  => ['venta' => $ventaComercial, 'peso' => $masa_comercial],
                'PRE-CALIBRE' => ['venta' => $ventaPrecalibre, 'peso' => $masa_precalibre],
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
    
    public function precios_destroy(){
        $fobs=Ajustecosto::where('temporada_id',$this->temporada->id)->get();
        foreach($fobs as $fob){
            $fob->delete();
        }

        $procesos=Proceso::where('temporada_id',$this->temporada->id)->get();
        foreach($procesos as $proceso){
            $proceso->update(['costo'=>null]);
        }
        
  
        return redirect()->route('temporada.precioajustado',$this->temporada);
        
    }

    public function subprecio_destroy($precio_id){
       
        $precio=Precio::find($precio_id);
        
        $precio->delete();

        return redirect()->route('temporada.precio.original',$this->temporada);
        
    }

}
