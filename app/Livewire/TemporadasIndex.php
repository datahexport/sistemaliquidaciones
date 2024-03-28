<?php

namespace App\Livewire;

use App\Models\Temporada;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Attributes\Url;

class TemporadasIndex extends Component
{   public $search;

    
    public function render()
    {   $temporadas = Temporada::orderBy('name', 'desc')->get();
        return view('livewire.temporadas-index',compact('temporadas'));
    }

    #[On('confirmDelete')]
    public function deletetemporada(Temporada $temporada){
        $temporada->delete();
        session()->flash('delete','Temporada borrada exitosamente');
        return $this->redirect('/dashboard', navigate:true);
    }


}
