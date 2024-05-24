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
use App\Imports\FleteImport;
use App\Imports\FobImport;
use App\Imports\GastoImport;
use App\Imports\MaterialImport;
use App\Imports\PackingImport;
use App\Imports\ProduccionImport;
use App\Imports\ResumenImport;
use App\Models\Anticipo;
use App\Models\Balancemasa;
use App\Models\Balancemasacuatro;
use App\Models\Balancemasados;
use App\Models\Balancemasatres;
use App\Models\Comision;
use App\Models\CostoPacking;
use App\Models\Detalle;
use App\Models\Embarque;
use App\Models\Exportacion;
use App\Models\Familia;
use App\Models\Flete;
use App\Models\Fob;
use App\Models\Fobnacional;
use App\Models\Gasto;
use App\Models\Material;
use App\Models\Proceso;
use App\Models\Razonsocial;
use App\Models\Resumen;
use App\Models\Temporada;
use App\Models\Variedad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
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

        return redirect()->route('dashboard')->with('info','Temporada creada con éxito.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Temporada $temporada)
    {   $resumes=Resumen::where('temporada_id',$temporada->id)->get();
        $CostosPackings=CostoPacking::where('temporada_id',$temporada->id)->get();

        $masitas=Balancemasa::where('temporada_id',$temporada->id)->paginate(3);
        if ($masitas->count()>0) {
            return view('temporadas.show',compact('temporada','resumes','CostosPackings'));
        } else {
            return view('temporadas.balancemasa',compact('temporada','masitas'));
        }
        
        
       
    }

    public function resume(Temporada $temporada)
    {   $resumes=Resumen::where('temporada_id',$temporada->id)->get();
        return view('temporadas.resume',compact('temporada','resumes'));
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
    {   $masastres=Balancemasatres::where('temporada_id',$temporada->id)->paginate(50);
        return view('temporadas.datauploaddesp',compact('temporada'));
    }

    public function datauploaddet(Temporada $temporada)
    {   
        return view('temporadas.datauploaddet',compact('temporada'));
    }

    public function datauploadprod(Temporada $temporada)
    {   $procesos=Proceso::where('temporada_id',$temporada->id)->paginate(25);
        return view('temporadas.datauploadprod',compact('temporada','procesos'));
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

  

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
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
    {   $masas=Balancemasa::where('temporada_id',$temporada->id)->get();
        foreach($masas as $masa){
            $variedad=Variedad::where('name',$masa->variedad)->where('temporada_id',$temporada->id)->first();
            if ($variedad){

            }else{
                if($masa->variedad){
                    Variedad::create(['name'=>$masa->variedad,
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

        $masas=Balancemasatres::where('temporada_id',$request->temporada)->get();

        foreach ($masas as $masa){
            $masa->delete();
        }

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
        /*
        $masas=Proceso::where('temporada_id',$request->temporada)->get();

        foreach ($masas as $masa){
            $masa->delete();
        }*/

        FacadesExcel::import(new ProduccionImport($request->temporada),$file);

        $temporada=Temporada::find($request->temporada);

        return redirect()->back()->with('info','Importación realizada con exito');
    }

}
