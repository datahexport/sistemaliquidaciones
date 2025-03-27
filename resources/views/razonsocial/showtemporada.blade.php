<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lista de Filtros') }}
        </h2>
    </x-slot>
    
    <div class=" pb-8 pt-2">
    
      <div class="card">
        <div class="px-2 md:px-6 py-4">
        

          <h1 class="text-2xl font-bold">Temporada {{$temporada->name}}</h1>
          <hr class="mt-2 mb-6">
          <div class="flex w-full bg-gray-300" x-data="{openMenu:2}" >
              
              @livewire('menu-aside',['temporada'=>$temporada->id])

              <div class="pb-12 pt-6 w-full">
                  <div class="mx-auto sm:px-6 lg:px-8">
                      <div class="flex justify-between mb-6">
                        <div class="items-center"> 
                          <h2 @click.on="openMenu = 1"  class="cursor-pointer text-xs text-blue-500 font-semibold mb-4"><-Abrir Menu</h2>
                        </div>

                        <a href="{{route('exportpdff',['razonsocial'=>$razonsocial,'temporada'=>$temporada])}}" target="_blank">
                          <x-button>
                            Generar
                          </x-button>
                        </a>
                  
                      </div>

           

                      <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                          <div class="flex flex-col">
                              <div class="overflow-x-auto sm:mx-0.5 lg:mx-0.5">
                                <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                                  <div class="overflow-hidden">
                                    <table class="min-w-full">
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
                                        </tr>
                                      </thead>
                                      <tbody>
                                              <tr class="bg-gray-100 border-b">
                                                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{$razonsocial->id}}</td>
                                                  <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                  {{$razonsocial->name}}
                                                  </td>
                                                  <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                  {{$razonsocial->rut}}
                                                  </td>
                                                  <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                                  {{$razonsocial->csg}}
                                                  </td>
                                              </tr>
                                        
                                      </tbody>
                                    </table>
                                  </div>
                                </div>
                              </div>
                          </div>

                          

                          <div class="flex flex-col">
                            <div class="overflow-x-auto sm:mx-0.5 lg:mx-0.5">
                              <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                             
                                <h1 class="mt-6">
                                  Gastos Frio Packing
                                </h1>
                                <table class="min-w-full leading-normal mt-4">
                                  <thead>
                                    <tr>
                                      <th
                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
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
                                    @php
                                        $totalpack=0;
                                    @endphp
                                    
                                      @foreach ($packings as $packing)
                                          <tr>
                                          
                                            <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                              <p class="text-gray-900 whitespace-no-wrap"> {{$packing->variedad}}</p>
                                            </td>
                                            <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                              <div class="flex items-center">
                                              
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

                                          @php
                                              $totalpack+=$packing->total_usd;
                                          @endphp
                                      @endforeach
                                      <tr>
                                          
                                        <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                          <p class="text-gray-900 whitespace-no-wrap">TOTAL</p>
                                        </td>
                                        <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                        
                                        </td>
                                        <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                        </td>
                                        <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                        
                                        </td>
                                        <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                          <p class="text-gray-900 whitespace-no-wrap">
                                          
                                            {{number_format($totalpack,2)}}
                                          </p>
                                        </td>
            
                                        <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                         
                                        </td>
                                      </tr>
                                  
                                  </tbody>
                                </table>

                                <h1 class="mt-6">
                                  Otros Gastos
                                </h1>
                                <table class="min-w-full leading-normal mt-4">
                                  <thead>
                                    <tr>
                                      <th
                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
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
                                    @php
                                        $totalgastos=0;
                                    @endphp
                                    
                                    
                                      @foreach ($gastos as $gasto)
                                      @if ($gasto->familia->name=='Costos' && $gasto->item=='Otros costos')
                                        @foreach ($detalles as $detalle)
                                          @if (preg_replace('/[\.\-\s]+/', '', strtolower($detalle->item))==preg_replace('/[\.\-\s]+/', '', strtolower($gasto->item)))

                                          <tr>
                                          
                                              <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                                <p class="text-gray-900 whitespace-no-wrap"> {{$detalle->variedad}}</p>
                                              </td>
                                              <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                                <div class="flex items-center">
                                                
                                                    <div class="ml-3">
                                                      <p class="text-gray-900 whitespace-no-wrap">
                                                        {{$detalle->n_productor}}
                                                      </p>
                                                    </div>
                                                  </div>
                                              </td>
                                              <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                                <p class="text-gray-900 whitespace-no-wrap"> {{$detalle->csg}}</p>
                                              </td>
                                              <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                                <p class="text-gray-900 whitespace-no-wrap">
                                                  {{$detalle->kg}}
                                                </p>
                                              </td>
                                              <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                                <p class="text-gray-900 whitespace-no-wrap">
                                                
                                                  {{number_format($detalle->cantidad,2)}}
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

                                            @php
                                              $totalgastos+=abs(floatval($detalle->cantidad));
                                            @endphp
                                            
                                          @endif
                                        @endforeach
                                       
                                      @endif
                                

                                      
                                      @endforeach
                                      <tr>
                                          
                                        <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                          <p class="text-gray-900 whitespace-no-wrap">TOTAL</p>
                                        </td>
                                        <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                        
                                        </td>
                                        <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                        </td>
                                        <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                        
                                        </td>
                                        <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                          <p class="text-gray-900 whitespace-no-wrap">
                                          
                                            {{number_format($totalgastos,2)}}
                                          </p>
                                        </td>
            
                                        <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                         
                                        </td>
                                      </tr>
                                  
                                  </tbody>
                                </table>

                               

                                  
                                  
                                  <h1 class="mt-6">
                                    Fruta dentro de norma
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
                                      <th>Costo</th>
                                     
                                      <th>Retorno Neto Productor</th>
                                      
                                      <th>NPK</th>
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
                              
                                        @foreach ($masas as $masa)
                                          
                              
                                            @if (($masa->calibre_real=='4J') && $masa->variedad==$variedad)
                                                @php
                                                  $cantidad4j+=floatval($masa->cantidad);
                                                  $pesoneto4j+=floatval($masa->peso_prorrateado);
                                                  $margen4j+=floatval($masa->margen);
                                                  $totalmargen4j+=floatval($masa->margen);

                                                  $costos4j+=floatval($masa->costo);
                                                  $totalcostos4j+=floatval($masa->costo);
                                                  
                                                  if (!IS_NULL($masa->fob)) {
                                                      $retorno4j+=floatval($masa->fob);
                                                      $totalretorno4j+=floatval($masa->fob);
                                                    }
                                                  $cantidadtotal+=floatval($masa->cantidad);
                                                  $pesonetototal+=floatval($masa->peso_prorrateado);
                                                
                                                  foreach ($materialestotal as $material) {
                                                      if ($material->c_embalaje==$masa->cod_embalaje) {
                                                        $totalmateriales4j+=$masa->peso_prorrateado*$material->tarifa_kg;
                                                        $globaltotalmateriales+=$masa->peso_prorrateado*$material->tarifa_kg;
                                                      }  
                                                    }
                                          
                                                @endphp	
                                            @endif
                                            @if (($masa->calibre_real=='3J') && $masa->variedad==$variedad)
                                                @php
                                                  $cantidad3j+=$masa->cantidad;
                                                  $pesoneto3j+=floatval($masa->peso_prorrateado);
                                                  $margen3j+=floatval($masa->margen);
                                                  $totalmargen3j+=floatval($masa->margen);

                                                  $costos3j+=floatval($masa->costo);
                                                  $totalcostos3j+=floatval($masa->costo);

                                                  if (!IS_NULL($masa->fob)) {
                                                                      $retorno3j+=floatval($masa->fob);
                                                                      $totalretorno3j+=floatval($masa->fob);
                                                                    }
                                                  $cantidadtotal+=$masa->cantidad;
                                                  $pesonetototal+=floatval($masa->peso_prorrateado);
                                                  foreach ($materialestotal as $material) {
                                                      if ($material->c_embalaje==$masa->cod_embalaje) {
                                                        $totalmateriales3j+=$masa->peso_prorrateado*$material->tarifa_kg;
                                                        $globaltotalmateriales+=$masa->peso_prorrateado*$material->tarifa_kg;
                                                      }  
                                                    }
                                                @endphp	
                                            @endif
                                            @if (($masa->calibre_real=='2J') && $masa->variedad==$variedad)
                                                @php
                                                  $cantidad2j+=$masa->cantidad;
                                                  $pesoneto2j+=floatval($masa->peso_prorrateado);
                                                  $margen2j+=floatval($masa->margen);
                                                  $totalmargen2j+=floatval($masa->margen);

                                                  $costos2j+=floatval($masa->costo);
                                                  $totalcostos2j+=floatval($masa->costo);

                                                  if (!IS_NULL($masa->fob)) {
                                                                      $retorno2j+=floatval($masa->fob);
                                                                      $totalretorno2j+=floatval($masa->fob);
                                                                    }
                                                  $cantidadtotal+=$masa->cantidad;
                                                  $pesonetototal+=floatval($masa->peso_prorrateado);
                                                  foreach ($materialestotal as $material) {
                                                      if ($material->c_embalaje==$masa->cod_embalaje) {
                                                        $totalmateriales2j+=$masa->peso_prorrateado*$material->tarifa_kg;
                                                        $globaltotalmateriales+=$masa->peso_prorrateado*$material->tarifa_kg;
                                                      }  
                                                    }
                                                @endphp	
                                            @endif
                                            @if (($masa->calibre_real=='J') && $masa->variedad==$variedad)
                                                @php
                                                  $cantidadj+=$masa->cantidad;
                                                    $pesonetoj+=floatval($masa->peso_prorrateado);
                                                    $margenj+=floatval($masa->margen);
                                                    $totalmargenj+=floatval($masa->margen);

                                                    $costosj+=floatval($masa->costo);
                                                    $totalcostosj+=floatval($masa->costo);

                                                    if (!IS_NULL($masa->fob)) {
                                                      $retornoj+=floatval($masa->fob);
                                                      $totalretornoj+=floatval($masa->fob);
                                                    }
                                                    $cantidadtotal+=$masa->cantidad;
                                                    $pesonetototal+=floatval($masa->peso_prorrateado);
                                                    foreach ($materialestotal as $material) {
                                                      if ($material->c_embalaje==$masa->cod_embalaje) {
                                                        $totalmaterialesj+=$masa->peso_prorrateado*$material->tarifa_kg;
                                                        $globaltotalmateriales+=$masa->peso_prorrateado*$material->tarifa_kg;
                                                      }  
                                                    }
                                                @endphp	
                                            @endif
                                            @if (($masa->calibre_real=='XL') && $masa->variedad==$variedad)
                                                @php
                                                  $cantidadxl+=$masa->cantidad;
                                                  $pesonetoxl+=floatval($masa->peso_prorrateado);
                                                  $margenxl+=floatval($masa->margen);
                                                  $totalmargenxl+=floatval($masa->margen);
                                                  $costosxl+=floatval($masa->costo);
                                                  $totalcostosxl+=floatval($masa->costo);

                                                  if (!IS_NULL($masa->fob)) {
                                                                      $retornoxl+=floatval($masa->fob);
                                                                      $totalretornoxl+=floatval($masa->fob);
                                                                    }
                                                  $cantidadtotal+=$masa->cantidad;
                                                  $pesonetototal+=floatval($masa->peso_prorrateado);
                                                  foreach ($materialestotal as $material) {
                                                      if ($material->c_embalaje==$masa->cod_embalaje) {
                                                        $totalmaterialesxl+=$masa->peso_prorrateado*$material->tarifa_kg;
                                                        $globaltotalmateriales+=$masa->peso_prorrateado*$material->tarifa_kg;
                                                      }  
                                                    }
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
                              
                                        @php
                                          foreach ($packings as $costo) {
                                                          if ($costo->variedad==$variedad) {
                                                            $costopacking+=$costo->total_usd;
                                                            $totalcostopacking+=($costopacking)*(($pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl)/($pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl+$pesonetol));
                                                          }  
                                                        }
                                        @endphp
                              
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
                                          $totalotroscostos+=($otroscostos)*(($pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl)/($masatotal));
                                          $globaltotalotroscostos+=$totalotroscostos;
                                        @endphp
                              
                                        @if ($cantidad4j+$cantidad3j+$cantidad2j+$cantidadj+$cantidadxl>0)
                                          
                                          @if ($pesoneto4j>0)
                                            <tr>
                                              <td> </td>
                                              <td> </td>
                                              
                                              
                                              
                                              
                                              <td>4J</td>
                                              <td style="text-align:right; padding-right:30px;border-left: 1px solid #ddd;" >{{number_format($pesoneto4j,0,',','.')}} KGS</td>
                                              <td>{{number_format(($retorno4j),2,',','.')}}
                                              <td>{{number_format(($margen4j),2,',','.')}}
                                              </td>
                                             
                                              <td>
                                                {{number_format($costos4j,2)}}
                                              </td>
                                              <td>{{number_format(($retorno4j+$margen4j+$costos4j),2,',','.')}} USD  
                                              </td>
                                              
                                              <td>
                                                @if ($pesoneto4j)
                                                  {{number_format(($retorno4j+$margen4j+$costos4j)/$pesoneto4j,2,',','.')}} USD/kg
                                                @else
                                                  0 USD/kg
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
                                              <td style="text-align:right; padding-right:30px;border-left: 1px solid #ddd;" >{{number_format($pesoneto3j,0,',','.')}} KGS</td>
                                              <td>{{number_format(($retorno3j),2,',','.')}}
                                              <td>{{number_format(($margen3j),2,',','.')}}
                                              </td>
                                              <td>
                                                {{number_format($costos3j,2)}}
                                              </td>
                                              <td>{{number_format(($retorno3j+$margen3j+$costos3j),2,',','.')}} USD  
                                              <td>
                                                @if ($pesoneto3j)
                                                  {{number_format(($retorno3j+$margen3j+$costos3j)/$pesoneto3j,2,',','.')}} USD/kg
                                                @else
                                                  0 USD/kg
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
                                              <td style="text-align:right; padding-right:30px;border-left: 1px solid #ddd;" >{{number_format($pesoneto2j,0,',','.')}} KGS</td>
                                              <td>{{number_format(($retorno2j),2,',','.')}}
                                              <td>{{number_format(($margen2j),2,',','.')}}
                                              </td>
                                              <td>
                                                {{number_format($costos2j,2)}}
                                              </td>
                                              <td>{{number_format(($retorno2j+$margen2j+$costos2j),2,',','.')}} USD  
                                             
                                              <td>
                                                @if ($pesoneto2j)
                                                  {{number_format(($retorno2j+$margen2j+$costos2j)/$pesoneto2j,2,',','.')}} USD/kg
                                                @else
                                                  0 USD/kg
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
                                              <td style="text-align:right; padding-right:30px; border-left: 1px solid #ddd;" >{{number_format($pesonetoj,0,',','.')}} KGS</td>
                                              <td>{{number_format(($retornoj),2,',','.')}}
                                              <td>{{number_format(($margenj),2,',','.')}}
                                              </td>
                                              <td>
                                                {{number_format($costosj,2)}}
                                              </td>
                                              <td>{{number_format(($retornoj+$margenj+$costosj),2,',','.')}} USD  
                                            
                                              <td>
                                                @if ($pesonetoj)
                                                  {{number_format(($retornoj+$margenj+$costosj)/$pesonetoj,2,',','.')}} USD/kg
                                                @else
                                                  0 USD/kg
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
                                              <td style="text-align:right; padding-right:30px; border-left: 1px solid #ddd; " >{{number_format($pesonetoxl,0,',','.')}} KGS</td>
                                              <td>{{number_format(($retornoxl),2,',','.')}}
                                              <td>{{number_format(($margenxl),2,',','.')}}
                                              </td>
                                              <td>
                                                {{number_format($costosxl,2)}}
                                              </td>
                                              <td>{{number_format(($retornoxl+$margenxl+$costosxl),2,',','.')}} USD  
                                             
                                                <td>
                                                @if ($pesonetoxl)
                                                  {{number_format(($retornoxl+$margenxl+$costosxl)/$pesonetoxl,2,',','.')}} USD/kg
                                                @else
                                                  0 USD/kg
                                                @endif
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
                                            <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; ">{{number_format($pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl,0,',','.')}} KGS</td>
                                            <td>
                                              {{number_format($retorno4j+$retorno3j+$retorno2j+$retornoj+$retornoxl,2,',','.')}}
                                            </td>
                                            <td>
                                              {{number_format(($margen4j+$margen3j+$margen2j+$margenj+$margenxl),2,',','.')}}
                                            </td>
                                          
                                            <td>
                                              {{number_format($costos4j+$costos3j+$costos2j+$costosj+$costosxl,2)}}
                                            </td>
                                            <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format(($retorno4j+$retorno3j+$retorno2j+$retornoj+$retornoxl+$margen4j+$margen3j+$margen2j+$margenj+$margenxl+$costos4j+$costos3j+$costos2j+$costosj+$costosxl),2,',','.')}} USD 
                                            
                                            
                                          </td>
                                            <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format(($retorno4j+$retorno3j+$retorno2j+$retornoj+$retornoxl+$margen4j+$margen3j+$margen2j+$margenj+$margenxl+$costos4j+$costos3j+$costos2j+$costosj+$costosxl)/($pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl),2,',','.')}} USD/KG</td>
                                            
                                          </tr>
                                        @endif
                                          @php
                                            $totalcount+=($retorno4j+$retorno3j+$retorno2j+$retornoj+$retornoxl+$margen4j+$margen3j+$margen2j+$margenj+$margenxl+$costos4j+$costos3j+$costos2j+$costosj+$costosxl);
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
                                            {{number_format(($totalcostos4j+$totalcostos3j+$totalcostos2j+$totalmargenj+$totalcostosxl),2)}}
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

                                                $margenl+=floatval($masa->margen);
                                                $totalmargenl+=floatval($masa->margen);

                                                $costosl+=floatval($masa->costo);
                                                $totalcostosl+=floatval($masa->costo);

                                                if (!IS_NULL($masa->fob)) {
                                                  $retornol+=floatval($masa->fob);
                                                  $totalretornol+=floatval($masa->fob);
                                                }
                                                $cantidadtotal+=$masa->cantidad;
                                                $pesonetototal+=floatval($masa->peso_prorrateado);
                                                foreach ($materialestotal as $material) {
                                                      if ($material->c_embalaje==$masa->cod_embalaje) {
                                                        $totalmaterialesl+=$masa->peso_prorrateado*$material->tarifa_kg;
                                                        $globaltotalmateriales+=$masa->peso_prorrateado*$material->tarifa_kg;
                                                      }  
                                                    }
                              
                                              @endphp	
                                            @endif

                                            @if ($masa->calibre_real=='4J' || $masa->calibre_real=='3J'|| $masa->calibre_real=='2J' || $masa->calibre_real=='J' || $masa->calibre_real=='XL' || $masa->calibre_real=='L')
                                                  @php
                                                        $masatotal+=$masa->peso_prorrateado;
                                                  @endphp
                                            @endif
                                          
                                       
                                         

                                        @endforeach
                              
                                        @php
                                          foreach ($packings as $costo) {
                                                          if ($costo->variedad==$variedad) {
                                                            $costopacking+=$costo->total_usd;
                                                            $totalcostopacking+=($costopacking)*(($pesonetol)/($pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl+$pesonetol));
                                                          }  
                                                        }
                                        @endphp
                              
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
                                            <td>{{number_format($retornol+$margenl+$costosl,2,',','.')}} USD
                                            </td>
                                          
                                              <td>
                                              @if ($pesonetol)
                                                {{number_format(($retornol+$margenl+$costosl)/$pesonetol,2,',','.')}} USD/kg
                                              @else
                                                0 USD/kg
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
                                            <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format(($retornol+$margenl+$costosl),2,',','.')}} USD 
                                            
                                            
                                          </td>
                                            <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format(($retornol+$margenl+$costosl)/($pesonetol),2,',','.')}} USD/KG</td>
                                            
                                          </tr>
                                        @endif
                                          @php
                                            $totalfr+=(($retornol+$margenl+$costosl));
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

                                  
                               

                                  

                                </div>
                              </div>
                            </div>
                      </div>
                  </div>
              </div>
          </div>

        </div>

      </div>
    </div>
    
</x-app-layout>
