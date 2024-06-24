<?php

namespace App\Livewire;

use App\Models\Balancemasacuatro;
use App\Models\Fob;
use App\Models\Precio;
use App\Models\Temporada;
use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\WithPagination;

class PrecioFob extends Component
{   use WithPagination;
    public $price_name, $fobid, $preciofob, $familia,$unidad, $item, $descuenta, $categoria, $masaid, $preciomasa, $temporada,$razonsocial,$type,$precio_usd, $etiqueta, $empresa, $exportacionedit_id, $valor, $ctd=50;


    #[Url]
    public $filters=[
        'variedad'=>'',
        'semana'=>'',
        'calibre'=>'',
    ];

    #[Url]

   

    public function mount(Temporada $temporada){
        $this->temporada=$temporada;
    }

    public function render()
    {   $detalle_liquidacions=Balancemasacuatro::where('temporada_id', $this->temporada->id)
                                            ->select('Variedad', 'semana', 'CALIBRE', 'PESO_TOTAL', 'LIQ_PRODUCTOR')
                                            ->get();

        $detalle_liquidacions2=Balancemasacuatro::filter($this->filters)->where('temporada_id', $this->temporada->id)
                                            ->select('Variedad', 'semana', 'CALIBRE', 'PESO_TOTAL', 'LIQ_PRODUCTOR')
                                            ->get();

        $fobs=Fob::filter($this->filters)->where('temporada_id',$this->temporada->id)->paginate($this->ctd);
        $fobsall=Fob::filter($this->filters)->where('temporada_id',$this->temporada->id)->get();

        $unique_variedades = $detalle_liquidacions->pluck('Variedad')->unique()->sort();
        $unique_semanas = $detalle_liquidacions->pluck('semana')->unique()->sort();

        $unique_calibres = $detalle_liquidacions->pluck('CALIBRE')->unique()->sort();
        $unique_calibres2 = ['5J','4J','3J','2J','J','XL','L','JUP'];


        return view('livewire.precio-fob',compact('fobs','fobsall','detalle_liquidacions','detalle_liquidacions2','unique_semanas','unique_variedades','unique_calibres','unique_calibres2'));
    }

    public function set_fobid($fobid){
        $this->fobid=$fobid;
        $this->preciofob=Fob::find($fobid)->fob_kilo_salida;
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
        $rules = [
            'price_name'=>'required',
            ];

        $this->validate ($rules);

        $precio=Precio::create(['name'=>$this->price_name,
                                'temporada_id'=>$this->temporada->id]);
                            
        $this->reset('price_name');

    }

    

    public function precio_create(){
        $detalle_liquidacions=Balancemasacuatro::where('temporada_id', $this->temporada->id)
            ->select('Variedad', 'semana', 'CALIBRE', 'PESO_TOTAL', 'LIQ_PRODUCTOR')
            ->get();
        $unique_variedades = $detalle_liquidacions->pluck('Variedad')->unique()->sort();
        $unique_semanas = $detalle_liquidacions->pluck('semana')->unique()->sort();
        $detalle_liquidacions2=Balancemasacuatro::where('temporada_id', $this->temporada->id)
                                            ->select('Variedad', 'semana', 'CALIBRE', 'PESO_TOTAL', 'LIQ_PRODUCTOR')
                                            ->get();


        foreach ($unique_variedades as $variedad){

            foreach ($unique_semanas as $semana){
                    $peso5J=0;
                    $peso4J=0;
                    $peso3J=0;
                    $peso2J=0;
                    $pesoJ=0;
                    $pesoXL=0;
                    $pesoL=0;
                    $pesoJUP=0;
                    
                    $venta5J=0;
                    $venta4J=0;
                    $venta3J=0;
                    $venta2J=0;
                    $ventaJ=0;
                    $ventaXL=0;
                    $ventaL=0;
                    $ventaJUP=0;
                    
                foreach ($detalle_liquidacions2 as $detalle){
                    if ($detalle->Variedad==$variedad && $detalle->semana==$semana){
                        if ($detalle->CALIBRE == '5J'){
                                $peso5J += $detalle->PESO_TOTAL;
                                $venta5J += $detalle->LIQ_PRODUCTOR;
                        }elseif ($detalle->CALIBRE == '4J'){
                                $peso4J += $detalle->PESO_TOTAL;
                                $venta4J += $detalle->LIQ_PRODUCTOR;
                        }elseif ($detalle->CALIBRE == '3J'){
                                $peso3J += $detalle->PESO_TOTAL;
                                $venta3J += $detalle->LIQ_PRODUCTOR;
                        }elseif ($detalle->CALIBRE == '2J'){
                                $peso2J += $detalle->PESO_TOTAL;
                                $venta2J += $detalle->LIQ_PRODUCTOR;
                        }elseif ($detalle->CALIBRE == 'J'){
                                $pesoJ += $detalle->PESO_TOTAL;
                                $ventaJ += $detalle->LIQ_PRODUCTOR;
                        }elseif ($detalle->CALIBRE == 'XL'){
                                $pesoXL += $detalle->PESO_TOTAL;
                                $ventaXL += $detalle->LIQ_PRODUCTOR;
                        }elseif ($detalle->CALIBRE == 'L'){
                                $pesoL += $detalle->PESO_TOTAL;
                                $ventaL += $detalle->LIQ_PRODUCTOR;
                        }elseif ($detalle->CALIBRE == 'JUP'){
                                $pesoJUP += $detalle->PESO_TOTAL;
                                $ventaJUP += $detalle->LIQ_PRODUCTOR;
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
                    'JUP'=> ['venta' => $ventaJUP, 'peso' => $pesoJUP],
                ];
                
                foreach ($calibres as $calibre => $data) {
                    if ($data['venta'] > 0) {
                        Fob::create([
                            'temporada_id'    => $this->temporada->id,
                            'n_variedad'      => $variedad,
                            'semana'          => $semana,
                            'n_calibre'       => $calibre,
                            'suma_fob'        => floatval($data['venta']),
                            'cant_kg'         => floatval($data['peso']),
                            'fob_kilo_salida' => floatval($data['venta'] / $data['peso'])
                        ]);
                    }
                }
                
                $this->render();
            }
        }
    }
    
}
