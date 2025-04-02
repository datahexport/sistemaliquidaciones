<?php

namespace App\Livewire;

use App\Models\Balancemasacuatro;
use App\Models\Temporada;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class LiquidacionSearch extends Component
{   use WithPagination;
    public $temporada;

    #[Url(history: true)]
    public $filters=[
        'folio'=>'',
        'variedad'=>'',
        'semana'=>'',
        'calibre'=>'',
    ];

    public function mount(Temporada $temporada){
        $this->temporada=$temporada;
    }

    public function render()
    {   $detalle_liquidacions=Balancemasacuatro::where('temporada_id', $this->temporada->id)
                ->select('Variedad', 'N_Pallet', 'CALIBRE', 'PESO_TOTAL', 'LIQ_PRODUCTOR','semana','CALIBRE')
                ->get();

        $unique_folios = $detalle_liquidacions->pluck('N_Pallet')->unique()->sort();

        $unique_variedads = $detalle_liquidacions->pluck('Variedad')->unique()->sort();

        $unique_semanas = $detalle_liquidacions->pluck('semana')->unique()->sort();

        $unique_calibres = $detalle_liquidacions->pluck('CALIBRE')->unique()->sort();

        $detalles=Balancemasacuatro::filter($this->filters)->where('temporada_id', $this->temporada->id)->paginate(100);

        $detallesall=Balancemasacuatro::filter($this->filters)->where('temporada_id', $this->temporada->id)->get();

        return view('livewire.liquidacion-search',compact('unique_folios','detalles','detallesall','unique_variedads','unique_semanas','unique_calibres'));
    }
    
}
