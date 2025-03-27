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
		font-size: 9px;
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

	<div class="cuerpo">
		<table style="width:100%;border-collapse: collapse; margin-bottom: 30px; margin-top: 30px; display: none;">
		
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
		<table style="width:60%; margin-bottom:30px; border-collapse: collapse; display: none;">
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
					<td style="text-align: center; padding: 2px;">
						{{$razonsocial->name}}
					</td>
				</tr>
			</thead>
		</table>

		
		<table id="balance" style="width:100%; border-collapse: collapse; margin-top: 20px; display: none;">
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


		
		<table style="width:100%;border-collapse: collapse; margin-bottom: 30px; margin-top: 30px; display: none;">
		
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
			<table style="width:60%; margin-bottom:30px; border-collapse: collapse; display: none;">
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
						<td style="text-align: center; padding: 2px;">
							{{$razonsocial->name}}
						</td>
					</tr>
				</thead>
			</table>

		<table id="balance" style="width:100%; border-collapse: collapse; margin-top: 20px; display: none;">
			<thead style="border-top: 2px solid black; border-bottom: 2px solid black;">
			  <tr>
				<th>NORMA</th>
				<th>VARIEDAD</th>
				<th>CALIBRE</th>
				<th>KG EMBALADO</th>
				<th>RETORNO NETO PRODUCTOR</th>
				<th>NPK</th>
				
			  </tr>
			</thead>
			<tbody>
			  <tr style="background-color: #ddd;">
					  
				  <td> DENTRO DE NORMA </td>
			  
			  
				  <td> </td>
				
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
	  
				@foreach ($masas as $masa)
				  
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
					
					@if ($masa->calibre_real=='4J' || $masa->calibre_real=='3J'|| $masa->calibre_real=='2J' || $masa->calibre_real=='J' || $masa->calibre_real=='XL')
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
					  <td style="text-align:right; padding-right:30px;border-left: 1px solid #ddd;" >{{number_format($pesoneto4j,0,',','.')}} KG</td>
					 
					  <td style="text-align:right; padding-right:30px;border-left: 1px solid #ddd;" >
							@if ($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','4J')->count()>0)
                                  {{number_format($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','4J')->first()->retorno, 2, ',', '.') }} USD
                                  @php
                                      $retorno_neto4j=$informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','4J')->first()->retorno;
                                  @endphp
                            @elseif ($pesoneto4j)
                                {{ number_format(($retorno4j - ($margen4j + $costos4j)), 2, ',', '.') }} USD <br>
                                @php
                                    $retorno_neto4j=($retorno4j - ($margen4j + $costos4j));
                                @endphp
                            @endif
					  </td>
					  
					  <td style="text-align:right; padding-right:20px;border-left: 1px solid #ddd;">
						@if ($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','4J')->count()>0)
								{{number_format($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','4J')->first()->retorno/$pesoneto4j, 2, ',', '.') }} USD
								
						@elseif ($pesoneto4j)
							{{ number_format(($retorno4j - ($margen4j + $costos4j))/$pesoneto4j, 2, ',', '.') }} USD <br>
							
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
					  <td style="text-align:right; padding-right:30px;border-left: 1px solid #ddd;" >{{number_format($pesoneto3j,0,',','.')}} KG</td>
					 
					  <td style="text-align:right; padding-right:30px;border-left: 1px solid #ddd;" >
							@if ($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','3J')->count()>0)
								{{number_format($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','3J')->first()->retorno, 2, ',', '.') }} USD
								@php
									$retorno_neto3j=$informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','3J')->first()->retorno;
								@endphp
							@elseif ($pesoneto3j)
								{{ number_format(($retorno3j - ($margen3j + $costos3j)), 2, ',', '.') }} USD <br>
								@php
									$retorno_neto3j=($retorno3j - ($margen3j + $costos3j));
								@endphp
							@endif
					</td>
					
					<td style="text-align:right; padding-right:20px;border-left: 1px solid #ddd;">
						@if ($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','3J')->count()>0)
								{{number_format($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','3J')->first()->retorno/$pesoneto3j, 2, ',', '.') }} USD
								
						@elseif ($pesoneto3j)
							{{ number_format(($retorno3j - ($margen3j + $costos3j))/$pesoneto3j, 2, ',', '.') }} USD <br>
							
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
					  <td style="text-align:right; padding-right:30px;border-left: 1px solid #ddd;" >{{number_format($pesoneto2j,0,',','.')}} KG</td>
					 
					  <td style="text-align:right; padding-right:30px;border-left: 1px solid #ddd;" >
								@if ($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','2J')->count()>0)
									{{number_format($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','2J')->first()->retorno, 2, ',', '.') }} USD
									@php
										$retorno_neto2j=$informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','2J')->first()->retorno;
									@endphp
								@elseif ($pesoneto2j)
									{{ number_format(($retorno2j - ($margen2j + $costos2j)), 2, ',', '.') }} USD <br>
									@php
										$retorno_neto2j=($retorno2j - ($margen2j + $costos2j));
									@endphp
								@endif
						</td>
						
						<td style="text-align:right; padding-right:20px;border-left: 1px solid #ddd;">
							@if ($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','2J')->count()>0)
									{{number_format($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','2J')->first()->retorno/$pesoneto2j, 2, ',', '.') }} USD
									
							@elseif ($pesoneto2j)
								{{ number_format(($retorno2j - ($margen2j + $costos2j))/$pesoneto2j, 2, ',', '.') }} USD <br>
								
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
					  <td style="text-align:right; padding-right:30px; border-left: 1px solid #ddd;" >{{number_format($pesonetoj,0,',','.')}} KG</td>
					 
					  	<td style="text-align:right; padding-right:30px;border-left: 1px solid #ddd;" >
								@if ($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','J')->count()>0)
									{{number_format($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','J')->first()->retorno, 2, ',', '.') }} USD
									@php
										$retorno_netoj=$informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','J')->first()->retorno;
									@endphp
								@elseif ($pesonetoj)
									{{ number_format(($retornoj - ($margenj + $costosj)), 2, ',', '.') }} USD <br>
									@php
										$retorno_netoj=($retornoj - ($margenj + $costosj));
									@endphp
								@endif
						</td>
						
						<td style="text-align:right; padding-right:20px;border-left: 1px solid #ddd;">
							@if ($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','J')->count()>0)
									{{number_format($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','J')->first()->retorno/$pesonetoj, 2, ',', '.') }} USD
									
							@elseif ($pesonetoj)
								{{ number_format(($retornoj - ($margenj + $costosj))/$pesonetoj, 2, ',', '.') }} USD <br>
								
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
					  <td style="text-align:right; padding-right:30px; border-left: 1px solid #ddd; " >{{number_format($pesonetoxl,0,',','.')}} KG</td>
					
					  	<td style="text-align:right; padding-right:30px;border-left: 1px solid #ddd;" >
								@if ($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','XL')->count()>0)
									{{number_format($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','XL')->first()->retorno, 2, ',', '.') }} USD
									@php
										$retorno_netoxl=$informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','XL')->first()->retorno;
									@endphp
								@elseif ($pesonetoxl)
									{{ number_format(($retornoxl - ($margenxl + $costosxl)), 2, ',', '.') }} USD <br>
									@php
										$retorno_netoxl=($retornoxl - ($margenxl + $costosxl));
									@endphp
								@endif
						</td>
						
						<td style="text-align:right; padding-right:20px;border-left: 1px solid #ddd;">
							@if ($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','XL')->count()>0)
									{{number_format($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','XL')->first()->retorno/$pesonetoxl, 2, ',', '.') }} USD
									
							@elseif ($pesonetoxl)
								{{ number_format(($retornoxl - ($margenxl + $costosxl))/$pesonetoxl, 2, ',', '.') }} USD <br>
								
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
					<td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">TOTAL {{$variedad}}</td>
					<td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
					<td style="text-align:right; padding-right:30px; border-left: 1px solid #ddd;font-weight: bold;">{{number_format($pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl,2,',','.')}} KG</td>
					
					<td style="text-align:right; padding-right:30px;border-left: 1px solid #ddd; font-weight: bold;" >{{number_format(($retorno_neto4j+$retorno_neto3j+$retorno_neto2j+$retorno_netoj+$retorno_netoxl),2,',','.')}} USD 
					
					
				  </td>
					<td style="text-align:right; padding-right:20px;border-left: 1px solid #ddd; font-weight: bold;">{{number_format(($retorno_neto4j+$retorno_neto3j+$retorno_neto2j+$retorno_netoj+$retorno_netoxl)/($pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl),2,',','.')}} USD</td>
					
				  </tr>
				@endif
				  @php
					$totalcount+=($retorno_neto4j+$retorno_neto3j+$retorno_neto2j+$retorno_netoj+$retorno_netoxl);
					$variedadcount+=1;
				  @endphp
				
	  
			  @endforeach
			
			  @if ($pesonetototal>0)
				<tr style="background-color: #ddd;">
					  
				  
				
					<td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">TOTAL DENTRO DE NORMA</td>
				  
				  
					<td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
				
				  
				  
				  <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"></td>
				  <td style="text-align:right; padding-right:30px; border-left: 1px solid #ddd;font-weight: bold;" >{{number_format($pesonetototal,1,',','.')}} KG</td>
				
				  
				  <td style="text-align:right; padding-right:30px;border-left: 1px solid #ddd;  font-weight: bold;">{{number_format($totalcount,2,',','.')}} USD 
				
				  </td>
				  <td style="text-align:right; padding-right:20px;border-left: 1px solid #ddd; font-weight: bold;">{{number_format($totalcount/$pesonetototal,2,',','.')}} USD </td>
				  
				</tr>
			  @endif
	  
			  @php
				$totaldentrodenorma=($totalcount);
			  @endphp
				
	  
			</tbody>
		  </table>

	
		<table style="width:100%;border-collapse: collapse; margin-bottom: 30px; margin-top: 30px; display: none;">
		
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
			<table style="width:60%; margin-bottom:30px; border-collapse: collapse; display: none;">
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
						<td style="text-align: center; padding: 2px;">
							{{$razonsocial->name}}
						</td>
					</tr>
				</thead>
			</table>

		
		<table id="balance" style="width:100%; border-collapse: collapse; margin-top: 20px; display: none;">
			<thead style="border-top: 2px solid black; border-bottom: 2px solid black;">
			  <tr>
				<th>NORMA</th>
				<th>VARIEDAD</th>
				<th>CALIBRE</th>
				<th>KG EMBALADO</th>
				<th>RETORNO NETO PRODUCTOR</th>
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
					$totalotroscostos+=($otroscostos)*(($pesonetol)/($masatotal));
					
					$globaltotalotroscostos+=$totalotroscostos;
				@endphp
	  
				@if ($cantidad4j+$cantidad3j+$cantidad2j+$cantidadj+$cantidadxl+$cantidadl>0)
				  
				
				@if ($pesonetol>0)
				  <tr>
					<td> </td>
					<td> </td>
					
					
					
					
					<td>L</td>
					<td style="text-align:right; padding-right:30px; border-left: 1px solid #ddd; " >{{number_format($pesonetol,0,',','.')}} KG</td>
				
					<td style="text-align:right; padding-right:30px;border-left: 1px solid #ddd;" >
						@if ($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','L')->count()>0)
							  {{number_format($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','L')->first()->retorno, 2, ',', '.') }} USD
							  @php
								  $retorno_netol=$informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','L')->first()->retorno;
							  @endphp
						@elseif ($pesonetol)
							{{ number_format(($retornol - ($margenl + $costosl)), 2, ',', '.') }} USD <br>
							@php
								$retorno_netol=($retornol - ($margenl + $costosl));
							@endphp
						@endif
				  </td>
				  
				  <td style="text-align:right; padding-right:20px;border-left: 1px solid #ddd;">
					@if ($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','L')->count()>0)
							{{number_format($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','L')->first()->retorno/$pesonetol, 2, ',', '.') }} USD
							
					@elseif ($pesonetol)
						{{ number_format(($retornol - ($margenl + $costosl))/$pesonetol, 2, ',', '.') }} USD <br>
						
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
					<td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">TOTAL {{$variedad}}</td>
					<td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
					<td style="text-align:right; padding-right:30px;border-left: 1px solid #ddd;">{{number_format($pesonetol,0,',','.')}} KG</td>
					
					<td style="text-align:right; padding-right:30px;border-left: 1px solid #ddd; font-weight: bold;">{{number_format(($retorno_netol),2,',','.')}} USD 
					
					
				  </td>
					<td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format(($retorno_netol)/($pesonetol),2,',','.')}} USD</td>
					
				  </tr>
				@endif
				  @php
					$totalfr+=($retorno_netol);
					$variedadcount+=1;
				  @endphp
				
	  
			  @endforeach
			
			  @if ($pesonetototal>0)
				
			  <tr style="background-color: #ddd;">
					
				
			  
				  <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">TOTAL FUERA DE NORMA</td>
				
				
				  <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
			  
				
				
				<td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"></td>
				<td style="text-align:right; padding-right:30px;border-left: 1px solid #ddd; font-weight: bold;">{{number_format($pesonetototal,0,',','.')}} KG</td>
				
				<td style="text-align:right; padding-right:30px;border-left: 1px solid #ddd; font-weight: bold;">{{number_format($totalfr,2,',','.')}} USD 
			   
				</td>
				<td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format($totalfr/$pesonetototal,2,',','.')}} USD </td>
				
			  </tr>
			  @endif
	  
			  @php
				
				$totalfueradenorma=$totalfr;
			  @endphp
				
	  
			</tbody>
		</table>

	
		<table style="width:100%;border-collapse: collapse; margin-bottom: 30px; margin-top: 30px; display: none;">
		
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
			<table style="width:60%; margin-bottom:30px; border-collapse: collapse; display: none;">
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
						<td style="text-align: center; padding: 2px;">
							{{$razonsocial->name}}
						</td>
					</tr>
				</thead>
			</table>

		
		<table id="balance" style="width:100%; border-collapse: collapse; margin-top: 20px; display: none;">
			<thead style="border-top: 2px solid black; border-bottom: 2px solid black;">
			  <tr>
				<th>NORMA</th>
				<th>VARIEDAD</th>
				<th>CALIBRE</th>
				<th>KG EMBALADO</th>
				<th>RETORNO NETO PRODUCTOR</th>
				<th>NPK</th>
				
			  </tr>
			</thead>
			<tbody>
			  <tr style="background-color: #ddd;">
					  
				  <td> COMERCIAL EMBALADA </td>
			  
			  
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

				  $totalemb=0;
				  
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
				  @php
					  if (!IS_NULL($masa->fob)) {
							$tarifafinal=0;
						
							if ($masa->fob->tarifas->count()>0) {
								
								$tarifafinal=$masa->fob->tarifas->reverse()->first()->tarifa_fc;
								
							}
						}
				  @endphp
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
					
					@if (($masa->calibre_real=='JUP') && $masa->variedad==$variedad)
					  @php
						$cantidadjup+=$masa->cantidad;
						$pesonetojup+=floatval($masa->peso_prorrateado);

						$margenjup+=floatval($masa->margen);
						$totalmargenjup+=floatval($masa->margen);

						$costosjup+=floatval($masa->costo);
						$totalcostosjup+=floatval($masa->costo);

						if (!IS_NULL($masa->fob)) {
						  $retornojup+=floatval($masa->peso_prorrateado*$tarifafinal);
						  $totalretornojup+=floatval($masa->peso_prorrateado*$tarifafinal);
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
							<td style="text-align:right; padding-right:30px; border-left: 1px solid #ddd; " >{{number_format($pesonetojup,0,',','.')}} KG</td>
						
							<td style="text-align:right; padding-right:30px;border-left: 1px solid #ddd;" >
									@if ($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','JUP')->count()>0)
										{{number_format($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','JUP')->first()->retorno, 2, ',', '.') }} USD
										@php
											$retorno_netojup=$informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','JUP')->first()->retorno;
										@endphp
									@elseif ($pesonetojup)
										{{ number_format(($retornojup - ($margenjup + $costosjup)), 2, ',', '.') }} USD <br>
										@php
											$retorno_netojup=($retornojup - ($margenjup + $costosjup));
										@endphp
									@endif
							</td>
							
							<td style="text-align:right; padding-right:20px;border-left: 1px solid #ddd;">
								@if ($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','JUP')->count()>0)
										{{number_format($informe_edit->modificaciones->where('categoria','DENTRO DE NORMA')->where('variedad',$variedad)->where('calibre','JUP')->first()->retorno/$pesonetojup, 2, ',', '.') }} USD
										
								@elseif ($pesonetojup)
									{{ number_format(($retornojup - ($margenjup + $costosjup))/$pesonetojup, 2, ',', '.') }} USD <br>
									
								@endif
							</td>
							
						</tr>
						@php
							$calibrecount+=1;
						@endphp
					@endif
			   
				
				@if ($pesonetojup>0)
				  
				  <tr>
					<td></td>
					<td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">TOTAL {{$variedad}}</td>
					<td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
					<td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold; ">{{number_format($pesonetojup,0,',','.')}} KG</td>
					
					<td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format(($retorno_netojup),2,',','.')}} USD 
					
					
				  </td>
					<td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format(($retorno_netojup)/($pesonetojup),2,',','.')}} USD</td>
					
				  </tr>
				@endif
				  @php
					$totalemb+=(($retorno_netojup));
					$variedadcount+=1;
				  @endphp
				
	  
			  @endforeach
			
			  @if ($pesonetototal>0)
				
			  <tr style="background-color: #ddd;">
					
				
			  
				  <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">TOTAL MERCADO INTERNO</td>
				
				
				  <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
			  
				
				
				<td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"></td>
				<td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format($pesonetototal,0,',','.')}} KG</td>
				
				<td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format($totalemb,2,',','.')}} USD 
			   
				</td>
				<td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format($totalemb/$pesonetototal,2,',','.')}} USD </td>
				
			  </tr>
			  @endif
	  
			  @php
				
				$totalembalada=$totalemb;
			  @endphp
				
	  
			</tbody>
		</table>

	
		
		<table style="width:100%;border-collapse: collapse; margin-bottom: 30px; margin-top: 30px; display: none;">
		
			<tr style="text-align: left;">
				<tr style="text-align: left; border-bottom: 0px solid #ddd;">
					<h1 style="color: red;margin: 0; line-height: 1.2;">
						INFORME ANALISIS MULTIRESIDUOS
					</h1>
					<h3 style="margin: 20px 0 ; line-height: 1.2;">PRODUCTOR: {{$razonsocial->name}}</h3>
				</td>
				
				<td>
					<img class="object-contain" style="height: 100px;" src="{{asset('image/logo.png')}}" alt="">
				</td>
			  </tr>
		</table>

		<table id="balance" style="width:100%; border-collapse: collapse; margin-top: 20px; display: none;">
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
									<td style="text-align: left; padding-left: 0px; padding-bottom: 4px; margin-top: 10px;">Analisis Multiresiduos</td>
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

		<table style="width:100%;border-collapse: collapse; margin-bottom: 30px; margin-top: 30px; display: none;">
		
			<tr style="text-align: left; border-bottom: 0px solid #ddd;">
				<td style="text-align: left;">
					<h1 style="color: red;margin: 0; line-height: 1.2;">
						INFORME CERTIFICACIONES
					</h1>
					<h3 style="margin: 20px 0 ; line-height: 1.2;">PRODUCTOR: {{$razonsocial->name}}</h3>
				</td>
				
				
			  </tr>
		</table>

		<table id="balance" style="width:100%; border-collapse: collapse; margin-top: 20px; display: none;">
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

	

		<table style="width:100%;border-collapse: collapse; margin-bottom: 30px; margin-top: 30px; display: none;">
		
			<tr style="text-align: left; border-bottom: 0px solid #ddd;">
				<td style="text-align: left;">
					<h1 style="color: red;margin: 0; line-height: 1.2;">
						INFORME MATERIALES DE COSECHA ADEUDADOS
					</h1>
					<h3 style="margin: 20px 0 ; line-height: 1.2;">PRODUCTOR: {{$razonsocial->name}}</h3>
				</td>
				
				
			  </tr>
		</table>

		<table id="balance" style="width:100%; border-collapse: collapse; margin-top: 20px; display: none;">
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

	
		<table style="width:100%;border-collapse: collapse; margin-bottom: 30px; margin-top: 30px; display: none;">
		
			<tr style="text-align: left; border-bottom: 0px solid #ddd;">
				<td style="text-align: left;">
					<h1 style="color: red;margin: 0; line-height: 1.2;">
						Anticipos Otorgados
					</h1>
					<h3 style="margin: 20px 0 ; line-height: 1.2;">PRODUCTOR: {{$razonsocial->name}}</h3>
				</td>
				
				<td>
					<img class="object-contain" style="height: 100px;" src="{{asset('image/logo.png')}}" alt="">
				</td>
			  </tr>
		</table>

		<table id="balance" style="width:100%; border-collapse: collapse; margin-top: 20px; display: none;">
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

	
		<table style="width:100%;border-collapse: collapse; margin-bottom: 30px; margin-top: 30px; display: none;">
		
			<tr style="text-align: left; border-bottom: 0px solid #ddd;">
				<td style="text-align: left;">
					<h1 style="color: red;margin: 0; line-height: 1.2;">
						Resumen Liquidación
					</h1>
					<h3 style="margin: 0; line-height: 1.2;">Productor: {{$razonsocial->name}}</h3>
				</td>
				
				<td>
					<img class="object-contain" style="height: 100px;" src="{{asset('image/logo.png')}}" alt="">
				</td>
			  </tr>
		</table>

		<table id="balance" style="width:100%; border-collapse: collapse; margin-top: 20px; display: none;">
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
								<tr>
									<td style="height: 12px;">

									</td>
								</tr>
								<tr>
								
									<td style="text-align: left; padding-left: 0px; padding-bottom: 4px; margin-top: 10px;">RESULTADO COMERCIALIZACIÓN FRUTA MERCADO INTERNO</td>
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
								<tr>
									<td style="height: 12px;">

									</td>
								</tr>
								<tr style="background-color: #ddd;">
								
									<td style="text-align: left; padding-left: 0px; padding-bottom: 4px; margin-top: 10px; font-weight: bold; ">SUBTOTAL EGRESOS</td>
									<td style="padding-bottom: 4px; margin-top: 10px; text-align: right; padding-right: 10; font-weight: bold;">{{number_format($resultadocomercial-$materiales-$certificaciones-$multiresiduos,2)}} USD</td>
							
								</tr>
								<tr>
									<td style="height: 12px;">

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


		<table style="width:100%;border-collapse: collapse; margin-bottom: 30px; margin-top: 30px;">
		
			<tr style="text-align: left; border-bottom: 0px solid #ddd;">
				<td style="text-align: left;">
					<h1 style="color: red;margin: 0; line-height: 1.2;">
						PROFORMA FACTURACIÓN LIQUIDACIÓN CEREZAS
					</h1>
					<h3 style="margin: 0; line-height: 1.2;">Productor: {{$razonsocial->name}}</h3>
				</td>
				
				<td>
					<img class="object-contain" style="height: 100px;" src="{{asset('image/logo.png')}}" alt="">
				</td>
			  </tr>
		</table>
		<div style="display: flex; justify-content: space-between; font-family: Arial, sans-serif; font-size: 12px; margin-bottom: 10px; align-items: center;">
			<!-- Columna izquierda alineada en una línea -->
			<div style="text-align: left;">
			  <span style="color: #3c2f2f;">T/C 10-04-20</span>
			  <span style="font-weight: bold; margin-left: 8px;">935,50</span>
			</div>
		  
			<!-- Columna derecha -->
			<div style="text-align: right;">
			  <span style="font-weight: bold;">LIQUIDACIÓN USD</span>
			  <span style="margin-left: 5px;">{{number_format(($totaldentrodenorma+$totalfueradenorma+$totalembalada),2,',','.')}} USD</span>
			</div>
		  </div>
		  
		  
		  
		<table id="balance" style="width:100%; border-collapse: collapse; margin-top: 20px;">
			<thead style="border-top: 2px solid black; border-bottom: 2px solid black;">
				<tr style="border: 1px solid black; font-weight: bold; text-align: left;">
					
					<th style="text-align: left; padding-left: 25px;">FECHA</th>
					<th style="text-align: center; padding-left: 25px;">DOCUMENTO</th>
					<td></td>
					<th style="text-align: center;">NETO</th>
					<th style="text-align: center;">IVA</th>
					<th style="text-align: center;">PAGO IVA</th>
					<th style="text-align: center;">NETO USD</th>
				</tr>
			</thead>
			<tbody>
				@foreach($facturas as $item)
				<tr>
				
					<td style="text-align: left; padding-left: 25px; padding-bottom: 4px; margin-top: 10px;">
						{{ \Carbon\Carbon::parse($item->fecha)->format('d/m/Y') }}
					</td>
					<td style="text-align: right; padding-left: 25px; padding-bottom: 4px; margin-top: 10px;">
						{{ $item->tipo_docto }}
					</td>
					<td style="text-align: right; padding-left: 25px; padding-bottom: 4px; margin-top: 10px;">
						{{$item->no_docto}}
					</td>
					<td style="padding-bottom: 4px; margin-top: 10px; text-align: center; padding-right: 10;">
						{{ number_format($item->monto_neto, 0, ',', '.') }}
					</td>
					<td style="padding-bottom: 4px; margin-top: 10px; text-align: right; padding-right: 10;">
						{{ number_format($item->iva, 0, ',', '.') }}
					</td>
					<td style="padding-bottom: 4px; margin-top: 10px; text-align: right; padding-right: 10;">
						{{ number_format($item->iva2, 0, ',', '.') }}
					</td>
					<td style="padding-bottom: 4px; margin-top: 10px; text-align: right; padding-right: 10;white-space: nowrap;">
						{{ number_format($item->cantidad, 2, ',', '.') }} USD
					</td>
				</tr>
				@endforeach
				
				@if($item->tc>0)
                                            
					<tr>
					
						
						<td colspan="2" style="text-align: right; padding-left: 25px; padding-bottom: 4px; margin-top: 10px; white-space: nowrap;">
							DIF. POR TIPO DE CAMBIO EN LIQUIDACION
						</td>
						<td style="text-align: right; padding-left: 25px; padding-bottom: 4px; margin-top: 10px;">
							
						</td>
						<td style="padding-bottom: 4px; margin-top: 10px; text-align: center; padding-right: 10;">
							{{ number_format($item->tc, 2, ',', '.') }}
						</td>
						<td style="padding-bottom: 4px; margin-top: 10px; text-align: right; padding-right: 10;">
							{{ number_format($item->iva, 2, ',', '.') }} USD
						</td>
						<td style="padding-bottom: 4px; margin-top: 10px; text-align: right; padding-right: 10;">
							{{ number_format($item->iva2, 2, ',', '.') }} USD
						</td>
						<td style="padding-bottom: 4px; margin-top: 10px; text-align: right; padding-right: 10;">
							{{ number_format($item->neto_usd, 2, ',', '.') }} USD
						</td>
					</tr>
			
				@endif
			</tbody>
		</table>
		<table id="balance" style="width:100%; border-collapse: collapse; margin-top: 20px;">
		
			<tbody>
				<tr style="background-color: #ddd; font-weight: bold;">
					
					<td style="text-align: right; padding-right: 10;">
						Total Facturado 
					</td>
					<td style="text-align: left; padding-left: 25px;" colspan="">
						
					</td>
					<td>
						{{ number_format($facturas->sum('monto_neto'), 0, ',', '.') }}
					</td>
					<td style="text-align: right; padding-right: 10;">
						{{ number_format($facturas->sum('iva'), 0, ',', '.') }}
					</td>
					<td style="text-align: right; padding-right: 10;">
						{{ number_format($facturas->sum('iva2'), 0, ',', '.') }}
					</td>
					<td style="text-align: right; padding-right: 10;">
						{{ number_format($facturas->sum('cantidad'), 2, ',', '.') }} USD
					</td>
				</tr>
			</tbody>
		</table>

		<table id="balance" style="width:50%; margin-top: 20px;  ">
		
			<tbody>
				<tr style="background-color: #ddd; font-weight: bold;" >
					<td style="text-align: left; padding-left: 25px;" colspan="2" >
						Nota de Débito a Emitir
					</td>
					
					
				</tr>
				<tr style="background-color: #ffffff; font-weight: bold;">
					<td style="text-align: left; padding-left: 25px;">
						Neto
					</td>
					<td style="text-align: right; padding-left: 25px;">
						1453
					</td>
					
				</tr>
				<tr style="background-color: #ffffff; font-weight: bold;">
					<td style="text-align: left; padding-left: 25px;">
						Iva
					</td>
					<td style="text-align: right; padding-left: 25px;">
						1453
					</td>
					
				</tr>
				<tr style="background-color: #ffffff; font-weight: bold;">
					<td style="text-align: left; padding-left: 25px;">
						Total
					</td>
					<td style="text-align: right; padding-left: 25px;">
						1453
					</td>
					
				</tr>
			</tbody>
		</table>
		
		<table id="balance" style="width:100%; margin-top: 20px; border-collapse: collapse;">
		
			<tbody>
				<tr style="background-color: #ddd; font-weight: bold;">
					<td style="text-align: left; padding-left: 25px;">
						Glosa Nota de Débito

					</td>
					<td>
						
					</td>
					
				</tr>
				<tr style="background-color: #ffffff; font-weight: bold;">
					<td style="text-align: left; padding-left: 25px;">
						Mayor Valor Resultado Liquidación de Cerezas Exportación Temporada 2023 - 2024
					</td>
					
					
				</tr>
				
			</tbody>
		</table>

		
		
		
	</body>
</html>