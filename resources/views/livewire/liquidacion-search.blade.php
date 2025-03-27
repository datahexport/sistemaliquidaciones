<div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
    @php
        $pesovariedad=0;
        $ventavariedad=0;
        $liqproductor=0;
    @endphp
    @foreach ($detallesall as $detalle)
        @php
            $pesovariedad+=floatval($detalle->PESO_TOTAL);
            $ventavariedad+=$detalle->VENTA_USD;
            $liqproductor+=$detalle->LIQ_CLIENTE;
        @endphp
    @endforeach

    <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
        <div class="flex mb-4">
            <div class="ml-4">
                Folios:<br>
                <div class="flex">
                    <button class="focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 text-sm leading-none text-gray-600 py-3 px-5 bg-gray-500 rounded hover:bg-gray-600 focus:outline-none">

                        <h1 style="font-size: 1rem;white-space: nowrap;" class="text-center text-white font-bold inline w-full" >
                            {{number_format($unique_folios->count(),0)}}
                            
                        </h1>
                    </button>
                 
                
                </div>
              </div>

            <div class="ml-4">
                Peso:<br>
                <div class="flex">
                    <button class="focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 text-sm leading-none text-gray-600 py-3 px-5 bg-gray-500 rounded hover:bg-gray-600 focus:outline-none">

                        <h1 style="font-size: 1rem;white-space: nowrap;" class="text-center text-white font-bold inline w-full" >
                            {{number_format($pesovariedad,1)}}
                            
                        </h1>
                    </button>
                 
                
                </div>
              </div>

              <div class="ml-4">
                Venta:<br>
                <div class="flex">

                 
                    <button class="ml-2 focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 text-sm leading-none text-gray-600 py-3 px-5 bg-gray-500 rounded hover:bg-gray-600 focus:outline-none">

                        <h1 style="font-size: 1rem;white-space: nowrap;" class="text-center text-white font-bold inline w-full" >
                            {{number_format($ventavariedad,2)}}
                            
                        </h1>
                    </button>
                </div>
              </div>

              <div class="ml-4">
                Liq Productor:<br>
                <div class="flex">

                 
                    <button class="ml-2 focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 text-sm leading-none text-gray-600 py-3 px-5 bg-gray-500 rounded hover:bg-gray-600 focus:outline-none">

                        <h1 style="font-size: 1rem;white-space: nowrap;" class="text-center text-white font-bold inline w-full" >
                            {{number_format($liqproductor,2)}}
                            
                        </h1>
                    </button>
                </div>
              </div>
       
            <div class="ml-4">
                Folio:<br>
                <select wire:model.live="filters.folio" name="" id="" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-40">
                  <option value="">Todos</option>
                  <option value="vacio">Vacios</option>
                  @foreach ($unique_folios as $item)
                    <option value="{{$item}}">{{$item}}</option>
                  @endforeach
                 
                </select>
              </div>

              <div class="ml-4">
                Variedad:<br>
                <select wire:model.live="filters.variedad" name="" id="" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-40">
                  <option value="">Todos</option>
                  @foreach ($unique_variedads as $item)
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
                Semana:<br>
                <select wire:model.live="filters.semana" name="" id="" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-40">
                  <option value="">Todos</option>
                  @foreach ($unique_semanas as $item)
                    <option value="{{$item}}">{{$item}}</option>
                  @endforeach
                 
                </select>
              </div>
              
    
              
        </div>
        <table class="min-w-full leading-normal">
            <thead>
            <tr>
                @php
                 $columnas = [
                    'Sales_date',
                    'Arrival_Date',
                    'semana',
                    'N_Pallet',
                    'Variedad',
                    'Etiqueta',
                    'Calibre_y_Color',
                    'Cajas',
                    'Precio_Venta_Yen',
                    'Total_Venta',
                    'Contenedor',
                    'PESO_TOTAL',
                    'CAJAS_DESPACHADAS',
                    'DIF',
                    'PESO_CAJA',
                    'COLOR',
                    'SIG_COLOR',
                    'CALIBRE',
                    'TC',
                    'VENTA_USD',
                    'COMISION',
                    'FLETE',
                    'OTROS_GASTOS',
                    'Apoyo_Liquidaciones',
                    'LIQ_CLIENTE',
                    'PROMOCION_ASOEX',
                    'SEGURO_CARGA',
                    'LIQ_PRODUCTOR',
                    'RETORNO_PRODUCTOR_ESTIMADO',
                    'NAVE',
                    'CLIENTE',
                    'PAIS',
                    'MERCADO',
                    'UNIR_CADE',
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
            @foreach ($detalles as $masa)
                <tr>
                @foreach ($columnas as $columna)
                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                    <p class="text-gray-900 whitespace-nowrap">{{ $masa->{$columna} }}</p>
                    </td>
                @endforeach
                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                
                    <p class="text-gray-900 whitespace-no-wrap">
                        @if ($masa->fob > 0)
                        {{ $masa->fob }}
                        @else
                        {{ $masa->fob_nacional }}
                        @endif
                    </p>
                
                </td>
                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                
                    <span wire:click='set_masaid({{$masa->id}})' class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                        <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full"></span>
                        <span class="relative">Editar</span>
                    </span>
                
                </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>