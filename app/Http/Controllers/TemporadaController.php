<?php

namespace App\Http\Controllers;

use App\Imports\AnticipoImport;
use App\Imports\Balance2Import;
use App\Imports\Balance3Import;
use App\Imports\Balance4Import;
use App\Imports\BalanceImport;
use App\Imports\ComisionImport;
use App\Imports\EmbarqueImport;
use App\Imports\ExportacionImport;
use App\Imports\FacturasImport;
use App\Imports\FleteImport;
use App\Imports\FobImport;
use App\Imports\GastoImport;
use App\Imports\MaterialImport;
use App\Imports\PackingImport;
use App\Imports\ProduccionImport;
use App\Imports\ProductorImport;
use App\Imports\ResumenImport;
use App\Imports\VentacomercialImport;
use App\Models\AnalisisMultiresiduo;
use App\Models\Anticipo;
use App\Models\Balancemasa;
use App\Models\Balancemasacuatro;
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
use App\Models\Fobdespacho;
use App\Models\Fobnacional;
use App\Models\Gasto;
use App\Models\Material;
use App\Models\Proceso;
use App\Models\Razonsocial;
use App\Models\Resumen;
use App\Models\Temporada;
use App\Models\Transporte;
use App\Models\Variedad;
use App\Models\Ventacomercial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Facades\Excel as FacadesExcel;

class TemporadaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function graficogenerate(Razonsocial $razonsocial, Temporada $temporada, Variedad $variedad)
    {   
        $masas=Balancemasa::where('temporada_id',$temporada->id)->where('c_productor',$razonsocial->csg)->get();
        $unique_variedades = $masas->pluck('n_variedad')->unique()->sort();
        $fobs = Fob::where('temporada_id',$temporada->id)->get();
        $unique_calibres = $masas->pluck('n_calibre')->unique()->sort();

        $unique_variedades = $masas->where('n_variedad', $variedad->name)->pluck('n_variedad')->unique()->sort();

        return view('grafico.variedad',compact('unique_calibres','unique_variedades','razonsocial','temporada','variedad','unique_variedades','masas','fobs'));
    }

    public function graficovariedad(Temporada $temporada, $variedad)
    {   $variedad=Variedad::find($variedad);
        return view('temporadas.graficovariedad',compact('temporada','variedad'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('temporadas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required'
        ]);

        $temporada = Temporada::create($request->all());

        return redirect()->route('temporada.dataupload',$temporada);
    }

    /**
     * Display the specified resource.
     */
    public function show(Temporada $temporada)
    {   $resumes=Resumen::where('temporada_id',$temporada->id)->get();
        $CostosPackings=CostoPacking::where('temporada_id',$temporada->id)->get();

        $masitas=Proceso::where('temporada_id',$temporada->id)->paginate(3);
        if ($masitas->count()>0) {
            return view('temporadas.show',compact('temporada','resumes','CostosPackings'));
        } else {
            return redirect()->route('temporada.dataupload',$temporada);
        }
        
        
       
    }

    public function resume(Temporada $temporada)
    {   $resumes=Resumen::where('temporada_id',$temporada->id)->get();
        return view('temporadas.resume',compact('temporada','resumes'));
    }

    public function clientes(Temporada $temporada)
    {   return view('temporadas.clientes',compact('temporada'));
    }

    public function grafico(Temporada $temporada)
    {   return view('temporadas.grafico',compact('temporada'));
    }

    public function saldoaliquidar(Temporada $temporada)
    {   return view('temporadas.saldo',compact('temporada'));
    }

    public function saldoaliquidar2(Temporada $temporada)
    {   return view('temporadas.saldo2',compact('temporada'));
    }

    public function comision(Temporada $temporada)
    {   $comisions=Comision::where('temporada_id',$temporada->id)->get();
        return view('temporadas.comision',compact('temporada','comisions'));
    }

    public function dataupload(Temporada $temporada)
    {   
        return view('temporadas.dataupload',compact('temporada'));
    }

    public function datauploadliq(Temporada $temporada)
    {   
        return view('temporadas.datauploadliq',compact('temporada'));
    }

    public function datauploaddesp(Temporada $temporada)
    {   $despachos=Balancemasatres::where('temporada_id',$temporada->id)->paginate(50);
        $despachosall=Balancemasatres::where('temporada_id',$temporada->id)->get();

        $unique_folios = $despachosall->pluck('Folio')->unique()->sort();
        
        return view('temporadas.datauploaddesp',compact('temporada','despachos','despachosall','unique_folios'));
    }

    public function datauploadcomercial(Temporada $temporada)
    {   $ventacomercials=Ventacomercial::where('temporada_id',$temporada->id)->paginate(50);
        $ventacomercialsall=Ventacomercial::where('temporada_id',$temporada->id)->get();
        
        return view('temporadas.datauploadcomercial',compact('temporada','ventacomercials','ventacomercialsall'));
    }

    public function datauploadcuentacorriente(Temporada $temporada)
    {   
        return view('temporadas.datauploadcuentacorriente',compact('temporada'));
    }

    public function datauploaddet(Temporada $temporada)
    {    $detalle_liquidacions = Balancemasacuatro::where('temporada_id', $temporada->id)
            ->select('Variedad', 'N_Pallet', 'CALIBRE', 'PESO_TOTAL', 'LIQ_PRODUCTOR')
            ->get();

        $unique_folios = $detalle_liquidacions->pluck('N_Pallet')->unique()->sort();

        return view('temporadas.datauploaddet',compact('temporada','unique_folios'));
    }

    public function datauploadprod(Temporada $temporada)
    {   $procesos=Proceso::where('temporada_id',$temporada->id)->paginate(25);
        $procesosall=Proceso::where('temporada_id',$temporada->id)->get();

        return view('temporadas.datauploadprod',compact('temporada','procesos','procesosall'));
    }

    public function datauploadfacturacion(Request $request)
    {    $request->validate([
          'file'=>'required|mimes:csv,xlsx'
        ]);

        $file = $request->file('file');

        $masas=Factura::where('temporada_id',$request->temporada)->get();
        
        foreach ($masas as $masa){
            $masa->delete();
        }

        FacadesExcel::import(new FacturasImport($request->temporada),$file);

        $temporada=Temporada::find($request->temporada);

        return redirect()->route('temporada.finanzas',$temporada)->with('info','Importación realizada con exito');
    }

    public function costocaja(Temporada $temporada)
    {   $procesos=Proceso::where('temporada_id',$temporada->id)->paginate(25);
        $procesosall=Proceso::where('temporada_id',$temporada->id)->get();

        return view('temporadas.costocaja',compact('temporada','procesos','procesosall'));
    }

    public function materiales(Temporada $temporada)
    {   $materiales=Material::where('temporada_id',$temporada->id)->paginate(5);
         return view('temporadas.materiales',compact('temporada','materiales'));
    }

    public function packing(Temporada $temporada)
    {   $resumes=Resumen::where('temporada_id',$temporada->id)->get();
        $CostosPackings=CostoPacking::where('temporada_id',$temporada->id)->get();
        return view('temporadas.packing',compact('temporada','CostosPackings','resumes'));
    }

    public function exportacion(Temporada $temporada)
    {   $exportacions= Exportacion::where('temporada_id',$temporada->id)->get();
        return view('temporadas.exportacion',compact('temporada','exportacions'));
    }
    public function flete(Temporada $temporada)
    {   $fletes=Flete::where('temporada_id',$temporada->id)->get();
        return view('temporadas.flete',compact('temporada','fletes'));
    }

    public function balancemasa(Temporada $temporada)
    {  
        $masitas=Balancemasa::where('temporada_id',$temporada->id)->paginate(3);

        return view('temporadas.balancemasa',compact('temporada','masitas'));
    }

    public function fob(Temporada $temporada)
    {  
        $fob=Fob::where('temporada_id',$temporada->id)->paginate(3);

        return view('temporadas.fob',compact('temporada','fob'));
    }

    public function fobnacional(Temporada $temporada)
    {  
        $fob=Fobnacional::where('temporada_id',$temporada->id)->paginate(3);

        return view('temporadas.fobnacional',compact('temporada','fob'));
    }

    public function otrosgastos(Temporada $temporada)
    {  
        $otrosgastos=Balancemasa::where('temporada_id',$temporada->id)->paginate(3);

        return view('temporadas.otrosgastos',compact('temporada','otrosgastos'));
    }

    public function finanzas(Temporada $temporada)
    {  
        $finanzas=Balancemasa::where('temporada_id',$temporada->id)->paginate(3);

        return view('temporadas.finanzas',compact('temporada','finanzas'));
    }
    
    public function anticipos(Temporada $temporada)
    {  
        $anticipos=Anticipo::where('temporada_id',$temporada->id)->paginate(3);

        return view('temporadas.anticipos',compact('temporada','anticipos'));
    }

    public function gastos(Temporada $temporada)
    {  
        $gastos=Gasto::where('temporada_id',$temporada->id)->paginate(3);

        return view('temporadas.gastos',compact('temporada','gastos'));
    }

    public function precio_original(Temporada $temporada)
    {  
        return view('temporadas.precio-original',compact('temporada'));
    }

    public function fobdespacho(Temporada $temporada)
    {  
        return view('temporadas.fobdespacho',compact('temporada'));
    }

    public function precioajustado(Temporada $temporada)
    {  
        return view('temporadas.precioajustado',compact('temporada'));
    }

  

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Temporada $temporada)
    {
        return view('temporadas.edit',compact('temporada'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Temporada $temporada)
    {   $temporada->update($request->all());

        if ($request->has([
            'pti',
            'tecomex',
            'coface',
            'safe_cargo',
            'transportes',
            'gastos_de_exportacion',
            'fedex',
            'seguro_carga_fester',
            'seguro_carga_maerk',
            'asoex'
        ])) {
        
       
       
        $procesosall=Proceso::where('temporada_id',$temporada->id)->get();

        $kilosprorrateados=0;
        $nulos=0;
        $ingresos=0;
        $totalmateriales=0;
        $totalprocesos=0;
        $peso2=0;
         $peso25=0;
         $peso5=0;
         $peso10=0;
         
        foreach ($procesosall as $item){
                if ($item->PESO_CAJA=="2.2"){
                                    $peso2+=$item->PESO_PRORRATEADO;
                }elseif ($item->PESO_CAJA=="2.5"){
                                      $peso25+=$item->PESO_PRORRATEADO;
        
                }elseif ($item->PESO_CAJA=="5"){
                                       $peso5+=$item->PESO_PRORRATEADO;
                }elseif ($item->PESO_CAJA=="10"){
                                        $peso10+=$item->PESO_PRORRATEADO;
                }elseif ($item->CRITERIO=="COMERCIAL"){
                                        $totalprocesos+=$item->PESO_PRORRATEADO*$temporada->procesocom;
                }
        }

        $totalotroscostos=  $temporada->pti +
                            $temporada->tecomex +
                            $temporada->coface +
                            $temporada->safe_cargo +
                            $temporada->transportes +
                            $temporada->gastos_de_exportacion +
                            $temporada->fedex +
                            $temporada->seguro_carga_fester +
                            $temporada->seguro_carga_maerk +
                            $temporada->asoex;

            foreach ($procesosall as $item){
                if($item->PESO_CAJA=="2.2" || $item->PESO_CAJA=="2.5" || $item->PESO_CAJA=="5" || $item->PESO_CAJA=="10"){
                    $item->update(['otros_gastos'=>$totalotroscostos*floatval($item->PESO_PRORRATEADO)/($peso2+$peso25+$peso5+$peso10)]) ;
                }elseif($item->CRITERIO=="COMERCIAL"){
                    $item->update(['otros_gastos'=>0]) ;
                }
            }
            
        }

        return redirect()->back()->with('info','Datos actualizados con éxito.');;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Temporada $temporada)
    {
        $temporada->delete();
        return redirect()->back();
    }
    

    public function importdata(Request $request)
    {    $request->validate([
            'file'=>'required|mimes:csv,xlsx'
        ]);

        $file = $request->file('file');

        FacadesExcel::import(new ResumenImport($request->temporada),$file);

        $temporada=Temporada::find($request->temporada);
        return redirect()->route('temporada.resume',$temporada)->with('info','Importación realizada con exito');
    }

    public function importCostosPacking(Request $request)
    {    $request->validate([
            'file'=>'required|mimes:csv,xlsx'
        ]);

        $file = $request->file('file');

        $masas=CostoPacking::where('temporada_id',$request->temporada)->get();
        
        foreach ($masas as $masa){
            $masa->delete();
        }

        FacadesExcel::import(new PackingImport($request->temporada),$file);

        $temporada=Temporada::find($request->temporada);

        return redirect()->route('temporada.packing',$temporada)->with('info','Importación realizada con exito');
    }

    public function importMateriales(Request $request)
    {    $request->validate([
            'file'=>'required|mimes:csv,xlsx'
        ]);

        $file = $request->file('file');

        $masas=Material::where('temporada_id',$request->temporada)->get();
        
        foreach ($masas as $masa){
            $masa->delete();
        }

        FacadesExcel::import(new MaterialImport($request->temporada),$file);

        $temporada=Temporada::find($request->temporada);

        return redirect()->route('temporada.materiales',$temporada)->with('info','Importación realizada con exito');
    }

    public function importVentacomercial(Request $request)
    {
        $request->validate([
            'file'=>'required|mimes:csv,xlsx'
        ]);

        $file = $request->file('file');

        $masas=Ventacomercial::where('temporada_id',$request->temporada)->get();
        
        foreach ($masas as $masa){
            $masa->delete();
        }

        FacadesExcel::import(new VentacomercialImport($request->temporada),$file);

        $temporada=Temporada::find($request->temporada);

        return redirect()->route('temporada.datauploadcomercial',$temporada)->with('info','Importación realizada con exito');
    }

    public function importProductores(Request $request)
    {
        $request->validate([
            'file'=>'required|mimes:csv,xlsx'
        ]);

        $file = $request->file('file');

        FacadesExcel::import(new ProductorImport,$file);

    
        return redirect()->route('razonsocial.index')->with('info','Importación realizada con exito');
    }

    public function exportacionedit(Exportacion $exportacion,Temporada $temporada)
    {   
        return view('exportacion.edit',compact('exportacion','temporada'));
    }

    public function gastoedit(Gasto $gasto,Temporada $temporada)
    {   $familias=Familia::pluck('name','id');
        return view('gastos.edit',compact('gasto','temporada','familias'));
    }

    public function exportacionupdate(Request $request,Exportacion $exportacion)
    {   
        $exportacion->update($request->all());
        return redirect(route('temporada.exportacion',$exportacion->temporada)."/#informacion");

    }

    public function fleteedit(Flete $flete,Temporada $temporada)
    {   
        return view('flete.edit',compact('flete','temporada'));
    }

    public function fleteupdate(Request $request,Flete $flete)
    {   
        $flete->update($request->all());
        return redirect(route('temporada.flete',$flete->temporada)."/#informacion");

    }

    public function comisionedit(Comision $comision,Temporada $temporada)
    {   
        return view('comision.edit',compact('comision','temporada'));
    }

    public function variedadupdate(Temporada $temporada)
    {   $masas=Proceso::where('temporada_id',$temporada->id)->get();
        foreach($masas as $masa){
            $variedad=Variedad::where('name',$masa->VARIEDAD)->where('temporada_id',$temporada->id)->first();
            if ($variedad){

            }else{
                if($masa->VARIEDAD){
                    Variedad::create(['name'=>$masa->VARIEDAD,
                                    'temporada_id'=>$temporada->id]);
                }
            }
       }
        return redirect()->back();
    }

    public function fobupdate(Temporada $temporada)
    {   $masas=Balancemasa::where('temporada_id',$temporada->id)->whereNull('precio_fob')->get();
        $fobsall=Fob::where('temporada_id',$temporada->id)->get();
        $fobnacionalsall=Fobnacional::where('temporada_id',$temporada->id)->get();
        $nro=0;
        foreach($masas as $masa){
                $calibre='';
                if ($masa->calibre=='4J' || $masa->calibre=='4JD' || $masa->calibre=='4JDD'){
				    $calibre='4J';
									
                    if ($masa->calibre=='4JD' || $masa->calibre=='4JDD'){
                          $color='Dark';
                    }else{
                      $color='Light';
                    }
        		}
				if ($masa->calibre=='3J' || $masa->calibre=='3JD' || $masa->calibre=='3JDD'){
                        $calibre='3J';
                  if ($masa->calibre=='3JD' || $masa->calibre=='3JDD'){
                          $color='Dark';
                    }else{
                      $color='Light';
                    }
				}
				if ($masa->calibre=='2J' || $masa->calibre=='2JD' || $masa->calibre=='2JDD'){
                    $calibre='2J';
                    if ($masa->calibre=='2JD' || $masa->calibre=='2JDD'){
                            $color='Dark';
                       
                    }else{
                        $color='Light';
                    }
				}
				if ($masa->calibre=='J' || $masa->calibre=='JD' || $masa->calibre=='JDD'){
                        $calibre='J';
                    if ($masa->calibre=='JD' || $masa->calibre=='JDD'){
                            $color='Dark';
                    }else{
                        $color='Light';
                    }
                }
			    if ($masa->calibre=='XL' || $masa->calibre=='XLD' || $masa->calibre=='XLDD'){
                    $calibre='XL';
                  if ($masa->calibre=='XLD' || $masa->calibre=='XLDD'){
                          $color='Dark';
                    }else{
                      $color='Light';
                    }
                }

                if ($masa->criterio=='EXPORTACIÓN') {
                    foreach ($fobsall->where('n_variedad',$masa->variedad)->where('semana',$masa->semana) as $fob){
                    
                        if ($fob->n_calibre==$masa->calibre_real && strtolower($fob->color)==strtolower($masa->color_final)){
                                $masa->update(['precio_fob'=>$fob->fob_kilo_salida]);
                                $nro+=1;
                        break;
                        }
                    }
                 } else {
                    foreach ($fobnacionalsall->where('n_variedad',$masa->variedad)->where('semana',$masa->semana) as $fob){
                        if ($masa->calibre_real=='MER' || $masa->calibre_real=='DES') {
                            $masa->update(['precio_fob'=>0]);
                            $nro+=1;
                        } elseif ($fob->n_calibre==$masa->calibre_real){
                                $masa->update(['precio_fob'=>$fob->fob_kilo_salida]);
                                $nro+=1;
                        break;
                        }
                    }
                 }
               

       }

        return redirect()->back()->with('info',$nro.' Actualizados con Éxito');
    }

    public function fobupdate2(Temporada $temporada)
    {   $masas = Proceso::where('temporada_id', $temporada->id)
            ->whereNull('fob_id')
            ->whereIn('CRITERIO', ['EXPORTACIÓN', 'COMERCIAL EMBALADA'])
            ->get();

        $masas2 = Proceso::where('temporada_id', $temporada->id)
            ->whereIn('CRITERIO', ['EXPORTACIÓN', 'COMERCIAL EMBALADA'])
            ->get();

        $peso_total =Proceso::where('temporada_id', $temporada->id)
                ->whereIn('CRITERIO', ['EXPORTACIÓN', 'COMERCIAL EMBALADA'])
                ->sum('PESO_PRORRATEADO');

        $fobsall=Fob::where('temporada_id',$temporada->id)->get();

        $totalotroscostos=  $temporada->pti + 
                            $temporada->tecomex +
                            $temporada->coface +
                            $temporada->safe_cargo +
                            $temporada->transportes +
                            $temporada->gastos_de_exportacion +
                            $temporada->fedex +
                            $temporada->seguro_carga_fester +
                            $temporada->seguro_carga_maerk +
                            $temporada->asoex;
        $nro=0;
        $nro2=0;
        $nro3=0;
        $nro4=0;

        $anticipos=Anticipo::where('temporada_id',$temporada->id)->get();
       
        $productores_cantidad = $anticipos->groupBy('productor')->map(function ($group) {
            // Sumar las cantidades de cada grupo de productor
            return [
                'productor' => $group->first()->productor,
                'total_cantidad' => $group->sum('cantidad_usd') // Asumiendo que la cantidad es 'cantidad_usd'
            ];
        });

        //$cantidad_anticipos=$productores_cantidad->sum('total_cantidad');
        //dd($cantidad_anticipos);


        // Iterar sobre la colección de productores con sus cantidades
       
      
        foreach($masas as $masa){
                $calibre='';
                if ($masa->calibre=='4J' || $masa->calibre=='4JD' || $masa->calibre=='4JDD'){
				    $calibre='4J';
									
                    if ($masa->calibre=='4JD' || $masa->calibre=='4JDD'){
                          $color='Dark';
                    }else{
                      $color='Light';
                    }
        		}
				if ($masa->calibre=='3J' || $masa->calibre=='3JD' || $masa->calibre=='3JDD'){
                        $calibre='3J';
                  if ($masa->calibre=='3JD' || $masa->calibre=='3JDD'){
                          $color='Dark';
                    }else{
                      $color='Light';
                    }
				}
				if ($masa->calibre=='2J' || $masa->calibre=='2JD' || $masa->calibre=='2JDD'){
                    $calibre='2J';
                    if ($masa->calibre=='2JD' || $masa->calibre=='2JDD'){
                            $color='Dark';
                       
                    }else{
                        $color='Light';
                    }
				}
				if ($masa->calibre=='J' || $masa->calibre=='JD' || $masa->calibre=='JDD'){
                        $calibre='J';
                    if ($masa->calibre=='JD' || $masa->calibre=='JDD'){
                            $color='Dark';
                    }else{
                        $color='Light';
                    }
                }
			    if ($masa->calibre=='XL' || $masa->calibre=='XLD' || $masa->calibre=='XLDD'){
                    $calibre='XL';
                  if ($masa->calibre=='XLD' || $masa->calibre=='XLDD'){
                          $color='Dark';
                    }else{
                      $color='Light';
                    }
                }

                
                
                    foreach ($fobsall as $fob){
                       
                        
                        if ($fob->n_calibre==$masa->CALIBRE_REAL && $fob->n_variedad==$masa->VARIEDAD && $fob->semana==$masa->SEMANA){
                            
                                $masa->update(['fob_id'=>$fob->id]);

                                $nro+=1;
                                break;
                        }
                    }
                 
               

       }

        foreach($masas2 as $masa){
       
                    if ($masa->PESO_CAJA=="2.2"){
                        $costo_proceso=$masa->PESO_PRORRATEADO*$temporada->proceso22;
                        $costo_materiales=$masa->PESO_PRORRATEADO*$temporada->materiales22;
                        
                    } elseif ($masa->PESO_CAJA=="2.5"){
                        $costo_proceso=$masa->PESO_PRORRATEADO*$temporada->proceso25;
                        $costo_materiales=$masa->PESO_PRORRATEADO*$temporada->materiales25;

                    }elseif ($masa->PESO_CAJA=="5"){
                        $costo_proceso=$masa->PESO_PRORRATEADO*$temporada->proceso5;
                         $costo_materiales=$masa->PESO_PRORRATEADO*$temporada->materiales5;

                    }elseif ($masa->PESO_CAJA=="10"){
                        $costo_proceso=$masa->PESO_PRORRATEADO*$temporada->proceso10;
                        $costo_materiales=$masa->PESO_PRORRATEADO*$temporada->materiales10;
                    }

                    if($costo_proceso>0 || $costo_materiales>0 || $totalotroscostos>0){
                        $masa->update([ 'costo_proceso'=>$costo_proceso,
                                        'costo_materiales'=>$costo_materiales,
                                        'otros_costos'=>floatval($totalotroscostos*($masa->PESO_PRORRATEADO/$peso_total))]);

                        $nro2+=1;
                    }
        }

        foreach ($productores_cantidad as $item) {
            // Filtrar los registros de $masa2 correspondientes al productor actual
            $masa_productor = $masas2->where('PRODUCTOR_RECEP_FACTURACION', $item['productor']);
            
            // Sumar el peso total del productor actual
            $peso_total_productor = $masa_productor->sum('PESO_PRORRATEADO');

            // Iterar sobre los registros de $masa2 del productor actual
            foreach ($masa_productor as $masa) {
                if($masa->PESO_PRORRATEADO>0){
                    // Calcular la cantidad distribuida para cada registro
                    $cantidad_distribuida = $item['total_cantidad'] * ($masa->PESO_PRORRATEADO / $peso_total_productor);

                    // Actualizar el registro con la nueva cantidad distribuida
                    $masa->anticipos = $cantidad_distribuida;
                    $masa->save(); // Guardar los cambios en la base de datos
                    $nro3+=1;
                }
            }

            foreach($anticipos->where('productor',$item['productor']) as $anticipo){
                $anticipo->prorrateado = True;
                $anticipo->save(); // Guardar los cambios en la base de datos
            }
        }

        $analisisall_agrupado_productors = AnalisisMultiresiduo::where('temporada_id', $temporada->id)
            ->select('productor', DB::raw('SUM(dolar) as total'))
            ->groupBy('productor')
            ->get();
        $transportesall_agrupado_productors = Transporte::where('temporada_id', $temporada->id)
            ->select('productor', DB::raw('SUM(dolar) as total'))
            ->groupBy('productor')
            ->get();
        $certificacionsall_agrupado_productors = Certificacion::where('temporada_id', $temporada->id)
            ->select('productor', DB::raw('SUM(precio) as total'))
            ->groupBy('productor')
            ->get();
        $materialesall_agrupado_productors = Material::where('temporada_id', $temporada->id)
            ->select('productor', DB::raw('SUM(dolar) as total'))
            ->groupBy('productor')
            ->get();
        
        $mergedResults = collect()
            ->merge($analisisall_agrupado_productors->map(function ($analisis) {
                $analisis['type'] = 'AnalisisMultiresiduo';
                return $analisis;
            }))
            ->merge($transportesall_agrupado_productors->map(function ($transporte) {
                $transporte['type'] = 'Transporte';
                return $transporte;
            }))
            ->merge($certificacionsall_agrupado_productors->map(function ($certificacion) {
                $certificacion['type'] = 'Certificacion';
                return $certificacion;
            }))
            ->merge($materialesall_agrupado_productors->map(function ($material) {
                $material['type'] = 'Material';
                return $material;
            })); // Ordena por el total
        
           // Calcular los totales generales para cada tipo
            $totalAnalisis = $mergedResults->where('type', 'AnalisisMultiresiduo')->sum('total');
            $totalTransporte = $mergedResults->where('type', 'Transporte')->sum('total');
            $totalCertificacion = $mergedResults->where('type', 'Certificacion')->sum('total');
            $totalMaterial = $mergedResults->where('type', 'Material')->sum('total');

            // Agrupar resultados
            $finalResults = $mergedResults->groupBy('productor')->map(function ($group) {
                return (object)[
                    'productor' => $group->first()->productor,
                    'total' => $group->sum('total'),
                    'analisis' => $group->where('type', 'AnalisisMultiresiduo')->sum('total'),
                    'transporte' => $group->where('type', 'Transporte')->sum('total'),
                    'certificacion' => $group->where('type', 'Certificacion')->sum('total'),
                    'material' => $group->where('type', 'Material')->sum('total'),
                ];
            })->values(); // `values()` para reindexar la colección

            
        foreach ($finalResults as $item){
            $masatotalproductor=$masas2->where('PRODUCTOR_RECEP_FACTURACION',$item->productor)->sum('PESO_PRORRATEADO');

            foreach($masas2->where('PRODUCTOR_RECEP_FACTURACION',$item->productor) as $masa ){
                $masa->update(['gastos'=>floatval($item->total)*(floatval($masa->PESO_PRORRATEADO)/floatval($masatotalproductor))]);
                $nro4+=1;
            }


        }

        /*  */

        return redirect()->back()->with('info',$nro.' fobs / '.$nro2.' Costos /'.$nro4.' Gastos y '.$nro3.' Anticipos Actualizados con Éxito ');
    }

    public function fobupdate3(Temporada $temporada)
    {   $masas = Proceso::where('temporada_id', $temporada->id)
            ->whereNull('fob_id')
            ->whereIn('TIPO', ['PRE-CALIBRE', 'COMERCIAL']) // Filtramos por TIPO
            ->get();
        
        $fobsall = Fob::where('temporada_id', $temporada->id)
            ->where('n_variedad', 'COMERCIAL') // Nos aseguramos de que sea la variedad "COMERCIAL"
            ->get();
        
        $nro = 0;
        
        foreach ($masas as $masa) {
            foreach ($fobsall as $fob) {
                // Comparar la columna 'TIPO' del Proceso con la columna 'n_calibre' del Fob
                if ($fob->n_calibre == $masa->TIPO && $fob->semana == $masa->SEMANA) {
                    $costo_procesos=$masa->PESO_PRORRATEADO*$temporada->procesocom;

                    // Actualizamos el campo 'fob_id' del Proceso con el ID correspondiente de la tabla Fob
                    $masa->update(['fob_id' => $fob->id,
                                    'costo_proceso'=>$costo_procesos]);
                    $nro += 1;
                    break; // Terminamos el bucle interno una vez que encontramos un match
                }
            }
        }
        $masas2 = Proceso::where('temporada_id', $temporada->id)
        ->whereIn('CRITERIO', ['COMERCIAL']) // Filtramos por TIPO
        ->get();

        $nro2=0;

        foreach($masas2 as $masa){
       
           
                $costo_proceso=$masa->PESO_PRORRATEADO*$temporada->procesocom;
              
          
            if($costo_proceso>0){
                $masa->update([ 'costo_proceso'=>$costo_proceso]);

                $nro2+=1;
            }
}
        
        return redirect()->back()->with('info', $nro2.' Costos / '.$nro.' Fobs Actualizados con Éxito');
        
    }

    public function fobupdatedespacho(Temporada $temporada)
    {   $masas=Balancemasatres::where('temporada_id',$temporada->id)->whereNull('Fob')->get();

       // Extraer los valores de la columna 'Folio' de los registros de $masas
        $folios_masas = $masas->pluck('Folio')->toArray();

        $unique_folios = Fobdespacho::where('temporada_id', $temporada->id)
            ->where('suma_fob', '>', 0)
            ->whereIn('folio', $folios_masas) // Filtrar por los folios en $masas
            ->get();
        
        $nro=0;
        
        foreach($unique_folios as $item){

          //  $despachos=Balancemasatres::where('Folio',$item->folio)->where('Variable',$item->variable)->where('Calibre',$item->calibre_color)->get();

             // Filtrar la colección
             $despachos = $masas->filter(function ($objet) use ($item) {
                return $objet->Folio == $item->folio && trim(strtolower($objet->Variedad_Rot)) == trim(strtolower($item->variedad)) && $objet->Calibre == $item->calibre_color;
            });


            $masatotalfolio=0;
            foreach($despachos as $despacho){
                $masatotalfolio+=$despacho->Kilos_INICIAL;
            }
            
                foreach($despachos as $despacho){
                    if($masatotalfolio>0){
                        $despacho->update(['Fob'=>floatval(($item->suma_fob*$despacho->Kilos_INICIAL)/$masatotalfolio)]);
                        $nro+=1;
                    }
                }       
        }
        return redirect()->back()->with('info',$nro.' Actualizados con Éxito');
    }

    public function comisionupdate(Request $request,Comision $comision)
    {   
        $comision->update($request->all());
        return redirect(route('temporada.comision',$comision->temporada)."/#informacion");

    }

    public function importExportacion(Request $request)
    {    $request->validate([
            'file'=>'required|mimes:csv,xlsx'
        ]);

        $file = $request->file('file');

        FacadesExcel::import(new ExportacionImport($request->temporada),$file);

        $temporada=Temporada::find($request->temporada);

        return redirect()->route('temporada.exportacion',$temporada)->with('info','Importación realizada con exito');
    }

    public function importComision(Request $request)
    {    $request->validate([
            'file'=>'required|mimes:csv,xlsx'
        ]);

        $file = $request->file('file');

        FacadesExcel::import(new ComisionImport($request->temporada),$file);

        $temporada=Temporada::find($request->temporada);

        return redirect()->route('temporada.comision',$temporada)->with('info','Importación realizada con exito');
    }

    public function importBalance(Request $request)
    {    $request->validate([
            'file'=>'required|mimes:csv,xlsx'
        ]);

        $file = $request->file('file');

        $masas=Balancemasa::where('temporada_id',$request->temporada)->get();

        foreach ($masas as $masa){
            $masa->delete();
        }


        FacadesExcel::import(new BalanceImport($request->temporada),$file);

        $temporada=Temporada::find($request->temporada);

        return redirect()->route('temporada.balancemasa',$temporada)->with('info','Importación realizada con exito');
    }

    public function importAnticipo(Request $request)
    {    $request->validate([
            'file'=>'required|mimes:csv,xlsx'
        ]);

        $file = $request->file('file');

        $masas=Anticipo::where('temporada_id',$request->temporada)->get();

        foreach ($masas as $masa){
            $masa->delete();
        }

        FacadesExcel::import(new AnticipoImport($request->temporada),$file);

        $temporada=Temporada::find($request->temporada);

        return redirect()->route('temporada.anticipos',$temporada)->with('info','Importación realizada con exito');
    }

    
    public function importFob(Request $request)
    {    $request->validate([
            'file'=>'required|mimes:csv,xlsx'
        ]);

        $file = $request->file('file');

        $masas=Fob::where('temporada_id',$request->temporada)->get();

        foreach ($masas as $masa){
            $masa->delete();
        }

        FacadesExcel::import(new FobImport($request->temporada,'exportacion'),$file);

        $temporada=Temporada::find($request->temporada);

        return redirect()->route('temporada.fob',$temporada)->with('info','Importación realizada con exito');
    }

    public function importFobnacional(Request $request)
    {    $request->validate([
            'file'=>'required|mimes:csv,xlsx'
        ]);

        $file = $request->file('file');

        $masas=Fobnacional::where('temporada_id',$request->temporada)->get();

        foreach ($masas as $masa){
            $masa->delete();
        }

        FacadesExcel::import(new FobImport($request->temporada,'nacional'),$file);

        $temporada=Temporada::find($request->temporada);

        return redirect()->route('temporada.fobnacional',$temporada)->with('info','Importación realizada con exito');
    }

    public function importFlete(Request $request)
    {    $request->validate([
            'file'=>'required|mimes:csv,xlsx'
        ]);

        $file = $request->file('file');

        $masas=Flete::where('temporada_id',$request->temporada)->get();

        foreach ($masas as $masa){
            $masa->delete();
        }

        FacadesExcel::import(new FleteImport($request->temporada),$file);

        $temporada=Temporada::find($request->temporada);

        return redirect()->route('temporada.flete',$temporada)->with('info','Importación realizada con exito');
    }

    public function importEmbarque(Request $request)
    {    $request->validate([
            'file'=>'required|mimes:csv,xlsx'
        ]);

        $file = $request->file('file');

        $masas=Embarque::where('temporada_id',$request->temporada)->get();

        foreach ($masas as $masa){
            $masa->delete();
        }

        FacadesExcel::import(new EmbarqueImport($request->temporada),$file);

        $temporada=Temporada::find($request->temporada);

        return redirect()->route('temporada.exportacion',$temporada)->with('info','Importación realizada con exito');
    }

    public function importGasto(Request $request)
    {    $request->validate([
            'file'=>'required|mimes:csv,xlsx'
        ]);

        $file = $request->file('file');

        $masas=Detalle::where('temporada_id',$request->temporada)->get();

        foreach ($masas as $masa){
            $masa->delete();
        }

        FacadesExcel::import(new GastoImport($request->temporada),$file);

        $temporada=Temporada::find($request->temporada);

        return redirect()->route('temporada.gastos',$temporada)->with('info','Importación realizada con exito');
    }

    public function importBalance2(Request $request)
    {    $request->validate([
            'file'=>'required|mimes:csv,xlsx'
        ]);

        $file = $request->file('file');

        $masas=Balancemasados::where('temporada_id',$request->temporada)->get();

        foreach ($masas as $masa){
            $masa->delete();
        }

        FacadesExcel::import(new Balance2Import($request->temporada),$file);

        $temporada=Temporada::find($request->temporada);

        return redirect()->back()->with('info','Importación realizada con exito');
    }

    public function importBalance3(Request $request)
    {    $request->validate([
            'file'=>'required|mimes:csv,xlsx'
        ]);

        $file = $request->file('file');
        
        /*
        $masas=Balancemasatres::where('temporada_id',$request->temporada)->get();

        foreach ($masas as $masa){
            $masa->delete();
        }
        */
        
        FacadesExcel::import(new Balance3Import($request->temporada),$file);

        $temporada=Temporada::find($request->temporada);

        return redirect()->back()->with('info','Importación realizada con exito');
    }

    public function importBalance4(Request $request)
    {    $request->validate([
            'file'=>'required|mimes:csv,xlsx'
        ]);

        $file = $request->file('file');

        $masas=Balancemasacuatro::where('temporada_id',$request->temporada)->get();

        foreach ($masas as $masa){
            $masa->delete();
        }

        FacadesExcel::import(new Balance4Import($request->temporada),$file);

        $temporada=Temporada::find($request->temporada);

        return redirect()->back()->with('info','Importación realizada con exito');
    }

    public function importProceso(Request $request)
    {    $request->validate([
            'file'=>'required|mimes:csv,xlsx'
        ]);

        $file = $request->file('file');
        
        $masas=Proceso::where('temporada_id',$request->temporada)->get();

        foreach ($masas as $masa){
            $masa->delete();
        }

        FacadesExcel::import(new ProduccionImport($request->temporada),$file);

        $temporada=Temporada::find($request->temporada);

        return redirect()->back()->with('info','Importación realizada con exito');
    }

}
