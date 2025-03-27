<?php

namespace App\Livewire;

use App\Models\Comision;
use App\Models\CostoPacking;
use App\Models\Detalle;
use App\Models\Flete;
use App\Models\Fob;
use App\Models\Gasto;
use App\Models\Informe;
use App\Models\Material;
use App\Models\Modificacions;
use App\Models\Proceso;
use App\Models\Razonsocial;
use App\Models\Temporada;
use App\Models\Variedad;
use Livewire\Component;

class InformeUpdate extends Component
{   public $temporada, $razonsocial, $informe_edit, $categoria_mod,$variedad_mod, $calibre_mod , $type_mod, $kg_mod, $retorno, $retorno_inicial, $npk;

    protected $listeners = ['mostrar-mensaje' => 'mostrarMensaje'];
    
    public function mount(Temporada $temporada, Razonsocial $razonsocial){
        $this->temporada=$temporada;
        $this->razonsocial=$razonsocial;

        $this->informe_edit=Informe::find($this->razonsocial->informes->where('temporada_id',$temporada->id)->reverse()->first()->id);
    }

    public function updatedRetorno()
    {
        if ($this->kg_mod > 0) {
            $this->npk = $this->retorno / $this->kg_mod;
        }
    }
    
    public function updatedNpk()
    {
        $this->retorno = $this->npk * $this->kg_mod;
    }
    

    public function set_informe_edit(Informe $informe){
        $this->informe_edit=$informe;
    }

    public function set_informe_oficial(Informe $informe){
        $informe->update(['oficial'=>'si']);
        foreach($this->razonsocial->informes->where('temporada_id',$this->temporada->id) as $item){
            if($item->id!=$informe->id){
                $item->update(['oficial'=>null]);
            }
        }
    }

    public function set_modification($categoria, $variedad, $calibre, $retorno, $npk, $peso, $type_mod){
        $this->categoria_mod=$categoria;
        $this->variedad_mod=$variedad;
        $this->calibre_mod=$calibre;
       
        $this->kg_mod=$peso;
        $this->type_mod=$type_mod;

        // Buscar un registro existente con la misma combinación de categoría, variedad y calibre
        $modificacion = Modificacions::where('informe_id', $this->informe_edit->id)
            ->where('categoria', $categoria)
            ->where('variedad', $variedad)
            ->where('calibre', $calibre)
            ->first();

        if ($modificacion) {
            // Si el registro existe, asignamos los valores existentes de retorno y npk
            $this->retorno = $modificacion->retorno;
            $this->npk = $modificacion->npk;
        } else {
            // Si no existe, asignamos los valores pasados como parámetros
            $this->retorno = $retorno;
            $this->retorno_inicial=$this->retorno;
            $this->npk = $npk;
        }
      

    }

    public function delete_modificacion(Modificacions $modificacion)
    {
        // Eliminar la instancia proporcionada
        $modificacion->delete();

        $newtotal=0;
        foreach($this->informe_edit->modificaciones as $modificacion){
            $newtotal+=$modificacion->retorno-$modificacion->retorno_inicial;
        }
        if($newtotal==0){
            $this->informe_edit->update(['total_liquidado'=>null]);
        }else{
            $this->informe_edit->update(['total_liquidado'=>$newtotal]);
        }
        

        $this->dispatch('mostrar-mensaje', ['tipo' => 'success', 'mensaje' => 'Modificacion Eliminada con Exito.']);
    }

    public function saveOrUpdateModification()
    {
        
        // Buscar un registro existente con la misma combinación de categoría, variedad y calibre
        $modificacion = Modificacions::where('categoria', $this->categoria_mod)
            ->where('informe_id', $this->informe_edit->id)
            ->where('variedad', $this->variedad_mod)
            ->where('calibre', $this->calibre_mod)
            ->first();

        if ($modificacion) {
            // Si el registro existe, lo actualizamos
            $modificacion->update([
                'retorno' => $this->retorno,
                'npk' => $this->npk,
                'peso' => $this->kg_mod,
                'type_mod' => $this->type_mod,
            ]);

            session()->flash('success', 'Modificación actualizada exitosamente.');
        } else {
            // Si no existe, lo creamos
            Modificacions::create([
                'informe_id'=>$this->informe_edit->id,
                'categoria' => $this->categoria_mod,
                'variedad' => $this->variedad_mod,
                'calibre' => $this->calibre_mod,
                'retorno' => $this->retorno,
                'retorno_inicial' => $this->retorno_inicial,
                'npk' => $this->npk
            ]);

            session()->flash('success', 'Modificación guardada exitosamente.');
        }
        $newtotal=0;
        foreach($this->informe_edit->modificaciones as $modificacion){
            $newtotal+=$modificacion->retorno-$modificacion->retorno_inicial;
        }
        if($newtotal==0){
            $this->informe_edit->update(['total_liquidado'=>null]);
        }else{
            $this->informe_edit->update(['total_liquidado'=>$newtotal]);
        }
        

        // Limpiar las variables
        $this->reset(['categoria_mod', 'variedad_mod', 'calibre_mod', 'retorno', 'npk', 'kg_mod', 'type_mod']);
    }


    public function guardarCambios($data)
    {
        $informe = Informe::find($data['id']);
        if ($informe) {
            //dd($data['total_liquidado']);
            $informe->update(['total_liquidado'=> $data['total_liquidado'],
                         'diferencia_tipodecambio' => $data['diferencia_tipodecambio']]);
           
            $this->dispatch('mostrar-mensaje', ['tipo' => 'success', 'mensaje' => 'El informe ha sido actualizado correctamente.']);
          
        }
    }
    
    public function render()
    {     $masastotal=Proceso::select([
                'PESO_PRORRATEADO',
                'CRITERIO',
                'CALIBRE_REAL',
                'SEMANA',
                'VARIEDAD',
                'PRODUCTOR_RECEP_FACTURACION',
                'costo_proceso',
                'costo_materiales',
                'otros_costos',
                'gastos',
                'costo',
                'anticipos',
            
                'fob_id' // Incluimos el fob_id para la relación
            ])
            ->with([
                'fob' => function($query) {
                    $query->select('id', 'fob_kilo_salida')->with([
                        'tarifas' => function($query) {
                            $query->select('id', 'fob_id', 'tarifa_fc', 'tarifa');
                        }
                    ]);
                }
            ])
            ->where('temporada_id', $this->temporada->id)
            ->get();

        
        $masas = Proceso::selectRaw('CALIBRE_REAL as calibre_real, VARIEDAD as variedad, CANT as cantidad, PESO_PRORRATEADO as peso_prorrateado, costo, fob_id , TIPO as tipo')
            ->where('temporada_id', $this->temporada->id)
            ->where('PRODUCTOR_RECEP_FACTURACION', 'like', '%' . $this->razonsocial->name . '%')
            ->with('fob.tarifas') // Esto carga la relación fob con sus tarifas
            ->get();

       
        $fletes=Flete::where('temporada_id',$this->temporada->id)->get();
        $packings=CostoPacking::where('temporada_id',$this->temporada->id)->where('csg',$this->razonsocial->csg)->get();
        $comisions=Comision::where('temporada_id',$this->temporada->id)->where('productor',$this->razonsocial->name)->get();
        $unique_calibres = $masas->pluck('calibre')->unique()->sort();
       
        $unique_variedades = $masas->pluck('variedad')->unique()->sort();
        
        $variedades = Variedad::whereIn('name', $unique_variedades)->get();

        $unique_semanas = $masas->pluck('semana')->unique()->sort();
        $fobs = Fob::where('temporada_id',$this->temporada->id)->get();
        $materialestotal=Material::where('temporada_id',$this->temporada->id)->get();
        $gastos = Gasto::where('temporada_id',$this->temporada->id)->get();

        $detalles=Detalle::where('temporada_id',$this->temporada->id)->where('n_productor',$this->razonsocial->name)->get();

        return view('livewire.informe-update',compact('masastotal','detalles','gastos','materialestotal','variedades','unique_semanas','fobs','unique_variedades','unique_calibres','masas','packings','comisions','fletes'));
    }

    public function crearInforme()
    {
        if (!$this->temporada || !$this->temporada->id) {
            $this->dispatch('mostrar-mensaje', ['tipo' => 'error', 'mensaje' => 'No se encontró la temporada activa.']);
            return;
        }
    
        if (!isset($this->razonsocial) || !$this->razonsocial->id) {
            $this->dispatch('mostrar-mensaje', ['tipo' => 'error', 'mensaje' => 'No se encontró la razón social seleccionada.']);
            return;
        }
    
        Informe::create([
            'temporada_id' => $this->temporada->id,
            'razonsocial_id' => $this->razonsocial->id,
        ]);
    
        $this->dispatch('mostrar-mensaje', ['tipo' => 'success', 'mensaje' => 'Informe creado correctamente.']);
    }
    
    

    public function eliminarInforme($id)
    {
        $informe = Informe::find($id);
    
        if (!$informe) {
            $this->dispatch('mostrar-mensaje', ['tipo' => 'error', 'mensaje' => 'El informe no existe.']);
            return;
        }
    
        $informe->delete();

        $this->informe_edit=$this->razonsocial->informes->reverse()->first();
    
        $this->dispatch('mostrar-mensaje', ['tipo' => 'success', 'mensaje' => 'Informe eliminado correctamente.']);
    }
    

}
