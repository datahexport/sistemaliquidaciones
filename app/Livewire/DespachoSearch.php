<?php

namespace App\Livewire;

use App\Models\Balancemasatres;
use App\Models\Temporada;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class DespachoSearch extends Component
{   use WithPagination;

    public $temporada;
    
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
    {  ini_set('memory_limit', '512M'); // o '512M' si necesitas más
        $despachos=Balancemasatres::filter($this->filters)->where('temporada_id',$this->temporada->id)->paginate(50);
        $despachosall=Balancemasatres::select('Kilos_prod','Fob')->filter($this->filters)->where('temporada_id',$this->temporada->id)->get();
        $despachosall2=Balancemasatres::select('Folio','semana','Variedad_Real','calibre_real')->where('temporada_id',$this->temporada->id)->get();

        $unique_folios = $despachosall2->pluck('Folio')->unique()->sort();
        $unique_semanas = $despachosall2->pluck('semana')
                        ->unique()
                        ->sortBy(function ($semana) {
                            // Las semanas mayores a 25 (segundo semestre) deben ir primero
                            // Les restamos 25 para que queden primero en el orden
                            // Las otras las ordenamos después, sumándoles 52 para que vayan al final
                            return $semana > 25 ? $semana - 25 : $semana + 52;
                        })
                        ->values(); // Opcional: para resetear los índices

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
