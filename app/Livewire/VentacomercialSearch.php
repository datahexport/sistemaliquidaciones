<?php

namespace App\Livewire;

use App\Models\Temporada;
use App\Models\Ventacomercial;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class VentacomercialSearch extends Component
{   use WithPagination;
    public $temporada;

    #[Url(history: true)]
    public $filters=[
        'cliente'=>'',
        'tipo'=>'',
        'semana'=>'',
    ];

    public function mount(Temporada $temporada){
        $this->temporada=$temporada;
    }

    public function render()
    {   $ventas=Ventacomercial::filter($this->filters)->where('temporada_id',$this->temporada->id)->paginate(50);
        $despachosall=Ventacomercial::filter($this->filters)->where('temporada_id',$this->temporada->id)->get();
        $despachosall2=Ventacomercial::where('temporada_id',$this->temporada->id)->get();

        $unique_folios = $despachosall2->pluck('cliente')->unique()->sort();
        $unique_tipos = $despachosall2->pluck('tipo')->unique()->sort();

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

        return view('livewire.ventacomercial-search',compact('unique_tipos','ventas','despachosall','unique_folios','unique_semanas','unique_variedades','unique_calibres'));
    }

    public function destroy_all(){
        $fobs=Ventacomercial::where('temporada_id',$this->temporada->id)->get();
        foreach($fobs as $fob){
            $fob->delete();
        }
        
        return redirect()->route('temporada.datauploadcomercial',$this->temporada);
        
    }
}

