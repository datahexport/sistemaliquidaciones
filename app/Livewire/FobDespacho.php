<?php

namespace App\Livewire;

use App\Models\Balancemasacuatro;
use App\Models\Fobdespacho as ModelsFobdespacho;
use App\Models\Precio;
use App\Models\Tarifaprecio;
use App\Models\Temporada;
use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\WithPagination;

class FobDespacho extends Component
{   use WithPagination;
    public $price_name, $fobid, $tarifaid, $tarifa, $preciofob, $familia,$unidad, $item, $descuenta, $categoria, $masaid, $preciomasa, $temporada,$razonsocial,$type,$precio_usd, $etiqueta, $empresa, $exportacionedit_id, $valor, $ctd=50;


    #[Url(history: true)]
    public $filters=[
        'folio'=>'',
    ];

    public function mount(Temporada $temporada){
        $this->temporada=$temporada;
       
    }

    public function render()
    {   $detalle_liquidacions=Balancemasacuatro::where('temporada_id', $this->temporada->id)
                                            ->select('Variedad', 'N_Pallet', 'CALIBRE', 'PESO_TOTAL', 'LIQ_PRODUCTOR')
                                            ->get();
        $unique_folios = $detalle_liquidacions->pluck('N_Pallet')->unique()->sort();

        $detalle_liquidacions2=Balancemasacuatro::filter($this->filters)->where('temporada_id', $this->temporada->id)
                                            ->select('Variedad', 'semana', 'CALIBRE', 'PESO_TOTAL', 'LIQ_PRODUCTOR')
                                            ->get();

        $fobs=ModelsFobdespacho::filter($this->filters)->where('temporada_id',$this->temporada->id)->paginate($this->ctd);
        $fobsall=ModelsFobdespacho::filter($this->filters)->where('temporada_id',$this->temporada->id)->get();

        $unique_variedades = $detalle_liquidacions->pluck('Variedad')->unique()->sort();
        
        $unique_semanas = $detalle_liquidacions->pluck('semana')->unique()->sort();

        $unique_calibres = $detalle_liquidacions->pluck('CALIBRE')->unique()->sort();
        $unique_calibres2 = ['5J','4J','3J','2J','J','XL','L','JUP'];


        return view('livewire.fob-despacho',compact('unique_folios','fobs','fobsall','detalle_liquidacions','detalle_liquidacions2','unique_semanas','unique_variedades','unique_calibres','unique_calibres2'));
    }

    public function comb_create(){
        $detalle_liquidacions=Balancemasacuatro::where('temporada_id', $this->temporada->id)
                                            ->select('Variedad', 'N_Pallet', 'Calibre_y_Color')
                                            ->get();

        $unique_folios = $detalle_liquidacions->pluck('N_Pallet')->unique()->sort();

      
        
        foreach($unique_folios as $folio){
            
            // Filtrar por 'folio'
            $detalle_liquidacions_filtrado = $detalle_liquidacions->filter(function ($item) use ($folio) {
                return $item->N_Pallet == $folio;
            });

            $unique_variedades = $detalle_liquidacions_filtrado->pluck('Variedad')->unique()->sort();

            $unique_calibre_colors = $detalle_liquidacions_filtrado->pluck('Calibre_y_Color')->unique()->sort();
            
            foreach($unique_variedades as $variedad){
                foreach($unique_calibre_colors as $calibre){

                            $exists = ModelsFobdespacho::where('temporada_id', $this->temporada->id)
                                ->where('folio', $folio)
                                ->where('variedad', $variedad)
                                ->where('calibre_color', $calibre)
                                ->exists();
                            
                                $exists2 = Balancemasacuatro::where('temporada_id', $this->temporada->id)
                                ->where('N_Pallet', $folio)
                                ->where('Variedad', $variedad)
                                ->where('Calibre_y_Color', $calibre)
                                ->where(function($query) {
                                    $query->where('VENTA_USD', '!=', 0)
                                          ->orWhere('PESO_TOTAL', '>', 0);
                                })
                                ->exists();
        
                            if (!$exists && $exists2) {
                                ModelsFobdespacho::create([
                                    'temporada_id'    => $this->temporada->id,
                                    'folio'          => $folio,
                                    'variedad'          => $variedad,
                                    'calibre_color' => $calibre
                                ]);
                            }
                }
            }
        }
    }

    public function delete_all(){
       
        $fobs=ModelsFobdespacho::where('temporada_id', $this->temporada->id)->get();
      
        foreach($fobs as $fob){
            $fob->delete();
        }
    }

    public function set_tarifaid($tarifaid){
        $this->tarifaid=$tarifaid;
        $this->tarifa=Tarifaprecio::find($tarifaid)->tarifa;
    }

    public function save_tarifaid(){
        $tarifa=Tarifaprecio::find($this->tarifaid);
        $tarifa->update(['tarifa'=>$this->tarifa]);    
        $this->reset(['tarifaid','tarifa']);
    }

    public function save_fobid(){
        $fob=ModelsFobdespacho::find($this->fobid);
        $fob->update(['fob_kilo_salida'=>$this->preciofob]);    
        $this->reset(['preciofob','fobid']);
        
    }

    public function reset_fobid(){
        $this->reset(['preciofob','fobid']);
    }

    
    public function add_precio(){
        $rules = [
            'price_name'=>'required',
            ];

        $this->validate ($rules);

        $precio=Precio::create(['name'=>$this->price_name,
                                'temporada_id'=>$this->temporada->id]);

        $fobsall=ModelsFobdespacho::where('temporada_id',$this->temporada->id)->get();
        
        foreach ($fobsall as $fob) {
            // Crea el registro de Tarifaprecio
            Tarifaprecio::create([
                'fob_id' => $fob->id,
                'precio_id' => $precio->id,
                'tarifa' => $fob->fob_kilo_salida
            ]);
        }
                            
        $this->reset('price_name');

    }

    

    public function precio_create() {
        $detalle_liquidacions = Balancemasacuatro::where('temporada_id', $this->temporada->id)
            ->select('Variedad', 'N_Pallet', 'CALIBRE', 'PESO_TOTAL', 'LIQ_PRODUCTOR')
            ->get();

        $unique_variedades = $detalle_liquidacions->pluck('Variedad')->unique()->sort();

        $unique_folios = ModelsFobdespacho::WhereNull('suma_fob')->take(1000)->get();
        
        $detalle_liquidacions2 = Balancemasacuatro::where('temporada_id', $this->temporada->id)
            ->select('Variedad', 'N_Pallet', 'Calibre_y_Color', 'PESO_TOTAL', 'LIQ_PRODUCTOR','VENTA_USD','COMISION','FLETE','OTROS_GASTOS','Apoyo_Liquidaciones')
            ->get();

  

    
            foreach ($unique_folios as $item) {

             
                
                $peso = 0;
                $venta = 0;

                $bruto = 0;
                $comision = 0;
                $flete = 0;
                $otros = 0;
                $apoyo = 0;
                
               
            // Filtrar la colección
            $detalle_liquidacions2_filtrado = $detalle_liquidacions2->filter(function ($objet) use ($item) {
                return $objet->N_Pallet == $item->folio && $objet->Variedad == $item->variedad && $objet->Calibre_y_Color == $item->calibre_color;
            });

            // Si deseas obtener una colección nueva con los elementos filtrados:
            $detalle_liquidacions2_filtrado = $detalle_liquidacions2_filtrado->values();

           
                    foreach ($detalle_liquidacions2_filtrado as $detalle) {
                            
                            $peso += floatval($detalle->PESO_TOTAL);
                            $venta += floatval($detalle->LIQ_PRODUCTOR);

                            $bruto += $detalle->VENTA_USD;
                            $comision += $detalle->COMISION;
                            $flete += $detalle->FLETE;
                            $otros += $detalle->OTROS_GASTOS;
                            $apoyo += $detalle->Apoyo_Liquidaciones;
                    
                            /*
                                switch ($detalle->CALIBRE) {
                                    case '5J':
                                        $peso5J += $detalle->PESO_TOTAL;
                                        $venta5J += $detalle->LIQ_PRODUCTOR;
                                        break;
                                    case '4J':
                                        $peso4J += $detalle->PESO_TOTAL;
                                        $venta4J += $detalle->LIQ_PRODUCTOR;
                                        break;
                                    case '3J':
                                        $peso3J += $detalle->PESO_TOTAL;
                                        $venta3J += $detalle->LIQ_PRODUCTOR;
                                        break;
                                    case '2J':
                                        $peso2J += $detalle->PESO_TOTAL;
                                        $venta2J += $detalle->LIQ_PRODUCTOR;
                                        break;
                                    case 'J':
                                        $pesoJ += $detalle->PESO_TOTAL;
                                        $ventaJ += $detalle->LIQ_PRODUCTOR;
                                        break;
                                    case 'XL':
                                        $pesoXL += $detalle->PESO_TOTAL;
                                        $ventaXL += $detalle->LIQ_PRODUCTOR;
                                        break;
                                    case 'L':
                                        $pesoL += $detalle->PESO_TOTAL;
                                        $ventaL += $detalle->LIQ_PRODUCTOR;
                                        break;
                                    case 'JUP':
                                        $pesoJUP += $detalle->PESO_TOTAL;
                                        $ventaJUP += $detalle->LIQ_PRODUCTOR;
                                        break;
                                }
                            */
                    
                    }
                
    
   
                       
                    if ($venta > 0) {
                       
                        if ($peso>0) {
                             $item->update([ 'suma_fob'        => floatval($venta),
                                    'cant_kg'         => floatval($peso),
                                    'fob_kilo_salida' => floatval($venta/$peso),
                                    'bruto'=>floatval($bruto),
                                    'comision'=>floatval($comision),
                                    'flete'=>floatval($flete),
                                    'otros'=>floatval($otros),
                                    'apoyo'=>floatval($apoyo),
                                ]);
                        } else {
                             $item->update([ 'suma_fob'        => floatval($venta),
                                    'cant_kg'         => floatval($peso),
                                    'fob_kilo_salida' => 0,
                                    'bruto'=>floatval($bruto),
                                    'comision'=>floatval($comision),
                                    'flete'=>floatval($flete),
                                    'otros'=>floatval($otros),
                                    'apoyo'=>floatval($apoyo),
                                ]);
                        }
                        
                       
                   
                }else{
                    if ($peso>0) {
                        $item->update([ 'suma_fob'        => "Sin Venta",
                               'cant_kg'         => floatval($peso),
                               'fob_kilo_salida' => floatval($venta/$peso),
                               'bruto'=>floatval($bruto),
                               'comision'=>floatval($comision),
                               'flete'=>floatval($flete),
                               'otros'=>floatval($otros),
                               'apoyo'=>floatval($apoyo),
                           ]);
                   } else {
                        $item->update([ 'suma_fob'        => "Sin Venta",
                               'cant_kg'         => floatval($peso),
                               'fob_kilo_salida' => 0,
                               'bruto'=>floatval($bruto),
                               'comision'=>floatval($comision),
                               'flete'=>floatval($flete),
                               'otros'=>floatval($otros),
                               'apoyo'=>floatval($apoyo),
                           ]);
                   }
                }
                            
                           
                  
               
                
            }
            return redirect()->route('temporada.fobdespacho',$this->temporada);
       
    }
    
    
}
