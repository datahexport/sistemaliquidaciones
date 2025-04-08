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
                        @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "L" && $semana_mod == $semana)
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
                          @if ($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','L')->where('semana',$semana)->count() > 0)
                            <p class="text-red-500 font-bold whitespace-nowrap">
                              {{ number_format($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','L')->where('semana',$semana)->first()->retorno, 2, ',', '.') }} USD
                            </p>
                            @php
                              $retorno_netol_semana = $informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','L')->where('semana',$semana)->first()->retorno;
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
                        @if ($categoria_mod=="DENTRO DE NORMA" && $variedad_mod==$variedad && $calibre_mod=="L" && $semana_mod == $semana && $type_mod=="retorno")
                          <button wire:click="saveOrUpdateModification" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                            <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                            <span class="relative">Guardar</span>
                          </button>
                        @else
                          <span wire:click="set_modification('DENTRO DE NORMA', '{{ $variedad }}', 'L','{{($retorno_netol_semana)}}','{{($retorno_netol_semana)/$pesonetol_semana}}','{{$pesonetol_semana}}','retorno',{{$semana}})" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                            <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full text-xs"></span>
                            <span class="relative">Editar</span>
                          </span>
                        @endif
                      </td>

                      {{-- retorno --}}
                      <td>
                        @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "L" && $semana_mod == $semana)
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
                          @if ($informe_edit->modificaciones->where('categoria', 'DENTRO DE NORMA')->where('variedad', $variedad)->where('calibre', 'L')->where('semana',$semana)->count() > 0)
                            <p class="text-red-500 font-bold whitespace-nowrap">
                              {{ number_format($informe_edit->modificaciones->where('categoria', 'DENTRO DE NORMA')->where('variedad', $variedad)->where('calibre', 'L')->where('semana',$semana)->first()->npk, 2, ',', '.') }} USD/kg
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

                        @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "L" && $semana_mod == $semana && $type_mod == "npk")
                          <button wire:click="saveOrUpdateModification" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                            <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                            <span class="relative">Guardar</span>
                          </button>
                        @else
                          <span wire:click="set_modification('DENTRO DE NORMA', '{{ $variedad }}', 'L','{{($retorno_netol_semana)}}','{{($retorno_netol_semana)/$pesonetol_semana}}','{{$pesonetol_semana}}','npk','{{$semana}}')" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                            <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full text-xs"></span>
                            <span class="relative">Editar</span>
                          </span>
                        @endif
                      </td>

                      {{-- eliminar --}}
                      <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-center">
                        @if ($informe_edit->modificaciones->where('categoria', 'DENTRO DE NORMA')->where('variedad', $variedad)->where('calibre', 'L')->where('semana',$semana)->count() > 0)
                          @php
                            $mod = $informe_edit->modificaciones->where('categoria', 'DENTRO DE NORMA')->where('variedad', $variedad)->where('calibre', 'L')->where('semana',$semana)->first();
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
              
          
        
            <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;" colspan="4" >Total Fuera de Norma</td>
          
          
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
        $totaldentrodenorma=($totalcount);
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
                @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "L" && $semana_mod == "no")
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
                  @if ($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','L')->where('semana','no')->count()>0)
                    <p class="text-red-500 font-bold whitespace-nowrap">
                      {{number_format($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','L')->where('semana','no')->first()->retorno, 2, ',', '.') }} USD
                    </p>
                    @php
                        $retorno_netol=$informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','L')->where('semana','no')->first()->retorno;
                    @endphp
                  @else
                    {{ number_format(($retornol - ($margenl + $costosl)), 2, ',', '.') }} USD <br>
                    @php
                        $retorno_netol=($retornol - ($margenl + $costosl));
                    @endphp
                  @endif
                @endif

                @if ($categoria_mod=="DENTRO DE NORMA" && $variedad_mod==$variedad && $calibre_mod=="L" && $type_mod=="retorno" && $semana_mod == "no")
                  <button wire:click="saveOrUpdateModification" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                    <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                    <span class="relative">Guardar</span>
                  </button>
                @else
                  <span wire:click="set_modification('DENTRO DE NORMA', '{{ $variedad }}', 'L','{{($retorno_netol)}}','{{($retorno_netol)/$pesonetol}}','{{$pesonetol}}','retorno','no')" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                    <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full text-xs"></span>
                    <span class="relative">Editar</span>
                  </span>
                @endif
              </td>
              <td>
                @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "L" && $semana_mod == "no")
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
                  @if ($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','L')->where('semana','no')->count()>0)
                    <p class="text-red-500 font-bold whitespace-nowrap">
                      {{number_format($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','L')->where('semana','no')->first()->npk, 2, ',', '.') }} USD/kg
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

                @if ($categoria_mod=="DENTRO DE NORMA" && $variedad_mod==$variedad && $calibre_mod=="L" && $type_mod=="npk" && $semana_mod=="no")
                  <button wire:click="saveOrUpdateModification" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                    <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                    <span class="relative">Guardar</span>
                  </button>
                @else
                  <span wire:click="set_modification('DENTRO DE NORMA', '{{ $variedad }}', 'L','{{($retorno_netol)}}','{{($retorno_netol)/$pesonetol}}','{{$pesonetol}}','npk','no')" class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                    <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full text-xs"></span>
                    <span class="relative">Editar</span>
                  </span>
                @endif
              </td>
              <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm text-center">
                @if ($informe_edit->modificaciones->where('categoria', 'DENTRO DE NORMA')->where('variedad', $variedad)->where('calibre', 'L')->where('semana','no')->count() > 0)
                  @php
                    $mod = $informe_edit->modificaciones->where('categoria', 'DENTRO DE NORMA')->where('variedad', $variedad)->where('calibre', 'L')->where('semana','no')->first();
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
              
          
        
            <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">Total Fuera de Norma</td>
          
          
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
        $totaldentrodenorma=($totalcount);
      @endphp
        

    </tbody>
  @endif
</table>