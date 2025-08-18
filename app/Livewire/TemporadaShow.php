<?php

namespace App\Livewire;

use App\Models\AnalisisMultiresiduo;
use App\Models\Anticipo;
use App\Models\Balancemasa;
use App\Models\Balancemasados;
use App\Models\Balancemasatres;
use App\Models\Certificacion;
use App\Models\Comision;
use App\Models\CostoPacking;
use App\Models\Detalle;
use App\Models\Embarque;
use App\Models\Exportacion;
use App\Models\Factura;
use App\Models\Familia;
use App\Models\Flete;
use App\Models\Fob;
use App\Models\Fobnacional;
use App\Models\Gasto;
use App\Models\Informe;
use App\Models\Material;
use App\Models\Proceso;
use App\Models\Razonsocial;
use App\Models\Resumen;
use App\Models\Temporada;
use App\Models\Variedad;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class TemporadaShow extends Component
{   use WithPagination;
    public $familia,$unidad, $fobid, $informedit,$difcambio, $total_liquidado, $preciofob, $item, $descuenta, $categoria, $masaid, $preciomasa, $temporada,$vista,$razonsocial,$type,$precio_usd, $etiqueta, $empresa, $exportacionedit_id, $valor, $ctd=25;
    public $statusMessages = [];
    public $comisiones = [];

    #[Url(history: true)]
    public $filters=[
        'exportadora'=>'',
        'razonsocial'=>'',
        'especie'=>'',
        'variedad'=>'',
        'fromNumber'=>'',
        'toNumber'=>'',
        'fromDate'=>'',
        'toDate'=>'',
        'precioFob'=>'',
        'ncategoria'=>'',
        'exp'=>true,
        'com'=>true,
        'comem'=>true,
        'ispropio'=>true,
        'nopropio'=>true,
        'mie'=>'',
        'mn'=>'',
        'calibre'=>'',
        'etiqueta'=>'',
        'material'=>'',
        'mi'=>'',
        'semana'=>'',
        'norma'=>'',
        'fnorma'=>'',
        'tipo'=>'',
        'variedad2'=>'',
        'folio'
      
    ];




   
    public function actualizarComision($id, $value)
    {
        $razon = RazonSocial::find($id);

        if ($razon) {
            $razon->comision = $value;
            $razon->save();

            session()->flash('comision_status_' . $id, 'Comisión actualizada');
        }
    }


    public function mount(Temporada $temporada, $vista){
        $this->comisiones = RazonSocial::pluck('comision', 'id')->toArray();
        $this->temporada=$temporada;
        $this->vista=$vista;
        $masastotal=Proceso::select([
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
            ->filter($this->filters)
            ->get();
        
        $variedades=Variedad::where('temporada_id',$temporada->id)->get();
        if(IS_NULL($variedades)){
            foreach($masastotal as $masa){
                $variedad=Variedad::where('name',$masa->VARIEDAD)->where('temporada_id',$temporada->id)->first();
                if ($variedad){
    
                }else{
                    if($masa->VARIEDAD){
                        Variedad::create(['name'=>$masa->VARIEDAD,
                                        'temporada_id'=>$temporada->id]);
                    }
                }
           }
        }

        $unique_productores = $masastotal->pluck('PRODUCTOR_RECEP_FACTURACION')->unique();
        foreach($unique_productores as $item){
            $razon=Razonsocial::where('name',$item)->first();
            if ($razon){
                $razon->update(['name'=>$item]);
            }else{
                if($item){
                   $razon = Razonsocial::create(['name'=>$item]);
                }
            }
            if($razon){
                if ($razon->informes->where('temporada_id',$this->temporada->id)->first()) {
                    # nada
                }else{
                    Informe::create(['temporada_id'=>$this->temporada->id,
                                        'razonsocial_id'=>$razon->id]);
                }
            }
        }
    }

    public function render()
    {   $resumes=Resumen::where('temporada_id',$this->temporada->id)->paginate($this->ctd);
        $anticipos=Anticipo::where('temporada_id',$this->temporada->id)->orderBy('id', 'desc')->paginate($this->ctd);
        $anticiposall=Anticipo::where('temporada_id',$this->temporada->id)->orderBy('id', 'desc')->get();
        
        $CostosPackings=CostoPacking::filter($this->filters)->where('temporada_id',$this->temporada->id)->paginate($this->ctd);
        
        $CostosPackingsall=CostoPacking::where('temporada_id',$this->temporada->id)->get();
        
        $materiales=Material::filter($this->filters)->where('temporada_id',$this->temporada->id)->paginate($this->ctd);
        $embarques=Embarque::where('temporada_id',$this->temporada->id)->paginate($this->ctd);
        $embarquestotal=Embarque::where('temporada_id',$this->temporada->id)->get();


        $materialestotal=Material::filter($this->filters)->where('temporada_id',$this->temporada->id)->get();


        $exportacions=Exportacion::where('temporada_id',$this->temporada->id)->paginate($this->ctd);

        $fletes=Flete::where('temporada_id',$this->temporada->id)->paginate($this->ctd);
        $fletestotal=Flete::where('temporada_id',$this->temporada->id)->get();
        
        $fobs=Fob::filter($this->filters)->where('temporada_id',$this->temporada->id)->paginate($this->ctd);
        $fobsall=Fob::filter($this->filters)->where('temporada_id',$this->temporada->id)->get();

        $detalles=Detalle::filter($this->filters)->where('temporada_id',$this->temporada->id)->paginate($this->ctd);
       

        $fobsnacional=Fobnacional::filter($this->filters)->where('temporada_id',$this->temporada->id)->paginate($this->ctd);
        $fobsallnacional=Fobnacional::where('temporada_id',$this->temporada->id)->get();

        $masasbalances=Balancemasa::filter($this->filters)
            ->where('temporada_id', $this->temporada->id)
            ->orderByDesc('updated_at') // Ordenar por precio_fob descendente
            ->paginate($this->ctd);

            
        $masastotal=Proceso::select([
                        'PESO_PRORRATEADO',
                        'CRITERIO',
                        'CALIBRE_REAL',
                        'SEMANA',
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
                    ->filter($this->filters)
                    ->get();

        
        $unique_productores = $masastotal->pluck('PRODUCTOR_RECEP_FACTURACION')->unique();

        $procesosall2=Proceso::where('temporada_id',$this->temporada->id)->get();

        $unique_tipos = $procesosall2->pluck('TIPO')->unique()->sort();


        $unique_especies = $CostosPackingsall->pluck('especie')->unique()->sort();

        $unique_variedades = Variedad::where('temporada_id',$this->temporada->id)->get();
        
        $razons= Razonsocial::filter($this->filters)->whereIn('name', $unique_productores)->orderBy('name', 'asc')->paginate($this->ctd);

        $razonsall=Razonsocial::whereIn('name', $unique_productores)->orderBy('name', 'asc')->get();

        $razonsall2 = $masastotal->pluck('PRODUCTOR_RECEP_FACTURACION')
                    ->unique()
                    ->sortBy(fn($item) => strtolower($item))
                    ->values(); // Reinicia las claves

        $comisions=Comision::all();

        $familias=Familia::where('status','active')->get();

        $gastos = Gasto::where('temporada_id',$this->temporada->id)->get();

        $detallesall=Detalle::where('temporada_id',$this->temporada->id)->get();

        $unique_semanas = $masastotal->pluck('SEMANA')
            ->unique()
            ->sortBy(function ($semana) {
                // Las semanas mayores a 25 (segundo semestre) deben ir primero
                // Les restamos 25 para que queden primero en el orden
                // Las otras las ordenamos después, sumándoles 52 para que vayan al final
                return $semana > 25 ? $semana - 25 : $semana + 52;
            })
            ->values(); // Opcional: para resetear los índices
            

        $unique_calibres = ['4J','3J','2J','J','XL','L'];

        $pormercados = Balancemasatres::whereNotNull('Nave')
            ->where('Nave', '!=', '')
            ->select(
                'Nave',
                'Variedad_Real',
                'Calibre',
                DB::raw('SUM(CASE WHEN mercado2 = "GZ" THEN Fob ELSE 0 END) / SUM(Kilos_prod) as GZ'),
                DB::raw('SUM(CASE WHEN mercado2 = "SH" THEN Fob ELSE 0 END) / SUM(Kilos_prod) as SH'),
                DB::raw('SUM(CASE WHEN mercado2 = "SY" THEN Fob ELSE 0 END) / SUM(Kilos_prod) as SY'),
                DB::raw('SUM(CASE WHEN mercado2 = "SY/SH" THEN Fob ELSE 0 END) / SUM(Kilos_prod) as SY_SH'),
                DB::raw('SUM(CASE WHEN mercado2 = "ZZ" THEN Fob ELSE 0 END) / SUM(Kilos_prod) as ZZ'),
                DB::raw('SUM(CASE WHEN mercado2 = "DL" THEN Fob ELSE 0 END) / SUM(Kilos_prod) as DL'),
                DB::raw('SUM(CASE WHEN mercado2 = "DD" THEN Fob ELSE 0 END) / SUM(Kilos_prod) as DD')
            )
            ->groupBy('Nave', 'Variedad_Real', 'Calibre')
            ->orderBy('Nave')
            ->orderBy('Variedad_Real')
            ->filter($this->filters)
            ->orderByRaw("FIELD(Calibre, '4JD', '4J', '3JD', '3J', '2JD', '2J', 'JD', 'J', 'XLD', 'XL', 'LD', 'L')")
            ->get();
    

        //dd($pormercados->first());

        

        $facturas = Factura::selectRaw('productor,
                                            tipo_docto,
                                            tc as promedio_tc,
                                            monto_neto as total_monto_neto,
                                            iva as total_iva,
                                            total as total_total,
                                            neto as total_neto,
                                            iva2 as total_iva2,
                                            total2 as total_total2,
                                            saldo as total_saldo,
                                            cantidad as total_cantidad,
                                            usd_kg as total_usd_kg,
                                            dolares as total_dolares,
                                            valor as total_valor,
                                            total_liq as total_total_liq,
                                            anticipo as total_anticipo,
                                            a_pagar as total_a_pagar,
                                            nd as total_nd')->get();




        return view('livewire.temporada-show',compact('facturas','pormercados','unique_tipos','unique_calibres','unique_semanas','gastos','detallesall','detalles','familias','fobsallnacional','fobsall','embarques','embarquestotal','fletestotal','materialestotal','masastotal','fobs','fobsnacional','anticiposall','anticipos','unique_especies','unique_variedades','resumes','CostosPackings','CostosPackingsall','materiales','exportacions','razons','comisions','fletes','masasbalances','razonsall','razonsall2'));
    }

    public function togglePropio($razonId)
    {
        // Encontrar la razón social por su ID
        $razon = RazonSocial::find($razonId);

        // Cambiar el estado de 'is_propio'
        $razon->is_propio = !$razon->is_propio;
        
        // Guardar el cambio en la base de datos
        $razon->save();

        // Definir el mensaje para la razón social actual
        $message = $razon->is_propio ? 'agregado' : 'eliminado';
        session()->flash('status_' . $razonId, "{$message}.");

        // Recargar la lista de razones sociales para reflejar los cambios
      //  $this->razons = RazonSocial::all();
    }

    public function set_view($vista){
        $this->vista=$vista;
    }


    public function set_informeid($productor){
        $this->informedit=$productor;
    
        $kgrazon=0;
        $ventasrazon=0;
        $venta2srazon=0;
        $venta3srazon=0;
        $ventasrazon2=0;
        $costosrazon=0;

        $costocomercial=0;

        $costo2srazon=0;
        $margenrazon=0;
        $gastosrazon=0;
        $anticiposrazon=0;

        
        $razonsall=Razonsocial::all();

        $masastotal=Proceso::select([
            'PESO_PRORRATEADO',
            'CRITERIO',
            'CALIBRE_REAL',
            'SEMANA',
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
        ->filter($this->filters)
        ->get();



              $razonExiste = $razonsall->where('name', $productor)->first();
              if ($razonExiste) {
                $name=$razonExiste->name;

                $this->difcambio=$razonExiste->informes->where('temporada_id',$this->temporada->id)->reverse()->first()->diferencia_tipodecambio;

              }else {
                $name="null";
              }
             

         
            foreach ($masastotal->filter(function($item) use ($name) {
                    return trim($item->PRODUCTOR_RECEP_FACTURACION) === trim($name);
                  }) as $item){
                    $peso = floatval($item->PESO_PRORRATEADO);
                   // $pesototalaliquidar += floatval($item->PESO_PRORRATEADO);
                  if ($item->fob) {
                    $tarifafinal=0;
                    $tarifafinal2=0;
                    if ($item->fob->tarifas->count()>0) {
                        $tarifafinal=$item->fob->fob_kilo_salida;
                        $tarifafinal2=$item->fob->tarifas->reverse()->first()->tarifa;
                        $tarifafinal3=$item->fob->tarifas->reverse()->first()->tarifa_fc;
                    }
                    $tarifaAplicada = ($item->CRITERIO == "COMERCIAL") ? $tarifafinal2 : $tarifafinal;
                   
                    if ($item->CRITERIO=="EXPORTACIÓN" || $item->CRITERIO=="COMERCIAL EMBALADA") {
                      $ventasrazon += floatval($tarifaAplicada * $peso);
                      $venta2srazon += floatval($tarifafinal3 * $peso);
                    
                   //   $ventatotalaliquidar+= floatval($tarifaAplicada * $peso);
                     // $venta2totalaliquidar+= floatval($tarifafinal3 * $peso);
                    }

                    if ($item->CRITERIO=="COMERCIAL") {
                      $venta3srazon += floatval($tarifaAplicada * $peso);
                   //   $venta3totalaliquidar += floatval($tarifaAplicada * $peso);
                    }
                    

                    if ($item->CRITERIO=="EXPORTACIÓN") {
                      $margenrazon += floatval($tarifafinal3 * $peso*0.08);
                    //  $margentotalaliquidar += floatval($tarifafinal3 * $peso*0.08);
                    }
                  }

                  if ($item->CRITERIO=="COMERCIAL") {
                    $costo2srazon += floatval($item->costo_proceso);
                   // $costo2totalaliquidar += floatval($item->costo_proceso);
                  }

                  $costosrazon += floatval($item->costo_proceso+$item->costo_materiales+$item->otros_costos);
                  //$costototalaliquidar += floatval($item->costo_proceso+$item->costo_materiales+$item->otros_costos);

                  $costo2srazon += floatval($item->costo);
                  //$costo2totalaliquidar += floatval($item->costo);
                  
                  $kgrazon += floatval($item->PESO_PRORRATEADO);
                  $gastosrazon += floatval($item->gastos);
                  //$gastototalaliquidar += floatval($item->gastos);
                
                  $anticiposrazon += floatval($item->anticipos);
                  //$anticipototalaliquidar += floatval($item->anticipos);

                 
            }
             
            
            if($this->difcambio=$razonExiste->informes->where('temporada_id',$this->temporada->id)->reverse()->first()->total_liquidado){
                $this->total_liquidado=$razonExiste->informes->where('temporada_id',$this->temporada->id)->reverse()->first()->total_liquidado;
            }else{
                $this->total_liquidado=$venta2srazon+$venta3srazon-$costo2srazon-$margenrazon-$gastosrazon;
            }
            
            //$totalaliquidar+=$aliquidar;
      


    }

    

    public function save_informeid($productor){
        //dd($productor);
        $razonExiste = Razonsocial::where('name', $productor)->first();
        if($razonExiste->informes->count()==1){
            Informe::create(['temporada_id'=>$this->temporada->id,
                                    'razonsocial_id'=>$razonExiste->id]);
        }

        foreach($razonExiste->informes->where('temporada_id',$this->temporada->id) as $informe){
            $informe->update(['diferencia_tipodecambio'=>$this->difcambio]);
        }
       
        $this->informedit=null;
        $this->difcambio=null;
        //$this->reset(['informedit','difcambio']);
    }


    public function set_fobid($fobid){
        $this->fobid=$fobid;
        $this->preciofob=Fob::find($fobid)->fob_kilo_salida;
    }

    public function save_fobid(){
        $fob=Fob::find($this->fobid);
        $fob->update(['fob_kilo_salida'=>$this->preciofob]);    
        $this->reset(['preciofob','fobid']);
        
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

    public function set_masaid($masaid){
        $this->masaid=$masaid;
        $this->preciomasa=Balancemasa::find($masaid)->precio_fob;
    }

    public function save_masaid(){
        $masa=Balancemasa::find($this->masaid);
        $masa->update(['precio_fob'=>$this->preciomasa]);    
        $this->reset(['preciomasa','masaid']);
        
    }

    public function exportpdf(Informe $informe){
        $razonsocial=Razonsocial::find($informe->razonsocial_id);
        $temporada=Temporada::find($informe->temporada_id);

        
        $masas=Balancemasa::where('temporada_id',$temporada->id)->where('productor_recep',$razonsocial->name)->get();

        $masas = Proceso::selectRaw('CALIBRE_REAL as calibre_real, VARIEDAD as variedad, CANT as cantidad, PESO_PRORRATEADO as peso_prorrateado, costo , costo_proceso , CRITERIO , NORMA, fob_id , TIPO as tipo, SEMANA as semana')
            ->where('temporada_id', $temporada->id)
            ->where('PRODUCTOR_RECEP_FACTURACION', 'like', '%' . $razonsocial->name . '%')
            ->with('fob.tarifas') // Esto carga la relación fob con sus tarifas
            ->get();
            

        $unique_variedades = $masas->pluck('variedad')->unique()->sort();

        $packings=CostoPacking::where('temporada_id',$temporada->id)->where('n_productor',$razonsocial->name)->get();

        $comisions=Comision::where('temporada_id',$temporada->id)->where('productor',$razonsocial->name)->get();

        $anticipos=Anticipo::where('temporada_id',$temporada->id)->where('productor',$razonsocial->name)->get();
        $detalles=Detalle::where('temporada_id',$temporada->id)->where('n_productor',$razonsocial->name)->get();

        $unique_calibres = $masas->pluck('calibre')->unique()->sort();
        $unique_semanas = $masas->pluck('semana')->unique()->sort();
        //dd($unique_semanas);
        $unique_categorias = $masas->pluck('tipo')->unique()->sort();
        $fobs = Fob::where('temporada_id',$temporada->id)->get();
        

        $analisis = AnalisisMultiresiduo::where('temporada_id',$temporada->id)->where('productor',$razonsocial->name)->get();
        $certificacions = Certificacion::where('temporada_id',$temporada->id)->where('productor',$razonsocial->name)->get();
        $materials = Material::where('temporada_id',$temporada->id)->where('productor',$razonsocial->name)->get();

        $exportacions=Exportacion::where('temporada_id',$temporada->id)->get();
        $materialestotal=Material::where('temporada_id',$temporada->id)->get();
        $categoria_mod=null;

        $variedades = Variedad::whereIn('name', $unique_variedades)->get();
        $graficos=[];
        foreach ($variedades->reverse() as $variedad){
            $graficos[]='https://v1.nocodeapi.com/greenex/screen/CbrYLdYsupiNNAot/screenshot?url=https://greenexweb.cl/grafico/'.$razonsocial->id.'/'.$temporada->id.'/'.$variedad->id.'.html&viewport=1400x600';
        }
        $pdf = Pdf::loadView('pdf.liquidacion', [   'razonsocial' => $razonsocial,
                                                    'masas' => $masas,
                                                    'packings'=>$packings,
                                                    'comisions'=>$comisions,
                                                    'unique_variedades'=>$unique_variedades,
                                                    'unique_calibres'=>$unique_calibres,
                                                    'unique_semanas'=>$unique_semanas,
                                                    'fobs'=>$fobs,
                                                    'graficos'=>$graficos,
                                                    'unique_categorias'=>$unique_categorias,
                                                    'anticipos'=>$anticipos,
                                                    'detalles'=>$detalles,
                                                    'analisis'=>$analisis,
                                                    'certificacions'=>$certificacions,
                                                    'materials'=>$materials,
                                                    'exportacions'=>$exportacions,
                                                    'materialestotal'=>$materialestotal,
                                                    'informe_edit'=>$informe,
                                                    'categoria_mod'=>$categoria_mod,
                                                    'temporada'=>$temporada]);

        $pdfContent = $pdf->output();
        $filename = 'Liquidacion '.$razonsocial->name.'.pdf';
                                                    
        Storage::put('pdf-liquidaciones/' . $filename, $pdfContent);

        $informe->update([
            'informe'=>'pdf-liquidaciones/'.$filename
        ]);

        return $pdf->stream('Liq. '.$razonsocial->name.'.pdf');
        
    }

    public function exportpdf2(Informe $informe){
        $razonsocial=Razonsocial::find($informe->razonsocial_id);
        $temporada=Temporada::find($informe->temporada_id);

        $masas=Balancemasa::where('temporada_id',$temporada->id)->where('productor_recep',$razonsocial->name)->get();

        $masas = Proceso::selectRaw('CALIBRE_REAL as calibre_real, VARIEDAD as variedad, CANT as cantidad, PESO_PRORRATEADO as peso_prorrateado, costo , costo_proceso , CRITERIO , NORMA, fob_id , TIPO as tipo, SEMANA as semana')
            ->where('temporada_id', $temporada->id)
            ->where('PRODUCTOR_RECEP_FACTURACION', 'like', '%' . $razonsocial->name . '%')
            ->with('fob.tarifas') // Esto carga la relación fob con sus tarifas
            ->get();
            
        $categoria_mod=null;

        $unique_variedades = $masas->pluck('variedad')->unique()->sort();

        $packings=CostoPacking::where('temporada_id',$temporada->id)->where('n_productor',$razonsocial->name)->get();

        $comisions=Comision::where('temporada_id',$temporada->id)->where('productor',$razonsocial->name)->get();

        $anticipos=Anticipo::where('temporada_id',$temporada->id)->where('productor',$razonsocial->name)->get();
        $detalles=Detalle::where('temporada_id',$temporada->id)->where('n_productor',$razonsocial->name)->get();

        $unique_calibres = $masas->pluck('calibre')->unique()->sort();
        $unique_semanas = $masas->pluck('semana')->unique()->sort();
        $unique_categorias = $masas->pluck('tipo')->unique()->sort();
        $fobs = Fob::where('temporada_id',$temporada->id)->get();
        

        $analisis = AnalisisMultiresiduo::where('temporada_id',$temporada->id)->where('productor',$razonsocial->name)->get();
        $certificacions = Certificacion::where('temporada_id',$temporada->id)->where('productor',$razonsocial->name)->get();
        $materials = Material::where('temporada_id',$temporada->id)->where('productor',$razonsocial->name)->get();

        $exportacions=Exportacion::where('temporada_id',$temporada->id)->get();
        $materialestotal=Material::where('temporada_id',$temporada->id)->get();
        $facturas=Factura::where('temporada_id',$temporada->id)->where('productor',$razonsocial->name)->get();
        
        

        $variedades = Variedad::whereIn('name', $unique_variedades)->get();
        $graficos=[];
        foreach ($variedades->reverse() as $variedad){
            $graficos[]='https://v1.nocodeapi.com/greenex/screen/CbrYLdYsupiNNAot/screenshot?url=https://greenexweb.cl/grafico/'.$razonsocial->id.'/'.$temporada->id.'/'.$variedad->id.'.html&viewport=1400x600';
        }
        $pdf = Pdf::loadView('pdf.nota', [   'razonsocial' => $razonsocial,
                                                    'masas' => $masas,
                                                    'packings'=>$packings,
                                                    'comisions'=>$comisions,
                                                    'unique_variedades'=>$unique_variedades,
                                                    'unique_calibres'=>$unique_calibres,
                                                    'unique_semanas'=>$unique_semanas,
                                                    'fobs'=>$fobs,
                                                    'graficos'=>$graficos,
                                                    'unique_categorias'=>$unique_categorias,
                                                    'anticipos'=>$anticipos,
                                                    'detalles'=>$detalles,
                                                    'analisis'=>$analisis,
                                                    'certificacions'=>$certificacions,
                                                    'materials'=>$materials,
                                                    'exportacions'=>$exportacions,
                                                    'materialestotal'=>$materialestotal,
                                                    'facturas'=>$facturas,
                                                    'temporada'=>$temporada,
                                                    'informe_edit'=>$informe,
                                                    'categoria_mod'=>$categoria_mod]);

        $pdfContent = $pdf->output();
        $filename = 'Nota '.$razonsocial->name.'.pdf';
                                                    
        Storage::put('pdf-liquidaciones/' . $filename, $pdfContent);

        $informe->update([
            'nota'=>'pdf-liquidaciones/'.$filename
        ]);

        return $pdf->stream('Liq. '.$razonsocial->name.'.pdf');
        
    }

    public function set_exportacionedit_id($id){
        $this->exportacionedit_id=$id;
        
    }

    public function updatevariedades(){

       foreach($this->masastotal as $masa){
            $variedad=Variedad::where('name',$masa->n_variedad)->first();
            if ($variedad){

            }else{
                Variedad::create(['name'=>$masa->n_variedad]);
            }
       }
        
    }

    public function exportacion_destroy(Exportacion $exportacion){
        $exportacion->delete();
    }

    public function flete_destroy(Flete $flete){
        $flete->delete();
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
