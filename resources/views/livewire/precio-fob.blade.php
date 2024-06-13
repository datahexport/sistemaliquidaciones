<div>
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
                                        <div class="mb-4 flex">
                                          
                                           
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
                                                  @foreach ($unique_calibres as $item)
                                                    <option value="{{$item}}">{{$item}}</option>
                                                  @endforeach
                                                 
                                                </select>
                                              </div>

                                              <div class="ml-4 hidden">
                                                Norma:<br>
                                                <select wire:model.live="filters.calibre" name="" id="" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-40">
                                                  <option value="">Todos</option>
                                                  @foreach ($unique_calibres as $item)
                                                    <option value="{{$item}}">{{$item}}</option>
                                                  @endforeach
                                                 
                                                </select>
                                              </div>

                                              <div class="ml-auto">
                                                Precio:<br>
                                                <div class="flex">
                                                    <input wire:model="precio_usd" type="number" class="form-input flex-1 w-full shadow-sm  border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg focus:outline-none" autocomplete="off">
                        
                                                    <button wire:click="exportacion_store" class="ml-2 focus:ring-2 focus:ring-offset-2 focus:ring-green-300 text-sm leading-none text-green-600 py-3 px-5 bg-green-600 rounded hover:bg-green-500 focus:outline-none">

                                                        <h1 style="font-size: 1rem;white-space: nowrap;" class="text-center text-white font-bold inline w-full" >
                                                        Agregar
                                                            
                                                        </h1>
                                                    </button>
                                                </div>
                                              </div>

                                          
                                           
                                             
                                          
                            
                                         
                                          </div>

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
                                                            'Suma de Fob',
                                                            'Suma de Kg',
                                                            'Suma de FOB/KG',
                                                            'Acción'
                                                           
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
                                                    @foreach ($unique_variedades as $variedad)

                                                        @foreach ($unique_semanas as $semana)
                                                            @php
                                                                $pesovariedad=0;
                                                                $ventavariedad=0;
                                                            @endphp
                                                            @foreach ($detalle_liquidacions2 as $detalle)
                                                                @if ($detalle->Variedad==$variedad && $detalle->semana==$semana)
                                                                    @php
                                                                        $pesovariedad+=$detalle->PESO_TOTAL;
                                                                        $ventavariedad+=$detalle->VENTA_USD;
                                                                    @endphp
                                                                @endif
                                                            @endforeach
                                                            @foreach ($unique_calibres as $calibre)
                                                               
                                                                @if ($pesovariedad>0)
                                                                    <tr>
                                                                        <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                                                            <p class="text-gray-900 whitespace-nowrap">{{$variedad}}</p>
                                                                        </td>
                                                                        <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                                                            <p class="text-gray-900 whitespace-nowrap">{{$semana}}</p>
                                                                        </td>
                                                                        <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                                                            <p class="text-gray-900 whitespace-nowrap">{{$calibre}}</p>
                                                                        </td>
                                                                        <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-right">
                                                                            <p class="text-gray-900 whitespace-nowrap">{{number_format($ventavariedad,2,'.','.')}}</p>
                                                                        </td>
                                                                        <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-center">
                                                                            <p class="text-gray-900 whitespace-nowrap">{{$pesovariedad}}</p>
                                                                        </td>
                                                                        <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-center">
                                                                            <p class="text-gray-900 whitespace-nowrap">{{number_format($ventavariedad/$pesovariedad,2,'.','.')}}</p>
                                                                        </td>
                                                                      
                                                                        <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                                                        
                                                                            <span wire:click='set_masaid({{$detalle->id}})' class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                                                                <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full"></span>
                                                                                <span class="relative">Editar</span>
                                                                            </span>
                                                                        
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            @endforeach
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
