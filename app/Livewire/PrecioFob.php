<?php

namespace App\Livewire;

use App\Models\Balancemasacuatro;
use App\Models\Temporada;
use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\WithPagination;

class PrecioFob extends Component
{   use WithPagination;
    public $familia,$unidad, $item, $descuenta, $categoria, $masaid, $preciomasa, $temporada,$razonsocial,$type,$precio_usd, $etiqueta, $empresa, $exportacionedit_id, $valor, $ctd=1000;


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
                                            ->select('Variedad', 'semana', 'CALIBRE', 'PESO_TOTAL', 'VENTA_USD')
                                            ->get();

        $detalle_liquidacions2=Balancemasacuatro::filter($this->filters)->where('temporada_id', $this->temporada->id)
                                            ->select('Variedad', 'semana', 'CALIBRE', 'PESO_TOTAL', 'VENTA_USD')
                                            ->get();


        $unique_variedades = $detalle_liquidacions->pluck('Variedad')->unique()->sort();
        $unique_semanas = $detalle_liquidacions->pluck('semana')->unique()->sort();

        $unique_calibres = $detalle_liquidacions->pluck('CALIBRE')->unique()->sort();
        $unique_calibres2 = ['5J','4J','3J','2J','J','XL','L','JUP'];


        return view('livewire.precio-fob',compact('detalle_liquidacions','detalle_liquidacions2','unique_semanas','unique_variedades','unique_calibres','unique_calibres2'));
    }
}
