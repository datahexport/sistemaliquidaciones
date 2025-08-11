<div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
    @php
        $pesovariedad=0;
        $ventavariedad=0;
    @endphp
    @foreach ($despachosall as $detalle)
        @php
            $pesovariedad+=$detalle->cantidad_kilos;
            $ventavariedad+=$detalle->venta_usd;
        @endphp
    @endforeach

    <div class="flex mt-2">
        
        <div class="ml-2">
            <h1>Registros:</h1>
            <button class=" focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 text-sm leading-none text-gray-600 py-3 px-5 bg-gray-500 rounded hover:bg-gray-600 focus:outline-none">
                <h1 style="font-size: 1rem;white-space: nowrap;" class="text-center text-white font-bold inline w-full" >
                {{$despachosall->count()}}
                </h1>
            </button>
        </div>

      
  
        <div class="ml-4">
            Peso:<br>
            <div class="flex">
                <button class="focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 text-sm leading-none text-gray-600 py-3 px-5 bg-gray-500 rounded hover:bg-gray-600 focus:outline-none">

                    <h1 style="font-size: 1rem;white-space: nowrap;" class="text-center text-white font-bold inline w-full" >
                        {{number_format($pesovariedad)}}
                        
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
    </div>
    <div class="flex mt-2">
        <div class="ml-4">
            Cliente:<br>
            <select wire:model.live="filters.cliente" name="" id="" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
              <option value="">Todos</option>
              @foreach ($unique_folios as $item)
                <option value="{{$item}}">{{$item}}</option>
              @endforeach
             
            </select>
          </div>

          <div class="ml-4">
            Tipo:<br>
            <select wire:model.live="filters.tipo" name="" id="" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
              <option value="">Todos</option>
              @foreach ($unique_tipos as $item)
                <option value="{{$item}}">{{$item}}</option>
              @endforeach
             
            </select>
          </div>
          <div class="ml-4">
            Semana:<br>
            <select wire:model.live="filters.semana" name="" id="" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
              <option value="">Todas</option>
              @foreach ($unique_semanas as $item)
                <option value="{{$item}}">{{$item}}</option>
              @endforeach
             
            </select>
          </div>

            <div class="ml-4"> 
                Plantilla:<br>
                <button wire:click="exportarBalance4" class="text-white focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 text-sm leading-none py-3 px-5 bg-gray-500 rounded hover:bg-gray-600 focus:outline-none">DESCARGAR</button>

            </div>
        
       
        <div class="ml-auto">
            <button x-on:click="upvariable=true" class="ml-2 focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 text-sm leading-none text-gray-600 py-3 px-5 bg-gray-500 rounded hover:bg-gray-600 focus:outline-none">
                <h1 style="font-size: 1rem;white-space: nowrap;" class="text-center text-white font-bold inline w-full" >
                    Subir Base Venta Comercial
                </h1>
            </button>
            <button wire:click="destroy_all()" class="mt-2 ml-2 focus:ring-2 focus:ring-offset-2 focus:ring-red-300 text-sm leading-none text-red-600 py-3 px-5 bg-red-500 rounded hover:bg-red-600 focus:outline-none">
                <h1 style="font-size: 1rem;white-space: nowrap;" class="text-center text-white font-bold inline w-full" >
                    Eliminar Base Venta Comercial
                </h1>
            </button>
        </div>
    </div>

    <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
        <table class="min-w-full leading-normal">
            <thead>
                <tr>
                    @php
                    $columnas = [
                        'fecha',
                        'cliente',
                        'cantidad_kilos',
                        'cajas',
                        'tipo',
                        'descripcion',
                        'precio_unitario',
                        'total_iva_incluido',
                        'condicion_de_pago',
                        'neto',
                        'iva',
                        'tc',
                        'venta_usd',
                        'semana'

                    ];
            
                    foreach ($columnas as $columna) {
                        echo '<th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase whitespace-nowrap">';
                        echo ucfirst(str_replace('_', ' ', $columna));
                        echo '</th>';
                    }
                    @endphp
                </tr>
            </thead>
            <tbody>
                @foreach ($ventas as $venta)
                    <tr>
                        @foreach ($columnas as $columna)
                            <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-nowrap">
                                    {{ $venta->{$columna} }}
                                </p>
                            </td>
                        @endforeach
                        <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                            <span wire:click='set_ventaid({{$venta->id}})' class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
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