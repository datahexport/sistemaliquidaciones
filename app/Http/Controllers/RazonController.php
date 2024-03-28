<?php

namespace App\Http\Controllers;

use App\Models\Balancemasa;
use App\Models\Balancemasados;
use App\Models\Comision;
use App\Models\CostoPacking;
use App\Models\Flete;
use App\Models\Fob;
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

    public function downloadpdf(Razonsocial $razonsocial) {

        return response()->file(storage_path('app/'.$razonsocial->informe));

      
    }

    
    public function razonsync(){

        $masas=Balancemasa::all();

        foreach($masas as $masa){
            $razon=Razonsocial::where('csg',$masa->csg)->first();
            if ($razon){

            }else{
                if($masa->productor_recep){
                    Razonsocial::create(['name'=>$masa->productor_recep,
                                    'csg'=>$masa->csg]);
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
        $masas=Balancemasa::where('temporada_id',$temporada->id)->where('c_productor',$razonsocial->csg)->get();
       


        $masas2=Balancemasados::where('temporada_id',$temporada->id)->get();
        $fletes=Flete::where('temporada_id',$temporada->id)->get();
        $packings=CostoPacking::where('temporada_id',$temporada->id)->where('csg',$razonsocial->csg)->get();
        $comisions=Comision::where('temporada_id',$temporada->id)->where('productor',$razonsocial->name)->get();
        $unique_calibres = $masas->pluck('n_calibre')->unique()->sort();
        $unique_variedades = $masas->pluck('n_variedad')->unique()->sort();
        $variedades = Variedad::whereIn('name', $unique_variedades)->get();

        $unique_semanas = $masas->pluck('semana')->unique()->sort();
        $fobs = Fob::where('temporada_id',$temporada->id)->get();

        return view('razonsocial.show',compact('variedades','unique_semanas','fobs','unique_variedades','unique_calibres','razonsocial','temporada','masas','masas2','packings','comisions','fletes'));
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
