<?php

use App\Http\Controllers\FamiliaController;
use App\Http\Controllers\GastoController;
use App\Http\Controllers\RazonController;
use App\Http\Controllers\TemporadaController;
use App\Http\Controllers\UserController;
use App\Livewire\TemporadaShow;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware('auth')->name('dashboard');
});


Route::get('lista/filtros',[RazonController::class,'index'])->name('razonsocial.index');

Route::get('productor/{razonsocial}/{temporada}',[RazonController::class,'show'])->middleware('auth')->name('razonsocial.show');

Route::get('temporada/{temporada}/graficovariedad/{variedad}',[TemporadaController::class,'graficovariedad'])->middleware('auth')->name('temporada.graficovariedad');

Route::get('razon/sync',[RazonController::class,'razonsync'])->name('razonsync');

Route::get('pdf/export/{informe}',[TemporadaShow::class,'exportpdf'])->name('exportpdff');

Route::get('nota/export/{informe}',[TemporadaShow::class,'exportpdf2'])->name('exportpdff2');

Route::get('grafico/{razonsocial}/{temporada}/{variedad}',[TemporadaController::class,'graficogenerate'])->name('grafico.variedad');

Route::resource('temporada', TemporadaController::class)->names('temporadas');

Route::resource('familia', FamiliaController::class)->names('familias');

Route::resource('gasto', GastoController::class)->names('gastos');

Route::resource('users', UserController::class)->names('users');

Route::get('temporada/{temporada}/resumen',[TemporadaController::class,'resume'])->middleware('auth')->name('temporada.resume');

Route::get('temporada/{temporada}/clientes',[TemporadaController::class,'clientes'])->middleware('auth')->name('temporada.clientes');

Route::get('temporada/{temporada}/grafico',[TemporadaController::class,'grafico'])->middleware('auth')->name('temporada.grafico');

Route::get('temporada/{temporada}/saldoaliquidar',[TemporadaController::class,'saldoaliquidar'])->middleware('auth')->name('temporada.saldoaliquidar');

Route::get('temporada/{temporada}/saldoaliquidar2',[TemporadaController::class,'saldoaliquidar2'])->middleware('auth')->name('temporada.saldoaliquidar2');

Route::get('temporada/{temporada}/packing',[TemporadaController::class,'packing'])->middleware('auth')->name('temporada.packing');

Route::get('temporada/{temporada}/comision',[TemporadaController::class,'comision'])->middleware('auth')->name('temporada.comision');

Route::get('temporada/{temporada}/dataupload',[TemporadaController::class,'dataupload'])->middleware('auth')->name('temporada.dataupload');

Route::get('temporada/{temporada}/dataupload/liquidacion',[TemporadaController::class,'datauploadliq'])->middleware('auth')->name('temporada.datauploadliq');

Route::get('temporada/{temporada}/dataupload/despacho',[TemporadaController::class,'datauploaddesp'])->middleware('auth')->name('temporada.datauploaddesp');

Route::get('temporada/{temporada}/dataupload/comercial',[TemporadaController::class,'datauploadcomercial'])->middleware('auth')->name('temporada.datauploadcomercial');

Route::get('temporada/{temporada}/dataupload/cuentacorriente',[TemporadaController::class,'datauploadcuentacorriente'])->middleware('auth')->name('temporada.datauploadcuentacorriente');

Route::get('temporada/{temporada}/dataupload/detliquidacion',[TemporadaController::class,'datauploaddet'])->middleware('auth')->name('temporada.datauploaddet');

Route::get('temporada/{temporada}/dataupload/produccion',[TemporadaController::class,'datauploadprod'])->middleware('auth')->name('temporada.datauploadprod');

Route::post('temporada/dataupload/facturacion',[TemporadaController::class,'datauploadfacturacion'])->middleware('auth')->name('temporada.datauploadfacturacion');

Route::get('temporada/{temporada}/costocaja',[TemporadaController::class,'costocaja'])->middleware('auth')->name('temporada.costocaja');

Route::get('temporada/{temporada}/materiales',[TemporadaController::class,'materiales'])->middleware('auth')->name('temporada.materiales');

Route::get('temporada/{temporada}/exportacion',[TemporadaController::class,'exportacion'])->middleware('auth')->name('temporada.exportacion');

Route::get('temporada/{temporada}/flete',[TemporadaController::class,'flete'])->middleware('auth')->name('temporada.flete');

Route::get('balance/{temporada}/masa',[TemporadaController::class,'balancemasa'])->middleware('auth')->name('temporada.balancemasa');

Route::get('balance/{temporada}/fob',[TemporadaController::class,'fob'])->middleware('auth')->name('temporada.fob');

Route::get('balance/{temporada}/fobnacional',[TemporadaController::class,'fobnacional'])->middleware('auth')->name('temporada.fobnacional');

Route::get('temporada/{temporada}/otrosgastos',[TemporadaController::class,'otrosgastos'])->middleware('auth')->name('temporada.otrosgastos');

Route::get('temporada/{temporada}/finanzas',[TemporadaController::class,'finanzas'])->middleware('auth')->name('temporada.finanzas');

Route::get('temporada/{temporada}/anticipos',[TemporadaController::class,'anticipos'])->middleware('auth')->name('temporada.anticipos');

Route::get('temporada/{temporada}/mercados',[TemporadaController::class,'gastos'])->middleware('auth')->name('temporada.gastos');

Route::get('temporada/{temporada}/precios',[TemporadaController::class,'precio_original'])->middleware('auth')->name('temporada.precio.original');

Route::get('temporada/{temporada}/fobdespacho',[TemporadaController::class,'fobdespacho'])->middleware('auth')->name('temporada.fobdespacho');

Route::get('temporada/{temporada}/costoajustado',[TemporadaController::class,'precioajustado'])->name('temporada.precioajustado');

Route::post('data/import',[TemporadaController::class,'importdata'])->middleware('auth')->name('temporada.importData');

Route::post('costos/packing/import',[TemporadaController::class,'importCostosPacking'])->middleware('auth')->name('temporada.importCostosPacking');

Route::post('costos/materiales/import',[TemporadaController::class,'importMateriales'])->middleware('auth')->name('temporada.importMateriales');

Route::post('costos/ventacomercial/import',[TemporadaController::class,'importVentacomercial'])->middleware('auth')->name('temporada.importVentacomercial');

Route::post('costos/productores/import',[TemporadaController::class,'importProductores'])->middleware('auth')->name('temporada.importProductores');

Route::get('edit/{exportacion}/{temporada}',[TemporadaController::class,'exportacionedit'])->middleware('auth')->name('exportacion.edit');

Route::get('edit/gasto/{gasto}/{temporada}',[TemporadaController::class,'gastoedit'])->name('gasto.edit');

Route::post('update/{exportacion}',[TemporadaController::class,'exportacionupdate'])->name('exportacion.update');

Route::get('editflete/{flete}/{temporada}',[TemporadaController::class,'fleteedit'])->name('flete.edit');

Route::post('updateflete/{flete}',[TemporadaController::class,'fleteupdate'])->name('flete.update');

Route::get('editcomision/{comision}/{temporada}',[TemporadaController::class,'comisionedit'])->name('comision.edit');

Route::post('updatecomision/{comision}',[TemporadaController::class,'comisionupdate'])->name('comision.update');

Route::post('costos/exportacion/import',[TemporadaController::class,'importExportacion'])->name('temporada.importExportacion');

Route::post('costos/comision/import',[TemporadaController::class,'importComision'])->name('temporada.importComision');

Route::post('costos/balance/import',[TemporadaController::class,'importBalance'])->name('temporada.importBalance');

Route::post('costos/balancedos/import',[TemporadaController::class,'importBalance2'])->name('temporada.importBalance2');

Route::post('costos/balancetres/import',[TemporadaController::class,'importBalance3'])->name('temporada.importBalance3');

Route::post('costos/balancecuatro/import',[TemporadaController::class,'importBalance4'])->name('temporada.importBalance4');

Route::post('costos/proceso/import',[TemporadaController::class,'importProceso'])->name('temporada.importProceso');

Route::post('costos/anticipo/import',[TemporadaController::class,'importAnticipo'])->name('temporada.importAnticipo');

Route::post('costos/fob/import',[TemporadaController::class,'importFob'])->name('temporada.importFob');

Route::post('costos/fobnacional/import',[TemporadaController::class,'importFobnacional'])->name('temporada.importFobnacional');

Route::post('costos/flete/import',[TemporadaController::class,'importFlete'])->name('temporada.importFlete');

Route::post('costos/embarque/import',[TemporadaController::class,'importEmbarque'])->name('temporada.importEmbarque');

Route::post('costos/gasto/import',[TemporadaController::class,'importGasto'])->name('temporada.importGasto');

Route::get('update/{temporada}',[TemporadaController::class,'variedadupdate'])->name('variedades.refresh');

Route::get('updatefob/{temporada}',[TemporadaController::class,'fobupdate'])->name('preciofob.refresh');

Route::get('updatefob2/{temporada}',[TemporadaController::class,'fobupdate2'])->name('preciofob.refresh2');

Route::get('updatefob3/{temporada}',[TemporadaController::class,'fobupdate3'])->name('preciofob.refresh3');

Route::get('updatefobdespacho/{temporada}',[TemporadaController::class,'fobupdatedespacho'])->middleware('auth')->name('fobupdatedespacho.refresh');

Route::get('download/{informe}.pdf', [RazonController::class,'downloadpdf'])->name('informe.download');

Route::get('download2/{informe}.pdf', [RazonController::class,'downloadpdf2'])->name('informe.download2');


