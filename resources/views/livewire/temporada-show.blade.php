<div class="card-body">
  @php
      $totalfriopacking=0;
  @endphp
  @if ($CostosPackingsall->count()>0)
    @foreach ($CostosPackingsall as $packing)
        @php
            $totalfriopacking+=intval($packing->total_usd);
        @endphp
          
    @endforeach
  @endif
    <h1 class="text-2xl font-bold">Temporada {{$temporada->name}}</h1> {{$vista}}
    <hr class="mt-2 mb-6">

   
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
                                Total Fob Liquidacion
                              </th>
                              <th class="px-6 py-0 text-left text-xs font-bold text-gray-900">
                                Total Comision
                              </th>
                              <th class="px-6 py-0 text-left text-xs font-bold text-gray-900">
                                Total Frio Packing
                              </th>
                              <th class="px-6 py-0 text-left text-xs font-bold text-gray-900">
                                Total Gastos de Exportacion
                              </th>
                              <th class="px-6 py-0 text-left text-xs font-bold text-gray-900">
                              Total Flete a puerto
                              </th>
                              <th class="px-6 py-0 text-left text-xs font-bold text-gray-900">
                                Total Materiales
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
                              $globaltotalmateriales=0;
                              $globalfletehuerto=0;
                              $globalgastoexportacion=0;
                              $globalventafob=0;
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
                                              $totalmateriales=0;
                                              $fletehuerto=0;
                                              $gastoexportacion=0;
                                              $ventafob=0;
                                              $kgsp=0;
                                              $costopacking=0;
                                          @endphp
                                          @foreach ($masastotal as $masa)
                                            @php
                                              if ($masa->variedad==$item->name) {
                                                $cajasbulto+=$masa->cantidad;
                                                $pesoneto+=floatval($masa->peso_prorrateado);
                                                $globalcajasbulto+=$masa->cantidad;
                                                $globalpesoneto+=floatval($masa->peso_prorrateado);
                                                
                                                if (!IS_NULL($masa->precio_fob)) {
                                                  $ventafob+=floatval($masa->peso_prorrateado)*floatval($masa->precio_fob);
                                                  $globalventafob+=floatval($masa->peso_prorrateado)*floatval($masa->precio_fob);
                                                } else {
                                                  $kgsp+=floatval($masa->peso_prorrateado);
                                                  $globalkgsp+=floatval($masa->peso_prorrateado);
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
                                          <div class="text-sm text-gray-900">{{number_format($ventafob,2,'.','.')}} ({{number_format($kgsp)}} Kilos/SP)</div>    
                                        </td>
                                        <td class="px-6 py-0 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{number_format($ventafob*(0.08) ,2,'.','.')}}</div>    
                                        </td>
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
                                          <div class="text-sm text-gray-900">{{number_format($totalmateriales,2,'.','.')}}</div>    
                                        </td>
                                        <td class="px-6 py-0 whitespace-nowrap">
                                          <div class="text-sm text-gray-900">{{number_format(($ventafob-($ventafob*(0.08)+$costopacking+$gastoexportacion+$fletehuerto+$totalmateriales)),2,'.','.')}}</div>    
                                        </td>
                                        <td class="px-6 py-0 whitespace-nowrap">
                                          <div class="text-sm text-gray-900">
                                            @if ($pesoneto==0)
                                              0      
                                            @else
                                             {{number_format(($ventafob-($ventafob*(0.08)+$costopacking+$gastoexportacion+$fletehuerto+$totalmateriales))/$pesoneto,2,'.','.')}}
                                                
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
                                      <div class="text-sm text-gray-900">{{number_format($globalventafob,2,'.','.')}} ({{number_format($globalkgsp)}} Kilos/SP)</div>    
                                    </td>
                                    <td class="px-6 py-0 whitespace-nowrap bg-yellow-500">
                                        <div class="text-sm text-gray-900">{{number_format($globalventafob*(0.08) ,2,'.','.')}}</div>    
                                    </td>
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
                                    <td class="px-6 py-0 whitespace-nowrap bg-yellow-500">
                                      <div class="text-sm text-gray-900">{{number_format(($globalventafob-($globalventafob*(0.08)+$globalcostopacking+$globalgastoexportacion+$globalfletehuerto+$globaltotalmateriales)),2,'.','.')}}</div>    
                                    </td>
                                    <td class="px-6 py-0 whitespace-nowrap bg-yellow-500">
                                      <div class="text-sm text-gray-900">
                                        @if ($globalpesoneto==0)
                                            0
                                        @else
                                          {{number_format(($globalventafob-($globalventafob*(0.08)+$globalcostopacking+$globalgastoexportacion+$globalfletehuerto+$globaltotalmateriales))/$globalpesoneto,2,'.','.')}}</div>    
                                            
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
    @php
        $globalpesoneto=0;
    @endphp
    @foreach ($masastotal as $masa)
      @php
       
          $globalpesoneto+=floatval($masa->peso_prorrateado);
        
      @endphp
    @endforeach

    <section id="informacion">
    <div class="flex w-full bg-gray-300 mt-2"  @if ($vista=="resumes") x-data="{openMenu: 2}" @else x-data="{openMenu: 1}" @endif >
        
        @livewire('menu-aside',['temporada'=>$temporada->id])
        <!-- End Sidebar -->
        <div class="flex flex-col flex-1 w-full overflow-y-auto">
            <!--Start Topbar -->
            <!--End Topbar -->
          <main class="relative z-0 flex-1 pb-8 bg-white">
           
            <div class="bg-gray-100 rounded px-2 md:p-8 shadow mb-6">
              <h2 @click.on="openMenu = 1"  class="cursor-pointer text-xs text-blue-500 font-semibold mb-4"><-Abrir Menu</h2>


              <h2 class="text-2xl font-semibold my-4">Filtros {{$vista}} 
             
                ({{$masastotal->count()}} Registros) ({{number_format($globalpesoneto,0)}} KGS)
             
          </h2>
              
              <div class="mb-4 flex">
                <div>
                  Exportadora:<br>
                  <select wire:model.live="filters.exportadora" name="" id="" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-32">
                    <option value="">Todos</option>
                    <option value="h-export">H-export</option>
                  </select>
                </div>
                
                <div class="ml-4">
                  Productor/Csg/Código de embalaje
                  <x-input wire:model.live="filters.razonsocial" type="text" class="w-full" />
                </div>
                <div class="ml-4">
                  Especie:<br>
                  <select wire:model.live="filters.especie" name="" id="" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-40">
                    <option value="">Todos</option>
                    @foreach ($unique_especies as $item)
                      <option value="{{$item}}">{{$item}}</option>
                    @endforeach
                   
                  </select>
                </div>
                <div class="ml-4">
                  Variedades:<br>
                  <select wire:model.live="filters.variedad" name="" id="" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-40">
                    <option value="">Todos</option>
                    @foreach ($unique_variedades as $item)
                      <option value="{{$item->name}}">{{$item->name}}</option>
                    @endforeach
                   
                  </select>
                </div>
              
                @if ($vista=='MASAS')
                  <div class="ml-4">
                    Precio_fob:<br>
                    <select wire:model.live="filters.precioFob" name="" id="" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-40">
                      <option value="">Todos</option>
                      
                        <option value="null"> Sin Precio Fob</option>
                      
                    
                    </select>
                  </div>
                @endif
                  <div class="ml-4">
                    Norma:<br>
                    <div>
                      <input type="checkbox" wire:model.live="filters.norma" id="norma" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                      <label for="norma">DENTRO DE NORMA</label>
                    </div>
                    <div>
                        <input type="checkbox" wire:model.live="filters.fnorma" id="fnorma" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <label for="fnorma">FUERA DE NORMA</label>
                    </div>
                    <div>
                        <input type="checkbox" wire:model.live="filters.mi" id="mi" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <label for="mi">MERCADO INTERNO</label>
                    </div>
                  




                  </div>
              

                @if ($vista=='PACKING')
                  <div class="ml-auto p-3 shadow-lg rounded-lg bg-white">
                    <h1 class="text-center font-bold text-xl">{{number_format($totalfriopacking,1)}} usd</h1>
                    <h1 class="text-center font-semibold text-sm">TOTAL COSTOS PACKING</h1>
                  </div>
                @endif
              </div>
              <div class="flex mb-4 hidden">
                <div class="mr-4">
                  Desde:
                  <x-input wire:model.live="filters.fromNumber" type="text" class="w-20" />
                </div>
                <div>
                  Hasta:
                  <x-input wire:model.live="filters.toNumber" type="text" class="w-20" />
                </div>
              </div>
              <div class="flex mb-4 hidden">
                <div class="mr-4">
                  Desde fecha:
                  <x-input wire:model.live="filters.fromDate" type="date" class="w-36" />
                </div>
                <div>
                  Hasta fecha:
                  <x-input wire:model.live="filters.toDate" type="date" class="w-36" />
                </div>
              </div>

             
              
              

            </div>

          <div class="hidden">
            <div class="flex justify-center">
                <div class="inline-flex items-center rounded-md shadow-sm gap-x-2">
                    <button class="text-slate-800 hover:text-blue-600 text-sm bg-white hover:bg-slate-100 border-y border-slate-200 font-medium px-4 py-2 inline-flex space-x-1 items-center">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>                      
                        </span>
                        <span>EXPORTADORA</span>
                    </button>
                    <button class="text-slate-800 hover:text-blue-600 text-sm bg-white hover:bg-slate-100 border border-slate-200 rounded-l-lg font-medium px-4 py-2 inline-flex space-x-1 items-center">
                        <span><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                        </svg>
                        </span>
                        <span>PRODUCTOR</span>
                    </button>
                    <button class="text-slate-800 hover:text-blue-600 text-sm bg-white hover:bg-slate-100 border border-slate-200 rounded-l-lg font-medium px-4 py-2 inline-flex space-x-1 items-center">
                        <span><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                        </svg>
                        </span>
                        <span>CSG</span>
                    </button>
                    <button class="text-slate-800 hover:text-blue-600 text-sm bg-white hover:bg-slate-100 border border-slate-200 rounded-l-lg font-medium px-4 py-2 inline-flex space-x-1 items-center">
                        <span><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                        </svg>
                        </span>
                        <span>ESPECIE</span>
                    </button>
                    <button class="text-slate-800 hover:text-blue-600 text-sm bg-white hover:bg-slate-100 border border-slate-200 rounded-l-lg font-medium px-4 py-2 inline-flex space-x-1 items-center">
                        <span><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                        </svg>
                        </span>
                        <span>VARIEDAD</span>
                    </button>
                  
                </div>
            </div>
            <div class="flex justify-center">
              <div class="inline-flex items-center rounded-md shadow-sm gap-x-2">
                  <button class="text-slate-800 hover:text-blue-600 text-sm bg-white hover:bg-slate-100 border-y border-slate-200 font-medium px-4 py-2 inline-flex space-x-1 items-center">
                      <span>
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                          </svg>                      
                      </span>
                      <span>ETIQUETA</span>
                  </button>
                  <button class="text-slate-800 hover:text-blue-600 text-sm bg-white hover:bg-slate-100 border border-slate-200 rounded-l-lg font-medium px-4 py-2 inline-flex space-x-1 items-center">
                      <span><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                      </svg>
                      </span>
                      <span>EMBALAJE</span>
                  </button>
                  <button class="text-slate-800 hover:text-blue-600 text-sm bg-white hover:bg-slate-100 border border-slate-200 rounded-l-lg font-medium px-4 py-2 inline-flex space-x-1 items-center">
                      <span><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                      </svg>
                      </span>
                      <span>CALIBRE</span>
                  </button>
                  <button class="text-slate-800 hover:text-blue-600 text-sm bg-white hover:bg-slate-100 border border-slate-200 rounded-l-lg font-medium px-4 py-2 inline-flex space-x-1 items-center">
                      <span><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                      </svg>
                      </span>
                      <span>CATEGORIA</span>
                  </button>
                  <button class="text-slate-800 hover:text-blue-600 text-sm bg-white hover:bg-slate-100 border border-slate-200 rounded-l-lg font-medium px-4 py-2 inline-flex space-x-1 items-center">
                      <span><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                      </svg>
                      </span>
                      <span>CONTENEDOR</span>
                  </button>
                
              </div>
            </div>
            <div class="flex justify-center">
              <div class="inline-flex items-center rounded-md shadow-sm gap-x-2">
                  <button class="text-slate-800 hover:text-blue-600 text-sm bg-white hover:bg-slate-100 border-y border-slate-200 font-medium px-4 py-2 inline-flex space-x-1 items-center">
                      <span>
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                          </svg>                      
                      </span>
                      <span>PESO NETO</span>
                  </button>
                  <button class="text-slate-800 hover:text-blue-600 text-sm bg-white hover:bg-slate-100 border border-slate-200 rounded-l-lg font-medium px-4 py-2 inline-flex space-x-1 items-center">
                      <span><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                      </svg>
                      </span>
                      <span>MERCADO</span>
                  </button>
                  <button class="text-slate-800 hover:text-blue-600 text-sm bg-white hover:bg-slate-100 border border-slate-200 rounded-l-lg font-medium px-4 py-2 inline-flex space-x-1 items-center">
                      <span><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                      </svg>
                      </span>
                      <span>TIPO NAVE</span>
                  </button>
                  <button class="text-slate-800 hover:text-blue-600 text-sm bg-white hover:bg-slate-100 border border-slate-200 rounded-l-lg font-medium px-4 py-2 inline-flex space-x-1 items-center">
                      <span><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                      </svg>
                      </span>
                      <span>SEMANA</span>
                  </button>
                  <button class="text-slate-800 hover:text-blue-600 text-sm bg-white hover:bg-slate-100 border border-slate-200 rounded-l-lg font-medium px-4 py-2 inline-flex space-x-1 items-center">
                      <span><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                      </svg>
                      </span>
                      <span>PAIS</span>
                  </button>
                
              </div>
            </div>
          </div>
            <div class="flex justify-between ml-4">
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
            <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
              <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">

                @if ($vista=='resumes')
                  <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                          <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                  <thead class="bg-white border-b">
                                    <tr>
                                      <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                        #
                                      </th>
                                      <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                        Name
                                      </th>
                                      <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                        Rut
                                      </th>
                                      <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                        Csg
                                      </th>
                                      <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                        Accion
                                      </th>
                                      <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                        Informe
                                      </th>
                                     
                                    </tr>
                                  </thead>
                                  <tbody>
                                    @php
                                        $n=1;
                                    @endphp
                                   
                                      @foreach ($razons as $razon)
                                       
                                          <tr class="bg-gray-100 border-b">
                                              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{$n}}) {{$razon->id}}</td>
                                              <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                @if ($razon && $temporada)
                                                    
                                                <a href="{{route('razonsocial.show',['razonsocial'=>$razon,'temporada'=>$temporada])}}" target="_blank"> {{$razon->name}}
                                                </a>
                                                
                                                @endif
                                              </td>
                                              <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                              {{$razon->rut}}
                                              </td>
                                              <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                              {{$razon->csg}}
                                              </td>
                                             
                                              <td class="text-sm text-gray-900 font-light px-2 py-4 whitespace-nowrap">
                                                <a href="{{route('exportpdff',['razonsocial'=>$razon,'temporada'=>$temporada])}}" target="_blank">
                                                  <x-button>
                                                    Generar
                                                  </x-button>
                                                </a>
                                              </td> 
                                              <td class="text-sm text-gray-900 font-light py-4 text-center">

                                                @if ($razon->informe)
                                                    <a href="{{route('informe.download',$razon)}}" target="_blank" class="h-10 mr-2 items-center content-center">   
                                                      <img class="h-10 ml-4 pl-2 object-contain" src="{{asset('image/pdf_icon2.png')}}" title="Descargar" alt="">
                                                    </a>
                                                
                                                    
                                                @else
                                                    
                                                @endif

                                              </td>
                                          </tr>
                                        @php
                                            $n+=1;
                                        @endphp
                                      @endforeach
                                  
                                    
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
                        Por favor selecione el archivo de "Materiales" que desea importar {{$materialestotal->count()}}
                    </h1>
                  
                    <h1 class="text-xl font-semibold mb-4 ml-4">
                      Fecha de importación: {{$materialestotal->first()->created_at}}
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
                                  'tipo_caja',
                                  'caja_eq5',
                                  'tipo',
                                  'criterio',
                                  'color_final',
                                  'exportadora',
                                  'norma',
                                  'semana',
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
                                  <p class="text-gray-900 whitespace-nowrap">{{ $masa->tipo_caja }}</p>
                              </td>
                              <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                  <p class="text-gray-900 whitespace-nowrap">{{ $masa->caja_eq5 }}</p>
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
                                @if ($masaid==$masa->id)
                                    <input wire:model="preciomasa" class="w-32 shadow-sm  border-2 border-gray-300 bg-white h-10 px-2 rounded-lg focus:outline-none">
                                @else
                                  <p class="text-gray-900 whitespace-no-wrap">{{ $masa->precio_fob }}</p>
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
                    
                          @foreach ($anticipos as $flete)
                            <tr>
                              <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                <div class="flex items-center">
                                
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
                                <p class="text-gray-900 whitespace-no-wrap"> {{$flete->n_productor}}</p>
                              </td>
                              <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap"> {{date('d/m/Y', strtotime($flete->fecha))}}</p>
                              </td>
                              <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap"> {{$flete->cantidad}}</p>
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

                @if ($vista=='GASTOS') 
                  
                    <div> 
                      <div class="grid grid-cols-6 gap-x-4 items-center mb-6">

                          <select wire:model="familia" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                              <option value="1" class="text-center">Selecciona una familia</option>
                              
                              @foreach ($familias as $familia)
                                  <option value="{{$familia->id}}" class="text-center">{{$familia->name}}</option>
                              @endforeach
                              

                          </select>

                          
                          <select wire:model="categoria" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                              <option value="" class="text-center">Selecciona una categoria</option>
                              
                            
                                  <option value="nacional" class="text-center">Nacional</option>
                                  <option value="exportacion" class="text-center">Exportación</option>
                                  <option value="todas" class="text-center">Todas</option>
                            
                          </select>

                          <input wire:model="item" type="text" class="form-input flex-1 w-full shadow-sm  border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg focus:outline-none" autocomplete="off">
                        

                          <select wire:model="descuenta" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                              <option value="" class="text-center">¿Donde Descuenta?</option>
                                  <option value="fob" class="text-center">Fob</option>
                                  <option value="ctacorriente" class="text-center">Cuenta Corriente</option>
                          </select>

                          <select wire:model="unidad" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                            <option value="" class="text-center">¿Unidad?</option>
                                <option value="caja" class="text-center">Caja</option>
                                <option value="kg" class="text-center">KG</option>
                          </select>

                          <button wire:click="gasto_store" class="focus:ring-2 focus:ring-offset-2 focus:ring-green-300 text-sm leading-none text-green-600 py-3 px-5 bg-green-600 rounded hover:bg-green-500 focus:outline-none">

                              <h1 style="font-size: 1rem;white-space: nowrap;" class="text-center text-white font-bold inline w-full" >
                              Agregar
                                  
                              </h1>
                          </button>
                      </div>
                      @if ($temporada->gastos->count()>0)
                          <table class="min-w-full leading-normal">
                          <thead>
                            <tr>
                              <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                  Familia
                                  </th>
                              <th
                                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                item
                              </th>
                            
                                  <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                      Categoria
                                      </th>
                              <th
                                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                              Descuenta
                              </th>
                              <th
                              class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Unidad
                            </th>
                            
                            
                            
                          
                          </tr>
                          </thead>
                          <tbody>
                        
                              @foreach ($temporada->gastos as $gasto)
                                <tr>
                                  <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                      <p class="text-gray-900 whitespace-no-wrap"> {{$gasto->familia->name}}</p>
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
                                            {{$gasto->item}}
                                          </p>
                                        </div>
                                      </div>
                                  </td>
                                
                                  <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                      <p class="text-gray-900 whitespace-no-wrap"> {{$gasto->categoria}}</p>
                                    </td>
                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                      <p class="text-gray-900 whitespace-no-wrap"> {{$gasto->descuenta}}</p>
                                    </td>
                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                      <p class="text-gray-900 whitespace-no-wrap"> {{$gasto->unidad}}</p>
                                    </td>
                              
                              
      
                                  <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                      <a href="{{Route('gasto.edit',['gasto'=>$gasto,'temporada'=>$temporada])}}">
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

                  @if ($temporada->detalles->count()>0)
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
                      
                            @foreach ($temporada->detalles as $detalle)
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

              
              </div>
            </div>


          </main>
        </div>
    </div>
  </section>
    <div class="flex justify-center">
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
</div>