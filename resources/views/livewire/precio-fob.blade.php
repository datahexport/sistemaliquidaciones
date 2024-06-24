<div>
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
                                    <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                                        @php
                                            $pesovariedad=0;
                                            $ventavariedad=0;
                                        @endphp
                                        @foreach ($detalle_liquidacions2 as $detalle)
                                            @php
                                                $pesovariedad+=$detalle->PESO_TOTAL;
                                                $ventavariedad+=$detalle->VENTA_USD;
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
                                                            @if ($unique_calibres->contains($item))
                                                                <option value="{{$item}}">{{$item}}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                              </div>
                                              <div class="ml-4">
                                                Generar Precios Fobs:<br>
                                                    <button wire:click="precio_create" class="ml-2 focus:ring-2 focus:ring-offset-2 focus:ring-green-300 text-sm leading-none text-green-600 py-3 px-5 bg-green-600 rounded hover:bg-green-500 focus:outline-none">

                                                        <h1 style="font-size: 1rem;white-space: nowrap;" class="text-center text-white font-bold inline w-full" >
                                                        GENERAR
                                                            
                                                        </h1>
                                                    </button>
                                              </div>
                                              
                                              <div class="ml-4 hidden">
                                                Peso:<br>
                                                <div class="flex">
                                                    <button class="focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 text-sm leading-none text-gray-600 py-3 px-5 bg-gray-500 rounded hover:bg-gray-600 focus:outline-none">

                                                        <h1 style="font-size: 1rem;white-space: nowrap;" class="text-center text-white font-bold inline w-full" >
                                                            {{number_format($pesovariedad,0)}}
                                                            
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


                                              <div class="ml-auto">
                                                Precio:<br>
                                                <div class="flex">
                                                    <input wire:model="price_name" wire:keydown.enter="add_precio" type="text" class="form-input flex-1 w-full shadow-sm  border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg focus:outline-none" autocomplete="off">
                        
                                                    <button wire:click="add_precio" class="ml-2 focus:ring-2 focus:ring-offset-2 focus:ring-green-300 text-sm leading-none text-green-600 py-3 px-5 bg-green-600 rounded hover:bg-green-500 focus:outline-none">

                                                        <h1 style="font-size: 1rem;white-space: nowrap;" class="text-center text-white font-bold inline w-full" >
                                                        Agregar
                                                            
                                                        </h1>
                                                    </button>
                                                </div>
                                              </div>

                                          
                                           
                                             
                                          
                            
                                         
                                          </div>
                                          <table class="min-w-full leading-normal">
                                            <thead>
                                           
                                                <tr>
                                                    @php
                                                        $columnas = [
                                                            'Variedad',
                                                            'Semana',
                                                            'Calibre',
                                                            '('.number_format($ventavariedad).')<br>Suma de Fob',
                                                            '('.number_format($pesovariedad).')<br>Suma de Kg',
                                                            
                                                           
                                                        ];
                                                        $n=0;
                                                        foreach ($columnas as $columna) {
                                                            if ($n==3) {
                                                                echo '<th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-right text-xs font-semibold text-gray-600 uppercase whitespace-no-wrap">';
                                                            } else {
                                                                echo '<th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase whitespace-no-wrap">';
                                                            }
                                                            
                                                            echo ucfirst(str_replace('_', ' ', $columna));
                                                            echo '</th>';
                                                            $n+=1;
                                                        }
    
                                                    @endphp

                                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase whitespace-no-wrap">
                                                        Precio Inicial
                                                    </th>
                                                    @if ($temporada->precios->count()>0)
                                                        @foreach ($temporada->precios as $precio)
                                                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase whitespace-no-wrap">
                                                                {{$precio->name}}
                                                            </th>
                                                        @endforeach
                                                    @endif
                                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase whitespace-no-wrap">
                                                        Acción
                                                    </th>

                                                </tr>
                                                </thead>
                                                <tbody class="text-left">
                                                  
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
                                                                <p class="text-gray-900 whitespace-no-wrap"> {{$fob->n_calibre}}</p>
                                                            </td>

                                                            
                                                            <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-right">
                                                                <p class="text-gray-900 whitespace-no-wrap"> {{number_format($fob->suma_fob,2)}}</p>
                                                            </td>

                                                            <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-right">
                                                                <p class="text-gray-900 whitespace-no-wrap"> {{number_format($fob->cant_kg,1)}}</p>
                                                            </td>
                                                        
                                                            <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                                                @if ($fobid==$fob->id)
                                                                    <input wire:model="preciofob" class="w-32 shadow-sm  border-2 border-gray-300 bg-white h-10 px-2 rounded-lg focus:outline-none">   
                                                                    <span wire:click='save_fobid()' class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                                                        <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                                                        <span class="relative">Guardar</span>
                                                                        </span>
                                                                @else
                                                                    <p class="text-gray-900 whitespace-no-wrap text-center"> {{number_format($fob->fob_kilo_salida,2)}}</p>
                                                                @endif
                                                                
                                                            </td>

                                                            @if ($temporada->precios->count()>0)
                                                                @foreach ($temporada->precios as $precio)
                                                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-center">
                                                                        <p class="text-gray-900 whitespace-nowrap">{{ number_format($fob->fob_kilo_salida, 2, '.', '.') }}</p>
                                                                    </td>
                                                                @endforeach
                                                            @endif
                                                        
                                                        
                                
                                                            <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                                                @if ($fobid==$fob->id)

                                                                    <span wire:click='reset_fobid()' class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                                                    <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                                                    <span class="relative">Cancelar</span>
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
                                        <table class="min-w-full leading-normal">
                                            <thead>
                                                <tr class="hidden">
                                                      
                                                
                                                      
                                                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase whitespace-no-wrap">
                                                            {{$unique_variedades->count() }} Variedades
                                                            </th>
                                                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase whitespace-no-wrap">
                                                                   {{$unique_semanas}}
                                                              
                                                            </th>
                                                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase whitespace-no-wrap">
                                                                {{$unique_calibres}}
                                                           
                                                            </th>
                                                     
                                                        
                                                </tr>
                                                <tr>
                                                    @php
                                                        $columnas = [
                                                            'Variedad',
                                                            'Semana',
                                                            'Calibre',
                                                            '('.number_format($ventavariedad).')<br>Suma de Fob',
                                                            '('.number_format($pesovariedad).')<br>Suma de Kg',
                                                            
                                                           
                                                        ];
                                                        $n=0;
                                                        foreach ($columnas as $columna) {
                                                            if ($n==3) {
                                                                echo '<th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-right text-xs font-semibold text-gray-600 uppercase whitespace-no-wrap">';
                                                            } else {
                                                                echo '<th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase whitespace-no-wrap">';
                                                            }
                                                            
                                                            echo ucfirst(str_replace('_', ' ', $columna));
                                                            echo '</th>';
                                                            $n+=1;
                                                        }
    
                                                    @endphp

                                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase whitespace-no-wrap">
                                                        Precio Inicial
                                                    </th>
                                                    @if ($temporada->precios->count()>0)
                                                        @foreach ($temporada->precios as $precio)
                                                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase whitespace-no-wrap">
                                                                {{$precio->name}}
                                                            </th>
                                                        @endforeach
                                                    @endif
                                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase whitespace-no-wrap">
                                                        Acción
                                                    </th>

                                                </tr>
                                                </thead>
                                                <tbody class="text-left">
                                                    @php
                                                        $ncount=0;
                                                    @endphp
                                                    @foreach ($unique_variedades as $variedad)

                                                        @foreach ($unique_semanas as $semana)
                                                            @php
                                                               
                                                                
                                                                $peso5J=0;
                                                                $peso4J=0;
                                                                $peso3J=0;
                                                                $peso2J=0;
                                                                $pesoJ=0;
                                                                $pesoXL=0;
                                                                $pesoL=0;
                                                                $pesoJUP=0;
                                                                
                                                                $venta5J=0;
                                                                $venta4J=0;
                                                                $venta3J=0;
                                                                $venta2J=0;
                                                                $ventaJ=0;
                                                                $ventaXL=0;
                                                                $ventaL=0;
                                                                $ventaJUP=0;
                                                                
                                                            @endphp
                                                            @foreach ($detalle_liquidacions2 as $detalle)
                                                                @if ($detalle->Variedad==$variedad && $detalle->semana==$semana)
                                                                    @if ($detalle->CALIBRE == '5J')
                                                                        @php
                                                                            $peso5J += $detalle->PESO_TOTAL;
                                                                            $venta5J += $detalle->VENTA_USD;
                                                                        @endphp
                                                                    @elseif ($detalle->CALIBRE == '4J')
                                                                        @php
                                                                            $peso4J += $detalle->PESO_TOTAL;
                                                                            $venta4J += $detalle->VENTA_USD;
                                                                        @endphp
                                                                    @elseif ($detalle->CALIBRE == '3J')
                                                                        @php
                                                                            $peso3J += $detalle->PESO_TOTAL;
                                                                            $venta3J += $detalle->VENTA_USD;
                                                                        @endphp
                                                                    @elseif ($detalle->CALIBRE == '2J')
                                                                        @php
                                                                            $peso2J += $detalle->PESO_TOTAL;
                                                                            $venta2J += $detalle->VENTA_USD;
                                                                        @endphp
                                                                    @elseif ($detalle->CALIBRE == 'J')
                                                                        @php
                                                                            $pesoJ += $detalle->PESO_TOTAL;
                                                                            $ventaJ += $detalle->VENTA_USD;
                                                                        @endphp
                                                                    @elseif ($detalle->CALIBRE == 'XL')
                                                                        @php
                                                                            $pesoXL += $detalle->PESO_TOTAL;
                                                                            $ventaXL += $detalle->VENTA_USD;
                                                                        @endphp
                                                                    @elseif ($detalle->CALIBRE == 'L')
                                                                        @php
                                                                            $pesoL += $detalle->PESO_TOTAL;
                                                                            $ventaL += $detalle->VENTA_USD;
                                                                        @endphp
                                                                    @elseif ($detalle->CALIBRE == 'JUP')
                                                                        @php
                                                                            $pesoJUP += $detalle->PESO_TOTAL;
                                                                            $ventaJUP += $detalle->VENTA_USD;
                                                                        @endphp
                                                                    @endif



                                                                    
                                                                @endif
                                                            @endforeach

                                                               
                                                            @if ($venta5J > 0)
                                                                @php
                                                                    $ncount+=1;
                                                                @endphp
                                                                <tr>
                                                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                                                        <p class="text-gray-900 whitespace-nowrap">{{ $variedad }}</p>
                                                                    </td>
                                                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                                                        <p class="text-gray-900 whitespace-nowrap">{{ $semana }}</p>
                                                                    </td>
                                                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                                                        <p class="text-gray-900 whitespace-nowrap">5J</p>
                                                                    </td>
                                                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-right">
                                                                        <p class="text-gray-900 whitespace-nowrap">{{ number_format($venta5J, 2, '.', '.') }}</p>
                                                                    </td>
                                                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-center">
                                                                        <p class="text-gray-900 whitespace-nowrap">{{ $peso5J }}</p>
                                                                    </td>
                                                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-center">
                                                                        <p class="text-gray-900 whitespace-nowrap">{{ number_format($venta5J / $peso5J, 2, '.', '.') }}</p>
                                                                    </td>
                                                                    @if ($temporada->precios->count()>0)
                                                                        @foreach ($temporada->precios as $precio)
                                                                            <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-center">
                                                                                <p class="text-gray-900 whitespace-nowrap">{{ number_format($venta5J / $peso5J, 2, '.', '.') }}</p>
                                                                            </td>
                                                                        @endforeach
                                                                    @endif
                                                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                                                        <span wire:click='set_masaid({{ $detalle->id }})' class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                                                            <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full"></span>
                                                                            <span class="relative">Editar {{$ncount}}</span>
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                            
                                                            @if ($venta4J > 0)
                                                                @php
                                                                    $ncount+=1;
                                                                @endphp
                                                                <tr>
                                                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                                                        <p class="text-gray-900 whitespace-nowrap">{{ $variedad }}</p>
                                                                    </td>
                                                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                                                        <p class="text-gray-900 whitespace-nowrap">{{ $semana }}</p>
                                                                    </td>
                                                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                                                        <p class="text-gray-900 whitespace-nowrap">4J</p>
                                                                    </td>
                                                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-right">
                                                                        <p class="text-gray-900 whitespace-nowrap">{{ number_format($venta4J, 2, '.', '.') }}</p>
                                                                    </td>
                                                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-center">
                                                                        <p class="text-gray-900 whitespace-nowrap">{{ $peso4J }}</p>
                                                                    </td>
                                                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-center">
                                                                        <p class="text-gray-900 whitespace-nowrap">{{ number_format($venta4J / $peso4J, 2, '.', '.') }}</p>
                                                                    </td>

                                                                    @if ($temporada->precios->count()>0)
                                                                        @foreach ($temporada->precios as $precio)
                                                                            <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-center">
                                                                                <p class="text-gray-900 whitespace-nowrap">{{ number_format($venta4J / $peso4J, 2, '.', '.') }}</p>
                                                                            </td>
                                                                        @endforeach
                                                                    @endif
                                                                    
                                                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                                                        <span wire:click='set_masaid({{ $detalle->id }})' class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                                                            <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full"></span>
                                                                            <span class="relative">Editar {{$ncount}}</span>
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                            
                                                            @if ($venta3J > 0)
                                                                @php
                                                                    $ncount+=1;
                                                                @endphp
                                                                <tr>
                                                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                                                        <p class="text-gray-900 whitespace-nowrap">{{ $variedad }}</p>
                                                                    </td>
                                                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                                                        <p class="text-gray-900 whitespace-nowrap">{{ $semana }}</p>
                                                                    </td>
                                                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                                                        <p class="text-gray-900 whitespace-nowrap">3J</p>
                                                                    </td>
                                                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-right">
                                                                        <p class="text-gray-900 whitespace-nowrap">{{ number_format($venta3J, 2, '.', '.') }}</p>
                                                                    </td>
                                                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-center">
                                                                        <p class="text-gray-900 whitespace-nowrap">{{ $peso3J }}</p>
                                                                    </td>
                                                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-center">
                                                                        <p class="text-gray-900 whitespace-nowrap">{{ number_format($venta3J / $peso3J, 2, '.', '.') }}</p>
                                                                    </td>
                                                                    @if ($temporada->precios->count()>0)
                                                                        @foreach ($temporada->precios as $precio)
                                                                            <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-center">
                                                                                <p class="text-gray-900 whitespace-nowrap">{{ number_format($venta3J / $peso3J, 2, '.', '.') }}</p>
                                                                            </td>
                                                                        @endforeach
                                                                    @endif
                                                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                                                        <span wire:click='set_masaid({{ $detalle->id }})' class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                                                            <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full"></span>
                                                                            <span class="relative">Editar {{$ncount}}</span>
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                            
                                                            @if ($venta2J > 0)
                                                                @php
                                                                    $ncount+=1;
                                                                @endphp
                                                                <tr>
                                                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                                                        <p class="text-gray-900 whitespace-nowrap">{{ $variedad }}</p>
                                                                    </td>
                                                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                                                        <p class="text-gray-900 whitespace-nowrap">{{ $semana }}</p>
                                                                    </td>
                                                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                                                        <p class="text-gray-900 whitespace-nowrap">2J</p>
                                                                    </td>
                                                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-right">
                                                                        <p class="text-gray-900 whitespace-nowrap">{{ number_format($venta2J, 2, '.', '.') }}</p>
                                                                    </td>
                                                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-center">
                                                                        <p class="text-gray-900 whitespace-nowrap">{{ $peso2J }}</p>
                                                                    </td>
                                                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-center">
                                                                        <p class="text-gray-900 whitespace-nowrap">{{ number_format($venta2J / $peso2J, 2, '.', '.') }}</p>
                                                                    </td>
                                                                    @if ($temporada->precios->count()>0)
                                                                        @foreach ($temporada->precios as $precio)
                                                                            <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-center">
                                                                                <p class="text-gray-900 whitespace-nowrap">{{ number_format($venta2J / $peso2J, 2, '.', '.') }}</p>
                                                                            </td>
                                                                        @endforeach
                                                                    @endif
                                                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                                                        <span wire:click='set_masaid({{ $detalle->id }})' class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                                                            <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full"></span>
                                                                            <span class="relative">Editar {{$ncount}}</span>
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                            
                                                            @if ($ventaJ > 0)
                                                                @php
                                                                    $ncount+=1;
                                                                @endphp
                                                                <tr>
                                                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                                                        <p class="text-gray-900 whitespace-nowrap">{{ $variedad }}</p>
                                                                    </td>
                                                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                                                        <p class="text-gray-900 whitespace-nowrap">{{ $semana }}</p>
                                                                    </td>
                                                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                                                        <p class="text-gray-900 whitespace-nowrap">J</p>
                                                                    </td>
                                                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-right">
                                                                        <p class="text-gray-900 whitespace-nowrap">{{ number_format($ventaJ, 2, '.', '.') }}</p>
                                                                    </td>
                                                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-center">
                                                                        <p class="text-gray-900 whitespace-nowrap">{{ $pesoJ }}</p>
                                                                    </td>
                                                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-center">
                                                                        <p class="text-gray-900 whitespace-nowrap">{{ number_format($ventaJ / $pesoJ, 2, '.', '.') }}</p>
                                                                    </td>

                                                                    @if ($temporada->precios->count()>0)
                                                                        @foreach ($temporada->precios as $precio)
                                                                            <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-center">
                                                                                <p class="text-gray-900 whitespace-nowrap">{{ number_format($ventaJ / $pesoJ, 2, '.', '.') }}</p>
                                                                            </td>
                                                                        @endforeach
                                                                    @endif

                                                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                                                        <span wire:click='set_masaid({{ $detalle->id }})' class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                                                            <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full"></span>
                                                                            <span class="relative">Editar {{$ncount}}</span>
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                            
                                                            @if ($ventaXL > 0)
                                                                @php
                                                                    $ncount+=1;
                                                                @endphp
                                                                <tr>
                                                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                                                        <p class="text-gray-900 whitespace-nowrap">{{ $variedad }}</p>
                                                                    </td>
                                                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                                                        <p class="text-gray-900 whitespace-nowrap">{{ $semana }}</p>
                                                                    </td>
                                                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                                                        <p class="text-gray-900 whitespace-nowrap">XL</p>
                                                                    </td>
                                                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-right">
                                                                        <p class="text-gray-900 whitespace-nowrap">{{ number_format($ventaXL, 2, '.', '.') }}</p>
                                                                    </td>
                                                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-center">
                                                                        <p class="text-gray-900 whitespace-nowrap">{{ $pesoXL }}</p>
                                                                    </td>
                                                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-center">
                                                                        <p class="text-gray-900 whitespace-nowrap">{{ number_format($ventaXL / $pesoXL, 2, '.', '.') }}</p>
                                                                    </td>
                                                                    @if ($temporada->precios->count()>0)
                                                                        @foreach ($temporada->precios as $precio)
                                                                            <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-center">
                                                                                <p class="text-gray-900 whitespace-nowrap">{{ number_format($ventaXL / $pesoXL, 2, '.', '.') }}</p>
                                                                            </td>
                                                                        @endforeach
                                                                    @endif

                                                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                                                        <span wire:click='set_masaid({{ $detalle->id }})' class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                                                            <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full"></span>
                                                                            <span class="relative">Editar {{$ncount}}</span>
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                            
                                                            @if ($ventaL > 0)
                                                                @php
                                                                    $ncount+=1;
                                                                @endphp
                                                                <tr>
                                                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                                                        <p class="text-gray-900 whitespace-nowrap">{{ $variedad }}</p>
                                                                    </td>
                                                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                                                        <p class="text-gray-900 whitespace-nowrap">{{ $semana }}</p>
                                                                    </td>
                                                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                                                        <p class="text-gray-900 whitespace-nowrap">L</p>
                                                                    </td>
                                                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-right">
                                                                        <p class="text-gray-900 whitespace-nowrap">{{ number_format($ventaL, 2, '.', '.') }}</p>
                                                                    </td>
                                                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-center">
                                                                        <p class="text-gray-900 whitespace-nowrap">{{ $pesoL }}</p>
                                                                    </td>
                                                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-center">
                                                                        <p class="text-gray-900 whitespace-nowrap">{{ number_format($ventaL / $pesoL, 2, '.', '.') }}</p>
                                                                    </td>
                                                                    @if ($temporada->precios->count()>0)
                                                                        @foreach ($temporada->precios as $precio)
                                                                            <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-center">
                                                                                <p class="text-gray-900 whitespace-nowrap">{{ number_format($ventaL / $pesoL, 2, '.', '.') }}</p>
                                                                            </td>
                                                                        @endforeach
                                                                    @endif
                                                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                                                        <span wire:click='set_masaid({{ $detalle->id }})' class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                                                            <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full"></span>
                                                                            <span class="relative">Editar {{$ncount}}</span>
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                            
                                                            @if ($ventaJUP > 0)
                                                                @php
                                                                    $ncount+=1;
                                                                @endphp
                                                                <tr>
                                                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                                                        <p class="text-gray-900 whitespace-nowrap">{{ $variedad }}</p>
                                                                    </td>
                                                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                                                        <p class="text-gray-900 whitespace-nowrap">{{ $semana }}</p>
                                                                    </td>
                                                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                                                        <p class="text-gray-900 whitespace-nowrap">JUP</p>
                                                                    </td>
                                                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-right">
                                                                        <p class="text-gray-900 whitespace-nowrap">{{ number_format($ventaJUP, 2, '.', '.') }}</p>
                                                                    </td>
                                                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-center">
                                                                        <p class="text-gray-900 whitespace-nowrap">{{ $pesoJUP }}</p>
                                                                    </td>
                                                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-center">
                                                                        <p class="text-gray-900 whitespace-nowrap">{{ number_format($ventaJUP / $pesoJUP, 2, '.', '.') }}</p>
                                                                    </td>
                                                                    @if ($temporada->precios->count()>0)
                                                                        @foreach ($temporada->precios as $precio)
                                                                            <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-center">
                                                                                <p class="text-gray-900 whitespace-nowrap">{{ number_format($ventaJUP / $pesoJUP, 2, '.', '.') }}</p>
                                                                            </td>
                                                                        @endforeach
                                                                    @endif
                                                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                                                        <span wire:click='set_masaid({{ $detalle->id }})' class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                                                            <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full"></span>
                                                                            <span class="relative">Editar {{$ncount}}</span>
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                          
                                                        @endforeach
                                                    @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            


                            </div>
                        </div>
                    </div>
                @endif
</div>