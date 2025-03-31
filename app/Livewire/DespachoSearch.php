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
        $query = Balancemasatres::where('temporada_id', $this->temporada->id)->filter($this->filters);
    
        $despachos = $query
            ->select('Kilos_prod', 'Fob', 'Folio', 'semana', 'Variedad_Real', 'calibre_real')
            ->paginate(50);
    
        // SUMAS Y CONTADORES OPTIMIZADOS
        $pesovariedad = (clone $query)->sum('Kilos_prod');
        $ventavariedad = (clone $query)->sum('Fob');
        $total_registros = (clone $query)->count();
        $sin_precio = (clone $query)->whereNull('Fob')->count();
    
        // Únicos (más eficientes con distinct + pluck)
        $unique_folios = Balancemasatres::where('temporada_id', $this->temporada->id)->distinct()->pluck('Folio')->filter()->unique()->sort();
        $unique_semanas = Balancemasatres::where('temporada_id', $this->temporada->id)->distinct()->pluck('semana')->filter()->unique()->sort();
        $unique_variedades = Balancemasatres::where('temporada_id', $this->temporada->id)->distinct()->pluck('Variedad_Real')->filter()->unique()->sort();
        $unique_calibres = Balancemasatres::where('temporada_id', $this->temporada->id)->distinct()->pluck('calibre_real')->filter()->unique()->sort();
    
        return view('livewire.despacho-search', compact(
            'despachos',
            'pesovariedad',
            'ventavariedad',
            'total_registros',
            'sin_precio',
            'unique_folios',
            'unique_semanas',
            'unique_variedades',
            'unique_calibres'
        ));
    }
    
    public function destroy_all(){
        $fobs=Balancemasatres::where('temporada_id',$this->temporada->id)->get();
        foreach($fobs as $fob){
            $fob->delete();
        }
        
        return redirect()->route('temporada.datauploaddesp',$this->temporada);
        
    }
}
