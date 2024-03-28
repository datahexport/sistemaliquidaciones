<?php

namespace App\Livewire;

use App\Models\Comision;
use App\Models\CostoPacking;
use App\Models\Exportacion;
use App\Models\Familia;
use App\Models\Flete;
use App\Models\Gasto;
use App\Models\Material;
use App\Models\Resumen;
use App\Models\Temporada;
use Livewire\Component;

class MainUpload extends Component
{   public $familia,$unidad, $item, $descuenta, $categoria, $temporada,$type,$precio_usd, $etiqueta, $empresa, $valor,$vista;

    public function mount(Temporada $temporada,$vista){
        $this->temporada=$temporada;
        $this->vista=$vista;
    }
    public function render()
    {   $materiales=Material::where('temporada_id',$this->temporada->id)->get();
        $resumes=Resumen::where('temporada_id',$this->temporada->id)->get();
        $CostosPackings=CostoPacking::where('temporada_id',$this->temporada->id)->get();
        $exportacions=Exportacion::where('temporada_id',$this->temporada->id)->get();
        $fletes=Flete::where('temporada_id',$this->temporada->id)->get();
        $comisions=Comision::where('temporada_id',$this->temporada->id)->get();
        $familias=Familia::where('status','active')->get();
       
        return view('livewire.main-upload',compact('familias','materiales','resumes','CostosPackings','exportacions','fletes','comisions'));
    }

    public function exportacion_store(){
        $rules = [
            'type'=>'required',
            'precio_usd'=>'required'
            
            ];
      
        $this->validate ($rules);

        Exportacion::create([
            'temporada_id'=>$this->temporada->id,
            'type'=>$this->type,
            'precio_usd'=>$this->precio_usd            
        ]);
        
        $this->reset(['type','precio_usd']);
        $this->temporada = Temporada::find($this->temporada->id);
    }

    public function gasto_store(){
        $rules = [
            'item'=>'required',
            'descuenta'=>'required'
            
            ];
      
        $this->validate ($rules);

        Gasto::create([
            'temporada_id'=>$this->temporada->id,
            'item'=>$this->item,
            'categoria'=>$this->categoria,
            'familia_id'=>$this->familia,
            'descuenta'=>$this->descuenta, 
            'unidad'=>$this->unidad
        ]);
        
        $this->reset(['item','categoria','familia','descuenta','unidad']);
        $this->temporada = Temporada::find($this->temporada->id);
    }

    public function flete_store(){
        $rules = [
            'etiqueta'=>'required',
            'empresa'=>'required',
            'valor'=>'required'
            
            ];
      
        $this->validate ($rules);

        Flete::create([
            'temporada_id'=>$this->temporada->id,
            'etiqueta'=>$this->etiqueta,
            'empresa'=>$this->empresa,
            'valor'=>$this->valor
        ]);
        
        $this->reset(['etiqueta','empresa','valor']);
        $this->temporada = Temporada::find($this->temporada->id);
    }
}
