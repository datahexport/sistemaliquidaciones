<div class="mt-4 space-y-2 px-8">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    #balance thead {
      position: sticky;
      top: 0;
      background-color: white; /* o el color que desees para fondo */
      z-index: 10; /* para que quede sobre el contenido */
    }
  </style>
  
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

      <div wire:loading wire:target="toggleSemana, set_informe_edit, set_modification, saveOrUpdateModification, retorno, npk, set_informe_oficial, delete_modificacion">
                              
        <div class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-50 z-50">
          <div class="max-w-sm w-full sm:rounded-2xl bg-white border-2 border-gray-200 shadow-xl">
            <div class="w-full">
              <div class="px-6 my-6 mx-auto">
                <div class="mb-8">
                  <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-extrabold mr-4" wire:loading wire:target="toggleSemana, set_informe_edit, set_modification, saveOrUpdateModification, retorno, npk, set_informe_oficial">Cargando...</h1>
                    <h1 class="text-2xl font-extrabold mr-4" wire:loading wire:target="delete_modificacion">Eliminando...</h1>
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
            
            <h1 class="hidden mt-6 text-xl font-bold text-right">
             0  Modificaciones
            </h1>

            <div>
              <label class="flex justify-between items-center cursor-pointer">
                <span class="ml-3 text-gray-700">Desglose por semana en fruta Dentro de Norma</span>
                  <div class="relative">
                      <input type="checkbox"
                          wire:click="toggleSemana('semana_dentrodenorma')"
                          class="sr-only"
                          {{ $informe_edit->semana_dentrodenorma === 'si' ? 'checked' : '' }}>
                      <div class="block w-14 h-8 rounded-full transition
                          {{ $informe_edit->semana_dentrodenorma === 'si' ? 'bg-blue-500' : 'bg-gray-300' }}">
                      </div>
                      <div class="dot absolute left-1 top-1 w-6 h-6 rounded-full bg-white shadow transition
                          {{ $informe_edit->semana_dentrodenorma === 'si' ? 'translate-x-6' : '' }}">
                      </div>
                  </div>
                  
              </label>
          </div>
      
       
          
          @if ($informe_edit)
          <div style="max-height: 600px; overflow-y: auto;">
            <table id="balance" style="width:100%; border-collapse: collapse; margin-top: 20px;">
              <thead style="border-top: 2px solid black; border-bottom: 2px solid black;">
                <tr>
                  <th>Norma</th>
                  <th>Variedad</th>
                  @if ($informe_edit->semana_dentrodenorma=='si')
                    <th>Semana</th>
                    <th></th>
                    <th></th>
                  @endif
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
              @if ($informe_edit->semana_dentrodenorma=='si')
                <tbody>
                    <tr style="background-color: #ddd;">
                            
                        <td> DENTRO DE NORMA </td>
                    
                    
                        <td> </td>
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
                      $semanacounter=1;
                      $variedadcount=1;
                      $cantidadtotal=0;
                      $pesonetototal=0;
                      $retornototal=0;
                      
                      $totalretorno5j=0;
                      $totalretorno4j=0;
                        $totalretorno3j=0;
                        $totalretorno2j=0;
                        $totalretornoj=0;
                        $totalretornoxl=0;

                        $totalmargen5j=0;
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

                        $totalcostos5j=0;
                        $totalcostos4j=0;
                        $totalcostos3j=0;
                        $totalcostos2j=0;
                        $totalcostosj=0;
                        $totalcostosxl=0;
                        
                    @endphp
                  
                      @foreach ($unique_variedades as $variedad)
                        <tr style="background-color: white;">
          


                          <td> </td>
                        
                          <td style="font-weight: bold; text-align: center;"> {{$variedad}} </td>
                      
                        
                          <td></td>
                          <td></td>
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
                              
                              
                              $cantidad5j=0;
                              $cantidad4j=0;
                              $cantidad3j=0;
                              $cantidad2j=0;
                              $cantidadj=0;
                              $cantidadxl=0;
                              
                              $pesoneto5j=0;
                              $pesoneto4j=0;
                              $pesoneto3j=0;
                              $pesoneto2j=0;
                              $pesonetoj=0;
                              $pesonetoxl=0;
                              $pesonetol=0;
                  
                              
                              $retorno5j=0;
                              $retorno4j=0;
                              $retorno3j=0;
                              $retorno2j=0;
                              $retornoj=0;
                              $retornoxl=0;

                              $retorno_neto5j=0;
                              $retorno_neto4j=0;
                              $retorno_neto3j=0;
                              $retorno_neto2j=0;
                              $retorno_netoj=0;
                              $retorno_netoxl=0;

                              $margen5j=0;
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

                              $costos5j=0;
                              $costos4j=0;
                              $costos3j=0;
                              $costos2j=0;
                              $costosj=0;
                              $costosxl=0;
                  
                              $otroscostos=0;
                              $totalotroscostos=0;
                              
                              
                              $masatotal=0;
                  
                        @endphp
                        @foreach ($unique_semanas as $semana)
                          @if ($semana)
                            
                            @php
                              $calibrecount=1;
                              
                              
                              $cantidad5j_semana=0;
                              $cantidad4j_semana=0;
                              $cantidad3j_semana=0;
                              $cantidad2j_semana=0;
                              $cantidadj_semana=0;
                              $cantidadxl_semana=0;
                              
                              $pesoneto5j_semana=0;
                              $pesoneto4j_semana=0;
                              $pesoneto3j_semana=0;
                              $pesoneto2j_semana=0;
                              $pesonetoj_semana=0;
                              $pesonetoxl_semana=0;
                              $pesonetol_semana=0;
                  
                              
                              $retorno5j_semana=0;
                              $retorno4j_semana=0;
                              $retorno3j_semana=0;
                              $retorno2j_semana=0;
                              $retornoj_semana=0;
                              $retornoxl_semana=0;

                              $retorno_neto5j_semana=0;
                              $retorno_neto4j_semana=0;
                              $retorno_neto3j_semana=0;
                              $retorno_neto2j_semana=0;
                              $retorno_netoj_semana=0;
                              $retorno_netoxl_semana=0;

                              $margen5j_semana=0;
                              $margen4j_semana=0;
                              $margen3j_semana=0;
                              $margen2j_semana=0;
                              $margenj_semana=0;
                              $margenxl_semana=0;
                  
                              $costopacking=0;
                  
                              $totalmateriales4j_semana=0;
                              $totalmateriales3j_semana=0;
                              $totalmateriales2j_semana=0;
                              $totalmaterialesj_semana=0;
                              $totalmaterialesxl_semana=0;

                              $costos5j_semana=0;
                              $costos4j_semana=0;
                              $costos3j_semana=0;
                              $costos2j_semana=0;
                              $costosj_semana=0;
                              $costosxl_semana=0;
                  
                              $otroscostos_semana=0;
                              $totalotroscostos_semana=0;
                              
                              
                              $masatotal_semana=0;
                  
                            @endphp
                  
                            @foreach ($masas->where('tipo','EXPORTACIÓN')->where('semana',$semana) as $masa)
                              @php
                                  $tarifafinal = 0;
                                  if (!is_null($masa->fob)) {
                                      if ($masa->fob->tarifas->count() > 0) {
                                          $tarifafinal = $masa->fob->tarifas->reverse()->first()->tarifa_fc;
                                          $tarifafinal2 = $masa->fob->tarifas->reverse()->first()->tarifa;
                                      }
                                  }
                              @endphp
                          
                              @if (($masa->calibre_real == '5J') && $masa->variedad == $variedad)
                                @php
                                  // Versión semanal
                                  $cantidad5j_semana += floatval($masa->cantidad);
                                  $pesoneto5j_semana += floatval($masa->peso_prorrateado);
                              
                                  if (!is_null($masa->fob)) {
                                      $retorno5j_semana += floatval($masa->peso_prorrateado * $tarifafinal);
                                      $retorno_neto5j_semana += floatval($masa->peso_prorrateado * $tarifafinal);
                                      $margen5j_semana += floatval($masa->peso_prorrateado * $tarifafinal * 0.08);
                                  }
                              
                                  $costos5j_semana += floatval($masa->costo);
                              
                                  // Versión total (sin _semana)
                                  $cantidad5j += floatval($masa->cantidad);
                                  $pesoneto5j += floatval($masa->peso_prorrateado);
                              
                                  if (!is_null($masa->fob)) {
                                      $retorno5j += floatval($masa->peso_prorrateado * $tarifafinal);
                                      $margen5j += floatval($masa->peso_prorrateado * $tarifafinal * 0.08);
                                  }
                              
                                  $costos5j += floatval($masa->costo);
                                @endphp
                              @endif
                        
                          
                              @if (($masa->calibre_real == '4J') && $masa->variedad == $variedad)
                                @php
                                    // Semana
                                    $cantidad4j_semana += floatval($masa->cantidad);
                                    $pesoneto4j_semana += floatval($masa->peso_prorrateado);
                                    if (!is_null($masa->fob)) {
                                        $retorno4j_semana += floatval($masa->peso_prorrateado * $tarifafinal);
                                        $retorno_neto4j_semana += floatval($masa->peso_prorrateado * $tarifafinal);
                                        $margen4j_semana += floatval($masa->peso_prorrateado * $tarifafinal * 0.08);
                                    }
                                    $costos4j_semana += floatval($masa->costo);
                                    $totalmateriales4j_semana += floatval($masa->costo);
                              
                                    // Total
                                    $cantidad4j += floatval($masa->cantidad);
                                    $pesoneto4j += floatval($masa->peso_prorrateado);
                                    if (!is_null($masa->fob)) {
                                        $retorno4j += floatval($masa->peso_prorrateado * $tarifafinal);
                                        $margen4j += floatval($masa->peso_prorrateado * $tarifafinal * 0.08);
                                    }
                                    $costos4j += floatval($masa->costo);
                                    $totalmateriales4j += floatval($masa->costo);
                                @endphp
                              @endif
                              
                              @if (($masa->calibre_real == '3J') && $masa->variedad == $variedad)
                                @php
                                    $cantidad3j_semana += floatval($masa->cantidad);
                                    $pesoneto3j_semana += floatval($masa->peso_prorrateado);
                                    if (!is_null($masa->fob)) {
                                        $retorno3j_semana += floatval($masa->peso_prorrateado * $tarifafinal);
                                        $retorno_neto3j_semana += floatval($masa->peso_prorrateado * $tarifafinal);
                                        $margen3j_semana += floatval($masa->peso_prorrateado * $tarifafinal * 0.08);
                                    }
                                    $costos3j_semana += floatval($masa->costo);
                                    $totalmateriales3j_semana += floatval($masa->costo);
                              
                                    $cantidad3j += floatval($masa->cantidad);
                                    $pesoneto3j += floatval($masa->peso_prorrateado);
                                    if (!is_null($masa->fob)) {
                                        $retorno3j += floatval($masa->peso_prorrateado * $tarifafinal);
                                        $margen3j += floatval($masa->peso_prorrateado * $tarifafinal * 0.08);
                                    }
                                    $costos3j += floatval($masa->costo);
                                    $totalmateriales3j += floatval($masa->costo);
                                @endphp
                              @endif
                              
                              @if (($masa->calibre_real == '2J') && $masa->variedad == $variedad)
                                @php
                                    $cantidad2j_semana += floatval($masa->cantidad);
                                    $pesoneto2j_semana += floatval($masa->peso_prorrateado);
                                    if (!is_null($masa->fob)) {
                                        $retorno2j_semana += floatval($masa->peso_prorrateado * $tarifafinal);
                                        $retorno_neto2j_semana += floatval($masa->peso_prorrateado * $tarifafinal);
                                        $margen2j_semana += floatval($masa->peso_prorrateado * $tarifafinal * 0.08);
                                    }
                                    $costos2j_semana += floatval($masa->costo);
                                    $totalmateriales2j_semana += floatval($masa->costo);
                              
                                    $cantidad2j += floatval($masa->cantidad);
                                    $pesoneto2j += floatval($masa->peso_prorrateado);
                                    if (!is_null($masa->fob)) {
                                        $retorno2j += floatval($masa->peso_prorrateado * $tarifafinal);
                                        $margen2j += floatval($masa->peso_prorrateado * $tarifafinal * 0.08);
                                    }
                                    $costos2j += floatval($masa->costo);
                                    $totalmateriales2j += floatval($masa->costo);
                                @endphp
                              @endif
                              
                              @if (($masa->calibre_real == 'J') && $masa->variedad == $variedad)
                                @php
                                    $cantidadj_semana += floatval($masa->cantidad);
                                    $pesonetoj_semana += floatval($masa->peso_prorrateado);
                                    if (!is_null($masa->fob)) {
                                        $retornoj_semana += floatval($masa->peso_prorrateado * $tarifafinal);
                                        $retorno_netoj_semana += floatval($masa->peso_prorrateado * $tarifafinal);
                                        $margenj_semana += floatval($masa->peso_prorrateado * $tarifafinal * 0.08);
                                    }
                                    $costosj_semana += floatval($masa->costo);
                                    $totalmaterialesj_semana += floatval($masa->costo);
                              
                                    $cantidadj += floatval($masa->cantidad);
                                    $pesonetoj += floatval($masa->peso_prorrateado);
                                    if (!is_null($masa->fob)) {
                                        $retornoj += floatval($masa->peso_prorrateado * $tarifafinal);
                                        $margenj += floatval($masa->peso_prorrateado * $tarifafinal * 0.08);
                                    }
                                    $costosj += floatval($masa->costo);
                                    $totalmaterialesj += floatval($masa->costo);
                                @endphp
                              @endif
                              
                              @if (($masa->calibre_real == 'XL') && $masa->variedad == $variedad)
                                @php
                                    $cantidadxl_semana += floatval($masa->cantidad);
                                    $pesonetoxl_semana += floatval($masa->peso_prorrateado);
                                    if (!is_null($masa->fob)) {
                                        $retornoxl_semana += floatval($masa->peso_prorrateado * $tarifafinal);
                                        $retorno_netoxl_semana += floatval($masa->peso_prorrateado * $tarifafinal);
                                        $margenxl_semana += floatval($masa->peso_prorrateado * $tarifafinal * 0.08);
                                    }
                                    $costosxl_semana += floatval($masa->costo);
                                    $totalmaterialesxl_semana += floatval($masa->costo);
                              
                                    $cantidadxl += floatval($masa->cantidad);
                                    $pesonetoxl += floatval($masa->peso_prorrateado);
                                    if (!is_null($masa->fob)) {
                                        $retornoxl += floatval($masa->peso_prorrateado * $tarifafinal);
                                        $margenxl += floatval($masa->peso_prorrateado * $tarifafinal * 0.08);
                                    }
                                    $costosxl += floatval($masa->costo);
                                    $totalmaterialesxl += floatval($masa->costo);
                                @endphp
                              @endif
                              
                          
                              @if (($masa->calibre_real == 'L') && $masa->variedad == $variedad)
                                  @php
                                      $pesonetol_semana += floatval($masa->peso_prorrateado);
                                  @endphp
                              @endif
                          
                              @if (in_array($masa->calibre_real, ['5J','4J', '3J', '2J', 'J', 'XL']) && $masa->variedad == $variedad)
                                  @php
                                      $masatotal_semana += floatval($masa->peso_prorrateado);
                                     
                                  @endphp
                              @endif
                            @endforeach
                            @php
                                 $pesonetototal+=$masatotal_semana;

                                 $totalretorno5j+=$retorno5j_semana;
                                 $totalretorno4j+=$retorno4j_semana;
                                 $totalretorno3j+=$retorno3j_semana;
                                 $totalretorno2j+=$retorno2j_semana;
                                 $totalretornoj+=$retornoj_semana;
                                 $totalretornoxl+=$retornoxl_semana;

                                  $totalmargen5j += $margen5j_semana;
                                  $totalmargen4j += $margen4j_semana;
                                  $totalmargen3j += $margen3j_semana;
                                  $totalmargen2j += $margen2j_semana;
                                  $totalmargenj  += $margenj_semana;
                                  $totalmargenxl += $margenxl_semana;

                                  $totalcostos5j += $costos5j_semana;
                                  $totalcostos4j += $costos4j_semana;
                                  $totalcostos3j += $costos3j_semana;
                                  $totalcostos2j += $costos2j_semana;
                                  $totalcostosj  += $costosj_semana;
                                  $totalcostosxl += $costosxl_semana;


                                 
                            @endphp
                            @if ($cantidad5j_semana+$cantidad4j_semana+$cantidad3j_semana+$cantidad2j_semana+$cantidadj_semana+$cantidadxl_semana>0)

                              <tr style="background-color: white;">
              


                                <td> </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td> {{$semana}} </td>
                            
                              
                              
                              
                                
                                <td ></td>
                                <td>
                                </td>
                                <td>
                    
                                </td>
                                <td>
                    
                                </td>
                                
                              </tr>
                              
                              @if ($pesoneto5j_semana > 0)
                                <tr>
                                  <td> </td>
                                  <td> </td>
                                  <td> </td>
                                  <td> </td>
                                  <td> </td>
                                  <td>5J</td>
                                  <td style="text-align:right; padding-right:30px;border-left: 1px solid #ddd;">
                                    {{ number_format($pesoneto5j_semana, 2, ',', '.') }} KGS
                                  </td>
                                  <td>{{ number_format($retorno5j_semana, 2, ',', '.') }}</td>
                                  <td>{{ number_format($margen5j_semana, 2, ',', '.') }}</td>
                                  <td>{{ number_format($costos5j_semana, 2) }}</td>
                                  {{-- npk --}}
                                  <td>
                                    @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "5J" && $semana_mod == $semana)
                                      @if ($type_mod == "npk")
                                        {{ $retorno }} <br>
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
                                      @php
                                        $retorno_neto5j_semana = $retorno;
                                      @endphp
                                    @else
                                      @if ($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','5J')->where('semana',$semana)->count() > 0)
                                        <p class="text-red-500 font-bold whitespace-nowrap">
                                          {{ number_format($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','5J')->where('semana',$semana)->first()->retorno, 2, ',', '.') }} USD
                                        </p>
                                        @php
                                          $retorno_neto5j_semana = $informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','5J')->where('semana',$semana)->first()->retorno;
                                        @endphp
                                      @else
                                        {{ number_format(($retorno5j_semana - ($margen5j_semana + $costos5j_semana)), 2, ',', '.') }} USD <br>
                                        @php
                                          $retorno_neto5j_semana = $retorno5j_semana - ($margen5j_semana + $costos5j_semana);
                                        @endphp
                                      @endif
                                    @endif
                                      @php
                                           $retorno_neto5j+= $retorno_neto5j_semana;
                                      @endphp
                                    @if ($categoria_mod=="DENTRO DE NORMA" && $variedad_mod==$variedad && $calibre_mod=="5J" && $semana_mod == $semana && $type_mod=="retorno")
                                      <button wire:click="saveOrUpdateModification" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                        <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                        <span class="relative">Guardar</span>
                                      </button>
                                    @else
                                      <span wire:click="set_modification('DENTRO DE NORMA', '{{ $variedad }}', '5J','{{($retorno_neto5j_semana)}}','{{($retorno_neto5j_semana)/$pesoneto5j_semana}}','{{$pesoneto5j_semana}}','retorno',{{$semana}})" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                        <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full text-xs"></span>
                                        <span class="relative">Editar</span>
                                      </span>
                                    @endif
                                  </td>
                                  {{-- retorno --}}
                                  <td>
                                    @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "5J" && $semana_mod == $semana)
                                      @if ($type_mod == "retorno")
                                        {{ $npk }} <br>
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
                                      @if ($informe_edit->modificaciones->where('categoria', 'DENTRO DE NORMA')->where('variedad', $variedad)->where('calibre', '5J')->where('semana',$semana)->count() > 0)
                                        <p class="text-red-500 font-bold whitespace-nowrap">
                                          {{ number_format($informe_edit->modificaciones->where('categoria', 'DENTRO DE NORMA')->where('variedad', $variedad)->where('calibre', '5J')->where('semana',$semana)->first()->npk, 2, ',', '.') }} USD/kg
                                        </p>
                                      @else
                                        @if ($pesoneto5j_semana)
                                          <p class="whitespace-nowrap">
                                            {{ number_format(($retorno5j_semana - ($margen5j_semana + $costos5j_semana)) / $pesoneto5j_semana, 2, ',', '.') }} USD/kg
                                          </p>
                                        @else
                                          0 USD/kg
                                        @endif
                                      @endif
                                    @endif
                                  
                                    @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "5J" && $semana_mod == $semana && $type_mod == "npk")
                                      <button wire:click="saveOrUpdateModification" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                        <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                        <span class="relative">Guardar</span>
                                      </button>
                                    @else
                                      <span wire:click="set_modification('DENTRO DE NORMA', '{{ $variedad }}', '5J','{{($retorno_neto5j_semana)}}','{{($retorno_neto5j_semana)/$pesoneto5j_semana}}','{{$pesoneto5j_semana}}','npk','{{$semana}}')" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                        <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full text-xs"></span>
                                        <span class="relative">Editar</span>
                                      </span>
                                    @endif
                                  </td>
                                  {{-- eliminar --}}
                                  <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-center">
                                    @if ($informe_edit->modificaciones->where('categoria', 'DENTRO DE NORMA')->where('variedad', $variedad)->where('calibre', '5J')->where('semana',$semana)->count() > 0)
                                      @php
                                        $mod = $informe_edit->modificaciones->where('categoria', 'DENTRO DE NORMA')->where('variedad', $variedad)->where('calibre', '5J')->where('semana',$semana)->first();
                                      @endphp
                                      @if ($mod->retorno > $mod->retorno_inicial)
                                        <p class="text-green-500 font-bold"> +{{ $mod->retorno - $mod->retorno_inicial }} usd </p>
                                      @else
                                        <p class="text-red-500 font-bold"> {{ $mod->retorno - $mod->retorno_inicial }} usd </p>
                                      @endif
                                      <button title="Eliminar" class="cursorpointer text-xs text-red-500" wire:click="delete_modificacion('{{ $mod->id }}')">(Eliminar)</button>
                                    @endif
                                  </td>

                                </tr>
                                @php
                                  $calibrecount += 1;
                                @endphp
                              @endif

                              @if ($pesoneto4j_semana > 0)
                                <tr>
                                  <td> </td>
                                  <td> </td>
                                  <td> </td>
                                  {{-- total semana --}}
                                  <td> </td>
                                  {{-- semana --}}
                                  <td> </td>

                                  <td>4J</td>
                                  <td style="text-align:right; padding-right:30px;border-left: 1px solid #ddd;">
                                    {{ number_format($pesoneto4j_semana, 2, ',', '.') }} KGS
                                  </td>
                                  <td>{{ number_format($retorno4j_semana, 2, ',', '.') }}</td>
                                  <td>{{ number_format($margen4j_semana, 2, ',', '.') }}</td>
                                  <td>{{ number_format($costos4j_semana, 2) }}</td>

                                  {{-- npk --}}
                                  <td>
                                    @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "4J" && $semana_mod == $semana)
                                      @if ($type_mod == "npk")
                                        {{ $retorno }} <br>
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
                                      @php
                                        $retorno_neto4j_semana = $retorno;
                                      @endphp
                                    @else
                                      @if ($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','4J')->where('semana',$semana)->count() > 0)
                                        <p class="text-red-500 font-bold whitespace-nowrap">
                                          {{ number_format($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','4J')->where('semana',$semana)->first()->retorno, 2, ',', '.') }} USD
                                        </p>
                                        @php
                                          $retorno_neto4j_semana = $informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','4J')->where('semana',$semana)->first()->retorno;
                                        @endphp
                                      @else
                                        {{ number_format(($retorno4j_semana - ($margen4j_semana + $costos4j_semana)), 2, ',', '.') }} USD <br>
                                        @php
                                          $retorno_neto4j_semana = $retorno4j_semana - ($margen4j_semana + $costos4j_semana);
                                        @endphp
                                      @endif
                                    @endif
                                    @php
                                      $retorno_neto4j += $retorno_neto4j_semana;
                                    @endphp
                                    @if ($categoria_mod=="DENTRO DE NORMA" && $variedad_mod==$variedad && $calibre_mod=="4J" && $semana_mod == $semana && $type_mod=="retorno")
                                      <button wire:click="saveOrUpdateModification" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                        <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                        <span class="relative">Guardar</span>
                                      </button>
                                    @else
                                      <span wire:click="set_modification('DENTRO DE NORMA', '{{ $variedad }}', '4J','{{($retorno_neto4j_semana)}}','{{($retorno_neto4j_semana)/$pesoneto4j_semana}}','{{$pesoneto4j_semana}}','retorno',{{$semana}})" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                        <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full text-xs"></span>
                                        <span class="relative">Editar</span>
                                      </span>
                                    @endif
                                  </td>

                                  {{-- retorno --}}
                                  <td>
                                    @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "4J" && $semana_mod == $semana)
                                      @if ($type_mod == "retorno")
                                        {{ $npk }} <br>
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
                                      @if ($informe_edit->modificaciones->where('categoria', 'DENTRO DE NORMA')->where('variedad', $variedad)->where('calibre', '4J')->where('semana',$semana)->count() > 0)
                                        <p class="text-red-500 font-bold whitespace-nowrap">
                                          {{ number_format($informe_edit->modificaciones->where('categoria', 'DENTRO DE NORMA')->where('variedad', $variedad)->where('calibre', '4J')->where('semana',$semana)->first()->npk, 2, ',', '.') }} USD/kg
                                        </p>
                                      @else
                                        @if ($pesoneto4j_semana)
                                          <p class="whitespace-nowrap">
                                            {{ number_format(($retorno4j_semana - ($margen4j_semana + $costos4j_semana)) / $pesoneto4j_semana, 2, ',', '.') }} USD/kg
                                          </p>
                                        @else
                                          0 USD/kg
                                        @endif
                                      @endif
                                    @endif

                                    @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "4J" && $semana_mod == $semana && $type_mod == "npk")
                                      <button wire:click="saveOrUpdateModification" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                        <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                        <span class="relative">Guardar</span>
                                      </button>
                                    @else
                                      <span wire:click="set_modification('DENTRO DE NORMA', '{{ $variedad }}', '4J','{{($retorno_neto4j_semana)}}','{{($retorno_neto4j_semana)/$pesoneto4j_semana}}','{{$pesoneto4j_semana}}','npk','{{$semana}}')" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                        <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full text-xs"></span>
                                        <span class="relative">Editar</span>
                                      </span>
                                    @endif
                                  </td>

                                  {{-- eliminar --}}
                                  <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-center">
                                    @if ($informe_edit->modificaciones->where('categoria', 'DENTRO DE NORMA')->where('variedad', $variedad)->where('calibre', '4J')->where('semana',$semana)->count() > 0)
                                      @php
                                        $mod = $informe_edit->modificaciones->where('categoria', 'DENTRO DE NORMA')->where('variedad', $variedad)->where('calibre', '4J')->where('semana',$semana)->first();
                                      @endphp
                                      @if ($mod->retorno > $mod->retorno_inicial)
                                        <p class="text-green-500 font-bold"> +{{ $mod->retorno - $mod->retorno_inicial }} usd </p>
                                      @else
                                        <p class="text-red-500 font-bold"> {{ $mod->retorno - $mod->retorno_inicial }} usd </p>
                                      @endif
                                      <button title="Eliminar" class="cursorpointer text-xs text-red-500" wire:click="delete_modificacion('{{ $mod->id }}')">(Eliminar)</button>
                                    @endif
                                  </td>
                                </tr>

                                @php
                                  $calibrecount += 1;
                                @endphp
                              @endif

                              @if ($pesoneto3j_semana > 0)
                                <tr>
                                  <td> </td>
                                  <td> </td>
                                  <td> </td>
                                  {{-- total semana --}}
                                  <td> </td>
                                  {{-- semana --}}
                                  <td> </td>

                                  <td>3J</td>
                                  <td style="text-align:right; padding-right:30px;border-left: 1px solid #ddd;">{{ number_format($pesoneto3j_semana, 2, ',', '.') }} KGS</td>
                                  <td>{{ number_format($retorno3j_semana, 2, ',', '.') }}</td>
                                  <td>{{ number_format($margen3j_semana, 2, ',', '.') }}</td>
                                  <td>{{ number_format($costos3j_semana, 2) }}</td>

                                  {{-- npk --}}
                                  <td>
                                    @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "3J" && $semana_mod == $semana)
                                      @if ($type_mod == "npk")
                                        {{ $retorno }} <br>
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
                                      @php
                                        $retorno_neto3j_semana = $retorno;
                                      @endphp
                                    @else
                                      @if ($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','3J')->where('semana',$semana)->count() > 0)
                                        <p class="text-red-500 font-bold whitespace-nowrap">
                                          {{ number_format($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','3J')->where('semana',$semana)->first()->retorno, 2, ',', '.') }} USD
                                        </p>
                                        @php
                                          $retorno_neto3j_semana = $informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','3J')->where('semana',$semana)->first()->retorno;
                                        @endphp
                                      @else
                                        {{ number_format(($retorno3j_semana - ($margen3j_semana + $costos3j_semana)), 2, ',', '.') }} USD <br>
                                        @php
                                          $retorno_neto3j_semana = $retorno3j_semana - ($margen3j_semana + $costos3j_semana);
                                        @endphp
                                      @endif
                                    @endif
                                    @php
                                      $retorno_neto3j += $retorno_neto3j_semana;
                                    @endphp
                                    @if ($categoria_mod=="DENTRO DE NORMA" && $variedad_mod==$variedad && $calibre_mod=="3J" && $semana_mod == $semana && $type_mod=="retorno")
                                      <button wire:click="saveOrUpdateModification" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                        <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                        <span class="relative">Guardar</span>
                                      </button>
                                    @else
                                      <span wire:click="set_modification('DENTRO DE NORMA', '{{ $variedad }}', '3J','{{($retorno_neto3j_semana)}}','{{($retorno_neto3j_semana)/$pesoneto3j_semana}}','{{$pesoneto3j_semana}}','retorno',{{$semana}})" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                        <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full text-xs"></span>
                                        <span class="relative">Editar</span>
                                      </span>
                                    @endif
                                  </td>

                                  {{-- retorno --}}
                                  <td>
                                    @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "3J" && $semana_mod == $semana)
                                      @if ($type_mod == "retorno")
                                        {{ $npk }} <br>
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
                                      @if ($informe_edit->modificaciones->where('categoria', 'DENTRO DE NORMA')->where('variedad', $variedad)->where('calibre', '3J')->where('semana',$semana)->count() > 0)
                                        <p class="text-red-500 font-bold whitespace-nowrap">
                                          {{ number_format($informe_edit->modificaciones->where('categoria', 'DENTRO DE NORMA')->where('variedad', $variedad)->where('calibre', '3J')->where('semana',$semana)->first()->npk, 2, ',', '.') }} USD/kg
                                        </p>
                                      @else
                                        @if ($pesoneto3j_semana)
                                          <p class="whitespace-nowrap">
                                            {{ number_format(($retorno3j_semana - ($margen3j_semana + $costos3j_semana)) / $pesoneto3j_semana, 2, ',', '.') }} USD/kg
                                          </p>
                                        @else
                                          0 USD/kg
                                        @endif
                                      @endif
                                    @endif

                                    @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "3J" && $semana_mod == $semana && $type_mod == "npk")
                                      <button wire:click="saveOrUpdateModification" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                        <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                        <span class="relative">Guardar</span>
                                      </button>
                                    @else
                                      <span wire:click="set_modification('DENTRO DE NORMA', '{{ $variedad }}', '3J','{{($retorno_neto3j_semana)}}','{{($retorno_neto3j_semana)/$pesoneto3j_semana}}','{{$pesoneto3j_semana}}','npk','{{$semana}}')" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                        <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full text-xs"></span>
                                        <span class="relative">Editar</span>
                                      </span>
                                    @endif
                                  </td>

                                  {{-- eliminar --}}
                                  <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-center">
                                    @if ($informe_edit->modificaciones->where('categoria', 'DENTRO DE NORMA')->where('variedad', $variedad)->where('calibre', '3J')->where('semana',$semana)->count() > 0)
                                      @php
                                        $mod = $informe_edit->modificaciones->where('categoria', 'DENTRO DE NORMA')->where('variedad', $variedad)->where('calibre', '3J')->where('semana',$semana)->first();
                                      @endphp
                                      @if ($mod->retorno > $mod->retorno_inicial)
                                        <p class="text-green-500 font-bold"> +{{ $mod->retorno - $mod->retorno_inicial }} usd </p>
                                      @else
                                        <p class="text-red-500 font-bold"> {{ $mod->retorno - $mod->retorno_inicial }} usd </p>
                                      @endif
                                      <button title="Eliminar" class="cursorpointer text-xs text-red-500" wire:click="delete_modificacion('{{ $mod->id }}')">(Eliminar)</button>
                                    @endif
                                  </td>

                                </tr>

                                @php
                                  $calibrecount += 1;
                                @endphp
                              @endif

                              @if ($pesoneto2j_semana > 0)
                                <tr>
                                  <td> </td>
                                  <td> </td>
                                  <td> </td>
                                  {{-- total semana --}}
                                  <td> </td>
                                  {{-- semana --}}
                                  <td> </td>

                                  <td>2J</td>
                                  <td style="text-align:right; padding-right:30px;border-left: 1px solid #ddd;">{{ number_format($pesoneto2j_semana, 2, ',', '.') }} KGS</td>
                                  <td>{{ number_format($retorno2j_semana, 2, ',', '.') }}</td>
                                  <td>{{ number_format($margen2j_semana, 2, ',', '.') }}</td>
                                  <td>{{ number_format($costos2j_semana, 2) }}</td>

                                  {{-- npk --}}
                                  <td>
                                    @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "2J" && $semana_mod == $semana)
                                      @if ($type_mod == "npk")
                                        {{ $retorno }} <br>
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
                                      @php
                                        $retorno_neto2j_semana = $retorno;
                                      @endphp
                                    @else
                                      @if ($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','2J')->where('semana',$semana)->count() > 0)
                                        <p class="text-red-500 font-bold whitespace-nowrap">
                                          {{ number_format($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','2J')->where('semana',$semana)->first()->retorno, 2, ',', '.') }} USD
                                        </p>
                                        @php
                                          $retorno_neto2j_semana = $informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','2J')->where('semana',$semana)->first()->retorno;
                                        @endphp
                                      @else
                                        {{ number_format(($retorno2j_semana - ($margen2j_semana + $costos2j_semana)), 2, ',', '.') }} USD <br>
                                        @php
                                          $retorno_neto2j_semana = $retorno2j_semana - ($margen2j_semana + $costos2j_semana);
                                        @endphp
                                      @endif
                                    @endif
                                    @php
                                      $retorno_neto2j += $retorno_neto2j_semana;
                                    @endphp
                                    @if ($categoria_mod=="DENTRO DE NORMA" && $variedad_mod==$variedad && $calibre_mod=="2J" && $semana_mod == $semana && $type_mod=="retorno")
                                      <button wire:click="saveOrUpdateModification" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                        <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                        <span class="relative">Guardar</span>
                                      </button>
                                    @else
                                      <span wire:click="set_modification('DENTRO DE NORMA', '{{ $variedad }}', '2J','{{($retorno_neto2j_semana)}}','{{($retorno_neto2j_semana)/$pesoneto2j_semana}}','{{$pesoneto2j_semana}}','retorno',{{$semana}})" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                        <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full text-xs"></span>
                                        <span class="relative">Editar</span>
                                      </span>
                                    @endif
                                  </td>

                                  {{-- retorno --}}
                                  <td>
                                    @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "2J" && $semana_mod == $semana)
                                      @if ($type_mod == "retorno")
                                        {{ $npk }} <br>
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
                                      @if ($informe_edit->modificaciones->where('categoria', 'DENTRO DE NORMA')->where('variedad', $variedad)->where('calibre', '2J')->where('semana',$semana)->count() > 0)
                                        <p class="text-red-500 font-bold whitespace-nowrap">
                                          {{ number_format($informe_edit->modificaciones->where('categoria', 'DENTRO DE NORMA')->where('variedad', $variedad)->where('calibre', '2J')->where('semana',$semana)->first()->npk, 2, ',', '.') }} USD/kg
                                        </p>
                                      @else
                                        @if ($pesoneto2j_semana)
                                          <p class="whitespace-nowrap">
                                            {{ number_format(($retorno2j_semana - ($margen2j_semana + $costos2j_semana)) / $pesoneto2j_semana, 2, ',', '.') }} USD/kg
                                          </p>
                                        @else
                                          0 USD/kg
                                        @endif
                                      @endif
                                    @endif

                                    @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "2J" && $semana_mod == $semana && $type_mod == "npk")
                                      <button wire:click="saveOrUpdateModification" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                        <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                        <span class="relative">Guardar</span>
                                      </button>
                                    @else
                                      <span wire:click="set_modification('DENTRO DE NORMA', '{{ $variedad }}', '2J','{{($retorno_neto2j_semana)}}','{{($retorno_neto2j_semana)/$pesoneto2j_semana}}','{{$pesoneto2j_semana}}','npk','{{$semana}}')" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                        <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full text-xs"></span>
                                        <span class="relative">Editar</span>
                                      </span>
                                    @endif
                                  </td>

                                  {{-- eliminar --}}
                                  <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-center">
                                    @if ($informe_edit->modificaciones->where('categoria', 'DENTRO DE NORMA')->where('variedad', $variedad)->where('calibre', '2J')->where('semana',$semana)->count() > 0)
                                      @php
                                        $mod = $informe_edit->modificaciones->where('categoria', 'DENTRO DE NORMA')->where('variedad', $variedad)->where('calibre', '2J')->where('semana',$semana)->first();
                                      @endphp
                                      @if ($mod->retorno > $mod->retorno_inicial)
                                        <p class="text-green-500 font-bold"> +{{ $mod->retorno - $mod->retorno_inicial }} usd </p>
                                      @else
                                        <p class="text-red-500 font-bold"> {{ $mod->retorno - $mod->retorno_inicial }} usd </p>
                                      @endif
                                      <button title="Eliminar" class="cursorpointer text-xs text-red-500" wire:click="delete_modificacion('{{ $mod->id }}')">(Eliminar)</button>
                                    @endif
                                  </td>

                                </tr>

                                @php
                                  $calibrecount += 1;
                                @endphp
                              @endif

                              @if ($pesonetoj_semana > 0)
                                <tr>
                                  <td> </td>
                                  <td> </td>
                                  <td> </td>
                                  {{-- total semana --}}
                                  <td> </td>
                                  {{-- semana --}}
                                  <td> </td>

                                  <td>J</td>
                                  <td style="text-align:right; padding-right:30px; border-left: 1px solid #ddd;">{{ number_format($pesonetoj_semana, 2, ',', '.') }} KGS</td>
                                  <td>{{ number_format($retornoj_semana, 2, ',', '.') }}</td>
                                  <td>{{ number_format($margenj_semana, 2, ',', '.') }}</td>
                                  <td>{{ number_format($costosj_semana, 2) }}</td>

                                 {{-- npk --}}
                                  <td>
                                    @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "J" && $semana_mod == $semana)
                                      @if ($type_mod == "npk")
                                        {{ $retorno }} <br>
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
                                      @php
                                        $retorno_netoj_semana = $retorno;
                                      @endphp
                                    @else
                                      @if ($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','J')->where('semana',$semana)->count() > 0)
                                        <p class="text-red-500 font-bold whitespace-nowrap">
                                          {{ number_format($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','J')->where('semana',$semana)->first()->retorno, 2, ',', '.') }} USD
                                        </p>
                                        @php
                                          $retorno_netoj_semana = $informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','J')->where('semana',$semana)->first()->retorno;
                                        @endphp
                                      @else
                                        {{ number_format(($retornoj_semana - ($margenj_semana + $costosj_semana)), 2, ',', '.') }} USD <br>
                                        @php
                                          $retorno_netoj_semana = $retornoj_semana - ($margenj_semana + $costosj_semana);
                                        @endphp
                                      @endif
                                    @endif
                                    @php
                                      $retorno_netoj += $retorno_netoj_semana;
                                    @endphp
                                    @if ($categoria_mod=="DENTRO DE NORMA" && $variedad_mod==$variedad && $calibre_mod=="J" && $semana_mod == $semana && $type_mod=="retorno")
                                      <button wire:click="saveOrUpdateModification" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                        <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                        <span class="relative">Guardar</span>
                                      </button>
                                    @else
                                      <span wire:click="set_modification('DENTRO DE NORMA', '{{ $variedad }}', 'J','{{($retorno_netoj_semana)}}','{{($retorno_netoj_semana)/$pesonetoj_semana}}','{{$pesonetoj_semana}}','retorno',{{$semana}})" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                        <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full text-xs"></span>
                                        <span class="relative">Editar</span>
                                      </span>
                                    @endif
                                  </td>

                                  {{-- retorno --}}
                                  <td>
                                    @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "J" && $semana_mod == $semana)
                                      @if ($type_mod == "retorno")
                                        {{ $npk }} <br>
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
                                      @if ($informe_edit->modificaciones->where('categoria', 'DENTRO DE NORMA')->where('variedad', $variedad)->where('calibre', 'J')->where('semana',$semana)->count() > 0)
                                        <p class="text-red-500 font-bold whitespace-nowrap">
                                          {{ number_format($informe_edit->modificaciones->where('categoria', 'DENTRO DE NORMA')->where('variedad', $variedad)->where('calibre', 'J')->where('semana',$semana)->first()->npk, 2, ',', '.') }} USD/kg
                                        </p>
                                      @else
                                        @if ($pesonetoj_semana)
                                          <p class="whitespace-nowrap">
                                            {{ number_format(($retornoj_semana - ($margenj_semana + $costosj_semana)) / $pesonetoj_semana, 2, ',', '.') }} USD/kg
                                          </p>
                                        @else
                                          0 USD/kg
                                        @endif
                                      @endif
                                    @endif

                                    @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "J" && $semana_mod == $semana && $type_mod == "npk")
                                      <button wire:click="saveOrUpdateModification" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                        <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                        <span class="relative">Guardar</span>
                                      </button>
                                    @else
                                      <span wire:click="set_modification('DENTRO DE NORMA', '{{ $variedad }}', 'J','{{($retorno_netoj_semana)}}','{{($retorno_netoj_semana)/$pesonetoj_semana}}','{{$pesonetoj_semana}}','npk','{{$semana}}')" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                        <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full text-xs"></span>
                                        <span class="relative">Editar</span>
                                      </span>
                                    @endif
                                  </td>

                                  {{-- eliminar --}}
                                  <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-center">
                                    @if ($informe_edit->modificaciones->where('categoria', 'DENTRO DE NORMA')->where('variedad', $variedad)->where('calibre', 'J')->where('semana',$semana)->count() > 0)
                                      @php
                                        $mod = $informe_edit->modificaciones->where('categoria', 'DENTRO DE NORMA')->where('variedad', $variedad)->where('calibre', 'J')->where('semana',$semana)->first();
                                      @endphp
                                      @if ($mod->retorno > $mod->retorno_inicial)
                                        <p class="text-green-500 font-bold"> +{{ $mod->retorno - $mod->retorno_inicial }} usd </p>
                                      @else
                                        <p class="text-red-500 font-bold"> {{ $mod->retorno - $mod->retorno_inicial }} usd </p>
                                      @endif
                                      <button title="Eliminar" class="cursorpointer text-xs text-red-500" wire:click="delete_modificacion('{{ $mod->id }}')">(Eliminar)</button>
                                    @endif
                                  </td>

                                </tr>

                                @php
                                  $calibrecount += 1;
                                @endphp
                              @endif

                              @if ($pesonetoxl_semana > 0)
                                <tr>
                                  <td> </td>
                                  <td> </td>
                                  <td> </td>
                                  {{-- total semana --}}
                                  <td> </td>
                                  {{-- semana --}}
                                  <td> </td>
                              
                                  <td>XL</td>
                                  <td style="text-align:right; padding-right:30px; border-left: 1px solid #ddd;">{{ number_format($pesonetoxl_semana, 2, ',', '.') }} KGS</td>
                                  <td>{{ number_format($retornoxl_semana, 2, ',', '.') }}</td>
                                  <td>{{ number_format($margenxl_semana, 2, ',', '.') }}</td>
                                  <td>{{ number_format($costosxl_semana, 2) }}</td>
                              
                                  {{-- npk --}}
                                  <td>
                                    @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "XL" && $semana_mod == $semana)
                                      @if ($type_mod == "npk")
                                        {{ $retorno }} <br>
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
                                      @php
                                        $retorno_netoxl_semana = $retorno;
                                      @endphp
                                    @else
                                      @if ($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','XL')->where('semana',$semana)->count() > 0)
                                        <p class="text-red-500 font-bold whitespace-nowrap">
                                          {{ number_format($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','XL')->where('semana',$semana)->first()->retorno, 2, ',', '.') }} USD
                                        </p>
                                        @php
                                          $retorno_netoxl_semana = $informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','XL')->where('semana',$semana)->first()->retorno;
                                        @endphp
                                      @else
                                        {{ number_format(($retornoxl_semana - ($margenxl_semana + $costosxl_semana)), 2, ',', '.') }} USD <br>
                                        @php
                                          $retorno_netoxl_semana = $retornoxl_semana - ($margenxl_semana + $costosxl_semana);
                                        @endphp
                                      @endif
                                    @endif
                                    @php
                                      $retorno_netoxl += $retorno_netoxl_semana;
                                    @endphp
                                    @if ($categoria_mod=="DENTRO DE NORMA" && $variedad_mod==$variedad && $calibre_mod=="XL" && $semana_mod == $semana && $type_mod=="retorno")
                                      <button wire:click="saveOrUpdateModification" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                        <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                        <span class="relative">Guardar</span>
                                      </button>
                                    @else
                                      <span wire:click="set_modification('DENTRO DE NORMA', '{{ $variedad }}', 'XL','{{($retorno_netoxl_semana)}}','{{($retorno_netoxl_semana)/$pesonetoxl_semana}}','{{$pesonetoxl_semana}}','retorno',{{$semana}})" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                        <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full text-xs"></span>
                                        <span class="relative">Editar</span>
                                      </span>
                                    @endif
                                  </td>

                                  {{-- retorno --}}
                                  <td>
                                    @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "XL" && $semana_mod == $semana)
                                      @if ($type_mod == "retorno")
                                        {{ $npk }} <br>
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
                                      @if ($informe_edit->modificaciones->where('categoria', 'DENTRO DE NORMA')->where('variedad', $variedad)->where('calibre', 'XL')->where('semana',$semana)->count() > 0)
                                        <p class="text-red-500 font-bold whitespace-nowrap">
                                          {{ number_format($informe_edit->modificaciones->where('categoria', 'DENTRO DE NORMA')->where('variedad', $variedad)->where('calibre', 'XL')->where('semana',$semana)->first()->npk, 2, ',', '.') }} USD/kg
                                        </p>
                                      @else
                                        @if ($pesonetoxl_semana)
                                          <p class="whitespace-nowrap">
                                            {{ number_format(($retornoxl_semana - ($margenxl_semana + $costosxl_semana)) / $pesonetoxl_semana, 2, ',', '.') }} USD/kg
                                          </p>
                                        @else
                                          0 USD/kg
                                        @endif
                                      @endif
                                    @endif

                                    @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "XL" && $semana_mod == $semana && $type_mod == "npk")
                                      <button wire:click="saveOrUpdateModification" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                        <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                        <span class="relative">Guardar</span>
                                      </button>
                                    @else
                                      <span wire:click="set_modification('DENTRO DE NORMA', '{{ $variedad }}', 'XL','{{($retorno_netoxl_semana)}}','{{($retorno_netoxl_semana)/$pesonetoxl_semana}}','{{$pesonetoxl_semana}}','npk','{{$semana}}')" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                        <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full text-xs"></span>
                                        <span class="relative">Editar</span>
                                      </span>
                                    @endif
                                  </td>

                                  {{-- eliminar --}}
                                  <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-center">
                                    @if ($informe_edit->modificaciones->where('categoria', 'DENTRO DE NORMA')->where('variedad', $variedad)->where('calibre', 'XL')->where('semana',$semana)->count() > 0)
                                      @php
                                        $mod = $informe_edit->modificaciones->where('categoria', 'DENTRO DE NORMA')->where('variedad', $variedad)->where('calibre', 'XL')->where('semana',$semana)->first();
                                      @endphp
                                      @if ($mod->retorno > $mod->retorno_inicial)
                                        <p class="text-green-500 font-bold"> +{{ $mod->retorno - $mod->retorno_inicial }} usd </p>
                                      @else
                                        <p class="text-red-500 font-bold"> {{ $mod->retorno - $mod->retorno_inicial }} usd </p>
                                      @endif
                                      <button title="Eliminar" class="cursorpointer text-xs text-red-500" wire:click="delete_modificacion('{{ $mod->id }}')">(Eliminar)</button>
                                    @endif
                                  </td>

                                </tr>
                              
                                @php
                                  $calibrecount += 1;
                                @endphp
                              @endif
                            
                            @endif
                            
                            @if ($pesoneto5j_semana+$pesoneto4j_semana+$pesoneto3j_semana+$pesoneto2j_semana+$pesonetoj_semana+$pesonetoxl_semana>0)
                              
                              <tr>
                                <td></td>
                                <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
                                <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
                                <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">Total {{ $semana }}:</td>
                                <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
                                <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
                                <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">
                                  {{ number_format($pesoneto5j_semana + $pesoneto4j_semana + $pesoneto3j_semana + $pesoneto2j_semana + $pesonetoj_semana + $pesonetoxl_semana, 2, ',', '.') }} KGS
                                </td>
                                <td>
                                  {{ number_format($retorno5j_semana + $retorno4j_semana + $retorno3j_semana + $retorno2j_semana + $retornoj_semana + $retornoxl_semana, 2, ',', '.') }}
                                </td>
                                <td>
                                  {{ number_format($margen5j_semana + $margen4j_semana + $margen3j_semana + $margen2j_semana + $margenj_semana + $margenxl_semana, 2, ',', '.') }}
                                </td>
                                <td>
                                  {{ number_format($costos5j_semana + $costos4j_semana + $costos3j_semana + $costos2j_semana + $costosj_semana + $costosxl_semana, 2) }}
                                </td>
                                <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">
                                  {{ number_format($retorno_neto5j_semana + $retorno_neto4j_semana + $retorno_neto3j_semana + $retorno_neto2j_semana + $retorno_netoj_semana + $retorno_netoxl_semana, 2, ',', '.') }} USD
                                </td>
                                <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">
                                  {{ number_format(
                                    ($retorno_neto5j_semana + $retorno_neto4j_semana + $retorno_neto3j_semana + $retorno_neto2j_semana + $retorno_netoj_semana + $retorno_netoxl_semana)
                                    /
                                    ($pesoneto5j_semana + $pesoneto4j_semana + $pesoneto3j_semana + $pesoneto2j_semana + $pesonetoj_semana + $pesonetoxl_semana),
                                    2, ',', '.'
                                  ) }} USD/KG
                                </td>
                              </tr>
                            
                            @endif 
                            @php
                              $variedadcount+=1;
                              $semanacounter+=1;
                            @endphp
                          @endif
                        @endforeach
            
                      @if ($pesoneto5j+$pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl>0)

                        <tr>
                          <td></td>
                          <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; text-align: center;">
                            Total {{$variedad}}:
                          </td>
                          
                          <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
                          <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
                          <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
                          <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
                          <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; ">{{number_format($pesoneto5j+$pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl,2,',','.')}} KGS</td>
                          <td>
                            {{number_format($retorno5j+$retorno4j+$retorno3j+$retorno2j+$retornoj+$retornoxl,2,',','.')}}
                          </td>
                          <td>
                            {{number_format(($margen5j+$margen4j+$margen3j+$margen2j+$margenj+$margenxl),2,',','.')}}
                          </td>
                        
                          <td>
                            {{number_format($costos5j+$costos4j+$costos3j+$costos2j+$costosj+$costosxl,2)}}
                          </td>
                          <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format(($retorno_neto5j+$retorno_neto4j+$retorno_neto3j+$retorno_neto2j+$retorno_netoj+$retorno_netoxl),2,',','.')}} USD
                          
                          
                          </td>
                        
                          <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format(($retorno_neto5j+$retorno_neto4j+$retorno_neto3j+$retorno_neto2j+$retorno_netoj+$retorno_netoxl)/($pesoneto5j+$pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl),2,',','.')}} USD/KG</td>
                          
                        </tr>
                        @php
                             $totalcount+=($retorno_neto5j+$retorno_neto4j+$retorno_neto3j+$retorno_neto2j+$retorno_netoj+$retorno_netoxl);
                        @endphp
                      @endif

                    @endforeach
                  
                  @if ($pesonetototal>0)
                    <tr style="background-color: #ddd;">
                          
                      
                    
                        <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;" colspan="4" >Total Dentro de Norma</td>
                      
                      
                        <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
                    
                      
                      
                      <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"></td>
                      <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format($pesonetototal,1,',','.')}} KGS</td>
                      <td>{{number_format($totalretorno5j+$totalretorno4j+$totalretorno3j+$totalretorno2j+$totalretornoj+$totalretornoxl,2)}} usd</td>
                      <td>{{number_format(($totalmargen5j+$totalmargen4j+$totalmargen3j+$totalmargen2j+$totalmargenj+$totalmargenxl),2)}} usd</td>
                    
                      <td>
                        {{number_format(($totalcostos5j+$totalcostos4j+$totalcostos3j+$totalcostos2j+$totalcostosj+$totalcostosxl),2)}}
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
              @else
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
                    
                    $totalretorno5j=0;
                    $totalretorno4j=0;
                      $totalretorno3j=0;
                      $totalretorno2j=0;
                      $totalretornoj=0;
                      $totalretornoxl=0;

                      $totalmargen5j=0;
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

                      $totalcostos5j=0;
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
                      
                      
                      $cantidad5j=0;
                      $cantidad4j=0;
                      $cantidad3j=0;
                      $cantidad2j=0;
                      $cantidadj=0;
                      $cantidadxl=0;
                      
                      $pesoneto5j=0;
                      $pesoneto4j=0;
                      $pesoneto3j=0;
                      $pesoneto2j=0;
                      $pesonetoj=0;
                      $pesonetoxl=0;
                      $pesonetol=0;
          
                      
                      $retorno5j=0;
                      $retorno4j=0;
                      $retorno3j=0;
                      $retorno2j=0;
                      $retornoj=0;
                      $retornoxl=0;

                      $retorno_neto5j=0;
                      $retorno_neto4j=0;
                      $retorno_neto3j=0;
                      $retorno_neto2j=0;
                      $retorno_netoj=0;
                      $retorno_netoxl=0;

                      $margen5j=0;
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

                      $costos5j=0;
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
                                        @if (($masa->calibre_real=='5J') && $masa->variedad==$variedad)
                                            @php
                                              $cantidad5j+=floatval($masa->cantidad);
                                              $pesoneto5j+=floatval($masa->peso_prorrateado);
                                            
                                              
                  
                                            
                                              
                                              if (!IS_NULL($masa->fob)) {
                                                  $retorno5j+=floatval($masa->peso_prorrateado*$tarifafinal);
                                                  $totalretorno5j+=floatval($masa->peso_prorrateado*$tarifafinal);
                                                  $margen5j+=floatval($masa->peso_prorrateado*$tarifafinal*0.08);
                                                  $totalmargen5j+=floatval($masa->peso_prorrateado*$tarifafinal*0.08);
                                                }
                                              $cantidadtotal+=floatval($masa->cantidad);
                                              $pesonetototal+=floatval($masa->peso_prorrateado);
                  
                                                  $costos4j+=floatval($masa->costo);
                                                  $totalcostos4j+=floatval($masa->costo);
                                                  
                                      
                                            @endphp	
                                        @endif
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
          

                

          
                    @if ($cantidad5j+$cantidad4j+$cantidad3j+$cantidad2j+$cantidadj+$cantidadxl>0)
                      
                      @if ($pesoneto5j>0)
                        <tr>
                          <td> </td>
                          <td> </td>
                      
                          <td>5J</td>
                          <td style="text-align:right; padding-right:30px;border-left: 1px solid #ddd;" >{{number_format($pesoneto5j,2,',','.')}} KGS</td>
                          <td>{{number_format(($retorno5j),2,',','.')}}
                          <td>{{number_format(($margen5j),2,',','.')}}
                          </td>
                      
                          <td>
                            {{number_format($costos5j,2)}}
                          </td>
                      
                          <td>
                              @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "5J" && $semana_mod == "no")
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
                                @php
                                    $retorno_neto5j=($retorno);
                                @endphp
                              @else
                      
                                @if ($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','5J')->where('semana','no')->count()>0)
                                  <p class="text-red-500 font-bold whitespace-nowrap">
                                    {{number_format($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','5J')->where('semana','no')->first()->retorno, 2, ',', '.') }} USD
                                  </p>
                                    @php
                                        $retorno_neto5j=$informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','5J')->where('semana','no')->first()->retorno;
                                    @endphp
                                @else
                                  {{ number_format(($retorno5j - ($margen5j + $costos5j)), 2, ',', '.') }} USD <br>
                                  @php
                                      $retorno_neto5j=($retorno5j - ($margen5j + $costos5j));
                                  @endphp
                                @endif
                      
                              @endif
                      
                              @if ($categoria_mod=="DENTRO DE NORMA" && $variedad_mod==$variedad && $calibre_mod=="5J" && $type_mod=="retorno" && $semana_mod == "no")
                                <button wire:click="saveOrUpdateModification" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                  <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                  <span class="relative">Guardar</span>
                                </button>
                              @else
                                <span wire:click="set_modification('DENTRO DE NORMA', '{{ $variedad }}', '5J','{{($retorno_neto5j)}}','{{($retorno_neto5j)/$pesoneto5j}}','{{$pesoneto5j}}','retorno','no')" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                  <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full text-xs"></span>
                                  <span class="relative">Editar</span>
                                </span>
                              @endif
                      
                          </td>
                          <td>
                              @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "5J" && $semana_mod == "no")
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
                                @if ($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','5J')->where('semana','no')->count()>0)
                                  <p class="text-red-500 font-bold whitespace-nowrap">
                                    {{number_format($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','5J')->where('semana','no')->first()->npk, 2, ',', '.') }} USD/kg
                                  </p>
                      
                                @else
                                  @if ($pesoneto5j)
                                      <p class="whitespace-nowrap">
                                        {{ number_format(($retorno5j - ($margen5j + $costos5j)) / $pesoneto5j, 2, ',', '.') }} USD/kg
                                      </p>
                                  @else
                                      0 USD/kg
                                  @endif
                                @endif
                      
                              @endif
                      
                              @if ($categoria_mod=="DENTRO DE NORMA" && $variedad_mod==$variedad && $calibre_mod=="5J" && $type_mod=="npk" && $semana_mod=="no")
                                <button wire:click="saveOrUpdateModification" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                  <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                  <span class="relative">Guardar</span>
                                </button>
                              @else
                                <span wire:click="set_modification('DENTRO DE NORMA', '{{ $variedad }}', '5J','{{($retorno_neto5j)}}','{{($retorno_neto5j)/$pesoneto5j}}','{{$pesoneto5j}}','npk','no')" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                  <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full text-xs"></span>
                                  <span class="relative">Editar</span>
                                </span>
                              @endif
                      
                          </td>
                      
                          <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-center">
                            @if ($informe_edit->modificaciones->where('categoria', 'DENTRO DE NORMA')->where('variedad', $variedad)->where('calibre', '5J')->where('semana','no')->count() > 0)
                              @php
                                $mod = $informe_edit->modificaciones->where('categoria', 'DENTRO DE NORMA')->where('variedad', $variedad)->where('calibre', '5J')->where('semana','no')->first();
                              @endphp
                              @if ($mod->retorno > $mod->retorno_inicial)
                                <p class="text-green-500 font-bold"> +{{ $mod->retorno - $mod->retorno_inicial }} usd </p>
                              @else
                                <p class="text-red-500 font-bold"> {{ $mod->retorno - $mod->retorno_inicial }} usd </p>
                              @endif
                              <button title="Eliminar" class="cursorpointer text-xs text-red-500" wire:click="delete_modificacion('{{ $mod->id }}')">(Eliminar)</button>
                            @endif
                          </td>
                        </tr>
                        @php
                          $calibrecount+=1;
                        @endphp
                      @endif
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
                            @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "4J" && $semana_mod == "no")
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
                              @php
                                  $retorno_neto4j=($retorno);
                              @endphp
                            @else
                              @if ($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','4J')->where('semana','no')->count()>0)
                                <p class="text-red-500 font-bold whitespace-nowrap">
                                  {{number_format($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','4J')->where('semana','no')->first()->retorno, 2, ',', '.') }} USD
                                </p>
                                  @php
                                      $retorno_neto4j=$informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','4J')->where('semana','no')->first()->retorno;
                                  @endphp
                              @else
                                {{ number_format(($retorno4j - ($margen4j + $costos4j)), 2, ',', '.') }} USD <br>
                                @php
                                    $retorno_neto4j=($retorno4j - ($margen4j + $costos4j));
                                @endphp
                              @endif
                            @endif
                          
                            @if ($categoria_mod=="DENTRO DE NORMA" && $variedad_mod==$variedad && $calibre_mod=="4J" && $type_mod=="retorno" && $semana_mod == "no")
                              <button wire:click="saveOrUpdateModification" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                <span class="relative">Guardar</span>
                              </button>
                            @else
                              <span wire:click="set_modification('DENTRO DE NORMA', '{{ $variedad }}', '4J','{{($retorno_neto4j)}}','{{($retorno_neto4j)/$pesoneto4j}}','{{$pesoneto4j}}','retorno','no')" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full text-xs"></span>
                                <span class="relative">Editar</span>
                              </span>
                            @endif
                          </td>
                          <td>
                            @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "4J" && $semana_mod == "no")
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
                              @if ($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','4J')->where('semana','no')->count()>0)
                                <p class="text-red-500 font-bold whitespace-nowrap">
                                  {{number_format($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','4J')->where('semana','no')->first()->npk, 2, ',', '.') }} USD/kg
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
                          
                            @if ($categoria_mod=="DENTRO DE NORMA" && $variedad_mod==$variedad && $calibre_mod=="4J" && $type_mod=="npk" && $semana_mod=="no")
                              <button wire:click="saveOrUpdateModification" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                <span class="relative">Guardar</span>
                              </button>
                            @else
                              <span wire:click="set_modification('DENTRO DE NORMA', '{{ $variedad }}', '4J','{{($retorno_neto4j)}}','{{($retorno_neto4j)/$pesoneto4j}}','{{$pesoneto4j}}','npk','no')" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full text-xs"></span>
                                <span class="relative">Editar</span>
                              </span>
                            @endif
                          </td>
                          <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-center">
                            @if ($informe_edit->modificaciones->where('categoria', 'DENTRO DE NORMA')->where('variedad', $variedad)->where('calibre', '4J')->where('semana','no')->count() > 0)
                              @php
                                $mod = $informe_edit->modificaciones->where('categoria', 'DENTRO DE NORMA')->where('variedad', $variedad)->where('calibre', '4J')->where('semana','no')->first();
                              @endphp
                              @if ($mod->retorno > $mod->retorno_inicial)
                                <p class="text-green-500 font-bold"> +{{ $mod->retorno - $mod->retorno_inicial }} usd </p>
                              @else
                                <p class="text-red-500 font-bold"> {{ $mod->retorno - $mod->retorno_inicial }} usd </p>
                              @endif
                              <button title="Eliminar" class="cursorpointer text-xs text-red-500" wire:click="delete_modificacion('{{ $mod->id }}')">(Eliminar)</button>
                            @endif
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
                            @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "3J" && $semana_mod == "no")
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
                              @php
                                  $retorno_neto3j=($retorno);
                              @endphp
                            @else
                              @if ($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','3J')->where('semana','no')->count()>0)
                                <p class="text-red-500 font-bold whitespace-nowrap">
                                  {{number_format($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','3J')->where('semana','no')->first()->retorno, 2, ',', '.') }} USD
                                </p>
                                  @php
                                      $retorno_neto3j=$informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','3J')->where('semana','no')->first()->retorno;
                                  @endphp
                              @else
                                {{ number_format(($retorno3j - ($margen3j + $costos3j)), 2, ',', '.') }} USD <br>
                                @php
                                    $retorno_neto3j=($retorno3j - ($margen3j + $costos3j));
                                @endphp
                              @endif
                            @endif

                            @if ($categoria_mod=="DENTRO DE NORMA" && $variedad_mod==$variedad && $calibre_mod=="3J" && $type_mod=="retorno" && $semana_mod == "no")
                              <button wire:click="saveOrUpdateModification" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                <span class="relative">Guardar</span>
                              </button>
                            @else
                              <span wire:click="set_modification('DENTRO DE NORMA', '{{ $variedad }}', '3J','{{($retorno_neto3j)}}','{{($retorno_neto3j)/$pesoneto3j}}','{{$pesoneto3j}}','retorno','no')" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full text-xs"></span>
                                <span class="relative">Editar</span>
                              </span>
                            @endif
                          </td>
                          <td>
                            @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "3J" && $semana_mod == "no")
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
                              @if ($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','3J')->where('semana','no')->count()>0)
                                <p class="text-red-500 font-bold whitespace-nowrap">
                                  {{number_format($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','3J')->where('semana','no')->first()->npk, 2, ',', '.') }} USD/kg
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

                            @if ($categoria_mod=="DENTRO DE NORMA" && $variedad_mod==$variedad && $calibre_mod=="3J" && $type_mod=="npk" && $semana_mod=="no")
                              <button wire:click="saveOrUpdateModification" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                <span class="relative">Guardar</span>
                              </button>
                            @else
                              <span wire:click="set_modification('DENTRO DE NORMA', '{{ $variedad }}', '3J','{{($retorno_neto3j)}}','{{($retorno_neto3j)/$pesoneto3j}}','{{$pesoneto3j}}','npk','no')" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full text-xs"></span>
                                <span class="relative">Editar</span>
                              </span>
                            @endif
                          </td>
                          <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-center">
                            @if ($informe_edit->modificaciones->where('categoria', 'DENTRO DE NORMA')->where('variedad', $variedad)->where('calibre', '3J')->where('semana','no')->count() > 0)
                              @php
                                $mod = $informe_edit->modificaciones->where('categoria', 'DENTRO DE NORMA')->where('variedad', $variedad)->where('calibre', '3J')->where('semana','no')->first();
                              @endphp
                              @if ($mod->retorno > $mod->retorno_inicial)
                                <p class="text-green-500 font-bold"> +{{ $mod->retorno - $mod->retorno_inicial }} usd </p>
                              @else
                                <p class="text-red-500 font-bold"> {{ $mod->retorno - $mod->retorno_inicial }} usd </p>
                              @endif
                              <button title="Eliminar" class="cursorpointer text-xs text-red-500" wire:click="delete_modificacion('{{ $mod->id }}')">(Eliminar)</button>
                            @endif
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
                            @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "2J" && $semana_mod == "no")
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
                              @php
                                  $retorno_neto2j=($retorno);
                              @endphp
                            @else
                              @if ($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','2J')->where('semana','no')->count()>0)
                                <p class="text-red-500 font-bold whitespace-nowrap">
                                  {{number_format($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','2J')->where('semana','no')->first()->retorno, 2, ',', '.') }} USD
                                </p>
                                  @php
                                      $retorno_neto2j=$informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','2J')->where('semana','no')->first()->retorno;
                                  @endphp
                              @else
                                {{ number_format(($retorno2j - ($margen2j + $costos2j)), 2, ',', '.') }} USD <br>
                                @php
                                    $retorno_neto2j=($retorno2j - ($margen2j + $costos2j));
                                @endphp
                              @endif
                            @endif
                          
                            @if ($categoria_mod=="DENTRO DE NORMA" && $variedad_mod==$variedad && $calibre_mod=="2J" && $type_mod=="retorno" && $semana_mod == "no")
                              <button wire:click="saveOrUpdateModification" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                <span class="relative">Guardar</span>
                              </button>
                            @else
                              <span wire:click="set_modification('DENTRO DE NORMA', '{{ $variedad }}', '2J','{{($retorno_neto2j)}}','{{($retorno_neto2j)/$pesoneto2j}}','{{$pesoneto2j}}','retorno','no')" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full text-xs"></span>
                                <span class="relative">Editar</span>
                              </span>
                            @endif
                          </td>
                          <td>
                            @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "2J" && $semana_mod == "no")
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
                              @if ($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','2J')->where('semana','no')->count()>0)
                                <p class="text-red-500 font-bold whitespace-nowrap">
                                  {{number_format($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','2J')->where('semana','no')->first()->npk, 2, ',', '.') }} USD/kg
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
                          
                            @if ($categoria_mod=="DENTRO DE NORMA" && $variedad_mod==$variedad && $calibre_mod=="2J" && $type_mod=="npk" && $semana_mod=="no")
                              <button wire:click="saveOrUpdateModification" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                <span class="relative">Guardar</span>
                              </button>
                            @else
                              <span wire:click="set_modification('DENTRO DE NORMA', '{{ $variedad }}', '2J','{{($retorno_neto2j)}}','{{($retorno_neto2j)/$pesoneto2j}}','{{$pesoneto2j}}','npk','no')" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full text-xs"></span>
                                <span class="relative">Editar</span>
                              </span>
                            @endif
                          </td>
                          <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-center">
                            @if ($informe_edit->modificaciones->where('categoria', 'DENTRO DE NORMA')->where('variedad', $variedad)->where('calibre', '2J')->where('semana','no')->count() > 0)
                              @php
                                $mod = $informe_edit->modificaciones->where('categoria', 'DENTRO DE NORMA')->where('variedad', $variedad)->where('calibre', '2J')->where('semana','no')->first();
                              @endphp
                              @if ($mod->retorno > $mod->retorno_inicial)
                                <p class="text-green-500 font-bold"> +{{ $mod->retorno - $mod->retorno_inicial }} usd </p>
                              @else
                                <p class="text-red-500 font-bold"> {{ $mod->retorno - $mod->retorno_inicial }} usd </p>
                              @endif
                              <button title="Eliminar" class="cursorpointer text-xs text-red-500" wire:click="delete_modificacion('{{ $mod->id }}')">(Eliminar)</button>
                            @endif
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
                            @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "J" && $semana_mod == "no")
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
                              @php
                                  $retorno_netoj=($retorno);
                              @endphp
                            @else
                              @if ($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','J')->where('semana','no')->count()>0)
                                <p class="text-red-500 font-bold whitespace-nowrap">
                                  {{number_format($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','J')->where('semana','no')->first()->retorno, 2, ',', '.') }} USD
                                </p>
                                  @php
                                      $retorno_netoj=$informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','J')->where('semana','no')->first()->retorno;
                                  @endphp
                              @else
                                {{ number_format(($retornoj - ($margenj + $costosj)), 2, ',', '.') }} USD <br>
                                @php
                                    $retorno_netoj=($retornoj - ($margenj + $costosj));
                                @endphp
                              @endif
                            @endif
                          
                            @if ($categoria_mod=="DENTRO DE NORMA" && $variedad_mod==$variedad && $calibre_mod=="J" && $type_mod=="retorno" && $semana_mod == "no")
                              <button wire:click="saveOrUpdateModification" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                <span class="relative">Guardar</span>
                              </button>
                            @else
                              <span wire:click="set_modification('DENTRO DE NORMA', '{{ $variedad }}', 'J','{{($retorno_netoj)}}','{{($retorno_netoj)/$pesonetoj}}','{{$pesonetoj}}','retorno','no')" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full text-xs"></span>
                                <span class="relative">Editar</span>
                              </span>
                            @endif
                          </td>
                          <td>
                            @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "J" && $semana_mod == "no")
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
                              @if ($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','J')->where('semana','no')->count()>0)
                                <p class="text-red-500 font-bold whitespace-nowrap">
                                  {{number_format($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','J')->where('semana','no')->first()->npk, 2, ',', '.') }} USD/kg
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
                          
                            @if ($categoria_mod=="DENTRO DE NORMA" && $variedad_mod==$variedad && $calibre_mod=="J" && $type_mod=="npk" && $semana_mod=="no")
                              <button wire:click="saveOrUpdateModification" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                <span class="relative">Guardar</span>
                              </button>
                            @else
                              <span wire:click="set_modification('DENTRO DE NORMA', '{{ $variedad }}', 'J','{{($retorno_netoj)}}','{{($retorno_netoj)/$pesonetoj}}','{{$pesonetoj}}','npk','no')" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full text-xs"></span>
                                <span class="relative">Editar</span>
                              </span>
                            @endif
                          </td>
                          <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-center">
                            @if ($informe_edit->modificaciones->where('categoria', 'DENTRO DE NORMA')->where('variedad', $variedad)->where('calibre', 'J')->where('semana','no')->count() > 0)
                              @php
                                $mod = $informe_edit->modificaciones->where('categoria', 'DENTRO DE NORMA')->where('variedad', $variedad)->where('calibre', 'J')->where('semana','no')->first();
                              @endphp
                              @if ($mod->retorno > $mod->retorno_inicial)
                                <p class="text-green-500 font-bold"> +{{ $mod->retorno - $mod->retorno_inicial }} usd </p>
                              @else
                                <p class="text-red-500 font-bold"> {{ $mod->retorno - $mod->retorno_inicial }} usd </p>
                              @endif
                              <button title="Eliminar" class="cursorpointer text-xs text-red-500" wire:click="delete_modificacion('{{ $mod->id }}')">(Eliminar)</button>
                            @endif
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
                            @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "XL" && $semana_mod == "no")
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
                              @php
                                  $retorno_netoxl=($retorno);
                              @endphp
                            @else
                              @if ($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','XL')->where('semana','no')->count()>0)
                                <p class="text-red-500 font-bold whitespace-nowrap">
                                  {{number_format($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','XL')->where('semana','no')->first()->retorno, 2, ',', '.') }} USD
                                </p>
                                  @php
                                      $retorno_netoxl=$informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','XL')->where('semana','no')->first()->retorno;
                                  @endphp
                              @else
                                {{ number_format(($retornoxl - ($margenxl + $costosxl)), 2, ',', '.') }} USD <br>
                                @php
                                    $retorno_netoxl=($retornoxl - ($margenxl + $costosxl));
                                @endphp
                              @endif
                            @endif
                          
                            @if ($categoria_mod=="DENTRO DE NORMA" && $variedad_mod==$variedad && $calibre_mod=="XL" && $type_mod=="retorno" && $semana_mod == "no")
                              <button wire:click="saveOrUpdateModification" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                <span class="relative">Guardar</span>
                              </button>
                            @else
                              <span wire:click="set_modification('DENTRO DE NORMA', '{{ $variedad }}', 'XL','{{($retorno_netoxl)}}','{{($retorno_netoxl)/$pesonetoxl}}','{{$pesonetoxl}}','retorno','no')" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full text-xs"></span>
                                <span class="relative">Editar</span>
                              </span>
                            @endif
                          </td>
                          <td>
                            @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "XL" && $semana_mod == "no")
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
                              @if ($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','XL')->where('semana','no')->count()>0)
                                <p class="text-red-500 font-bold whitespace-nowrap">
                                  {{number_format($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','XL')->where('semana','no')->first()->npk, 2, ',', '.') }} USD/kg
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
                          
                            @if ($categoria_mod=="DENTRO DE NORMA" && $variedad_mod==$variedad && $calibre_mod=="XL" && $type_mod=="npk" && $semana_mod=="no")
                              <button wire:click="saveOrUpdateModification" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                <span class="relative">Guardar</span>
                              </button>
                            @else
                              <span wire:click="set_modification('DENTRO DE NORMA', '{{ $variedad }}', 'XL','{{($retorno_netoxl)}}','{{($retorno_netoxl)/$pesonetoxl}}','{{$pesonetoxl}}','npk','no')" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full text-xs"></span>
                                <span class="relative">Editar</span>
                              </span>
                            @endif
                          </td>
                          <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-center">
                            @if ($informe_edit->modificaciones->where('categoria', 'DENTRO DE NORMA')->where('variedad', $variedad)->where('calibre', 'XL')->where('semana','no')->count() > 0)
                              @php
                                $mod = $informe_edit->modificaciones->where('categoria', 'DENTRO DE NORMA')->where('variedad', $variedad)->where('calibre', 'XL')->where('semana','no')->first();
                              @endphp
                              @if ($mod->retorno > $mod->retorno_inicial)
                                <p class="text-green-500 font-bold"> +{{ $mod->retorno - $mod->retorno_inicial }} usd </p>
                              @else
                                <p class="text-red-500 font-bold"> {{ $mod->retorno - $mod->retorno_inicial }} usd </p>
                              @endif
                              <button title="Eliminar" class="cursorpointer text-xs text-red-500" wire:click="delete_modificacion('{{ $mod->id }}')">(Eliminar)</button>
                            @endif
                          </td>
                          
                          
                        </tr>
                        @php
                          $calibrecount+=1;
                        @endphp
                      @endif
                    @endif
                    
                    @if ($pesoneto5j+$pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl>0)
                      
                      <tr>
                        <td></td>
                        <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">Total {{$variedad}}</td>
                        <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
                        <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; ">{{number_format($pesoneto5j+$pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl,2,',','.')}} KGS</td>
                        <td>
                          {{number_format($retorno5j+$retorno4j+$retorno3j+$retorno2j+$retornoj+$retornoxl,2,',','.')}}
                        </td>
                        <td>
                          {{number_format(($margen5j+$margen4j+$margen3j+$margen2j+$margenj+$margenxl),2,',','.')}}
                        </td>
                      
                        <td>
                          {{number_format($costos5j+$costos4j+$costos3j+$costos2j+$costosj+$costosxl,2)}}
                        </td>
                        <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format(($retorno_neto5j+$retorno_neto4j+$retorno_neto3j+$retorno_neto2j+$retorno_netoj+$retorno_netoxl),2,',','.')}} USD
                        
                        
                      </td>
                        <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format(($retorno_neto5j+$retorno_neto4j+$retorno_neto3j+$retorno_neto2j+$retorno_netoj+$retorno_netoxl)/($pesoneto5j+$pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl),2,',','.')}} USD/KG</td>
                        
                      </tr>
                    @endif 
                      @php
                        $totalcount+=($retorno_neto5j+$retorno_neto4j+$retorno_neto3j+$retorno_neto2j+$retorno_netoj+$retorno_netoxl);
                        $variedadcount+=1;
                      @endphp
                    
          
                  @endforeach
                
                  @if ($pesonetototal>0)
                    <tr style="background-color: #ddd;">
                          
                      
                    
                        <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">Total Dentro de Norma</td>
                      
                      
                        <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
                    
                      
                      
                      <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"></td>
                      <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format($pesonetototal,1,',','.')}} KGS</td>
                      <td>{{number_format($totalretorno5j+$totalretorno4j+$totalretorno3j+$totalretorno2j+$totalretornoj+$totalretornoxl,2)}} usd</td>
                      <td>{{number_format(($totalmargen5j+$totalmargen4j+$totalmargen3j+$totalmargen2j+$totalmargenj+$totalmargenxl),2)}} usd</td>
                    
                      <td>
                        {{number_format(($totalcostos5j+$totalcostos4j+$totalcostos3j+$totalcostos2j+$totalcostosj+$totalcostosxl),2)}}
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
              @endif
            </table>
          </div>
              <!-- Fuera de norma -->
            <div>
              <label class="flex justify-between items-center cursor-pointer">
                <span class="ml-3 text-gray-700">Desglose por semana en fruta Fuera de Norma</span>
                  <div class="relative">
                      <input type="checkbox"
                          wire:click="toggleSemana('semana_fueradenorma')"
                          class="sr-only"
                          {{ $informe_edit->semana_fueradenorma === 'si' ? 'checked' : '' }}>
                      <div class="block w-14 h-8 rounded-full transition
                          {{ $informe_edit->semana_fueradenorma === 'si' ? 'bg-blue-500' : 'bg-gray-300' }}">
                      </div>
                      <div class="dot absolute left-1 top-1 w-6 h-6 rounded-full bg-white shadow transition
                          {{ $informe_edit->semana_fueradenorma === 'si' ? 'translate-x-6' : '' }}">
                      </div>
                  </div>
                 
              </label>
          </div>
         
          <!-- Fuera de norma nuevo -->
          <table id="balance" style="width:100%; border-collapse: collapse; margin-top: 20px;">
            <thead style="border-top: 2px solid black; border-bottom: 2px solid black;">
              <tr>
                <th>Norma</th>
                <th>Variedad</th>
                @if ($informe_edit->semana_fueradenorma=='si')
                  <th>Semana</th>
                  <th></th>
                  <th></th>
                @endif
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
            @if ($informe_edit->semana_fueradenorma=='si')
              <tbody>
                  <tr style="background-color: #ddd;">
                          
                      <td> FUERA DE NORMA </td>
                  
                  
                      <td> </td>
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
                    $semanacounter=1;
                    $variedadcount=1;
                    $cantidadtotal=0;
                    $pesonetototal=0;
                    $retornototal=0;
                    
                    $totalretorno5j=0;
                    $totalretorno4j=0;
                      $totalretorno3j=0;
                      $totalretorno2j=0;
                      $totalretornoj=0;
                      $totalretornoxl=0;
                      $totalretornol=0;
          
                      $totalmargen5j=0;
                      $totalmargen4j=0;
                      $totalmargen3j=0;
                      $totalmargen2j=0;
                      $totalmargenj=0;
                      $totalmargenxl=0;
                      $totalmargenl=0;
          
                      $totalcostopacking=0;
                      $globaltotalmateriales=0;
          
                      $totalpesonetol=0;
          
                      $globaltotalotroscostos=0;
                      $totalcount=0;
          
                      $totalcostos5j=0;
                      $totalcostos4j=0;
                      $totalcostos3j=0;
                      $totalcostos2j=0;
                      $totalcostosj=0;
                      $totalcostosxl=0;
                      $totalcostosl=0;
                      
                  @endphp
                
                    @foreach ($unique_variedades as $variedad)
                      <tr style="background-color: white;">
          
          
          
                        <td> </td>
                      
                        <td style="font-weight: bold; text-align: center;"> {{$variedad}} </td>
                    
                      
                        <td></td>
                        <td></td>
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
                            
                            
                            $cantidad5j=0;
                            $cantidad4j=0;
                            $cantidad3j=0;
                            $cantidad2j=0;
                            $cantidadj=0;
                            $cantidadxl=0;
                            $cantidadl=0;
                            
                            $pesoneto5j=0;
                            $pesoneto4j=0;
                            $pesoneto3j=0;
                            $pesoneto2j=0;
                            $pesonetoj=0;
                            $pesonetoxl=0;
                            $pesonetol=0;
                
                            
                            $retorno5j=0;
                            $retorno4j=0;
                            $retorno3j=0;
                            $retorno2j=0;
                            $retornoj=0;
                            $retornoxl=0;
                            $retornol=0;
          
                            $retorno_neto5j=0;
                            $retorno_neto4j=0;
                            $retorno_neto3j=0;
                            $retorno_neto2j=0;
                            $retorno_netoj=0;
                            $retorno_netoxl=0;
                            $retorno_netol=0;
          
                            $margen5j=0;
                            $margen4j=0;
                            $margen3j=0;
                            $margen2j=0;
                            $margenj=0;
                            $margenxl=0;
                            $margenl=0;
                
                            $costopacking=0;
                
                            $totalmateriales4j=0;
                            $totalmateriales3j=0;
                            $totalmateriales2j=0;
                            $totalmaterialesj=0;
                            $totalmaterialesxl=0;
                            $totalmaterialesl=0;
          
                            $costos5j=0;
                            $costos4j=0;
                            $costos3j=0;
                            $costos2j=0;
                            $costosj=0;
                            $costosxl=0;
                            $costosl=0;
                
                            $otroscostos=0;
                            $totalotroscostos=0;
                            
                            
                            $masatotal=0;
                
                      @endphp
                      @foreach ($unique_semanas as $semana)
                        @if ($semana)
                          
                          @php
                            $calibrecount=1;
                            
                            
                            $cantidad5j_semana=0;
                            $cantidad4j_semana=0;
                            $cantidad3j_semana=0;
                            $cantidad2j_semana=0;
                            $cantidadj_semana=0;
                            $cantidadxl_semana=0;
                            $cantidadl_semana=0;
                            
                            $pesoneto5j_semana=0;
                            $pesoneto4j_semana=0;
                            $pesoneto3j_semana=0;
                            $pesoneto2j_semana=0;
                            $pesonetoj_semana=0;
                            $pesonetoxl_semana=0;
                            $pesonetol_semana=0;
                
                            
                            $retorno5j_semana=0;
                            $retorno4j_semana=0;
                            $retorno3j_semana=0;
                            $retorno2j_semana=0;
                            $retornoj_semana=0;
                            $retornoxl_semana=0;
                            $retornol_semana=0;
          
                            $retorno_neto5j_semana=0;
                            $retorno_neto4j_semana=0;
                            $retorno_neto3j_semana=0;
                            $retorno_neto2j_semana=0;
                            $retorno_netoj_semana=0;
                            $retorno_netoxl_semana=0;
                            $retorno_netol_semana=0;
          
                            $margen5j_semana=0;
                            $margen4j_semana=0;
                            $margen3j_semana=0;
                            $margen2j_semana=0;
                            $margenj_semana=0;
                            $margenxl_semana=0;
                            $margenl_semana=0;
                
                            $costopacking=0;
                
                            $totalmateriales4j_semana=0;
                            $totalmateriales3j_semana=0;
                            $totalmateriales2j_semana=0;
                            $totalmaterialesj_semana=0;
                            $totalmaterialesxl_semana=0;
                            $totalmaterialesl_semana=0;
          
                            $costos5j_semana=0;
                            $costos4j_semana=0;
                            $costos3j_semana=0;
                            $costos2j_semana=0;
                            $costosj_semana=0;
                            $costosxl_semana=0;
                            $costosl_semana=0;
                
                            $otroscostos_semana=0;
                            $totalotroscostos_semana=0;
                            
                            
                            $masatotal_semana=0;
                
                          @endphp
                
                          @foreach ($masas->where('tipo','EXPORTACIÓN')->where('semana',$semana) as $masa)
                            @php
                                $tarifafinal = 0;
                                if (!is_null($masa->fob)) {
                                    if ($masa->fob->tarifas->count() > 0) {
                                        $tarifafinal = $masa->fob->tarifas->reverse()->first()->tarifa_fc;
                                        $tarifafinal2 = $masa->fob->tarifas->reverse()->first()->tarifa;
                                    }
                                }
                            @endphp
                        
                            @if (($masa->calibre_real == '5J') && $masa->variedad == $variedad)
                              @php
                                // Versión semanal
                                $cantidad5j_semana += floatval($masa->cantidad);
                                $pesoneto5j_semana += floatval($masa->peso_prorrateado);
                            
                                if (!is_null($masa->fob)) {
                                    $retorno5j_semana += floatval($masa->peso_prorrateado * $tarifafinal);
                                    $retorno_neto5j_semana += floatval($masa->peso_prorrateado * $tarifafinal);
                                    $margen5j_semana += floatval($masa->peso_prorrateado * $tarifafinal * 0.08);
                                }
                            
                                $costos5j_semana += floatval($masa->costo);
                            
                                // Versión total (sin _semana)
                                $cantidad5j += floatval($masa->cantidad);
                                $pesoneto5j += floatval($masa->peso_prorrateado);
                            
                                if (!is_null($masa->fob)) {
                                    $retorno5j += floatval($masa->peso_prorrateado * $tarifafinal);
                                    $margen5j += floatval($masa->peso_prorrateado * $tarifafinal * 0.08);
                                }
                            
                                $costos5j += floatval($masa->costo);
                              @endphp
                            @endif
                      
                        
                            @if (($masa->calibre_real == '4J') && $masa->variedad == $variedad)
                              @php
                                  // Semana
                                  $cantidad4j_semana += floatval($masa->cantidad);
                                  $pesoneto4j_semana += floatval($masa->peso_prorrateado);
                                  if (!is_null($masa->fob)) {
                                      $retorno4j_semana += floatval($masa->peso_prorrateado * $tarifafinal);
                                      $retorno_neto4j_semana += floatval($masa->peso_prorrateado * $tarifafinal);
                                      $margen4j_semana += floatval($masa->peso_prorrateado * $tarifafinal * 0.08);
                                  }
                                  $costos4j_semana += floatval($masa->costo);
                                  $totalmateriales4j_semana += floatval($masa->costo);
                            
                                  // Total
                                  $cantidad4j += floatval($masa->cantidad);
                                  $pesoneto4j += floatval($masa->peso_prorrateado);
                                  if (!is_null($masa->fob)) {
                                      $retorno4j += floatval($masa->peso_prorrateado * $tarifafinal);
                                      $margen4j += floatval($masa->peso_prorrateado * $tarifafinal * 0.08);
                                  }
                                  $costos4j += floatval($masa->costo);
                                  $totalmateriales4j += floatval($masa->costo);
                              @endphp
                            @endif
                            
                            @if (($masa->calibre_real == '3J') && $masa->variedad == $variedad)
                              @php
                                  $cantidad3j_semana += floatval($masa->cantidad);
                                  $pesoneto3j_semana += floatval($masa->peso_prorrateado);
                                  if (!is_null($masa->fob)) {
                                      $retorno3j_semana += floatval($masa->peso_prorrateado * $tarifafinal);
                                      $retorno_neto3j_semana += floatval($masa->peso_prorrateado * $tarifafinal);
                                      $margen3j_semana += floatval($masa->peso_prorrateado * $tarifafinal * 0.08);
                                  }
                                  $costos3j_semana += floatval($masa->costo);
                                  $totalmateriales3j_semana += floatval($masa->costo);
                            
                                  $cantidad3j += floatval($masa->cantidad);
                                  $pesoneto3j += floatval($masa->peso_prorrateado);
                                  if (!is_null($masa->fob)) {
                                      $retorno3j += floatval($masa->peso_prorrateado * $tarifafinal);
                                      $margen3j += floatval($masa->peso_prorrateado * $tarifafinal * 0.08);
                                  }
                                  $costos3j += floatval($masa->costo);
                                  $totalmateriales3j += floatval($masa->costo);
                              @endphp
                            @endif
                            
                            @if (($masa->calibre_real == '2J') && $masa->variedad == $variedad)
                              @php
                                  $cantidad2j_semana += floatval($masa->cantidad);
                                  $pesoneto2j_semana += floatval($masa->peso_prorrateado);
                                  if (!is_null($masa->fob)) {
                                      $retorno2j_semana += floatval($masa->peso_prorrateado * $tarifafinal);
                                      $retorno_neto2j_semana += floatval($masa->peso_prorrateado * $tarifafinal);
                                      $margen2j_semana += floatval($masa->peso_prorrateado * $tarifafinal * 0.08);
                                  }
                                  $costos2j_semana += floatval($masa->costo);
                                  $totalmateriales2j_semana += floatval($masa->costo);
                            
                                  $cantidad2j += floatval($masa->cantidad);
                                  $pesoneto2j += floatval($masa->peso_prorrateado);
                                  if (!is_null($masa->fob)) {
                                      $retorno2j += floatval($masa->peso_prorrateado * $tarifafinal);
                                      $margen2j += floatval($masa->peso_prorrateado * $tarifafinal * 0.08);
                                  }
                                  $costos2j += floatval($masa->costo);
                                  $totalmateriales2j += floatval($masa->costo);
                              @endphp
                            @endif
                            
                            @if (($masa->calibre_real == 'J') && $masa->variedad == $variedad)
                              @php
                                  $cantidadj_semana += floatval($masa->cantidad);
                                  $pesonetoj_semana += floatval($masa->peso_prorrateado);
                                  if (!is_null($masa->fob)) {
                                      $retornoj_semana += floatval($masa->peso_prorrateado * $tarifafinal);
                                      $retorno_netoj_semana += floatval($masa->peso_prorrateado * $tarifafinal);
                                      $margenj_semana += floatval($masa->peso_prorrateado * $tarifafinal * 0.08);
                                  }
                                  $costosj_semana += floatval($masa->costo);
                                  $totalmaterialesj_semana += floatval($masa->costo);
                            
                                  $cantidadj += floatval($masa->cantidad);
                                  $pesonetoj += floatval($masa->peso_prorrateado);
                                  if (!is_null($masa->fob)) {
                                      $retornoj += floatval($masa->peso_prorrateado * $tarifafinal);
                                      $margenj += floatval($masa->peso_prorrateado * $tarifafinal * 0.08);
                                  }
                                  $costosj += floatval($masa->costo);
                                  $totalmaterialesj += floatval($masa->costo);
                              @endphp
                            @endif
                            
                            @if (($masa->calibre_real == 'XL') && $masa->variedad == $variedad)
                              @php
                                  $cantidadxl_semana += floatval($masa->cantidad);
                                  $pesonetoxl_semana += floatval($masa->peso_prorrateado);
                                  if (!is_null($masa->fob)) {
                                      $retornoxl_semana += floatval($masa->peso_prorrateado * $tarifafinal);
                                      $retorno_netoxl_semana += floatval($masa->peso_prorrateado * $tarifafinal);
                                      $margenxl_semana += floatval($masa->peso_prorrateado * $tarifafinal * 0.08);
                                  }
                                  $costosxl_semana += floatval($masa->costo);
                                  $totalmaterialesxl_semana += floatval($masa->costo);
                            
                                  $cantidadxl += floatval($masa->cantidad);
                                  $pesonetoxl += floatval($masa->peso_prorrateado);
                                  if (!is_null($masa->fob)) {
                                      $retornoxl += floatval($masa->peso_prorrateado * $tarifafinal);
                                      $margenxl += floatval($masa->peso_prorrateado * $tarifafinal * 0.08);
                                  }
                                  $costosxl += floatval($masa->costo);
                                  $totalmaterialesxl += floatval($masa->costo);
                              @endphp
                            @endif
                            
                        
                            @if (($masa->calibre_real == 'L') && $masa->variedad == $variedad)
                                @php
                                    $cantidadl_semana += floatval($masa->cantidad);
                                    $pesonetol_semana += floatval($masa->peso_prorrateado);
                                    if (!is_null($masa->fob)) {
                                        $retornol_semana += floatval($masa->peso_prorrateado * $tarifafinal);
                                        $retorno_netol_semana += floatval($masa->peso_prorrateado * $tarifafinal);
                                        $margenl_semana += floatval($masa->peso_prorrateado * $tarifafinal * 0.08);
                                    }
                                    $costosl_semana += floatval($masa->costo);
                                    $totalmaterialesl_semana += floatval($masa->costo);
          
                                    $cantidadl += floatval($masa->cantidad);
                                    $pesonetol += floatval($masa->peso_prorrateado);
                                    if (!is_null($masa->fob)) {
                                        $retornol += floatval($masa->peso_prorrateado * $tarifafinal);
                                        $margenl += floatval($masa->peso_prorrateado * $tarifafinal * 0.08);
                                    }
                                    $costosl += floatval($masa->costo);
                                    $totalmaterialesl += floatval($masa->costo);
                                @endphp
                            @endif
          
                        
                            @if (in_array($masa->calibre_real, ['L']) && $masa->variedad == $variedad)
                                @php
                                    $masatotal_semana += floatval($masa->peso_prorrateado);
                                   
                                @endphp
                            @endif
                          @endforeach
                          @php
                               $pesonetototal+=$masatotal_semana;
          
                               $totalretorno5j+=$retorno5j_semana;
                               $totalretorno4j+=$retorno4j_semana;
                               $totalretorno3j+=$retorno3j_semana;
                               $totalretorno2j+=$retorno2j_semana;
                               $totalretornoj+=$retornoj_semana;
                               $totalretornoxl+=$retornoxl_semana;
                               $totalretornol+=$retornol_semana;
          
                                $totalmargen5j += $margen5j_semana;
                                $totalmargen4j += $margen4j_semana;
                                $totalmargen3j += $margen3j_semana;
                                $totalmargen2j += $margen2j_semana;
                                $totalmargenj  += $margenj_semana;
                                $totalmargenxl += $margenxl_semana;
                                $totalmargenl += $margenl_semana;
          
                                $totalcostos5j += $costos5j_semana;
                                $totalcostos4j += $costos4j_semana;
                                $totalcostos3j += $costos3j_semana;
                                $totalcostos2j += $costos2j_semana;
                                $totalcostosj  += $costosj_semana;
                                $totalcostosxl += $costosxl_semana;
                                $totalcostosl += $costosl_semana;
          
          
                               
                          @endphp
                          @if ($cantidadl_semana>0)
          
                            <tr style="background-color: white;">
            
          
          
                              <td> </td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td> {{$semana}} </td>
                          
                            
                            
                            
                              
                              <td ></td>
                              <td>
                              </td>
                              <td>
                  
                              </td>
                              <td>
                  
                              </td>
                              
                            </tr>
                            
                            @if ($pesonetol_semana > 0)
                              <tr>
                                <td> </td>
                                <td> </td>
                                <td> </td>
                                {{-- total semana --}}
                                <td> </td>
                                {{-- semana --}}
                                <td> </td>
          
                                <td>L</td>
                                <td style="text-align:right; padding-right:30px; border-left: 1px solid #ddd; white-space: nowrap;">{{ number_format($pesonetol_semana, 2, ',', '.') }} KGS</td>
                                <td>{{ number_format($retornol_semana, 2, ',', '.') }}</td>
                                <td>{{ number_format($margenl_semana, 2, ',', '.') }}</td>
                                <td>{{ number_format($costosl_semana, 2) }}</td>
          
                                {{-- npk --}}
                                <td>
                                  @if ($categoria_mod == "FUERA DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "L" && $semana_mod == $semana)
                                    @if ($type_mod == "npk")
                                      {{ $retorno }} <br>
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
                                    @php
                                      $retorno_netol_semana = $retorno;
                                    @endphp
                                  @else
                                    @if ($informe_edit->modificaciones->where('categoria','FUERA DE NORMA')->where('variedad',$variedad)->where('calibre','L')->where('semana',$semana)->count() > 0)
                                      <p class="text-red-500 font-bold whitespace-nowrap">
                                        {{ number_format($informe_edit->modificaciones->where('categoria','FUERA DE NORMA')->where('variedad',$variedad)->where('calibre','L')->where('semana',$semana)->first()->retorno, 2, ',', '.') }} USD
                                      </p>
                                      @php
                                        $retorno_netol_semana = $informe_edit->modificaciones->where('categoria','FUERA DE NORMA')->where('variedad',$variedad)->where('calibre','L')->where('semana',$semana)->first()->retorno;
                                      @endphp
                                    @else
                                      {{ number_format(($retornol_semana - ($margenl_semana + $costosl_semana)), 2, ',', '.') }} USD <br>
                                      @php
                                        $retorno_netol_semana = $retornol_semana - ($margenl_semana + $costosl_semana);
                                      @endphp
                                    @endif
                                  @endif
                                  @php
                                    $retorno_netol += $retorno_netol_semana;
                                  @endphp
                                  @if ($categoria_mod=="FUERA DE NORMA" && $variedad_mod==$variedad && $calibre_mod=="L" && $semana_mod == $semana && $type_mod=="retorno")
                                    <button wire:click="saveOrUpdateModification" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                      <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                      <span class="relative">Guardar</span>
                                    </button>
                                  @else
                                    <span wire:click="set_modification('FUERA DE NORMA', '{{ $variedad }}', 'L','{{($retorno_netol_semana)}}','{{($retorno_netol_semana)/$pesonetol_semana}}','{{$pesonetol_semana}}','retorno',{{$semana}})" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                      <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full text-xs"></span>
                                      <span class="relative">Editar</span>
                                    </span>
                                  @endif
                                </td>
          
                                {{-- retorno --}}
                                <td>
                                  @if ($categoria_mod == "FUERA DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "L" && $semana_mod == $semana)
                                    @if ($type_mod == "retorno")
                                      {{ $npk }} <br>
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
                                    @if ($informe_edit->modificaciones->where('categoria', 'FUERA DE NORMA')->where('variedad', $variedad)->where('calibre', 'L')->where('semana',$semana)->count() > 0)
                                      <p class="text-red-500 font-bold whitespace-nowrap">
                                        {{ number_format($informe_edit->modificaciones->where('categoria', 'FUERA DE NORMA')->where('variedad', $variedad)->where('calibre', 'L')->where('semana',$semana)->first()->npk, 2, ',', '.') }} USD/kg
                                      </p>
                                    @else
                                      @if ($pesonetol_semana)
                                        <p class="whitespace-nowrap">
                                          {{ number_format(($retornol_semana - ($margenl_semana + $costosl_semana)) / $pesonetol_semana, 2, ',', '.') }} USD/kg
                                        </p>
                                      @else
                                        0 USD/kg
                                      @endif
                                    @endif
                                  @endif
          
                                  @if ($categoria_mod == "FUERA DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "L" && $semana_mod == $semana && $type_mod == "npk")
                                    <button wire:click="saveOrUpdateModification" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                      <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                      <span class="relative">Guardar</span>
                                    </button>
                                  @else
                                    <span wire:click="set_modification('FUERA DE NORMA', '{{ $variedad }}', 'L','{{($retorno_netol_semana)}}','{{($retorno_netol_semana)/$pesonetol_semana}}','{{$pesonetol_semana}}','npk','{{$semana}}')" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                      <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full text-xs"></span>
                                      <span class="relative">Editar</span>
                                    </span>
                                  @endif
                                </td>
          
                                {{-- eliminar --}}
                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-center">
                                  @if ($informe_edit->modificaciones->where('categoria', 'FUERA DE NORMA')->where('variedad', $variedad)->where('calibre', 'L')->where('semana',$semana)->count() > 0)
                                    @php
                                      $mod = $informe_edit->modificaciones->where('categoria', 'FUERA DE NORMA')->where('variedad', $variedad)->where('calibre', 'L')->where('semana',$semana)->first();
                                    @endphp
                                    @if ($mod->retorno > $mod->retorno_inicial)
                                      <p class="text-green-500 font-bold"> +{{ $mod->retorno - $mod->retorno_inicial }} usd </p>
                                    @else
                                      <p class="text-red-500 font-bold"> {{ $mod->retorno - $mod->retorno_inicial }} usd </p>
                                    @endif
                                    <button title="Eliminar" class="cursorpointer text-xs text-red-500" wire:click="delete_modificacion('{{ $mod->id }}')">(Eliminar)</button>
                                  @endif
                                </td>
                              </tr>
          
                              @php
                                $calibrecount += 1;
                              @endphp
                            @endif
          
                          @endif
                          
                          @if ($pesonetol_semana>0)
                            
                            <tr>
                              <td></td>
                              <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
                              <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
                              <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">Total {{ $semana }}:</td>
                              <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
                              <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
                              <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; white-space: nowrap;">
                                {{ number_format($pesonetol_semana, 2, ',', '.') }} KGS
                              </td>
                              <td>
                                {{ number_format($retornol_semana, 2, ',', '.') }}
                              </td>
                              <td>
                                {{ number_format($margenl_semana, 2, ',', '.') }}
                              </td>
                              <td>
                                {{ number_format($costosl_semana, 2) }}
                              </td>
                              <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">
                                {{ number_format($retorno_netol_semana, 2, ',', '.') }} USD
                              </td>
                              <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">
                                {{ number_format(
                                  ($retorno_netol_semana)
                                  /
                                  ($pesonetol_semana),
                                  2, ',', '.'
                                ) }} USD/KG
                              </td>
                            </tr>
                          
                          @endif 
                          @php
                            $variedadcount+=1;
                            $semanacounter+=1;
                          @endphp
                        @endif
                      @endforeach
          
                    @if ($pesonetol>0)
          
                      <tr>
                        <td></td>
                        <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; text-align: center;">
                          Total {{$variedad}}:
                        </td>
                        
                        <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
                        <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
                        <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
                        <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
                        <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; white-space: nowrap;">{{number_format($pesonetol,2,',','.')}} KGS</td>
                        <td>
                          {{number_format($retornol,2,',','.')}}
                        </td>
                        <td>
                          {{number_format(($margenl),2,',','.')}}
                        </td>
                      
                        <td>
                          {{number_format($costosl,2)}}
                        </td>
                        <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format(($retorno_netol),2,',','.')}} USD
                        
                        
                        </td>
                      
                        <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format(($retorno_netol)/($pesonetol),2,',','.')}} USD/KG</td>
                        
                      </tr>
                      @php
                           $totalcount+=($retorno_netol);
                      @endphp
                    @endif
          
                  @endforeach
                
                @if ($pesonetototal>0)
                  <tr style="background-color: #ddd;">
                        
                    
                  
                      <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; white-space: nowrap;" colspan="4" >Total Fuera de Norma</td>
                    
                    
                      <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
                  
                    
                    
                    <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"></td>
                    <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format($pesonetototal,1,',','.')}} KGS</td>
                    <td>{{number_format($totalretornol,2)}} usd</td>
                    <td>{{number_format(($totalmargenl),2)}} usd</td>
                  
                    <td>
                      {{number_format(($totalcostosl),2)}}
                    </td>
                    
                    <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format($totalcount,2,',','.')}} USD 
                  
                    </td>
                    <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format($totalcount/$pesonetototal,2,',','.')}} usd/kg </td>
                    
                  </tr>
                @endif
          
                @php
                  $totalfueraodenorma=($totalcount);
                @endphp
                  
          
              </tbody>
            @else
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
                  
                  $totalretorno5j=0;
                  $totalretorno4j=0;
                    $totalretorno3j=0;
                    $totalretorno2j=0;
                    $totalretornoj=0;
                    $totalretornoxl=0;
                    $totalretornol=0;
          
                    $totalmargen5j=0;
                    $totalmargen4j=0;
                    $totalmargen3j=0;
                    $totalmargen2j=0;
                    $totalmargenj=0;
                    $totalmargenxl=0;
                    $totalmargenl=0;
          
                    $totalcostopacking=0;
                    $globaltotalmateriales=0;
          
                    $totalpesonetol=0;
          
                    $globaltotalotroscostos=0;
                    $totalcount=0;
          
                    $totalcostos5j=0;
                    $totalcostos4j=0;
                    $totalcostos3j=0;
                    $totalcostos2j=0;
                    $totalcostosj=0;
                    $totalcostosxl=0;
                    $totalcostosl=0;
                    
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
                    
                    
                    $cantidad5j=0;
                    $cantidad4j=0;
                    $cantidad3j=0;
                    $cantidad2j=0;
                    $cantidadj=0;
                    $cantidadxl=0;
                    $cantidadl=0;
                    
                    $pesoneto5j=0;
                    $pesoneto4j=0;
                    $pesoneto3j=0;
                    $pesoneto2j=0;
                    $pesonetoj=0;
                    $pesonetoxl=0;
                    $pesonetol=0;
          
                    
                    $retorno5j=0;
                    $retorno4j=0;
                    $retorno3j=0;
                    $retorno2j=0;
                    $retornoj=0;
                    $retornoxl=0;
                    $retornol=0;
          
                    $retorno_neto5j=0;
                    $retorno_neto4j=0;
                    $retorno_neto3j=0;
                    $retorno_neto2j=0;
                    $retorno_netoj=0;
                    $retorno_netoxl=0;
                    $retorno_netol=0;
          
                    $margen5j=0;
                    $margen4j=0;
                    $margen3j=0;
                    $margen2j=0;
                    $margenj=0;
                    $margenxl=0;
                    $margenl=0;
          
                    $costopacking=0;
          
                    $totalmateriales4j=0;
                    $totalmateriales3j=0;
                    $totalmateriales2j=0;
                    $totalmaterialesj=0;
                    $totalmaterialesxl=0;
                    $totalmaterialesl=0;
          
                    $costos5j=0;
                    $costos4j=0;
                    $costos3j=0;
                    $costos2j=0;
                    $costosj=0;
                    $costosxl=0;
                    $costosl=0;
          
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
                            
                      @if (($masa->calibre_real=='L') && $masa->variedad==$variedad)
                        @php
                          $cantidadl+=$masa->cantidad;
                          $pesonetol+=floatval($masa->peso_prorrateado);
                        
                          $costosl+=floatval($masa->costo);
                          $totalcostosl+=floatval($masa->costo);
          
                          if (!IS_NULL($masa->fob)) {
                            $retornol+=floatval($masa->peso_prorrateado*$tarifafinal);
                            $totalretornol+=floatval($masa->peso_prorrateado*$tarifafinal);
                            $margenl+=floatval($masa->peso_prorrateado*$tarifafinal*0.08);
                            $totalmargenl+=floatval($masa->peso_prorrateado*$tarifafinal*0.08);
                          }
          
                          $cantidadtotal+=$masa->cantidad;
                        @endphp	
                      @endif
          
                      
                      @if ( $masa->calibre_real=='L')
                            @php
                                  $masatotal+=$masa->peso_prorrateado;
                            @endphp
                      @endif
                    
                  @endforeach
                          @php
                               $pesonetototal=$masatotal;
                          @endphp
                 
                      
              
          
          
                  @if ($cantidadl>0)
                    
                    
                    @if ($pesonetol>0)
                      <tr>
                        <td> </td>
                        <td> </td>
          
                        <td>L</td>
                        <td style="text-align:right; padding-right:30px; border-left: 1px solid #ddd; white-space: nowrap;" >{{number_format($pesonetol,2,',','.')}} KGS</td>
                        <td>{{number_format(($retornol),2,',','.')}}
                        <td>{{number_format(($margenl),2,',','.')}}
                        </td>
                        <td>
                          {{number_format($costosl,2)}}
                        </td>
          
                        <td>
                          @if ($categoria_mod == "FUERA DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "L" && $semana_mod == "no")
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
                            @php
                                $retorno_netol=($retorno);
                            @endphp
                          @else
                            @if ($informe_edit->modificaciones->where('categoria','FUERA DE NORMA')->where('variedad',$variedad)->where('calibre','L')->where('semana','no')->count()>0)
                              <p class="text-red-500 font-bold whitespace-nowrap">
                                {{number_format($informe_edit->modificaciones->where('categoria','FUERA DE NORMA')->where('variedad',$variedad)->where('calibre','L')->where('semana','no')->first()->retorno, 2, ',', '.') }} USD
                              </p>
                              @php
                                  $retorno_netol=$informe_edit->modificaciones->where('categoria','FUERA DE NORMA')->where('variedad',$variedad)->where('calibre','L')->where('semana','no')->first()->retorno;
                              @endphp
                            @else
                              {{ number_format(($retornol - ($margenl + $costosl)), 2, ',', '.') }} USD <br>
                              @php
                                  $retorno_netol=($retornol - ($margenl + $costosl));
                              @endphp
                            @endif
                          @endif
          
                          @if ($categoria_mod=="FUERA DE NORMA" && $variedad_mod==$variedad && $calibre_mod=="L" && $type_mod=="retorno" && $semana_mod == "no")
                            <button wire:click="saveOrUpdateModification" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                              <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                              <span class="relative">Guardar</span>
                            </button>
                          @else
                            <span wire:click="set_modification('FUERA DE NORMA', '{{ $variedad }}', 'L','{{($retorno_netol)}}','{{($retorno_netol)/$pesonetol}}','{{$pesonetol}}','retorno','no')" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                              <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full text-xs"></span>
                              <span class="relative">Editar</span>
                            </span>
                          @endif
                        </td>
                        <td>
                          @if ($categoria_mod == "FUERA DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "L" && $semana_mod == "no")
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
                            @if ($informe_edit->modificaciones->where('categoria','FUERA DE NORMA')->where('variedad',$variedad)->where('calibre','L')->where('semana','no')->count()>0)
                              <p class="text-red-500 font-bold whitespace-nowrap">
                                {{number_format($informe_edit->modificaciones->where('categoria','FUERA DE NORMA')->where('variedad',$variedad)->where('calibre','L')->where('semana','no')->first()->npk, 2, ',', '.') }} USD/kg
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
          
                          @if ($categoria_mod=="FUERA DE NORMA" && $variedad_mod==$variedad && $calibre_mod=="L" && $type_mod=="npk" && $semana_mod=="no")
                            <button wire:click="saveOrUpdateModification" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                              <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                              <span class="relative">Guardar</span>
                            </button>
                          @else
                            <span wire:click="set_modification('FUERA DE NORMA', '{{ $variedad }}', 'L','{{($retorno_netol)}}','{{($retorno_netol)/$pesonetol}}','{{$pesonetol}}','npk','no')" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                              <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full text-xs"></span>
                              <span class="relative">Editar</span>
                            </span>
                          @endif
                        </td>
                        <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-center">
                          @if ($informe_edit->modificaciones->where('categoria', 'FUERA DE NORMA')->where('variedad', $variedad)->where('calibre', 'L')->where('semana','no')->count() > 0)
                            @php
                              $mod = $informe_edit->modificaciones->where('categoria', 'FUERA DE NORMA')->where('variedad', $variedad)->where('calibre', 'L')->where('semana','no')->first();
                            @endphp
                            @if ($mod->retorno > $mod->retorno_inicial)
                              <p class="text-green-500 font-bold"> +{{ $mod->retorno - $mod->retorno_inicial }} usd </p>
                            @else
                              <p class="text-red-500 font-bold"> {{ $mod->retorno - $mod->retorno_inicial }} usd </p>
                            @endif
                            <button title="Eliminar" class="cursorpointer text-xs text-red-500" wire:click="delete_modificacion('{{ $mod->id }}')">(Eliminar)</button>
                          @endif
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
                      <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; ">{{number_format($pesonetol,2,',','.')}} KGS</td>
                      <td>
                        {{number_format($retornol,2,',','.')}}
                      </td>
                      <td>
                        {{number_format(($margenl),2,',','.')}}
                      </td>
                    
                      <td>
                        {{number_format($costosl,2)}}
                      </td>
                      <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format(($retorno_netol),2,',','.')}} USD
                      
                      
                    </td>
                      <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format(($retorno_netol)/($pesonetol),2,',','.')}} USD/KG</td>
                      
                    </tr>
                  @endif 
                    @php
                      $totalcount+=($retorno_netol);
                      $variedadcount+=1;
                    @endphp
                  
          
                @endforeach
              
                @if ($pesonetototal>0)
                  <tr style="background-color: #ddd;">
                        
                    
                  
                      <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; white-space: nowrap;">Total Fuera de Norma</td>
                    
                    
                      <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
                  
                    
                    
                    <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"></td>
                    <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format($pesonetototal,1,',','.')}} KGS</td>
                    <td>{{number_format($totalretornol,2)}} usd</td>
                    <td>{{number_format(($totalmargenl),2)}} usd</td>
                  
                    <td>
                      {{number_format(($totalcostosl),2)}}
                    </td>
                    
                    <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format($totalcount,2,',','.')}} USD 
                  
                    </td>
                    <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format($totalcount/$pesonetototal,2,',','.')}} usd/kg </td>
                    
                  </tr>
                @endif
          
                @php
                  $totalfueraodenorma=($totalcount);
                @endphp
                  
          
              </tbody>
            @endif
          </table>
         
          <!-- Mercado Interno -->
            <div>
                <label class="flex justify-between items-center cursor-pointer">
                  <span class="ml-3 text-gray-700">Desglose por semana en fruta Mercado Interno</span>
                    <div class="relative">
                        <input type="checkbox"
                            wire:click="toggleSemana('semana_comercial')"
                            class="sr-only"
                            {{ $informe_edit->semana_comercial === 'si' ? 'checked' : '' }}>
                        <div class="block w-14 h-8 rounded-full transition
                            {{ $informe_edit->semana_comercial === 'si' ? 'bg-blue-500' : 'bg-gray-300' }}">
                        </div>
                        <div class="dot absolute left-1 top-1 w-6 h-6 rounded-full bg-white shadow transition
                            {{ $informe_edit->semana_comercial === 'si' ? 'translate-x-6' : '' }}">
                        </div>
                    </div>
                  
                </label>
            </div>

 

             <!-- Mercado Interno nuevo -->

              <table id="balance" style="width:100%; border-collapse: collapse; margin-top: 20px;">
                <thead style="border-top: 2px solid black; border-bottom: 2px solid black;">
                  <tr>
                    <th>Norma</th>
                    <th>Variedad</th>
                    @if ($informe_edit->semana_comercial=='si')
                      <th>Semana</th>
                      <th></th>
                      <th></th>
                    @endif
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
                @if ($informe_edit->semana_comercial=='si')
                  <tbody>
                      <tr style="background-color: #ddd;">
                              
                          <td> MERCADO INTERNO </td>
                      
                      
                          <td> </td>
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
                        $semanacounter=1;
                        $variedadcount=1;
                        $cantidadtotal=0;
                        $pesonetototal=0;
                        $retornototal=0;
                        
                        $totalretorno5j=0;
                        $totalretorno4j=0;
                          $totalretorno3j=0;
                          $totalretorno2j=0;
                          $totalretornoj=0;
                          $totalretornoxl=0;
                          $totalretornol=0;
                          $totalretornojup=0;
              
                          $totalmargen5j=0;
                          $totalmargen4j=0;
                          $totalmargen3j=0;
                          $totalmargen2j=0;
                          $totalmargenj=0;
                          $totalmargenxl=0;
                          $totalmargenl=0;
                          $totalmargenjup=0;
              
                          $totalcostopacking=0;
                          $globaltotalmateriales=0;
              
                          $totalpesonetol=0;
                          $totalpesonetojup=0;
              
                          $globaltotalotroscostos=0;
                          $totalcount=0;
              
                          $totalcostos5j=0;
                          $totalcostos4j=0;
                          $totalcostos3j=0;
                          $totalcostos2j=0;
                          $totalcostosj=0;
                          $totalcostosxl=0;
                          $totalcostosl=0;
                          $totalcostosjup=0;
                          
                      @endphp
                    
                        @foreach ($unique_variedades as $variedad)
                          <tr style="background-color: white;">
              
              
              
                            <td> </td>
                          
                            <td style="font-weight: bold; text-align: center;"> {{$variedad}} </td>
                        
                          
                            <td></td>
                            <td></td>
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
                                
                                
                                $cantidad5j=0;
                                $cantidad4j=0;
                                $cantidad3j=0;
                                $cantidad2j=0;
                                $cantidadj=0;
                                $cantidadxl=0;
                                $cantidadl=0;
                                $cantidadjup=0;
                                
                                $pesoneto5j=0;
                                $pesoneto4j=0;
                                $pesoneto3j=0;
                                $pesoneto2j=0;
                                $pesonetoj=0;
                                $pesonetoxl=0;
                                $pesonetol=0;
                                $pesonetojup=0;
                    
                                
                                $retorno5j=0;
                                $retorno4j=0;
                                $retorno3j=0;
                                $retorno2j=0;
                                $retornoj=0;
                                $retornoxl=0;
                                $retornol=0;
                                $retornojup=0;
              
                                $retorno_neto5j=0;
                                $retorno_neto4j=0;
                                $retorno_neto3j=0;
                                $retorno_neto2j=0;
                                $retorno_netoj=0;
                                $retorno_netoxl=0;
                                $retorno_netol=0;
                                $retorno_netojup=0;
              
                                $margen5j=0;
                                $margen4j=0;
                                $margen3j=0;
                                $margen2j=0;
                                $margenj=0;
                                $margenxl=0;
                                $margenl=0;
                                $margenjup=0;
                    
                                $costopacking=0;
                    
                                $totalmateriales4j=0;
                                $totalmateriales3j=0;
                                $totalmateriales2j=0;
                                $totalmaterialesj=0;
                                $totalmaterialesxl=0;
                                $totalmaterialesl=0;
                                $totalmaterialesjup=0;
              
                                $costos5j=0;
                                $costos4j=0;
                                $costos3j=0;
                                $costos2j=0;
                                $costosj=0;
                                $costosxl=0;
                                $costosl=0;
                                $costosjup=0;
                    
                                $otroscostos=0;
                                $totalotroscostos=0;
                                
                                
                                $masatotal=0;
                    
                          @endphp
                          @foreach ($unique_semanas as $semana)
                            @if ($semana)
                              
                              @php
                                $calibrecount=1;
                                
                                
                                $cantidad5j_semana=0;
                                $cantidad4j_semana=0;
                                $cantidad3j_semana=0;
                                $cantidad2j_semana=0;
                                $cantidadj_semana=0;
                                $cantidadxl_semana=0;
                                $cantidadl_semana=0;
                                $cantidadjup_semana=0;
                                
                                $pesoneto5j_semana=0;
                                $pesoneto4j_semana=0;
                                $pesoneto3j_semana=0;
                                $pesoneto2j_semana=0;
                                $pesonetoj_semana=0;
                                $pesonetoxl_semana=0;
                                $pesonetol_semana=0;
                                $pesonetojup_semana=0;
                    
                                
                                $retorno5j_semana=0;
                                $retorno4j_semana=0;
                                $retorno3j_semana=0;
                                $retorno2j_semana=0;
                                $retornoj_semana=0;
                                $retornoxl_semana=0;
                                $retornol_semana=0;
                                $retornojup_semana=0;
              
                                $retorno_neto5j_semana=0;
                                $retorno_neto4j_semana=0;
                                $retorno_neto3j_semana=0;
                                $retorno_neto2j_semana=0;
                                $retorno_netoj_semana=0;
                                $retorno_netoxl_semana=0;
                                $retorno_netol_semana=0;
                                $retorno_netojup_semana=0;
              
                                $margen5j_semana=0;
                                $margen4j_semana=0;
                                $margen3j_semana=0;
                                $margen2j_semana=0;
                                $margenj_semana=0;
                                $margenxl_semana=0;
                                $margenl_semana=0;
                                $margenjup_semana=0;
                    
                                $costopacking=0;
                    
                                $totalmateriales4j_semana=0;
                                $totalmateriales3j_semana=0;
                                $totalmateriales2j_semana=0;
                                $totalmaterialesj_semana=0;
                                $totalmaterialesxl_semana=0;
                                $totalmaterialesl_semana=0;
                                $totalmaterialesjup_semana=0;
              
                                $costos5j_semana=0;
                                $costos4j_semana=0;
                                $costos3j_semana=0;
                                $costos2j_semana=0;
                                $costosj_semana=0;
                                $costosxl_semana=0;
                                $costosl_semana=0;
                                $costosjup_semana=0;
                    
                                $otroscostos_semana=0;
                                $totalotroscostos_semana=0;
                                
                                
                                $masatotal_semana=0;
                    
                              @endphp
                    
                              @foreach ($masas->where('semana',$semana) as $masa)
                                @php
                                    $tarifafinal = 0;
                                    if (!is_null($masa->fob)) {
                                        if ($masa->fob->tarifas->count() > 0) {
                                            $tarifafinal = $masa->fob->tarifas->reverse()->first()->tarifa_fc;
                                            $tarifafinal2 = $masa->fob->tarifas->reverse()->first()->tarifa;
                                        }
                                    }
                                @endphp
                            
                                @if (($masa->calibre_real == '5J') && $masa->variedad == $variedad)
                                  @php
                                    // Versión semanal
                                    $cantidad5j_semana += floatval($masa->cantidad);
                                    $pesoneto5j_semana += floatval($masa->peso_prorrateado);
                                
                                    if (!is_null($masa->fob)) {
                                        $retorno5j_semana += floatval($masa->peso_prorrateado * $tarifafinal);
                                        $retorno_neto5j_semana += floatval($masa->peso_prorrateado * $tarifafinal);
                                        $margen5j_semana += floatval($masa->peso_prorrateado * $tarifafinal * 0.08);
                                    }
                                
                                    $costos5j_semana += floatval($masa->costo);
                                
                                    // Versión total (sin _semana)
                                    $cantidad5j += floatval($masa->cantidad);
                                    $pesoneto5j += floatval($masa->peso_prorrateado);
                                
                                    if (!is_null($masa->fob)) {
                                        $retorno5j += floatval($masa->peso_prorrateado * $tarifafinal);
                                        $margen5j += floatval($masa->peso_prorrateado * $tarifafinal * 0.08);
                                    }
                                
                                    $costos5j += floatval($masa->costo);
                                  @endphp
                                @endif
                          
                            
                                @if (($masa->calibre_real == '4J') && $masa->variedad == $variedad)
                                  @php
                                      // Semana
                                      $cantidad4j_semana += floatval($masa->cantidad);
                                      $pesoneto4j_semana += floatval($masa->peso_prorrateado);
                                      if (!is_null($masa->fob)) {
                                          $retorno4j_semana += floatval($masa->peso_prorrateado * $tarifafinal);
                                          $retorno_neto4j_semana += floatval($masa->peso_prorrateado * $tarifafinal);
                                          $margen4j_semana += floatval($masa->peso_prorrateado * $tarifafinal * 0.08);
                                      }
                                      $costos4j_semana += floatval($masa->costo);
                                      $totalmateriales4j_semana += floatval($masa->costo);
                                
                                      // Total
                                      $cantidad4j += floatval($masa->cantidad);
                                      $pesoneto4j += floatval($masa->peso_prorrateado);
                                      if (!is_null($masa->fob)) {
                                          $retorno4j += floatval($masa->peso_prorrateado * $tarifafinal);
                                          $margen4j += floatval($masa->peso_prorrateado * $tarifafinal * 0.08);
                                      }
                                      $costos4j += floatval($masa->costo);
                                      $totalmateriales4j += floatval($masa->costo);
                                  @endphp
                                @endif
                                
                                @if (($masa->calibre_real == '3J') && $masa->variedad == $variedad)
                                  @php
                                      $cantidad3j_semana += floatval($masa->cantidad);
                                      $pesoneto3j_semana += floatval($masa->peso_prorrateado);
                                      if (!is_null($masa->fob)) {
                                          $retorno3j_semana += floatval($masa->peso_prorrateado * $tarifafinal);
                                          $retorno_neto3j_semana += floatval($masa->peso_prorrateado * $tarifafinal);
                                          $margen3j_semana += floatval($masa->peso_prorrateado * $tarifafinal * 0.08);
                                      }
                                      $costos3j_semana += floatval($masa->costo);
                                      $totalmateriales3j_semana += floatval($masa->costo);
                                
                                      $cantidad3j += floatval($masa->cantidad);
                                      $pesoneto3j += floatval($masa->peso_prorrateado);
                                      if (!is_null($masa->fob)) {
                                          $retorno3j += floatval($masa->peso_prorrateado * $tarifafinal);
                                          $margen3j += floatval($masa->peso_prorrateado * $tarifafinal * 0.08);
                                      }
                                      $costos3j += floatval($masa->costo);
                                      $totalmateriales3j += floatval($masa->costo);
                                  @endphp
                                @endif
                                
                                @if (($masa->calibre_real == '2J') && $masa->variedad == $variedad)
                                  @php
                                      $cantidad2j_semana += floatval($masa->cantidad);
                                      $pesoneto2j_semana += floatval($masa->peso_prorrateado);
                                      if (!is_null($masa->fob)) {
                                          $retorno2j_semana += floatval($masa->peso_prorrateado * $tarifafinal);
                                          $retorno_neto2j_semana += floatval($masa->peso_prorrateado * $tarifafinal);
                                          $margen2j_semana += floatval($masa->peso_prorrateado * $tarifafinal * 0.08);
                                      }
                                      $costos2j_semana += floatval($masa->costo);
                                      $totalmateriales2j_semana += floatval($masa->costo);
                                
                                      $cantidad2j += floatval($masa->cantidad);
                                      $pesoneto2j += floatval($masa->peso_prorrateado);
                                      if (!is_null($masa->fob)) {
                                          $retorno2j += floatval($masa->peso_prorrateado * $tarifafinal);
                                          $margen2j += floatval($masa->peso_prorrateado * $tarifafinal * 0.08);
                                      }
                                      $costos2j += floatval($masa->costo);
                                      $totalmateriales2j += floatval($masa->costo);
                                  @endphp
                                @endif
                                
                                @if (($masa->calibre_real == 'J') && $masa->variedad == $variedad)
                                  @php
                                      $cantidadj_semana += floatval($masa->cantidad);
                                      $pesonetoj_semana += floatval($masa->peso_prorrateado);
                                      if (!is_null($masa->fob)) {
                                          $retornoj_semana += floatval($masa->peso_prorrateado * $tarifafinal);
                                          $retorno_netoj_semana += floatval($masa->peso_prorrateado * $tarifafinal);
                                          $margenj_semana += floatval($masa->peso_prorrateado * $tarifafinal * 0.08);
                                      }
                                      $costosj_semana += floatval($masa->costo);
                                      $totalmaterialesj_semana += floatval($masa->costo);
                                
                                      $cantidadj += floatval($masa->cantidad);
                                      $pesonetoj += floatval($masa->peso_prorrateado);
                                      if (!is_null($masa->fob)) {
                                          $retornoj += floatval($masa->peso_prorrateado * $tarifafinal);
                                          $margenj += floatval($masa->peso_prorrateado * $tarifafinal * 0.08);
                                      }
                                      $costosj += floatval($masa->costo);
                                      $totalmaterialesj += floatval($masa->costo);
                                  @endphp
                                @endif
                                
                                @if (($masa->calibre_real == 'XL') && $masa->variedad == $variedad)
                                  @php
                                      $cantidadxl_semana += floatval($masa->cantidad);
                                      $pesonetoxl_semana += floatval($masa->peso_prorrateado);
                                      if (!is_null($masa->fob)) {
                                          $retornoxl_semana += floatval($masa->peso_prorrateado * $tarifafinal);
                                          $retorno_netoxl_semana += floatval($masa->peso_prorrateado * $tarifafinal);
                                          $margenxl_semana += floatval($masa->peso_prorrateado * $tarifafinal * 0.08);
                                      }
                                      $costosxl_semana += floatval($masa->costo);
                                      $totalmaterialesxl_semana += floatval($masa->costo);
                                
                                      $cantidadxl += floatval($masa->cantidad);
                                      $pesonetoxl += floatval($masa->peso_prorrateado);
                                      if (!is_null($masa->fob)) {
                                          $retornoxl += floatval($masa->peso_prorrateado * $tarifafinal);
                                          $margenxl += floatval($masa->peso_prorrateado * $tarifafinal * 0.08);
                                      }
                                      $costosxl += floatval($masa->costo);
                                      $totalmaterialesxl += floatval($masa->costo);
                                  @endphp
                                @endif
                                
                            
                                @if (($masa->calibre_real == 'L') && $masa->variedad == $variedad)
                                    @php
                                        $cantidadl_semana += floatval($masa->cantidad);
                                        $pesonetol_semana += floatval($masa->peso_prorrateado);
                                        if (!is_null($masa->fob)) {
                                            $retornol_semana += floatval($masa->peso_prorrateado * $tarifafinal);
                                            $retorno_netol_semana += floatval($masa->peso_prorrateado * $tarifafinal);
                                            $margenl_semana += floatval($masa->peso_prorrateado * $tarifafinal * 0.08);
                                        }
                                        $costosl_semana += floatval($masa->costo);
                                        $totalmaterialesl_semana += floatval($masa->costo);
              
                                        $cantidadl += floatval($masa->cantidad);
                                        $pesonetol += floatval($masa->peso_prorrateado);
                                        if (!is_null($masa->fob)) {
                                            $retornol += floatval($masa->peso_prorrateado * $tarifafinal);
                                            $margenl += floatval($masa->peso_prorrateado * $tarifafinal * 0.08);
                                        }
                                        $costosl += floatval($masa->costo);
                                        $totalmaterialesl += floatval($masa->costo);
                                    @endphp
                                @endif
              
                                @if (($masa->calibre_real == 'JUP') && $masa->variedad == $variedad)
                                    @php
                                        $cantidadjup_semana += floatval($masa->cantidad);
                                        $pesonetojup_semana += floatval($masa->peso_prorrateado);
                                        if (!is_null($masa->fob)) {
                                            $retornojup_semana += floatval($masa->peso_prorrateado * $tarifafinal);
                                            $retorno_netojup_semana += floatval($masa->peso_prorrateado * $tarifafinal);
                                          // $margenjup_semana += floatval($masa->peso_prorrateado * $tarifafinal * 0.08);
                                        }
                                        $costosjup_semana += floatval($masa->costo);
                                        $totalmaterialesjup_semana += floatval($masa->costo);
              
                                        $cantidadjup += floatval($masa->cantidad);
                                        $pesonetojup += floatval($masa->peso_prorrateado);
                                        if (!is_null($masa->fob)) {
                                            $retornojup += floatval($masa->peso_prorrateado * $tarifafinal);
                                            //$margenjup += floatval($masa->peso_prorrateado * $tarifafinal * 0.08);
                                        }
                                        $costosjup += floatval($masa->costo);
                                        $totalmaterialesjup += floatval($masa->costo);
                                    @endphp
                                @endif
              
              
                            
                                @if (in_array($masa->calibre_real, ['JUP']) && $masa->variedad == $variedad)
                                    @php
                                        $masatotal_semana += floatval($masa->peso_prorrateado);
                                      
                                    @endphp
                                @endif
                              @endforeach
                              @php
                                  $pesonetototal+=$masatotal_semana;
              
                                  $totalretorno5j+=$retorno5j_semana;
                                  $totalretorno4j+=$retorno4j_semana;
                                  $totalretorno3j+=$retorno3j_semana;
                                  $totalretorno2j+=$retorno2j_semana;
                                  $totalretornoj+=$retornoj_semana;
                                  $totalretornoxl+=$retornoxl_semana;
                                  $totalretornol+=$retornol_semana;
                                  $totalretornojup+=$retornojup_semana;
              
                                    $totalmargen5j += $margen5j_semana;
                                    $totalmargen4j += $margen4j_semana;
                                    $totalmargen3j += $margen3j_semana;
                                    $totalmargen2j += $margen2j_semana;
                                    $totalmargenj  += $margenj_semana;
                                    $totalmargenxl += $margenxl_semana;
                                    $totalmargenl += $margenl_semana;
                                    $totalmargenjup += $margenjup_semana;
              
                                    $totalcostos5j += $costos5j_semana;
                                    $totalcostos4j += $costos4j_semana;
                                    $totalcostos3j += $costos3j_semana;
                                    $totalcostos2j += $costos2j_semana;
                                    $totalcostosj  += $costosj_semana;
                                    $totalcostosxl += $costosxl_semana;
                                    $totalcostosl += $costosl_semana;
                                    $totalcostosjup += $costosjup_semana;
              
              
                                  
                              @endphp
                              @if ($cantidadjup_semana>0)
              
                                <tr style="background-color: white;">
                
              
              
                                  <td> </td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td> {{$semana}} </td>
                              
                                
                                
                                
                                  
                                  <td ></td>
                                  <td>
                                  </td>
                                  <td>
                      
                                  </td>
                                  <td>
                      
                                  </td>
                                  
                                </tr>
                                
                                @if ($pesonetojup_semana > 0)
                                  
                                  <tr>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    {{-- total semana --}}
                                    <td> </td>
                                    {{-- semana --}}
                                    <td> </td>
                                  
                                    <td>JUP</td>
                                    <td style="text-align:right; padding-right:30px; border-left: 1px solid #ddd; white-space: nowrap;">{{ number_format($pesonetojup_semana, 2, ',', '.') }} KGS</td>
                                    <td>{{ number_format($retornojup_semana, 2, ',', '.') }}</td>
                                    <td>{{ number_format($margenjup_semana, 2, ',', '.') }}</td>
                                    <td>{{ number_format($costosjup_semana, 2) }}</td>
                                  
                                    {{-- npk --}}
                                    <td>
                                      @if ($categoria_mod == "MERCADO INTERNO" && $variedad_mod == $variedad && $calibre_mod == "JUP" && $semana_mod == $semana)
                                        @if ($type_mod == "npk")
                                          {{ $retorno }} <br>
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
                                        @php
                                          $retorno_netojup_semana = $retorno;
                                        @endphp
                                      @else
                                        @if ($informe_edit->modificaciones->where('categoria','MERCADO INTERNO')->where('variedad',$variedad)->where('calibre','JUP')->where('semana',$semana)->count() > 0)
                                          <p class="text-red-500 font-bold whitespace-nowrap">
                                            {{ number_format($informe_edit->modificaciones->where('categoria','MERCADO INTERNO')->where('variedad',$variedad)->where('calibre','JUP')->where('semana',$semana)->first()->retorno, 2, ',', '.') }} USD
                                          </p>
                                          @php
                                            $retorno_netojup_semana = $informe_edit->modificaciones->where('categoria','MERCADO INTERNO')->where('variedad',$variedad)->where('calibre','JUP')->where('semana',$semana)->first()->retorno;
                                          @endphp
                                        @else
                                          {{ number_format(($retornojup_semana - ($margenjup_semana + $costosjup_semana)), 2, ',', '.') }} USD <br>
                                          @php
                                            $retorno_netojup_semana = $retornojup_semana - ($costosjup_semana);
                                          @endphp
                                        @endif
                                      @endif
                                      @php
                                        $retorno_netojup += $retorno_netojup_semana;
                                      @endphp
                                      @if ($categoria_mod=="MERCADO INTERNO" && $variedad_mod==$variedad && $calibre_mod=="JUP" && $semana_mod == $semana && $type_mod=="retorno")
                                        <button wire:click="saveOrUpdateModification" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                          <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                          <span class="relative">Guardar</span>
                                        </button>
                                      @else
                                        <span wire:click="set_modification('MERCADO INTERNO', '{{ $variedad }}', 'JUP','{{($retorno_netojup_semana)}}','{{($retorno_netojup_semana)/$pesonetojup_semana}}','{{$pesonetojup_semana}}','retorno',{{$semana}})" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                          <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full text-xs"></span>
                                          <span class="relative">Editar</span>
                                        </span>
                                      @endif
                                    </td>
                                  
                                    {{-- retorno --}}
                                    <td>
                                      @if ($categoria_mod == "MERCADO INTERNO" && $variedad_mod == $variedad && $calibre_mod == "JUP" && $semana_mod == $semana)
                                        @if ($type_mod == "retorno")
                                          {{ $npk }} <br>
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
                                        @if ($informe_edit->modificaciones->where('categoria', 'MERCADO INTERNO')->where('variedad', $variedad)->where('calibre', 'JUP')->where('semana',$semana)->count() > 0)
                                          <p class="text-red-500 font-bold whitespace-nowrap">
                                            {{ number_format($informe_edit->modificaciones->where('categoria', 'MERCADO INTERNO')->where('variedad', $variedad)->where('calibre', 'JUP')->where('semana',$semana)->first()->npk, 2, ',', '.') }} USD/kg
                                          </p>
                                        @else
                                          @if ($pesonetojup_semana)
                                            <p class="whitespace-nowrap">
                                              {{ number_format(($retornojup_semana - ($margenjup_semana + $costosjup_semana)) / $pesonetojup_semana, 2, ',', '.') }} USD/kg
                                            </p>
                                          @else
                                            0 USD/kg
                                          @endif
                                        @endif
                                      @endif
                                  
                                      @if ($categoria_mod == "MERCADO INTERNO" && $variedad_mod == $variedad && $calibre_mod == "JUP" && $semana_mod == $semana && $type_mod == "npk")
                                        <button wire:click="saveOrUpdateModification" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                          <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                          <span class="relative">Guardar</span>
                                        </button>
                                      @else
                                        <span wire:click="set_modification('MERCADO INTERNO', '{{ $variedad }}', 'JUP','{{($retorno_netojup_semana)}}','{{($retorno_netojup_semana)/$pesonetojup_semana}}','{{$pesonetojup_semana}}','npk','{{$semana}}')" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                          <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full text-xs"></span>
                                          <span class="relative">Editar</span>
                                        </span>
                                      @endif
                                    </td>
                                  
                                    {{-- eliminar --}}
                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-center">
                                      @if ($informe_edit->modificaciones->where('categoria', 'MERCADO INTERNO')->where('variedad', $variedad)->where('calibre', 'JUP')->where('semana',$semana)->count() > 0)
                                        @php
                                          $mod = $informe_edit->modificaciones->where('categoria', 'MERCADO INTERNO')->where('variedad', $variedad)->where('calibre', 'JUP')->where('semana',$semana)->first();
                                        @endphp
                                        @if ($mod->retorno > $mod->retorno_inicial)
                                          <p class="text-green-500 font-bold"> +{{ $mod->retorno - $mod->retorno_inicial }} usd </p>
                                        @else
                                          <p class="text-red-500 font-bold"> {{ $mod->retorno - $mod->retorno_inicial }} usd </p>
                                        @endif
                                        <button title="Eliminar" class="cursorpointer text-xs text-red-500" wire:click="delete_modificacion('{{ $mod->id }}')">(Eliminar)</button>
                                      @endif
                                    </td>
                                  </tr>
                                
              
                                  @php
                                    $calibrecount += 1;
                                  @endphp
                                @endif
              
                              @endif
                              
                              @if ($pesonetojup_semana>0)
                                
                                <tr>
                                  <td></td>
                                  <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
                                  <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
                                  <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">Total {{ $semana }}:</td>
                                  <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
                                  <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
                                  <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; white-space: nowrap;">
                                    {{ number_format($pesonetojup_semana, 2, ',', '.') }} KGS
                                  </td>
                                  <td>
                                    {{ number_format($retornojup_semana, 2, ',', '.') }}
                                  </td>
                                  <td>
                                    {{ number_format($margenjup_semana, 2, ',', '.') }}
                                  </td>
                                  <td>
                                    {{ number_format($costosjup_semana, 2) }}
                                  </td>
                                  <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">
                                    {{ number_format($retorno_netojup_semana, 2, ',', '.') }} USD
                                  </td>
                                  <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">
                                    {{ number_format(
                                      ($retorno_netojup_semana)
                                      /
                                      ($pesonetojup_semana),
                                      2, ',', '.'
                                    ) }} USD/KG
                                  </td>
                                </tr>
                              
                              @endif 
                              @php
                                $variedadcount+=1;
                                $semanacounter+=1;
                              @endphp
                            @endif
                          @endforeach
              
                          @if ($pesonetojup>0)
                
                            <tr>
                              <td></td>
                              <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; text-align: center;">
                                Total {{$variedad}}:
                              </td>
                              
                              <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
                              <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
                              <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
                              <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
                              <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; white-space: nowrap;">{{number_format($pesonetojup,2,',','.')}} KGS</td>
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
                            @php
                                $totalcount+=($retorno_netojup);
                            @endphp
                          @endif
                
                        @endforeach
                      
                    @if ($pesonetototal>0)
                      <tr style="background-color: #ddd;">
                            
                        
                      
                          <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; white-space: nowrap;" colspan="4" >Total Mercado Interno</td>
                        
                        
                          <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
                      
                        
                        
                        <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"></td>
                        <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format($pesonetototal,1,',','.')}} KGS</td>
                        <td>{{number_format($totalretornojup,2)}} usd</td>
                        <td>{{number_format(($totalmargenjup),2)}} usd</td>
                      
                        <td>
                          {{number_format(($totalcostosjup),2)}}
                        </td>
                        
                        <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format($totalcount,2,',','.')}} USD 
                      
                        </td>
                        <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format($totalcount/$pesonetototal,2,',','.')}} usd/kg </td>
                        
                      </tr>
                    @endif
              
                    @php
                      $totalfueraodenorma=($totalcount);
                    @endphp
                      
              
                  </tbody>
                @else
                  <tbody>
                    <tr style="background-color: #ddd;">
                            
                        <td> MERCADO INTERNO</td>
                    
                    
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
                      
                      $totalretorno5j=0;
                      $totalretorno4j=0;
                        $totalretorno3j=0;
                        $totalretorno2j=0;
                        $totalretornoj=0;
                        $totalretornoxl=0;
                        $totalretornol=0;
                        $totalretornojup=0;
              
                        $totalmargen5j=0;
                        $totalmargen4j=0;
                        $totalmargen3j=0;
                        $totalmargen2j=0;
                        $totalmargenj=0;
                        $totalmargenxl=0;
                        $totalmargenl=0;
                        $totalmargenjup=0;
              
                        $totalcostopacking=0;
                        $globaltotalmateriales=0;
              
                        $totalpesonetol=0;
                        $totalpesonetojup=0;
              
                        $globaltotalotroscostos=0;
                        $totalcount=0;
              
                        $totalcostos5j=0;
                        $totalcostos4j=0;
                        $totalcostos3j=0;
                        $totalcostos2j=0;
                        $totalcostosj=0;
                        $totalcostosxl=0;
                        $totalcostosl=0;
                        $totalcostosjup=0;
                        
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
                        
                        
                        $cantidad5j=0;
                        $cantidad4j=0;
                        $cantidad3j=0;
                        $cantidad2j=0;
                        $cantidadj=0;
                        $cantidadxl=0;
                        $cantidadl=0;
                        $cantidadjup=0;
                        
                        $pesoneto5j=0;
                        $pesoneto4j=0;
                        $pesoneto3j=0;
                        $pesoneto2j=0;
                        $pesonetoj=0;
                        $pesonetoxl=0;
                        $pesonetol=0;
                        $pesonetojup=0;
              
                        
                        $retorno5j=0;
                        $retorno4j=0;
                        $retorno3j=0;
                        $retorno2j=0;
                        $retornoj=0;
                        $retornoxl=0;
                        $retornol=0;
                        $retornojup=0;
              
                        $retorno_neto5j=0;
                        $retorno_neto4j=0;
                        $retorno_neto3j=0;
                        $retorno_neto2j=0;
                        $retorno_netoj=0;
                        $retorno_netoxl=0;
                        $retorno_netol=0;
                        $retorno_netojup=0;
              
                        $margen5j=0;
                        $margen4j=0;
                        $margen3j=0;
                        $margen2j=0;
                        $margenj=0;
                        $margenxl=0;
                        $margenl=0;
                        $margenjup=0;
              
                        $costopacking=0;
              
                        $totalmateriales4j=0;
                        $totalmateriales3j=0;
                        $totalmateriales2j=0;
                        $totalmaterialesj=0;
                        $totalmaterialesxl=0;
                        $totalmaterialesl=0;
                        $totalmaterialesjup=0;
              
                        $costos5j=0;
                        $costos4j=0;
                        $costos3j=0;
                        $costos2j=0;
                        $costosj=0;
                        $costosxl=0;
                        $costosl=0;
                        $costosjup=0;
              
                        $otroscostos=0;
                        $totalotroscostos=0;
                        
                        
                        $masatotal=0;
              
                      @endphp
              
                      @foreach ($masas as $masa)
                        
                        @php      
                                  $tarifafinal=0;
                                  if (!IS_NULL($masa->fob)) {
                                              if ($masa->fob->tarifas->count()>0) {
                                                  $tarifafinal=$masa->fob->tarifas->reverse()->first()->tarifa_fc;
                                              }
                                  }
                                          
                        @endphp 
                                
                                @if (($masa->calibre_real=='JUP') && $masa->variedad==$variedad)
                                  @php
                                    $cantidadjup += $masa->cantidad;
                                    $pesonetojup += floatval($masa->peso_prorrateado);
                                
                                    $costosjup += floatval($masa->costo);
                                    $totalcostosjup += floatval($masa->costo);
                                
                                    if (!IS_NULL($masa->fob)) {
                                      $retornojup += floatval($masa->peso_prorrateado * $tarifafinal);
                                      $totalretornojup += floatval($masa->peso_prorrateado * $tarifafinal);
                                      //$margenjup += floatval($masa->peso_prorrateado * $tarifafinal * 0.08);
                                      //$totalmargenjup += floatval($masa->peso_prorrateado * $tarifafinal * 0.08);
                                    }
                                
                                    $cantidadtotal += $masa->cantidad;
                                  @endphp	
                                @endif
                              
              
                          
                          @if ( $masa->calibre_real=='JUP')
                                @php
                                      $masatotal+=$masa->peso_prorrateado;
                                @endphp
                          @endif
                        
                      @endforeach
                              @php
                                  $pesonetototal=$masatotal;
                              @endphp
                    
                          
                  
              
              
                      @if ($cantidadjup>0)
                        
                        
                        @if ($pesonetojup>0)
                          <tr>
                            <td> </td>
                            <td> </td>
                          
                            <td>JUP</td>
                            <td style="text-align:right; padding-right:30px; border-left: 1px solid #ddd; white-space: nowrap;" >{{number_format($pesonetojup,2,',','.')}} KGS</td>
                            <td>{{number_format(($retornojup),2,',','.')}}
                            <td>{{number_format(($margenjup),2,',','.')}}
                            </td>
                            <td>
                              {{number_format($costosjup,2)}}
                            </td>
                          
                            <td>
                              @if ($categoria_mod == "MERCADO INTERNO" && $variedad_mod == $variedad && $calibre_mod == "JUP" && $semana_mod == "no")
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
                                @php
                                    $retorno_netojup = ($retorno);
                                @endphp
                              @else
                                @if ($informe_edit->modificaciones->where('categoria','MERCADO INTERNO')->where('variedad',$variedad)->where('calibre','JUP')->where('semana','no')->count() > 0)
                                  <p class="text-red-500 font-bold whitespace-nowrap">
                                    {{number_format($informe_edit->modificaciones->where('categoria','MERCADO INTERNO')->where('variedad',$variedad)->where('calibre','JUP')->where('semana','no')->first()->retorno, 2, ',', '.') }} USD
                                  </p>
                                  @php
                                      $retorno_netojup = $informe_edit->modificaciones->where('categoria','MERCADO INTERNO')->where('variedad',$variedad)->where('calibre','JUP')->where('semana','no')->first()->retorno;
                                  @endphp
                                @else
                                  {{ number_format(($retornojup - ($margenjup + $costosjup)), 2, ',', '.') }} USD <br>
                                  @php
                                      $retorno_netojup = ($retornojup - ($margenjup + $costosjup));
                                  @endphp
                                @endif
                              @endif
                          
                              @if ($categoria_mod=="MERCADO INTERNO" && $variedad_mod==$variedad && $calibre_mod=="JUP" && $type_mod=="retorno" && $semana_mod == "no")
                                <button wire:click="saveOrUpdateModification" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                  <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                  <span class="relative">Guardar</span>
                                </button>
                              @else
                                <span wire:click="set_modification('MERCADO INTERNO', '{{ $variedad }}', 'JUP','{{($retorno_netojup)}}','{{($retorno_netojup)/$pesonetojup}}','{{$pesonetojup}}','retorno','no')" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                  <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full text-xs"></span>
                                  <span class="relative">Editar</span>
                                </span>
                              @endif
                            </td>
                            <td>
                              @if ($categoria_mod == "MERCADO INTERNO" && $variedad_mod == $variedad && $calibre_mod == "JUP" && $semana_mod == "no")
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
                                @if ($informe_edit->modificaciones->where('categoria','MERCADO INTERNO')->where('variedad',$variedad)->where('calibre','JUP')->where('semana','no')->count() > 0)
                                  <p class="text-red-500 font-bold whitespace-nowrap">
                                    {{number_format($informe_edit->modificaciones->where('categoria','MERCADO INTERNO')->where('variedad',$variedad)->where('calibre','JUP')->where('semana','no')->first()->npk, 2, ',', '.') }} USD/kg
                                  </p>
                                @else
                                  @if ($pesonetojup)
                                      <p class="whitespace-nowrap">
                                        {{ number_format(($retornojup - ($margenjup + $costosjup)) / $pesonetojup, 2, ',', '.') }} USD/kg
                                      </p>
                                  @else
                                      0 USD/kg
                                  @endif
                                @endif
                              @endif
                          
                              @if ($categoria_mod=="MERCADO INTERNO" && $variedad_mod==$variedad && $calibre_mod=="JUP" && $type_mod=="npk" && $semana_mod=="no")
                                <button wire:click="saveOrUpdateModification" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                  <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                  <span class="relative">Guardar</span>
                                </button>
                              @else
                                <span wire:click="set_modification('MERCADO INTERNO', '{{ $variedad }}', 'JUP','{{($retorno_netojup)}}','{{($retorno_netojup)/$pesonetojup}}','{{$pesonetojup}}','npk','no')" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                  <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full text-xs"></span>
                                  <span class="relative">Editar</span>
                                </span>
                              @endif
                            </td>
                            <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-center">
                              @if ($informe_edit->modificaciones->where('categoria', 'MERCADO INTERNO')->where('variedad', $variedad)->where('calibre', 'JUP')->where('semana','no')->count() > 0)
                                @php
                                  $mod = $informe_edit->modificaciones->where('categoria', 'MERCADO INTERNO')->where('variedad', $variedad)->where('calibre', 'JUP')->where('semana','no')->first();
                                @endphp
                                @if ($mod->retorno > $mod->retorno_inicial)
                                  <p class="text-green-500 font-bold"> +{{ $mod->retorno - $mod->retorno_inicial }} usd </p>
                                @else
                                  <p class="text-red-500 font-bold"> {{ $mod->retorno - $mod->retorno_inicial }} usd </p>
                                @endif
                                <button title="Eliminar" class="cursorpointer text-xs text-red-500" wire:click="delete_modificacion('{{ $mod->id }}')">(Eliminar)</button>
                              @endif
                            </td>
                          </tr>
                        
                          @php
                            $calibrecount+=1;
                          @endphp
                        @endif
              
                      @endif
                      
                      @if ($pesonetojup>0)
                        
                        <tr>
                          <td></td>
                          <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">Total {{$variedad}}</td>
                          <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
                          <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; ">{{number_format($pesonetojup,2,',','.')}} KGS</td>
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
                          $totalcount+=($retorno_netojup);
                          $variedadcount+=1;
                        @endphp
                      
              
                    @endforeach
                  
                    @if ($pesonetototal>0)
                      <tr style="background-color: #ddd;">
                            
                        
                      
                          <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; white-space: nowrap; ">Total Mercado Interno</td>
                        
                        
                          <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
                      
                        
                        
                        <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"></td>
                        <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format($pesonetototal,1,',','.')}} KGS</td>
                        <td>{{number_format($totalretornojup,2)}} usd</td>
                        <td>{{number_format(($totalmargenjup),2)}} usd</td>
                      
                        <td>
                          {{number_format(($totalcostosjup),2)}}
                        </td>
                        
                        <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format($totalcount,2,',','.')}} USD 
                      
                        </td>
                        <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format($totalcount/$pesonetototal,2,',','.')}} usd/kg </td>
                        
                      </tr>
                    @endif
              
                    @php
                      $totalfueraodenorma=($totalcount);
                    @endphp
                      
              
                  </tbody>
                @endif
              </table>
           
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