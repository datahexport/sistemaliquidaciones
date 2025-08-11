<div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
    @php
        $pesovariedad=0;
        $ventavariedad=0;
    @endphp
    @foreach ($despachosall as $detalle)
        @php
            $pesovariedad+=floatval($detalle->kg_liq);
            $ventavariedad+=floatval($detalle->Fob);
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

        <div class="ml-2">
            <h1>Registros S/Precio:</h1>
            <button class=" focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 text-sm leading-none text-gray-600 py-3 px-5 bg-gray-500 rounded hover:bg-gray-600 focus:outline-none">
                <h1 style="font-size: 1rem;white-space: nowrap;" class="text-center text-white font-bold inline w-full" >
                {{$despachosall->whereNull('Fob')->count()}}
                </h1>
            </button>
        </div>
        
        <div class="ml-2">
            <h1>Folios:</h1>
            <button class=" focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 text-sm leading-none text-gray-600 py-3 px-5 bg-gray-500 rounded hover:bg-gray-600 focus:outline-none">
                <h1 style="font-size: 1rem;white-space: nowrap;" class="text-center text-white font-bold inline w-full" >
                {{$unique_folios->count()}}
                </h1>
            </button>
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
    </div>
    <div class="flex mt-2">
        <div class="ml-4">
            Folio:<br>
            <select wire:model.live="filters.folio" name="" id="" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-40">
              <option value="">Todos</option>
              <option value="vacio">Sin Precio</option>
              @foreach ($unique_folios as $item)
                <option value="{{$item}}">{{$item}}</option>
              @endforeach
             
            </select>
          </div>

          <div class="ml-4">
            Variedad Real:<br>
            <select wire:model.live="filters.variedad" name="" id="" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-40">
                <option value="">Todos</option>
              @foreach ($unique_variedades as $item)
                <option value="{{$item}}">{{$item}}</option>
              @endforeach
             
            </select>
          </div>
          <div class="ml-4">
            Variedad Rotulada:<br>
            <select wire:model.live="filters.variedad2" name="" id="" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-40">
                <option value="">Todos</option>
              @foreach ($unique_variedades as $item)
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


          <div class="ml-4">
            Semana:<br>
            <select wire:model.live="filters.semana" name="" id="" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-40">
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
            <a href="{{Route('fobupdatedespacho.refresh',$temporada)}}">
                <button class="ml-2 focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 text-sm leading-none text-gray-600 py-3 px-5 bg-gray-500 rounded hover:bg-gray-600 focus:outline-none">
                    <h1 style="font-size: 1rem;white-space: nowrap;" class="text-center text-white font-bold inline w-full" >
                        Actualizar FOB
                    </h1>
                </button>
            </a>
               
            
        </div>
        <div class="ml-auto">
            <button x-on:click="upvariable=true" class="ml-2 focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 text-sm leading-none text-gray-600 py-3 px-5 bg-gray-500 rounded hover:bg-gray-600 focus:outline-none">
                <h1 style="font-size: 1rem;white-space: nowrap;" class="text-center text-white font-bold inline w-full" >
                    Subir Base Despachos
                </h1>
            </button>
            <button wire:click="destroy_all()" class="mt-2 ml-2 focus:ring-2 focus:ring-offset-2 focus:ring-red-300 text-sm leading-none text-red-600 py-3 px-5 bg-red-500 rounded hover:bg-red-600 focus:outline-none">
                <h1 style="font-size: 1rem;white-space: nowrap;" class="text-center text-white font-bold inline w-full" >
                    Eliminar Base Despacho
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
                    'Temporada',
                    'Estado',
                    'Packing',
                    'Folio',
                    'Fob',
                    'semana',
                    'Cajas_INICIAL',
                    'Dif_Cajas',
                    'Cajas',
                    'Cajas_Pallet',
                    'Kilos_prod',
                    'Dif_Kilos_proc',
                    'Kilos_prod',
                    'Kilos_emb',
                    'N_GuiaSII_Rec',
                    'N_lote',
                    'Peido',
                    'Fecha_Emb',
                    'Cliente',
                    'CSG',
                    'Csg_Rot',
                    'Nombre_Huerto',
                    'Nombre_CSG_Rot',
                    'Nombre_Productor',
                    'Etiqueta',
                    'C_Envase',
                    'Envase',
                    'Especie',
                    'Variedad_Real',
                    'Variedad_Rot',
                    'Categoria',
                    'Calidad',
                    'Calibre',
                    'Proceso',
                    'Tipo_Pallet',
                    'Base_Pallet',
                    'Altura',
                    'C_Packing',
                    'C_Variedad_real',
                    'C_Variedad_Rot',
                    'C_Categoria',
                    'C_Cliente',
                    'C_Etiqueta',
                    'C_Especie',
                    'C_Recibidor',
                    'C_Mercado',
                    'Nave',
                    'Fecha_Salida',
                    'Exportador',
                    'Mercado',
                    'Despacho',
                    'Folio_Sag',
                    'Fecha_despacho',
                    'Recibidor_comprador',
                    'Numero_Inspeccion',
                    'Fecha_Inspeccion',
                    'Estado_Inspeccion',
                    'Guia_sii',
                    'Contenedor',
                    'Peso_Neto',
                    'Peso_Bruto',
                    'Fecha_Digitacion',
                    'N_Reserva',
                    'Fecha_Reserva',
                    'Planta',
                    'planta_despacho',
                    'liquidado',
                    'liq_real',
                    'liquidacion_ajuste',
                    'venta',
                    'retorno_productor',
                    'kg_liq',
                    'fob2',
                    'npk',
                    'fob_x_caja',
                    'ajuste_kilos',
                    'ajuste_final',
                    'semana_proceso',
                    'variedad_real2',
                    'calibre_real2',
                    'productor_real',
                    'busqueda_proceso',
                    'observacion',
                    'cliente_china',
                    'transporte',
                    'mercado2',
                    'productor_facturacion',
                    'csg_fact',
                    'obs',
                    'unir_cad',
                    'caja_desp',
                    'comision',
                    'otros_costos',
                    'materiales',
                    'proceso2',
                    'tipo',
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
            @foreach ($despachos->reverse() as $masa)
                <tr>
                @foreach ($columnas as $columna)
                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                        @if ($columna=="Fob")
                            <p class="text-gray-900 whitespace-nowrap text-right">{{ number_format($masa->{$columna},2) }}</p>
                        @else
                            <p class="text-gray-900 whitespace-nowrap">{{ $masa->{$columna} }}</p>
                        @endif
                       
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