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
        <div id="container" style="width: 100%; height: 400px;"></div>
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
                        @php
                            $array=[];
                            $sumas = [
                                '4J' => ['suma' => 0, 'peso' => 0],
                                '3J' => ['suma' => 0, 'peso' => 0],
                                '2J' => ['suma' => 0, 'peso' => 0],
                                'J' => ['suma' => 0, 'peso' => 0],
                                'XL' => ['suma' => 0, 'peso' => 0],
                                'L' => ['suma' => 0, 'peso' => 0],
                            ];


                        @endphp
                        @if ($semana)
                          <tr>
                            <td class="px-6 py-0 whitespace-nowrap">
                              <div class="text-sm text-gray-900">{{$semana}}</div>    
                            </td>
                            @foreach ($masastotal->where('SEMANA',$semana) as $item)
                                    @php
                                      if ($item->fob) {
                                        $tarifafinal=0;
                                        $tarifafinal2=0;
                                        if ($item->fob->tarifas->count()>0) {
                                            $tarifafinal=$item->fob->tarifas->reverse()->first()->tarifa;
                                            $tarifafinal2=$item->fob->tarifas->reverse()->first()->tarifa;
                                        }
                                        $tarifaAplicada = ($item->CRITERIO == "COMERCIAL") ? $tarifafinal2 : $tarifafinal;
                                        $peso = floatval($item->PESO_PRORRATEADO);

                                        switch ($item->CALIBRE_REAL) {
                                            case '4J':
                                            case '3J':
                                            case '2J':
                                            case 'J':
                                            case 'XL':
                                            case 'L':
                                                $sumas[$item->CALIBRE_REAL]['suma'] += $tarifaAplicada * $peso;
                                                $sumas[$item->CALIBRE_REAL]['peso'] += $peso;
                                                break;
                                        }

                                      }
                                    @endphp
                              
                            @endforeach
                            
                            @foreach ($unique_calibres as $calibre)
                              @php
                                $calibres[]=$calibre; 
                              @endphp
                             
                                @php
                                    if ($sumas[$calibre]['peso'] >0) {
                                      $array[]=round($sumas[$calibre]['suma'] / $sumas[$calibre]['peso'], 2);
                                    } else {
                                      $array[]=null;
                                    }
                                    
                                    
                                @endphp

                              <td class="px-6 py-0 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                  @if ($sumas[$calibre]['peso'] >0) 
                                  
                                    {{number_format($sumas[$calibre]['suma']/$sumas[$calibre]['peso'],2)}}
                                  @else
                                      0
                                  @endif  
                                </div>    
                              </td>

                            @endforeach
                            
                          </tr>
                          @php
                              $series[]=['name' =>$semana,
                                        'data'=> $array];
                          @endphp
                        @endif  
                        
                        
                    @endforeach
                   
                    
                  </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

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
