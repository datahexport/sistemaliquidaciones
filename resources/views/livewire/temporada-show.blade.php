<div class="px-2 py-2">
 
    @php
        $totalfriopacking=0;

        $masatotal=0;

        $globaltotalotroscostos=0;
        $otroscostos=0;
        $totalotroscostos=0;
        


    @endphp

<style>
  .table-container {
overflow-x: auto;
}

.sticky-column {
position: sticky;
left: 0;
background-color: white;
z-index: 1; /* Para que las columnas se mantengan sobre las otras al hacer scroll */
border-right: 1px solid #ddd; /* O alguna otra propiedad para que se vea como parte de la tabla */
}

.sticky-column:nth-child(2) { /* Ajusta este selector según el número de la columna */
left: 300px; /* Ajusta el valor según el ancho de la columna anterior */
}

.sticky-column:nth-child(3) { /* Ajusta para la siguiente columna */
left: 180px;
}

/* Mantener las columnas fijas en su lugar */
.fixed-column {
position: sticky;
left: 0;
background-color: white;
z-index: 2; /* Asegura que quede por encima del resto */
}

.fixed-column-1 {
position: sticky;
left: 100px; /* Ajustar este valor según el ancho de la columna anterior (Variedad) */
background-color: white;
z-index: 3; /* Asegura que esta columna esté por encima de la anterior */
}

.fixed-column-2 {
position: sticky;
left: 180px; /* Ajustar este valor según el ancho de las columnas anteriores (Variedad + Semana) */
background-color: white;
z-index: 4; /* Asegura que esta columna esté por encima de las anteriores */
}

</style>

  @if ($gastos->count()>0 && $detallesall->count()>0)
    @php
        foreach ($gastos as $gasto){
          if ($gasto->familia->name=='Costos' && $gasto->item=='Otros costos'){
            foreach ($detallesall as $detalle){
              if (preg_replace('/[\.\-\s]+/', '', strtolower($detalle->item))==preg_replace('/[\.\-\s]+/', '', strtolower($gasto->item))){
                  $otroscostos+=abs(floatval($detalle->cantidad));
              }
            }
          }
        }

        $globaltotalotroscostos+=$otroscostos;
    @endphp
  @endif

  @if ($CostosPackingsall->count()>0)
    @foreach ($CostosPackingsall as $packing)
        @php
            $totalfriopacking+=intval($packing->total_usd);
        @endphp
          
    @endforeach
  @endif
  @if ($masastotal->count()>0)
    @foreach ($masastotal as $masa)
        @php
            $masatotal+=floatval($masa->peso_prorrateado);
        @endphp
          
    @endforeach
  @endif
    
    @php
        $globalpesoneto=0;
    @endphp
    @foreach ($masastotal as $masa)
      @php
       
          $globalpesoneto+=floatval($masa->peso_prorrateado);
        
      @endphp
    @endforeach

    <section id="informacion">
      <div class="flex w-full bg-white mt-2"  @if ($vista=="resumes" || $vista=="show") x-data="{openMenu: 2}" @else x-data="{openMenu: 1}" @endif >
          
          <!-- End Sidebar -->
          <div class="flex flex-col flex-1 w-full overflow-y-auto">
              <!--Start Topbar -->
              <!--End Topbar -->
            <main class="relative z-0 flex-1 pb-8 bg-white">
              @if ($vista!="show")

                <div class="bg-gray-100 rounded px-2 md:p-8 shadow mb-6">
                
                    <div wire:loading wire:target="filters, set_informeid, save_informeid">
                        
                      <div class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-50 z-50">
                        <div class="max-w-sm w-full sm:rounded-2xl bg-white border-2 border-gray-200 shadow-xl">
                          <div class="w-full">
                            <div class="px-6 my-6 mx-auto">
                              <div class="mb-8">
                                <div class="flex justify-between items-center">
                                  <h1 class="text-2xl font-extrabold mr-4">Cargando filtros...</h1>
                                  <div><img class="h-10" src="{{asset('image/cargando.gif')}}" alt="Cargando..."></div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      
                    </div>

                    @php
                        $anticiposcount=0;
                        foreach ($anticiposall as $anticipo) {
                          $anticiposcount+=$anticipo->cantidad_usd;
                        }
                    @endphp
                

                      <h2 class="text-2xl font-semibold my-4">Filtros {{$vista}}    
                        @if ($vista=="ANTICIPOS")
                          ({{number_format($anticiposall->count())}} Registros) ({{number_format($anticiposcount,2,',','.')}} USD)
                        @elseif('grafico')
                         - Seleccione una variedad:
                        @else  
                          ({{number_format($masastotal->count())}} Registros) ({{number_format($globalpesoneto,0)}} KGS)
                        @endif  
                      </h2>
              
                  
                  
                    @if ($vista!='grafico')
                      <div class="mb-4 grid grid-cols-4 md:grid-cols-6">
                            
                        <div class="ml-4">
                        Variedades:<br>
                        <select wire:model.live="filters.variedad" name="" id="" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-40">
                            <option value="">Todos</option>
                            @foreach ($unique_variedades as $item)
                              <option value="{{$item->name}}">{{$item->name}}</option>
                            @endforeach
                        
                        </select>
                        </div>
                      
                        <div class="ml-4">
                        Calibre:<br>
                        <select wire:model.live="filters.calibre" name="" id="" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-40">
                            <option value="">Todos</option>
                            @foreach ($unique_calibres as $calibre)
                            @if ($calibre)
                                <option value="{{$calibre}}">{{$calibre}}</option>
                            @endif
            
                            @endforeach
                        </select>
                        </div>

                      
                        <div class="ml-4">
                            Norma:<br>
                            <select wire:model.live="filters.norma" name="" id="" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-40">
                            <option value="">Todos</option>
                            
                                <option value="dentro"> Dentro de norma</option>
                                <option value="fuera"> Fuera de norma</option>
                            
                            
                            </select>
                        </div>
                        <div class="ml-4">
                            Precio_fob:<br>
                            <select wire:model.live="filters.precioFob" name="" id="" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-40">
                            <option value="">Todos</option>
                                <option value="null"> Sin Precio Fob</option>
                                <option value="full"> Con Precio Fob</option>
                            </select>
                        </div>
                        <div class="ml-4">
                            Semana:<br>
                            <select wire:model.live="filters.semana" name="" id="" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-40">
                            <option value="">Todos</option>
                            
                            @foreach ($unique_semanas as $semana)
                            @if ($semana)
                                <option value="{{$semana}}">{{$semana}}</option>
                            @endif
                            @endforeach
                            
                            
                            </select>
                        </div>
                        <div class="ml-4">
                            Tipo:<br>
                            <select wire:model.live="filters.tipo" name="" id="" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-40">
                            <option value="">Todos</option>
                            
                            @foreach ($unique_tipos as $tipo)
                            @if ($tipo)
                                <option value="{{$tipo}}">{{$tipo}}</option>
                            @endif
                            @endforeach
                            
                            
                            </select>
                        </div>
                        <div class="ml-4">
                            Categoria:<br>
                            <div>
                            <input checked type="checkbox" wire:model.live="filters.exp" id="exp" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <label for="exp">Exportación</label>
                            </div>
                        
                            <div>
                            <input checked type="checkbox" wire:model.live="filters.com" id="com" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <label for="com">Comercial</label>
                            </div>
                            <div>
                            <input checked type="checkbox" wire:model.live="filters.comem" id="comem" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <label for="comem">Comercial Embalada</label>
                            </div>
                            
                        
                        
            
            
                        
                        </div>
                        <div class="ml-4">
                            Embalaje:<br>
                            <select wire:model.live="filters.embalaje" name="" id="" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-40">
                            <option value="">Todos</option>
                            
                                <option value="2.2"> 2.2</option>
                                <option value="2.5"> 2.5</option>
                                <option value="5"> 5</option>
                                <option value="10"> 10</option>
                            
                            
                            </select>
                        </div>
                    
                        
                      
                      </div>
         
                      <div class="mb-4 flex">
                    
                          @if ($vista=="ANTICIPOS")
                              
                            <div class="ml-4">
                              Anticipos:<br>
                              <div>
                                <input checked type="checkbox" wire:model.live="filters.ispropio" id="ispropio" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <label for="ispropio">PROPIOS</label>
                              </div>
                              <div>
                                  <input checked type="checkbox" wire:model.live="filters.nopropio" id="nopropio" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                  <label for="nopropio">EXTERNOS</label>
                              </div>
                            </div>
                      
                          @endif

                      </div>
                    @endif
                    <div class="mx-2  grid grid-cols-3 sm:grid-cols-3 md:grid-cols-6 lg:grid-cols-9 gap-y-4 gap-x-3 justify-between  content-center">
                  
                        @if ($vista=="grafico")
                          @foreach ($unique_variedades as $variedad)
                            <div class="flex justify-center">
                              <a href="{{ route('temporada.graficovariedad', ['variedad' => $variedad, 'temporada' => $temporada]) }}" class=" w-full text-center items-center focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 px-2 py-3 hover:bg-gray-500 focus:outline-none rounded" style="background-color: #008d39;">
                                <button>
                                    <p class="whitespace-nowrap text-sm font-medium leading-none text-white">{{$variedad->name}}</p>
                                </button>
                              </a>
                            </div>

                            
                          @endforeach
                        @endif

                    </div>

                      

                
                    

                  
                  
                  

                </div>

              @elseif($vista=="show" )

                <div class="bg-gray-100 rounded px-2 md:p-8 shadow mb-6">
                  <h2 class="text-2xl font-semibold"> {{$razonsall->count()}} Productores</h2>
                </div>

              @endif
              
              @if ($vista=="resumes")
              
                <div class="flex flex-col mb-2">
                  <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                      <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                          <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-yellow-400">
                                  <tr>
                                      <th class="px-6 py-0 text-center text-xs font-bold text-gray-900">
                                      Grupo variedad
                                      </th>
                                      <th class="px-6 py-0 text-left text-xs font-bold text-gray-900">
                                        Caja Bulto
                                      </th>
                                      <th class="px-6 py-0 text-left text-xs font-bold text-gray-900">
                                      Kilos Netos
                                      </th>
                                      <th class="px-6 py-0 text-left text-xs font-bold text-gray-900">
                                        Cajas Base
                                      </th>
                                      <th class="px-6 py-0 text-left text-xs font-bold text-gray-900">
                                        FOB <br>Exp
                                      </th>
                                      <th class="px-6 py-0 text-left text-xs font-bold text-gray-900">
                                        FOB <br>Comercial
                                      </th>
                                      <th class="px-6 py-0 text-left text-xs font-bold text-gray-900">
                                        Total Fob
                                      </th>
                                      <th class="px-6 py-0 text-left text-xs font-bold text-gray-900">
                                        Comision
                                      </th>
                                      {{-- comment<th class="px-6 py-0 text-left text-xs font-bold text-gray-900">
                                        Frio Packing
                                      </th>
                                      
                                        <th class="px-6 py-0 text-left text-xs font-bold text-gray-900">
                                          Total Gastos de Exportacion
                                        </th>
                                        <th class="px-6 py-0 text-left text-xs font-bold text-gray-900">
                                          Total Flete a puerto
                                        </th>
                                        <th class="px-6 py-0 text-left text-xs font-bold text-gray-900">
                                          Materiales
                                        </th>
                                      --}}
                                      <th class="px-6 py-0 text-left text-xs font-bold text-gray-900">
                                        Costos Exportación
                                      </th>
                                      <th class="px-6 py-0 text-left text-xs font-bold text-gray-900">
                                        Costos Nacional
                                      </th>
                                    
                                    
                                      <th class="px-6 py-0 text-left text-xs font-bold text-gray-900">
                                      Retorno Productor
                                      </th>
                                      <th class="px-6 py-0 text-left text-xs font-bold text-gray-900">
                                        Retorno por kg
                                      </th>
                                      <th class="relative px-6 py-0">
                                      <span class="sr-only"></span>
                                      </th>
                                  </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                  @php
                                      $globalcajasbulto=0;
                                      $globalpesoneto=0;
                                      $globalcostos=0;
                                      $globalcostoscom=0;
                                      $globalmargen=0;

                                      $globaltotalmateriales=0;
                                      
                                      $globalfletehuerto=0;
                                      $globalgastoexportacion=0;

                                      $globalventafob=0;
                                      $globalventafobexp=0;
                                      $globalventafobnacio=0;
                                      
                                      $globalkgsp=0;
                                      $globalcostopacking=0;
                                      
                                      
                                                      
                                  
                                @endphp 
                                        @foreach ($unique_variedades as $item)
                                            <tr>
                                              <td class="px-6 py-0 whitespace-nowrap">
                                                  <div class="text-sm text-gray-900">{{$item->name}}</div>    
                                              </td>
                                                <td class="px-6 py-0 whitespace-nowrap">
                                                  @php
                                                      $cajasbulto=0;
                                                      $pesoneto=0;
                                                      $costos=0;
                                                      $costoscom=0;
                                                      $margen=0;

                                                      $totalmateriales=0;
                                                      $fletehuerto=0;
                                                      $gastoexportacion=0;

                                                      $ventafob=0;
                                                      $ventafobexp=0;
                                                      $ventafobnacio=0;
                                                      
                                                      $kgsp=0;
                                                      $costopacking=0;

                                                    
                                                    
                                                  @endphp
                                                
                                                  @foreach ($masastotal as $masa)
                                                    @php
                                                      if ($masa->variedad==$item->name) {
                                                        $cajasbulto+=$masa->cantidad;
                                                        $pesoneto+=floatval($masa->peso_prorrateado);
                                                        $margen+=floatval($masa->margen);
                                                        $globalmargen+=floatval($masa->margen);
                                                        
                                                        $globalcajasbulto+=$masa->cantidad;
                                                        $globalpesoneto+=floatval($masa->peso_prorrateado);
                                                        
                                                        if (!IS_NULL($masa->fob) || !IS_NULL($masa->fob_nacional)) {
                                                          $ventafob+=floatval($masa->fob)+floatval($masa->fob_nacional);
                                                          $globalventafob+=floatval($masa->fob)+floatval($masa->fob_nacional);
                                                          
                                                          $ventafobexp+=floatval($masa->fob);
                                                          $globalventafobexp+=floatval($masa->fob);
                                                          
                                                          $ventafobnacio+=floatval($masa->fob_nacional);
                                                          $globalventafobnacio+=floatval($masa->fob_nacional);
                                                          
                                                        } else {
                                                          $kgsp+=floatval($masa->peso_prorrateado);
                                                          $globalkgsp+=floatval($masa->peso_prorrateado);
                                                        }

                                                        if (!IS_NULL($masa->costo)) {
                                                          $costos+=floatval($masa->costo);
                                                          $globalcostos+=floatval($masa->costo);
                                                        }
                                                        if(!IS_NULL($masa->costo_nacional)){
                                                          $costoscom+=floatval($masa->costo_nacional);
                                                          $globalcostoscom+=floatval($masa->costo_nacional);
                                                        }
                                                        
                                                        
                                                        
                                                        if ($masa->tipo_transporte=='AEREO') {
                                                              if ($exportacions->where('type','aereo')->count()>0) {
                                                                $gastoexportacion+=$masa->peso_neto*$exportacions->where('type','aereo')->first()->precio_usd;
                                                                $globalgastoexportacion+=$masa->peso_neto*$exportacions->where('type','aereo')->first()->precio_usd;
                                                              }
                                                          }
                                                        if ($masa->tipo_transporte=='MARITIMO') {
                                                          if ($exportacions->where('type','maritimo')->count()>0) {
                                                              $gastoexportacion+=$masa->peso_neto*$exportacions->where('type','maritimo')->first()->precio_usd;
                                                              $globalgastoexportacion+=$masa->peso_neto*$exportacions->where('type','maritimo')->first()->precio_usd;
                                                            }
                                                          }

                                                        foreach ($materialestotal as $material) {
                                                          if ($material->c_embalaje==$masa->cod_embalaje) {
                                                            $totalmateriales+=$masa->peso_prorrateado*$material->tarifa_kg;
                                                            $globaltotalmateriales+=$masa->peso_prorrateado*$material->tarifa_kg;
                                                          }  
                                                        }

                                                        foreach ($fletestotal as $flete) {
                                                          if ($flete->rut==$masa->r_productor) {
                                                            $fletehuerto+=$masa->peso_neto*$flete->tarifa;
                                                            $globalfletehuerto+=$masa->peso_neto*$flete->tarifa;
                                                          }  
                                                        }
                                                      }
                                                      
                                                    @endphp
                                                  @endforeach
                                                      @php
                                                          
                                                  foreach ($CostosPackingsall as $costo) {
                                                    if ($costo->variedad==$item->name) {
                                                      $costopacking+=$costo->total_usd;
                                                      $globalcostopacking+=$costo->total_usd;
                                                    }  
                                                  }

                                                  
                                                

                                                  @endphp

                                                    <div class="text-sm text-gray-900">
                                                        {{number_format($cajasbulto)}}
                                                    </div>    
                                                </td>

                                                <td class="px-6 py-0 whitespace-nowrap">
                                                  <div class="text-sm text-gray-900">{{number_format($pesoneto)}}</div>    
                                                </td>
                                                <td class="px-6 py-0 whitespace-nowrap">
                                                  <div class="text-sm text-gray-900">{{ number_format($pesoneto/5,0)}}</div>    
                                                </td>
                                                <td class="px-6 py-0 whitespace-nowrap">
                                                  <div class="text-sm text-gray-900">{{number_format($ventafobexp,2,'.','.')}} </div>    
                                                </td>
                                                <td class="px-6 py-0 whitespace-nowrap">
                                                  <div class="text-sm text-gray-900">{{number_format($ventafobnacio,2,'.','.')}} </div>    
                                                </td>
                                                <td class="px-6 py-0 whitespace-nowrap">
                                                  <div class="text-sm text-gray-900">{{number_format($ventafob,2,'.','.')}} </div>    
                                                </td>
                                                <td class="px-6 py-0 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">{{number_format($margen ,2,'.','.')}}</div>    
                                                </td>
                                                {{-- comment
                                                
                                                <td class="px-6 py-0 whitespace-nowrap">
                                                  <div class="text-sm text-gray-900">{{number_format($costopacking ,2,'.','.')}}</div>    
                                                </td>
                                                  <td class="px-6 py-0 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">{{number_format($gastoexportacion,2,'.','.')}}</div>    
                                                  </td>
                                                  <td class="px-6 py-0 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">{{number_format($fletehuerto,2,'.','.')}}</div>    
                                                  </td>
                                                <td class="px-6 py-0 whitespace-nowrap">
                                                  <div class="text-sm text-gray-900">{{number_format($globaltotalotroscostos*($pesoneto/$masatotal),2,'.','.')}}</div>    
                                                </td>
                                                  --}}

                                                <td class="px-6 py-0 whitespace-nowrap">
                                                  <div class="text-sm text-gray-900">{{number_format($costos,2,'.','.')}}</div>    
                                                </td>
                                                <td class="px-6 py-0 whitespace-nowrap">
                                                  <div class="text-sm text-gray-900">{{number_format($costoscom,2,'.','.')}}</div>    
                                                </td>
                                                <td class="px-6 py-0 whitespace-nowrap">
                                                  <div class="text-sm text-gray-900">{{number_format($ventafob+$margen+$costos+$costoscom,2,'.','.')}}</div>    
                                                </td>
                                                <td class="px-6 py-0 whitespace-nowrap">
                                                  <div class="text-sm text-gray-900">
                                                    @if ($pesoneto==0)
                                                      0      
                                                    @else
                                                    {{number_format(($ventafob+$margen+$costos+$costoscom)/$pesoneto,2,'.','.')}}
                                                        
                                                    @endif
                                                  </div>    
                                                </td>
                                                <td class="px-6 py-0 whitespace-nowrap text-right text-sm font-medium">
                                                    <a href="" class="text-indigo-600 hover:text-indigo-900">Ver detalles</a>
                                                </td>
                                            </tr>
                                        @endforeach

                                        <tr class="bg-yellow-400">
                                          <td class="px-6 py-0 whitespace-nowrap bg-yellow-500">
                                              <div class="text-sm text-gray-900">Total</div>    
                                          </td>
                                            <td class="px-6 py-0 whitespace-nowrap bg-yellow-500">
                                                <div class="text-sm text-gray-900">
                                                    {{number_format($globalcajasbulto)}}
                                                </div>    
                                            </td>
                                            <td class="px-6 py-0 whitespace-nowrap bg-yellow-500">
                                              <div class="text-sm text-gray-900">{{number_format($globalpesoneto)}}</div>    
                                            </td>
                                            <td class="px-6 py-0 whitespace-nowrap bg-yellow-500">
                                              <div class="text-sm text-gray-900">{{ number_format($globalpesoneto/5,0)}}</div>    
                                            </td>
                                            <td class="px-6 py-0 whitespace-nowrap bg-yellow-500">
                                              <div class="text-sm text-gray-900">{{number_format($globalventafobexp,2,'.','.')}}</div>    
                                            </td>
                                            <td class="px-6 py-0 whitespace-nowrap bg-yellow-500">
                                              <div class="text-sm text-gray-900">{{number_format($globalventafobnacio,2,'.','.')}}</div>    
                                            </td>
                                            <td class="px-6 py-0 whitespace-nowrap bg-yellow-500">
                                              <div class="text-sm text-gray-900">{{number_format($globalventafob,2,'.','.')}}</div>    
                                            </td>
                                            <td class="px-6 py-0 whitespace-nowrap bg-yellow-500">
                                                <div class="text-sm text-gray-900">{{number_format($globalmargen ,2,'.','.')}}</div>    
                                            </td>
                                          
                                            {{-- comment 
                                            <td class="px-6 py-0 whitespace-nowrap bg-yellow-500">
                                              <div class="text-sm text-gray-900">{{number_format($globalcostopacking ,2,'.','.')}}</div>    
                                            </td>
                                              <td class="px-6 py-0 whitespace-nowrap bg-yellow-500">
                                                <div class="text-sm text-gray-900">{{number_format($globalgastoexportacion,2,'.','.')}}</div>    
                                              </td>
                                              <td class="px-6 py-0 whitespace-nowrap bg-yellow-500">
                                                <div class="text-sm text-gray-900">{{number_format($globalfletehuerto)}}</div>    
                                              </td>
                                              <td class="px-6 py-0 whitespace-nowrap bg-yellow-500">
                                              <div class="text-sm text-gray-900">{{number_format($globaltotalmateriales,2,'.','.')}}</div>    
                                            </td>
                                            --}}
                                            <td class="px-6 py-0 whitespace-nowrap bg-yellow-500">
                                              <div class="text-sm text-gray-900">{{number_format($globalcostos,2,'.','.')}}</div>    
                                            </td>
                                            <td class="px-6 py-0 whitespace-nowrap bg-yellow-500">
                                              <div class="text-sm text-gray-900">{{number_format($globalcostoscom,2,'.','.')}}</div>    
                                            </td>
                                          
                                            <td class="px-6 py-0 whitespace-nowrap bg-yellow-500">
                                              <div class="text-sm text-gray-900">{{number_format(($globalventafob+$globalmargen+$globalcostos+$globalcostoscom),2,'.','.')}}</div>    
                                            </td>
                                            <td class="px-6 py-0 whitespace-nowrap bg-yellow-500">
                                              <div class="text-sm text-gray-900">
                                                @if ($globalpesoneto==0)
                                                    0
                                                @else
                                                  {{number_format(($globalventafob+$globalmargen+$globalcostos+$globalcostoscom)/$globalpesoneto,2,'.','.')}}</div>    
                                                    
                                                @endif
                                            </td>
                                            <td class="px-6 py-0 whitespace-nowrap text-right text-sm font-medium bg-yellow-500">
                                                <a href="" class="text-gray-600 hover:text-gray-900">Ver detalles</a>
                                            </td>
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="flex ">
                    <a href="{{Route('variedades.refresh',$temporada)}}" class="mr-2">
                      <x-button>
                        Actualizar Variedades
                      </x-button>
                    </a>
                    <a href="{{Route('preciofob.refresh',$temporada)}}">
                      <x-button>
                        Actualizar PRECIO FOB
                      </x-button>
                    </a>
                  </div>
              @endif

              @if ($vista!='grafico' && $vista!='saldoaliquidar')
                <div class="flex justify-between ml-4 mt-4">
                  @if ($vista=='MASAS')
                    <a href="{{Route('preciofob.refresh',$temporada)}}">
                      <x-button>
                        Actualizar PRECIO FOB
                      </x-button>
                    </a>
                  @endif
                  
                  <select wire:model.live="ctd" class="max-w-xl  mx-2 bg-gray-200 border border-gray-200 text-gray-700 py-3 px-6 rounded focus:outline-none focus:bg-white focus:border-gray-500">
                      <option value="25" class="text-left px-10">25 </option>
                      <option value="50" class="text-left px-10">50 </option>
                      <option value="100" class="text-left px-10">100 </option>
                      <option value="500" class="text-left px-10">500 </option>
                      
                  </select>
                </div>
              @endif
              
              <div class="px-4 sm:px-2 py-2 overflow-x-auto">
                <div class="inline-block min-w-full rounded-lg overflow-hidden">

                  @if ($vista=='resumes' || $vista=='show')
                    <!-- Tabla con checkbox interactivo -->
                    <div class="flex flex-col">
                      <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                          <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                              <thead class="bg-white border-b">
                                <tr>
                                  <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">#</th>
                                  <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Name</th>
                                  <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Rut</th>
                                  <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Csg</th>
                                  <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left hidden">Acción</th>
                                  <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Informe</th>
                                  <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Nota</th>
                                  <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Propio</th>
                                </tr>
                              </thead>
                              <tbody>
                                @php
                                  $n = 1;
                                @endphp
                                @foreach ($razons as $razon)
                                      <tr class="bg-gray-100 border-b">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $n }})</td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                          @if ($razon && $temporada)
                                          <a href="{{ route('razonsocial.show', ['razonsocial' => $razon, 'temporada' => $temporada]) }}" target="_blank">{{ $razon->name }}</a>
                                          @endif
                                        </td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ $razon->rut }}</td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ $razon->csg }}</td>
                                        <td class="text-sm text-gray-900 font-light px-2 py-4 whitespace-nowrap hidden">
                                          <a href="{{ route('exportpdff', ['informe' => $razon->informes->reverse()->first()]) }}" target="_blank">
                                            <x-button>Generar</x-button>
                                          </a>
                                        </td>
                                        <td class="text-sm text-gray-900 font-light py-4 text-center">
                                          @if ($razon->informes->reverse()->first()->informe)
                                            <a href="{{ route('informe.download', $razon->informes->reverse()->first()) }}" target="_blank" class="h-10 mr-2 items-center content-center">
                                              <img class="h-10 object-contain mx-auto mb-2" src="{{ asset('image/pdf_icon2.png') }}" title="Descargar" alt="">
                                            </a>
                                            <a href="{{route('exportpdff',['informe' => $razon->informes->reverse()->first()])}}" target="_blank" class="text-xs">
                                              <x-button>
                                                ReGenerar
                                                Informe
                                              </x-button>
                                            </a>
                                          @else
                                            <a href="{{route('exportpdff',['informe' => $razon->informes->reverse()->first()])}}" target="_blank">
                                              <x-button>
                                                Generar
                                                Informe
                                              </x-button>
                                            </a>
                                          @endif
                                        </td>
                                        <td class="text-sm text-gray-900 font-light py-4 text-center">
                                          @if ($razon->informes->reverse()->first()->nota)
                                            <a href="{{ route('informe.download2', $razon->informes->reverse()->first()) }}" target="_blank" class="h-10 mr-2 items-center content-center">
                                              <img class="h-10 object-contain mx-auto mb-2" src="{{ asset('image/pdf_icon2.png') }}" title="Descargar" alt="">
                                            </a>
                                            <a href="{{route('exportpdff2',['informe' => $razon->informes->reverse()->first()])}}" target="_blank" class="text-xs">
                                              <x-button>
                                               ReGenerar
                                                NC/ND
                                              </x-button>
                                            </a>
                                          @else
                                            <a href="{{route('exportpdff2',['informe' => $razon->informes->reverse()->first()])}}" target="_blank">
                                              <x-button>
                                                Generar
                                                NC/ND
                                              </x-button>
                                            </a>
                                          @endif
                                        </td>
                                        <!-- Columna del checkbox "Propio" -->
                                        <!-- Columna del checkbox "Propio" con mensaje dinámico -->
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 text-center">
                                          <div class="flex justify-center items-center mb-2">
                                            <input type="checkbox" wire:change="togglePropio({{ $razon->id }})" {{ $razon->is_propio ? 'checked' : '' }}>
                                          </div>
                                          <!-- Mostrar mensaje si existe para esta razón social -->
                                          @if (session()->has('status_' . $razon->id))
                                              <span class="text-gray-600 text-center mt-2">{{ session('status_' . $razon->id) }}</span>
                                          @endif
                                        </td>

                                    

                                      </tr>
                                @php
                                  $n += 1;
                                @endphp
                                @endforeach
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  @endif

                  @if ($vista=='grafico')
                    <!-- Tabla con checkbox interactivo -->
                    
                    <div>
                      <div id="container" style="width: 100%; height: 400px;"></div>
                    </div>
                    <div class="flex ">
                      <a href="{{Route('variedades.refresh',$temporada)}}" class="mr-2">
                        <x-button>
                          Actualizar Variedades
                        </x-button>
                      </a>
                     
                    </div>

                  @endif

                  @if ($vista=='saldoaliquidar2')
                    <div class="flex flex-col mb-2">
                      <div class="-my-2 overflow-x-auto">
                        <div class="py-2 align-middle inline-block min-w-full">
                          <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-yellow-400">
                                  <tr>
                                    <th class="px-6 py-0 text-center text-xs font-bold text-gray-900">
                                      PRODUCTOR
                                    </th>
                                    <th class="px-6 py-0 text-center text-xs font-bold text-gray-900">
                                      KG
                                    </th>
                                    <th class="px-6 py-0 text-center text-xs font-bold text-gray-900">
                                      VENTA FOB
                                    </th>
                                    <th class="px-6 py-0 text-center text-xs font-bold text-gray-900">
                                      VENTA 2 FOB
                                    </th>
                                    <th class="px-6 py-0 text-center text-xs font-bold text-gray-900">
                                      VENTA COMERCIAL
                                    </th>
                                    <th class="px-6 py-0 text-center text-xs font-bold text-gray-900">
                                      COSTOS GENERAL
                                    </th>
                                    <th class="px-6 py-0 text-center text-xs font-bold text-gray-900">
                                      COSTOS DIFERENCIAL
                                    </th>
                                    <th class="px-6 py-0 text-center text-xs font-bold text-gray-900">
                                      %
                                    </th>
                                    <th class="px-6 py-0 text-center text-xs font-bold text-gray-900">
                                      Retorno Precio Unico
                                    </th>
                                    <th class="px-6 py-0 text-center text-xs font-bold text-gray-900">
                                    GASTOS
                                    </th>
                                    <th class="px-6 py-0 text-center text-xs font-bold text-gray-900">
                                    ANTICIPOS
                                    </th>
                                    <th class="px-6 py-0 text-center text-xs font-bold text-gray-900">
                                      A LIQUIDAR
                                    </th>
                                    <th class="px-6 py-0 text-center text-xs font-bold text-gray-900">
                                        KILO HUASO
                                    </th>
                                
                                  </tr>
                                </thead>
                                @php
                                    //PRECIO ORIGINAL
                                    $ventatotalaliquidar=0;
                                    //PRECIO MODIFICADO
                                    $venta2totalaliquidar=0;
                                    //COMERCIAL
                                    $venta3totalaliquidar=0;
                                    $margentotalaliquidar=0;
                                    $pesototalaliquidar=0;
                                    $costototalaliquidar=0;
                                    $costo2totalaliquidar=0;
                                    $gastototalaliquidar=0;
                                    $anticipototalaliquidar=0;
                                    $cont=1;
                                    
                                    $totalaliquidar=0;
                                    $totalaliquidar_huaso=0;
                                    $control=true;

                                @endphp
                                <tbody class="bg-white divide-y divide-gray-200">
                                  @foreach ($razonsall2 as $razon)
                                      @php
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

                                        
                                          
                                        

                                      @endphp
                              
                                        <tr class="@if($control==true) bg-gray-100 @else @endif">
                                          <td class="px-6 py-0 whitespace-nowrap">
                                            @php
                                                $razonExiste = $razonsall->where('name', $razon)->first();
                                            @endphp

                                            @if ($razonExiste)
                                                <!-- Mostrar contenido si el registro existe -->
                                                <a href="{{ route('razonsocial.show', ['razonsocial' => $razonExiste, 'temporada' => $temporada]) }}">
                                                  <div class="text-sm text-gray-900 font-bold">{{$cont}}) {{$razon}}</div>  
                                                </a>
                                            @else
                                                <!-- Mostrar contenido si el registro no existe -->
                                                <div class="text-sm text-red-900">{{$cont}}) {{$razon}}</div>  
                                            @endif

                                            
                                            @php
                                                $cont+=1;
                                            @endphp  
                                          </td>
                                          @foreach ($masastotal->filter(function($item) use ($razon) {
                                                      return trim($item->PRODUCTOR_RECEP_FACTURACION) === trim($razon);
                                                    }) as $item)
                                                  @php
                                                      $peso = floatval($item->PESO_PRORRATEADO);
                                                      $pesototalaliquidar += floatval($item->PESO_PRORRATEADO);
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
                                                      
                                                        $ventatotalaliquidar+= floatval($tarifaAplicada * $peso);
                                                        $venta2totalaliquidar+= floatval($tarifafinal3 * $peso);
                                                      }

                                                      if ($item->CRITERIO=="COMERCIAL") {
                                                        $venta3srazon += floatval($tarifaAplicada * $peso);
                                                        $venta3totalaliquidar += floatval($tarifaAplicada * $peso);
                                                      }
                                                      

                                                      if ($item->CRITERIO=="EXPORTACIÓN") {
                                                        $margenrazon += floatval($tarifafinal3 * $peso*0.08);
                                                        $margentotalaliquidar += floatval($tarifafinal3 * $peso*0.08);
                                                      }
                                                    }

                                                    
                                                    $costosrazon += floatval($item->costo_proceso+$item->costo_materiales+$item->otros_costos);
                                                    $costototalaliquidar += floatval($item->costo_proceso+$item->costo_materiales+$item->otros_costos);

                                                    $costo2srazon += floatval($item->costo);
                                                    $costo2totalaliquidar += floatval($item->costo);
                                                    
                                                    $kgrazon += floatval($item->PESO_PRORRATEADO);
                                                    $gastosrazon += floatval($item->gastos);
                                                    $gastototalaliquidar += floatval($item->gastos);
                                                  
                                                    $anticiposrazon += floatval($item->anticipos);
                                                    $anticipototalaliquidar += floatval($item->anticipos);

                                                  
                                                  @endphp
                                            
                                          @endforeach
                                          @php
                                              $aliquidar=$venta2srazon+$venta3srazon-$costo2srazon-$margenrazon-$gastosrazon-$anticiposrazon;
                                              $aliquidar_huaso=$venta2srazon+$venta3srazon-$costo2srazon-$margenrazon;
                                              
                                              $totalaliquidar+=$aliquidar;
                                              $totalaliquidar_huaso+=$aliquidar_huaso;
                                          @endphp

                                          <td class="px-6 py-0 whitespace-nowrap text-right pr-6">
                                            <div class="text-sm text-gray-900">
                                              @if ($kgrazon>0) 
                                                {{number_format($kgrazon,2,',','.')}}
                                              @else
                                                  0
                                              @endif  
                                            </div>    
                                          </td>
                                          <td class="px-6 py-0 whitespace-nowrap text-right pr-6">
                                            <div class="text-sm text-gray-900">
                                              @if ($ventasrazon>0) 
                                                {{number_format($ventasrazon,2,',','.')}}
                                              @else
                                                  0
                                              @endif  
                                            </div>    
                                          </td>
                                          <td class="px-6 py-0 whitespace-nowrap text-right pr-6">
                                            <div class="text-sm text-gray-900">
                                              @if ($ventasrazon>0) 
                                                {{number_format($venta2srazon,2,',','.')}}
                                              @else
                                                  0
                                              @endif  
                                            </div>    
                                          </td>
                                          <td class="px-6 py-0 whitespace-nowrap text-right pr-6">
                                            <div class="text-sm text-gray-900">
                                              @if ($ventasrazon>0) 
                                                {{number_format($venta3srazon,2,',','.')}}
                                              @else
                                                  0
                                              @endif  
                                            </div>    
                                          </td>
                                          <td class="px-6 py-0 whitespace-nowrap text-right pr-6">
                                            <div class="text-sm text-gray-900">
                                              @if ($costo2srazon>0) 
                                                {{number_format($costo2srazon,2,',','.')}}
                                              @else
                                                  0
                                              @endif  
                                            </div>    
                                          </td>

                                          <td class="px-6 py-0 whitespace-nowrap text-right pr-6">
                                            <div class="text-sm text-gray-900">
                                              @if ($costosrazon>0) 
                                                {{number_format($costosrazon,2,',','.')}}
                                              @else
                                                  0
                                              @endif  
                                            </div>    
                                          </td>
                                          
                                          <td class="px-6 py-0 whitespace-nowrap text-right pr-6">
                                            <div class="text-sm text-gray-900">
                                              @if ($margenrazon>0) 
                                                {{number_format($margenrazon,2,',','.')}}
                                              @else
                                                  0
                                              @endif  
                                            </div>    
                                          </td>
                                          <td class="px-6 py-0 whitespace-nowrap text-right pr-6">
                                            <div class="text-sm text-gray-900">
                                              @if ($margenrazon>0) 
                                                {{number_format($margenrazon,2,',','.')}}
                                              @else
                                                  0
                                              @endif  
                                            </div>    
                                          </td>
                                          <td class="px-6 py-0 whitespace-nowrap text-right pr-6">
                                            <div class="text-sm text-gray-900">
                                              @if ($gastosrazon>0) 
                                                {{number_format($gastosrazon,2,',','.')}}
                                              @else
                                                  0
                                              @endif  
                                            </div>    
                                          </td>
                                          <td class="px-6 py-0 whitespace-nowrap text-right pr-6">
                                            <div class="text-sm text-gray-900">
                                              @if ($anticiposrazon>0) 
                                                {{number_format($anticiposrazon,2,',','.')}}
                                              @else
                                                  0
                                              @endif  
                                            </div>    
                                          </td>
                                          <td class="px-6 py-0 whitespace-nowrap text-right pr-6">
                                            <div class="text-sm text-gray-900">
                                              {{number_format($aliquidar,2,',','.')}}
                                            </div>    
                                          </td>
                                          <td class="px-6 py-0 whitespace-nowrap text-right pr-6">
                                            <div class="text-sm text-gray-900">
                                              @if ($kgrazon>0) 
                                                {{number_format(($aliquidar_huaso)/$kgrazon,2,',','.')}}
                                              @else
                                                  0
                                              @endif  
                                            </div>    
                                          </td>

                                          
                                        </tr>
                                      
                                      
                                  
                                      @php
                                          $control=!$control;
                                      @endphp
                                      
                                  @endforeach
                                  <tr>
                                    <td>

                                    </td>
                                    <td>
                                      {{number_format($pesototalaliquidar,2)}}
                                    </td>
                                    <td>
                                      {{number_format($ventatotalaliquidar,2)}}
                                    </td>
                                    <td>
                                      {{number_format($venta2totalaliquidar,2)}}
                                    </td>
                                    <td>
                                      {{number_format($venta3totalaliquidar,2)}}
                                    </td>
                                    <td>
                                      {{number_format($costo2totalaliquidar,2)}}
                                    </td>
                                    <td>
                                      {{number_format($costototalaliquidar,2)}}
                                    </td>
                                    <td>
                                      {{number_format($margentotalaliquidar,2)}}
                                    </td>
                                    <td>
                                      {{number_format($gastototalaliquidar,2)}}
                                    </td>
                                    <td>
                                      {{number_format($anticipototalaliquidar,2)}}
                                    </td>
                                    <td>
                                      {{number_format($totalaliquidar,2)}}
                                    </td>
                                    <td>
                                              @if ($pesototalaliquidar>0) 
                                                {{number_format(($totalaliquidar_huaso)/$pesototalaliquidar,2,',','.')}}
                                              @else
                                                  0
                                              @endif  
                                    </td>
                                  </tr>
                                  
                                </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  @endif

                  @if ($vista=='saldoaliquidar')
                    <!-- Tabla con checkbox interactivo -->
                    <div class="flex flex-col mb-2">
                      <div class="-my-2 overflow-x-auto">
                        <div class="py-2 align-middle inline-block min-w-full">
                          <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-yellow-400">
                                  <tr>
                                    <th class="px-6 py-0 text-center text-xs font-bold text-gray-900">
                                      PRODUCTOR
                                    </th>
                                    <th class="px-6 py-0 text-center text-xs font-bold text-gray-900">
                                      KG
                                    </th>
                                    <th class="px-6 py-0 text-center text-xs font-bold text-gray-900">
                                      VENTA FOB
                                    </th>
                                    <th class="px-6 py-0 text-center text-xs font-bold text-gray-900">
                                      VENTA 2 FOB
                                    </th>
                                    <th class="px-6 py-0 text-center text-xs font-bold text-gray-900">
                                      VENTA COMERCIAL
                                    </th>
                                    <th class="px-6 py-0 text-center text-xs font-bold text-gray-900">
                                      COSTOS GENERAL
                                    </th>
                                    <th class="px-6 py-0 text-center text-xs font-bold text-gray-900">
                                      COSTOS DIFERENCIAL
                                    </th>
                                    <th class="px-6 py-0 text-center text-xs font-bold text-gray-900">
                                      %
                                    </th>
                                    <th class="px-6 py-0 text-center text-xs font-bold text-gray-900">
                                     GASTOS
                                    </th>
                                    <th class="px-6 py-0 text-center text-xs font-bold text-gray-900">
                                     ANTICIPOS
                                    </th>
                                    <th class="px-6 py-0 text-center text-xs font-bold text-gray-900">
                                      A LIQUIDAR
                                    </th>
                                    <th class="px-6 py-0 text-center text-xs font-bold text-gray-900">
                                        KILO HUASO
                                    </th>
                                 
                                  </tr>
                                </thead>
                                @php
                                    //PRECIO ORIGINAL
                                    $ventatotalaliquidar=0;
                                    //PRECIO MODIFICADO
                                    $venta2totalaliquidar=0;
                                    //COMERCIAL
                                    $venta3totalaliquidar=0;
                                    $margentotalaliquidar=0;
                                    $pesototalaliquidar=0;
                                    $costototalaliquidar=0;
                                    $costo2totalaliquidar=0;
                                    $gastototalaliquidar=0;
                                    $anticipototalaliquidar=0;
                                    $cont=1;
                                    
                                    $totalaliquidar=0;
                                    $control=true;

                                @endphp
                                <tbody class="bg-white divide-y divide-gray-200">
                                  @foreach ($razonsall2 as $razon)
                                      @php
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

                                         
                                          
                                        

                                      @endphp
                               
                                        <tr class="@if($control==true) bg-gray-100 @else @endif">
                                          <td class="px-6 py-0 whitespace-nowrap">
                                            @php
                                                $razonExiste = $razonsall->where('name', $razon)->first();
                                            @endphp

                                            @if ($razonExiste)
                                                <!-- Mostrar contenido si el registro existe -->
                                                <a href="{{ route('razonsocial.show', ['razonsocial' => $razonExiste, 'temporada' => $temporada]) }}">
                                                  <div class="text-sm text-gray-900 font-bold">{{$cont}}) {{$razon}}</div>  
                                                </a>
                                            @else
                                                <!-- Mostrar contenido si el registro no existe -->
                                                <div class="text-sm text-red-900">{{$cont}}) {{$razon}}</div>  
                                            @endif

                                            
                                            @php
                                                $cont+=1;
                                            @endphp  
                                          </td>
                                          @foreach ($masastotal->filter(function($item) use ($razon) {
                                                      return trim($item->PRODUCTOR_RECEP_FACTURACION) === trim($razon);
                                                    }) as $item)
                                                  @php
                                                      $peso = floatval($item->PESO_PRORRATEADO);
                                                      $pesototalaliquidar += floatval($item->PESO_PRORRATEADO);
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
                                                      
                                                        $ventatotalaliquidar+= floatval($tarifaAplicada * $peso);
                                                        $venta2totalaliquidar+= floatval($tarifafinal3 * $peso);
                                                      }

                                                      if ($item->CRITERIO=="COMERCIAL") {
                                                        $venta3srazon += floatval($tarifaAplicada * $peso);
                                                        $venta3totalaliquidar += floatval($tarifaAplicada * $peso);
                                                      }
                                                      

                                                      if ($item->CRITERIO=="EXPORTACIÓN") {
                                                        $margenrazon += floatval($tarifafinal3 * $peso*0.08);
                                                        $margentotalaliquidar += floatval($tarifafinal3 * $peso*0.08);
                                                      }
                                                    }

                                                    if ($item->CRITERIO=="COMERCIAL") {
                                                      $costo2srazon += floatval($item->costo_proceso);
                                                      $costo2totalaliquidar += floatval($item->costo_proceso);
                                                    }

                                                    $costosrazon += floatval($item->costo_proceso+$item->costo_materiales+$item->otros_costos);
                                                    $costototalaliquidar += floatval($item->costo_proceso+$item->costo_materiales+$item->otros_costos);

                                                    $costo2srazon += floatval($item->costo);
                                                    $costo2totalaliquidar += floatval($item->costo);
                                                    
                                                    $kgrazon += floatval($item->PESO_PRORRATEADO);
                                                    $gastosrazon += floatval($item->gastos);
                                                    $gastototalaliquidar += floatval($item->gastos);
                                                  
                                                    $anticiposrazon += floatval($item->anticipos);
                                                    $anticipototalaliquidar += floatval($item->anticipos);

                                                   
                                                  @endphp
                                            
                                          @endforeach
                                          @php
                                              $aliquidar=$venta2srazon+$venta3srazon-$costo2srazon-$margenrazon-$gastosrazon-$anticiposrazon;
                                               $totalaliquidar+=$aliquidar;
                                          @endphp

                                          <td class="px-6 py-0 whitespace-nowrap text-right pr-6">
                                            <div class="text-sm text-gray-900">
                                              @if ($kgrazon>0) 
                                                {{number_format($kgrazon,2,',','.')}}
                                              @else
                                                  0
                                              @endif  
                                            </div>    
                                          </td>
                                          <td class="px-6 py-0 whitespace-nowrap text-right pr-6">
                                            <div class="text-sm text-gray-900">
                                              @if ($ventasrazon>0) 
                                                {{number_format($ventasrazon,2,',','.')}}
                                              @else
                                                  0
                                              @endif  
                                            </div>    
                                          </td>
                                          <td class="px-6 py-0 whitespace-nowrap text-right pr-6">
                                            <div class="text-sm text-gray-900">
                                              @if ($ventasrazon>0) 
                                                {{number_format($venta2srazon,2,',','.')}}
                                              @else
                                                  0
                                              @endif  
                                            </div>    
                                          </td>
                                          <td class="px-6 py-0 whitespace-nowrap text-right pr-6">
                                            <div class="text-sm text-gray-900">
                                              @if ($ventasrazon>0) 
                                                {{number_format($venta3srazon,2,',','.')}}
                                              @else
                                                  0
                                              @endif  
                                            </div>    
                                          </td>
                                          <td class="px-6 py-0 whitespace-nowrap text-right pr-6">
                                            <div class="text-sm text-gray-900">
                                              @if ($costo2srazon>0) 
                                                {{number_format($costo2srazon,2,',','.')}}
                                              @else
                                                  0
                                              @endif  
                                            </div>    
                                          </td>

                                          <td class="px-6 py-0 whitespace-nowrap text-right pr-6">
                                            <div class="text-sm text-gray-900">
                                              @if ($costosrazon>0) 
                                                {{number_format($costosrazon,2,',','.')}}
                                              @else
                                                  0
                                              @endif  
                                            </div>    
                                          </td>
                                           
                                          <td class="px-6 py-0 whitespace-nowrap text-right pr-6">
                                            <div class="text-sm text-gray-900">
                                              @if ($margenrazon>0) 
                                                {{number_format($margenrazon,2,',','.')}}
                                              @else
                                                  0
                                              @endif  
                                            </div>    
                                          </td>
                                          <td class="px-6 py-0 whitespace-nowrap text-right pr-6">
                                            <div class="text-sm text-gray-900">
                                              @if ($gastosrazon>0) 
                                                {{number_format($gastosrazon,2,',','.')}}
                                              @else
                                                  0
                                              @endif  
                                            </div>    
                                          </td>
                                          <td class="px-6 py-0 whitespace-nowrap text-right pr-6">
                                            <div class="text-sm text-gray-900">
                                              @if ($anticiposrazon>0) 
                                                {{number_format($anticiposrazon,2,',','.')}}
                                              @else
                                                  0
                                              @endif  
                                            </div>    
                                          </td>
                                          <td class="px-6 py-0 whitespace-nowrap text-right pr-6">
                                            <div class="text-sm text-gray-900">
                                              {{number_format($aliquidar,2,',','.')}}
                                            </div>    
                                          </td>
                                          <td class="px-6 py-0 whitespace-nowrap text-right pr-6">
                                            <div class="text-sm text-gray-900">
                                              @if ($kgrazon>0) 
                                                {{number_format(($ventasrazon+$venta3srazon-$costo2srazon-$margenrazon)/$kgrazon,2,',','.')}}
                                              @else
                                                  0
                                              @endif  
                                            </div>    
                                          </td>

                                          
                                        </tr>
                                       
                                      
                                   
                                      @php
                                          $control=!$control;
                                      @endphp
                                      
                                  @endforeach
                                  <tr>
                                    <td>

                                    </td>
                                    <td>
                                      {{number_format($pesototalaliquidar,2)}}
                                    </td>
                                    <td>
                                      {{number_format($ventatotalaliquidar,2)}}
                                    </td>
                                    <td>
                                      {{number_format($venta2totalaliquidar,2)}}
                                    </td>
                                    <td>
                                      {{number_format($venta3totalaliquidar,2)}}
                                    </td>
                                    <td>
                                      {{number_format($costo2totalaliquidar,2)}}
                                    </td>
                                    <td>
                                      {{number_format($costototalaliquidar,2)}}
                                    </td>
                                    <td>
                                      {{number_format($margentotalaliquidar,2)}}
                                    </td>
                                    <td>
                                      {{number_format($gastototalaliquidar,2)}}
                                    </td>
                                    <td>
                                      {{number_format($anticipototalaliquidar,2)}}
                                    </td>
                                    <td>
                                      {{number_format($totalaliquidar,2)}}
                                    </td>
                                    <td>
                                              @if ($pesototalaliquidar>0) 
                                                {{number_format(($ventatotalaliquidar+$venta3totalaliquidar-$costo2totalaliquidar-$margentotalaliquidar)/$pesototalaliquidar,2,',','.')}}
                                              @else
                                                  0
                                              @endif  
                                    </td>
                                  </tr>
                                  
                                </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>

                  @endif

                  @if ($vista=='PACKING')

                    <div>
                        <h1 class="text-xl font-semibold mb-4 text-center">
                            Por favor selecione el archivo de "Costos de packing" que desea importar
                        </h1>
                        <div class="flex justify-center">
                            
                            <form action="{{route('temporada.importCostosPacking')}}"
                                method="POST"
                                class="bg-white rounded p-8 shadow"
                                enctype="multipart/form-data">
                                
                                @csrf

                                <input type="hidden" name="temporada" value={{$temporada->id}}>

                                <x-validation-errors class="errors">

                                </x-validation-errors>

                                <input type="file" name="file" accept=".csv,.xlsx">

                                <x-button class="ml-4">
                                    Importar
                                </x-button>
                            </form>
                        </div>
                    </div>
                  
                    <table class="min-w-full leading-normal">
                      <thead>
                        <tr>
                          <th
                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Cliente
                          </th>
                          <th
                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Especie
                          </th>
                          <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                          Variedad
                          </th>
                          <th
                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Nombre Productor
                          </th>
                          <th
                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                          CSG
                          </th>
                          <th
                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            KG
                          </th>
                          <th
                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            TotalUSD
                          </th>
                          <th
                          class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                          NETO
                        </th>
                      
                      </tr>
                      </thead>
                      <tbody>
                        
                          @foreach ($CostosPackings as $packing)
                            <tr>
                              
                              <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap"> {{$packing->cliente}}</p>
                              </td>
                              
                              <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap"> {{$packing->especie}}</p>
                              </td>
                              
                              <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap"> {{$packing->variedad}}</p>
                              </td>

                              <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                <div class="flex items-center">
                                  <div class="flex-shrink-0 w-10 h-10 hidden">
                                    <img class="w-full h-full rounded-full"
                                                              src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2.2&w=160&h=160&q=80"
                                                              alt="" />
                                                      </div>
                                    <div class="ml-3">
                                      <p class="text-gray-900 whitespace-no-wrap">
                                                {{$packing->n_productor}}
                                            
                                        
                                      </p>
                                    </div>
                                  </div>
                              </td>
                              <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap"> {{$packing->csg}}</p>
                              </td>
                              <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">
                                  {{$packing->kg}}
                                </p>
                              </td>
                              <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">
                                
                                  {{number_format($packing->total_usd,2)}}
                                </p>
                              </td>

                              <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                <span
                                                      class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                                      <span aria-hidden
                                                          class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                <span class="relative">Activo</span>
                                </span>
                              </td>
                            </tr>
                          @endforeach
                      
                      </tbody>
                    </table>
                  @endif
                  @if ($vista=='MATERIALES') 

                    <div>
                      <h1 class="text-xl font-semibold mb-4 ml-4">
                          Por favor selecione el archivo de "Materiales" que desea importar 
                      </h1>
                    
              

                      <div class="flex">
                          
                          <form action="{{route('temporada.importMateriales')}}"
                              method="POST"
                              class="bg-white rounded p-8 shadow"
                              enctype="multipart/form-data">
                              
                              @csrf

                              <input type="hidden" name="temporada" value={{$temporada->id}}>

                              <x-validation-errors class="errors">

                              </x-validation-errors>

                              <input type="file" name="file" accept=".csv,.xlsx">

                              <x-button class="ml-4">
                                  Importar
                              </x-button>
                          </form>
                          </div>
                      </div>
                      <table class="min-w-full leading-normal">
                        <thead>
                          <tr>
                            <th
                              class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                              CODIGO DE EMBALAJE
                            </th>
                            <th
                              class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            DESCRIPCIÓN
                            </th>
                            <th
                              class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            KG
                            </th>
                            <th
                              class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                              TARIFA KG
                            </th>
                            <th
                              class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                              TOTAL USD
                            </th>
                          
                        </tr>
                        </thead>
                        <tbody>
                      
                            @foreach ($materiales as $material)
                              <tr>
                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                  <div class="flex items-center">
                                    <div class="flex-shrink-0 w-10 h-10 hidden">
                                      <img class="w-full h-full rounded-full"
                                                                src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2.2&w=160&h=160&q=80"
                                                                alt="" />
                                                        </div>
                                      <div class="ml-3">
                                        <p class="text-gray-900 whitespace-no-wrap">
                                          {{$material->c_embalaje}}
                                        </p>
                                      </div>
                                    </div>
                                </td>
                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                  <p class="text-gray-900 whitespace-no-wrap"> {{$material->descripcion}}</p>
                                </td> 
                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                  <p class="text-gray-900 whitespace-no-wrap"> {{$material->kg}}</p>
                                </td>
                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                  <p class="text-gray-900 whitespace-no-wrap"> {{$material->tarifa_kg}}</p>
                                </td>
                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                  <p class="text-gray-900 whitespace-no-wrap">
                                    {{$material->total_usd}}
                                  </p>
                                </td>
                            

                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                  <span
                                                        class="relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                                        <span aria-hidden
                                                            class="absolute inset-0 bg-gray-200 opacity-50 rounded-full"></span>
                                  <span class="relative">Editar</span>
                                  </span>
                                </td>
                              </tr>
                            @endforeach
                  
                        </tbody>
                      </table>
                  @endif
                  @if ($vista=='EXPORTACION') 
                    <div class="grid grid-cols-3 gap-x-4 items-center mb-6">

                      <select wire:model="type" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                          <option value="" class="text-center">Selecciona una categoría</option>
                          <option value="maritimo" class="text-center">Maritimo</option>
                          <option value="aereo" class="text-center">Aereo</option>
                          <option value="terrestre" class="text-center">Terrestre</option>

                          

                      </select>

                      <input wire:model="precio_usd" type="number" class="form-input flex-1 w-full shadow-sm  border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg focus:outline-none" autocomplete="off">
                      
                      <button wire:click="exportacion_store" class="focus:ring-2 focus:ring-offset-2 focus:ring-green-300 text-sm leading-none text-green-600 py-3 px-5 bg-green-600 rounded hover:bg-green-500 focus:outline-none">

                          <h1 style="font-size: 1rem;white-space: nowrap;" class="text-center text-white font-bold inline w-full" >
                          Agregar
                              
                          </h1>
                      </button>
                    </div>

                    <table class="min-w-full leading-normal">
                      <thead>
                        <tr>
                          <th
                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Tipo
                          </th>
                          <th
                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                          Precio USD
                          </th>
                          <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Acción
                            </th>
                        
                        
                      
                      </tr>
                      </thead>
                      <tbody>
                        
                        @if ($exportacions)
                            
                          @foreach ($exportacions as $exportacion)
                            <tr>
                              <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                <div class="flex items-center">
                                  <div class="flex-shrink-0 w-10 h-10 hidden">
                                    <img class="w-full h-full rounded-full"
                                                              src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2.2&w=160&h=160&q=80"
                                                              alt="" />
                                                      </div>
                                    <div class="ml-3">
                                      <p class="text-gray-900 whitespace-no-wrap">
                                        {{$exportacion->type}}
                                      </p>
                                    </div>
                                  </div>
                              </td>
                              <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap"> 
                              
                                  {{$exportacion->precio_usd}}</p>
                              </td>
                          
                          

                              <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                <a href="{{route('exportacion.edit',['exportacion'=>$exportacion,'temporada'=>$temporada])}}">
                                  <span class="relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                      <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full"></span>
                                      <span class="relative">Editar</span>
                                  </span>
                                </a>
                                <span wire:click="exportacion_destroy({{$exportacion->id}})" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-red-900 leading-tight">
                                    <span aria-hidden class="absolute inset-0 bg-red-200 opacity-50 rounded-full"></span>
                                    <span class="relative">Eliminar</span>
                                </span>
                              </td>
                            </tr>
                          @endforeach
                        @endif

                      </tbody>
                    </table>
                      
                  
                    

                  @endif
                  @if ($vista=='COMISION') 
                    <table class="min-w-full leading-normal">
                      <thead>
                        <tr>
                          <th
                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Productor
                          </th>
                          <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                          Comisión
                          </th>
                          <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Acción
                            </th>
                        
                      
                      </tr>
                      </thead>
                      <tbody>
                    
                          @foreach ($comisions as $comision)
                            <tr>
                              <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                <div class="flex items-center">
                                  <div class="flex-shrink-0 w-10 h-10 hidden">
                                    <img class="w-full h-full rounded-full"
                                                              src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2.2&w=160&h=160&q=80"
                                                              alt="" />
                                                      </div>
                                    <div class="ml-3">
                                      <p class="text-gray-900 whitespace-no-wrap">
                                        {{$comision->productor}}
                                      </p>
                                    </div>
                                  </div>
                              </td>
                              <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap"> {{$comision->comision*100}}%</p>
                              </td>
                          
                          

                              <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                <a href="{{route('comision.edit',['comision'=>$comision,'temporada'=>$temporada])}}">
                                  <span class="relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                      <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full"></span>
                                      <span class="relative">Editar</span>
                                  </span>
                                </a>
                              </td>
                            </tr>
                          @endforeach
                
                      </tbody>
                    </table>
                  @endif
                  @if ($vista=='FLETES')
              
                    <h1 class="text-xl font-semibold mb-4 ml-4">
                          Por favor selecione el archivo de "Flete a huerto" que desea importar
                    </h1>
                    
                  


                    <form action="{{route('temporada.importFlete')}}"
                        method="POST"
                        class="bg-white rounded p-8 shadow"
                        enctype="multipart/form-data">
                        
                        @csrf

                        <input type="hidden" name="temporada" value={{$temporada->id}}>

                        <x-validation-errors class="errors">

                        </x-validation-errors>

                        <input type="file" name="file" accept=".csv,.xlsx">

                        <x-button class="ml-4">
                            Importar
                        </x-button>
                    </form>

                    <table class="min-w-full leading-normal">
                      <thead>
                        <tr>
                          <th
                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Grupo
                          </th>
                          <th
                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                          Rut
                          </th>
                          <th
                          class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Productor
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                          TARIFA
                          </th>
                      
                        
                      
                      </tr>
                      </thead>
                      <tbody>
                    
                          @foreach ($fletes as $flete)
                            <tr>
                              <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                <div class="flex items-center">
                                  <div class="flex-shrink-0 w-10 h-10 hidden">
                                    <img class="w-full h-full rounded-full"
                                                              src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2.2&w=160&h=160&q=80"
                                                              alt="" />
                                                      </div>
                                    <div class="ml-3">
                                      <p class="text-gray-900 whitespace-no-wrap">
                                        {{$flete->grupo}}
                                      </p>
                                    </div>
                                  </div>
                              </td>
                              <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap"> {{$flete->rut}}</p>
                              </td>
                              <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap"> {{$flete->productor}}</p>
                              </td>
                              <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap"> {{$flete->tarifa}}</p>
                              </td>
                          
                          

                              <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                <a href="{{route('flete.edit',['flete'=>$flete,'temporada'=>$temporada])}}">
                                  <span class="relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                                        <span aria-hidden
                                                            class="absolute inset-0 bg-gray-200 opacity-50 rounded-full"></span>
                                  <span class="relative">Editar</span>
                                </a>
                                <span wire:click="flete_destroy({{$flete->id}})" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-red-900 leading-tight">
                                  <span aria-hidden class="absolute inset-0 bg-red-200 opacity-50 rounded-full"></span>
                                  <span class="relative">Eliminar</span>
                              </span>
                                </span>
                              </td>
                            </tr>
                          @endforeach
                
                      </tbody>
                    </table>

                  @endif
                  
                  @if ($vista=='MASAS')

                    
                  
                    <div class="flex justify-start">
                      <div class="">
                        <h1 class="text-xl font-semibold mb-4 ml-4">
                          Por favor selecione el archivo de "Balance de masas" que desea importar. {{$masastotal->count()}}
                        </h1>
                        @if ($masastotal->count()>0)
                          <h1 class="text-xl font-semibold mb-4 ml-4">
                            Fecha de importación: {{$masastotal->first()->created_at}}
                          </h1>
                        @endif
                        
                            <form action="{{route('temporada.importBalance')}}"
                                method="POST"
                                class="bg-white rounded p-8 shadow"
                                enctype="multipart/form-data">
                                
                                @csrf

                                <input type="hidden" name="temporada" value={{$temporada->id}}>

                                <x-validation-errors class="errors">

                                </x-validation-errors>

                                <input type="file" name="file" accept=".csv,.xlsx">

                                <x-button class="ml-4">
                                    Importar
                                </x-button>
                            </form>

                      </div>
                    </div>

                      <table class="min-w-full leading-normal">
                        <thead>
                          <tr>
                            @php
                                  
                                  $columnas = [
                                    'proceso',
                                    'planta',
                                    'fecha',
                                    'rut',
                                    'csg',
                                    'productor_recep',
                                    'variedad',
                                    'cod_embalaje',
                                    'descripcion',
                                    'envases',
                                    'color',
                                    'calibre',
                                    'calibre_real',
                                    'cantidad',
                                    'peso_prorrateado',
                                    'peso_caja',
                                    'tipo',
                                    'criterio',
                                    'color_final',
                                    'exportadora',
                                    'norma',
                                    'semana',
                                    'costo',
                                    'margen',
                                    'precio_fob',
                                ];


                              
                              foreach ($columnas as $columna) {
                                  echo '<th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase whitespace-no-wrap">';
                                  echo ucfirst(str_replace('_', ' ', $columna));
                                  echo '</th>';
                              }
                              
                            @endphp
                          </tr>
                        </thead>
                        <tbody>
                      
                            @foreach ($masasbalances as $masa)
                              <tr>
                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                  <p class="text-gray-900 whitespace-nowrap">{{ $masa->proceso }}</p>
                                </td>
                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-nowrap">{{ $masa->planta }}</p>
                                </td>
                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-nowrap">{{ $masa->fecha }}</p>
                                </td>
                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-nowrap">{{ $masa->rut }}</p>
                                </td>
                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                  <p class="text-gray-900 whitespace-nowrap">{{ $masa->csg }}</p>
                              </td>
                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm whitespace-no-wrap">
                                    <p class="text-gray-900 whitespace-nowrap">{{ $masa->productor_recep }}</p>
                                </td>
                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-nowrap">{{ $masa->variedad }}</p>
                                </td>
                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-nowrap">{{ $masa->cod_embalaje }}</p>
                                </td>
                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-nowrap">{{ $masa->descripcion }}</p>
                                </td>
                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-nowrap">{{ $masa->envases }}</p>
                                </td>
                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-nowrap">{{ $masa->color }}</p>
                                </td>
                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-nowrap">{{ $masa->calibre }}</p>
                                </td>
                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-nowrap">{{ $masa->calibre_real }}</p>
                                </td>
                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-nowrap">{{ $masa->cantidad }}</p>
                                </td>
                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-nowrap">{{ $masa->peso_prorrateado }}</p>
                                </td>
                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-nowrap">{{ $masa->peso_caja }}</p>
                                </td>
                              
                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-nowrap">{{ $masa->tipo }}</p>
                                </td>
                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-nowrap">{{ $masa->criterio }}</p>
                                </td>
                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-nowrap">{{ $masa->color_final }}</p>
                                </td>
                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-nowrap">{{ $masa->exportadora }}</p>
                                </td>
                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-nowrap">{{ $masa->norma }}</p>
                                </td>
                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-nowrap">{{ $masa->semana }}</p>
                                </td>
                            
                              <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-nowrap">
                                      @if ($masa->costo>0)
                                          {{ $masa->costo }}
                                      @else
                                          {{ $masa->costo_nacional }}
                                      @endif  
                                    </p>
                                </td>
                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                  <p class="text-gray-900 whitespace-nowrap">{{ $masa->margen }}</p>
                                </td>
                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                  @if ($masaid==$masa->id)
                                      <input wire:model="preciomasa" class="w-32 shadow-sm  border-2 border-gray-300 bg-white h-10 px-2 rounded-lg focus:outline-none">
                                  @else
                                    <p class="text-gray-900 whitespace-no-wrap">
                                    @if ($masa->fob>0)
                                        {{ $masa->fob }}
                                    @else
                                        {{ $masa->fob_nacional }}
                                    @endif
                                    
                                    
                                    </p>
                                  @endif
                                </td>
                              
                            
                            

                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                  @if ($masaid==$masa->id)
                                    <span wire:click='save_masaid()' class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                      <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                      <span class="relative">Guardar</span>
                                    </span>
                                  @else
                                    <span wire:click='set_masaid({{$masa->id}})' class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                      <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full"></span>
                                      <span class="relative">Editar</span>
                                    </span>
                                  @endif
                                

                                </td>
                              </tr>
                            @endforeach
                  
                        </tbody>
                      </table>

                  @endif

                  @if ($vista=='ANTICIPOS')
                      <div>
                          <h1 class="text-xl font-semibold mb-4">
                              Por favor selecione el archivo de "Anticipos" que desea importar
                          </h1>
                          <div class="">
                              <form action="{{route('temporada.importAnticipo')}}"
                                  method="POST"
                                  class="bg-white rounded p-8 shadow"
                                  enctype="multipart/form-data">
                                  
                                  @csrf

                                  <input type="hidden" name="temporada" value={{$temporada->id}}>

                                  <x-validation-errors class="errors">

                                  </x-validation-errors>

                                  <input type="file" name="file" accept=".csv,.xlsx">

                                  <x-button class="ml-4">
                                      Importar
                                  </x-button>
                              </form>

                          </div>
                      </div>
                      <table class="min-w-full leading-normal">
                        <thead>
                            <tr>
                                <th
                                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Productor
                                </th>
                                <th
                                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Cantidad USD
                                </th>
                                <th
                                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    USD
                                </th>
                                <th
                                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Tipo de Cambio
                                </th>
                                <th
                                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Total
                                </th>
                                <th
                                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Fecha
                                </th>
                                <th
                                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Orden
                                </th>
                                <th
                                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Moneda
                                </th>
                                <th
                                  class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                  Detalle
                              </th>
                              <th  class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Prorrateado
                            </th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Acción
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($anticipos as $anticipo)
                            <tr>
                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">
                                        {{$anticipo->productor}}
                                    </p>
                                </td>
                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">
                                        {{number_format($anticipo->cantidad_usd,2,',','.')}}
                                    </p>
                                </td>
                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">
                                        {{number_format(floatval($anticipo->usd),2,',','.')}}
                                    </p>
                                </td>
                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">
                                        {{number_format($anticipo->tipo_cambio,2,',','.')}}
                                    </p>
                                </td>
                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">
                                        {{number_format($anticipo->total,0,',','.')}}
                                    </p>
                                </td>
                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">
                                        {{date('d/m/Y', strtotime($anticipo->fecha))}}
                                    </p>
                                </td>
                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">
                                        {{$anticipo->orden}}
                                    </p>
                                </td>
                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">
                                        {{$anticipo->moneda}}
                                    </p>
                                </td>
                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                  <p class="text-gray-900 whitespace-no-wrap">
                                      {{$anticipo->detalle}}
                                  </p>
                              </td>
                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">
                                      @if ($anticipo->prorrateado==True)
                                          Prorrateado
                                      @else
                                          Sin Prorratear
                                      @endif
                                    </p>
                                </td>
                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                    <a href="">
                                        <span class="relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                            <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full"></span>
                                            <span class="relative">Editar</span>
                                        </span>
                                    </a>
                                    <span wire:click="anticipo_destroy({{$anticipo->id}})"
                                        class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-red-900 leading-tight">
                                        <span aria-hidden class="absolute inset-0 bg-red-200 opacity-50 rounded-full"></span>
                                        <span class="relative">Eliminar</span>
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                  @endif

                  @if ($vista=='FOB')

                    <div class="flex justify-center">
                        <div>
                          <h1 class="text-xl font-semibold mb-4">
                              Por favor selecione el archivo de "FOB" que desea importar
                          </h1>
                          <div class="">
                              <form action="{{route('temporada.importFob')}}"
                                  method="POST"
                                  class="bg-white rounded p-8 shadow"
                                  enctype="multipart/form-data">
                                  
                                  @csrf

                                  <input type="hidden" name="temporada" value={{$temporada->id}}>

                                  <x-validation-errors class="errors">

                                  </x-validation-errors>

                                  <input type="file" name="file" accept=".csv,.xlsx">

                                  <x-button class="ml-4">
                                      Importar
                                  </x-button>
                              </form>

                          </div>
                        </div>
                    </div>

                    <table class="min-w-full leading-normal">
                        <thead>
                          <tr>
                            <th
                              class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                              n_variedad
                            </th>
                            <th
                              class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Semana
                            </th>
                            <th
                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                          Etiqueta
                          </th>
                          <th
                          class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Calibre
                        </th>
                        <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                      Color
                      </th>
                          <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Categoria
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                              FOB
                              </th>
                        
                          
                        
                        </tr>
                        </thead>
                        <tbody>
                      
                            @foreach ($fobs as $fob)
                              <tr>
                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                  <div class="flex items-center">
                                  
                                      <div class="ml-3">
                                        <p class="text-gray-900 whitespace-no-wrap">
                                          {{$fob->n_variedad}}
                                        </p>
                                      </div>
                                    </div>
                                </td>
                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                  <p class="text-gray-900 whitespace-no-wrap"> {{$fob->semana}}</p>
                                </td>
                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                  <p class="text-gray-900 whitespace-no-wrap"> {{$fob->etiqueta}}</p>
                                </td>
                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                  <p class="text-gray-900 whitespace-no-wrap"> {{$fob->n_calibre}}</p>
                                </td>
                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                  <p class="text-gray-900 whitespace-no-wrap"> {{$fob->color}}</p>
                                </td>
                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                  <p class="text-gray-900 whitespace-no-wrap"> {{$fob->categoria}}</p>
                                </td>
                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                  @if ($fobid==$fob->id)
                                      <input wire:model="preciofob" class="w-32 shadow-sm  border-2 border-gray-300 bg-white h-10 px-2 rounded-lg focus:outline-none">
                                  @else
                                    <p class="text-gray-900 whitespace-no-wrap"> {{$fob->fob_kilo_salida}}</p>
                                  @endif
                                </td>
                            
                            

                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                  @if ($fobid==$fob->id)
                                    <span wire:click='save_fobid()' class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                      <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                      <span class="relative">Guardar</span>
                                    </span>
                                  @else
                                    <span wire:click='set_fobid({{$fob->id}})' class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                      <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full"></span>
                                      <span class="relative">Editar</span>
                                    </span>
                                  @endif
                                  
                                  <span  class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-red-900 leading-tight">
                                    <span aria-hidden class="absolute inset-0 bg-red-200 opacity-50 rounded-full"></span>
                                    <span class="relative">Eliminar</span>
                                </span>
                                  </span>
                                </td>
                              </tr>
                            @endforeach
                  
                        </tbody>
                    </table>
                  @endif

                  @if ($vista=='FOBNACIONAL')

                    <div class="flex justify-center">
                        <div>
                          <h1 class="text-xl font-semibold mb-4">
                              Por favor selecione el archivo de "FOB Nacional" que desea importar
                          </h1>
                          <div class="">
                              <form action="{{route('temporada.importFobnacional')}}"
                                  method="POST"
                                  class="bg-white rounded p-8 shadow"
                                  enctype="multipart/form-data">
                                  
                                  @csrf

                                  <input type="hidden" name="temporada" value={{$temporada->id}}>

                                  <x-validation-errors class="errors">

                                  </x-validation-errors>

                                  <input type="file" name="file" accept=".csv,.xlsx">

                                  <x-button class="ml-4">
                                      Importar
                                  </x-button>
                              </form>

                          </div>
                        </div>
                    </div>

                    <table class="min-w-full leading-normal">
                        <thead>
                          <tr>
                            <th
                              class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                              n_variedad
                            </th>
                            <th
                              class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Semana
                            </th>
                            <th
                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                          Etiqueta
                          </th>
                          <th
                          class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Calibre
                        </th>
                        <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                      Color
                      </th>
                          <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Categoria
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                              FOB
                              </th>
                        
                          
                        
                        </tr>
                        </thead>
                        <tbody>
                      
                            @foreach ($fobsnacional as $fob)
                              <tr>
                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                  <div class="flex items-center">
                                  
                                      <div class="ml-3">
                                        <p class="text-gray-900 whitespace-no-wrap">
                                          {{$fob->n_variedad}}
                                        </p>
                                      </div>
                                    </div>
                                </td>
                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                  <p class="text-gray-900 whitespace-no-wrap"> {{$fob->semana}}</p>
                                </td>
                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                  <p class="text-gray-900 whitespace-no-wrap"> {{$fob->etiqueta}}</p>
                                </td>
                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                  <p class="text-gray-900 whitespace-no-wrap"> {{$fob->n_calibre}}</p>
                                </td>
                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                  <p class="text-gray-900 whitespace-no-wrap"> {{$fob->color}}</p>
                                </td>
                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                  <p class="text-gray-900 whitespace-no-wrap"> {{$fob->categoria}}</p>
                                </td>
                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                  <p class="text-gray-900 whitespace-no-wrap"> {{$fob->fob_kilo_salida}}</p>
                                </td>
                            
                            

                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                  <a href="">
                                    <span class="relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                                          <span aria-hidden
                                                              class="absolute inset-0 bg-gray-200 opacity-50 rounded-full"></span>
                                    <span class="relative">Editar</span>
                                  </a>
                                  <span  class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-red-900 leading-tight">
                                    <span aria-hidden class="absolute inset-0 bg-red-200 opacity-50 rounded-full"></span>
                                    <span class="relative">Eliminar</span>
                                </span>
                                  </span>
                                </td>
                              </tr>
                            @endforeach
                  
                        </tbody>
                    </table>
                  @endif

                  @if ($vista=='X MERCADO') 
                    <div class="overflow-x-auto">
                      <table class="min-w-full border border-collapse border-gray-300">
                        <thead>
                          <tr class="bg-orange-600 text-white text-sm font-medium">
                            <th class="border border-gray-300 px-4 py-2">Nave</th>
                            <th class="border border-gray-300 px-4 py-2">Variedad_Rot</th>
                            <th class="border border-gray-300 px-4 py-2">Calibre</th>
                            <th class="border border-gray-300 px-4 py-2">GZ</th>
                            <th class="border border-gray-300 px-4 py-2">SH</th>
                            <th class="border border-gray-300 px-4 py-2">SY</th>
                            <th class="border border-gray-300 px-4 py-2">SY/SH</th>
                            <th class="border border-gray-300 px-4 py-2">ZZ</th>
                            <th class="border border-gray-300 px-4 py-2">DL</th>
                            <th class="border border-gray-300 px-4 py-2">DD</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($pormercados as $item)
                            <tr class="h-10">
                                <td class="border border-gray-300 px-4 py-2 whitespace-nowrap">{{ $item->Nave }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $item->Variedad_Real }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $item->Calibre }}</td>
                                <td class="border border-gray-300 px-4 py-2">
                                  @if ($item->GZ>0)
                                    USD {{ number_format($item->GZ,2,',','.') }}      
                                  @else
                                      -
                                  @endif
                                </td>
                                <td class="border border-gray-300 px-4 py-2">
                                  @if ($item->SH>0)
                                    USD {{ number_format($item->SH,2,',','.') }}      
                                  @else
                                      -
                                  @endif
                                </td>
                                <td class="border border-gray-300 px-4 py-2">
                                  @if ($item->SY>0)
                                    USD {{ number_format($item->SY,2,',','.') }}      
                                  @else
                                      -
                                  @endif
                                </td>
                                <td class="border border-gray-300 px-4 py-2">
                                  @if ($item->SY_SH>0)
                                    USD   {{ number_format($item->SY_SH,2,',','.')    }}  
                                  @else
                                      -
                                  @endif
                                </td>
                                <td class="border border-gray-300 px-4 py-2">
                                  @if ($item->ZZ>0)
                                    USD {{ number_format($item->ZZ,2,',','.') }}      
                                  @else
                                      -
                                  @endif
                                </td>
                                <td class="border border-gray-300 px-4 py-2">
                                  @if ($item->DL>0)
                                    USD {{ number_format($item->DL,2,',','.') }}      
                                  @else
                                      -
                                  @endif
                                </td>
                                <td class="border border-gray-300 px-4 py-2">
                                  @if ($item->DD>0)
                                    USD {{ number_format($item->DD,2,',','.') }}      
                                  @else
                                      -
                                  @endif
                                </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  @endif
                  @if ($vista=='OTROSGASTOS') 
                      <h1 class="text-xl text-center font-semibold mb-4 ">
                        Por favor selecione el archivo de "Gastos" que desea importar
                    </h1>
                    <div class="flex justify-center">
                        
                        <form action="{{route('temporada.importGasto')}}"
                            method="POST"
                            class="bg-white rounded p-8 shadow"
                            enctype="multipart/form-data">
                            
                            @csrf

                            <input type="hidden" name="temporada" value={{$temporada->id}}>

                            <x-validation-errors class="errors">

                            </x-validation-errors>

                            <input type="file" name="file" accept=".csv,.xlsx">

                            <x-button class="ml-4">
                                Importar
                            </x-button>
                        </form>
                    </div>

                    @if ($detalles->count()>0)
                      <table class="min-w-full leading-normal">
                          <thead>
                            <tr>
                              <th
                                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Grupo
                              </th>
                              <th
                                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                              Rut
                              </th>
                              <th
                              class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Productor
                            </th>
                            <th
                              class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Item
                            </th>
                            <th
                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                          Fecha
                          </th>
                          <th
                          class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Cantidad
                        </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                              Acción
                              </th>
                          
                            
                          
                          </tr>
                          </thead>
                          <tbody>
                        
                              @foreach ($detalles as $detalle)
                                <tr>
                                  <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                    <div class="flex items-center">
                                    
                                        <div class="ml-3">
                                          <p class="text-gray-900 whitespace-no-wrap">
                                            {{$detalle->grupo}}
                                          </p>
                                        </div>
                                      </div>
                                  </td>
                                  <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap"> {{$detalle->rut}}</p>
                                  </td>
                                  <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap"> {{$detalle->n_productor}}</p>
                                  </td>
                                  <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap"> {{$detalle->item}}</p>
                                  </td>
                                  <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap"> {{date('d/m/Y', strtotime($detalle->fecha))}}</p>
                                  </td>
                                  <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap"> {{$detalle->cantidad}}</p>
                                  </td>
                              
                              

                                  <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                    <a href="">
                                      <span class="relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                                            <span aria-hidden
                                                                class="absolute inset-0 bg-gray-200 opacity-50 rounded-full"></span>
                                      <span class="relative">Editar</span>
                                    </a>
                                    <span wire:click="" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-red-900 leading-tight">
                                      <span aria-hidden class="absolute inset-0 bg-red-200 opacity-50 rounded-full"></span>
                                      <span class="relative">Eliminar</span>
                                  </span>
                                    </span>
                                  </td>
                                </tr>
                              @endforeach
                    
                          </tbody>
                      </table>
                    @endif
                  @endif
                  @if($vista=="FINANZAS")
                          
                        <div class="container mx-auto p-4">
                          <h1 class="text-xl font-bold mb-4">Subir Facturación</h1>
                          @if (session('success'))
                              <div class="bg-green-100 text-green-700 p-2 rounded mb-4">
                                  {{ session('success') }}
                              </div>
                          @endif
                  
                          <form action="{{route('temporada.datauploadfacturacion')}}"
                              method="POST"
                              class="bg-white rounded px-8 shadow my-4"
                              enctype="multipart/form-data">
                          
                              @csrf

                              <input type="hidden" name="temporada" value={{$temporada->id}}>

                              <x-validation-errors class="errors">

                              </x-validation-errors>

                              <input type="file" name="file" accept=".csv,.xlsx">

                              <x-button class="">
                                  Importar
                              </x-button>
                          </form>
                        </div>

                        <div class="container mx-auto my-4">
                          <div class="overflow-x-auto">
                            <table class="table-auto w-full border-collapse border border-gray-300 text-sm">
                              <thead class="bg-gray-100">
                                  <tr>
                                    <th class="border border-gray-300 px-4 py-2 whitespace-nowrap sticky-column">Productor</th>
                                    <th class="border border-gray-300 px-4 py-2 whitespace-nowrap sticky-column">Tipo Docto</th>
                                    <th class="border border-gray-300 px-4 py-2 whitespace-nowrap">Total Monto Neto</th>
                                    <th class="border border-gray-300 px-4 py-2 whitespace-nowrap">Total IVA</th>
                                    <th class="border border-gray-300 px-4 py-2 whitespace-nowrap">Total</th>
                                    <th class="border border-gray-300 px-4 py-2 whitespace-nowrap">Total Neto</th>
                                    <th class="border border-gray-300 px-4 py-2 whitespace-nowrap">Total IVA2</th>
                                    <th class="border border-gray-300 px-4 py-2 whitespace-nowrap">Total2</th>
                                    <th class="border border-gray-300 px-4 py-2 whitespace-nowrap">Total Saldo</th>
                                    
                                    <th class="border border-gray-300 px-4 py-2 whitespace-nowrap">Promedio T/C</th>

                                    <th class="border border-gray-300 px-4 py-2 whitespace-nowrap">Total Cantidad</th>
                                    <th class="border border-gray-300 px-4 py-2 whitespace-nowrap">Total USD/KG</th>
                                    <th class="border border-gray-300 px-4 py-2 whitespace-nowrap">Total Dólares</th>
                                    <th class="border border-gray-300 px-4 py-2 whitespace-nowrap">Total Valor</th>
                                      <th class="border border-gray-300 px-4 py-2 whitespace-nowrap">Total Liquidado</th>
                                     
                                      <th class="border border-gray-300 px-4 py-2 whitespace-nowrap">Anticipo Total</th>
                                      <th class="border border-gray-300 px-4 py-2 whitespace-nowrap">A Pagar Total</th>
                                      <th class="border border-gray-300 px-4 py-2 whitespace-nowrap">ND Total</th>
                                      <th class="border border-gray-300 px-4 py-2 whitespace-nowrap">Dif. Tipo de Cambio</th>
                                  </tr>
                              </thead>
                              <tbody>
                                @php
                                //PRECIO ORIGINAL
                                $ventatotalaliquidar=0;
                                //PRECIO MODIFICADO
                                $venta2totalaliquidar=0;
                                //COMERCIAL
                                $venta3totalaliquidar=0;
                                $margentotalaliquidar=0;
                                $pesototalaliquidar=0;
                                $costototalaliquidar=0;
                                $costo2totalaliquidar=0;
                                $gastototalaliquidar=0;
                                $anticipototalaliquidar=0;
                                $cont=1;
                                
                                $totalaliquidar=0;
                                $control=true;

                            @endphp

                                  @foreach ($facturas as $factura)
                                  <tr>
                                    
                                    <td class="border border-gray-300 px-4 py-2 whitespace-nowrap sticky-column">
                                      @php
                                          $razonExiste = $razonsall->where('name', $factura->productor)->first();
                                      @endphp

                                      @if ($razonExiste)
                                          <!-- Mostrar contenido si el registro existe -->
                                          <a href="{{ route('razonsocial.show', ['razonsocial' => $razonExiste, 'temporada' => $temporada]) }}" target="_blank">
                                            <div class="text-sm text-gray-900 font-bold">{{$factura->productor}}</div>  
                                          </a>
                                      @else
                                          <!-- Mostrar contenido si el registro no existe -->
                                          <div class="text-sm text-red-900">{{$factura->productor}}</div>  
                                      @endif

                                    </td>
                                    <td class="border border-gray-300 px-4 py-2 whitespace-nowrap sticky-column">{{ $factura->tipo_docto }}</td>
                                    <td class="border border-gray-300 px-4 py-2 whitespace-nowrap">{{ $factura->total_monto_neto }}</td>
                                    <td class="border border-gray-300 px-4 py-2 whitespace-nowrap">{{ $factura->total_iva }}</td>
                                    <td class="border border-gray-300 px-4 py-2 whitespace-nowrap">{{ $factura->total_total }}</td>
                                    <td class="border border-gray-300 px-4 py-2 whitespace-nowrap">{{ $factura->total_neto }}</td>
                                    <td class="border border-gray-300 px-4 py-2 whitespace-nowrap">{{ $factura->total_iva2 }}</td>
                                    <td class="border border-gray-300 px-4 py-2 whitespace-nowrap">{{ $factura->total_total2 }}</td>
                                    <td class="border border-gray-300 px-4 py-2 whitespace-nowrap">{{ $factura->total_saldo }}</td>
                                    
                                    <td class="border border-gray-300 px-4 py-2 whitespace-nowrap">{{ $factura->promedio_tc }}</td>
                                    <td class="border border-gray-300 px-4 py-2 whitespace-nowrap">{{ $factura->total_cantidad }}</td>
                                    <td class="border border-gray-300 px-4 py-2 whitespace-nowrap">{{ $factura->total_usd_kg }}</td>
                                    <td class="border border-gray-300 px-4 py-2 whitespace-nowrap">{{ $factura->total_dolares }}</td>
                                    <td class="border border-gray-300 px-4 py-2 whitespace-nowrap">{{ $factura->total_valor }}</td>
                                   
                                    @php
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

                                     
                                      
                                    

                                  @endphp
                           
                                   
                                        @php
                                            $razonExiste = $razonsall->where('name', $factura->productor)->first();
                                            if ($razonExiste) {
                                              $name=$razonExiste->name;
                                            }else {
                                              $name="null";
                                            }
                                           
                                        @endphp


                                       
                                      @foreach ($masastotal->filter(function($item) use ($name) {
                                                  return trim($item->PRODUCTOR_RECEP_FACTURACION) === trim($name);
                                                }) as $item)
                                              @php
                                                  $peso = floatval($item->PESO_PRORRATEADO);
                                                  $pesototalaliquidar += floatval($item->PESO_PRORRATEADO);
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
                                                  
                                                    $ventatotalaliquidar+= floatval($tarifaAplicada * $peso);
                                                    $venta2totalaliquidar+= floatval($tarifafinal3 * $peso);
                                                  }

                                                  if ($item->CRITERIO=="COMERCIAL") {
                                                    $venta3srazon += floatval($tarifaAplicada * $peso);
                                                    $venta3totalaliquidar += floatval($tarifaAplicada * $peso);
                                                  }
                                                  

                                                  if ($item->CRITERIO=="EXPORTACIÓN") {
                                                    $margenrazon += floatval($tarifafinal3 * $peso*0.08);
                                                    $margentotalaliquidar += floatval($tarifafinal3 * $peso*0.08);
                                                  }
                                                }

                                                if ($item->CRITERIO=="COMERCIAL") {
                                                  $costo2srazon += floatval($item->costo_proceso);
                                                  $costo2totalaliquidar += floatval($item->costo_proceso);
                                                }

                                                $costosrazon += floatval($item->costo_proceso+$item->costo_materiales+$item->otros_costos);
                                                $costototalaliquidar += floatval($item->costo_proceso+$item->costo_materiales+$item->otros_costos);

                                                $costo2srazon += floatval($item->costo);
                                                $costo2totalaliquidar += floatval($item->costo);
                                                
                                                $kgrazon += floatval($item->PESO_PRORRATEADO);
                                                $gastosrazon += floatval($item->gastos);
                                                $gastototalaliquidar += floatval($item->gastos);
                                              
                                                $anticiposrazon += floatval($item->anticipos);
                                                $anticipototalaliquidar += floatval($item->anticipos);

                                               
                                              @endphp
                                        
                                      @endforeach
                                      @php
                                          $aliquidar=$venta2srazon+$venta3srazon-$costo2srazon-$margenrazon-$gastosrazon;
                                           $totalaliquidar+=$aliquidar;
                                      @endphp

                                      <td class="border border-gray-300 px-4 py-2 whitespace-nowrap">
                                        @if ($informedit==$name)
                                            <input wire:model.live="total_liquidado" type="text">
                                        @else

                                          @if ($razonExiste)
                                              @if($razonExiste->informes->where('temporada_id',$temporada->id)->reverse()->first()->total_liquidado!=($venta2srazon+$venta3srazon-$costo2srazon-$margenrazon-$gastosrazon))
                                               <p class="font-bold text-red-500">{{$razonExiste->informes->where('temporada_id',$temporada->id)->reverse()->first()->total_liquidado}} </p> 
                                              @endif
                                          @else
                                              
                                          @endif

                                          {{ number_format($venta2srazon+$venta3srazon-$costo2srazon-$margenrazon-$gastosrazon, 2) }}

                                        @endif
                                      
                                      </td>
                                      
                                      <td class="border border-gray-300 px-4 py-2 whitespace-nowrap">{{ number_format($anticiposrazon, 2) }}</td>
                                      <td class="border border-gray-300 px-4 py-2 whitespace-nowrap">{{ number_format($aliquidar, 2) }}</td>
                                      <td class="border border-gray-300 px-4 py-2 whitespace-nowrap">{{ number_format($venta2srazon+$venta3srazon-$costo2srazon-$margenrazon-$gastosrazon-$factura->total_dolares, 2) }}</td>
                                      <td class="border border-gray-300 px-4 py-2 whitespace-nowrap">
                                        @if ($informedit==$name)
                                            <input wire:model.live="difcambio" type="text">
                                        @else

                                          @if ($razonExiste)
                                              @if($razonExiste->informes->where('temporada_id',$temporada->id)->first())
                                               <p class="font-bold text-red-500">{{$razonExiste->informes->where('temporada_id',$temporada->id)->reverse()->first()->diferencia_tipodecambio}} </p> 
                                              @endif
                                          @else
                                              
                                          @endif


                                        @endif
                                      
                                      </td>

                                      @if ($informedit==$name)
                                        <td  class="border border-gray-300 px-4 py-2 whitespace-nowrap">
                                          <button wire:click.prevent="save_informeid('{{$name}}')" class="py-1 bg-gray-800 text-white rounded-full text-center px-2">
                                          Guardar
                                          </button>
                                        </td>
                                      @else
                                        <td class="border border-gray-300 px-4 py-2 whitespace-nowrap">
                                          <button wire:click="set_informeid('{{$name}}')" class="py-1 bg-gray-800 text-white rounded-full text-center px-2">
                                          Editar
                                          </button>
                                        </td>
                                      @endif
                                    
                                  </tr>
                                  @endforeach
                              </tbody>
                          </table>
                          
                          </div>
                      </div>
                                            

                  @endif
                  @if ($vista=="PRODUCTOR")
                      
                  @endif
                </div>
              </div>


            </main>

          </div>
      </div>
      
    </section>
    <div class="flex justify-center hidden">
        <div class="inline-flex items-center rounded-md shadow-sm gap-x-2">
            <button wire:click="set_view('resumes')" class="text-slate-800 hover:text-blue-600 text-sm bg-white hover:bg-slate-100 border-y border-slate-200 font-medium px-4 py-2 inline-flex space-x-1 items-center">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>                      
                </span>
                <span>RESUMEN</span>
            </button>

              <button wire:click="set_view('PACKING')" class="text-slate-800 hover:text-blue-600 text-sm bg-white hover:bg-slate-100 border border-slate-200 rounded-l-lg font-medium px-4 py-2 inline-flex space-x-1 items-center">
                  <span><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                  </svg>
                  </span>
                  <span>COSTOS <br>PACKING</span>
              </button>
          
              <a href="{{route('temporadas.show',$temporada)}}" wire:navigate>
              <button class="text-slate-800 hover:text-blue-600 text-sm bg-white hover:bg-slate-100 border border-slate-200 rounded-l-lg font-medium px-4 py-2 inline-flex space-x-1 items-center">
                  <span><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                  </svg>
                  </span>
                  <span>MI</span>
              </button>
              </a>
              <a href="{{route('temporadas.show',$temporada)}}" wire:navigate>
              <button class="text-slate-800 hover:text-blue-600 text-sm bg-white hover:bg-slate-100 border border-slate-200 rounded-l-lg font-medium px-4 py-2 inline-flex space-x-1 items-center">
                  <span><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                  </svg>
                  </span>
                  <span>DETALLE</span>
              </button>
              </a>
              <a href="{{route('temporadas.show',$temporada)}}" wire:navigate>
              <button class="text-slate-800 hover:text-blue-600 text-sm bg-white hover:bg-slate-100 border border-slate-200 rounded-l-lg font-medium px-4 py-2 inline-flex space-x-1 items-center">
                  <span><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                  </svg>
                  </span>
                  <span>TARIFAS</span>
              </button>
              </a>
              <a href="{{route('temporadas.show',$temporada)}}" wire:navigate>
              <button class="text-slate-800 hover:text-blue-600 text-sm bg-white hover:bg-slate-100 border border-slate-200 rounded-l-lg font-medium px-4 py-2 inline-flex space-x-1 items-center">
                  <span><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                  </svg>
                  </span>
                  <span>INGRESOS</span>
              </button>
              </a>
              <a href="{{route('temporadas.show',$temporada)}}" wire:navigate>
              <button class="text-slate-800 hover:text-blue-600 text-sm bg-white hover:bg-slate-100 border border-slate-200 rounded-r-lg font-medium px-4 py-2 inline-flex space-x-1 items-center">
                  <span>
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                  </svg>
                  </span>
                  <span>FINANZAS</span>
              </button>
              </a>
        </div>
    </div>

    @php
         $series=[];
         $calibres=[];
    @endphp

        @if ($vista=="grafico")
            
          <div class="flex flex-col mb-2">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
              <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                  <table class="min-w-full divide-y divide-gray-200">
                      <thead class="bg-yellow-400">
                        <tr>
                          <th class="px-6 py-0 text-center text-xs font-bold text-gray-900">
                           
                          </th>
                          @foreach ($unique_calibres as $calibre)
                            <th class="px-6 py-0 text-center text-xs font-bold text-gray-900">
                              {{$calibre}}
                            </th>
                          @endforeach
                        </tr>
                      </thead>
                      <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($unique_semanas as $semana)
                            @php
                                $array=[];
                                $sumas = [
                                    '4J' => ['suma' => 0, 'peso' => 0],
                                    '3J' => ['suma' => 0, 'peso' => 0],
                                    '2J' => ['suma' => 0, 'peso' => 0],
                                    'J' => ['suma' => 0, 'peso' => 0],
                                    'XL' => ['suma' => 0, 'peso' => 0],
                                    'L' => ['suma' => 0, 'peso' => 0],
                                ];


                            @endphp
                            @if ($semana)
                              <tr>
                                <td class="px-6 py-0 whitespace-nowrap">
                                  <div class="text-sm text-gray-900">{{$semana}}</div>    
                                </td>
                                @foreach ($masastotal->where('SEMANA',$semana) as $item)
                                        @php
                                          if ($item->fob) {
                                            $tarifafinal=0;
                                            $tarifafinal2=0;
                                            if ($item->fob->tarifas->count()>0) {
                                                $tarifafinal=$item->fob->tarifas->reverse()->first()->tarifa;
                                                $tarifafinal2=$item->fob->tarifas->reverse()->first()->tarifa;
                                            }
                                            $tarifaAplicada = ($item->CRITERIO == "COMERCIAL") ? $tarifafinal2 : $tarifafinal;
                                            $peso = floatval($item->PESO_PRORRATEADO);

                                            switch ($item->CALIBRE_REAL) {
                                                case '4J':
                                                case '3J':
                                                case '2J':
                                                case 'J':
                                                case 'XL':
                                                case 'L':
                                                    $sumas[$item->CALIBRE_REAL]['suma'] += $tarifaAplicada * $peso;
                                                    $sumas[$item->CALIBRE_REAL]['peso'] += $peso;
                                                    break;
                                            }

                                          }
                                        @endphp
                                  
                                @endforeach
                                
                                @foreach ($unique_calibres as $calibre)
                                  @php
                                    $calibres[]=$calibre; 
                                  @endphp
                                 
                                    @php
                                        if ($sumas[$calibre]['peso'] >0) {
                                          $array[]=round($sumas[$calibre]['suma'] / $sumas[$calibre]['peso'], 2);
                                        } else {
                                          $array[]=null;
                                        }
                                        
                                        
                                    @endphp

                                  <td class="px-6 py-0 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                      @if ($sumas[$calibre]['peso'] >0) 
                                      
                                        {{number_format($sumas[$calibre]['suma']/$sumas[$calibre]['peso'],2)}}
                                      @else
                                          0
                                      @endif  
                                    </div>    
                                  </td>

                                @endforeach
                                
                              </tr>
                              @php
                                  $series[]=['name' =>$semana,
                                            'data'=> $array];
                              @endphp
                            @endif  
                            
                            
                        @endforeach
                       
                        
                      </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

        @endif
       

       <!-- Script para eliminar el mensaje después de 3 segundos -->
       <script>
        document.addEventListener('DOMContentLoaded', function () {
            setTimeout(() => {
                let statusMessages = document.querySelectorAll('span.text-green-600');
                statusMessages.forEach(msg => {
                    msg.style.display = 'none'; // Ocultar el mensaje después de 3 segundos
                });
            }, 2000);
        });
    </script>
  <script>
      var series = <?php echo json_encode($series) ?>;
      var calibres = <?php echo json_encode($calibres) ?>;

        Highcharts.chart('container', {
            title: {
                text: '',
                align: 'left'
            },
            subtitle: {
                text: '',
                align: 'left'
            },
            yAxis: {
                title: {
                    text: 'USD'
                }
            },
            xAxis: {
              categories: calibres
            },
            tooltip: {
                useHTML: true, // Permite usar HTML para formatear el tooltip
                formatter: function () {
                    return `
                        <b>Semana ${this.series.name}</b> <br>Calibre: <span style="color: ${this.series.color};">${this.x}</span><br> <!-- Nombre de la serie -->
                        <span style="font-weight: bold;">${this.y.toFixed(2)} USD</span>
                    `;
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle'
            },
            plotOptions: {
        series: {
            dataLabels: {
                enabled: true,
                useHTML: true, // Permite usar HTML en las etiquetas
                formatter: function () {
                    if (this.point.index === 0) {
                        // Mantener el valor en la posición estándar
                        const valueLabel = `<span style="color: black; font-size: 11px;">${this.y.toFixed(2)} USD</span>`;
                        // Botón independiente con color de fondo de la serie
                        const buttonLabel = `
                            <span style="
                                display: inline-block;
                                padding: 5px 10px;
                                background-color: ${this.series.color};
                                color: white;
                                border-radius: 5px;
                                font-weight: bold;
                                font-size: 12px;
                                position: absolute;
                                transform: translate(-40px, -5px);
                            ">
                                ${this.series.name}
                            </span>`;
                        return buttonLabel + valueLabel;
                    }
                    // Formato estándar para los demás puntos
                    return `<span style="color: black; font-size: 11px;">${this.y.toFixed(2)} USD</span>`;
                },
                style: {
                    fontWeight: 'bold',
                    color: 'black'
                },
                crop: false, // Evitar cortar etiquetas fuera del gráfico
                overflow: 'none' // Permitir que las etiquetas sobresalgan si es necesario
            }
        }
    },
            series: series,
            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        legend: {
                            layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
                        }
                    }
                }]
            }
        });
    
</script>

</div>