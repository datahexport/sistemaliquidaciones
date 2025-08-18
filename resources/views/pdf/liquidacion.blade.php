<!DOCTYPE html>
<html>
<head>
	<title>Liq. {{$razonsocial->name}}</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link href=”https://fonts.googleapis.com/css?family=Pacifico” rel=”stylesheet”>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

	<style>

		@font-face {
			font-family: "Roboto";
			src: url("' . public_path('fonts/Roboto-Regular.ttf') . '") format("truetype");
			/* Agrega aquí otras variantes de la fuente si las necesitas */
		}
		/* Estilos CSS para la página */
		@page {
			margin-top: 0px;
			margin-bottom: 0px;
			margin-left: 0px;
			margin-right: 0px;
		}
		body {
			font-family: 'Roboto', 'Segoe UI', Tahoma, sans-serif;
			width: 100%;
			margin: 0;
			padding: 0;
		}

		.page-break {
			page-break-after: always;
		}
		html {
			margin: 0;
		}
		.container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh; /* Esto centra verticalmente en la página */
            text-align: center; /* Esto centra el texto dentro de los elementos */
        }
		.cuerpo {
		margin-left: 30px;
		margin-right: 30px;
		font-size: 11px;
		}
		

		th, td {
			padding-top: 1px;
			padding-bottom: 1px;
			padding-left: 2px;
			padding-right: 2px;
			text-align: center;
		}
		tr {
			border-bottom: 1px solid #ddd;
		}
		.fondo-abajo {
			position: fixed;
			bottom: 0;
			left: 50%;
			transform: translateX(-50%);

			width: calc(100% - 60px); /* El ancho de la imagen es el 100% del ancho de la ventana menos los 60px de margen */
			z-index: -1; /* Coloca la imagen detrás del contenido */
		}
		

	</style>
</head>

<body>
	<div class="container">
        <h1 style="color:red; margin-top: 150px; font-size: 52px;">LIQUIDACIÓN CEREZAS</h1>
        <h1 style="color:gray; margin-top: 10px;">{{$temporada->name}}</h1>
        <img class="object-contain" style="height: 550px;"  src="{{asset('image/logo.png')}}" alt="">
		<h1>{{$razonsocial->name}}</h1>
    </div>

	

	<div class="page-break"></div>
	
	<div class="cuerpo">

		<table style="width:100%;border-collapse: collapse; margin-bottom: 30px; margin-top: 30px;">
		
			<tr style="text-align: left; border-bottom: 0px solid #ddd;">
				<td style="text-align: left;">
					<h1 style="color: red;margin: 0; line-height: 1.2;">
						DISTRIBUCION FRUTA ENTREGADA
					</h1>
					<h2 style="margin: 0; line-height: 1.2;">POR VARIEDAD</h2>
				</td>
				
				<td>
					<img class="object-contain" style="height: 100px;" src="{{asset('image/logo.png')}}" alt="">
				</td>
			  </tr>
		</table>

		{{-- Datos Productor --}}
		<table style="width:60%; margin-bottom:30px; border-collapse: collapse;">
			<thead > 
				<tr style="border-bottom: 0px solid #ddd;">
					<td style="text-align: center; padding: 2px;">
						PRODUCTOR
					</td>
					{{--  
					<td style="text-align: center; border: 1px solid black; padding: 2px;">
						{{$razonsocial->rut}}
					</td>
					--}}
					<td style="text-align: center; padding: 2px; font-weight: bold; ">
						{{$razonsocial->name}}
					</td>
				</tr>
			</thead>
		</table>

		
		<table id="balance" style="width:100%; border-collapse: collapse; margin-top: 20px;">
			<thead style="border-top: 2px solid black; border-bottom: 2px solid black;">
				<tr style="border: 1px solid black; font-weight: bold;">
					<th style="border: 1px solid black; font-weight: bold; white-space: nowrap; font-size: 10px;">KG<br>VARIEDAD</th>
					<th style="white-space: nowrap; font-size: 10px;">TIPO<br>EXPORTACIÓN</th>
					<th style="white-space: nowrap; font-size: 10px;">COMERCIAL EMBALADA</th>
					<th style="white-space: nowrap; font-size: 10px;">COMERCIAL</th>
					<th style="white-space: nowrap; font-size: 10px;">PRE-CALIBRE</th>
					<th style="white-space: nowrap; font-size: 10px;">MERMA DESECHO</th>
					<th style="white-space: nowrap; font-size: 10px;">MERMA HOJAS</th>
					<th style="white-space: nowrap; font-size: 10px;">TOTAL</th>
				</tr>
			</thead>
			
			<tbody>
				@php
					$variedadcount=1;
					$cantidadtotal=0;
					$pesonetototal=0;
					$retornototal=0;
					$totalpesoneto4j=0;
					$totalpesoneto3j=0;
					$totalpesoneto2j=0;
					$totalpesonetoj=0;
					$totalpesonetoxl=0;
					$totalpesonetoxxl=0;
					$totalfrutanacional=0;
					$resultadocomercial=0;

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
						$pesonetoxxl=0;
						$retorno4j=0;
						$retorno3j=0;
						$retorno2j=0;
						$retornoj=0;
						$retornoxl=0;

						
					@endphp

					@foreach ($masas as $masa)
						@if ($masa->tipo=='COMERCIAL EMBALADA' || $masa->tipo=='COMERCIAL' || $masa->tipo=='PRE-CALIBRE' || $masa->tipo=='MERMA DESECHO' || $masa->tipo=='MERMA HOJAS' || $masa->tipo=='COMERCIAL EMBALADA' || $masa->tipo=='EXPORTACIÓN LIGHT' || $masa->tipo=='EXPORTACIÓN DARK' || $masa->tipo=='EXPORTACIÓN')
							@if (($masa->tipo=='COMERCIAL EMBALADA') && $masa->variedad==$variedad)
									@php
										$cantidad4j+=floatval($masa->cantidad);

											$pesonetoxxl+=floatval($masa->peso_prorrateado);
											$totalpesonetoxxl+=floatval($masa->peso_prorrateado);
											$pesonetototal+=floatval($masa->peso_prorrateado);
										
											
										
										$cantidadtotal+=floatval($masa->cantidad);
										
									@endphp	
							@endif
							@if (($masa->tipo=='COMERCIAL') && $masa->variedad==$variedad)
									@php
										$cantidad4j+=floatval($masa->cantidad);

										if ($masa->peso_caja>0) {
											$pesoneto4j+=floatval($masa->peso_caja)*floatval($masa->cantidad);
											$totalpesoneto4j+=floatval($masa->peso_caja)*floatval($masa->cantidad);
											$pesonetototal+=floatval($masa->peso_caja)*floatval($masa->cantidad);
										} else {
											$pesoneto4j+=floatval($masa->peso_prorrateado);
											$totalpesoneto4j+=floatval($masa->peso_prorrateado);
											$pesonetototal+=floatval($masa->peso_prorrateado);
										}
										
											
										
										$cantidadtotal+=floatval($masa->cantidad);
										
									@endphp	
							@endif
							@if (($masa->tipo=='PRE-CALIBRE') && $masa->variedad==$variedad)
									@php
										$cantidad3j+=floatval($masa->cantidad);

										if ($masa->peso_caja>0) {
											$pesoneto3j+=floatval($masa->peso_caja)*floatval($masa->cantidad);
											$totalpesoneto3j+=floatval($masa->peso_caja)*floatval($masa->cantidad);
											$pesonetototal+=floatval($masa->peso_caja)*floatval($masa->cantidad);
										} else {
											$pesoneto3j+=floatval($masa->peso_prorrateado);
											$totalpesoneto3j+=floatval($masa->peso_prorrateado);
											$pesonetototal+=floatval($masa->peso_prorrateado);
										}
										
										$cantidadtotal+=floatval($masa->cantidad);
										
									@endphp	
							@endif
							@if (($masa->tipo=='MERMA DESECHO') && $masa->variedad==$variedad)
									@php
										$cantidad2j+=floatval($masa->cantidad);

										if ($masa->peso_caja>0) {
											$pesoneto2j+=floatval($masa->peso_caja)*floatval($masa->cantidad);
											$totalpesoneto2j+=floatval($masa->peso_caja)*floatval($masa->cantidad);
											$pesonetototal+=floatval($masa->peso_caja)*floatval($masa->cantidad);
										} else {
											$pesoneto2j+=floatval($masa->peso_prorrateado);
											$totalpesoneto2j+=floatval($masa->peso_prorrateado);
											$pesonetototal+=floatval($masa->peso_prorrateado);
										}
										
										$cantidadtotal+=floatval($masa->cantidad);
										
									@endphp	
							@endif
							@if (($masa->tipo=='MERMA HOJAS') && $masa->variedad==$variedad)
									@php
										$cantidadj+=floatval($masa->cantidad);

										if ($masa->peso_caja>0) {
											$pesonetoj+=floatval($masa->peso_caja)*floatval($masa->cantidad);
											$totalpesonetoj+=floatval($masa->peso_caja)*floatval($masa->cantidad);
											$pesonetototal+=floatval($masa->peso_caja)*floatval($masa->cantidad);
										} else {
											$pesonetoj+=floatval($masa->peso_prorrateado);
											$totalpesonetoj+=floatval($masa->peso_prorrateado);
											$pesonetototal+=floatval($masa->peso_prorrateado);
										}
										
										$cantidadtotal+=floatval($masa->cantidad);
										
									@endphp	
							@endif
							@if (($masa->tipo=='EXPORTACIÓN LIGHT' || $masa->tipo=='EXPORTACIÓN DARK' || $masa->tipo=='EXPORTACIÓN') && $masa->variedad==$variedad)
									@php
										$cantidadxl+=floatval($masa->cantidad);

										if ($masa->peso_caja>0) {
											$pesonetoxl+=floatval($masa->peso_caja)*floatval($masa->cantidad);
											$totalpesonetoxl+=floatval($masa->peso_caja)*floatval($masa->cantidad);
											$pesonetototal+=floatval($masa->peso_caja)*floatval($masa->cantidad);
										} else {
											$pesonetoxl+=floatval($masa->peso_prorrateado);
											$totalpesonetoxl+=floatval($masa->peso_prorrateado);
											$pesonetototal+=floatval($masa->peso_prorrateado);
										}
										
										$cantidadtotal+=floatval($masa->cantidad);
										
									@endphp	
							@endif

							@if ($masa->precio_fob>0 && $masa->variedad==$variedad)
								@php
									if ($masa->peso_caja>0) {
										$totalfrutanacional+=floatval($masa->peso_caja)*floatval($masa->cantidad)*floatval($masa->precio_fob);
									} else {
										$totalfrutanacional+=floatval($masa->peso_prorrateado)*floatval($masa->precio_fob);
									}
									
								@endphp
							@endif
							
						@endif
						@php      
									$tarifafinal=0;
									if (!IS_NULL($masa->fob)) {
													$tarifafinal=$masa->fob->tarifas->reverse()->first()->tarifa;
									}
											
						@endphp 
						@if (($masa->CRITERIO=='COMERCIAL') && $masa->NORMA=='MERCADO INTERNO')
							@if ($masa->variedad==$variedad)
								@php
									$resultadocomercial+=$masa->peso_prorrateado*$tarifafinal-$masa->costo;
								@endphp
							@endif
						@endif	
					@endforeach

							<tr>
								
								
								<td style="border-top: 0.5px groove black; text-align:right; padding-right:20px;">{{$variedad}}</td>
								<td style="border-top: 0.5px groove black; text-align:right; padding-right:10px;">{{number_format($pesonetoxl,2,',','.')}} KG</td>
								<td style="border-top: 0.5px groove black; text-align:right; padding-right:20px;">{{number_format($pesonetoxxl,2,',','.')}} KG</td>
								
								<td style="border-top: 0.5px groove black; text-align:right; padding-right:20px;">{{number_format($pesoneto4j,2,',','.')}} KG</td>
								<td style="border-top: 0.5px groove black; text-align:right; padding-right:20px;">{{number_format($pesoneto3j,2,',','.')}} KG</td>
								<td style="border-top: 0.5px groove black; text-align:right; padding-right:20px;">{{number_format($pesoneto2j,2,',','.')}} KG</td>
								<td style="border-top: 0.5px groove black; text-align:right; padding-right:20px;">{{number_format($pesonetoj,2,',','.')}} KG</td>
								<td style="border-top: 0.5px groove black; text-align:right; padding-right:20px;">{{number_format($pesonetoxl+$pesonetoxxl+$pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj,2,',','.')}} KG</td>

								
								
								
								
							</tr>
				

						

					
						

						@php
							$variedadcount+=1;
						@endphp
					

				@endforeach

				<tr style="border: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;">
					<td style="border: 1px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold; white-space: nowrap;">TOTAL</td>
					<td style="text-align:right; padding-right:10px; white-space: nowrap;">{{number_format($totalpesonetoxl,2,',','.')}} KG</td>
					<td style="text-align:right; padding-right:20px; white-space: nowrap;">{{number_format($totalpesonetoxxl,2,',','.')}} KG</td>
					<td style="text-align:right; padding-right:20px; white-space: nowrap;">{{number_format($totalpesoneto4j,2,',','.')}} KG</td>
					<td style="text-align:right; padding-right:20px; white-space: nowrap;">{{number_format($totalpesoneto3j,2,',','.')}} KG</td>
					<td style="text-align:right; padding-right:20px; white-space: nowrap;">{{number_format($totalpesoneto2j,2,',','.')}} KG</td>
					<td style="text-align:right; padding-right:20px; white-space: nowrap;">{{number_format($totalpesonetoj,2,',','.')}} KG</td>
					<td style="text-align:right; padding-right:20px; white-space: nowrap;">{{number_format($totalpesonetoxl+$totalpesonetoxxl+$totalpesoneto4j+$totalpesoneto3j+$totalpesoneto2j+$totalpesonetoj,2,',','.')}} KG</td>
				</tr>
				
						

			</tbody>
		</table>


		<div class="page-break"></div>

		<table style="width:100%;border-collapse: collapse; margin-bottom: 30px; margin-top: 30px;">
		
			<tr style="text-align: left; border-bottom: 0px solid #ddd;">
				<td style="text-align: left;">
					<h1 style="color: red;margin: 0; line-height: 1.2;">
						INFORME LIQUIDACION FRUTA EXPORTACIÓN
					</h1>
					<h2 style="margin: 0; line-height: 1.2;">FRUTA DENTRO DE NORMA</h2>
				</td>
				
				<td>
					<img class="object-contain" style="height: 100px;" src="{{asset('image/logo.png')}}" alt="">
				</td>
			  </tr>
		</table>

			{{-- Datos Productor --}}
			<table style="width:60%; margin-bottom:30px; border-collapse: collapse;">
				<thead > 
					<tr style="border-bottom: 0px solid #ddd;">
						<td style="text-align: center; padding: 2px;">
							PRODUCTOR
						</td>
						{{--  
						<td style="text-align: center; border: 1px solid black; padding: 2px;">
							{{$razonsocial->rut}}
						</td>
						--}}
						<td style="text-align: center; padding: 2px; font-weight: bold; ">
							{{$razonsocial->name}}
						</td>
					</tr>
				</thead>
			</table>

		<table id="balance" style="width:100%; border-collapse: collapse; margin-top: 20px;">
              <thead style="border-top: 2px solid black; border-bottom: 2px solid black;">
                <tr>
                  <th>NORMA</th>
                  <th>VARIEDAD</th>
                  @if ($informe_edit->semana_dentrodenorma == 'si')
                    <th></th>
                    <th>SEMANA</th>
                    <th></th>
                  @endif
                  <th>CALIBRE</th>
                  <th>KG EMBALADOS</th>
                  <th>TOTAL USD</th>
                  <th>NPK</th>
                </tr>
              </thead>

              @if ($informe_edit->semana_dentrodenorma=='si')
                <tbody>
                    <tr style="background-color: #ddd;">
                            
                        <td style="font-weight: bold; " > DENTRO DE NORMA </td>
                    
                    
                    
                      
                      <td></td>
                      <td></td>
                      <td></td>
                      <td ></td>
                      <td></td>
                      <td ></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      
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
                      
                        
                        
                          <td ></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          
                          
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
                                      $margen5j_semana += floatval($masa->peso_prorrateado * $tarifafinal * $informe_edit->comision);
                                  }
                              
                                  $costos5j_semana += floatval($masa->costo);
                              
                                  // Versión total (sin _semana)
                                  $cantidad5j += floatval($masa->cantidad);
                                  $pesoneto5j += floatval($masa->peso_prorrateado);
                              
                                  if (!is_null($masa->fob)) {
                                      $retorno5j += floatval($masa->peso_prorrateado * $tarifafinal);
                                      $margen5j += floatval($masa->peso_prorrateado * $tarifafinal * $informe_edit->comision);
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
                                        $margen4j_semana += floatval($masa->peso_prorrateado * $tarifafinal * $informe_edit->comision);
                                    }
                                    $costos4j_semana += floatval($masa->costo);
                                    $totalmateriales4j_semana += floatval($masa->costo);
                              
                                    // Total
                                    $cantidad4j += floatval($masa->cantidad);
                                    $pesoneto4j += floatval($masa->peso_prorrateado);
                                    if (!is_null($masa->fob)) {
                                        $retorno4j += floatval($masa->peso_prorrateado * $tarifafinal);
                                        $margen4j += floatval($masa->peso_prorrateado * $tarifafinal * $informe_edit->comision);
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
                                        $margen3j_semana += floatval($masa->peso_prorrateado * $tarifafinal * $informe_edit->comision);
                                    }
                                    $costos3j_semana += floatval($masa->costo);
                                    $totalmateriales3j_semana += floatval($masa->costo);
                              
                                    $cantidad3j += floatval($masa->cantidad);
                                    $pesoneto3j += floatval($masa->peso_prorrateado);
                                    if (!is_null($masa->fob)) {
                                        $retorno3j += floatval($masa->peso_prorrateado * $tarifafinal);
                                        $margen3j += floatval($masa->peso_prorrateado * $tarifafinal * $informe_edit->comision);
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
                                        $margen2j_semana += floatval($masa->peso_prorrateado * $tarifafinal * $informe_edit->comision);
                                    }
                                    $costos2j_semana += floatval($masa->costo);
                                    $totalmateriales2j_semana += floatval($masa->costo);
                              
                                    $cantidad2j += floatval($masa->cantidad);
                                    $pesoneto2j += floatval($masa->peso_prorrateado);
                                    if (!is_null($masa->fob)) {
                                        $retorno2j += floatval($masa->peso_prorrateado * $tarifafinal);
                                        $margen2j += floatval($masa->peso_prorrateado * $tarifafinal * $informe_edit->comision);
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
                                        $margenj_semana += floatval($masa->peso_prorrateado * $tarifafinal * $informe_edit->comision);
                                    }
                                    $costosj_semana += floatval($masa->costo);
                                    $totalmaterialesj_semana += floatval($masa->costo);
                              
                                    $cantidadj += floatval($masa->cantidad);
                                    $pesonetoj += floatval($masa->peso_prorrateado);
                                    if (!is_null($masa->fob)) {
                                        $retornoj += floatval($masa->peso_prorrateado * $tarifafinal);
                                        $margenj += floatval($masa->peso_prorrateado * $tarifafinal * $informe_edit->comision);
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
                                        $margenxl_semana += floatval($masa->peso_prorrateado * $tarifafinal * $informe_edit->comision);
                                    }
                                    $costosxl_semana += floatval($masa->costo);
                                    $totalmaterialesxl_semana += floatval($masa->costo);
                              
                                    $cantidadxl += floatval($masa->cantidad);
                                    $pesonetoxl += floatval($masa->peso_prorrateado);
                                    if (!is_null($masa->fob)) {
                                        $retornoxl += floatval($masa->peso_prorrateado * $tarifafinal);
                                        $margenxl += floatval($masa->peso_prorrateado * $tarifafinal * $informe_edit->comision);
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
                              
                                <td></td>
                                
                                <td></td>
                                <td></td>
                                <td></td>
                                
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
                                    {{ number_format($pesoneto5j_semana, 2, ',', '.') }} KG
                                  </td>
                                 
                                  {{-- npk --}}
                                  <td style="text-align:right; padding-right:30px;border-left: 1px solid #ddd;" >
                                    @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "5J" && $semana_mod == $semana)
                                      @if ($type_mod == "npk")
                                        {{ $retorno }}
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
                                        {{ number_format($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','5J')->where('semana',$semana)->first()->retorno, 2, ',', '.') }} USD
                                        @php
                                          $retorno_neto5j_semana = $informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','5J')->where('semana',$semana)->first()->retorno;
                                        @endphp
                                      @else
                                        {{ number_format(($retorno5j_semana - ($margen5j_semana + $costos5j_semana)), 2, ',', '.') }} USD
                                        @php
                                          $retorno_neto5j_semana = $retorno5j_semana - ($margen5j_semana + $costos5j_semana);
                                        @endphp
                                      @endif
                                    @endif
                                      @php
                                           $retorno_neto5j+= $retorno_neto5j_semana;
                                      @endphp
                                    
                                  </td>
                                  {{-- retorno --}}
                                  <td style="text-align:right; padding-right:20px;border-left: 1px solid #ddd;">
                                    @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "5J" && $semana_mod == $semana)
                                      @if ($type_mod == "retorno")
                                        {{ $npk }}
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
                                          {{ number_format($informe_edit->modificaciones->where('categoria', 'DENTRO DE NORMA')->where('variedad', $variedad)->where('calibre', '5J')->where('semana',$semana)->first()->npk, 2, ',', '.') }} USD
                                      @else
                                        @if ($pesoneto5j_semana)
                                            {{ number_format(($retorno5j_semana - ($margen5j_semana + $costos5j_semana)) / $pesoneto5j_semana, 2, ',', '.') }} USD
                                        @else
                                          0 USD
                                        @endif
                                      @endif
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
                                    {{ number_format($pesoneto4j_semana, 2, ',', '.') }} KG
                                  </td>
                                 
                                  {{-- npk --}}
								                  <td style="text-align:right; padding-right:20px;border-left: 1px solid #ddd;">
                                    @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "4J" && $semana_mod == $semana)
                                      @if ($type_mod == "npk")
                                        {{ $retorno }}
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
                                          {{ number_format($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','4J')->where('semana',$semana)->first()->retorno, 2, ',', '.') }} USD
                                        @php
                                          $retorno_neto4j_semana = $informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','4J')->where('semana',$semana)->first()->retorno;
                                        @endphp
                                      @else
                                        {{ number_format(($retorno4j_semana - ($margen4j_semana + $costos4j_semana)), 2, ',', '.') }} USD
                                        @php
                                          $retorno_neto4j_semana = $retorno4j_semana - ($margen4j_semana + $costos4j_semana);
                                        @endphp
                                      @endif
                                    @endif
                                    @php
                                      $retorno_neto4j += $retorno_neto4j_semana;
                                    @endphp
                                    
                                  </td>

                                  {{-- retorno --}}
								                  <td style="text-align:right; padding-right:20px;border-left: 1px solid #ddd;">
                                    @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "4J" && $semana_mod == $semana)
                                      @if ($type_mod == "retorno")
                                        {{ $npk }}
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
                                          {{ number_format($informe_edit->modificaciones->where('categoria', 'DENTRO DE NORMA')->where('variedad', $variedad)->where('calibre', '4J')->where('semana',$semana)->first()->npk, 2, ',', '.') }} USD
                                      @else
                                        @if ($pesoneto4j_semana)
                                            {{ number_format(($retorno4j_semana - ($margen4j_semana + $costos4j_semana)) / $pesoneto4j_semana, 2, ',', '.') }} USD
                                        @else
                                          0 USD
                                        @endif
                                      @endif
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
                                  <td style="text-align:right; padding-right:30px;border-left: 1px solid #ddd;">{{ number_format($pesoneto3j_semana, 2, ',', '.') }} KG</td>
                                  

                                  {{-- npk --}}
                                  <td style="text-align:right; padding-right:20px;border-left: 1px solid #ddd;">
                                    @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "3J" && $semana_mod == $semana)
                                      @if ($type_mod == "npk")
                                        {{ $retorno }}
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
                                          {{ number_format($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','3J')->where('semana',$semana)->first()->retorno, 2, ',', '.') }} USD
                                        @php
                                          $retorno_neto3j_semana = $informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','3J')->where('semana',$semana)->first()->retorno;
                                        @endphp
                                      @else
                                        {{ number_format(($retorno3j_semana - ($margen3j_semana + $costos3j_semana)), 2, ',', '.') }} USD
                                        @php
                                          $retorno_neto3j_semana = $retorno3j_semana - ($margen3j_semana + $costos3j_semana);
                                        @endphp
                                      @endif
                                    @endif
                                    @php
                                      $retorno_neto3j += $retorno_neto3j_semana;
                                    @endphp
                                   
                                  </td>

                                  {{-- retorno --}}
                                  <td style="text-align:right; padding-right:20px;border-left: 1px solid #ddd;">
                                    @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "3J" && $semana_mod == $semana)
                                      @if ($type_mod == "retorno")
                                        {{ $npk }}
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
                                          {{ number_format($informe_edit->modificaciones->where('categoria', 'DENTRO DE NORMA')->where('variedad', $variedad)->where('calibre', '3J')->where('semana',$semana)->first()->npk, 2, ',', '.') }} USD
                                      @else
                                        @if ($pesoneto3j_semana)
                                            {{ number_format(($retorno3j_semana - ($margen3j_semana + $costos3j_semana)) / $pesoneto3j_semana, 2, ',', '.') }} USD
                                        @else
                                          0 USD
                                        @endif
                                      @endif
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
                                  <td style="text-align:right; padding-right:30px;border-left: 1px solid #ddd;">{{ number_format($pesoneto2j_semana, 2, ',', '.') }} KG</td>
                                 

                                  {{-- npk --}}
                                  <td style="text-align:right; padding-right:20px;border-left: 1px solid #ddd;">
                                    @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "2J" && $semana_mod == $semana)
                                      @if ($type_mod == "npk")
                                        {{ $retorno }}
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
                                          {{ number_format($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','2J')->where('semana',$semana)->first()->retorno, 2, ',', '.') }} USD
                                        @php
                                          $retorno_neto2j_semana = $informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','2J')->where('semana',$semana)->first()->retorno;
                                        @endphp
                                      @else
                                        {{ number_format(($retorno2j_semana - ($margen2j_semana + $costos2j_semana)), 2, ',', '.') }} USD
                                        @php
                                          $retorno_neto2j_semana = $retorno2j_semana - ($margen2j_semana + $costos2j_semana);
                                        @endphp
                                      @endif
                                    @endif
                                    @php
                                      $retorno_neto2j += $retorno_neto2j_semana;
                                    @endphp
                                    
                                  </td>

                                  {{-- retorno --}}
                                  <td style="text-align:right; padding-right:20px;border-left: 1px solid #ddd;">
                                    @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "2J" && $semana_mod == $semana)
                                      @if ($type_mod == "retorno")
                                        {{ $npk }}
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
                                          {{ number_format($informe_edit->modificaciones->where('categoria', 'DENTRO DE NORMA')->where('variedad', $variedad)->where('calibre', '2J')->where('semana',$semana)->first()->npk, 2, ',', '.') }} USD
                                      @else
                                        @if ($pesoneto2j_semana)
                                            {{ number_format(($retorno2j_semana - ($margen2j_semana + $costos2j_semana)) / $pesoneto2j_semana, 2, ',', '.') }} USD
                                        @else
                                          0 USD
                                        @endif
                                      @endif
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
                                  <td style="text-align:right; padding-right:30px; border-left: 1px solid #ddd;">{{ number_format($pesonetoj_semana, 2, ',', '.') }} KG</td>
                                

                                 {{-- npk --}}
                                  <td style="text-align:right; padding-right:20px;border-left: 1px solid #ddd;">
                                    @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "J" && $semana_mod == $semana)
                                      @if ($type_mod == "npk")
                                        {{ $retorno }}
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
                                          {{ number_format($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','J')->where('semana',$semana)->first()->retorno, 2, ',', '.') }} USD
                                        @php
                                          $retorno_netoj_semana = $informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','J')->where('semana',$semana)->first()->retorno;
                                        @endphp
                                      @else
                                        {{ number_format(($retornoj_semana - ($margenj_semana + $costosj_semana)), 2, ',', '.') }} USD
                                        @php
                                          $retorno_netoj_semana = $retornoj_semana - ($margenj_semana + $costosj_semana);
                                        @endphp
                                      @endif
                                    @endif
                                    @php
                                      $retorno_netoj += $retorno_netoj_semana;
                                    @endphp
                                   
                                  </td>

                                  {{-- retorno --}}
                                  <td style="text-align:right; padding-right:20px;border-left: 1px solid #ddd;">
                                    @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "J" && $semana_mod == $semana)
                                      @if ($type_mod == "retorno")
                                        {{ $npk }}
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
                                          {{ number_format($informe_edit->modificaciones->where('categoria', 'DENTRO DE NORMA')->where('variedad', $variedad)->where('calibre', 'J')->where('semana',$semana)->first()->npk, 2, ',', '.') }} USD
                                      @else
                                        @if ($pesonetoj_semana)
                                            {{ number_format(($retornoj_semana - ($margenj_semana + $costosj_semana)) / $pesonetoj_semana, 2, ',', '.') }} USD
                                        @else
                                          0 USD
                                        @endif
                                      @endif
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
                                  <td style="text-align:right; padding-right:30px; border-left: 1px solid #ddd;">{{ number_format($pesonetoxl_semana, 2, ',', '.') }} KG</td>
                                  
                                  {{-- npk --}}
                                  <td style="text-align:right; padding-right:20px;border-left: 1px solid #ddd;">
                                    @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "XL" && $semana_mod == $semana)
                                      @if ($type_mod == "npk")
                                        {{ $retorno }}
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
                                          {{ number_format($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','XL')->where('semana',$semana)->first()->retorno, 2, ',', '.') }} USD
                                        @php
                                          $retorno_netoxl_semana = $informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','XL')->where('semana',$semana)->first()->retorno;
                                        @endphp
                                      @else
                                        {{ number_format(($retornoxl_semana - ($margenxl_semana + $costosxl_semana)), 2, ',', '.') }} USD
                                        @php
                                          $retorno_netoxl_semana = $retornoxl_semana - ($margenxl_semana + $costosxl_semana);
                                        @endphp
                                      @endif
                                    @endif
                                    @php
                                      $retorno_netoxl += $retorno_netoxl_semana;
                                    @endphp
                                   
                                  </td>

                                  {{-- retorno --}}
                                  <td style="text-align:right; padding-right:20px;border-left: 1px solid #ddd;">
                                    @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "XL" && $semana_mod == $semana)
                                      @if ($type_mod == "retorno")
                                        {{ $npk }}
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
                                          {{ number_format($informe_edit->modificaciones->where('categoria', 'DENTRO DE NORMA')->where('variedad', $variedad)->where('calibre', 'XL')->where('semana',$semana)->first()->npk, 2, ',', '.') }} USD
                                      @else
                                        @if ($pesonetoxl_semana)
                                            {{ number_format(($retornoxl_semana - ($margenxl_semana + $costosxl_semana)) / $pesonetoxl_semana, 2, ',', '.') }} USD
                                        @else
                                          0 USD
                                        @endif
                                      @endif
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
                                <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; text-align:right; padding-right:30px;">
                                  {{ number_format($pesoneto5j_semana + $pesoneto4j_semana + $pesoneto3j_semana + $pesoneto2j_semana + $pesonetoj_semana + $pesonetoxl_semana, 2, ',', '.') }} KG
                                </td>
                                
                                <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; text-align:right; padding-right:20px;">
                                  {{ number_format($retorno_neto5j_semana + $retorno_neto4j_semana + $retorno_neto3j_semana + $retorno_neto2j_semana + $retorno_netoj_semana + $retorno_netoxl_semana, 2, ',', '.') }} USD
                                </td>
                                <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; text-align:right; padding-right:20px;">
                                  {{ number_format(
                                    ($retorno_neto5j_semana + $retorno_neto4j_semana + $retorno_neto3j_semana + $retorno_neto2j_semana + $retorno_netoj_semana + $retorno_netoxl_semana)
                                    /
                                    ($pesoneto5j_semana + $pesoneto4j_semana + $pesoneto3j_semana + $pesoneto2j_semana + $pesonetoj_semana + $pesonetoxl_semana),
                                    2, ',', '.'
                                  ) }} USD
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

                        <tr style="background-color: white;">
                          <td></td>
                          <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; text-align: center;">
                            Total {{$variedad}}:
                          </td>
                          
                          <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
                          <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
                          <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
                          <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
                          <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; text-align:right; padding-right:30px;">{{number_format($pesoneto5j+$pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl,2,',','.')}} KG</td>
                         
                          <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; text-align:right; padding-right:20px;">{{number_format(($retorno_neto5j+$retorno_neto4j+$retorno_neto3j+$retorno_neto2j+$retorno_netoj+$retorno_netoxl),2,',','.')}} USD
                          
                          
                          </td>
                        
                          <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; text-align:right; padding-right:20px;">{{number_format(($retorno_neto5j+$retorno_neto4j+$retorno_neto3j+$retorno_neto2j+$retorno_netoj+$retorno_netoxl)/($pesoneto5j+$pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl),2,',','.')}} USD</td>
                          
                        </tr>
                        @php
                             $totalcount+=($retorno_neto5j+$retorno_neto4j+$retorno_neto3j+$retorno_neto2j+$retorno_netoj+$retorno_netoxl);
                        @endphp
                      @endif

                    @endforeach
                  
                  @if ($pesonetototal>0)
                    <tr style="background-color: #ddd;">
                          
                      
                    
                        <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;" colspan="4" >TOTAL DENTRO DE NORMA</td>
                      
                      
                        <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
                    
                      
                      
                      <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"></td>
                      <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; text-align:right; padding-right:30px;">{{number_format($pesonetototal,1,',','.')}} KG</td>
                      
                      <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; text-align:right; padding-right:20px;">{{number_format($totalcount,2,',','.')}} USD 
                    
                      </td>
                      <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; text-align:right; padding-right:20px;">{{number_format($totalcount/$pesonetototal,2,',','.')}} USD </td>
                      
                    </tr>
                  @endif
          
                  @php
                    $totaldentrodenorma=($totalcount);
                  @endphp
                    
          
                </tbody>
              @else
                <tbody>
                  <tr style="background-color: #ddd;">
                          
                      <td style="font-weight: bold; " > DENTRO DE NORMA </td>
                    
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  
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
                      <td></td>
                      <td></td>
                      <td></td>
                    
                      
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
                                                  $margen5j+=floatval($masa->peso_prorrateado*$tarifafinal*$informe_edit->comision);
                                                  $totalmargen5j+=floatval($masa->peso_prorrateado*$tarifafinal*$informe_edit->comision);
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
                                  $margen4j+=floatval($masa->peso_prorrateado*$tarifafinal*$informe_edit->comision);
                                  $totalmargen4j+=floatval($masa->peso_prorrateado*$tarifafinal*$informe_edit->comision);
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
                                                  $margen3j+=floatval($masa->peso_prorrateado*$tarifafinal*$informe_edit->comision);
                                                  $totalmargen3j+=floatval($masa->peso_prorrateado*$tarifafinal*$informe_edit->comision);
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
                                              $margen2j+=floatval($masa->peso_prorrateado*$tarifafinal*$informe_edit->comision);
                                              $totalmargen2j+=floatval($masa->peso_prorrateado*$tarifafinal*$informe_edit->comision);
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
                                                  $margenj+=floatval($masa->peso_prorrateado*$tarifafinal*$informe_edit->comision);
                                                  $totalmargenj+=floatval($masa->peso_prorrateado*$tarifafinal*$informe_edit->comision);
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
                                              $margenxl+=floatval($masa->peso_prorrateado*$tarifafinal*$informe_edit->comision);
                                              $totalmargenxl+=floatval($masa->peso_prorrateado*$tarifafinal*$informe_edit->comision);
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
                              <td style="text-align:right; padding-right:30px;border-left: 1px solid #ddd; white-space: nowrap; " >{{number_format($pesoneto5j,2,',','.')}} KG</td>
                              
                          
                              <td style="white-space: nowrap; text-align:right; padding-right:40px;" >
                                  @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "5J" && $semana_mod == "no")
                                    @if ($type_mod=="npk")
                                      {{$retorno}}
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
                                        {{number_format($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','5J')->where('semana','no')->first()->retorno, 2, ',', '.') }} USD
                                        @php
                                            $retorno_neto5j=$informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','5J')->where('semana','no')->first()->retorno;
                                        @endphp
                                    @else
                                      {{ number_format(($retorno5j - ($margen5j + $costos5j)), 2, ',', '.') }} USD
                                      @php
                                          $retorno_neto5j=($retorno5j - ($margen5j + $costos5j));
                                      @endphp
                                    @endif
                          
                                  @endif
                          
                          
                              </td>
                              <td style="white-space: nowrap; text-align:right; padding-right:20px;" >
                                  @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "5J" && $semana_mod == "no")
                                    @if ($type_mod=="retorno")
                                      {{$npk}}
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
                                        {{number_format($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','5J')->where('semana','no')->first()->npk, 2, ',', '.') }} USD
                                      
                                    @else
                                      @if ($pesoneto5j)
                                            {{ number_format(($retorno5j - ($margen5j + $costos5j)) / $pesoneto5j, 2, ',', '.') }} USD
                                      @else
                                          0 USD
                                      @endif
                                    @endif
                          
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
                              <td style="text-align:right; padding-right:30px;border-left: 1px solid #ddd; white-space: nowrap;" >{{number_format($pesoneto4j,2,',','.')}} KG</td>
                              
                          <td style="white-space: nowrap; text-align:right; padding-right:40px;" >
                                @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "4J" && $semana_mod == "no")
                                  @if ($type_mod=="npk")
                                    {{$retorno}}
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
                                      {{number_format($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','4J')->where('semana','no')->first()->retorno, 2, ',', '.') }} USD
                                      @php
                                          $retorno_neto4j=$informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','4J')->where('semana','no')->first()->retorno;
                                      @endphp
                                  @else
                                    {{ number_format(($retorno4j - ($margen4j + $costos4j)), 2, ',', '.') }} USD
                                    @php
                                        $retorno_neto4j=($retorno4j - ($margen4j + $costos4j));
                                    @endphp
                                  @endif
                                @endif
                              
                                
                          </td>
                          <td style="white-space: nowrap; text-align:right; padding-right:20px;" >
                            @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "4J" && $semana_mod == "no")
                              @if ($type_mod=="retorno")
                                {{$npk}}
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
                                  {{number_format($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','4J')->where('semana','no')->first()->npk, 2, ',', '.') }} USD
                              @else
                                @if ($pesoneto4j)
                                      {{ number_format(($retorno4j - ($margen4j + $costos4j)) / $pesoneto4j, 2, ',', '.') }} USD
                                @else
                                    0 USD
                                @endif
                              @endif
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
                          <td style="text-align:right; padding-right:30px;border-left: 1px solid #ddd; white-space: nowrap;" >{{number_format($pesoneto3j,2,',','.')}} KG</td>
                          
                          <td style="white-space: nowrap; text-align:right; padding-right:40px;">
                            @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "3J" && $semana_mod == "no")
                              @if ($type_mod=="npk")
                                {{$retorno}}
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
                                  {{number_format($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','3J')->where('semana','no')->first()->retorno, 2, ',', '.') }} USD
                                  @php
                                      $retorno_neto3j=$informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','3J')->where('semana','no')->first()->retorno;
                                  @endphp
                              @else
                                {{ number_format(($retorno3j - ($margen3j + $costos3j)), 2, ',', '.') }} USD
                                @php
                                    $retorno_neto3j=($retorno3j - ($margen3j + $costos3j));
                                @endphp
                              @endif
                            @endif

                            
                          </td>
                          <td style="white-space: nowrap; text-align:right; padding-right:20px;">
                            @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "3J" && $semana_mod == "no")
                              @if ($type_mod=="retorno")
                                {{$npk}}
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
                                  {{number_format($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','3J')->where('semana','no')->first()->npk, 2, ',', '.') }} USD
                              @else
                                @if ($pesoneto3j)
                                      {{ number_format(($retorno3j - ($margen3j + $costos3j)) / $pesoneto3j, 2, ',', '.') }} USD
                                @else
                                    0 USD
                                @endif
                              @endif
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
                          <td style="text-align:right; padding-right:30px;border-left: 1px solid #ddd; white-space: nowrap;" >{{number_format($pesoneto2j,2,',','.')}} KG</td>
                         
                          
                          <td style="white-space: nowrap; text-align:right; padding-right:40px;">
                            @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "2J" && $semana_mod == "no")
                              @if ($type_mod=="npk")
                                {{$retorno}}
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
                                  {{number_format($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','2J')->where('semana','no')->first()->retorno, 2, ',', '.') }} USD
                                  @php
                                      $retorno_neto2j=$informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','2J')->where('semana','no')->first()->retorno;
                                  @endphp
                              @else
                                {{ number_format(($retorno2j - ($margen2j + $costos2j)), 2, ',', '.') }} USD
                                @php
                                    $retorno_neto2j=($retorno2j - ($margen2j + $costos2j));
                                @endphp
                              @endif
                            @endif
                          
                            
                          </td>
                          <td style="white-space: nowrap; text-align:right; padding-right:20px;">
                            @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "2J" && $semana_mod == "no")
                              @if ($type_mod=="retorno")
                                {{$npk}}
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
                                  {{number_format($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','2J')->where('semana','no')->first()->npk, 2, ',', '.') }} USD
                              @else
                                @if ($pesoneto2j)
                                      {{ number_format(($retorno2j - ($margen2j + $costos2j)) / $pesoneto2j, 2, ',', '.') }} USD
                                @else
                                    0 USD
                                @endif
                              @endif
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
                          <td style="text-align:right; padding-right:30px; border-left: 1px solid #ddd; white-space: nowrap;" >{{number_format($pesonetoj,2,',','.')}} KG</td>
                         
                          
                          <td style="white-space: nowrap; text-align:right; padding-right:40px;">
                            @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "J" && $semana_mod == "no")
                              @if ($type_mod=="npk")
                                {{$retorno}}
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
                                  {{number_format($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','J')->where('semana','no')->first()->retorno, 2, ',', '.') }} USD
                                  @php
                                      $retorno_netoj=$informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','J')->where('semana','no')->first()->retorno;
                                  @endphp
                              @else
                                {{ number_format(($retornoj - ($margenj + $costosj)), 2, ',', '.') }} USD
                                @php
                                    $retorno_netoj=($retornoj - ($margenj + $costosj));
                                @endphp
                              @endif
                            @endif
                          
                          </td>
                          <td style="white-space: nowrap; text-align:right; padding-right:20px;">
                            @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "J" && $semana_mod == "no")
                              @if ($type_mod=="retorno")
                                {{$npk}}
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
                                  {{number_format($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','J')->where('semana','no')->first()->npk, 2, ',', '.') }} USD
                              @else
                                @if ($pesonetoj)
                                      {{ number_format(($retornoj - ($margenj + $costosj)) / $pesonetoj, 2, ',', '.') }} USD
                                @else
                                    0 USD
                                @endif
                              @endif
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
                          <td style="text-align:right; padding-right:30px; border-left: 1px solid #ddd; white-space: nowrap;" >{{number_format($pesonetoxl,2,',','.')}} KG</td>
                          
                          <td style="white-space: nowrap; text-align:right; padding-right:40px;">
                            @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "XL" && $semana_mod == "no")
                              @if ($type_mod=="npk")
                                {{$retorno}}
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
                          
                          </td>
                          <td style="white-space: nowrap; text-align:right; padding-right:20px;">
                            @if ($categoria_mod == "DENTRO DE NORMA" && $variedad_mod == $variedad && $calibre_mod == "XL" && $semana_mod == "no")
                              @if ($type_mod=="retorno")
                                {{$npk}}
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
                                  {{number_format($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','XL')->where('semana','no')->first()->npk, 2, ',', '.') }} USD
                              @else
                                @if ($pesonetoxl)
                                      {{ number_format(($retornoxl - ($margenxl + $costosxl)) / $pesonetoxl, 2, ',', '.') }} USD
                                @else
                                    0 USD
                                @endif
                              @endif
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
                        <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; text-align:right; padding-right:30px;">{{number_format($pesoneto5j+$pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl,2,',','.')}} KG</td>
                        
                        <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;white-space: nowrap; text-align:right; padding-right:40px;">{{number_format(($retorno_neto5j+$retorno_neto4j+$retorno_neto3j+$retorno_neto2j+$retorno_netoj+$retorno_netoxl),2,',','.')}} USD
                        
                        
                        </td>
                        <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; white-space: nowrap; text-align:right; padding-right:20px;">{{number_format(($retorno_neto5j+$retorno_neto4j+$retorno_neto3j+$retorno_neto2j+$retorno_netoj+$retorno_netoxl)/($pesoneto5j+$pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl),2,',','.')}} USD</td>
                        
                      </tr>
                    @endif 
                      @php
                        $totalcount+=($retorno_neto5j+$retorno_neto4j+$retorno_neto3j+$retorno_neto2j+$retorno_netoj+$retorno_netoxl);
                        $variedadcount+=1;
                      @endphp
                    
          
                  @endforeach
                
                  @if ($pesonetototal>0)
                    <tr style="background-color: #ddd;">
                          
                      
                    
                        <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">TOTAL DENTRO DE NORMA</td>
                      
                      
                        <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
                    
                      
                      
                      <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"></td>
                      <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; text-align:right; padding-right:30px;">{{number_format($pesonetototal,1,',','.')}} KG</td>
                      
                      <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; white-space: nowrap; text-align:right; padding-right:40px;">{{number_format($totalcount,2,',','.')}} USD 
                    
                      </td>
                      <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; white-space: nowrap; text-align:right; padding-right:20px;">{{number_format($totalcount/$pesonetototal,2,',','.')}} USD</td>
                      
                    </tr>
                  @endif
          
                  @php
                    $totaldentrodenorma=($totalcount);
                  @endphp
                    
          
                </tbody>
              @endif
            </table>

		<div class="page-break"></div>

		<table style="width:100%;border-collapse: collapse; margin-bottom: 30px; margin-top: 30px;">
		
			<tr style="text-align: left; border-bottom: 0px solid #ddd;">
				<td style="text-align: left;">
					<h1 style="color: red;margin: 0; line-height: 1.2;">
						INFORME LIQUIDACION FRUTA EXPORTACIÓN
					</h1>
					<h2 style="margin: 0; line-height: 1.2;">FRUTA FUERA DE NORMA</h2>
				</td>
				
				<td>
					<img class="object-contain" style="height: 100px;" src="{{asset('image/logo.png')}}" alt="">
				</td>
			  </tr>
		</table>

			{{-- Datos Productor --}}
			<table style="width:60%; margin-bottom:30px; border-collapse: collapse; ">
				<thead > 
					<tr style="border-bottom: 0px solid #ddd;">
						<td style="text-align: center; padding: 2px;">
							PRODUCTOR
						</td>
						{{--  
						<td style="text-align: center; border: 1px solid black; padding: 2px;">
							{{$razonsocial->rut}}
						</td>
						--}}
						<td style="text-align: center; padding: 2px; font-weight: bold; ">
							{{$razonsocial->name}}
						</td>
					</tr>
				</thead>
			</table>

		
		<table id="balance" style="width:100%; border-collapse: collapse; margin-top: 20px;">
			<thead style="border-top: 2px solid black; border-bottom: 2px solid black;">
			  <tr>
          <th>NORMA</th>
          <th>VARIEDAD</th>
          @if ($informe_edit->semana_fueradenorma=='si')
            <th></th>
            <th>SEMANA</th>
            <th></th>
          @endif
          <th>CALIBRE</th>
          <th>KG EMBALADOS</th>
          <th>TOTAL USD</th>
          <th>NPK</th>
          
			  </tr>
			</thead>
		        @if ($informe_edit->semana_fueradenorma=='si')
              <tbody>
                  <tr style="background-color: #ddd;">
                          
                      <td style="font-weight: bold;" > FUERA DE NORMA </td>
                  
                  
                      <td> </td>
                      <td> </td>
                    
                    <td></td>
                    
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    
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
                        <td></td>
                        <td></td>
                        <td></td>
                        
                        
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
                                    $margen5j_semana += floatval($masa->peso_prorrateado * $tarifafinal * $informe_edit->comision);
                                }
                            
                                $costos5j_semana += floatval($masa->costo);
                            
                                // Versión total (sin _semana)
                                $cantidad5j += floatval($masa->cantidad);
                                $pesoneto5j += floatval($masa->peso_prorrateado);
                            
                                if (!is_null($masa->fob)) {
                                    $retorno5j += floatval($masa->peso_prorrateado * $tarifafinal);
                                    $margen5j += floatval($masa->peso_prorrateado * $tarifafinal * $informe_edit->comision);
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
                                      $margen4j_semana += floatval($masa->peso_prorrateado * $tarifafinal * $informe_edit->comision);
                                  }
                                  $costos4j_semana += floatval($masa->costo);
                                  $totalmateriales4j_semana += floatval($masa->costo);
                            
                                  // Total
                                  $cantidad4j += floatval($masa->cantidad);
                                  $pesoneto4j += floatval($masa->peso_prorrateado);
                                  if (!is_null($masa->fob)) {
                                      $retorno4j += floatval($masa->peso_prorrateado * $tarifafinal);
                                      $margen4j += floatval($masa->peso_prorrateado * $tarifafinal * $informe_edit->comision);
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
                                      $margen3j_semana += floatval($masa->peso_prorrateado * $tarifafinal * $informe_edit->comision);
                                  }
                                  $costos3j_semana += floatval($masa->costo);
                                  $totalmateriales3j_semana += floatval($masa->costo);
                            
                                  $cantidad3j += floatval($masa->cantidad);
                                  $pesoneto3j += floatval($masa->peso_prorrateado);
                                  if (!is_null($masa->fob)) {
                                      $retorno3j += floatval($masa->peso_prorrateado * $tarifafinal);
                                      $margen3j += floatval($masa->peso_prorrateado * $tarifafinal * $informe_edit->comision);
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
                                      $margen2j_semana += floatval($masa->peso_prorrateado * $tarifafinal * $informe_edit->comision);
                                  }
                                  $costos2j_semana += floatval($masa->costo);
                                  $totalmateriales2j_semana += floatval($masa->costo);
                            
                                  $cantidad2j += floatval($masa->cantidad);
                                  $pesoneto2j += floatval($masa->peso_prorrateado);
                                  if (!is_null($masa->fob)) {
                                      $retorno2j += floatval($masa->peso_prorrateado * $tarifafinal);
                                      $margen2j += floatval($masa->peso_prorrateado * $tarifafinal * $informe_edit->comision);
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
                                      $margenj_semana += floatval($masa->peso_prorrateado * $tarifafinal * $informe_edit->comision);
                                  }
                                  $costosj_semana += floatval($masa->costo);
                                  $totalmaterialesj_semana += floatval($masa->costo);
                            
                                  $cantidadj += floatval($masa->cantidad);
                                  $pesonetoj += floatval($masa->peso_prorrateado);
                                  if (!is_null($masa->fob)) {
                                      $retornoj += floatval($masa->peso_prorrateado * $tarifafinal);
                                      $margenj += floatval($masa->peso_prorrateado * $tarifafinal * $informe_edit->comision);
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
                                      $margenxl_semana += floatval($masa->peso_prorrateado * $tarifafinal * $informe_edit->comision);
                                  }
                                  $costosxl_semana += floatval($masa->costo);
                                  $totalmaterialesxl_semana += floatval($masa->costo);
                            
                                  $cantidadxl += floatval($masa->cantidad);
                                  $pesonetoxl += floatval($masa->peso_prorrateado);
                                  if (!is_null($masa->fob)) {
                                      $retornoxl += floatval($masa->peso_prorrateado * $tarifafinal);
                                      $margenxl += floatval($masa->peso_prorrateado * $tarifafinal * $informe_edit->comision);
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
                                        $margenl_semana += floatval($masa->peso_prorrateado * $tarifafinal * $informe_edit->comision);
                                    }
                                    $costosl_semana += floatval($masa->costo);
                                    $totalmaterialesl_semana += floatval($masa->costo);
          
                                    $cantidadl += floatval($masa->cantidad);
                                    $pesonetol += floatval($masa->peso_prorrateado);
                                    if (!is_null($masa->fob)) {
                                        $retornol += floatval($masa->peso_prorrateado * $tarifafinal);
                                        $margenl += floatval($masa->peso_prorrateado * $tarifafinal * $informe_edit->comision);
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
                                <td style="text-align:right; padding-right:30px; border-left: 1px solid #ddd; white-space: nowrap;">{{ number_format($pesonetol_semana, 2, ',', '.') }} KG</td>
                              
                                {{-- npk --}}
                                <td style="text-align:right; padding-right:30px;" > 
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
                                        {{ number_format($informe_edit->modificaciones->where('categoria','FUERA DE NORMA')->where('variedad',$variedad)->where('calibre','L')->where('semana',$semana)->first()->retorno, 2, ',', '.') }} USD
                                      @php
                                        $retorno_netol_semana = $informe_edit->modificaciones->where('categoria','FUERA DE NORMA')->where('variedad',$variedad)->where('calibre','L')->where('semana',$semana)->first()->retorno;
                                      @endphp
                                    @else
                                      {{ number_format(($retornol_semana - ($margenl_semana + $costosl_semana)), 2, ',', '.') }} USD
                                      @php
                                        $retorno_netol_semana = $retornol_semana - ($margenl_semana + $costosl_semana);
                                      @endphp
                                    @endif
                                  @endif
                                  @php
                                    $retorno_netol += $retorno_netol_semana;
                                  @endphp
                                 
                                </td>
          
                                {{-- retorno --}}
                                <td style="text-align:right; padding-right:10px; " > 
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
                                        {{ number_format($informe_edit->modificaciones->where('categoria', 'FUERA DE NORMA')->where('variedad', $variedad)->where('calibre', 'L')->where('semana',$semana)->first()->npk, 2, ',', '.') }} USD
                                    @else
                                      @if ($pesonetol_semana)
                                          {{ number_format(($retornol_semana - ($margenl_semana + $costosl_semana)) / $pesonetol_semana, 2, ',', '.') }} USD
                                      @else
                                        0 USD
                                      @endif
                                    @endif
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
                              <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;  white-space: nowrap;">Total {{ $semana }}:</td>
                              <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
                              <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
                              <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; white-space: nowrap; text-align:right; padding-right:30px;">
                                {{ number_format($pesonetol_semana, 2, ',', '.') }} KG
                              </td>
                             
                              <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;  white-space: nowrap; text-align:right; padding-right:30px; ">
                                {{ number_format($retorno_netol_semana, 2, ',', '.') }} USD
                              </td>
                              <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;  white-space: nowrap; text-align:right; padding-right:10px; ">
                                {{ number_format(
                                  ($retorno_netol_semana)
                                  /
                                  ($pesonetol_semana),
                                  2, ',', '.'
                                ) }} USD
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
                        <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; text-align: center;  white-space: nowrap;">
                          Total {{$variedad}}:
                        </td>
                        
                        <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
                        <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
                        <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
                        <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
                        <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; white-space: nowrap; text-align:right; padding-right:30px; ">{{number_format($pesonetol,2,',','.')}} KG</td>
                        <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; white-space: nowrap; text-align:right; padding-right:30px; ">{{number_format(($retorno_netol),2,',','.')}} USD</td>
                      
                        <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; white-space: nowrap; text-align:right; padding-right:10px; ">{{number_format(($retorno_netol)/($pesonetol),2,',','.')}} USD</td>
                        
                      </tr>
                      @php
                           $totalcount+=($retorno_netol);
                      @endphp
                    @endif
          
                  @endforeach
                
                @if ($pesonetototal>0)
                  <tr style="background-color: #ddd;">
                        
                    
                  
                      <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; white-space: nowrap;text-align:left; padding-left:20px; " colspan="4" >TOTAL FUERA DE NORMA</td>
                    
                    
                      <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
                  
                    
                    
                    <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"></td>
                    <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; text-align:right; padding-right:30px; ">{{number_format($pesonetototal,2,',','.')}} KG</td>
                    
                    <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; text-align:right; padding-right:30px; ">{{number_format($totalcount,2,',','.')}} USD 
                  
                    </td>
                    <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; text-align:right; padding-right:10px; ">{{number_format($totalcount/$pesonetototal,2,',','.')}} USD </td>
                    
                  </tr>
                @endif
          
                @php
                  $totalfueraodenorma=($totalcount);
                @endphp
                  
          
              </tbody>
            @else
              <tbody>
                <tr style="background-color: #ddd;">
                        
                    <td style="font-weight: bold;" > FUERA DE NORMA </td>
                
                
                    <td> </td>
                  
                  <td></td>
                  
                  <td></td>
                  <td></td>
                  <td></td>
                 
                  
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
                    <td></td>
                    <td></td>
                    <td></td>
                    
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
                            $margenl+=floatval($masa->peso_prorrateado*$tarifafinal*$informe_edit->comision);
                            $totalmargenl+=floatval($masa->peso_prorrateado*$tarifafinal*$informe_edit->comision);
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
                        <td style="text-align:right; padding-right:30px; border-left: 1px solid #ddd; white-space: nowrap;" >{{number_format($pesonetol,2,',','.')}} KG</td>
                        
          
                        <td style="text-align:right; padding-right:30px;">
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
                                {{number_format($informe_edit->modificaciones->where('categoria','FUERA DE NORMA')->where('variedad',$variedad)->where('calibre','L')->where('semana','no')->first()->retorno, 2, ',', '.') }} USD
                              @php
                                  $retorno_netol=$informe_edit->modificaciones->where('categoria','FUERA DE NORMA')->where('variedad',$variedad)->where('calibre','L')->where('semana','no')->first()->retorno;
                              @endphp
                            @else
                              {{ number_format(($retornol - ($margenl + $costosl)), 2, ',', '.') }} USD
                              @php
                                  $retorno_netol=($retornol - ($margenl + $costosl));
                              @endphp
                            @endif
                          @endif
          
                         
                        </td>
                        <td style="text-align:right; padding-right:10px;" >
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
                                {{number_format($informe_edit->modificaciones->where('categoria','FUERA DE NORMA')->where('variedad',$variedad)->where('calibre','L')->where('semana','no')->first()->npk, 2, ',', '.') }} USD
                            @else
                              @if ($pesonetol)
                                    {{ number_format(($retornol - ($margenl + $costosl)) / $pesonetol, 2, ',', '.') }} USD
                              @else
                                  0 USD
                              @endif
                            @endif
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
                      <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; text-align:right; padding-right:30px;">{{number_format($pesonetol,2,',','.')}} KG</td>
                      
                      <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; text-align:right; padding-right:30px;">{{number_format(($retorno_netol),2,',','.')}} USD
                      
                      
                    </td>
                      <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; text-align:right; padding-right:10px;">{{number_format(($retorno_netol)/($pesonetol),2,',','.')}} USD</td>
                      
                    </tr>
                  @endif 
                    @php
                      $totalcount+=($retorno_netol);
                      $variedadcount+=1;
                    @endphp
                  
          
                @endforeach
              
                @if ($pesonetototal>0)
                  <tr style="background-color: #ddd;">
                        
                    
                  
                      <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; white-space: nowrap;">TOTAL FUERA DE NORMA</td>
                    
                    
                      <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
                  
                    
                    
                    <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"></td>
                    <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; text-align:right; padding-right:30px;">{{number_format($pesonetototal,2,',','.')}} KG</td>
                   
                    
                    <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; text-align:right; padding-right:30px;">{{number_format($totalcount,2,',','.')}} USD 
                  
                    </td>
                    <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;text-align:right; padding-right:10px;">{{number_format($totalcount/$pesonetototal,2,',','.')}} USD </td>
                    
                  </tr>
                @endif
          
               
                  
          
              </tbody>
            @endif
            
            @php
              $totalfueradenorma=($totalcount);
            @endphp
		</table>

		<div class="page-break"></div>

		<table style="width:100%;border-collapse: collapse; margin-bottom: 30px; margin-top: 30px;">
		
			<tr style="text-align: left; border-bottom: 0px solid #ddd;">
				<td style="text-align: left;">
					<h1 style="color: red;margin: 0; line-height: 1.2;">
						INFORME LIQUIDACION FRUTA EMBALADA
					</h1>
					<h2 style="margin: 0; line-height: 1.2;">VENTA COMERCIAL EMBALADA</h2>
				</td>
				
				<td>
					<img class="object-contain" style="height: 100px;" src="{{asset('image/logo.png')}}" alt="">
				</td>
			  </tr>
		</table>

			{{-- Datos Productor --}}
			<table style="width:60%; margin-bottom:30px; border-collapse: collapse;">
				<thead > 
					<tr style="border-bottom: 0px solid #ddd;">
						<td style="text-align: center; padding: 2px;">
							PRODUCTOR
						</td>
						{{--  
						<td style="text-align: center; border: 1px solid black; padding: 2px;">
							{{$razonsocial->rut}}
						</td>
						--}}
						<td style="text-align: center; padding: 2px; font-weight: bold; ">
							{{$razonsocial->name}}
						</td>
					</tr>
				</thead>
			</table>

		
		<table id="balance" style="width:100%; border-collapse: collapse; margin-top: 20px;">
			<thead style="border-top: 2px solid black; border-bottom: 2px solid black;">
			  <tr>
				<th>NORMA</th>
				<th>VARIEDAD</th>
        @if ($informe_edit->semana_comercial=='si')
          <th>SEMANA</th>
          <th></th>
          <th></th>
        @endif
				<th>CALIBRE</th>
				<th>KG EMBALADOS</th>
				<th>TOTAL USD</th>
				<th>NPK</th>
				
			  </tr>
			</thead>
			          @if ($informe_edit->semana_comercial=='si')
                  <tbody>
                      <tr style="background-color: #ddd;">
                              
                          <td style="font-weight: bold;" >MERCADO INTERNO</td>
                      
                      
                      
                          <td> </td>
                          <td> </td>
                        
                        <td></td>
                        
                        <td></td>
                        <td></td>

                        
                        <td></td>
                        <td></td>
                        <td></td>
                        
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
                                        $margen5j_semana += floatval($masa->peso_prorrateado * $tarifafinal * $informe_edit->comision);
                                    }
                                
                                    $costos5j_semana += floatval($masa->costo);
                                
                                    // Versión total (sin _semana)
                                    $cantidad5j += floatval($masa->cantidad);
                                    $pesoneto5j += floatval($masa->peso_prorrateado);
                                
                                    if (!is_null($masa->fob)) {
                                        $retorno5j += floatval($masa->peso_prorrateado * $tarifafinal);
                                        $margen5j += floatval($masa->peso_prorrateado * $tarifafinal * $informe_edit->comision);
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
                                          $margen4j_semana += floatval($masa->peso_prorrateado * $tarifafinal * $informe_edit->comision);
                                      }
                                      $costos4j_semana += floatval($masa->costo);
                                      $totalmateriales4j_semana += floatval($masa->costo);
                                
                                      // Total
                                      $cantidad4j += floatval($masa->cantidad);
                                      $pesoneto4j += floatval($masa->peso_prorrateado);
                                      if (!is_null($masa->fob)) {
                                          $retorno4j += floatval($masa->peso_prorrateado * $tarifafinal);
                                          $margen4j += floatval($masa->peso_prorrateado * $tarifafinal * $informe_edit->comision);
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
                                          $margen3j_semana += floatval($masa->peso_prorrateado * $tarifafinal * $informe_edit->comision);
                                      }
                                      $costos3j_semana += floatval($masa->costo);
                                      $totalmateriales3j_semana += floatval($masa->costo);
                                
                                      $cantidad3j += floatval($masa->cantidad);
                                      $pesoneto3j += floatval($masa->peso_prorrateado);
                                      if (!is_null($masa->fob)) {
                                          $retorno3j += floatval($masa->peso_prorrateado * $tarifafinal);
                                          $margen3j += floatval($masa->peso_prorrateado * $tarifafinal * $informe_edit->comision);
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
                                          $margen2j_semana += floatval($masa->peso_prorrateado * $tarifafinal * $informe_edit->comision);
                                      }
                                      $costos2j_semana += floatval($masa->costo);
                                      $totalmateriales2j_semana += floatval($masa->costo);
                                
                                      $cantidad2j += floatval($masa->cantidad);
                                      $pesoneto2j += floatval($masa->peso_prorrateado);
                                      if (!is_null($masa->fob)) {
                                          $retorno2j += floatval($masa->peso_prorrateado * $tarifafinal);
                                          $margen2j += floatval($masa->peso_prorrateado * $tarifafinal * $informe_edit->comision);
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
                                          $margenj_semana += floatval($masa->peso_prorrateado * $tarifafinal * $informe_edit->comision);
                                      }
                                      $costosj_semana += floatval($masa->costo);
                                      $totalmaterialesj_semana += floatval($masa->costo);
                                
                                      $cantidadj += floatval($masa->cantidad);
                                      $pesonetoj += floatval($masa->peso_prorrateado);
                                      if (!is_null($masa->fob)) {
                                          $retornoj += floatval($masa->peso_prorrateado * $tarifafinal);
                                          $margenj += floatval($masa->peso_prorrateado * $tarifafinal * $informe_edit->comision);
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
                                          $margenxl_semana += floatval($masa->peso_prorrateado * $tarifafinal * $informe_edit->comision);
                                      }
                                      $costosxl_semana += floatval($masa->costo);
                                      $totalmaterialesxl_semana += floatval($masa->costo);
                                
                                      $cantidadxl += floatval($masa->cantidad);
                                      $pesonetoxl += floatval($masa->peso_prorrateado);
                                      if (!is_null($masa->fob)) {
                                          $retornoxl += floatval($masa->peso_prorrateado * $tarifafinal);
                                          $margenxl += floatval($masa->peso_prorrateado * $tarifafinal * $informe_edit->comision);
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
                                            $margenl_semana += floatval($masa->peso_prorrateado * $tarifafinal * $informe_edit->comision);
                                        }
                                        $costosl_semana += floatval($masa->costo);
                                        $totalmaterialesl_semana += floatval($masa->costo);
              
                                        $cantidadl += floatval($masa->cantidad);
                                        $pesonetol += floatval($masa->peso_prorrateado);
                                        if (!is_null($masa->fob)) {
                                            $retornol += floatval($masa->peso_prorrateado * $tarifafinal);
                                            $margenl += floatval($masa->peso_prorrateado * $tarifafinal * $informe_edit->comision);
                                        }
                                        $costosl += floatval($masa->costo);
                                        $totalmaterialesl += floatval($masa->costo);
                                    @endphp
                                @endif
              
                                @if ((strtoupper(trim($masa->calibre_real)) == 'JUP') && $masa->variedad == $variedad)
                                    @php
                                        $cantidadjup_semana += floatval($masa->cantidad);
                                        $pesonetojup_semana += floatval($masa->peso_prorrateado);
                                        if (!is_null($masa->fob)) {
                                            $retornojup_semana += floatval($masa->peso_prorrateado * $tarifafinal);
                                            $retorno_netojup_semana += floatval($masa->peso_prorrateado * $tarifafinal);
                                          // $margenjup_semana += floatval($masa->peso_prorrateado * $tarifafinal * $informe_edit->comision);
                                        }
                                        $costosjup_semana += floatval($masa->costo);
                                        $totalmaterialesjup_semana += floatval($masa->costo);
              
                                        $cantidadjup += floatval($masa->cantidad);
                                        $pesonetojup += floatval($masa->peso_prorrateado);
                                        if (!is_null($masa->fob)) {
                                            $retornojup += floatval($masa->peso_prorrateado * $tarifafinal);
                                            //$margenjup += floatval($masa->peso_prorrateado * $tarifafinal * $informe_edit->comision);
                                        }
                                        $costosjup += floatval($masa->costo);
                                        $totalmaterialesjup += floatval($masa->costo);
                                    @endphp
                                @endif
              
              
                            
                                @if (in_array(strtoupper(trim($masa->calibre_real)), ['JUP']) && $masa->variedad == $variedad)
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
                                    <td style="text-align:right; padding-right:30px; border-left: 1px solid #ddd; white-space: nowrap;">{{ number_format($pesonetojup_semana, 2, ',', '.') }} KG</td>
                                  
                                    {{-- npk --}}
                                    <td style="text-align:right; padding-right:30px; " >
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
                                            {{ number_format($informe_edit->modificaciones->where('categoria','MERCADO INTERNO')->where('variedad',$variedad)->where('calibre','JUP')->where('semana',$semana)->first()->retorno, 2, ',', '.') }} USD
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
                                    
                                    </td>
                                  
                                    {{-- retorno --}}
                                    <td style="text-align:right; padding-right:10px; " >
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
                                            {{ number_format($informe_edit->modificaciones->where('categoria', 'MERCADO INTERNO')->where('variedad', $variedad)->where('calibre', 'JUP')->where('semana',$semana)->first()->npk, 2, ',', '.') }} USD
                                        @else
                                          @if ($pesonetojup_semana)
                                              {{ number_format(($retornojup_semana - ($margenjup_semana + $costosjup_semana)) / $pesonetojup_semana, 2, ',', '.') }} USD
                                          @else
                                            0 USD
                                          @endif
                                        @endif
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
                                  <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; white-space: nowrap; text-align:right; padding-right:30px; ">
                                    {{ number_format($pesonetojup_semana, 2, ',', '.') }} KG
                                  </td>
                                  <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; text-align:right; padding-right:30px; ">
                                    {{ number_format($retorno_netojup_semana, 2, ',', '.') }} USD
                                  </td>
                                  <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; text-align:right; padding-right:10px; ">
                                    {{ number_format(
                                      ($retorno_netojup_semana)
                                      /
                                      ($pesonetojup_semana),
                                      2, ',', '.'
                                    ) }} USD
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
                              <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; white-space: nowrap; text-align:right; padding-right:30px; ">{{number_format($pesonetojup,2,',','.')}} KG</td>
                             
                              <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; text-align:right; padding-right:30px; ">{{number_format(($retorno_netojup),2,',','.')}} USD
                              
                              
                              </td>
                            
                              <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; text-align:right; padding-right:10px; ">{{number_format(($retorno_netojup)/($pesonetojup),2,',','.')}} USD</td>
                              
                            </tr>
                            @php
                                $totalcount+=($retorno_netojup);
                            @endphp
                          @endif
                
                        @endforeach
                      
                    @if ($pesonetototal>0)
                      <tr style="background-color: #ddd;">
                            
                        
                      
                          <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; white-space: nowrap; text-align:left; padding-left:30px; " colspan="4" >TOTAL MERCADO INTERNO</td>
                        
                        
                          <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
                      
                        
                        
                        <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"></td>
                        <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; text-align:right; padding-right:30px; ">{{number_format($pesonetototal,2,',','.')}} KG</td>
                       
                        
                        <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; text-align:right; padding-right:30px; ">{{number_format($totalcount,2,',','.')}} USD 
                      
                        </td>
                        <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; text-align:right; padding-right:10px; ">{{number_format($totalcount/$pesonetototal,2,',','.')}} USD </td>
                        
                      </tr>
                    @endif
              
                    @php
                      $totalemb=($totalcount);
                    @endphp
                      
              
                  </tbody>
                @else
                  <tbody>
                    <tr style="background-color: #ddd;">
                            
                          <td style="font-weight: bold;" >MERCADO INTERNO</td>
                   
                    
                        <td> </td>
                      
                      <td></td>
                      
                      <td></td>
                      <td></td>
                      <td></td>
                     
                      
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
                        <td></td>
                        <td></td>
                        
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
                                
                                @if ((strtoupper(trim($masa->calibre_real))=='JUP') && $masa->variedad==$variedad)
                                  @php
                                    $cantidadjup += $masa->cantidad;
                                    $pesonetojup += floatval($masa->peso_prorrateado);
                                
                                    $costosjup += floatval($masa->costo);
                                    $totalcostosjup += floatval($masa->costo);
                                
                                    if (!IS_NULL($masa->fob)) {
                                      $retornojup += floatval($masa->peso_prorrateado * $tarifafinal);
                                      $totalretornojup += floatval($masa->peso_prorrateado * $tarifafinal);
                                      //$margenjup += floatval($masa->peso_prorrateado * $tarifafinal * $informe_edit->comision);
                                      //$totalmargenjup += floatval($masa->peso_prorrateado * $tarifafinal * $informe_edit->comision);
                                    }
                                
                                    $cantidadtotal += $masa->cantidad;
                                  @endphp	
                                @endif
                              
              
                          
                          @if ( strtoupper(trim($masa->calibre_real))=='JUP')
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
                            <td style="text-align:right; padding-right:30px; border-left: 1px solid #ddd; white-space: nowrap;" >{{number_format($pesonetojup,2,',','.')}} KG</td>
                           
                          
                            <td style="text-align:right; padding-right:30px;" >
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
                                    {{number_format($informe_edit->modificaciones->where('categoria','MERCADO INTERNO')->where('variedad',$variedad)->where('calibre','JUP')->where('semana','no')->first()->retorno, 2, ',', '.') }} USD
                                  @php
                                      $retorno_netojup = $informe_edit->modificaciones->where('categoria','MERCADO INTERNO')->where('variedad',$variedad)->where('calibre','JUP')->where('semana','no')->first()->retorno;
                                  @endphp
                                @else
                                  {{ number_format(($retornojup - ($margenjup + $costosjup)), 2, ',', '.') }} USD
                                  @php
                                      $retorno_netojup = ($retornojup - ($margenjup + $costosjup));
                                  @endphp
                                @endif
                              @endif
                          
                             
                            </td>
                            <td style="text-align:right; padding-right:10px; ">
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
                                    {{number_format($informe_edit->modificaciones->where('categoria','MERCADO INTERNO')->where('variedad',$variedad)->where('calibre','JUP')->where('semana','no')->first()->npk, 2, ',', '.') }} USD
                                @else
                                  @if ($pesonetojup)
                                        {{ number_format(($retornojup - ($margenjup + $costosjup)) / $pesonetojup, 2, ',', '.') }} USD
                                  @else
                                      0 USD
                                  @endif
                                @endif
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
                          <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; text-align:right; padding-right:30px; ">{{number_format($pesonetojup,2,',','.')}} KG</td>
                         
                          <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; text-align:right; padding-right:30px; ">{{number_format(($retorno_netojup),2,',','.')}} USD
                          
                          
                        </td>
                          <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; text-align:right; padding-right:10px; ">{{number_format(($retorno_netojup)/($pesonetojup),2,',','.')}} USD</td>
                          
                        </tr>
                      @endif 
                        @php
                          $totalcount+=($retorno_netojup);
                          $variedadcount+=1;
                        @endphp
                      
              
                    @endforeach
                  
                    @if ($pesonetototal>0)
                      <tr style="background-color: #ddd;">
                            
                        
                      
                          <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; white-space: nowrap;" >TOTAL MERCADO INTERNO</td>
                        
                          <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
                      
                        
                        
                        <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"></td>
                        <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; text-align:right; padding-right:30px;">{{number_format($pesonetototal,2,',','.')}} KG</td>
                       
                        
                        <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; text-align:right; padding-right:30px;">{{number_format($totalcount,2,',','.')}} USD 
                      
                        </td>
                        <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; text-align:right; padding-right:10px;">{{number_format($totalcount/$pesonetototal,2,',','.')}} USD </td>
                        
                      </tr>
                    @endif
              
                    @php
                      $totalemb=($totalcount);
                    @endphp
                      
              
                  </tbody>
                @endif

                @php
                  $totalembalada=$totalemb;
                @endphp
		</table>

		<div class="page-break"></div>

		<table style="width:100%; border-collapse: collapse; margin-bottom: 30px; margin-top: 30px; border: none;">
        <tr style="text-align: left; border: none;">
            <td style="border: none;">
                <h1 style="color: red; margin: 0; line-height: 1.2; text-align: left; ">
                    INFORME ANALISIS MULTIRESIDUOS
                </h1>
            </td>
            <td style="border: none;">
                <img class="object-contain" style="height: 100px;" src="{{ asset('image/logo.png') }}" alt="">
            </td>
        </tr>
    </table>

    <table style="width:60%; margin-bottom:30px; border-collapse: collapse; border: none;">
        <thead> 
            <tr style="border: none;">
                <td style="text-align: center; padding: 2px; border: none;">
                    PRODUCTOR
                </td>
                <td style="text-align: center; padding: 2px; font-weight: bold; border: none;">
                    {{$razonsocial->name}}
                </td>
            </tr>
        </thead>
    </table>


		<table id="balance" style="width:100%; border-collapse: collapse; margin-top: 20px;">
			<thead style="border-top: 2px solid black; border-bottom: 2px solid black;">
			  <tr style="border: 1px solid black; font-weight: bold;">
				<th>FECHA</th>
				<th style="text-align:left;">DETALLE</th>
				<th>USD</th>
				
			  </tr>
			</thead>
			<tbody>
				@php
					$totalgastos=0;
				@endphp

				@foreach ($analisis as $detalle)
								
								<tr>
								
									<td style="text-align: left; padding-left: 0px; padding-bottom: 4px; margin-top: 30px;">{{ date('d-m-Y', strtotime($detalle->fecha)) }}</td>
									<td style="text-align: left; padding-left: 0px; padding-bottom: 4px; margin-top: 10px;">ANALISIS MULTIRESIDUOS</td>
									<td style="padding-bottom: 4px; margin-top: 10px;">{{number_format($detalle->dolar,2,',','.')}} USD</td>
							
								</tr>
								@php
									$totalgastos+=floatval($detalle->dolar);
								@endphp
				@endforeach

				<tr style="background-color: #ddd; " >
								
					<td style="font-weight: bold; padding-bottom: 4px; margin-top: 10px;">TOTAL</td>
					<td style="font-weight: bold; padding-bottom: 4px; margin-top: 10px;"></td>
					<td style="font-weight: bold; padding-bottom: 4px; margin-top: 10px;">{{number_format($totalgastos,2,',','.')}} USD</td>
			
				</tr>
			
			@php
				$multiresiduos=$totalgastos;
			@endphp
					

			</tbody>
		</table>

		<table style="width:100%;border-collapse: collapse; margin-bottom: 30px; margin-top: 30px;">
		
			<tr style="text-align: left; border-bottom: 0px solid #ddd;">
				<td style="text-align: left;">
					<h1 style="color: red;margin: 0; line-height: 1.2;">
						INFORME CERTIFICACIONES
					</h1>
				</td>
				
				
			  </tr>
		</table>
      <table style="width:60%; margin-bottom:30px; border-collapse: collapse; border: none;">
        <thead> 
            <tr style="border: none;">
                <td style="text-align: center; padding: 2px; border: none;">
                    PRODUCTOR
                </td>
                <td style="text-align: center; padding: 2px; font-weight: bold; border: none;">
                    {{$razonsocial->name}}
                </td>
            </tr>
        </thead>
    </table>

		<table id="balance" style="width:100%; border-collapse: collapse; margin-top: 20px;">
			<thead style="border-top: 2px solid black; border-bottom: 2px solid black;">
			  <tr style="border: 1px solid black; font-weight: bold;">
				<th>FECHA</th>
				<th style="text-align:left;">DETALLE</th>
				<th style="text-align:right;">CANTIDAD</th>
				<th style="text-align:right; padding-right: 20px; ">PRECIO</th>
				<th style="text-align:right; padding-right: 20px;">USD</th>
				
			  </tr>
			</thead>
			<tbody>
				@php
					$totalgastos=0;
				@endphp
						@foreach ($certificacions as $detalle)
								
								<tr>
								
									<td style="text-align: left; padding-left: 0px; padding-bottom: 4px; margin-top: 30px;">{{  date('d-m-Y', strtotime($detalle->fecha)) }}</td>
									<td style="text-align: left; padding-left: 0px; padding-bottom: 4px; margin-top: 10px;">{{$detalle->material}}</td>
									<td style="text-align: right; padding-right: 20px; padding-bottom: 4px; margin-top: 10px;">{{$detalle->cant}}</td>
									<td style="text-align: right; padding-right: 20px; padding-bottom: 4px; margin-top: 10px;">{{number_format($detalle->precio,2,',','.')}} USD</td>
									@if ($detalle->dolar>0)
										<td style="text-align: right; padding-right: 15px; padding-bottom: 4px; margin-top: 10px;">{{number_format($detalle->dolar,2,',','.')}} USD</td>
									@else
										<td style="text-align: right; padding-right: 15px; padding-bottom: 4px; margin-top: 10px;">({{number_format($detalle->dolar,2,',','.')}}) USD</td>
									@endif
									
							
								</tr>
								@php
									$totalgastos+=floatval($detalle->dolar);
								@endphp
						@endforeach
						
				<tr style="background-color: #ddd; " >
								
					<td style="font-weight: bold; padding-bottom: 4px; margin-top: 10px;">TOTAL</td>
					<td style="font-weight: bold; padding-bottom: 4px; margin-top: 10px;"></td>
					<td style="font-weight: bold; padding-bottom: 4px; margin-top: 10px;"></td>
					<td style="font-weight: bold; padding-bottom: 4px; margin-top: 10px;"></td>
					<td style="text-align: right; padding-right: 15px; padding-bottom: 4px; margin-top: 10px;font-weight: bold;">{{number_format($totalgastos,2,',','.')}} USD</td>
			
				</tr>
			
				@php
					$certificaciones=$totalgastos;
				@endphp
					

			</tbody>
		</table>

	

		<table style="width:100%;border-collapse: collapse; margin-bottom: 30px; margin-top: 30px;">
		
			<tr style="text-align: left; border-bottom: 0px solid #ddd;">
				<td style="text-align: left;">
					<h1 style="color: red;margin: 0; line-height: 1.2;">
						INFORME MATERIALES DE COSECHA ADEUDADOS
					</h1>
				</td>
				
				
			  </tr>
		</table>
      <table style="width:60%; margin-bottom:30px; border-collapse: collapse; border: none;">
        <thead> 
            <tr style="border: none;">
                <td style="text-align: center; padding: 2px; border: none;">
                    PRODUCTOR
                </td>
                <td style="text-align: center; padding: 2px; font-weight: bold; border: none;">
                    {{$razonsocial->name}}
                </td>
            </tr>
        </thead>
    </table>

		<table id="balance" style="width:100%; border-collapse: collapse; margin-top: 20px;">
			<thead style="border-top: 2px solid black; border-bottom: 2px solid black;">
			  <tr style="border: 1px solid black; font-weight: bold;">
				<th>FECHA</th>
				<th style="text-align:left;">DETALLE</th>
				<th style="text-align:right;">CANTIDAD</th>
				<th style="text-align:right; padding-right: 20px; ">PRECIO</th>
				<th style="text-align:right; padding-right: 20px;">USD</th>
				
			  </tr>
			</thead>
			<tbody>
				@php
					$totalgastos=0;
				@endphp
						@foreach ($materials as $detalle)
								
								<tr>
								
									<td style="text-align: left; padding-left: 0px; padding-bottom: 4px; margin-top: 30px;">{{  date('d-m-Y', strtotime($detalle->fecha)) }}</td>
									<td style="text-align: left; padding-left: 0px; padding-bottom: 4px; margin-top: 10px;">{{$detalle->material}}</td>
									<td style="text-align: right; padding-right: 20px; padding-bottom: 4px; margin-top: 10px;">{{$detalle->cantidad}}</td>
									<td style="text-align: right; padding-right: 20px; padding-bottom: 4px; margin-top: 10px;">{{number_format($detalle->precio,2,',','.')}} USD</td>
									@if ($detalle->dolar>0)
										<td style="text-align: right; padding-right: 15px; padding-bottom: 4px; margin-top: 10px;">{{number_format($detalle->dolar,2,',','.')}} USD</td>
									@else
										<td style="text-align: right; padding-right: 15px; padding-bottom: 4px; margin-top: 10px;">({{number_format($detalle->dolar,2,',','.')}}) USD</td>
									@endif
									
							
								</tr>
								@php
									$totalgastos+=floatval($detalle->dolar);
								@endphp
						@endforeach
						
				<tr style="background-color: #ddd; " >
								
					<td style="font-weight: bold; padding-bottom: 4px; margin-top: 10px;">TOTAL</td>
					<td style="font-weight: bold; padding-bottom: 4px; margin-top: 10px;"></td>
					<td style="font-weight: bold; padding-bottom: 4px; margin-top: 10px;"></td>
					<td style="font-weight: bold; padding-bottom: 4px; margin-top: 10px;"></td>
					<td style="text-align: right; padding-right: 15px; padding-bottom: 4px; margin-top: 10px;font-weight: bold;">{{number_format($totalgastos,2,',','.')}} USD</td>
			
				</tr>
			
				@php
					$materiales=$totalgastos;
				@endphp
					

			</tbody>
		</table>

		<div class="page-break"></div>

		<table style="width:100%;border-collapse: collapse; margin-bottom: 30px; margin-top: 30px;">
		
			<tr style="text-align: left; border-bottom: 0px solid #ddd;">
				<td style="text-align: left;">
					<h1 style="color: red;margin: 0; line-height: 1.2;">
						ANTICIPOS OTORGADOS
					</h1>
				</td>
				
				<td>
					<img class="object-contain" style="height: 100px;" src="{{asset('image/logo.png')}}" alt="">
				</td>
			  </tr>
		</table>
    <table style="width:60%; margin-bottom:30px; border-collapse: collapse; border: none;">
        <thead> 
            <tr style="border: none;">
                <td style="text-align: center; padding: 2px; border: none;">
                    PRODUCTOR
                </td>
                <td style="text-align: center; padding: 2px; font-weight: bold; border: none;">
                    {{$razonsocial->name}}
                </td>
            </tr>
        </thead>
    </table>
		<table id="balance" style="width:100%; border-collapse: collapse; margin-top: 20px;">
			<thead style="border-top: 2px solid black; border-bottom: 2px solid black;">
			  <tr style="border: 1px solid black; font-weight: bold;">
				<th>FECHA</th>
				<th>DETALLE</th>
				<th>USD</th>
				<th>TIPO DE CAMBIO</th>
				<th>CLP</th>
				
			  </tr>
			</thead>
			<tbody>
				@php
					$totalgastos=0;
					$totalgastosclp=0;
				@endphp
				@foreach ($anticipos as $anticipo)
								
								<tr>
								
									<td style=" padding-bottom: 4px; margin-top: 10px;">{{ date('d-m-Y', strtotime($anticipo->fecha)) }}</td>
									<td style=" padding-bottom: 4px; margin-top: 10px;"> {{$anticipo->detalle}}</td>
									<td style=" padding-bottom: 4px; margin-top: 10px;">{{number_format(floatval($anticipo->cantidad_usd),2,',','.')}} USD</td>
									
									@if ($anticipo->tipo_cambio)
										<td style=" padding-bottom: 4px; margin-top: 10px;">{{$anticipo->tipo_cambio}}</td>
									@else
										<td style=" padding-bottom: 4px; margin-top: 10px;"> - </td>
									@endif
								
									@if ($anticipo->tipo_cambio)
										<td style=" padding-bottom: 4px; margin-top: 10px;">{{number_format(floatval($anticipo->total),2,',','.')}} CLP</td>
									@elseif($anticipo->tipo_cambio==0)
										<td style=" padding-bottom: 4px; margin-top: 10px;"> - </td>
									@else
										<td style=" padding-bottom: 4px; margin-top: 10px;"> - </td>
									@endif
									
								</tr>
								@php
									$totalgastos+=floatval($anticipo->cantidad_usd);
									$totalgastosclp+=floatval($anticipo->total);
								@endphp
							
				@endforeach
				<tr style="background-color: #ddd;">
								
					<td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">TOTAL</td>
					<td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"></td>
					<td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format($totalgastos,2,',','.')}} USD</td>
					<td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">-</td>
					
					@if($totalgastosclp==0)
						<td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">-</td>
					@else
						<td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format($totalgastosclp,2,',','.')}} CLP</td>
					@endif
					
			
				</tr>
			

				@php
					$totalanticipos=$totalgastos;
				@endphp

			</tbody>
		</table>

		<div class="page-break"></div>

		<table style="width:100%;border-collapse: collapse; margin-bottom: 30px; margin-top: 30px;">
		
			<tr style="text-align: left; border-bottom: 0px solid #ddd;">
				<td style="text-align: left;">
					<h1 style="color: red;margin: 0; line-height: 1.2;">
						RESUMEN LIQUIDACIÓN
					</h1>
					<h2 style="margin: 0; line-height: 1.2;">{{$temporada->name}}</h2>
				</td>
				
				<td>
					<img class="object-contain" style="height: 100px;" src="{{asset('image/logo.png')}}" alt="">
				</td>
			  </tr>
		</table>
    <table style="width:60%; margin-bottom:30px; border-collapse: collapse; border: none;">
        <thead> 
            <tr style="border: none;">
                <td style="text-align: center; padding: 2px; border: none;">
                    PRODUCTOR
                </td>
                <td style="text-align: center; padding: 2px; font-weight: bold; border: none;">
                    {{$razonsocial->name}}
                </td>
            </tr>
        </thead>
    </table>

		<table id="balance" style="width:100%; border-collapse: collapse; margin-top: 20px;">
			<thead style="border-top: 2px solid black; border-bottom: 2px solid black;">
			  <tr style="border: 1px solid black; font-weight: bold; text-align: left;">
				<th style="text-align: left; padding-left: 25px; ">CONCEPTO</th>
		
				<th>MONTO</th>
				
			  </tr>
			</thead>
			<tbody>
								<tr>
								
									<td style="text-align: left; padding-left: 0px; padding-bottom: 4px; margin-top: 10px;">NETO PRODUCTOR FRUTA EXPORTACIÓN DENTRO DE NORMA</td>
									<td style="padding-bottom: 4px; margin-top: 10px; text-align: right; padding-right: 10">{{number_format($totaldentrodenorma,2,',','.')}} USD</td>
							
								</tr>
								<tr>
								
									<td style="text-align: left; padding-left: 0px; padding-bottom: 4px; margin-top: 10px;">NETO PRODUCTOR FRUTA EXPORTACIÓN FUERA DE NORMA</td>
									<td style="padding-bottom: 4px; margin-top: 10px; text-align: right; padding-right: 10">{{number_format($totalfueradenorma,2,',','.')}} USD</td>
							
								</tr>
								<tr>
								
									<td style="text-align: left; padding-left: 0px; padding-bottom: 4px; margin-top: 10px;">NETO PRODUCTOR FRUTA COMERCIAL EMBALADA</td>
									<td style="padding-bottom: 4px; margin-top: 10px; text-align: right; padding-right: 10">{{number_format($totalembalada,2,',','.')}} USD</td>
							
								</tr>

								<tr style="background-color: #ddd;">
								
									<td style="text-align: left; padding-left: 0px; padding-bottom: 4px; margin-top: 10px; font-weight: bold; ">SUBTOTAL</td>
									<td style="padding-bottom: 4px; margin-top: 10px; text-align: right; padding-right: 10; font-weight: bold;">{{number_format(($totaldentrodenorma+$totalfueradenorma+$totalembalada),2,',','.')}} USD</td>
							
								</tr>
								<tr style="border: none;" >
									<td style="height: 12px;">

									</td>
                  <td>

                  </td>
								</tr>
								<tr>
								
									<td style="text-align: left; padding-left: 0px; padding-bottom: 4px; margin-top: 10px;">RESULTADO COMERCIALIZACIÓN FRUTA MERCADO COMERCIAL</td>
									<td style="padding-bottom: 4px; margin-top: 10px; text-align: right; padding-right: 10">{{number_format($resultadocomercial,2)}} USD</td>
							
								</tr>
								
								<tr>
								
									<td style="text-align: left; padding-left: 0px; padding-bottom: 4px; margin-top: 10px;">ANALISIS MULTIRESIDUOS</td>
									<td style="padding-bottom: 4px; margin-top: 10px; text-align: right; padding-right: 10">-{{number_format($multiresiduos,2,',','.')}} USD</td>
							
								</tr>
								<tr>
								
									<td style="text-align: left; padding-left: 0px; padding-bottom: 4px; margin-top: 10px;">CERTIFICACIÓN</td>
									<td style="padding-bottom: 4px; margin-top: 10px; text-align: right; padding-right: 10">-{{number_format($certificaciones,2,',','.')}} USD</td>
							
								</tr>
								<tr>
								
									<td style="text-align: left; padding-left: 0px; padding-bottom: 4px; margin-top: 10px;">MATERIALES COSECHA</td>
									<td style="padding-bottom: 4px; margin-top: 10px; text-align: right; padding-right: 10">-{{number_format($materiales,2,',','.')}} USD</td>
							
								</tr>
								<tr style="border: none;" >
									<td style="height: 12px;">

									</td>
                  <td>
                    
                  </td>
								</tr>
								<tr style="background-color: #ddd;">
								
									<td style="text-align: left; padding-left: 0px; padding-bottom: 4px; margin-top: 10px; font-weight: bold; ">SUBTOTAL EGRESOS</td>
									<td style="padding-bottom: 4px; margin-top: 10px; text-align: right; padding-right: 10; font-weight: bold;">{{number_format($resultadocomercial-$materiales-$certificaciones-$multiresiduos,2)}} USD</td>
							
								</tr>
								<tr style="border: none;" >
									<td style="height: 12px;">

									</td>
                  <td>
                    
                  </td>
								</tr>
								<tr style="background-color: #ddd;">
								
									<td style="text-align: left; padding-left: 0px; padding-bottom: 4px; margin-top: 10px; font-weight: bold; ">TOTAL LIQUIDACIÓN</td>
									<td style="padding-bottom: 4px; margin-top: 10px; text-align: right; padding-right: 10; font-weight: bold;">{{number_format(($totaldentrodenorma+$totalfueradenorma+$totalembalada-$materiales-$certificaciones-$multiresiduos+$resultadocomercial),2)}} USD</td>
							
								</tr>
								<tr>
								
									<td style="text-align: left; padding-left: 0px; padding-bottom: 4px; margin-top: 10px;">ANTICIPOS OTORGADOS</td>
									<td style="padding-bottom: 4px; margin-top: 10px; text-align: right; padding-right: 10">-{{number_format($totalanticipos,2,',','.')}} USD</td>
							
								</tr>
								<tr style="background-color: #ddd;">
								
									<td style="text-align: left; padding-left: 0px; padding-bottom: 4px; margin-top: 10px; font-weight: bold; ">SALDO A PAGAR</td>
									<td style="padding-bottom: 4px; margin-top: 10px; text-align: right; padding-right: 10; font-weight: bold;">{{number_format($totaldentrodenorma+$totalfueradenorma+$totalembalada-$materiales-$certificaciones-$multiresiduos+$resultadocomercial-$totalanticipos,2)}} USD</td>
							
								</tr>


								
								
								


			</tbody>
		</table>

		
		
	</body>
</html>