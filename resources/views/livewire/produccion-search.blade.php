<div>
    @php
        $totalotrosgastos= 0;
        $totalcuentacorriente= 0;
        $totalanticipos= 0;

        $sumaPropios = 0;
        $sumaNoPropios = 0;

    @endphp
   


    @if ($procesosall2->count()>1)
        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-4">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <div class="flex flex-col justify-center items-center">
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
                     
                        <div class="relative flex flex-col items-center rounded-[20px] max-w-7xl mx-auto bg-white bg-clip-border shadow-3xl shadow-lg  dark:!bg-navy-800 dark:text-white dark:!shadow-none p-3">
                          
                            <h4 class="px-2 text-xl font-bold text-navy-700 dark:text-white text-center my-4">
                                Base Producción
                                </h4>
                          
                            @php
                                $kilosprorrateados=0;
                                
                                $kilosprorrateadosexp=0;
                                $kilosprorrateadoscomercial=0;
                                $kilosprorrateadoscomercialembalada=0;

                                $nulos=0;
                                $ingresostotal=0;

                                $ingresostotal2=0;

                                $ingresosexp=0;
                                $ingresoscomemb=0;
                                $ingresoscomercial=0;

                                $ingresosexp2=0;
                                $ingresoscomemb2=0;
                                $ingresoscomercial2=0;

                                $totalmateriales=0;
                                $totalprocesos=0;
                                $peso2=0;
                                 $peso25=0;
                                 $peso5=0;
                                 $peso10=0;
                                 
                            @endphp
                            @foreach ($procesosall as $item)
                                @php
                                    $kilosprorrateados+=floatval($item->PESO_PRORRATEADO);

                                    if ($item->CRITERIO=="EXPORTACIÓN") {
                                        $kilosprorrateadosexp+=floatval($item->PESO_PRORRATEADO);
                                    } elseif($item->CRITERIO=="COMERCIAL") {
                                        $kilosprorrateadoscomercial+=floatval($item->PESO_PRORRATEADO);
                                    } elseif($item->CRITERIO=="COMERCIAL EMBALADA") {
                                        $kilosprorrateadoscomercialembalada+=floatval($item->PESO_PRORRATEADO);
                                    }

                                    if ($item->fob) {
                                        $tarifafinal=0;
                                        $tarifafinal2=0;
                                        if ($item->fob->tarifas->count()>0) {
                                            
                                                            $tarifafinal=$item->fob->tarifas->reverse()->first()->tarifa_fc;
                                                            $tarifafinal2=$item->fob->tarifas->reverse()->first()->tarifa;
                                        
                                        }

                                        $ingresostotal+=$item->fob->fob_kilo_salida*floatval($item->PESO_PRORRATEADO);

                                        if ($item->CRITERIO=="COMERCIAL") {
                                            $ingresostotal2+=$tarifafinal2*floatval($item->PESO_PRORRATEADO);
                                        } else {
                                            $ingresostotal2+=$tarifafinal*floatval($item->PESO_PRORRATEADO);
                                        }
                                        
                                       
                                       
                                      

                                        if ($item->CRITERIO=="EXPORTACIÓN") {
                                            $ingresosexp+=$item->fob->fob_kilo_salida*floatval($item->PESO_PRORRATEADO);
                                            $ingresosexp2+=$tarifafinal*floatval($item->PESO_PRORRATEADO);

                                        } elseif($item->CRITERIO=="COMERCIAL") {
                                            $ingresoscomercial+=$item->fob->fob_kilo_salida*floatval($item->PESO_PRORRATEADO);
                                            $ingresoscomercial2+=$tarifafinal2*floatval($item->PESO_PRORRATEADO);

                                        } elseif($item->CRITERIO=="COMERCIAL EMBALADA") {
                                            $ingresoscomemb+=$item->fob->fob_kilo_salida*floatval($item->PESO_PRORRATEADO);
                                            $ingresoscomemb2+=$tarifafinal*floatval($item->PESO_PRORRATEADO);

                                        }

                                    }else{
                                        $nulos+=1;
                                    }
                                @endphp


                                 @if ($item->PESO_CAJA=="2.2")
                                    @php
                                       
                                      $peso2+=$item->PESO_PRORRATEADO;
        
                                    @endphp
                                @elseif ($item->PESO_CAJA=="2.5")
                                    @php
                                      $peso25+=$item->PESO_PRORRATEADO;
        
                                    @endphp
                
                                @elseif ($item->PESO_CAJA=="5")
                                    @php
                                       $peso5+=$item->PESO_PRORRATEADO;
       
                                    @endphp
                
                                @elseif ($item->PESO_CAJA=="10")
                                    @php
                                        $peso10+=$item->PESO_PRORRATEADO;
      
                                    @endphp
                
                               
                                @endif

                                

                                @php
                                    // Buscar la razón social cuyo nombre coincida con PRODUCTOR_RECEP_FACTURACION del proceso
                                        $razon = $razons->firstWhere('name', $item->PRODUCTOR_RECEP_FACTURACION);

                                    // Si se encuentra la razón social correspondiente
                                    if ($razon) {
                                        // Verificar si la razón social es "propia"
                                        if ($razon->is_propio) {
                                            // Sumar el PESO_PRORRATEAD si es propio
                                            $sumaPropios += $item->anticipos;
                                        } else {
                                            // Sumar el PESO_PRORRATEAD si no es propio
                                            $sumaNoPropios += $item->anticipos;
                                        }
                                    }else{
                                        $sumaNoPropios += $item->anticipos;
                                    }
                                     $totalprocesos+=$item->costo_proceso;
                                     $totalmateriales+=$item->costo_materiales;
                                     $totalotrosgastos+=$item->otros_costos;
                                     $totalcuentacorriente+=$item->gastos;
                                      $totalanticipos+=$item->anticipos;

                                @endphp
                            @endforeach
                            <div class="grid grid-cols-7 gap-4 px-2 w-full">
                               
                             
                                <div class="flex flex-col justify-center rounded-2xl bg-clip-border px-3 py-4 border-2 bg-green-400 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                                    <p class="text-3xl font-bold text-gray-600 text-center">Kilos</p>
                                  
                                </div>
                               
                                <div class="flex flex-col justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 border-2 border-green-400 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                                    <p class="text-sm text-gray-600">Kilos Prorrateados Exportación</p>
                                    <p class="text-base font-medium text-navy-700 dark:text-white">
                                        {{number_format($kilosprorrateadosexp,2)}}
                                    </p>
                                </div>
                                <div class="flex flex-col justify-center rounded-2xl bg-white bg-clip-border px-3 border-2 border-green-400 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                                    <p class="text-sm text-gray-600">Kilos Prorrateados Comercial Embalada</p>
                                    <p class="text-base font-medium text-navy-700 dark:text-white">
                                        {{number_format($kilosprorrateadoscomercialembalada,2)}}
                                    </p>
                                </div>
                                <div class="flex flex-col justify-center rounded-2xl bg-white bg-clip-border px-3 border-2 border-green-400 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                                    <p class="text-sm text-gray-600">Kilos Prorrateados Comercial</p>
                                    <p class="text-base font-medium text-navy-700 dark:text-white">
                                        {{number_format($kilosprorrateadoscomercial,2)}}
                                    </p>
                                </div>
                              
                                <div class="flex flex-col justify-center rounded-2xl bg-white bg-clip-border px-3 border-2 border-red-400 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                                    <p class="text-sm text-gray-600">Kilos Prorrateados Totales</p>
                                    <p class="text-base font-medium text-navy-700 dark:text-white">
                                        {{number_format($kilosprorrateados,2)}}
                                    </p>
                                </div>

                               
                               
                                <div>
                                    
                                </div>
                                <div>

                                </div>

                                <div class="flex flex-col justify-center rounded-2xl bg-clip-border px-3 py-4 border-2 bg-yellow-400 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                                    <p class="text-3xl font-bold text-gray-600 text-center">Ingresos</p>
                                    <p class="text-xl font-bold text-gray-600 text-center">P.Inicial</p>
                                </div>

                                <div class="flex flex-col justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 border-2 border-yellow-400 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                                    <p class="text-sm text-gray-600">Ingresos Exportación</p>
                                    <p class="text-base font-medium text-navy-700 dark:text-white">
                                        {{number_format($ingresosexp,2)}}
                                    </p>
                                </div>
                                <div class="flex flex-col justify-center rounded-2xl bg-white bg-clip-border px-3 border-2 border-yellow-400 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                                    <p class="text-sm text-gray-600">Ingresos Comercial Embalada</p>
                                    <p class="text-base font-medium text-navy-700 dark:text-white">
                                        {{number_format($ingresoscomemb,2)}}
                                    </p>
                                </div>
                                <div class="flex flex-col justify-center rounded-2xl bg-white bg-clip-border px-3 border-2 border-yellow-400 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                                    <p class="text-sm text-gray-600">Ingresos Comercial</p>
                                    <p class="text-base font-medium text-navy-700 dark:text-white">
                                        {{number_format($ingresoscomercial,2)}}
                                    </p>
                                </div>
                               
                                <div class="flex flex-col justify-center rounded-2xl bg-white bg-clip-border px-3 border-2 border-red-400 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                                    <p class="text-sm text-gray-600">Ingresos Totales</p>
                                    <p class="text-base font-medium text-navy-700 dark:text-white">
                                        {{number_format($ingresostotal,2)}}
                                    </p>
                                </div>

                                <div>

                                </div>
                                <div>

                                </div>

                                <div class="flex flex-col justify-center rounded-2xl bg-clip-border px-3 py-4 border-2 bg-yellow-400 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                                    <p class="text-3xl font-bold text-gray-600 text-center">Ingresos</p>
                                    <p class="text-xl font-bold text-gray-600 text-center">P.Final</p>
                                </div>

                                <div class="flex flex-col justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 border-2 border-yellow-400 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                                    <p class="text-sm text-gray-600">Ingresos Exportación</p>
                                    <p class="text-base font-medium text-navy-700 dark:text-white">
                                        {{number_format($ingresosexp2,2)}}
                                    </p>
                                </div>
                                <div class="flex flex-col justify-center rounded-2xl bg-white bg-clip-border px-3 border-2 border-yellow-400 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                                    <p class="text-sm text-gray-600">Ingresos Comercial Embalada</p>
                                    <p class="text-base font-medium text-navy-700 dark:text-white">
                                        {{number_format($ingresoscomemb2,2)}}
                                    </p>
                                </div>
                                <div class="flex flex-col justify-center rounded-2xl bg-white bg-clip-border px-3 border-2 border-yellow-400 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                                    <p class="text-sm text-gray-600">Ingresos Comercial</p>
                                    <p class="text-base font-medium text-navy-700 dark:text-white">
                                        {{number_format($ingresoscomercial2,2)}}
                                    </p>
                                </div>
                               
                                <div class="flex flex-col justify-center rounded-2xl bg-white bg-clip-border px-3 border-2 border-red-400 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                                    <p class="text-sm text-gray-600">Ingresos Totales</p>
                                    <p class="text-base font-medium text-navy-700 dark:text-white">
                                        {{number_format($ingresostotal2,2)}}
                                    </p>
                                </div>

                                <div>

                                </div>
                                <div>

                                </div>
                                
                                <a href="{{route('temporada.costocaja',$temporada)}}" target="_blank" >
                                    <div class="flex flex-col justify-center rounded-2xl bg-clip-border px-3 py-4 border-2 bg-red-400 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                                        <p class="text-3xl font-bold text-gray-600 text-center">Costos</p>
                                    </div>
                                </a>
                                <a href="{{route('temporada.costocaja',$temporada)}}" target="_blank" >
                                    <div class="bg-orange-300 flex flex-col items-start justify-center rounded-2xl bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                                            <p class="text-sm text-gray-600">Procesos:</p>
                                            <p class="text-base font-medium text-navy-700 dark:text-white">
                                                {{number_format($totalprocesos,2)}}
                                            </p>
                                    </div>
                                </a>
                                <a href="{{route('temporada.costocaja',$temporada)}}" target="_blank" >
                                    <div class="flex flex-col items-start justify-center rounded-2xl bg-green-300 bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                                        <p class="text-sm text-gray-600">Materiales:</p>
                                        <p class="text-base font-medium text-navy-700 dark:text-white">
                                            {{number_format($totalmateriales,2)}}
                                        </p>
                                    </div>
                                </a>
                                <a href="{{route('temporada.costocaja',$temporada)}}" target="_blank" >
                                    <div class="flex flex-col items-start justify-center rounded-2xl bg-red-300 bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                                        <p class="text-sm text-gray-600">Otros Gastos:</p>
                                        <p class="text-base font-medium text-navy-700 dark:text-white">
                                            {{number_format($totalotrosgastos,2)}}
                                        </p>
                                    </div>
                                </a>

                                <div class="flex flex-col items-start justify-center rounded-2xl border-2 border-red-400 bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                                    <p class="text-sm text-gray-600">Total Costo <br> General:</p>
                                    <p class="text-base font-medium text-navy-700 dark:text-white">
                                        {{number_format($totalotrosgastos+$totalprocesos+$totalmateriales,2)}}
                                    </p>
                                </div>
                                <div class="flex flex-col items-start justify-center rounded-2xl border-2 border-red-400 bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                                    <p class="text-sm text-gray-600">Total Costo <br> Diferencial :</p>
                                    <p class="text-xs text-gray-400">(Columna 'Costo')</p>
                                    
                                    <p class="text-base font-medium text-navy-700 dark:text-white">
                                        {{number_format($procesosall->sum('costo'),2)}}
                                    </p>
                                </div>

                                <div class="flex flex-col items-start justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                                    <p class="text-sm text-gray-600">Ingresos Neto:</p>
                                    <p class="text-base font-medium text-navy-700 dark:text-white">
                                        {{number_format($ingresostotal-$totalotrosgastos-$totalprocesos-$totalmateriales,2)}}
                                    </p>
                                </div>

                              

                                <a href="{{route('temporada.datauploadcuentacorriente',$temporada)}}" target="_blank" >
                                    <div class="flex flex-col justify-center rounded-2xl bg-clip-border px-3 py-4 border-2 bg-red-400 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                                        <p class="text-3xl font-bold text-gray-600 text-center">Gastos</p>
                                    </div>
                                </a>
                               

                                <a href="{{route('temporada.datauploadcuentacorriente',$temporada)}}" target="_blank" >
                                    <div class="flex flex-col items-start justify-center rounded-2xl bg-gray-300 bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                                        <p class="text-sm text-gray-600">Cuenta Corriente:</p>
                                        <p class="text-base font-medium text-navy-700 dark:text-white">
                                            {{number_format($totalcuentacorriente,2)}}
                                        </p>
                                    </div>
                                </a>
                                <div>

                                </div>
                               <div>
                                
                               </div>

                                <div class="flex flex-col items-start justify-center rounded-2xl border-2 border-red-400 bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                                    <p class="text-sm text-gray-600">Total Gastos:</p>
                                    <p class="text-base font-medium text-navy-700 dark:text-white">
                                        {{number_format($totalcuentacorriente,2)}}
                                    </p>
                                </div>
                                
                              

                                <div>
                                    
                                </div>

                                <div>

                                </div>

                                
                                <a href="{{route('temporada.anticipos',$temporada)}}" target="_blank" >
                                    <div class="flex flex-col justify-center rounded-2xl bg-clip-border px-3 py-4 border-2 bg-red-400 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                                        <p class="text-3xl font-bold text-gray-600 text-center">Anticipos</p>
                                    </div>
                                </a>
                 
                                <a href="{{route('temporada.anticipos',$temporada)}}" target="_blank" >
                                    <div class="flex flex-col items-start justify-center rounded-2xl bg-gray-300 bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                                        <p class="text-sm text-gray-600">Huertos Propios:</p>
                                        <p class="text-base font-medium text-navy-700 dark:text-white">
                                            {{number_format($sumaPropios,2)}}
                                        </p>
                                    </div>
                                </a>
                                <a href="{{route('temporada.anticipos',$temporada)}}" target="_blank" >
                                    <div class="flex flex-col items-start justify-center rounded-2xl bg-gray-300 bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                                        <p class="text-sm text-gray-600">Huertos Externos:</p>
                                        <p class="text-base font-medium text-navy-700 dark:text-white">
                                            {{number_format($sumaNoPropios,2)}}
                                        </p>
                                    </div>
                                </a>
                               <div>
                                
                               </div>
                               
                                <div class="flex flex-col items-start justify-center rounded-2xl border-2 border-red-400 bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                                    <p class="text-sm text-gray-600">Total Anticipos:</p>
                                    <p class="text-base font-medium text-navy-700 dark:text-white">
                                        {{number_format($sumaPropios+$sumaNoPropios,2)}}
                                    </p>
                                </div>
                                
                              

                                <div>
                                    
                                </div>

                                <div>

                                </div>
                                
                                <div class="flex flex-col items-start justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                                        <p class="text-sm text-gray-600">Comisión 1:</p>
                                        <p class="text-base font-medium text-navy-700 dark:text-white">
                                            {{number_format($ingresosexp*0.08,2)}}
                                        </p>
                                    </div>

                                <div class="flex flex-col items-start justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                                        <p class="text-sm text-gray-600">Precio Liquidación 1:</p>
                                        <p class="text-base font-medium text-navy-700 dark:text-white">
                                            {{number_format(($ingresostotal-$totalotrosgastos-$totalprocesos-$totalmateriales)-$ingresosexp*0.08,2)}}
                                        </p>
                                    </div>

                                <div class="flex flex-col items-start justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                                    <p class="text-sm text-gray-600">RNP Promedio:</p>
                                    <p class="text-base font-medium text-navy-700 dark:text-white">
                                        @if (($kilosprorrateadosexp+$kilosprorrateadoscomercialembalada)>0)
                                            {{number_format(($ingresostotal-$totalotrosgastos-$totalprocesos-$totalmateriales-$ingresosexp*0.08)/($kilosprorrateadosexp+$kilosprorrateadoscomercialembalada),2)}}
                                        @else
                                            0
                                        @endif
                                    </p>
                                </div>
                                <div class="flex flex-col items-start justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                                    <p class="text-sm text-gray-600">Kilo Huaso:</p>
                                    <p class="text-base font-medium text-navy-700 dark:text-white">
                                        @if ($kilosprorrateados>0)
                                            {{number_format(($ingresostotal-$totalotrosgastos-$totalprocesos-$totalmateriales-$ingresosexp*0.08)/$kilosprorrateados,2)}}
                                        @endif
                                    </p>
                                </div>

                               
            
                                <div class="flex col-span-2 justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                                    <div class="mr-2">
                                        <a href="{{Route('preciofob.refresh2',$temporada)}}">
                                            <x-button>
                                            Actualizar PRECIO FOB <br>EXPORTACIÓN
                                            </x-button>
                                        </a>
                                    </div>
                                    <div>
                                        <a href="{{Route('preciofob.refresh3',$temporada)}}">
                                            <x-button>
                                            Actualizar PRECIO FOB <br>COMERCIAL
                                            </x-button>
                                        </a>
                                    </div>
                                </div>

                                <div class="flex flex-col items-start justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                                    <p class="text-sm text-gray-600">Registros Sin precio:</p>
                                    <p class="text-base font-medium text-navy-700 dark:text-white">
                                        {{number_format($nulos)}} / {{number_format($procesosall->count())}}
                                    </p>
                                </div>

                                <div class="flex flex-col items-start justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                                    <p class="text-sm text-gray-600">Comisión 2:</p>
                                    <p class="text-base font-medium text-navy-700 dark:text-white">
                                        {{number_format($ingresosexp2*0.08,2)}}
                                    </p>
                                </div>

                                <div class="flex flex-col items-start justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                                        <p class="text-sm text-gray-600">Precio Liquidación 2:</p>
                                        <p class="text-base font-medium text-navy-700 dark:text-white">
                                            {{number_format(($ingresostotal2-$totalotrosgastos-$totalprocesos-$totalmateriales)-$ingresosexp2*0.08,2)}}
                                        </p>
                                    </div>

                                <div class="flex flex-col items-start justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                                    <p class="text-sm text-gray-600">RNP Promedio:</p>
                                    <p class="text-base font-medium text-navy-700 dark:text-white">
                                        @if (($kilosprorrateadosexp+$kilosprorrateadoscomercialembalada)>0)
                                            {{number_format(($ingresostotal2-$totalotrosgastos-$totalprocesos-$totalmateriales-$ingresosexp2*0.08)/($kilosprorrateadosexp+$kilosprorrateadoscomercialembalada),2)}}
                                        @else
                                            0    
                                        @endif
                                    </p>
                                </div>
                                <div class="flex flex-col items-start justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                                    <p class="text-sm text-gray-600">Kilo Huaso:</p>
                                    <p class="text-base font-medium text-navy-700 dark:text-white">
                                        @if ($kilosprorrateados>0)
                                            {{number_format((($ingresostotal2-$totalotrosgastos-$totalprocesos-$totalmateriales)-$ingresosexp2*0.08)/$kilosprorrateados,2)}}
                                        @endif
                                    </p>
                                </div>
            
                            </div>

                            <div class="mt-2 mb-2 w-full">
                              
                                <p class="mt-2 px-2 text-base text-gray-600">
                                As we live, our hearts turn colder. Cause pain is what we go through
                                as we become older. We get insulted by others, lose trust for those
                                others. We get back stabbed by friends. It becomes harder for us to
                                give others a hand. We get our heart broken by people we love, even
                                that we give them all...
                                </p>
                                <div class="flex justify-center">
                                    <form action="{{route('temporada.importProceso')}}"
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
                            </div> 

                        </div>  
                    </div>

                    <div class="bg-gray-100 rounded px-2 md:p-8 shadow mb-6">
                        <h2 @click.on="openMenu = 1"  class="hidden cursor-pointer text-xs text-blue-500 font-semibold mb-4"><-Abrir Menu</h2>
                
                            <div wire:loading wire:target="filters">
                    
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

                        <h2 class="text-2xl font-semibold my-4">Filtros 
                
                
                    
                           
                            
                     
                
                    
                        @php
                            $kgstotmas=0;
                        @endphp
                        @foreach ($procesosall as $masa)
                            @php
                                $kgstotmas+=$masa->PESO_PRORRATEADO;
                            @endphp
                        @endforeach
                    
                        
                        
                            ({{(number_format($procesosall->count()))}} Resultados) ({{number_format($kgstotmas)}} KGS)
                        
                    
                        </h2>
                
                        <div class="mb-4">
                            Productor/Csg
                            <x-input wire:model.live="filters.razonsocial" type="text" class="w-full" />
                            @if ($filters['razonsocial'])
                            <ul class="relative z-1 left-0 w-full bg-white mt-1 rounded-lg overflow-hidden px-4">
                                {{-- comment
                                @forelse ($this->users as $objet)
                                    <li wire:click='set_productorid({{$objet->id}})' class="leading-10 px-5 text-sm cursor-pointer hover:bg-gray-300">
                                        <p>{{$objet->name}}-{{$objet->rut}}-{{$objet->csg}}</p>
                                    </li>
                                    @empty
                                @endforelse --}}
                            </ul>
                            @endif
                        </div>
                
                        <div class="mb-4 grid grid-cols-4 md:grid-cols-6">
                          
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
                        
                     
                
                
                    </div>
                    {{-- comment    --}}
                        <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
                            <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                                <table class="min-w-full leading-normal">
                                    <thead>
                                    <tr>
                                        @php
                                        $columnas = [
                                            'PROCESO',
                                            'TURNO',
                                            'PLANTA',
                                            'FECHA',
                                            'PRODUCTOR_RECEP_FACTURACION',
                                            'VARIEDAD',
                                            'ENVASES_ETIQ',
                                            'COLOR',
                                            'CALIBRE',
                                            'CALIBRE_REAL',
                                            'CANT',
                                            'PESO_FINAL',
                                            'PESO_PRORRATEADO',
                                            'KG_VACIADO',
                                            'PESO_CAJA',
                                            'TIPO_CAJA',
                                            'CAJA_EQ_5KG',
                                            'TIPO',
                                            'CRITERIO',
                                            'COLOR_FINAL',
                                            'BUSQUEDA_PROCESO',
                                            'EXPORTADORA',
                                            'NORMA',
                                            'SEMANA'
                                        ];
                                        foreach ($columnas as $columna) {
                                            echo '<th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase whitespace-no-wrap">';
                                            echo ucfirst(str_replace('_', ' ', $columna));
                                            echo '</th>';
                                        }
                                        @endphp

                                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase whitespace-no-wrap">
                                            Liquidación
                                        </th>
                                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase whitespace-no-wrap">
                                            Liquidación final
                                        </th>
                                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-red-100 text-left text-xs font-semibold text-gray-600 uppercase whitespace-no-wrap">
                                             COSTO
                                        </th>
                                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-red-100 text-left text-xs font-semibold text-gray-600 uppercase whitespace-no-wrap">
                                            CAJA DIFERENCIAL
                                        </th>
                                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-red-100 text-left text-xs font-semibold text-gray-600 uppercase whitespace-no-wrap">
                                            Otros Gastos
                                        </th>
                                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-red-100 text-left text-xs font-semibold text-gray-600 uppercase whitespace-no-wrap">
                                            Costo Proceso
                                        </th>
                                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-red-100 text-left text-xs font-semibold text-gray-600 uppercase whitespace-no-wrap">
                                            Costo Materiales
                                        </th>
                                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase whitespace-no-wrap">
                                            Gastos
                                        </th>
                                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase whitespace-no-wrap">
                                            RNP
                                        </th>
                                    

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($procesos as $masa)
                                        <tr>
                                        @foreach ($columnas as $columna)
                                            <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                            <p class="text-gray-900 whitespace-nowrap">{{ $masa->{$columna} }}</p>
                                            </td>
                                        @endforeach
                                        <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                        
                                            <p class="text-gray-900 whitespace-no-wrap">
                                                @if ($masa->fob)
                                                    {{ number_format(($masa->fob->fob_kilo_salida*floatval($masa->PESO_PRORRATEADO))*0.92-$masa->costo,2)}}
                                                @endif
                                            </p>
                                        
                                        </td>
                                        <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                        
                                            <p class="text-gray-900 whitespace-no-wrap">
                                                @if ($masa->fob)
                                                    @if ($item->fob->tarifas->count()>0) 
                                                        {{ number_format((($masa->fob->tarifas->reverse()->first()->tarifa_fc*floatval($masa->PESO_PRORRATEADO))*0.92-$masa->costo),2)}}
                                                    @endif
                                                @endif
                                            </p>
                                        
                                        </td>
                                        <td class="px-5 py-2 border-b border-gray-200 bg-red-100 text-sm">
                                        
                                            <p class="text-gray-900 whitespace-no-wrap">
                                                
                                                {{number_format($masa->costo,2)}}
                                            
                                            </p>
                                        
                                        </td>
                                        <td class="px-5 py-2 border-b border-gray-200 bg-red-100 text-sm">
                                        
                                            <p class="text-gray-900 whitespace-no-wrap">
                                                
                                                {{number_format($masa->costo_proceso+$masa->costo_materiales+$masa->otros_costos,2)}}
                                            
                                            </p>
                                        
                                        </td>
                                        <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                        
                                            <p class="text-gray-900 whitespace-no-wrap">
                                                    {{ number_format($masa->otros_costos,2)}}
                                                
                                            </p>
                                        
                                        </td>
                                        <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                        
                                            <p class="text-gray-900 whitespace-no-wrap">
                                                
                                                {{number_format($masa->costo_proceso,2)}}
                                            
                                            </p>
                                        
                                        </td>
                                        <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                        
                                            <p class="text-gray-900 whitespace-no-wrap">
                                                {{number_format($masa->costo_materiales,2)}}
                                            </p>
                                        
                                        </td>

                                        <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                        
                                            <p class="text-gray-900 whitespace-no-wrap">
                                                {{number_format($masa->gastos,2)}}
                                            </p>
                                        
                                        </td>
                                    

                                        <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                        
                                            <p class="text-gray-900 whitespace-no-wrap">

                                                @if ($masa->fob)
                                                    @if ($masa->PESO_CAJA=="2.2")
                                                    
                                                    {{number_format($masa->fob->fob_kilo_salida*floatval($masa->PESO_PRORRATEADO)-($totalotrosgastos*floatval($masa->PESO_PRORRATEADO)/($peso2+$peso25+$peso5+$peso10))-($masa->PESO_PRORRATEADO*$temporada->materiales22)-$masa->PESO_PRORRATEADO*$temporada->proceso22,2)}}
                                                        
                                                    @elseif ($masa->PESO_CAJA=="2.5")
                                                        {{number_format($masa->fob->fob_kilo_salida*floatval($masa->PESO_PRORRATEADO)-($totalotrosgastos*floatval($masa->PESO_PRORRATEADO)/($peso2+$peso25+$peso5+$peso10))-($masa->PESO_PRORRATEADO*$temporada->materiales25)-$masa->PESO_PRORRATEADO*$temporada->proceso25,2)}}

                                                    @elseif ($masa->PESO_CAJA=="5")
                                                        {{number_format($masa->fob->fob_kilo_salida*floatval($masa->PESO_PRORRATEADO)-($totalotrosgastos*floatval($masa->PESO_PRORRATEADO)/($peso2+$peso25+$peso5+$peso10))-($masa->PESO_PRORRATEADO*$temporada->materiales5)-$masa->PESO_PRORRATEADO*$temporada->proceso5,2)}}

                                                    @elseif ($masa->PESO_CAJA=="10")
                                                        {{number_format($masa->fob->fob_kilo_salida*floatval($masa->PESO_PRORRATEADO)-($totalotrosgastos*floatval($masa->PESO_PRORRATEADO)/($peso2+$peso25+$peso5+$peso10))-($masa->PESO_PRORRATEADO*$temporada->materiales10)-$masa->PESO_PRORRATEADO*$temporada->proceso10,2)}}
                                                
                                                    @endif
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
                


                </div>
            </div>
        </div>
    @else
        <div class="flex flex-col justify-center items-center h-[100vh]">
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
            <div class="relative flex flex-col items-center rounded-[20px] w-[700px] max-w-[95%] mx-auto bg-white bg-clip-border shadow-3xl shadow-lg  dark:!bg-navy-800 dark:text-white dark:!shadow-none p-3">
                <div class="mt-2 mb-2 w-full">
                    <h4 class="px-2 text-xl font-bold text-navy-700 dark:text-white">
                        Base Producción
                    </h4>
                    <p class="mt-2 px-2 text-base text-gray-600">
                    As we live, our hearts turn colder. Cause pain is what we go through
                    as we become older. We get insulted by others, lose trust for those
                    others. We get back stabbed by friends. It becomes harder for us to
                    give others a hand. We get our heart broken by people we love, even
                    that we give them all...
                    </p>
                </div> 
                <div class="">
                    <form action="{{route('temporada.importProceso')}}"
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
                <div class="grid grid-cols-2 gap-4 px-2 w-full">
                    <div class="flex flex-col items-start justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                    <p class="text-sm text-gray-600">Education</p>
                    <p class="text-base font-medium text-navy-700 dark:text-white">
                        Stanford University
                    </p>
                    </div>

                    <div class="flex flex-col justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                    <p class="text-sm text-gray-600">Languages</p>
                    <p class="text-base font-medium text-navy-700 dark:text-white">
                        English, Spanish, Italian
                    </p>
                    </div>

                    <div class="flex flex-col items-start justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                    <p class="text-sm text-gray-600">Department</p>
                    <p class="text-base font-medium text-navy-700 dark:text-white">
                        Product Design
                    </p>
                    </div>

                    <div class="flex flex-col justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                    <p class="text-sm text-gray-600">Work History</p>
                    <p class="text-base font-medium text-navy-700 dark:text-white">
                        English, Spanish, Italian
                    </p>
                    </div>

                    <div class="flex flex-col items-start justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                    <p class="text-sm text-gray-600">Organization</p>
                    <p class="text-base font-medium text-navy-700 dark:text-white">
                        Simmmple Web LLC
                    </p>
                    </div>

                    <div class="flex flex-col justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                    <p class="text-sm text-gray-600">Birthday</p>
                    <p class="text-base font-medium text-navy-700 dark:text-white">
                        20 July 1986
                    </p>
                    </div>
                </div>
            </div>  
            <p class="font-normal text-navy-700 mt-20 mx-auto w-max">Profile Card component from <a href="https://horizon-ui.com?ref=tailwindcomponents.com" target="_blank" class="text-brand-500 font-bold">Horizon UI Tailwind React</a></p>  
        </div>
    @endif
</div>
