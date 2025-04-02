<?php

namespace App\Livewire;

use App\Imports\CertificacionImport;
use App\Imports\MaterialesImport;
use App\Imports\OrdenImport;
use App\Imports\TransporteImport;
use App\Models\AnalisisMultiresiduo;
use App\Models\Certificacion;
use App\Models\Material;
use App\Models\Temporada;
use App\Models\Transporte;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class DataUploadCuentacorriente extends Component
{  
    use WithPagination;
    use WithFileUploads;

    #[Url(history: true)]
    public $temporada,$vista="Resumen",$ctd=50;
    public $fileReciduos, $fileTransporte,$fileCertificaciones,$fileMateriales;

   

    public function importExcelMultiresiduos()
    {   $rules = [
            'fileReciduos' => 'required|file|mimes:xlsx,xls'
        ];
        $this->validate($rules);
        //dd($this->file);
        // Importar el archivo Excel
        $trasnportes=AnalisisMultiresiduo::where('temporada_id',$this->temporada->id)->get();
        foreach($trasnportes as $trasporte){
            $trasporte->delete();
        }

        Excel::import(new OrdenImport($this->temporada), $this->fileReciduos->store('temp'));
       
        session()->flash('message', 'Archivo subido e importado con éxito!');
    }

    public function importExcelTransportes()
    {   $rules = [
            'fileTransporte' => 'required|file|mimes:xlsx,xls'
        ];
        $this->validate($rules);
        //dd($this->file);
        // Importar el archivo Excel
        $trasnportes=Transporte::where('temporada_id',$this->temporada->id)->get();
        foreach($trasnportes as $trasporte){
            $trasporte->delete();
        }
        Excel::import(new TransporteImport($this->temporada), $this->fileTransporte->store('temp'));
       

        session()->flash('message', 'Archivo subido e importado con éxito!');
    }

    public function importExcelCertificaciones()
    {   $rules = [
            'fileCertificaciones' => 'required|file|mimes:xlsx,xls'
        ];
        $this->validate($rules);
        //dd($this->file);
        // Importar el archivo Excel
        $trasnportes=Certificacion::where('temporada_id',$this->temporada->id)->get();
        foreach($trasnportes as $trasporte){
            $trasporte->delete();
        }
        Excel::import(new CertificacionImport($this->temporada), $this->fileCertificaciones->store('temp'));
       

        session()->flash('message', 'Archivo subido e importado con éxito!');
    }

    public function importExcelMateriales()
    {   $rules = [
            'fileMateriales' => 'required|file|mimes:xlsx,xls'
        ];
        $this->validate($rules);
        //dd($this->file);
        // Importar el archivo Excel
        $trasnportes=Material::where('temporada_id',$this->temporada->id)->get();
        foreach($trasnportes as $trasporte){
            $trasporte->delete();
        }
        Excel::import(new MaterialesImport($this->temporada), $this->fileMateriales->store('temp'));
       

        session()->flash('message', 'Archivo subido e importado con éxito!');
    }

    
    public function mount(Temporada $temporada){
        $this->temporada=$temporada;
    }

    public function render()
    {   $analisis=AnalisisMultiresiduo::where('temporada_id',$this->temporada->id)->paginate($this->ctd);
        $analisisall=AnalisisMultiresiduo::where('temporada_id',$this->temporada->id)->get();
       


        $transportes=Transporte::where('temporada_id',$this->temporada->id)->paginate($this->ctd);
        $transportesall=Transporte::where('temporada_id',$this->temporada->id)->get();
      
        
        $certificacions=Certificacion::where('temporada_id',$this->temporada->id)->paginate($this->ctd);
        $certificacionsall=Certificacion::where('temporada_id',$this->temporada->id)->get();
       

        $materiales=Material::where('temporada_id',$this->temporada->id)->paginate($this->ctd);
        $materialesall=Material::where('temporada_id',$this->temporada->id)->get();
        
        $analisisall_agrupado_productors = AnalisisMultiresiduo::where('temporada_id', $this->temporada->id)
            ->select('productor', DB::raw('SUM(dolar) as total'))
            ->groupBy('productor')
            ->get();
        $transportesall_agrupado_productors = Transporte::where('temporada_id', $this->temporada->id)
            ->select('productor', DB::raw('SUM(dolar) as total'))
            ->groupBy('productor')
            ->get();
        $certificacionsall_agrupado_productors = Certificacion::where('temporada_id', $this->temporada->id)
            ->select('productor', DB::raw('SUM(precio) as total'))
            ->groupBy('productor')
            ->get();
        $materialesall_agrupado_productors = Material::where('temporada_id', $this->temporada->id)
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

            
            

        return view('livewire.data-upload-cuentacorriente',compact('totalAnalisis','totalTransporte','totalCertificacion','totalMaterial','finalResults','analisis','transportes','certificacions','materiales','analisisall','transportesall'));
    }
}
