<?php

namespace App\Http\Controllers;

use App\Models\Balancemasa;
use App\Models\Balancemasados;
use App\Models\Comision;
use App\Models\CostoPacking;
use App\Models\Detalle;
use App\Models\Flete;
use App\Models\Fob;
use App\Models\Gasto;
use App\Models\Informe;
use App\Models\Material;
use App\Models\Proceso;
use App\Models\Razonsocial;
use App\Models\Temporada;
use App\Models\Variedad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Barryvdh\DomPDF\Facade\Pdf;

class RazonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   $razons=Razonsocial::all();
        return view('razonsocial.index',compact('razons'));
    }

    public function downloadpdf(Informe $informe) {

        return response()->file(storage_path('app/'.$informe->informe));

      
    }

    public function downloadpdf2(Informe $informe) {

        return response()->file(storage_path('app/'.$informe->nota));

      
    }

    
    public function razonsync(){

        $masas=Proceso::all();

        foreach($masas as $masa){
            $razon=Razonsocial::where('name',$masa->PRODUCTOR_RECEP_FACTURACION)->first();
            if ($razon){
                $razon->update(['name'=>$masa->PRODUCTOR_RECEP_FACTURACION]);
            }else{
                if($masa->PRODUCTOR_RECEP_FACTURACION){
                    Razonsocial::create(['name'=>$masa->PRODUCTOR_RECEP_FACTURACION]);
                }
            }
       }
       
        return redirect()->back();


        //return view('productors.index',compact('users'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Razonsocial $razonsocial,Temporada $temporada)
    {       
        $temporada=Temporada::find($temporada->id);

        $masas = Proceso::selectRaw('CALIBRE_REAL as calibre_real, VARIEDAD as variedad, CANT as cantidad, PESO_PRORRATEADO as peso_prorrateado, costo, fob_id , TIPO as tipo')
            ->where('temporada_id', $temporada->id)
            ->where('PRODUCTOR_RECEP_FACTURACION', 'like', '%' . $razonsocial->name . '%')
            ->with('fob.tarifas') // Esto carga la relación fob con sus tarifas
            ->get();

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
            ->where('temporada_id', $temporada->id)
            ->get();
        
        $fletes=Flete::where('temporada_id',$temporada->id)->get();
        $packings=CostoPacking::where('temporada_id',$temporada->id)->where('csg',$razonsocial->csg)->get();
        $comisions=Comision::where('temporada_id',$temporada->id)->where('productor',$razonsocial->name)->get();
        $unique_calibres = $masas->pluck('calibre')->unique()->sort();
       
        $unique_variedades = $masas->pluck('variedad')->unique()->sort();
        
        $variedades = Variedad::whereIn('name', $unique_variedades)->get();

        $unique_semanas = $masas->pluck('semana')->unique()->sort();
        $fobs = Fob::where('temporada_id',$temporada->id)->get();
        $materialestotal=Material::where('temporada_id',$temporada->id)->get();
        $gastos = Gasto::where('temporada_id',$temporada->id)->get();

        $detalles=Detalle::where('temporada_id',$temporada->id)->where('n_productor',$razonsocial->name)->get();

        return view('razonsocial.show',compact('masastotal','detalles','gastos','materialestotal','variedades','unique_semanas','fobs','unique_variedades','unique_calibres','razonsocial','temporada','masas','packings','comisions','fletes'));
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
    public function destroy(string $id)
    {
        //
    }
}
