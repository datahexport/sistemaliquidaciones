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
    
        // Datos paginados
        $despachos = (clone $query)
            ->select('Kilos_prod', 'Fob', 'Folio', 'semana', 'Variedad_Real', 'calibre_real')
            ->paginate(50);
    
        // Estadísticas
        $stats = (clone $query)->selectRaw("
            SUM(Kilos_prod) as total_kilos,
            SUM(Fob) as total_fob,
            COUNT(*) as total_registros,
            SUM(CASE WHEN Fob IS NULL THEN 1 ELSE 0 END) as sin_precio
        ")->first();
    
        $pesovariedad = $stats->total_kilos;
        $ventavariedad = $stats->total_fob;
        $total_registros = $stats->total_registros;
        $sin_precio = $stats->sin_precio;
    
        // Valores únicos
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
