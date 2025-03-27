<div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div wire:loading wire:target="set_fobid">
                    
        <div class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-50 z-50">
            <div class="max-w-sm w-full sm:rounded-2xl bg-white border-2 border-gray-200 shadow-xl">
              <div class="w-full">
                <div class="px-6 my-6 mx-auto">
                  <div class="mb-8">
                    <div class="flex justify-between items-center">
                      <h1 class="text-2xl font-extrabold mr-4">Cargando...</h1>
                      <div><img class="h-10" src="{{asset('image/cargando.gif')}}" alt="Cargando..."></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
    </div>

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
    left: 100px; /* Ajusta el valor según el ancho de la columna anterior */
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
    
    @if ($detalle_liquidacions->count()>0)
                    <div class="py-8">
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-4">
                            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                                @if(session('info'))
                                    <div class="flex justify-center mt-12">
                                        <div class="justify-center" x-data="{notificacion: true}" x-show="notificacion">
                                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded justify-center w-full flex my-2 mx-2 items-center" role="alert">
                                        <strong class="font-bold mx-2 my-auto">Felicidades!</strong>
                                        <span class="flex">{{session('info')}}</span>
                                        <span class="mx-3 top-0 bottom-0 right-0">
                                        <svg x-on:click="notificacion=false" class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                                        </span>
                                        </div>
                                        </div>
                                    </div>
                                @endif
                            
                        
                                <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
                                    <div class="inline-block min-w-full rounded-lg overflow-hidden">
                                        @php
                                            $pesovariedad=0;
                                            $ventavariedad=0;

                                            $pesovariedad_prom=0;
                                            $ventavariedad_prom=0;

                                            $costo_procesos_prom=0;
                                            $costo_materiales_prom=0;
                                            $otros_costos_prom=0;

                                            $pesovariedad_ajust=0;
                                            $ventavariedad_ajust=0;

                                            $ventavariedad_ajust2=0;

                                            $costo_procesos_ajust=0;
                                            $costo_materiales_ajust=0;
                                            $otros_costos_ajust=0;

                                            $sumadiferenciaaumento=0;


                                        @endphp

                                        @foreach ($fobsall as $fob)
                                            @php
                                                $pesovariedad+=floatval($fob->cant_kg);
                                                $ventavariedad+=floatval($fob->suma_fob);
                                               
                                            @endphp
                                        @endforeach
                                         
                                        <div class="mb-4 flex">
                                            
                                            <div class="ml-4">
                                                Combinaciones:<br>
                                                <div class="flex">
                                                    <button class="focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 text-sm leading-none text-gray-600 py-3 px-5 bg-gray-500 rounded hover:bg-gray-600 focus:outline-none">

                                                        <h1 style="font-size: 1rem;white-space: nowrap;" class="text-center text-white font-bold inline w-full" >
                                                            {{number_format($fobsall->count(),0)}}
                                                            
                                                        </h1>
                                                    </button>
                                                
                                                
                                                </div>
                                                <div class="mt-2">
                                                    Categoria:<br>
                                                    <input checked type="checkbox" wire:model.live="filters.exp" id="exp" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                                    <label for="exp">Exportación</label>
                                                    </div>
                                                
                                                    <div>
                                                    <input checked type="checkbox" wire:model.live="filters.com" id="com" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                                    <label for="com">Comercial</label>
                                                    </div>
                                                    <div>
                                                </div>
                                            </div>
                                            
                                            <div class="ml-4">
                                                Variedades:<br>
                                                <select wire:model.live="filters.variedad" name="" id="" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-40">
                                                    <option value="">Todos</option>
                                                    @foreach ($unique_variedades as $item)
                                                    <option value="{{$item}}">{{$item}}</option>
                                                    @endforeach
                                                
                                                </select>
                                            
                                            </div>

                                            <div class="ml-4">
                                                Semana:<br>
                                                <select wire:model.live="filters.semana" name="" id="" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-40">
                                                <option value="">Todos</option>
                                                @foreach ($unique_semanas as $item)
                                                    <option value="{{$item}}">{{$item}}</option>
                                                @endforeach
                                                
                                                </select>
                                            </div>

                                            <div class="ml-4">
                                                Calibre:<br>
                                                    <select wire:model.live="filters.calibre" name="" id="" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-40">
                                                        <option value="">Todos</option>
                                                        @foreach ($unique_calibres2 as $item)
                                                                <option value="{{$item}}">{{$item}}</option>
                                                        @endforeach
                                                    </select>
                                            </div>
                                            <div class="ml-4">
                                                Generar Tabla de Costos:<br>
                                                    <button onclick="confirmCreateFOB()" class="ml-2 focus:ring-2 focus:ring-offset-2 focus:ring-green-300 text-sm leading-none text-green-600 py-3 px-5 bg-green-600 rounded hover:bg-green-500 focus:outline-none">
                                                        <h1 style="font-size: 1rem; white-space: nowrap;" class="text-center text-white font-bold inline w-full">
                                                            GENERAR
                                                        </h1>
                                                    </button>
                                                    <br>
                                                    <button onclick="confirmCreateComercial()" class="hidden ml-2 mt-2 focus:ring-2 focus:ring-offset-2 focus:ring-green-300 text-sm leading-none text-green-600 py-3 px-5 bg-green-600 rounded hover:bg-green-500 focus:outline-none">
                                                        <h1 style="font-size: 1rem; white-space: nowrap;" class="text-center text-white font-bold inline w-full">
                                                            GENERAR COMERCIAL
                                                        </h1>
                                                    </button>
                                                    @if ($fobs->count()>0)
                                                        <button  onclick="confirmDelete()" class="ml-2 focus:ring-2 focus:ring-offset-2 focus:ring-red-300 text-sm leading-none text-red-600 py-3 px-5 bg-red-600 rounded hover:bg-red-500 mt-2 focus:outline-none">
                                                            <h1 style="font-size: 1rem;white-space: nowrap;" class="text-center text-white font-bold inline w-full">
                                                                ELIMINAR
                                                            </h1>
                                                        </button>
                                                    @endif
                                                
                                                                                        
                                            </div>
                                            
                                            <div class="ml-4 hidden">
                                                Peso:<br>
                                                <div class="flex">
                                                    <button class="focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 text-sm leading-none text-gray-600 py-3 px-5 bg-gray-500 rounded hover:bg-gray-600 focus:outline-none">

                                                        <h1 style="font-size: 1rem;white-space: nowrap;" class="text-center text-white font-bold inline w-full" >
                                                            {{number_format($pesovariedad,1)}}
                                                            
                                                        </h1>
                                                    </button>
                                                
                                                
                                                </div>
                                            </div>

                                            <div class="ml-4 hidden">
                                                Venta:<br>
                                                <div class="flex">
                            
                                                
                                                    <button class="ml-2 focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 text-sm leading-none text-gray-600 py-3 px-5 bg-gray-500 rounded hover:bg-gray-600 focus:outline-none">

                                                        <h1 style="font-size: 1rem;white-space: nowrap;" class="text-center text-white font-bold inline w-full" >
                                                            {{number_format($ventavariedad,0)}}
                                                            
                                                        </h1>
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="ml-4 hidden">
                                                Norma:<br>
                                                <select wire:model.live="filters.calibre" name="" id="" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-40">
                                                <option value="">Todos</option>
                                                    @foreach ($unique_calibres2 as $item)
                                                        @if ($unique_calibres->contains($item))
                                                            <option value="{{$item}}">{{$item}}</option>
                                                        @endif
                                                    @endforeach
                                                
                                                </select>
                                            </div>

                                            @if ($fobs->count()>0)
                                                
                                            <div class="ml-auto">
                                                Precio:<br>
                                                <div class="flex">
                                                    @if ($temporada->precios->count()==0)
                                                    @endif
                                                    <button onclick="confirmAddPrecio()" class="focus:ring-2 focus:ring-offset-2 focus:ring-green-300 text-sm leading-none text-green-600 py-3 px-5 bg-green-600 rounded hover:bg-green-500 focus:outline-none">
                                                        <h1 style="font-size: 1rem;white-space: nowrap;" class="text-center text-white font-bold inline w-full">
                                                            Asignar a Costo
                                                        </h1>
                                                    </button>
                                                    
                                                    
                                                </div>

                                                <div class="flex">
                                                
                                                    <button wire:click="excel_export" class="mt-2 focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 text-sm leading-none text-gray-600 py-3 px-5 bg-gray-600 rounded hover:bg-gray-500 focus:outline-none">

                                                        <h1 style="font-size: 1rem;white-space: nowrap;" class="text-center text-white font-bold inline w-full" >
                                                        Exportar en Excel
                                                            
                                                        </h1>
                                                    </button>
                                                </div>
                                            </div>
                                            @endif
                                            

                                        
                                        
                                            
                                        
                            
                                        
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                     
                    <div class="overflow-x-auto max-h-[580px]">
                        <table class="min-w-full leading-normal">
                            <thead class="sticky top-0 bg-white shadow-md z-10">
                                <tr>
                                    <th colspan="3" class="px-5 py-3 border-gray-200 text-center text-xs font-semibold text-gray-600 uppercase whitespace-no-wrap fixed-column">
                                    
                                    </th>
                                    <th colspan="2" class="px-5 py-1 border-r-2 border-gray-200 bg-red-500 text-white text-center text-xs font-semibold uppercase whitespace-no-wrap">
                                   2.2
                                    </th>
                                    <th colspan="2" class="px-5 py-1 border-r-2 border-gray-200 bg-red-500 text-white text-center text-xs font-semibold uppercase whitespace-no-wrap">
                                        2.5
                                    </th>
                                    <th colspan="2" class="px-5 py-1 border-r-2 border-gray-200 bg-red-500 text-white text-center text-xs font-semibold uppercase whitespace-no-wrap">
                                        5
                                    </th>
                                    <th colspan="2" class="px-5 py-1 border-r-2 border-gray-200 bg-red-500 text-white text-center text-xs font-semibold uppercase whitespace-no-wrap">
                                        10
                                    </th>
                                    <th colspan="2" class="px-5 py-1 border-r-2 border-gray-200 bg-red-500 text-white text-center text-xs font-semibold uppercase whitespace-no-wrap">
                                        comercial
                                    </th>
                                    <th colspan="2" class="px-5 py-1 border-r-2 border-gray-200 bg-red-500 text-white text-center text-xs font-semibold uppercase whitespace-no-wrap">
                                        Total
                                    </th>
                                    <th colspan="2" class="px-5 py-1 border-r-2 border-gray-200 bg-red-500 text-white text-center text-xs font-semibold uppercase whitespace-no-wrap">
                                        Tarifa
                                    </th>
                                  
                    
                                </tr>
                                <tr>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-white text-left text-xs font-semibold text-gray-600 uppercase whitespace-no-wrap fixed-column">
                                        Variedad
                                      </th>
                                      <th class="px-5 py-3 border-b-2 border-gray-200 bg-white text-left text-xs font-semibold text-gray-600 uppercase whitespace-no-wrap fixed-column-1">
                                        Semana
                                      </th>
                                      <th class="px-5 py-3 border-b-2 border-gray-200 bg-white text-left text-xs font-semibold text-gray-600 uppercase whitespace-no-wrap fixed-column-2">
                                        Calibre
                                      </th>
                                  
                    
                                    <th class="text-center px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase whitespace-no-wrap">
                                        Suma de CAJA DIFERENCIAL
                                       
                                    </th>
                                    <th class="text-center px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase whitespace-no-wrap">
                                        Suma de PESO PRORRATEADO
                                       
                                    </th>
                                    <th class="text-center px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase whitespace-no-wrap">
                                        Suma de CAJA DIFERENCIAL
                                       
                                    </th>
                                    <th class="text-center px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase whitespace-no-wrap">
                                        Suma de PESO PRORRATEADO
                                       
                                    </th>
                                    <th class="text-center px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase whitespace-no-wrap">
                                        Suma de CAJA DIFERENCIAL
                                       
                                    </th>
                                    <th class="text-center px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase whitespace-no-wrap">
                                        Suma de PESO PRORRATEADO
                                       
                                    </th>
                                    <th class="text-center px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase whitespace-no-wrap">
                                        Suma de CAJA DIFERENCIAL
                                       
                                    </th>
                                    <th class="text-center px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase whitespace-no-wrap">
                                        Suma de PESO PRORRATEADO
                                       
                                    </th>
                                    <th class="text-center px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase whitespace-no-wrap">
                                        Suma de CAJA DIFERENCIAL
                                       
                                    </th>
                                    <th class="text-center px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase whitespace-no-wrap">
                                        Suma de PESO PRORRATEADO
                                       
                                    </th>
                                    <th class="text-center px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase whitespace-no-wrap">
                                        Suma de CAJA DIFERENCIAL
                                       
                                    </th>
                                    <th class="text-center px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase whitespace-no-wrap">
                                        Suma de PESO PRORRATEADO
                                       
                                    </th>

                    
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase whitespace-no-wrap">
                                        Tarifa
                                    </th>                
                    
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase whitespace-no-wrap">
                                        Acción
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="text-left">
                              
                                @foreach ($fobs as $fob)
                                    <tr>
                                        <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm sticky-column">
                                            <div class="flex items-center">
                                                <div class="ml-3">
                                                    <p class="text-gray-900 whitespace-no-wrap">
                                                        {{$fob->n_variedad}}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm sticky-column">
                                            <p class="text-gray-900 whitespace-no-wrap"> {{$fob->semana}}</p>
                                        </td>
                                        <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm sticky-column">
                                            <p class="text-gray-900 whitespace-no-wrap"> {{$fob->n_calibre}}</p>
                                        </td>
                                        
                                        <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-right">
                                            <p class="text-gray-900 whitespace-no-wrap"> {{number_format(floatval($fob->suma_caja_diferencial_22),2)}}</p>
                                        </td>

                                        <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-right">
                                            <p class="text-gray-900 whitespace-no-wrap"> {{number_format(floatval($fob->peso_caja_diferencial_22),2)}}</p>
                                        </td>
                                    
                                        <td class="px-5 py-2 border-b border-gray-200 bg-gray-200 text-sm text-right">
                                            <p class="text-gray-900 whitespace-no-wrap"> {{number_format(floatval($fob->suma_caja_diferencial_25),1)}}</p>
                                        </td>

                                        <td class="px-5 py-2 border-b border-gray-200 bg-gray-200 text-sm text-right">
                                            <p class="text-gray-900 whitespace-no-wrap"> {{number_format(floatval($fob->peso_caja_diferencial_25),1)}}</p>
                                        </td>

                                        <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-right">
                                            <p class="text-gray-900 whitespace-no-wrap"> {{number_format(floatval($fob->suma_caja_diferencial_5),2)}}</p>
                                        </td>

                                        <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-right">
                                            <p class="text-gray-900 whitespace-no-wrap"> {{number_format(floatval($fob->peso_caja_diferencial_5),2)}}</p>
                                        </td>

                                        <td class="px-5 py-2 border-b border-gray-200 bg-gray-200 text-sm text-right">
                                            <p class="text-gray-900 whitespace-no-wrap"> {{number_format(floatval($fob->suma_caja_diferencial_10),1)}}</p>
                                        </td>

                                        <td class="px-5 py-2 border-b border-gray-200 bg-gray-200 text-sm text-right">
                                            <p class="text-gray-900 whitespace-no-wrap"> {{number_format(floatval($fob->peso_caja_diferencial_10),1)}}</p>
                                        </td>
                                        <td class="px-5 py-2 border-b border-gray-200 bg-gray-200 text-sm text-right">
                                            <p class="text-gray-900 whitespace-no-wrap"> {{number_format(floatval($fob->suma_caja_diferencial_com),1)}}</p>
                                        </td>
                                        <td class="px-5 py-2 border-b border-gray-200 bg-gray-200 text-sm text-right">
                                            <p class="text-gray-900 whitespace-no-wrap"> {{number_format(floatval($fob->peso_caja_diferencial_com),1)}}</p>
                                        </td>

                                        <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-right">
                                            <p class="text-gray-900 whitespace-no-wrap"> {{number_format(floatval($fob->suma_caja_diferencial_total),2)}}</p>
                                        </td>

                                        <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-right">
                                            <p class="text-gray-900 whitespace-no-wrap"> {{number_format(floatval($fob->peso_caja_diferencial_total),2)}}</p>
                                        </td>

                                        <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-right">
                                            <p class="text-gray-900 whitespace-no-wrap"> {{number_format(floatval($fob->tarifa_costo),2)}}</p>
                                        </td>

                                     
                                    
                                    
            
                                        <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                         
                                                <button wire:click='reset_fobid()' class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                                <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                                <span class="relative">Cancelar</span>
                                                </button>

                                         
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
                    </div>
    @endif

    <script>
        function confirmCreateFOB() {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Este proceso creará la tabla de costos y puede demorar unos minutos.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, generar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Mostrar pantalla de cargando mientras se ejecuta el proceso
                    Swal.fire({
                        title: 'Generando precios...',
                        text: 'Este proceso puede demorar unos minutos. Por favor, espera.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    // Llamar a la función de Livewire para generar los precios
                    @this.call('precio_create').then(() => {
                        Swal.close(); // Cerrar la alerta de cargando cuando el proceso termine
                        Swal.fire(
                            '¡Proceso completado!',
                            'Los precios FOB se han generado exitosamente.',
                            'success'
                        );
                    }).catch(() => {
                        Swal.close(); // Cerrar la alerta en caso de error
                        Swal.fire(
                            'Error en el proceso',
                            'Ocurrió un problema al generar los precios FOB. Inténtalo nuevamente.',
                            'error'
                        );
                    });
                }
            });
        }
        </script>
<script>
    function confirmCreateComercial() {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Este proceso generará los datos comerciales y puede demorar unos minutos.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, generar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Mostrar pantalla de cargando mientras se ejecuta el proceso
                Swal.fire({
                    title: 'Generando datos comerciales...',
                    text: 'Este proceso puede demorar unos minutos. Por favor, espera.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Llamar a la función de Livewire para generar los datos comerciales
                @this.call('precio_create2').then(() => {
                    Swal.close(); // Cerrar la alerta de cargando cuando el proceso termine
                    Swal.fire(
                        '¡Proceso completado!',
                        'Los datos comerciales se han generado exitosamente.',
                        'success'
                    );
                }).catch(() => {
                    Swal.close(); // Cerrar la alerta en caso de error
                    Swal.fire(
                        'Error en el proceso',
                        'Ocurrió un problema al generar los datos comerciales. Inténtalo nuevamente.',
                        'error'
                    );
                });
            }
        });
    }
    </script>

<script>
   function confirmDelete() {
       Swal.fire({
           title: '¿Estás seguro?',
           text: "No podrás revertir esta acción.",
           icon: 'warning',
           showCancelButton: true,
           confirmButtonColor: '#d33',
           cancelButtonColor: '#3085d6',
           confirmButtonText: 'Sí, eliminar',
           cancelButtonText: 'Cancelar'
       }).then((result) => {
           if (result.isConfirmed) {
               // Mostrar mensaje de "Eliminando..."
               Swal.fire({
                   title: 'Eliminando...',
                   allowOutsideClick: false,
                   didOpen: () => {
                       Swal.showLoading();
                   }
               });

               // Llama al método Livewire para eliminar
               @this.call('precios_destroy');
           }
       });
   }

   // Escucha el evento 'deleted' desde Livewire
   Livewire.on('deleted', () => {
       Swal.fire(
           'Eliminado!',
           'El registro ha sido eliminado.',
           'success'
       );
   });
</script>
<script>
    function confirmAddPrecio() {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Este proceso asignará los precios al costo. Puede demorar unos minutos.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, asignar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Asignando...',
                    text: 'Por favor espera mientras se realiza la asignación.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                @this.call('add_precio').then(() => {
                    Swal.close();
                    Swal.fire(
                        '¡Completado!',
                        'La asignación se realizó correctamente.',
                        'success'
                    );
                }).catch(() => {
                    Swal.close();
                    Swal.fire(
                        'Error',
                        'Hubo un problema al asignar los precios. Inténtalo de nuevo.',
                        'error'
                    );
                });
            }
        });
    }
</script>

    

</div>
