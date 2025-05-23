<?php

namespace App\Livewire;

use App\Models\Balancemasa;
use App\Models\Temporada;
use Livewire\Component;
use Livewire\WithPagination;

class MenuAside extends Component
{   use WithPagination;

    public $temporada;

    public function mount(Temporada $temporada){
        $this->temporada=$temporada;
    }
    public function render()
    {   $masascount=Balancemasa::where('temporada_id',$this->temporada->id)->paginate(3);
        
        return view('livewire.menu-aside',compact('masascount'));
    }
}
