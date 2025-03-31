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
        $unique_folios = Balancemasatres::select('Folio')
            ->where('temporada_id', $this->temporada->id)
            ->whereNotNull('Folio')
            ->distinct()
            ->orderBy('Folio')
            ->pluck('Folio');
            
        $unique_semanas = Balancemasatres::select('semana')
            ->where('temporada_id', $this->temporada->id)
            ->whereNotNull('semana')
            ->distinct()
            ->orderBy('semana')
            ->pluck('semana');
        
        $unique_variedades = Balancemasatres::select('Variedad_Real')
            ->where('temporada_id', $this->temporada->id)
            ->whereNotNull('Variedad_Real')
            ->distinct()
            ->orderBy('Variedad_Real')
            ->pluck('Variedad_Real');
        
        $unique_calibres = Balancemasatres::select('calibre_real')
            ->where('temporada_id', $this->temporada->id)
            ->whereNotNull('calibre_real')
            ->distinct()
            ->orderBy('calibre_real')
            ->pluck('calibre_real');
    
    
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
