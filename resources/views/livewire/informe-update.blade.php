<div class="mt-4 space-y-2 px-8">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

    @if (session()->has('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if (session()->has('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif


    <div class="flex justify-end">
      
      <x-button 
          x-data 
          @click="
              Swal.fire({
                  title: 'Crear un nuevo informe',
                  text: '¿Deseas continuar?',
                  icon: 'question',
                  showCancelButton: true,
                  confirmButtonText: 'Sí, crear',
                  cancelButtonText: 'Cancelar',
                  confirmButtonColor: '#28a745',
                  cancelButtonColor: '#d33'
              }).then((result) => {
                  if (result.isConfirmed) {
                      $wire.crearInforme();
                      Swal.fire({
                          icon: 'success',
                          title: 'Creado',
                          text: 'El informe ha sido creado correctamente.',
                          showConfirmButton: false,
                          timer: 1500
                      });
                  }
              })
          ">
          Nuevo
      </x-button>
  
  
    </div>
    @php
        $counter=$razonsocial->informes->where('temporada_id',$temporada->id)->count();
        $n=0
    @endphp

    @foreach ($razonsocial->informes->where('temporada_id',$temporada->id)->reverse() as $informe)

      @php
        $kgrazon=0;
        $ventasrazon_dentrodenorma=0;
        $costosrazon_dentrodenorma=0;
        $margenrazon_dentrodenorma=0;

        $ventasrazon_fueradenorma=0;
        $costosrazon_fueradenorma=0;
        $margenrazon_fueradenorma=0;
        $ventasrazon_mercadointerno=0;
        $costosrazon_mercadointerno=0;
        $margenrazon_mercadointerno=0;
        
        $venta2srazon=0;
        $venta3srazon=0;
        $ventasrazon2=0;
        

        $costocomercial=0;

        $costo2srazon=0;
       
        $gastosrazon=0;
        $anticiposrazon=0;

    
      
    

      @endphp

 
      @php
            $name=$razonsocial->name;
      @endphp

      <div wire:loading wire:target="set_informe_edit, set_modification, saveOrUpdateModification, retorno, npk, set_informe_oficial">
                              
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
               
                  if (in_array($item->CALIBRE_REAL, ['4J', '3J', '2J', 'J', 'XL'])) {
                    $ventasrazon_dentrodenorma += floatval($tarifafinal3 * $peso);
                    $costosrazon_dentrodenorma += floatval($item->costo);
                    $margenrazon_dentrodenorma += floatval($tarifafinal3 * $peso*0.08);
                  }elseif (in_array($item->CALIBRE_REAL, ['L'])) {
                    $ventasrazon_fueradenorma += floatval($tarifafinal3 * $peso);
                    $costosrazon_fueradenorma += floatval($item->costo);
                    $margenrazon_fueradenorma += floatval($tarifafinal3 * $peso*0.08);
                  } elseif (in_array($item->CALIBRE_REAL, ['JUP'])) {
                    $ventasrazon_mercadointerno += floatval($tarifafinal3 * $peso);
                    $costosrazon_mercadointerno += floatval($item->costo);
                  }
                  
                
                if ($item->CRITERIO=="EXPORTACIÓN" || $item->CRITERIO=="COMERCIAL EMBALADA") {
                  //$ventatotalaliquidar+= floatval($tarifaAplicada * $peso);
                  //$venta2totalaliquidar+= floatval($tarifafinal3 * $peso);
                }

                if ($item->CRITERIO=="COMERCIAL") {
                  $venta3srazon += floatval($tarifaAplicada * $peso);
                  $venta3totalaliquidar += floatval($tarifaAplicada * $peso);
                }
                

                if ($item->CRITERIO=="EXPORTACIÓN") {
                 
                  $margentotalaliquidar += floatval($tarifafinal3 * $peso*0.08);
                }
              }

              if ($item->CRITERIO=="COMERCIAL") {
                //$costo2srazon += floatval($item->costo_proceso);
                //$costo2totalaliquidar += floatval($item->costo_proceso);
              }

              //$costosrazon_dentrodenorma += floatval($item->costo_proceso+$item->costo_materiales+$item->otros_costos);
              $costototalaliquidar += floatval($item->costo_proceso+$item->costo_materiales+$item->otros_costos);

              
              $costo2totalaliquidar += floatval($item->costo);
              
              $kgrazon += floatval($item->PESO_PRORRATEADO);
              $gastosrazon += floatval($item->gastos);
              $gastototalaliquidar += floatval($item->gastos);
            
              $anticiposrazon += floatval($item->anticipos);
              $anticipototalaliquidar += floatval($item->anticipos);

             
            @endphp
      
      @endforeach
      @php

          $totaldentrodenorma=$ventasrazon_dentrodenorma-$costosrazon_dentrodenorma-$margenrazon_dentrodenorma;
          $totalfueradenorma=$ventasrazon_fueradenorma-$costosrazon_fueradenorma-$margenrazon_fueradenorma;
          $totalmercadointerno=$ventasrazon_mercadointerno-$costosrazon_mercadointerno;
          //$aliquidar=$venta2srazon+$venta3srazon-$costo2srazon-$margenrazon-$gastosrazon;
          $aliquidar=$totaldentrodenorma+$totalfueradenorma+$totalmercadointerno;

          // $totalaliquidar+=$aliquidar;
      @endphp
        

      <div @if($informe_edit->id!=$informe->id) wire:click='set_informe_edit({{$informe->id}})' @endif class="flex items-center justify-between w-full px-8 py-4 mx-auto border rounded-xl dark:border-gray-700 @if($informe_edit->id==$informe->id) bg-gray-200 @else  @endif hover:bg-gray-200">
          <div class="flex items-center justify-between">
              <span @if($informe_edit->id==$informe->id) wire:click='set_informe_oficial({{$informe->id}})' @endif class="flex-col text-center justify-center cursor-pointer">
                <svg  xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mx-auto @if($informe->oficial=='si')text-green-400 @else text-yellow-400 cursor-pointer @endif sm:h-9 sm:w-9" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                @if ($informe->oficial=='si')
                    OFICIAL
                @elseif($informe_edit->id==$informe->id)
                    SET
                @endif
              </span>

              <div class="flex flex-col items-center mx-5 mr-12">
                <div x-data="{ isEditing: false, totalLiquidado: '{{ number_format(floatval($informe->total_liquidado)+$aliquidar)}}', diferenciaTipoCambio: '{{ $informe->diferencia_tipodecambio ?? '-' }}' }" 
                  class="flex items-center mx-5 mr-12">
               <!-- Título del informe -->
               <div>
                <h2 class="text-lg font-medium text-gray-700 sm:text-2xl dark:text-gray-200 whitespace-nowrap">
                  Informe {{$counter-$n}}
                </h2>
              
                <!-- Botones de acción -->
                <div class="flex">
                  @if($informe_edit->id==$informe->id)
                    <button x-show="!isEditing" @click="isEditing = true" 
                            class="bg-blue-900 p-1 mr-2 rounded-lg text-xs text-white">
                      Editar
                    </button>
                    
                    <button class="bg-red-500 p-1 rounded-lg text-xs text-white"
                            x-data 
                            @click="
                                Swal.fire({
                                    title: '¿Estás seguro?',
                                    text: 'Esta acción no se puede deshacer.',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonText: 'Sí, eliminar',
                                    cancelButtonText: 'Cancelar',
                                    confirmButtonColor: '#d33',
                                    cancelButtonColor: '#3085d6'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        $wire.eliminarInforme({{ $informe->id }});
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Eliminado',
                                            text: 'El informe ha sido eliminado.',
                                            showConfirmButton: false,
                                            timer: 1500
                                        });
                                    }
                                })
                            ">
                      Eliminar
                    </button>
                  @endif
                </div>
                <div x-show="isEditing" class="flex space-x-2 mt-2">
                  <button @click="
                      isEditing = false; 
                      $wire.guardarCambios({ id: {{ $informe->id }}, total_liquidado: totalLiquidado, diferencia_tipodecambio: diferenciaTipoCambio }).then(() => {
                          Swal.fire({
                              icon: 'success',
                              title: 'Actualizado',
                              text: 'El informe ha sido actualizado correctamente.',
                              showConfirmButton: false,
                              timer: 1500
                          });
                      }).catch((error) => {
                          Swal.fire({
                              icon: 'error',
                              title: 'Error',
                              text: 'Hubo un problema al actualizar el informe.',
                              showConfirmButton: false,
                              timer: 1500
                          });
                      });
                        " class="bg-green-500 text-white px-3 py-1 rounded-md text-xs">
                      Guardar
                  </button>
              
                  <button @click="isEditing = false" 
                          class="bg-gray-500 text-white px-3 py-1 rounded-md text-xs">
                    Cancelar
                  </button>
                </div>
                </div>
                @php
                    $n+=1;
                @endphp
             
               <!-- Campos en modo edición -->
               <div x-show="isEditing" class="space-x-2 my-auto flex ml-6">
                 <div>
                   <label class="text-sm font-medium text-gray-700 dark:text-gray-200">Total Liquidado:</label>
                   <input x-model="totalLiquidado" 
                          type="text" 
                          class="border rounded-md px-2 py-1" />
                 </div>
                 <div>
                   <label class="text-sm font-medium text-gray-700 dark:text-gray-200">Diferencia Tipo de Cambio:</label>
                   <input x-model="diferenciaTipoCambio" 
                          type="text" 
                          class="border rounded-md px-2 py-1" />
                 </div>
                 
               </div>
             
               <!-- Modo visualización -->
               <div x-show="!isEditing" class="mt-4 flex">
                  <div class="flex flex-col items-center mx-5 space-y-1 mr-2">
                    <h2 class="text-lg font-medium text-gray-700 sm:text-2xl dark:text-gray-200 @if(!IS_NULL($informe->total_liquidado))line-through @endif">
                      {{ number_format($aliquidar,2,',','.') }}
                    </h2>
                    <h2 class="text-md font-medium text-gray-700 dark:text-gray-200">Liquidado<br>Informe</h2>
                  </div>
                 <div class="flex flex-col items-center mx-5 space-y-1 mr-2">
                   <h2 class="text-lg font-medium text-gray-700 sm:text-2xl dark:text-gray-200">
                    @if (!IS_NULL($informe->total_liquidado))
                      {{  number_format(floatval($informe->total_liquidado)+$aliquidar,2,',','.') }}
                    @else
                      -
                    @endif
                    
                   </h2>
                   <h2 class="text-md font-medium text-gray-700 dark:text-gray-200 whitespace-nowrap text-center">Liquidado<br>
                    Agregar Modificaciones
                  </h2>
                 </div>
                 <div class="flex flex-col items-center mx-5 space-y-1 mr-2">
                   <h2 class="text-lg font-medium text-gray-700 sm:text-2xl dark:text-gray-200">
                     {{ $informe->diferencia_tipodecambio ?? '-' }}
                   </h2>
                   <h2 class="text-sm font-medium text-gray-700 dark:text-gray-200 whitespace-nowrap">
                     Dif. Tipo de Cambio
                   </h2>
                 </div>
               </div>

             </div>
            </div>
             
             
             

             
              
          </div>

          <div class="flex flex-col items-center mx-5 space-y-1 ml-auto">
                
            @if ($informe->informe)
              <a href="{{ route('informe.download', $informe) }}" target="_blank" class="h-10 mr-2 items-center content-center">
                <img class="h-10 object-contain mx-auto mb-2" src="{{ asset('image/pdf_icon2.png') }}" title="Descargar" alt="">
              </a>
              <a href="{{route('exportpdff',['informe' => $informe])}}" target="_blank" class="text-xs">
                <x-button>
                  ReGenerar
                  Informe
                </x-button>
              </a>
            @else
              <a href="{{route('exportpdff',['informe' => $informe])}}" target="_blank">
                <x-button>
                  Generar
                  Informe
                </x-button>
              </a>
            @endif
          
            <div class="hidden px-2 text-xs text-blue-500 bg-gray-100 rounded-full sm:px-4 sm:py-1 dark:bg-gray-700 whitespace-nowrap">
                Informe de Temporada
            </div>
          </div>

          <div class="flex flex-col items-center mx-5 space-y-1 mr-12 justify-end">
               
            @if ($informe->nota)
              <a href="{{ route('informe.download2', $informe) }}" target="_blank" class="h-10 mr-2 items-center content-center">
                <img class="h-10 object-contain mx-auto mb-2" src="{{ asset('image/pdf_icon2.png') }}" title="Descargar" alt="">
              </a>
              <a href="{{route('exportpdff2',['informe' => $informe])}}" target="_blank" class="text-xs">
                <x-button>
                ReGenerar
                  NC/ND
                </x-button>
              </a>
            @else
              <a href="{{route('exportpdff2',['informe' => $informe])}}" target="_blank">
                <x-button>
                  Generar
                  NC/ND
                </x-button>
              </a>
            @endif
            <div class="hidden px-2 text-xs text-blue-500 bg-gray-100 rounded-full sm:px-4 sm:py-1 dark:bg-gray-700 whitespace-nowrap">
                Nota debito
            </div>
          </div>

          
          <div class="flex items-center justify-end hidden"> 
            <h2 class="text-2xl items-center font-semibold text-gray-500 sm:text-4xl dark:text-gray-300">ND: </h2><span class="text-base font-medium my-auto items-center ml-2"> 153.135 </span>
          </div>
      </div>
      
    @endforeach

    

    <div class="flex flex-col">
      <div class="overflow-x-auto sm:mx-0.5 lg:mx-0.5">
        <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
       


          @if (session()->has('success'))
            <div class="alert alert-success mt-2">
                {{ session('success') }}
            </div>
        @endif
            
            <h1 class="mt-6 text-xl font-bold text-right">
             0  Modificaciones
            </h1>

          @if ($informe_edit)
              
            <table id="balance" style="width:100%; border-collapse: collapse; margin-top: 20px;">
              <thead style="border-top: 2px solid black; border-bottom: 2px solid black;">
                <tr>
                <th>Norma</th>
                <th>Variedad</th>
                <th>Calibre</th>
                <th>Kg Embalado</th>
                
                <th>Ingresos</th>
                <th>Comision</th>
                <th>Costo</th>
               
                <th>Retorno Neto Productor</th>
                <th>NPK</th>
                <th>Modificaciones</th>

                </tr>
              </thead>
              <tbody>
                <tr style="background-color: #ddd;">
                        
                    <td> DENTRO DE NORMA </td>
                
                
                    <td> </td>
                  
                  <td></td>
                  
                  <td></td>
                  <td></td>
                  <td></td>
                  <td ></td>
                  <td></td>
                  <td ></td>
                  <td>
                  </td>
                  <td>
        
                  </td>
                  <td>
        
                  </td>
                  
                </tr>
                @php
                  $variedadcount=1;
                  $cantidadtotal=0;
                  $pesonetototal=0;
                  $retornototal=0;
                    $totalretorno4j=0;
                    $totalretorno3j=0;
                    $totalretorno2j=0;
                    $totalretornoj=0;
                    $totalretornoxl=0;

                    $totalmargen4j=0;
                    $totalmargen3j=0;
                    $totalmargen2j=0;
                    $totalmargenj=0;
                    $totalmargenxl=0;

                    $totalcostopacking=0;
                    $globaltotalmateriales=0;

                    $totalpesonetol=0;
        
                    $globaltotalotroscostos=0;
                    $totalcount=0;

                    $totalcostos4j=0;
                    $totalcostos3j=0;
                    $totalcostos2j=0;
                    $totalcostosj=0;
                    $totalcostosxl=0;
                    
                @endphp
                @foreach ($unique_variedades as $variedad)
                  <tr style="background-color: white;">
    


                    <td> </td>
                  
                    <td> {{$variedad}} </td>
                
                  
                  
                  
                    <td></td>
                    <td ></td>
                    <td>
                    </td>
                    <td>
        
                    </td>
                    <td>
        
                    </td>
                    
                  </tr>
                  @php
                    $calibrecount=1;
                    
                    $cantidad4j=0;
                    $cantidad3j=0;
                    $cantidad2j=0;
                    $cantidadj=0;
                    $cantidadxl=0;
                    $pesoneto4j=0;
                    $pesoneto3j=0;
                    $pesoneto2j=0;
                    $pesonetoj=0;
                    $pesonetoxl=0;
                    $pesonetol=0;
        
                    $retorno4j=0;
                    $retorno3j=0;
                    $retorno2j=0;
                    $retornoj=0;
                    $retornoxl=0;

                    $retorno_neto4j=0;
                    $retorno_neto3j=0;
                    $retorno_neto2j=0;
                    $retorno_netoj=0;
                    $retorno_netoxl=0;

                    $margen4j=0;
                    $margen3j=0;
                    $margen2j=0;
                    $margenj=0;
                    $margenxl=0;
        
                    $costopacking=0;
        
                    $totalmateriales4j=0;
                    $totalmateriales3j=0;
                    $totalmateriales2j=0;
                    $totalmaterialesj=0;
                    $totalmaterialesxl=0;

                    $costos4j=0;
                    $costos3j=0;
                    $costos2j=0;
                    $costosj=0;
                    $costosxl=0;
        
                    $otroscostos=0;
                    $totalotroscostos=0;
                    
                    
                    $masatotal=0;
        
                  @endphp
        
                  @foreach ($masas->where('tipo','EXPORTACIÓN') as $masa)
                    
                    @php      
                              $tarifafinal=0;
                              if (!IS_NULL($masa->fob)) {
                                          if ($masa->fob->tarifas->count()>0) {
                                              $tarifafinal=$masa->fob->tarifas->reverse()->first()->tarifa_fc;
                                          }
                              }
                                      
                    @endphp 
                      @if (($masa->calibre_real=='4J') && $masa->variedad==$variedad)
                          @php
                            $cantidad4j+=floatval($masa->cantidad);
                            $pesoneto4j+=floatval($masa->peso_prorrateado);
                           
                            

                           
                            
                            if (!IS_NULL($masa->fob)) {
                                $retorno4j+=floatval($masa->peso_prorrateado*$tarifafinal);
                                $totalretorno4j+=floatval($masa->peso_prorrateado*$tarifafinal);
                                $margen4j+=floatval($masa->peso_prorrateado*$tarifafinal*0.08);
                                $totalmargen4j+=floatval($masa->peso_prorrateado*$tarifafinal*0.08);
                              }
                            $cantidadtotal+=floatval($masa->cantidad);
                            $pesonetototal+=floatval($masa->peso_prorrateado);

                                $costos4j+=floatval($masa->costo);
                                $totalcostos4j+=floatval($masa->costo);
                                 
                    
                          @endphp	
                      @endif
                      @if (($masa->calibre_real=='3J') && $masa->variedad==$variedad)
                          @php
                            $cantidad3j+=$masa->cantidad;
                            $pesoneto3j+=floatval($masa->peso_prorrateado);
                         

                            $costos3j+=floatval($masa->costo);
                            $totalcostos3j+=floatval($masa->costo);

                            if (!IS_NULL($masa->fob)) {
                              //dd($masa->fob);
                                                $retorno3j+=floatval($masa->peso_prorrateado*$tarifafinal);
                                                $totalretorno3j+=floatval($masa->peso_prorrateado*$tarifafinal);
                                                $margen3j+=floatval($masa->peso_prorrateado*$tarifafinal*0.08);
                                                $totalmargen3j+=floatval($masa->peso_prorrateado*$tarifafinal*0.08);
                                              }
                            $cantidadtotal+=$masa->cantidad;
                            $pesonetototal+=floatval($masa->peso_prorrateado);

                                

                          @endphp	
                      @endif
                      @if (($masa->calibre_real=='2J') && $masa->variedad==$variedad)
                          @php
                            $cantidad2j+=$masa->cantidad;
                            $pesoneto2j+=floatval($masa->peso_prorrateado);
                           

                            $costos2j+=floatval($masa->costo);
                            $totalcostos2j+=floatval($masa->costo);

                            if (!IS_NULL($masa->fob)) {
                                             $retorno2j+=floatval($masa->peso_prorrateado*$tarifafinal);
                                             $totalretorno2j+=floatval($masa->peso_prorrateado*$tarifafinal);
                                             $margen2j+=floatval($masa->peso_prorrateado*$tarifafinal*0.08);
                                             $totalmargen2j+=floatval($masa->peso_prorrateado*$tarifafinal*0.08);
                                              }
                            $cantidadtotal+=$masa->cantidad;
                            $pesonetototal+=floatval($masa->peso_prorrateado);

                          

                          @endphp	
                      @endif
                      @if (($masa->calibre_real=='J') && $masa->variedad==$variedad)
                          @php
                            $cantidadj+=$masa->cantidad;
                              $pesonetoj+=floatval($masa->peso_prorrateado);
                             

                              $costosj+=floatval($masa->costo);
                              $totalcostosj+=floatval($masa->costo);

                              if (!IS_NULL($masa->fob)) {
                                                $retornoj+=floatval($masa->peso_prorrateado*$tarifafinal);
                                                $totalretornoj+=floatval($masa->peso_prorrateado*$tarifafinal);
                                                $margenj+=floatval($masa->peso_prorrateado*$tarifafinal*0.08);
                                                $totalmargenj+=floatval($masa->peso_prorrateado*$tarifafinal*0.08);
                              }
                              $cantidadtotal+=$masa->cantidad;
                              $pesonetototal+=floatval($masa->peso_prorrateado);

                           

                          @endphp	
                      @endif
                      @if (($masa->calibre_real=='XL') && $masa->variedad==$variedad)
                          @php
                            $cantidadxl+=$masa->cantidad;
                            $pesonetoxl+=floatval($masa->peso_prorrateado);
                          
                            $costosxl+=floatval($masa->costo);
                            $totalcostosxl+=floatval($masa->costo);

                            if (!IS_NULL($masa->fob)) {
                                             $retornoxl+=floatval($masa->peso_prorrateado*$tarifafinal);
                                             $totalretornoxl+=floatval($masa->peso_prorrateado*$tarifafinal);
                                             $margenxl+=floatval($masa->peso_prorrateado*$tarifafinal*0.08);
                                             $totalmargenxl+=floatval($masa->peso_prorrateado*$tarifafinal*0.08);
                                              }
                            $cantidadtotal+=$masa->cantidad;
                            $pesonetototal+=floatval($masa->peso_prorrateado);


                          @endphp	
                      @endif
                      @if (($masa->calibre_real=='L') && $masa->variedad==$variedad)
                          @php
                          
                            $pesonetol+=floatval($masa->peso_prorrateado);
                            $totalpesonetol+=floatval($masa->peso_prorrateado);
                            
                          @endphp	
                      @endif
                      
                      @if ($masa->calibre_real=='4J' || $masa->calibre_real=='3J'|| $masa->calibre_real=='2J' || $masa->calibre_real=='J' || $masa->calibre_real=='XL' || $masa->calibre_real=='L')
                            @php
                                  $masatotal+=$masa->peso_prorrateado;
                            @endphp
                      @endif
                    
                  @endforeach
        

               

        
                  @if ($cantidad4j+$cantidad3j+$cantidad2j+$cantidadj+$cantidadxl>0)
                    
                    @if ($pesoneto4j>0)
                      <tr>
                        <td> </td>
                        <td> </td>
                        
                        
                        
                        
                        <td>4J</td>
                        <td style="text-align:right; padding-right:30px;border-left: 1px solid #ddd;" >{{number_format($pesoneto4j,2,',','.')}} KGS</td>
                        <td>{{number_format(($retorno4j),2,',','.')}}
                        <td>{{number_format(($margen4j),2,',','.')}}
                        </td>
                       
                        <td>
                          {{number_format($costos4j,2)}}
                        </td>
                        
                        <td>
                            @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "4J")
                              @if ($type_mod=="npk")
                                {{$retorno}} <br>
                              @else
                                <label for="retorno" class="hidden text-sm font-medium text-gray-700">Retorno</label>
                                <input
                                    id="retorno"
                                    type="number" 
                                    step="0.01"
                                    class="w-32 shadow-sm border-2 border-gray-300 bg-white h-10 px-2 rounded-lg focus:outline-none"
                                    wire:model.live="retorno"
                                    
                                >
                              @endif
                            
                              
                            @else

                              @if ($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','4J')->count()>0)
                                <p class="text-red-500 font-bold whitespace-nowrap">
                                  {{number_format($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','4J')->first()->retorno, 2, ',', '.') }} USD
                                </p>
                                  @php
                                      $retorno_neto4j=$informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','4J')->first()->retorno;
                                  @endphp
                              @else
                                {{ number_format(($retorno4j - ($margen4j + $costos4j)), 2, ',', '.') }} USD <br>
                                @php
                                    $retorno_neto4j=($retorno4j - ($margen4j + $costos4j));
                                @endphp
                              @endif
                              
                            @endif

                            @if ($categoria_mod=="DENTRO DE NORMA" && $variedad_mod==$variedad && $calibre_mod=="4J" && $type_mod=="retorno")
                              <button wire:click="saveOrUpdateModification" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                <span class="relative">Guardar</span>
                              </button>
                            @else
                              <span wire:click="set_modification('DENTRO DE NORMA', '{{ $variedad }}', '4J','{{($retorno4j-($margen4j+$costos4j))}}','{{($retorno4j-($margen4j+$costos4j))/$pesoneto4j}}','{{$pesoneto4j}}','retorno')" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full text-xs"></span>
                                <span class="relative">Editar</span>
                                </span>
                            @endif
                              
                        </td>
                        <td>
                            @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "4J")
                              @if ($type_mod=="retorno")
                                {{$npk}} <br>
                              @else
                                <label for="npk" class="hidden text-sm font-medium text-gray-700">NPK</label>
                                <input
                                    id="npk"
                                    type="number"
                                    step="0.01"
                                    class="w-32 shadow-sm border-2 border-gray-300 bg-white h-10 px-2 rounded-lg focus:outline-none"
                                    wire:model.live="npk"
                                >
                              @endif
                                
                            @else
                              @if ($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','4J')->count()>0)
                                <p class="text-red-500 font-bold whitespace-nowrap">
                                  {{number_format($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','4J')->first()->npk, 2, ',', '.') }} USD/kg
                                </p>

                              @else
                                @if ($pesoneto4j)
                                    <p class="whitespace-nowrap">
                                      {{ number_format(($retorno4j - ($margen4j + $costos4j)) / $pesoneto4j, 2, ',', '.') }} USD/kg
                                    </p>
                                @else
                                    0 USD/kg
                                @endif
                              @endif
                                
                            @endif

                            @if ($categoria_mod=="DENTRO DE NORMA" && $variedad_mod==$variedad && $calibre_mod=="4J" && $type_mod=="npk")
                              <button wire:click="saveOrUpdateModification" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                <span class="relative">Guardar</span>
                              </button>
                            @else
                              <span wire:click="set_modification('DENTRO DE NORMA', '{{ $variedad }}', '4J','{{($retorno4j-($margen4j+$costos4j))}}','{{($retorno4j-($margen4j+$costos4j))/$pesoneto4j}}','{{$pesoneto4j}}','npk')" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full text-xs"></span>
                                <span class="relative">Editar</span>
                                </span>
                            @endif
                              
                        </td>
                      
                         
                        <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-center">

                         
                          @if ($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','4J')->count()>0)
                            @if ($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','4J')->first()->retorno>$informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','4J')->first()->retorno_inicial)
                               <p class="text-green-500 font-bold"> +{{$informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','4J')->first()->retorno-$informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','4J')->first()->retorno_inicial}} usd
                              </p>
                            @else
                              <p class="text-red-500 font-bold"> {{$informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','4J')->first()->retorno-$informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','4J')->first()->retorno_inicial}} usd
                              </p>
                            @endif
                           <button title="Eliminar" class="cursorpointer text-xs text-red-500" wire:click="delete_modificacion('{{$informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','4J')->first()->id}}')" >(Eliminar)</button>
                          @endif
                           {{-- comment
                                <input wire:model="preciofob" class="w-32 shadow-sm  border-2 border-gray-300 bg-white h-10 px-2 rounded-lg focus:outline-none">   
                                <span wire:click='save_fobid()' class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                    <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                    <span class="relative">Guardar</span>
                                    </span>
                            --}}

                        </td>
                      </tr>
                      @php
                        $calibrecount+=1;
                      @endphp
                    @endif
                    @if ($pesoneto3j>0)
                      <tr>
                        <td> </td>
                        <td> </td>
                      
                        
                        
                        <td>3J</td>
                        <td style="text-align:right; padding-right:30px;border-left: 1px solid #ddd;" >{{number_format($pesoneto3j,2,',','.')}} KGS</td>
                        <td>{{number_format(($retorno3j),2,',','.')}}
                        <td>{{number_format(($margen3j),2,',','.')}}
                        </td>
                        <td>
                          {{number_format($costos3j,2)}}
                        </td>
                        <td>
                          @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "3J")
                            @if ($type_mod=="npk")
                              {{$retorno}} <br>
                            @else
                              <label for="retorno" class="hidden text-sm font-medium text-gray-700">Retorno</label>
                              <input
                                  id="retorno"
                                  type="number" 
                                  step="0.01"
                                  class="w-32 shadow-sm border-2 border-gray-300 bg-white h-10 px-2 rounded-lg focus:outline-none"
                                  wire:model.live="retorno"
                                  
                              >
                            @endif
                          
                            
                          @else

                            @if ($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','3J')->count()>0)
                              <p class="text-red-500 font-bold whitespace-nowrap">
                                {{number_format($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','3J')->first()->retorno, 2, ',', '.') }} USD
                              </p>
                                  @php
                                      $retorno_neto3j=$informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','3J')->first()->retorno;
                                  @endphp
                            @else
                              {{ number_format(($retorno3j - ($margen3j + $costos3j)), 2, ',', '.') }} USD <br>
                                @php
                                    $retorno_neto3j=($retorno3j - ($margen3j + $costos3j));
                                @endphp
                            @endif
                            
                          @endif

                          @if ($categoria_mod=="DENTRO DE NORMA" && $variedad_mod==$variedad && $calibre_mod=="3J" && $type_mod=="retorno")
                            <button wire:click="saveOrUpdateModification" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                              <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                              <span class="relative">Guardar</span>
                            </button>
                          @else
                            <span wire:click="set_modification('DENTRO DE NORMA', '{{ $variedad }}', '3J','{{($retorno3j-($margen3j+$costos3j))}}','{{($retorno3j-($margen3j+$costos3j))/$pesoneto3j}}','{{$pesoneto3j}}','retorno')" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                              <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full text-xs"></span>
                              <span class="relative">Editar</span>
                              </span>
                          @endif
                            
                        </td>
                        <td>
                            @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "3J")
                              @if ($type_mod=="retorno")
                                {{$npk}} <br>
                              @else
                                <label for="npk" class="hidden text-sm font-medium text-gray-700">NPK</label>
                                <input
                                    id="npk"
                                    type="number"
                                    step="0.01"
                                    class="w-32 shadow-sm border-2 border-gray-300 bg-white h-10 px-2 rounded-lg focus:outline-none"
                                    wire:model.live="npk"
                                >
                              @endif
                                
                            @else
                              @if ($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','3J')->count()>0)
                                <p class="text-red-500 font-bold whitespace-nowrap">
                                  {{number_format($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','3J')->first()->npk, 2, ',', '.') }} USD/kg
                                </p>

                              @else
                                @if ($pesoneto3j)
                                    <p class="whitespace-nowrap">
                                      {{ number_format(($retorno3j - ($margen3j + $costos3j)) / $pesoneto3j, 2, ',', '.') }} USD/kg
                                    </p>
                                @else
                                    0 USD/kg
                                @endif
                              @endif
                                
                            @endif

                            @if ($categoria_mod=="DENTRO DE NORMA" && $variedad_mod==$variedad && $calibre_mod=="3J" && $type_mod=="npk")
                              <button wire:click="saveOrUpdateModification" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                <span class="relative">Guardar</span>
                              </button>
                            @else
                              <span wire:click="set_modification('DENTRO DE NORMA', '{{ $variedad }}', '3J','{{($retorno3j-($margen3j+$costos3j))}}','{{($retorno3j-($margen3j+$costos3j))/$pesoneto3j}}','{{$pesoneto3j}}','npk')" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full text-xs"></span>
                                <span class="relative">Editar</span>
                                </span>
                            @endif
                              
                        </td>
                      
                        <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-center">

                        
                          @if ($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','3J')->count()>0)
                            @if ($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','3J')->first()->retorno>$informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','3J')->first()->retorno_inicial)
                                <p class="text-green-500 font-bold"> +{{$informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','3J')->first()->retorno-$informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','3J')->first()->retorno_inicial}} usd
                              </p>
                            @else
                              <p class="text-red-500 font-bold"> {{$informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','3J')->first()->retorno-$informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','3J')->first()->retorno_inicial}} usd
                              </p>
                            @endif
                            <button title="Eliminar" class="cursorpointer text-xs text-red-500" wire:click="delete_modificacion('{{$informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','3J')->first()->id}}')" >(Eliminar)</button>
                          @endif
                          {{-- comment
                                <input wire:model="preciofob" class="w-32 shadow-sm  border-2 border-gray-300 bg-white h-10 px-2 rounded-lg focus:outline-none">   
                                <span wire:click='save_fobid()' class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                    <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                    <span class="relative">Guardar</span>
                                    </span>
                            --}}

                        </td>
                          
                      </tr>
                      @php
                        $calibrecount+=1;
                      @endphp
                    @endif
                    @if ($pesoneto2j>0)
                      <tr>
                        <td> </td>
                        <td> </td>
                      
                        
                        
                        <td>2J</td>
                        <td style="text-align:right; padding-right:30px;border-left: 1px solid #ddd;" >{{number_format($pesoneto2j,2,',','.')}} KGS</td>
                        <td>{{number_format(($retorno2j),2,',','.')}}
                        <td>{{number_format(($margen2j),2,',','.')}}
                        </td>
                        <td>
                          {{number_format($costos2j,2)}}
                        </td>
                        <td>
                          @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "2J")
                            @if ($type_mod=="npk")
                              {{$retorno}} <br>
                            @else
                              <label for="retorno" class="hidden text-sm font-medium text-gray-700">Retorno</label>
                              <input
                                  id="retorno"
                                  type="number" 
                                  step="0.01"
                                  class="w-32 shadow-sm border-2 border-gray-300 bg-white h-10 px-2 rounded-lg focus:outline-none"
                                  wire:model.live="retorno"
                                  
                              >
                            @endif
                          
                            
                          @else

                            @if ($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','2J')->count()>0)
                              <p class="text-red-500 font-bold whitespace-nowrap">
                                {{number_format($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','2J')->first()->retorno, 2, ',', '.') }} USD
                              </p>
                              @php
                                  $retorno_neto2j=$informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','2J')->first()->retorno;
                              @endphp
                            @else
                            
                              {{ number_format(($retorno2j - ($margen2j + $costos2j)), 2, ',', '.') }} USD <br>
                              @php
                                  $retorno_neto2j=($retorno2j - ($margen2j + $costos2j));
                              @endphp
                            @endif
                            
                          @endif

                          @if ($categoria_mod=="DENTRO DE NORMA" && $variedad_mod==$variedad && $calibre_mod=="2J" && $type_mod=="retorno")
                            <button wire:click="saveOrUpdateModification" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                              <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                              <span class="relative">Guardar</span>
                            </button>
                          @else
                            <span wire:click="set_modification('DENTRO DE NORMA', '{{ $variedad }}', '2J','{{($retorno2j-($margen2j+$costos2j))}}','{{($retorno2j-($margen2j+$costos2j))/$pesoneto2j}}','{{$pesoneto2j}}','retorno')" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                              <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full text-xs"></span>
                              <span class="relative">Editar</span>
                              </span>
                          @endif
                            
                        </td>
                        <td>
                            @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "2J")
                              @if ($type_mod=="retorno")
                                {{$npk}} <br>
                              @else
                                <label for="npk" class="hidden text-sm font-medium text-gray-700">NPK</label>
                                <input
                                    id="npk"
                                    type="number"
                                    step="0.01"
                                    class="w-32 shadow-sm border-2 border-gray-300 bg-white h-10 px-2 rounded-lg focus:outline-none"
                                    wire:model.live="npk"
                                >
                              @endif
                                
                            @else
                              @if ($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','2J')->count()>0)
                                <p class="text-red-500 font-bold whitespace-nowrap">
                                  {{number_format($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','2J')->first()->npk, 2, ',', '.') }} USD/kg
                                </p>

                              @else
                                @if ($pesoneto2j)
                                    <p class="whitespace-nowrap">
                                      {{ number_format(($retorno2j - ($margen2j + $costos2j)) / $pesoneto2j, 2, ',', '.') }} USD/kg
                                    </p>
                                @else
                                    0 USD/kg
                                @endif
                              @endif
                                
                            @endif

                            @if ($categoria_mod=="DENTRO DE NORMA" && $variedad_mod==$variedad && $calibre_mod=="2J" && $type_mod=="npk")
                              <button wire:click="saveOrUpdateModification" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                <span class="relative">Guardar</span>
                              </button>
                            @else
                              <span wire:click="set_modification('DENTRO DE NORMA', '{{ $variedad }}', '2J','{{($retorno2j-($margen2j+$costos2j))}}','{{($retorno2j-($margen2j+$costos2j))/$pesoneto2j}}','{{$pesoneto2j}}','npk')" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full text-xs"></span>
                                <span class="relative">Editar</span>
                                </span>
                            @endif
                              
                        </td>
                      
                        <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-center">

                        
                          @if ($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','2J')->count()>0)
                            @if ($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','2J')->first()->retorno>$informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','2J')->first()->retorno_inicial)
                                <p class="text-green-500 font-bold"> +{{$informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','2J')->first()->retorno-$informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','2J')->first()->retorno_inicial}} usd
                              </p>
                            @else
                              <p class="text-red-500 font-bold"> {{$informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','2J')->first()->retorno-$informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','2J')->first()->retorno_inicial}} usd
                              </p>
                            @endif
                            <button title="Eliminar" class="cursorpointer text-xs text-red-500" wire:click="delete_modificacion('{{$informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','2J')->first()->id}}')" >(Eliminar)</button>
                          @endif
                          {{-- comment
                                <input wire:model="preciofob" class="w-32 shadow-sm  border-2 border-gray-300 bg-white h-10 px-2 rounded-lg focus:outline-none">   
                                <span wire:click='save_fobid()' class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                    <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                    <span class="relative">Guardar</span>
                                    </span>
                            --}}

                        </td>
                        
                      </tr>
                      @php
                        $calibrecount+=1;
                      @endphp
                    @endif
                    @if ($pesonetoj>0)
                      <tr>
                        <td> </td>
                        <td> </td>
                        
                        
                        
                        
                        <td>J</td>
                        <td style="text-align:right; padding-right:30px; border-left: 1px solid #ddd;" >{{number_format($pesonetoj,2,',','.')}} KGS</td>
                        <td>{{number_format(($retornoj),2,',','.')}}
                        <td>{{number_format(($margenj),2,',','.')}}
                        </td>
                        <td>
                          {{number_format($costosj,2)}}
                        </td>
                        <td>
                          @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "J")
                            @if ($type_mod=="npk")
                              {{$retorno}} <br>
                            @else
                              <label for="retorno" class="hidden text-sm font-medium text-gray-700">Retorno</label>
                              <input
                                  id="retorno"
                                  type="number" 
                                  step="0.01"
                                  class="w-32 shadow-sm border-2 border-gray-300 bg-white h-10 px-2 rounded-lg focus:outline-none"
                                  wire:model.live="retorno"
                                  
                              >
                            @endif
                          
                            
                          @else

                            @if ($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','J')->count()>0)
                              <p class="text-red-500 font-bold whitespace-nowrap">
                                {{number_format($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','J')->first()->retorno, 2, ',', '.') }} USD
                              </p>
                                @php
                                    $retorno_netoj=$informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','J')->first()->retorno;
                                @endphp
                            @else
                              {{ number_format(($retornoj - ($margenj + $costosj)), 2, ',', '.') }} USD <br>
                              @php
                                  $retorno_netoj=($retornoj - ($margenj + $costosj));
                              @endphp
                            @endif
                            
                          @endif

                          @if ($categoria_mod=="DENTRO DE NORMA" && $variedad_mod==$variedad && $calibre_mod=="J" && $type_mod=="retorno")
                            <button wire:click="saveOrUpdateModification" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                              <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                              <span class="relative">Guardar</span>
                            </button>
                          @else
                            <span wire:click="set_modification('DENTRO DE NORMA', '{{ $variedad }}', 'J','{{($retornoj-($margenj+$costosj))}}','{{($retornoj-($margenj+$costosj))/$pesonetoj}}','{{$pesonetoj}}','retorno')" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                              <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full text-xs"></span>
                              <span class="relative">Editar</span>
                              </span>
                          @endif
                            
                        </td>
                        <td>
                            @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "J")
                              @if ($type_mod=="retorno")
                                {{$npk}} <br>
                              @else
                                <label for="npk" class="hidden text-sm font-medium text-gray-700">NPK</label>
                                <input
                                    id="npk"
                                    type="number"
                                    step="0.01"
                                    class="w-32 shadow-sm border-2 border-gray-300 bg-white h-10 px-2 rounded-lg focus:outline-none"
                                    wire:model.live="npk"
                                >
                              @endif
                                
                            @else
                              @if ($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','J')->count()>0)
                                <p class="text-red-500 font-bold whitespace-nowrap">
                                  {{number_format($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','J')->first()->npk, 2, ',', '.') }} USD/kg
                                </p>

                              @else
                                @if ($pesonetoj)
                                    <p class="whitespace-nowrap">
                                      {{ number_format(($retornoj - ($margenj + $costosj)) / $pesonetoj, 2, ',', '.') }} USD/kg
                                    </p>
                                @else
                                    0 USD/kg
                                @endif
                              @endif
                                
                            @endif

                            @if ($categoria_mod=="DENTRO DE NORMA" && $variedad_mod==$variedad && $calibre_mod=="J" && $type_mod=="npk")
                              <button wire:click="saveOrUpdateModification" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                <span class="relative">Guardar</span>
                              </button>
                            @else
                              <span wire:click="set_modification('DENTRO DE NORMA', '{{ $variedad }}', 'J','{{($retornoj-($margenj+$costosj))}}','{{($retornoj-($margenj+$costosj))/$pesonetoj}}','{{$pesonetoj}}','npk')" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full text-xs"></span>
                                <span class="relative">Editar</span>
                                </span>
                            @endif
                              
                        </td>
                      
                        <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-center">

                        
                          @if ($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','J')->count()>0)
                            @if ($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','J')->first()->retorno>$informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','J')->first()->retorno_inicial)
                                <p class="text-green-500 font-bold"> +{{$informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','J')->first()->retorno-$informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','J')->first()->retorno_inicial}} usd
                              </p>
                            @else
                              <p class="text-red-500 font-bold"> {{$informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','J')->first()->retorno-$informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','J')->first()->retorno_inicial}} usd
                              </p>
                            @endif
                          <button title="Eliminar" class="cursorpointer text-xs text-red-500" wire:click="delete_modificacion('{{$informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','J')->first()->id}}')" >(Eliminar)</button>
                          @endif
                          {{-- comment
                                <input wire:model="preciofob" class="w-32 shadow-sm  border-2 border-gray-300 bg-white h-10 px-2 rounded-lg focus:outline-none">   
                                <span wire:click='save_fobid()' class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                    <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                    <span class="relative">Guardar</span>
                                    </span>
                            --}}

                        </td>
          
                        
                      </tr>
                      @php
                        $calibrecount+=1;
                      @endphp
                    @endif
                    @if ($pesonetoxl>0)
                      <tr>
                        <td> </td>
                        <td> </td>
                        
                        
                        
                        
                        <td>XL</td>
                        <td style="text-align:right; padding-right:30px; border-left: 1px solid #ddd; " >{{number_format($pesonetoxl,2,',','.')}} KGS</td>
                        <td>{{number_format(($retornoxl),2,',','.')}}
                        <td>{{number_format(($margenxl),2,',','.')}}
                        </td>
                        <td>
                          {{number_format($costosxl,2)}}
                        </td>
                        <td>
                          @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "XL")
                            @if ($type_mod=="npk")
                              {{$retorno}} <br>
                            @else
                              <label for="retorno" class="hidden text-sm font-medium text-gray-700">Retorno</label>
                              <input
                                  id="retorno"
                                  type="number" 
                                  step="0.01"
                                  class="w-32 shadow-sm border-2 border-gray-300 bg-white h-10 px-2 rounded-lg focus:outline-none"
                                  wire:model.live="retorno"
                                  
                              >
                            @endif
                          
                            
                          @else

                            @if ($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','XL')->count()>0)
                              <p class="text-red-500 font-bold whitespace-nowrap">
                                {{number_format($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','XL')->first()->retorno, 2, ',', '.') }} USD
                              </p>
                              @php
                                  $retorno_netoxl=$informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','XL')->first()->retorno;
                              @endphp
                            @else
                              {{ number_format(($retornoxl - ($margenxl + $costosxl)), 2, ',', '.') }} USD <br>
                              @php
                                  $retorno_netoxl=($retornoxl - ($margenxl + $costosxl));
                              @endphp
                            @endif
                            
                          @endif

                          @if ($categoria_mod=="DENTRO DE NORMA" && $variedad_mod==$variedad && $calibre_mod=="XL" && $type_mod=="retorno")
                            <button wire:click="saveOrUpdateModification" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                              <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                              <span class="relative">Guardar</span>
                            </button>
                          @else
                            <span wire:click="set_modification('DENTRO DE NORMA', '{{ $variedad }}', 'XL','{{($retornoxl-($margenxl+$costosxl))}}','{{($retornoxl-($margenxl+$costosxl))/$pesonetoxl}}','{{$pesonetoxl}}','retorno')" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                              <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full text-xs"></span>
                              <span class="relative">Editar</span>
                              </span>
                          @endif
                            
                        </td>
                        <td>
                            @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "XL")
                              @if ($type_mod=="retorno")
                                {{$npk}} <br>
                              @else
                                <label for="npk" class="hidden text-sm font-medium text-gray-700">NPK</label>
                                <input
                                    id="npk"
                                    type="number"
                                    step="0.01"
                                    class="w-32 shadow-sm border-2 border-gray-300 bg-white h-10 px-2 rounded-lg focus:outline-none"
                                    wire:model.live="npk"
                                >
                              @endif
                                
                            @else
                              @if ($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','XL')->count()>0)
                                <p class="text-red-500 font-bold whitespace-nowrap">
                                  {{number_format($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','XL')->first()->npk, 2, ',', '.') }} USD/kg
                                </p>

                              @else
                                @if ($pesonetoxl)
                                    <p class="whitespace-nowrap">
                                      {{ number_format(($retornoxl - ($margenxl + $costosxl)) / $pesonetoxl, 2, ',', '.') }} USD/kg
                                    </p>
                                @else
                                    0 USD/kg
                                @endif
                              @endif
                                
                            @endif

                            @if ($categoria_mod=="DENTRO DE NORMA" && $variedad_mod==$variedad && $calibre_mod=="XL" && $type_mod=="npk")
                              <button wire:click="saveOrUpdateModification" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                <span class="relative">Guardar</span>
                              </button>
                            @else
                              <span wire:click="set_modification('DENTRO DE NORMA', '{{ $variedad }}', 'XL','{{($retornoxl-($margenxl+$costosxl))}}','{{($retornoxl-($margenxl+$costosxl))/$pesonetoxl}}','{{$pesonetoxl}}','npk')" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full text-xs"></span>
                                <span class="relative">Editar</span>
                                </span>
                            @endif
                              
                        </td>
                      
                        <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-center">

                        
                          @if ($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','XL')->count()>0)
                            @if ($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','XL')->first()->retorno>$informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','XL')->first()->retorno_inicial)
                                <p class="text-green-500 font-bold"> +{{$informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','XL')->first()->retorno-$informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','XL')->first()->retorno_inicial}} usd
                              </p>
                            @else
                              <p class="text-red-500 font-bold"> {{$informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','XL')->first()->retorno-$informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','XL')->first()->retorno_inicial}} usd
                              </p>
                            @endif
                            <button title="Eliminar" class="cursorpointer text-xs text-red-500" wire:click="delete_modificacion('{{$informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','XL')->first()->id}}')" >(Eliminar)</button>
                          @endif
                          {{-- comment
                                <input wire:model="preciofob" class="w-32 shadow-sm  border-2 border-gray-300 bg-white h-10 px-2 rounded-lg focus:outline-none">   
                                <span wire:click='save_fobid()' class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                    <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                    <span class="relative">Guardar</span>
                                    </span>
                            --}}

                        </td>
                        
                      </tr>
                      @php
                        $calibrecount+=1;
                      @endphp
                    @endif
                  @endif
                  
                  @if ($pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl>0)
                    
                    <tr>
                      <td></td>
                      <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">Total {{$variedad}}</td>
                      <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
                      <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; ">{{number_format($pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl,2,',','.')}} KGS</td>
                      <td>
                        {{number_format($retorno4j+$retorno3j+$retorno2j+$retornoj+$retornoxl,2,',','.')}}
                      </td>
                      <td>
                        {{number_format(($margen4j+$margen3j+$margen2j+$margenj+$margenxl),2,',','.')}}
                      </td>
                    
                      <td>
                        {{number_format($costos4j+$costos3j+$costos2j+$costosj+$costosxl,2)}}
                      </td>
                      <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format(($retorno_neto4j+$retorno_neto3j+$retorno_neto2j+$retorno_netoj+$retorno_netoxl),2,',','.')}} USD 
                      
                      
                    </td>
                      <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format(($retorno_neto4j+$retorno_neto3j+$retorno_neto2j+$retorno_netoj+$retorno_netoxl)/($pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl),2,',','.')}} USD/KG</td>
                      
                    </tr>
                  @endif 
                    @php
                      $totalcount+=($retorno_neto4j+$retorno_neto3j+$retorno_neto2j+$retorno_netoj+$retorno_netoxl);
                      $variedadcount+=1;
                    @endphp
                  
        
                @endforeach
              
                @if ($pesonetototal>0)
                  <tr style="background-color: #ddd;">
                        
                    
                  
                      <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">Total Dentro de Norma</td>
                    
                    
                      <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
                  
                    
                    
                    <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"></td>
                    <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format($pesonetototal,1,',','.')}} KGS</td>
                    <td>{{number_format($totalretorno4j+$totalretorno3j+$totalretorno2j+$totalretornoj+$totalretornoxl,2)}} usd</td>
                    <td>{{number_format(($totalmargen4j+$totalmargen3j+$totalmargen2j+$totalmargenj+$totalmargenxl),2)}} usd</td>
                   
                    <td>
                      {{number_format(($totalcostos4j+$totalcostos3j+$totalcostos2j+$totalcostosj+$totalcostosxl),2)}}
                    </td>
                    
                    <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format($totalcount,2,',','.')}} USD 
                  
                    </td>
                    <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format($totalcount/$pesonetototal,2,',','.')}} usd/kg </td>
                    
                  </tr>
                @endif
        
                @php
                  $totaldentrodenorma=($totalcount);
                @endphp
                  
        
              </tbody>
            </table>

            <h1 class="mt-6">
              Fruta fuera de norma
            </h1>
            <table id="balance" style="width:100%; border-collapse: collapse; margin-top: 20px;">
              <thead style="border-top: 2px solid black; border-bottom: 2px solid black;">
                <tr>
                <th>Norma</th>
                <th>Variedad</th>
                <th>Calibre</th>
                <th>Kg Embalado</th>
                
                <th>Ingresos</th>
                <th>Comision</th>
                <th>Costo </th>
                <th>Retorno Neto Productor</th>
                
                <th>NPK</th>
                <th>Modificaciones</th>
                </tr>
              </thead>
              <tbody>
                <tr style="background-color: #ddd;">
                        
                    <td> FUERA DE NORMA </td>
                
                
                    <td> </td>
                  
                  <td></td>
                  
                  <td></td>
                  <td></td>
                  <td></td>
                  <td ></td>
                  <td></td>
                  <td ></td>
                  <td>
                  </td>
                  <td>
        
                  </td>
                  <td>

                  </td>
                  
                </tr>
                @php
                  $variedadcount=1;
                  $cantidadtotal=0;
                  $pesonetototal=0;
                  $retornototal=0;
                    $totalretorno4j=0;
                    $totalretorno3j=0;
                    $totalretorno2j=0;
                    $totalretornoj=0;
                    $totalretornoxl=0;
                    $totalretornol=0;

                    $totalmargenl=0;

                    $totalcostosl=0;

                    $totalcostopacking=0;
                    $globaltotalmateriales=0;

                    $totalpesonetol=0;

                    $globaltotalotroscostos=0;

                    $totalfr=0;
                    
                @endphp
                @foreach ($unique_variedades as $variedad)
                <tr style="background-color: white;">
  


                  <td> </td>
                
                  <td> {{$variedad}} </td>
              
                
                
                
                <td></td>
                <td ></td>
                <td>
                </td>
                <td>
    
                </td>
                <td>

                </td>
                
              </tr>
                  @php
                    $calibrecount=1;
                    
                    $cantidad4j=0;
                    $cantidad3j=0;
                    $cantidad2j=0;
                    $cantidadj=0;
                    $cantidadxl=0;
                    $cantidadl=0;
                    
                    $pesoneto4j=0;
                    $pesoneto3j=0;
                    $pesoneto2j=0;
                    $pesonetoj=0;
                    $pesonetoxl=0;
                    $pesonetol=0;
        
                    $retorno4j=0;
                    $retorno3j=0;
                    $retorno2j=0;
                    $retornoj=0;
                    $retornoxl=0;
                    $retornol=0;

                    $retorno_neto4j=0;
                    $retorno_neto3j=0;
                    $retorno_neto2j=0;
                    $retorno_netoj=0;
                    $retorno_netoxl=0;
                    $retorno_netol=0;

                    $margenl=0;
                    
                    $costosl=0;
        
                    $costopacking=0;
        
                    $totalmateriales4j=0;
                    $totalmateriales3j=0;
                    $totalmateriales2j=0;
                    $totalmaterialesj=0;
                    $totalmaterialesxl=0;
                    $totalmaterialesl=0;
        
                    $otroscostos=0;
                    $totalotroscostos=0;
                    
                    $masatotal=0;
        
                  @endphp
        
                  @foreach ($masas as $masa)
                    
                      @if (($masa->calibre_real=='4J') && $masa->variedad==$variedad)
                          @php
                            $cantidad4j+=floatval($masa->cantidad);
                            $pesoneto4j+=floatval($masa->peso_prorrateado);
                            if (!IS_NULL($masa->precio_fob)) {
                                                $retorno4j+=floatval($masa->peso_prorrateado)*floatval($masa->precio_fob);
                                                $totalretorno4j+=floatval($masa->peso_prorrateado)*floatval($masa->precio_fob);
                                              }
                            $cantidadtotal+=floatval($masa->cantidad);
                          
                            foreach ($materialestotal as $material) {
                                if ($material->c_embalaje==$masa->cod_embalaje) {
                                  $totalmateriales4j+=$masa->peso_prorrateado*$material->tarifa_kg;
                                }  
                              }
                    
                          @endphp	
                      @endif
                      @if (($masa->calibre_real=='3J') && $masa->variedad==$variedad)
                          @php
                            $cantidad3j+=$masa->cantidad;
                            $pesoneto3j+=floatval($masa->peso_prorrateado);
                            if (!IS_NULL($masa->precio_fob)) {
                                                $retorno3j+=floatval($masa->peso_prorrateado)*floatval($masa->precio_fob);
                                                $totalretorno3j+=floatval($masa->peso_prorrateado)*floatval($masa->precio_fob);
                                              }
                            $cantidadtotal+=$masa->cantidad;
                            foreach ($materialestotal as $material) {
                                if ($material->c_embalaje==$masa->cod_embalaje) {
                                  $totalmateriales3j+=$masa->peso_prorrateado*$material->tarifa_kg;
                                }  
                              }
                          @endphp	
                      @endif
                      @if (($masa->calibre_real=='2J') && $masa->variedad==$variedad)
                          @php
                            $cantidad2j+=$masa->cantidad;
                            $pesoneto2j+=floatval($masa->peso_prorrateado);
                            if (!IS_NULL($masa->precio_fob)) {
                                                $retorno2j+=floatval($masa->peso_prorrateado)*floatval($masa->precio_fob);
                                                $totalretorno2j+=floatval($masa->peso_prorrateado)*floatval($masa->precio_fob);
                                              }
                            $cantidadtotal+=$masa->cantidad;
                            foreach ($materialestotal as $material) {
                                if ($material->c_embalaje==$masa->cod_embalaje) {
                                  $totalmateriales2j+=$masa->peso_prorrateado*$material->tarifa_kg;
                                }  
                              }
                          @endphp	
                      @endif
                      @if (($masa->calibre_real=='J') && $masa->variedad==$variedad)
                          @php
                            $cantidadj+=$masa->cantidad;
                              $pesonetoj+=floatval($masa->peso_prorrateado);
                              if (!IS_NULL($masa->precio_fob)) {
                              $retornoj+=floatval($masa->peso_prorrateado)*floatval($masa->precio_fob);
                              $totalretornoj+=floatval($masa->peso_prorrateado)*floatval($masa->precio_fob);
                              }
                              $cantidadtotal+=$masa->cantidad;
                              foreach ($materialestotal as $material) {
                                if ($material->c_embalaje==$masa->cod_embalaje) {
                                  $totalmaterialesj+=$masa->peso_prorrateado*$material->tarifa_kg;
                                }  
                              }
                          @endphp	
                      @endif
                      @if (($masa->calibre_real=='XL') && $masa->variedad==$variedad)
                          @php
                            $cantidadxl+=$masa->cantidad;
                            $pesonetoxl+=floatval($masa->peso_prorrateado);
                            if (!IS_NULL($masa->precio_fob)) {
                                                $retornoxl+=floatval($masa->peso_prorrateado)*floatval($masa->precio_fob);
                                                $totalretornoxl+=floatval($masa->peso_prorrateado)*floatval($masa->precio_fob);
                                              }
                            $cantidadtotal+=$masa->cantidad;
                            foreach ($materialestotal as $material) {
                                if ($material->c_embalaje==$masa->cod_embalaje) {
                                  $totalmaterialesxl+=$masa->peso_prorrateado*$material->tarifa_kg;
                                }  
                              }
                          @endphp	
                      @endif
                      
                      @if (($masa->calibre_real=='L') && $masa->variedad==$variedad)
                        @php
                          $cantidadl+=$masa->cantidad;
                          $pesonetol+=floatval($masa->peso_prorrateado);

                        
                         

                          $costosl+=floatval($masa->costo);
                          $totalcostosl+=floatval($masa->costo);

                          if (!IS_NULL($masa->fob)) {
                            $tarifafinal=0;
                           
                              if ($masa->fob->tarifas->count()>0) {
                                  
                                  $tarifafinal=$masa->fob->tarifas->reverse()->first()->tarifa_fc;
                                 
                              }
                                                $retornol+=floatval($masa->peso_prorrateado*$tarifafinal);
                                                $totalretornol+=floatval($masa->peso_prorrateado*$tarifafinal);
                                                $margenl+=floatval($masa->peso_prorrateado*$tarifafinal*0.08);
                                                $totalmargenl+=floatval($masa->peso_prorrateado*$tarifafinal*0.08);
                          }
                          $cantidadtotal+=$masa->cantidad;
                          $pesonetototal+=floatval($masa->peso_prorrateado);
                         
        
                        @endphp	
                      @endif

                      @if ($masa->calibre_real=='4J' || $masa->calibre_real=='3J'|| $masa->calibre_real=='2J' || $masa->calibre_real=='J' || $masa->calibre_real=='XL' || $masa->calibre_real=='L')
                            @php
                                  $masatotal+=$masa->peso_prorrateado;
                            @endphp
                      @endif
                    
                 
                   

                  @endforeach
        
        
                  @foreach ($gastos as $gasto)
                      @if ($gasto->familia->name=='Costos' && $gasto->item=='Otros costos')
                        @foreach ($detalles as $detalle)
                          @if (preg_replace('/[\.\-\s]+/', '', strtolower($detalle->item))==preg_replace('/[\.\-\s]+/', '', strtolower($gasto->item)))
                            @php
                              $otroscostos+=abs(floatval($detalle->cantidad));
                            @endphp
                          @endif
                        @endforeach
                      @endif
                  @endforeach
                  @php
                      $totalotroscostos+=($otroscostos)*(($pesonetol)/($masatotal));
                      
                      $globaltotalotroscostos+=$totalotroscostos;
                  @endphp
        
                  @if ($cantidad4j+$cantidad3j+$cantidad2j+$cantidadj+$cantidadxl+$cantidadl>0)
                    
                  
                  @if ($pesonetol>0)
                    <tr>
                      <td> </td>
                      <td> </td>
                      
                      
                      
                      
                      <td>L</td>
                      <td style="text-align:right; padding-right:30px; border-left: 1px solid #ddd; " >{{number_format($pesonetol,0,',','.')}} KGS</td>
                      <td>{{number_format(($retornol),2,',','.')}}
                      <td>{{number_format(($margenl),2,',','.')}}
                      </td>
                     
                      <td>
                        {{number_format($costosl,2)}}
                      </td>
                      <td>
                        @if ($categoria_mod == "FUERA DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "L")
                          @if ($type_mod=="npk")
                            {{$retorno}} <br>
                          @else
                            <label for="retorno" class="hidden text-sm font-medium text-gray-700">Retorno</label>
                            <input
                                id="retorno"
                                type="number" 
                                step="0.01"
                                class="w-32 shadow-sm border-2 border-gray-300 bg-white h-10 px-2 rounded-lg focus:outline-none"
                                wire:model.live="retorno"
                                
                            >
                          @endif
                        
                          
                        @else

                          @if ($informe_edit->modificaciones->where('categoria','FUERA DE NORMA')->where('variedad',$variedad)->where('calibre','L')->count()>0)
                            <p class="text-red-500 font-bold whitespace-nowrap">
                              {{number_format($informe_edit->modificaciones->where('categoria','FUERA DE NORMA')->where('variedad',$variedad)->where('calibre','L')->first()->retorno, 2, ',', '.') }} USD
                            </p>
                              @php
                                  $retorno_netol=$informe_edit->modificaciones->where('categoria','FUERA DE NORMA')->where('variedad',$variedad)->where('calibre','L')->first()->retorno;
                              @endphp
                          @else
                            {{ number_format(($retornol - ($margenl + $costosl)), 2, ',', '.') }} USD <br>
                            @php
                                $retorno_netol=($retornol - ($margenl + $costosl));
                            @endphp
                          @endif
                          
                        @endif

                        @if ($categoria_mod=="FUERA DE NORMA" && $variedad_mod==$variedad && $calibre_mod=="L" && $type_mod=="retorno")
                          <button wire:click="saveOrUpdateModification" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                            <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                            <span class="relative">Guardar</span>
                          </button>
                        @else
                          <span wire:click="set_modification('FUERA DE NORMA', '{{ $variedad }}', 'L','{{($retornol-($margenl+$costosl))}}','{{($retornol-($margenl+$costosl))/$pesonetol}}','{{$pesonetol}}','retorno')" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                            <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full text-xs"></span>
                            <span class="relative">Editar</span>
                            </span>
                        @endif
                          
                      </td>
                    
                      <td>
                        @if ($categoria_mod == "FUERA DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "L")
                          @if ($type_mod=="retorno")
                            {{$npk}} <br>
                          @else
                            <label for="npk" class="hidden text-sm font-medium text-gray-700">NPK</label>
                            <input
                                id="npk"
                                type="number"
                                step="0.01"
                                class="w-32 shadow-sm border-2 border-gray-300 bg-white h-10 px-2 rounded-lg focus:outline-none"
                                wire:model.live="npk"
                            >
                          @endif
                            
                        @else
                          @if ($informe_edit->modificaciones->where('categoria','FUERA DE NORMA')->where('variedad',$variedad)->where('calibre','L')->count()>0)
                            <p class="text-red-500 font-bold whitespace-nowrap">
                              {{number_format($informe_edit->modificaciones->where('categoria','FUERA DE NORMA')->where('variedad',$variedad)->where('calibre','L')->first()->npk, 2, ',', '.') }} USD/kg
                            </p>

                          @else
                            @if ($pesonetol)
                                <p class="whitespace-nowrap">
                                  {{ number_format(($retornol - ($margenl + $costosl)) / $pesonetol, 2, ',', '.') }} USD/kg
                                </p>
                            @else
                                0 USD/kg
                            @endif
                          @endif
                            
                        @endif

                        @if ($categoria_mod=="FUERA DE NORMA" && $variedad_mod==$variedad && $calibre_mod=="L" && $type_mod=="npk")
                          <button wire:click="saveOrUpdateModification" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                            <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                            <span class="relative">Guardar</span>
                          </button>
                        @else
                          <span wire:click="set_modification('FUERA DE NORMA', '{{ $variedad }}', 'L','{{($retornol-($margenl+$costosl))}}','{{($retornol-($margenl+$costosl))/$pesonetol}}','{{$pesonetol}}','npk')" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                            <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full text-xs"></span>
                            <span class="relative">Editar</span>
                            </span>
                        @endif
                          
                    </td>
                  
                     
                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-center">

                     
                      @if ($informe_edit->modificaciones->where('categoria','FUERA DE NORMA')->where('variedad',$variedad)->where('calibre','L')->count()>0)
                            @if ($informe_edit->modificaciones->where('categoria','FUERA DE NORMA')->where('variedad',$variedad)->where('calibre','L')->first()->retorno>$informe_edit->modificaciones->where('categoria','FUERA DE NORMA')->where('variedad',$variedad)->where('calibre','L')->first()->retorno_inicial)
                                <p class="text-green-500 font-bold"> +{{$informe_edit->modificaciones->where('categoria','FUERA DE NORMA')->where('variedad',$variedad)->where('calibre','L')->first()->retorno-$informe_edit->modificaciones->where('categoria','FUERA DE NORMA')->where('variedad',$variedad)->where('calibre','L')->first()->retorno_inicial}} usd
                              </p>
                            @else
                              <p class="text-red-500 font-bold"> {{$informe_edit->modificaciones->where('categoria','FUERA DE NORMA')->where('variedad',$variedad)->where('calibre','L')->first()->retorno-$informe_edit->modificaciones->where('categoria','FUERA DE NORMA')->where('variedad',$variedad)->where('calibre','L')->first()->retorno_inicial}} usd
                              </p>
                            @endif
                       <button title="Eliminar" class="cursorpointer text-xs text-red-500" wire:click="delete_modificacion('{{$informe_edit->modificaciones->where('categoria','FUERA DE NORMA')->where('variedad',$variedad)->where('calibre','L')->first()->id}}')" >(Eliminar)</button>
                      @endif
                       {{-- comment
                            <input wire:model="preciofob" class="w-32 shadow-sm  border-2 border-gray-300 bg-white h-10 px-2 rounded-lg focus:outline-none">   
                            <span wire:click='save_fobid()' class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                <span class="relative">Guardar</span>
                                </span>
                        --}}

                    </td>
                      
                    </tr>
                    @php
                      $calibrecount+=1;
                    @endphp
                  @endif
                  @endif
                 
                  
                  @if ($pesonetol>0)
                    
                    <tr>
                      <td></td>
                      <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">Total {{$variedad}}</td>
                      <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
                      <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; ">{{number_format($pesonetol,0,',','.')}} KGS</td>
                      <td>
                        {{number_format($retornol,2,',','.')}}
                      </td>
                      <td>
                        {{number_format(($margenl),2,',','.')}}
                      </td>
                 
                      <td>
                        {{number_format($costosl,2)}}
                      </td>
                      <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format($retorno_netol,2,',','.')}} USD 
                      
                      
                    </td>
                      <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format(($retorno_netol)/($pesonetol),2,',','.')}} USD/KG</td>
                      
                    </tr>
                  @endif
                    @php
                      $totalfr+=(($retorno_netol));
                      $variedadcount+=1;
                    @endphp
                  
        
                @endforeach
              
                @if ($pesonetototal>0)
                  
                <tr style="background-color: #ddd;">
                      
                  
                
                    <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">Total Fuera de Norma</td>
                  
                  
                    <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
                
                  
                  
                  <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"></td>
                  <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format($pesonetototal,0,',','.')}} KGS</td>
                  <td>{{number_format($totalretornol,2)}} usd</td>
                  <td>{{number_format(($totalmargenl),2)}} usd</td>
                 
                  <td>
                    {{number_format(($totalcostosl),2)}}
                  </td>
                  <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format($totalfr,2,',','.')}} USD 
                 
                  </td>
                  <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format($totalfr/$pesonetototal,2,',','.')}} usd/kg </td>
                  
                </tr>
                @endif
        
                @php
                  
                  $totalfueraodenorma=$totalfr;
                @endphp
                  
        
              </tbody>
            </table>

            <h1 class="mt-6">
              Fruta Mercado Interno
            </h1>
            <table id="balance" style="width:100%; border-collapse: collapse; margin-top: 20px;">
              <thead style="border-top: 2px solid black; border-bottom: 2px solid black;">
                <tr>
                <th>Norma</th>
                <th>Variedad</th>
                <th>Calibre</th>
                <th>Kg Embalado</th>
                
                <th>Ingresos</th>
                <th>Comision</th>
                <th>Costo </th>
                <th>Retorno Neto Productor</th>
                
                <th>NPK</th>
                </tr>
              </thead>
              <tbody>
                <tr style="background-color: #ddd;">
                        
                    <td> MERCADO INTERNO </td>
                
                
                    <td> </td>
                  
                  <td></td>
                  
                  <td></td>
                  <td></td>
                  <td></td>
                  <td ></td>
                  <td></td>
                  <td ></td>
                  <td>
                  </td>
                  <td>
        
                  </td>
                  
                </tr>
                @php
                  $variedadcount=1;
                  $cantidadtotal=0;
                  $pesonetototal=0;
                  $retornototal=0;
                    $totalretorno4j=0;
                    $totalretorno3j=0;
                    $totalretorno2j=0;
                    $totalretornoj=0;
                    $totalretornoxl=0;
                    $totalretornol=0;
                    $totalretornojup=0;

                    $totalmargenl=0;
                    $totalmargenjup=0;

                    $totalcostosl=0;
                    $totalcostosjup=0;

                    $totalcostopacking=0;
                    $globaltotalmateriales=0;

                    $totalpesonetol=0;

                    $globaltotalotroscostos=0;

                    $totalfr=0;
                    
                @endphp
                @foreach ($unique_variedades as $variedad)
                 
                    @php
                      $calibrecount=1;
                      
                      $cantidad4j=0;
                      $cantidad3j=0;
                      $cantidad2j=0;
                      $cantidadj=0;
                      $cantidadxl=0;
                      $cantidadl=0;
                      $cantidadjup=0;
                      
                      $pesoneto4j=0;
                      $pesoneto3j=0;
                      $pesoneto2j=0;
                      $pesonetoj=0;
                      $pesonetoxl=0;
                      $pesonetol=0;
                      $pesonetojup=0;
          
                      $retorno4j=0;
                      $retorno3j=0;
                      $retorno2j=0;
                      $retornoj=0;
                      $retornoxl=0;
                      $retornol=0;
                      $retornojup=0;

                      $retorno_netojup=0;

                      $margenl=0;
                      $margenjup=0;
                      
                      $costosl=0;
                      $costosjup=0;
          
                      $costopacking=0;
          
                      $totalmateriales4j=0;
                      $totalmateriales3j=0;
                      $totalmateriales2j=0;
                      $totalmaterialesj=0;
                      $totalmaterialesxl=0;
                      $totalmaterialesl=0;
          
                      $otroscostos=0;
                      $totalotroscostos=0;
                      
                      $masatotal=0;
          
                    @endphp
          
                    @foreach ($masas as $masa)
                      
                        @if (($masa->calibre_real=='4J') && $masa->variedad==$variedad)
                            @php
                              $cantidad4j+=floatval($masa->cantidad);
                              $pesoneto4j+=floatval($masa->peso_prorrateado);
                              if (!IS_NULL($masa->precio_fob)) {
                                                  $retorno4j+=floatval($masa->peso_prorrateado)*floatval($masa->precio_fob);
                                                  $totalretorno4j+=floatval($masa->peso_prorrateado)*floatval($masa->precio_fob);
                                                }
                              $cantidadtotal+=floatval($masa->cantidad);
                            
                              foreach ($materialestotal as $material) {
                                  if ($material->c_embalaje==$masa->cod_embalaje) {
                                    $totalmateriales4j+=$masa->peso_prorrateado*$material->tarifa_kg;
                                  }  
                                }
                      
                            @endphp	
                        @endif
                        @if (($masa->calibre_real=='3J') && $masa->variedad==$variedad)
                            @php
                              $cantidad3j+=$masa->cantidad;
                              $pesoneto3j+=floatval($masa->peso_prorrateado);
                              if (!IS_NULL($masa->precio_fob)) {
                                                  $retorno3j+=floatval($masa->peso_prorrateado)*floatval($masa->precio_fob);
                                                  $totalretorno3j+=floatval($masa->peso_prorrateado)*floatval($masa->precio_fob);
                                                }
                              $cantidadtotal+=$masa->cantidad;
                              foreach ($materialestotal as $material) {
                                  if ($material->c_embalaje==$masa->cod_embalaje) {
                                    $totalmateriales3j+=$masa->peso_prorrateado*$material->tarifa_kg;
                                  }  
                                }
                            @endphp	
                        @endif
                        @if (($masa->calibre_real=='2J') && $masa->variedad==$variedad)
                            @php
                              $cantidad2j+=$masa->cantidad;
                              $pesoneto2j+=floatval($masa->peso_prorrateado);
                              if (!IS_NULL($masa->precio_fob)) {
                                                  $retorno2j+=floatval($masa->peso_prorrateado)*floatval($masa->precio_fob);
                                                  $totalretorno2j+=floatval($masa->peso_prorrateado)*floatval($masa->precio_fob);
                                                }
                              $cantidadtotal+=$masa->cantidad;
                              foreach ($materialestotal as $material) {
                                  if ($material->c_embalaje==$masa->cod_embalaje) {
                                    $totalmateriales2j+=$masa->peso_prorrateado*$material->tarifa_kg;
                                  }  
                                }
                            @endphp	
                        @endif
                        @if (($masa->calibre_real=='J') && $masa->variedad==$variedad)
                            @php
                              $cantidadj+=$masa->cantidad;
                                $pesonetoj+=floatval($masa->peso_prorrateado);
                                if (!IS_NULL($masa->precio_fob)) {
                                $retornoj+=floatval($masa->peso_prorrateado)*floatval($masa->precio_fob);
                                $totalretornoj+=floatval($masa->peso_prorrateado)*floatval($masa->precio_fob);
                                }
                                $cantidadtotal+=$masa->cantidad;
                                foreach ($materialestotal as $material) {
                                  if ($material->c_embalaje==$masa->cod_embalaje) {
                                    $totalmaterialesj+=$masa->peso_prorrateado*$material->tarifa_kg;
                                  }  
                                }
                            @endphp	
                        @endif
                        @if (($masa->calibre_real=='XL') && $masa->variedad==$variedad)
                            @php
                              $cantidadxl+=$masa->cantidad;
                              $pesonetoxl+=floatval($masa->peso_prorrateado);
                              if (!IS_NULL($masa->precio_fob)) {
                                                  $retornoxl+=floatval($masa->peso_prorrateado)*floatval($masa->precio_fob);
                                                  $totalretornoxl+=floatval($masa->peso_prorrateado)*floatval($masa->precio_fob);
                                                }
                              $cantidadtotal+=$masa->cantidad;
                              foreach ($materialestotal as $material) {
                                  if ($material->c_embalaje==$masa->cod_embalaje) {
                                    $totalmaterialesxl+=$masa->peso_prorrateado*$material->tarifa_kg;
                                  }  
                                }
                            @endphp	
                        @endif
                        
                        @if (($masa->calibre_real=='L') && $masa->variedad==$variedad)
                          @php
                            $cantidadl+=$masa->cantidad;
                            $pesonetol+=floatval($masa->peso_prorrateado);

                          
                          

                            $costosl+=floatval($masa->costo);
                            $totalcostosl+=floatval($masa->costo);

                            if (!IS_NULL($masa->fob)) {
                              $tarifafinal=0;
                            
                                if ($masa->fob->tarifas->count()>0) {
                                    
                                    $tarifafinal=$masa->fob->tarifas->reverse()->first()->tarifa_fc;
                                  
                                }
                                                  $retornol+=floatval($masa->peso_prorrateado*$tarifafinal);
                                                  $totalretornol+=floatval($masa->peso_prorrateado*$tarifafinal);
                                                  $margenl+=floatval($masa->peso_prorrateado*$tarifafinal*0.08);
                                                  $totalmargenl+=floatval($masa->peso_prorrateado*$tarifafinal*0.08);
                            }
                            $cantidadtotal+=$masa->cantidad;
                            //$pesonetototal+=floatval($masa->peso_prorrateado);
                          
          
                          @endphp	
                        @endif

                        @if (($masa->calibre_real=='JUP') && $masa->variedad==$variedad)
                          @php
                            $cantidadjup+=$masa->cantidad;
                            $pesonetojup+=floatval($masa->peso_prorrateado);

                            $costosjup+=floatval($masa->costo);
                            $totalcostosjup+=floatval($masa->costo);

                            if (!IS_NULL($masa->fob)) {
                              $tarifafinal=0;
                            
                                if ($masa->fob->tarifas->count()>0) {
                                    
                                    $tarifafinal=$masa->fob->tarifas->reverse()->first()->tarifa_fc;
                                  
                                }
                                                  $retornojup+=floatval($masa->peso_prorrateado*$tarifafinal);
                                                  $totalretornojup+=floatval($masa->peso_prorrateado*$tarifafinal);
                                                  $margenjup+=0;
                                                  $totalmargenjup+=0;
                            }
                            $cantidadtotal+=$masa->cantidad;
                            $pesonetototal+=floatval($masa->peso_prorrateado);
                          
          
                          @endphp	
                        @endif

                        @if ($masa->calibre_real=='4J' || $masa->calibre_real=='3J'|| $masa->calibre_real=='2J' || $masa->calibre_real=='J' || $masa->calibre_real=='XL' || $masa->calibre_real=='L'|| $masa->calibre_real=='JUP')
                              @php
                                    $masatotal+=$masa->peso_prorrateado;
                              @endphp
                        @endif
                      
                  
                    

                    @endforeach
          
          
                    @php
                        $totalotroscostos+=($otroscostos)*(($pesonetol)/($masatotal));
                        
                        $globaltotalotroscostos+=$totalotroscostos;
                    @endphp
          
                      
                    
                      @if ($pesonetojup>0)
                        <tr style="background-color: white;">
      


                          <td> </td>
                        
                          <td> {{$variedad}} </td>
                      
                        
                        
                        
                          <td></td>
                          <td ></td>
                          <td>
                          </td>
                          <td>
              
                          </td>
                          
                        </tr>
                        <tr>
                          <td> </td>
                          <td> </td>
                          <td>JUP</td>
                          <td style="text-align:right; padding-right:30px; border-left: 1px solid #ddd; " >{{number_format($pesonetojup,0,',','.')}} KGS</td>
                          <td>{{number_format(($retornojup),2,',','.')}}
                          <td>{{number_format(($margenjup),2,',','.')}}
                          </td>
                        
                          <td>
                            {{number_format($costosjup,2)}}
                          </td>
                          <td>
                            @if ($categoria_mod == "MERCADO INTERNO" && $variedad_mod == $variedad && $calibre_mod == "JUP")
                              @if ($type_mod=="npk")
                                {{$retorno}} <br>
                              @else
                                <label for="retorno" class="hidden text-sm font-medium text-gray-700">Retorno</label>
                                <input
                                    id="retorno"
                                    type="number" 
                                    step="0.01"
                                    class="w-32 shadow-sm border-2 border-gray-300 bg-white h-10 px-2 rounded-lg focus:outline-none"
                                    wire:model.live="retorno"
                                    
                                >
                              @endif
                            
                              
                            @else
  
                              @if ($informe_edit->modificaciones->where('categoria','MERCADO INTERNO')->where('variedad',$variedad)->where('calibre','JUP')->count()>0)
                                <p class="text-red-500 font-bold whitespace-nowrap">
                                  {{number_format($informe_edit->modificaciones->where('categoria','MERCADO INTERNO')->where('variedad',$variedad)->where('calibre','JUP')->first()->retorno, 2, ',', '.') }} USD
                                </p>
                                @php
                                    $retorno_netojup=$informe_edit->modificaciones->where('categoria','MERCADO INTERNO')->where('variedad',$variedad)->where('calibre','JUP')->first()->retorno;
                                @endphp
                              @else
                                {{ number_format(($retornojup - ($margenjup + $costosjup)), 2, ',', '.') }} USD <br>
                                @php
                                    $retorno_netojup=($retornojup - ($margenjup + $costosjup));
                                @endphp
                              @endif
                              
                            @endif
  
                            @if ($categoria_mod=="MERCADO INTERNO" && $variedad_mod==$variedad && $calibre_mod=="JUP" && $type_mod=="retorno")
                              <button wire:click="saveOrUpdateModification" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                <span class="relative">Guardar</span>
                              </button>
                            @else
                              <span wire:click="set_modification('MERCADO INTERNO', '{{ $variedad }}', 'JUP','{{($retornojup-($margenjup+$costosjup))}}','{{($retornojup-($margenjup+$costosjup))/$pesonetojup}}','{{$pesonetojup}}','retorno')" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full text-xs"></span>
                                <span class="relative">Editar</span>
                                </span>
                            @endif
                              
                          </td>
                        
                          <td>
                            @if ($categoria_mod == "MERCADO INTERNO" && $variedad_mod == $variedad && $calibre_mod == "JUP")
                              @if ($type_mod=="retorno")
                                {{$npk}} <br>
                              @else
                                <label for="npk" class="hidden text-sm font-medium text-gray-700">NPK</label>
                                <input
                                    id="npk"
                                    type="number"
                                    step="0.01"
                                    class="w-32 shadow-sm border-2 border-gray-300 bg-white h-10 px-2 rounded-lg focus:outline-none"
                                    wire:model.live="npk"
                                >
                              @endif
                                
                            @else
                              @if ($informe_edit->modificaciones->where('categoria','MERCADO INTERNO')->where('variedad',$variedad)->where('calibre','JUP')->count()>0)
                                <p class="text-red-500 font-bold whitespace-nowrap">
                                  {{number_format($informe_edit->modificaciones->where('categoria','MERCADO INTERNO')->where('variedad',$variedad)->where('calibre','JUP')->first()->npk, 2, ',', '.') }} USD/kg
                                </p>

                              @else
                                @if ($pesonetojup)
                                    <p class="whitespace-nowrap">
                                      {{ number_format(($retorno_netojup) / $pesonetojup, 2, ',', '.') }} USD/kg
                                    </p>
                                @else
                                    0 USD/kg
                                @endif
                              @endif
                                
                            @endif

                            @if ($categoria_mod=="MERCADO INTERNO" && $variedad_mod==$variedad && $calibre_mod=="JUP" && $type_mod=="npk")
                              <button wire:click="saveOrUpdateModification" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                <span class="relative">Guardar</span>
                              </button>
                            @else
                              <span wire:click="set_modification('MERCADO INTERNO', '{{ $variedad }}', 'JUP','{{($retornojup-($margenjup+$costosjup))}}','{{($retornojup-($margenjup+$costosjup))/$pesonetojup}}','{{$pesonetojup}}','npk')" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full text-xs"></span>
                                <span class="relative">Editar</span>
                                </span>
                            @endif
                              
                        </td>
                        <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-center">

                        
                          @if ($informe_edit->modificaciones->where('categoria','MERCADO INTERNO')->where('variedad',$variedad)->where('calibre','JUP')->count()>0)
                            @if ($informe_edit->modificaciones->where('categoria','MERCADO INTERNO')->where('variedad',$variedad)->where('calibre','JUP')->first()->retorno>$informe_edit->modificaciones->where('categoria','MERCADO INTERNO')->where('variedad',$variedad)->where('calibre','JUP')->first()->retorno_inicial)
                                <p class="text-green-500 font-bold"> +{{$informe_edit->modificaciones->where('categoria','MERCADO INTERNO')->where('variedad',$variedad)->where('calibre','JUP')->first()->retorno-$informe_edit->modificaciones->where('categoria','MERCADO INTERNO')->where('variedad',$variedad)->where('calibre','JUP')->first()->retorno_inicial}} usd
                              </p>
                            @else
                              <p class="text-red-500 font-bold"> {{$informe_edit->modificaciones->where('categoria','MERCADO INTERNO')->where('variedad',$variedad)->where('calibre','JUP')->first()->retorno-$informe_edit->modificaciones->where('categoria','MERCADO INTERNO')->where('variedad',$variedad)->where('calibre','JUP')->first()->retorno_inicial}} usd
                              </p>
                            @endif
                            <button title="Eliminar" class="cursorpointer text-xs text-red-500" wire:click="delete_modificacion('{{$informe_edit->modificaciones->where('categoria','MERCADO INTERNO')->where('variedad',$variedad)->where('calibre','JUP')->first()->id}}')" >(Eliminar)</button>
                          @endif
                          {{-- comment
                                <input wire:model="preciofob" class="w-32 shadow-sm  border-2 border-gray-300 bg-white h-10 px-2 rounded-lg focus:outline-none">   
                                <span wire:click='save_fobid()' class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                    <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                    <span class="relative">Guardar</span>
                                    </span>
                            --}}

                        </td>
                          
                        </tr>
                        @php
                          $calibrecount+=1;
                        @endphp
                      @endif
                  
                    
                      @if ($pesonetojup>0)
                        
                        <tr>
                          <td></td>
                          <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">Total {{$variedad}}</td>
                          <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
                          <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; ">{{number_format($pesonetojup,0,',','.')}} KGS</td>
                          <td>
                            {{number_format($retornojup,2,',','.')}}
                          </td>
                          <td>
                            {{number_format(($margenjup),2,',','.')}}
                          </td>
                    
                          <td>
                            {{number_format($costosjup,2)}}
                          </td>
                          <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format(($retorno_netojup),2,',','.')}} USD 
                          
                          
                          </td>
                          <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format(($retorno_netojup)/($pesonetojup),2,',','.')}} USD/KG</td>
                          
                        </tr>
                      @endif

                      @php
                        $totalfr+=(($retorno_netojup));
                        $variedadcount+=1;
                      @endphp
                    
          
                  @endforeach
                
                  @if ($pesonetototal>0)
                    
                  <tr style="background-color: #ddd;">
                        
                    
                  
                      <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">Total Mercado Interno</td>
                    
                    
                      <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
                  
                    
                    
                    <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"></td>
                    <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format($pesonetototal,0,',','.')}} KGS</td>
                    <td>{{number_format($totalretornojup,2)}} usd</td>
                    <td>{{number_format(($totalmargenjup),2)}} usd</td>
                  
                    <td>
                      {{number_format(($totalcostosjup),2)}}
                    </td>
                    <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format($totalfr,2,',','.')}} USD 
                  
                    </td>
                    <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format($totalfr/$pesonetototal,2,',','.')}} usd/kg </td>
                    
                  </tr>
                  @endif
          
                  @php
                    
                    $totalfueraodenorma=$totalfr;
                  @endphp
                    
          
                </tbody>
              </table>


            <h1 class="mt-6">
                Listado de Calibres
            </h1>
            @foreach ($unique_calibres as $calibre)
                                                    
                {{$calibre}}<br>
             
            @endforeach

            <h1 class="mt-6">
              Listado de Variedades
            </h1>
            @foreach ($unique_variedades as $variedad)
                                                    
                {{$variedad}}<br>
             
            @endforeach

          @endif
            
         

            

          </div>
        </div>
      </div>
    </div>

    <script>
      document.addEventListener('livewire:load', function () {
          Livewire.on('mostrar-mensaje', (data) => {
              Swal.fire({
                  icon: data.tipo,
                  title: data.mensaje,
                  showConfirmButton: false,
                  timer: 2000
              });
          });
      });
  </script>



  </div>