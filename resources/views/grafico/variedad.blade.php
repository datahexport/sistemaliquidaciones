<!DOCTYPE html>
<html>
<head>
	<title>Grafico Variedad</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link href=”https://fonts.googleapis.com/css?family=Pacifico” rel=”stylesheet”>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/series-label.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
	<style>
		#container {
        margin: 0 auto; 
        height: 500px;
        width: 1200px;
    }
    .centrar {
        margin: 0 120px; /* Esto centra el elemento horizontalmente */
        width: 1230px; /* Ancho de la tabla */
    }
    .centrar {
        position: relative;
    }
    table {
        font-family: "Arial", sans-serif;
        background-color: white;
        position: absolute;
        top: -60px; /* Elevación de 150px */
        z-index: 1; /* Asegura que la tabla esté encima del gráfico */
    }
    th, td {
        padding: 5px;
        text-align: center;
    }
    table {
        border-collapse: collapse;
    }
    table, th, td {
        border: 1px solid;
    }

	</style>
</head>
<body>

    <figure class="highcharts-figure mx-1 mt-4">
        <div id="container">
           
        </div>
        
     </figure>


    
	
    @php
        $categories=[];
        $calibre_array=[];
        $curvacalibre_array=[];
        $retorno_array=[];
        $colors=['#24a745']
       
       
    @endphp

        @php
            $variedadcount=1;
            $cantidadtotal=0;
            $pesonetototal=0;
            $retornototal=0;
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
                $retorno4j=0;
                $retorno3j=0;
                $retorno2j=0;
                $retornoj=0;
                $retornoxl=0;
            @endphp

            @foreach ($masas as $masa)
            
                    @if (($masa->n_calibre=='4J' || $masa->n_calibre=='4JD' || $masa->n_calibre=='4JDD') && $masa->n_variedad==$variedad)
                            @php
                                $cantidad4j+=$masa->cantidad;
                                $pesoneto4j+=$masa->peso_neto;
                                foreach ($fobs->where('n_variedad',$masa->n_variedad)->where('semana',$masa->semana) as $fob){
                                    $retorno4j+=intval($masa->peso_neto)*intval($fob->fob_kilo_salida);
                                    $retornototal+=intval($masa->peso_neto)*intval($fob->fob_kilo_salida);
                                break;
                                }
                                $cantidadtotal+=$masa->cantidad;
                                $pesonetototal+=$masa->peso_neto;
                            @endphp	
                    @endif
                    @if (($masa->n_calibre=='3J' || $masa->n_calibre=='3JD' || $masa->n_calibre=='3JDD') && $masa->n_variedad==$variedad)
                            @php
                                $cantidad3j+=$masa->cantidad;
                                $pesoneto3j+=$masa->peso_neto;
                                foreach ($fobs->where('n_variedad',$masa->n_variedad)->where('semana',$masa->semana) as $fob){
                                    $retorno3j+=intval($masa->peso_neto)*intval($fob->fob_kilo_salida);
                                    $retornototal+=intval($masa->peso_neto)*intval($fob->fob_kilo_salida);
                                break;
                                }
                                $cantidadtotal+=$masa->cantidad;
                                $pesonetototal+=$masa->peso_neto;
                            @endphp	
                    @endif
                    @if (($masa->n_calibre=='2J' || $masa->n_calibre=='2JD' || $masa->n_calibre=='2JDD') && $masa->n_variedad==$variedad)
                            @php
                                $cantidad2j+=$masa->cantidad;
                                $pesoneto2j+=$masa->peso_neto;
                                foreach ($fobs->where('n_variedad',$masa->n_variedad)->where('semana',$masa->semana) as $fob){
                                    $retorno2j+=intval($masa->peso_neto)*intval($fob->fob_kilo_salida);
                                    $retornototal+=intval($masa->peso_neto)*intval($fob->fob_kilo_salida);
                                break;
                                }
                                $cantidadtotal+=$masa->cantidad;
                                $pesonetototal+=$masa->peso_neto;
                            @endphp	
                    @endif
                    @if (($masa->n_calibre=='J' || $masa->n_calibre=='JD' || $masa->n_calibre=='JDD') && $masa->n_variedad==$variedad)
                            @php
                                $cantidadj+=$masa->cantidad;
                                    $pesonetoj+=$masa->peso_neto;
                                    foreach ($fobs->where('n_variedad',$masa->n_variedad)->where('semana',$masa->semana) as $fob){
                                        $retornoj+=intval($masa->peso_neto)*intval($fob->fob_kilo_salida);
                                        $retornototal+=intval($masa->peso_neto)*intval($fob->fob_kilo_salida);
                                    break;
                                }
                                    $cantidadtotal+=$masa->cantidad;
                                $pesonetototal+=$masa->peso_neto;
                            @endphp	
                    @endif
                    @if (($masa->n_calibre=='XL' || $masa->n_calibre=='XLD' || $masa->n_calibre=='XLDD') && $masa->n_variedad==$variedad)
                            @php
                                $cantidadxl+=$masa->cantidad;
                                $pesonetoxl+=$masa->peso_neto;
                                foreach ($fobs->where('n_variedad',$masa->n_variedad)->where('semana',$masa->semana) as $fob){
                                    $retornoxl+=intval($masa->peso_neto)*intval($fob->fob_kilo_salida);
                                    $retornototal+=intval($masa->peso_neto)*intval($fob->fob_kilo_salida);
                                break;
                                }
                                $cantidadtotal+=$masa->cantidad;
                                $pesonetototal+=$masa->peso_neto;
                            @endphp	
                    @endif
                
                
            @endforeach

                @if ($unique_calibres->contains('4J') || $unique_calibres->contains('4JD') || $unique_calibres->contains('4JDD'))
                   
                      
                   
                    @php
                        $calibre_array[]='4J';
                        $curvacalibre_array[]=floatval(number_format($cantidad4j*100/($cantidad4j+$cantidad3j+$cantidad2j+$cantidadj+$cantidadxl),2));
                            if ($pesoneto4j>0){
                                $retorno_array[]=floatval(number_format($retorno4j/$pesoneto4j,2));
                            } else{
                                $retorno_array[]=floatval(0);
                            }
                          
                       
                        $calibrecount+=1;
                    @endphp
                @endif
                @if ($unique_calibres->contains('3J') || $unique_calibres->contains('3JD') || $unique_calibres->contains('3JDD'))
                   
                        @if ($variedadcount==1 && $calibrecount==1)
                            <td>Cherries</td>
                        @else
                            <td> </td>
                        @endif
                        @if ($calibrecount==1)
                            <td>{{$variedad}}</td>
                        @else
                            <td> </td>
                        @endif
                        @if ($calibrecount==1)
                            <td>Cat 1</td>
                        @else
                            <td> </td>
                        @endif
                        
                    @php
                        $calibre_array[]='3J';
                        $curvacalibre_array[]=floatval(number_format($cantidad3j*100/($cantidad4j+$cantidad3j+$cantidad2j+$cantidadj+$cantidadxl),2));
                        if ($pesoneto3j>0){
                                $retorno_array[]=floatval(number_format($retorno3j/$pesoneto3j,2));
                            } else{
                                $retorno_array[]=floatval(0);
                            }
                        $calibrecount+=1;
                    @endphp
                @endif
                @if ($unique_calibres->contains('2J') || $unique_calibres->contains('2JD') || $unique_calibres->contains('2JDD'))
                        @if ($variedadcount==1 && $calibrecount==1)
                            <td>Cherries</td>
                        @else
                            <td> </td>
                        @endif
                        @if ($calibrecount==1)
                            <td>{{$variedad}}</td>
                        @else
                            <td> </td>
                        @endif
                        @if ($calibrecount==1)
                            <td>Cat 1</td>
                        @else
                            <td> </td>
                        @endif
                        
                       
                    @php
                        $calibre_array[]='2J';
                        $curvacalibre_array[]=floatval(number_format($cantidad2j*100/($cantidad4j+$cantidad3j+$cantidad2j+$cantidadj+$cantidadxl),2));
                        if ($pesoneto2j>0){
                                $retorno_array[]=floatval(number_format($retorno2j/$pesoneto2j,2));
                            } else{
                                $retorno_array[]=floatval(0);
                            }
                        $calibrecount+=1;
                    @endphp
                @endif
                @if ($unique_calibres->contains('J') || $unique_calibres->contains('JD') || $unique_calibres->contains('JDD'))
                        @if ($variedadcount==1 && $calibrecount==1)
                            <td>Cherries</td>
                        @else
                            <td> </td>
                        @endif
                        @if ($calibrecount==1)
                            <td>{{$variedad}}</td>
                        @else
                            <td> </td>
                        @endif
                        @if ($calibrecount==1)
                            <td>Cat 1</td>
                        @else
                            <td> </td>
                        @endif
                      
                    @php
                        $calibre_array[]='J';
                        $curvacalibre_array[]=floatval(number_format($cantidadj*100/($cantidad4j+$cantidad3j+$cantidad2j+$cantidadj+$cantidadxl),2));
                            if ($pesonetoj>0){
                                $retorno_array[]=floatval(number_format($retornoj/$pesonetoj,2));
                            } else{
                                $retorno_array[]=floatval(0);
                            }
                        $calibrecount+=1;
                    @endphp
                @endif
                @if ($unique_calibres->contains('XL') || $unique_calibres->contains('XLD') || $unique_calibres->contains('XLDD'))
                        @if ($variedadcount==1 && $calibrecount==1)
                            <td>Cherries</td>
                        @else
                            <td> </td>
                        @endif
                        @if ($calibrecount==1)
                            <td>{{$variedad}}</td>
                        @else
                            <td> </td>
                        @endif
                        @if ($calibrecount==1)
                            <td>Cat 1</td>
                        @else
                            <td> </td>
                        @endif
                        
                        
                        
                    
                    @php
                        $calibre_array[]='XL';
                        $curvacalibre_array[]=floatval(number_format($cantidadxl*100/($cantidad4j+$cantidad3j+$cantidad2j+$cantidadj+$cantidadxl),2));
                        if ($pesonetoxl>0){
                                $retorno_array[]=floatval(number_format($retornoxl/$pesonetoxl,2));
                            } else{
                                $retorno_array[]=floatval(0);
                            }
                        $calibrecount+=1;
                    @endphp
                @endif

                @php
                    $totalpromedio=0;
                    $n=0;
                    $promedio=[];
                    $name=$variedad;
                @endphp
               @foreach ($retorno_array as $item)
                    @php
                            $totalpromedio+=$item;
                            $n+=1;
                    @endphp
                @endforeach  

               @foreach ($calibre_array as $item)
                    @if ($n>0)
                        @php
                            $promedio[]=floatval(number_format($totalpromedio/$n,2));
                        @endphp
                    @else    
                        @php
                            $promedio[]=floatval(0);
                        @endphp
                    @endif
               @endforeach

                @php
                    $variedadcount+=1;
                @endphp
            

        @endforeach

    <div class="centrar">
        <table style="width: 100%;">
            <tr>
                <td style="font-weight: bold;">
                   % CURVA DE CALIBRE
                </td>
                @foreach ($curvacalibre_array as $item)
                    <td style="font-weight: bold;">
                        {{$item}}%
                    </td>
                @endforeach
            </tr>
            <tr>
                <td style="font-weight: bold;">
                   RETORNO KILO
                </td>
                @foreach ($retorno_array as $item)
                    <td style="font-weight: bold;">
                        USD {{$item}}
                    </td>
                @endforeach
            </tr>
            <tr>
                <td style="font-weight: bold;">
                   PROMEDIO
                </td>
                @foreach ($promedio as $item)
                    <td style="font-weight: bold;">
                        USD {{$item}}
                    </td>
                @endforeach
            </tr>
        </table>
    </div>
        
        @php
            $colorbarra='#6FAB1B';
            $tamanoletra='28px'
        @endphp

      <script>
        
	
        var curvacalibre_array = <?php echo json_encode($curvacalibre_array) ?>;
        var retorno_array = <?php echo json_encode($retorno_array) ?>;
        var categories = <?php echo json_encode($calibre_array) ?>;
        var promedio = <?php echo json_encode($promedio) ?>;
        var colorbarra = <?php echo json_encode($colorbarra) ?>;
        var name = <?php echo json_encode($name) ?>;
        var tamanoletra = <?php echo json_encode($tamanoletra) ?>;

        console.log(curvacalibre_array); // Esto puede ayudar a verificar si se está pasando correctamente
        Highcharts.chart('container', {
    chart: {
        zoomType: 'xy',
        animation: false // Desactivar la animación de carga
    },
    title: {
        text: name,
        align: 'center',
        style: {
            fontSize: '25px' // Ajustar el tamaño del texto del título
        }
    },
    subtitle: {
        text: '',
        align: 'left',
        style: {
            fontSize: '16px' // Ajustar el tamaño del texto del subtítulo
        }
    },
    xAxis: [{
        categories: categories,
        crosshair: true,
        labels: {
            style: {
                fontSize: '14px' // Ajustar el tamaño del texto en el eje X
            }
        }
    }],
    yAxis: [{ // Eje Y para la serie "Rainfall" ubicado en el lado izquierdo
        gridLineWidth: 0,
        title: {
            text: '',
            style: {
                color: 'black',
                fontSize: '14px' // Ajustar el tamaño del texto en el eje Y
            }
        },
        labels: {
            format: '{value:.2f} %',
            style: {
                color: 'black',
                fontSize: tamanoletra, // Ajustar el tamaño del texto en el eje Y
                fontWeight: 'bold'
            }
        }
    }, { // Eje Y para las otras series ubicado en el lado derecho
        gridLineWidth: 0,
        title: {
            text: '',
            style: {
                color: 'black',
                fontSize: '14px' // Ajustar el tamaño del texto en el eje Y
            }
        },
        labels: {
            format: 'USD {value:.2f}',
            style: {
                color: 'black',
                fontSize: tamanoletra, // Ajustar el tamaño del texto en el eje Y
                fontWeight: 'bold'
            }
        },
        opposite: true,
        tickInterval: 0.5 // Aquí se establece el intervalo del eje Y a 0.5 USD
    }],
    tooltip: {
        shared: true
    },
    series: [{
        name: '% Curva de Calibre',
        type: 'column',
        yAxis: 0, // Asociar esta serie al primer eje Y
        data: curvacalibre_array,
        color: colorbarra, // Cambiar el color de la serie a verde
        tooltip: {
            valueSuffix: ' mm'
        },
        dataLabels: {
            enabled: true,
            inside: true,
            color: 'black',
            style: {
                fontSize: '30px',
                textOutline: '0px green', // Ajustar el tamaño del texto en el eje Y
                fontWeight: 'bold'
            },
            formatter: function() {
                return this.y + '%';
            }
        }
    }, {
        name: 'PROMEDIO',
        type: 'spline',
        yAxis: 1, // Asociar esta serie al segundo eje Y
        data: promedio,
        color: 'black',
        marker: {
            enabled: false
        },
        dashStyle: 'solid',
        tooltip: {
            valueSuffix: ' USD'
        },
        dataLabels: {
            enabled: true,
            borderRadius: 5,
            backgroundColor: 'white',
            borderWidth: 1,
            borderColor: 'black',
            padding: 5,
            style: {
                fontSize: '27px' // Ajustar el tamaño del texto del label
            },
            formatter: function() {
                // Verificar si ya se ha mostrado el datalabel
                if (this.point.index === 0) {
                    return 'USD '+this.y.toFixed(2);
                } else {
                    return null; // Deshabilitar datalabel para puntos subsiguientes
                }
            }
        }
    }, {
        name: 'RETORNO KILO',
        type: 'line',
        yAxis: 1, // Asociar esta serie al segundo eje Y
        data: retorno_array,
        color: 'orange',
        dataLabels: {
            enabled: true,
            borderRadius: 5,
            backgroundColor: 'white',
            borderWidth: 3,
            borderColor: 'orange',
            padding: 5,
            style: {
                fontSize: '27px' // Ajustar el tamaño del texto del label
            },
            formatter: function() {
                return 'USD ' + this.y.toFixed(2) ;
            }
        },
        tooltip: {
            valueSuffix: ' USD' // Ajuste de la unidad de medida para Temperature
        }
    }],
    plotOptions: {
        series: {
            animation: false // Desactivar la animación de carga
        }
    },
    exporting: {
        enabled: false // Deshabilitar la exportación y el menú
    }
    
});


      </script>
</body>
</html>