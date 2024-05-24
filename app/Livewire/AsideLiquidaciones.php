<?php

namespace App\Livewire;

use App\Models\Temporada;
use Livewire\Component;

class AsideLiquidaciones extends Component
{   
    public $temporada;

    public function mount(Temporada $temporada){
        $this->temporada=$temporada;
    }

    public function render()
    {
        return view('livewire.aside-liquidaciones');
    }
}
