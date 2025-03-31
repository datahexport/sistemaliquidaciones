<?php

namespace App\Livewire;

use App\Models\Balancemasatres;
use App\Models\Temporada;
use Livewire\Attributes\Url;
use Livewire\Component;

class DespachoSearch extends Component
{   public $temporada;

    #[Url(history: true)]
    public $filters=[
        'folio'=>'',
        'semana'=>'',
        'variedad'=>'',
        'variedad2'=>'',
    ];

    public function mount(Temporada $temporada){
        $this->temporada=$temporada;
    }

    public function render()
    {  
        $despachos=Balancemasatres::select('Kilos_prod','Fob','Folio','semana','Variedad_Real','calibre_real')->filter($this->filters)->where('temporada_id',$this->temporada->id)->paginate(50);
        $despachosall=Balancemasatres::select('Kilos_prod','Fob')->filter($this->filters)->where('temporada_id',$this->temporada->id)->get();
        $despachosall2=Balancemasatres::select('Folio','semana','Variedad_Real','calibre_real')->where('temporada_id',$this->temporada->id)->get();

        $unique_folios = $despachosall2->pluck('Folio')->unique()->sort();
        $unique_semanas = $despachosall2->pluck('semana')->unique()->sort();
        $unique_variedades = $despachosall2->pluck('Variedad_Real')->unique()->sort();
        $unique_calibres = $despachosall2->pluck('calibre_real')->unique()->sort();

        return view('livewire.despacho-search',compact('despachos','despachosall','unique_folios','unique_semanas','unique_variedades','unique_calibres'));
    }
    public function destroy_all(){
        $fobs=Balancemasatres::where('temporada_id',$this->temporada->id)->get();
        foreach($fobs as $fob){
            $fob->delete();
        }
        
        return redirect()->route('temporada.datauploaddesp',$this->temporada);
        
    }
}
