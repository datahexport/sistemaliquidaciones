<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lista de Filtros') }}
        </h2>
    </x-slot>
    
    <div class="container pb-8 pt-2">
    
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
                                      @endforeach
                                  
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
                                      <th>Costo Packing</th>
                                      <th>Otros Costos</th>
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
                                          $totalcostopacking=0;
                                          $globaltotalmateriales=0;

                                          $totalpesonetol=0;
                              
                                          $totalotroscostos=0;
                                          
                                      @endphp
                                      @foreach ($unique_variedades as $variedad)
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
                              
                                          $costopacking=0;
                              
                                          $totalmateriales4j=0;
                                          $totalmateriales3j=0;
                                          $totalmateriales2j=0;
                                          $totalmaterialesj=0;
                                          $totalmaterialesxl=0;
                              
                                          $otroscostos=0;
                                          
                              
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
                                                  if (!IS_NULL($masa->precio_fob)) {
                                                                      $retorno3j+=floatval($masa->peso_prorrateado)*floatval($masa->precio_fob);
                                                                      $totalretorno3j+=floatval($masa->peso_prorrateado)*floatval($masa->precio_fob);
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
                                                  if (!IS_NULL($masa->precio_fob)) {
                                                                      $retorno2j+=floatval($masa->peso_prorrateado)*floatval($masa->precio_fob);
                                                                      $totalretorno2j+=floatval($masa->peso_prorrateado)*floatval($masa->precio_fob);
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
                                                    if (!IS_NULL($masa->precio_fob)) {
                                                    $retornoj+=floatval($masa->peso_prorrateado)*floatval($masa->precio_fob);
                                                    $totalretornoj+=floatval($masa->peso_prorrateado)*floatval($masa->precio_fob);
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
                                                  if (!IS_NULL($masa->precio_fob)) {
                                                                      $retornoxl+=floatval($masa->peso_prorrateado)*floatval($masa->precio_fob);
                                                                      $totalretornoxl+=floatval($masa->peso_prorrateado)*floatval($masa->precio_fob);
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
                                                    $otroscostos+=floatval($detalle->cantidad);
                                                    
                                                  @endphp
                                                  
                                                @endif
                                              @endforeach
                                              
                                            @endif
                                        @endforeach
                              
                                        @if ($cantidad4j+$cantidad3j+$cantidad2j+$cantidadj+$cantidadxl>0)
                                          
                                          @if ($pesoneto4j>0)
                                            <tr>
                                              <td> </td>
                                              @if ($calibrecount==1)
                                                <td>{{$variedad}}</td>
                                              @else
                                                <td> </td>
                                              @endif
                                              
                                              
                                              
                                              
                                              <td>4J</td>
                                              <td style="text-align:right; padding-right:30px;border-left: 1px solid #ddd;" >{{number_format($pesoneto4j,0,',','.')}} KGS</td>
                                              <td>{{number_format(($retorno4j),2,',','.')}}
                                              <td>{{number_format(($retorno4j*0.08),2,',','.')}}
                                              </td>
                                              <td>
                                                {{number_format(($costopacking)*($pesoneto4j/($pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl+$pesonetol)),2)}}
                                              </td>
                                              <td>
                                                {{number_format(($otroscostos)*($pesoneto4j/($pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl+$pesonetol)),2)}}
                                              </td>
                                              <td>{{number_format(($retorno4j*0.92-(($costopacking+$otroscostos)*($pesoneto4j/($pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl+$pesonetol))+$totalmateriales4j)),2,',','.')}} USD  
                                              </td>
                                              
                                              <td>
                                                @if ($pesoneto4j)
                                                  {{number_format(($retorno4j*0.92-(($costopacking+$otroscostos)*($pesoneto4j/($pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl+$pesonetol))+$totalmateriales4j))/$pesoneto4j,2,',','.')}} USD/kg
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
                                              @if ($calibrecount==1)
                                                <td>{{$variedad}}</td>
                                              @else
                                                <td> </td>
                                              @endif
                                            
                                              
                                              
                                              <td>3J</td>
                                              <td style="text-align:right; padding-right:30px;border-left: 1px solid #ddd;" >{{number_format($pesoneto3j,0,',','.')}} KGS</td>
                                              <td>{{number_format(($retorno3j),2,',','.')}}
                                              <td>{{number_format(($retorno3j*0.08),2,',','.')}}
                                              </td>
                                              <td>
                                                {{number_format(($costopacking)*($pesoneto3j/($pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl+$pesonetol)),2)}}
                                              </td>
                                              <td>
                                                {{number_format(($otroscostos)*($pesoneto3j/($pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl+$pesonetol)),2)}}
                                              </td>
                                              <td>{{number_format(($retorno3j*0.92-(($costopacking+$otroscostos)*($pesoneto3j/($pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl+$pesonetol))+$totalmateriales3j)),2,',','.')}} USD
                                              </td>
                                             
                                              <td>
                                                @if ($pesoneto3j)
                                                  {{number_format(($retorno3j*0.92-(($costopacking+$otroscostos)*($pesoneto3j/($pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl+$pesonetol))+$totalmateriales3j))/$pesoneto3j,2,',','.')}} USD/kg
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
                                              @if ($calibrecount==1)
                                                <td>{{$variedad}}</td>
                                              @else
                                                <td> </td>
                                              @endif
                                            
                                              
                                              
                                              <td>2J</td>
                                              <td style="text-align:right; padding-right:30px;border-left: 1px solid #ddd;" >{{number_format($pesoneto2j,0,',','.')}} KGS</td>
                                              <td>{{number_format(($retorno2j),2,',','.')}}
                                              <td>{{number_format(($retorno2j*0.08),2,',','.')}}
                                              </td>
                                              <td>
                                                {{number_format(($costopacking)*($pesoneto2j/($pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl+$pesonetol)),2)}}
                                              </td>
                                              <td>
                                                {{number_format(($otroscostos)*($pesoneto2j/($pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl+$pesonetol)),2)}}
                                              </td>
                                              <td>{{number_format(($retorno2j*0.92-(($costopacking+$otroscostos)*($pesoneto2j/($pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl+$pesonetol))+$totalmateriales2j)),2,',','.')}} USD
                                              </td>
                                             
                                              <td>
                                                @if ($pesoneto2j)
                                                  {{number_format(($retorno2j*0.92-(($costopacking+$otroscostos)*($pesoneto2j/($pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl+$pesonetol))+$totalmateriales2j))/$pesoneto2j,2,',','.')}} USD/kg
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
                                              @if ($calibrecount==1)
                                                <td>{{$variedad}}</td>
                                              @else
                                                <td> </td>
                                              @endif
                                              
                                              
                                              
                                              
                                              <td>J</td>
                                              <td style="text-align:right; padding-right:30px; border-left: 1px solid #ddd;" >{{number_format($pesonetoj,0,',','.')}} KGS</td>
                                              <td>{{number_format(($retornoj),2,',','.')}}
                                              <td>{{number_format(($retornoj*0.08),2,',','.')}}
                                              </td>
                                              <td>
                                                {{number_format(($costopacking)*($pesonetoj/($pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl+$pesonetol)),2)}}
                                              </td>
                                              <td>
                                                {{number_format(($otroscostos)*($pesonetoj/($pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl+$pesonetol)),2)}}
                                              </td>
                                              <td>{{number_format(($retornoj*0.92-(($costopacking+$otroscostos)*($pesonetoj/($pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl+$pesonetol))+$totalmaterialesj)),2,',','.')}} USD
                                              </td>
                                            
                                              <td>
                                                @if ($pesonetoj)
                                                  {{number_format(($retornoj*0.92-(($costopacking+$otroscostos)*($pesonetoj/($pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl+$pesonetol))+$totalmaterialesj))/$pesonetoj,2,',','.')}} USD/kg
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
                                              @if ($calibrecount==1)
                                                <td>{{$variedad}}</td>
                                              @else
                                                <td> </td>
                                              @endif
                                              
                                              
                                              
                                              
                                              <td>XL</td>
                                              <td style="text-align:right; padding-right:30px; border-left: 1px solid #ddd; " >{{number_format($pesonetoxl,0,',','.')}} KGS</td>
                                              <td>{{number_format(($retornoxl),2,',','.')}}
                                              <td>{{number_format(($retornoxl*0.08),2,',','.')}}
                                              </td>
                                              <td>
                                                {{number_format(($costopacking)*($pesonetoxl/($pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl+$pesonetol)),2)}}
                                              </td>
                                              <td>
                                                {{number_format(($otroscostos)*($pesonetoxl/($pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl+$pesonetol)),2)}}
                                              </td>
                                              <td>{{number_format(($retornoxl*0.92-(($costopacking+$otroscostos)*($pesonetoxl/($pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl+$pesonetol))+$totalmaterialesxl)),2,',','.')}} USD
                                              </td>
                                             
                                                <td>
                                                @if ($pesonetoxl)
                                                  {{number_format(($retornoxl*0.92-(($costopacking+$otroscostos)*($pesonetoxl/($pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl+$pesonetol))+$totalmaterialesxl))/$pesonetoxl,2,',','.')}} USD/kg
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
                                              {{number_format(($retorno4j+$retorno3j+$retorno2j+$retornoj+$retornoxl)*0.08,2,',','.')}}
                                            </td>
                                            <td>
                                              {{number_format(($costopacking)*(($pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl)/($pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl+$pesonetol)),2)}}
                                            </td>
                                            <td>
                                              {{number_format(($otroscostos)*(($pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl)/($pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl+$pesonetol)),2)}}
                                            </td>
                                            <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format((($retorno4j*0.92-(($costopacking+$otroscostos)*($pesoneto4j/($pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl))+$totalmateriales4j))+($retorno3j*0.92-(($costopacking+$otroscostos)*($pesoneto3j/($pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl))+$totalmateriales3j))+($retorno2j*0.92-(($costopacking+$otroscostos)*($pesoneto2j/($pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl))+$totalmateriales2j))+($retornoj*0.92-(($costopacking+$otroscostos)*($pesonetoj/($pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl))+$totalmaterialesj))+($retornoxl*0.92-(($costopacking+$otroscostos)*($pesonetoxl/($pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl))+$totalmaterialesxl))),2,',','.')}} USD 
                                            
                                            
                                          </td>
                                            <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format((($retorno4j*0.92-(($costopacking+$otroscostos)*($pesoneto4j/($pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl))+$totalmateriales4j))+($retorno3j*0.92-(($costopacking+$otroscostos)*($pesoneto3j/($pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl))+$totalmateriales3j))+($retorno2j*0.92-(($costopacking+$otroscostos)*($pesoneto2j/($pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl))+$totalmateriales2j))+($retornoj*0.92-(($costopacking+$otroscostos)*($pesonetoj/($pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl))+$totalmaterialesj))+($retornoxl*0.92-(($costopacking+$otroscostos)*($pesonetoxl/($pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl))+$totalmaterialesxl)))/($pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl),2,',','.')}} USD/KG</td>
                                            
                                          </tr>
                                        @endif
                                          @php
                                            $variedadcount+=1;
                                          @endphp
                                        
                              
                                      @endforeach
                                    
                                      @if ($pesonetototal>0)
                                        
                                      <tr style="background-color: #ddd;">
                                            
                                        
                                      
                                          <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">Total Dentro de Norma</td>
                                        
                                        
                                          <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
                                      
                                        
                                        
                                        <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"></td>
                                        <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format($pesonetototal,0,',','.')}} KGS</td>
                                        <td> </td>
                                        <td>
                                          {{number_format(($totalcostopacking),2)}}
                                        </td>
                                        <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format((($totalretorno4j+$totalretorno3j+$totalretorno2j+$totalretornoj+$totalretornoxl)*0.92-($totalotroscostos+$totalcostopacking+$globaltotalmateriales)),2,',','.')}} USD 
                                       
                                        </td>
                                        <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format((($totalretorno4j+$totalretorno3j+$totalretorno2j+$totalretornoj+$totalretornoxl)*0.92-($totalotroscostos+$totalcostopacking+$globaltotalmateriales))/$pesonetototal,2,',','.')}} usd/kg </td>
                                        
                                      </tr>
                                      @endif
                              
                                      @php
                                        
                                        $totaldentrodenorma=(($totalretorno4j+$totalretorno3j+$totalretorno2j+$totalretornoj+$totalretornoxl)*0.92-($totalotroscostos+$totalcostopacking+$globaltotalmateriales));
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

                                  <h1 class="mt-6">
                                    Listado de Variedades real
                                  </h1>
                                  @foreach ($variedades as $variedad)
                                    <a href="{{Route('grafico.variedad',['razonsocial'=>$razonsocial,'temporada'=>$temporada,'variedad'=>$variedad] )}}" target="_blank">                     
                                      {{$variedad->name}}<br>
                                    </a>
                                  @endforeach

                                  

                                  
                       

                                  
                               

                                  @foreach ($masas as $masa)
                                      

                                      @foreach ($fobs->where('n_variedad',$masa->n_variedad)->where('semana',$masa->semana) as $fob)
                                        
                                          @if (($masa->n_calibre=='4J' || $masa->n_calibre=='4JD' || $masa->n_calibre=='4JDD'))
                                            
                                              @if (strpos($fob->n_calibre, "4J") !== false)
                                                @if (strpos($fob->etiqueta, $masa->n_etiqueta) !== false)

                                                
                                                {{$masa->semana}} - {{$masa->n_variedad}} - {{$masa->n_etiqueta}} - {{$masa->n_calibre}} <br>
                                                 <b> PRECIO: {{$fob->fob_kilo_salida}} ({{$fob->fob_kilo_salida*$masa->peso_neto}}) </b> <br>

                                                @endif

                                              @endif
                                          @endif
                                          @if (($masa->n_calibre=='3J' || $masa->n_calibre=='3JD' || $masa->n_calibre=='3JDD'))
                                            @if (strpos($fob->n_calibre, "3J") !== false)

                                              @if (strpos($fob->etiqueta, $masa->n_etiqueta) !== false)
                                              {{$masa->semana}} - {{$masa->n_variedad}} - {{$masa->n_etiqueta}} - {{$masa->n_calibre}} <br>
                                               <b> PRECIO: {{$fob->fob_kilo_salida}} ({{$fob->fob_kilo_salida*$masa->peso_neto}}) </b> <br>

                                              @endif
                                            @endif
                                          @endif
                                          @if (($masa->n_calibre=='2J' || $masa->n_calibre=='2JD' || $masa->n_calibre=='2JDD'))
                                            @if (strpos($fob->n_calibre, "2J") !== false)

                                              @if (strpos($fob->etiqueta, $masa->n_etiqueta) !== false)
                                              {{$masa->semana}} - {{$masa->n_variedad}} - {{$masa->n_etiqueta}} - {{$masa->n_calibre}} <br>
                                               <b> PRECIO: {{$fob->fob_kilo_salida}} ({{$fob->fob_kilo_salida*$masa->peso_neto}}) </b> <br>

                                              @endif
                                            @endif
                                          @endif
                                          @if (($masa->n_calibre=='J' || $masa->n_calibre=='JD' || $masa->n_calibre=='JDD'))
                                            @if (strpos($fob->n_calibre, "J") !== false)

                                              @if (strpos($fob->etiqueta, $masa->n_etiqueta) !== false)
                                              {{$masa->semana}} - {{$masa->n_variedad}} - {{$masa->n_etiqueta}} - {{$masa->n_calibre}} <br>
                                               <b> PRECIO: {{$fob->fob_kilo_salida}} ({{$fob->fob_kilo_salida*$masa->peso_neto}}) </b> <br>

                                              @endif
                                            @endif
                                          @endif
                                          @if (($masa->n_calibre=='XL' || $masa->n_calibre=='XLD' || $masa->n_calibre=='XLDD'))
                                            @if (strpos($fob->n_calibre, "XL") !== false)

                                              @if (strpos($fob->etiqueta, $masa->n_etiqueta) !== false)
                                              {{$masa->semana}} - {{$masa->n_variedad}} - {{$masa->n_etiqueta}} - {{$masa->n_calibre}} <br>
                                               <b> PRECIO: {{$fob->fob_kilo_salida}} ({{$fob->fob_kilo_salida*$masa->peso_neto}}) </b> <br>

                                              @endif
                                            @endif
                                          @endif
                                          @break
                                      @endforeach

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
