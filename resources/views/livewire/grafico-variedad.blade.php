<div>
    <div class="bg-gray-100 rounded px-2 md:p-4 shadow mb-6">
        <h2 class="text-2xl font-semibold my-4">
            Graficos Variedad: {{$variedad->name}}
        </h2>
    </div>
    
    <div class="mx-2 mb-4 grid grid-cols-3 sm:grid-cols-3 md:grid-cols-6 lg:grid-cols-9 gap-y-4 gap-x-3 justify-between  content-center">
                  
          @foreach ($unique_variedades as $item)
            <div class="flex justify-center">
                @if ($item->id==$variedad->id)
                    <a href="{{ route('temporada.graficovariedad', ['variedad' => $item, 'temporada' => $temporada]) }}" class=" w-full text-center items-center focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 px-2 py-3 hover:bg-gray-500 focus:outline-none rounded" style="background-color: #e20606;">
                        <button>
                            <p class="whitespace-nowrap text-sm font-medium leading-none text-white">{{$item->name}}</p>
                        </button>
                    </a>
                @else
                    <a href="{{ route('temporada.graficovariedad', ['variedad' => $item, 'temporada' => $temporada]) }}" class=" w-full text-center items-center focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 px-2 py-3 hover:bg-gray-500 focus:outline-none rounded" style="background-color: #008d39;">
                        <button>
                            <p class="whitespace-nowrap text-sm font-medium leading-none text-white">{{$item->name}}</p>
                        </button>
                    </a>
                @endif
            </div>

            
          @endforeach
       

    </div>

    <div>
        <div wire:ignore id="container" style="width: 100%; height: 400px;"></div>
    </div>

    <div class="flex flex-col mb-2">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
          <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
              <table class="min-w-full divide-y divide-gray-200">
                  <thead class="bg-yellow-400">
                    <tr>
                      <th class="px-6 py-0 text-center text-xs font-bold text-gray-900">
                       
                      </th>
                      @foreach ($unique_calibres as $calibre)
                        <th class="px-6 py-0 text-center text-xs font-bold text-gray-900">
                          {{$calibre}}
                        </th>
                      @endforeach
                    </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($unique_semanas as $semana)
                       
                        @if ($semana)
                          <tr>
                            <td class="px-6 py-0 whitespace-nowrap">
                              <div class="text-sm text-gray-900">{{$semana}}</div>    
                            </td>
                            
                            @foreach ($unique_calibres as $calibre)
                              @if ($fobsall->where('n_calibre',$calibre)->where('semana',$semana)->count()>0)
                                
                                  

                                <td class="px-6 py-0 whitespace-nowrap">
                                  @if ($tarifaid==$fobsall->where('n_calibre',$calibre)->where('semana',$semana)->first()->tarifas->reverse()->first()->id)
                                      <input wire:model="tarifa" class="w-32 shadow-sm  border-2 border-gray-300 bg-white h-10 px-2 rounded-lg focus:outline-none">   
                                      <button wire:click='save_tarifaid()' class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                          <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                          <span class="relative">Guardar</span>
                                      </button>
                                  @else
                                      @if ($fobsall->where('n_calibre',$calibre)->where('semana',$semana)->first()->tarifas->reverse()->first()->tarifa!=$fobsall->where('n_calibre',$calibre)->where('semana',$semana)->first()->tarifas->first()->tarifa)
                                      {{number_format($fobsall->where('n_calibre',$calibre)->where('semana',$semana)->first()->tarifas->reverse()->first()->tarifa,2)}} <span  class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-red-900 leading-tight">
                                            <span aria-hidden class="absolute inset-0 bg-red-200 opacity-50 rounded-full text-xs"></span>
                                            <span wire:click.prevent="setback_tarifaid({{ $fobsall->where('n_calibre',$calibre)->where('semana',$semana)->first()->tarifas->reverse()->first()->id }})" 
                                                wire:key="item-{{ $fobsall->where('n_calibre',$calibre)->where('semana',$semana)->first()->tarifas->reverse()->first()->id }}"  class="relative">Eliminar</span>
                                            </span>
                                        </span>
                                      @else
                                        <div class="text-sm text-gray-900">
                                          {{number_format($fobsall->where('n_calibre',$calibre)->where('semana',$semana)->first()->tarifas->reverse()->first()->tarifa,2)}}
                                          <span wire:click='set_tarifaid({{$fobsall->where('n_calibre',$calibre)->where('semana',$semana)->first()->tarifas->reverse()->first()->id}})' class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                            <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full text-xs"></span>
                                            <span class="relative">Editar</span>
                                          </span>
                                        </div> 
                                      @endif
                                  @endif
                                      
                                </td>
                               
                              @else
                                <td class="px-6 py-0 whitespace-nowrap">
                                  <div class="text-sm text-red-900">
                                   -
                                  </div>    
                                </td>
                                
                              @endif
                              
                            @endforeach
                            
                          </tr>
                        
                        @endif  
                        
                        
                    @endforeach
                  </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

                    @foreach ($unique_semanas as $semana)
                        @php
                            $array=[];
                            $sumas = [
                                '5J' => ['tarifa' => 0, 'peso' => 0],
                                '4J' => ['tarifa' => 0, 'peso' => 0],
                                '3J' => ['tarifa' => 0, 'peso' => 0],
                                '2J' => ['tarifa' => 0, 'peso' => 0],
                                'J' => ['tarifa' => 0, 'peso' => 0],
                                'XL' => ['tarifa' => 0, 'peso' => 0],
                                'L' => ['tarifa' => 0, 'peso' => 0],
                                'JUP' => ['tarifa' => 0, 'peso' => 0],
                                'COMERCIAL' => ['tarifa' => 0, 'peso' => 0],
                                'PRE-CALIBRE' => ['tarifa' => 0, 'peso' => 0],
                            ];


                        @endphp
                        @if ($semana)
                         
                            @foreach ($fobsall->where('semana',$semana) as $item)
                                    @php
                                     
                                        switch ($item->n_calibre) {
                                            case '5J':
                                            case '4J':
                                            case '3J':
                                            case '2J':
                                            case 'J':
                                            case 'XL':
                                            case 'L':
                                                $sumas[$item->n_calibre]['tarifa'] += $item->tarifas->reverse()->first()->tarifa;
                                                $sumas[$item->n_calibre]['peso'] += 10;
                                                break;
                                        }

                                      
                                    @endphp
                              
                            @endforeach
                            
                            @foreach ($unique_calibres as $calibre)
                              @php
                                $calibres[]=$calibre; 
                              @endphp
                             
                                @php
                                    if ($sumas[$calibre]['peso'] >0) {
                                      $array[]=round($sumas[$calibre]['tarifa'], 2);
                                    } else {
                                      $array[]=null;
                                    }
                                    
                                    
                                @endphp


                            @endforeach
                            
                          
                          @php
                              $series[]=['name' =>$semana,
                                        'data'=> $array];
                          @endphp
                        @endif  
                        
                        
                    @endforeach

      <script>
        var series = <?php echo json_encode($series) ?>;
        var calibres = <?php echo json_encode($calibres) ?>;
  
        Highcharts.chart('container', {
            title: {
                text: '',
                align: 'left'
            },
            subtitle: {
                text: '',
                align: 'left'
            },
            yAxis: {
                title: {
                    text: 'USD'
                }
            },
            xAxis: {
                categories: calibres
            },
            tooltip: {
                useHTML: true, // Permite usar HTML para formatear el tooltip
                formatter: function () {
                    return `
                        <b>Semana ${this.series.name}</b> <br>Calibre: <span style="color: ${this.series.color};">${this.x}</span><br> <!-- Nombre de la serie -->
                        <span style="font-weight: bold;">${this.y.toFixed(2)} USD</span>
                    `;
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle'
            },
            plotOptions: {
                series: {
                    dataLabels: {
                        enabled: true,
                        useHTML: true, // Permite usar HTML en las etiquetas
                        formatter: function () {
                            if (this.point.index === 0) {
                                // Mantener el valor en la posición estándar
                                const valueLabel = `<span style="color: black; font-size: 11px;">${this.y.toFixed(2)} USD</span>`;
                                // Botón independiente con color de fondo de la serie
                                const buttonLabel = `
                                    <span style="
                                        display: inline-block;
                                        padding: 5px 10px;
                                        background-color: ${this.series.color};
                                        color: white;
                                        border-radius: 5px;
                                        font-weight: bold;
                                        font-size: 12px;
                                        position: absolute;
                                        transform: translate(-40px, -5px);
                                    ">
                                        ${this.series.name}
                                    </span>`;
                                return buttonLabel + valueLabel;
                            }
                            // Formato estándar para los demás puntos
                            return `<span style="color: black; font-size: 11px;">${this.y.toFixed(2)} USD</span>`;
                        },
                        style: {
                            fontWeight: 'bold',
                            color: 'black'
                        },
                        crop: false, // Evitar cortar etiquetas fuera del gráfico
                        overflow: 'none' // Permitir que las etiquetas sobresalgan si es necesario
                    }
                }
            },
            series: series,
            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        legend: {
                            layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
                        }
                    }
                }]
            }
        });

      
  </script>

</div>
