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
        <h1 style="color:red; margin-top: 150px; font-size: 52px;">Liquidación Cerezas</h1>
        <h1 style="color:gray; margin-top: 10px;">Temporada 2023-2024</h1>
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
					<h2 style="margin: 0; line-height: 1.2;">Por Variedad</h2>
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
					<td style="text-align: center; padding: 2px;">
						{{$razonsocial->name}}
					</td>
				</tr>
			</thead>
		</table>

		
		<table id="balance" style="width:100%; border-collapse: collapse; margin-top: 20px;">
			<thead style="border-top: 2px solid black; border-bottom: 2px solid black;">
			  <tr style="border: 1px solid black; font-weight: bold;">
				
				<th style="border: 1px solid black; font-weight: bold;   ">KG<br>Variedad</th>
				
				<th>Tipo<br>Exportación</th>
				
			
				<th>Comercial</th>
				<th>PRE-CALIBRE</th>
				<th>MERMA DESECHO</th>
				<th>MERMA HOJAS</th>
				<th>TOTAL</th>
				
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
						$retorno4j=0;
						$retorno3j=0;
						$retorno2j=0;
						$retornoj=0;
						$retornoxl=0;
					@endphp

					@foreach ($masas as $masa)
						@if ($masa->tipo=='COMERCIAL' || $masa->tipo=='PRE-CALIBRE' || $masa->tipo=='MERMA DESECHO' || $masa->tipo=='MERMA HOJAS' || $masa->tipo=='COMERCIAL EMBALADA' || $masa->tipo=='EXPORTACIÓN LIGHT' || $masa->tipo=='EXPORTACIÓN DARK' || $masa->tipo=='EXPORTACIÓN')
							@if (($masa->tipo=='COMERCIAL' || $masa->tipo=='COMERCIAL EMBALADA') && $masa->variedad==$variedad)
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
						@if ($masa->norma=='MERCADO INTERNO')
							@if (($masa->tipo=='COMERCIAL' || $masa->tipo=='PRE-CALIBRE' || $masa->tipo=='MERMA DESECHO' || $masa->tipo=='MERMA HOJAS') && $masa->variedad==$variedad)
								@php
									$resultadocomercial+=$masa->fob_nacional+$masa->costo_nacional;
								@endphp
							@endif
						@endif	
					@endforeach

							<tr>
								
								
								<td style="border-top: 0.5px groove black; text-align:right; padding-right:20px;">{{$variedad}}</td>
								<td style="border-top: 0.5px groove black; text-align:right; padding-right:20px;">{{number_format($pesonetoxl,2,',','.')}} KG</td>
								<td style="border-top: 0.5px groove black; text-align:right; padding-right:20px;">{{number_format($pesoneto4j,2,',','.')}} KG</td>
								<td style="border-top: 0.5px groove black; text-align:right; padding-right:20px;">{{number_format($pesoneto3j,2,',','.')}} KG</td>
								<td style="border-top: 0.5px groove black; text-align:right; padding-right:20px;">{{number_format($pesoneto2j,2,',','.')}} KG</td>
								<td style="border-top: 0.5px groove black; text-align:right; padding-right:20px;">{{number_format($pesonetoj,2,',','.')}} KG</td>
								<td style="border-top: 0.5px groove black; text-align:right; padding-right:20px;">{{number_format($pesonetoxl+$pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj,2,',','.')}} KG</td>

								
								
								
								
							</tr>
				

						

					
						

						@php
							$variedadcount+=1;
						@endphp
					

				@endforeach

				<tr style="border: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;">
							
					
					<td style="border: 1px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;">Total</td>
					<td>{{number_format($totalpesonetoxl)}} KG</td>
					<td>{{number_format($totalpesoneto4j)}} KG</td>
					<td>{{number_format($totalpesoneto3j)}} KG</td>
					<td>{{number_format($totalpesoneto2j)}} KG</td>
					<td>{{number_format($totalpesonetoj)}} KG</td>
					<td>{{number_format($totalpesonetoxl+$totalpesoneto4j+$totalpesoneto3j+$totalpesoneto2j+$totalpesonetoj)}} KG</td>
			
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

		<table id="balance" style="width:100%; border-collapse: collapse; margin-top: 20px;">
			<thead style="border-top: 2px solid black; border-bottom: 2px solid black;">
			  <tr>
			  <th>Norma</th>
			  <th>Variedad</th>
			  <th>Calibre</th>
			  <th>Kg Embalado</th>
			  
			
			 
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

		
		<table id="balance" style="width:100%; border-collapse: collapse; margin-top: 20px;">
			<thead style="border-top: 2px solid black; border-bottom: 2px solid black;">
			  <tr>
			  <th>Norma</th>
			  <th>Variedad</th>
			  <th>Calibre</th>
			  <th>Kg Embalado</th>
			  
		
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
				
				<td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format($totalfr,2,',','.')}} USD 
			   
				</td>
				<td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format($totalfr/$pesonetototal,2,',','.')}} usd/kg </td>
				
			  </tr>
			  @endif
	  
			  @php
				
				$totalfueradenorma=$totalfr;
			  @endphp
				
	  
			</tbody>
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

		
		<table id="balance" style="width:100%; border-collapse: collapse; margin-top: 20px;">
			<thead style="border-top: 2px solid black; border-bottom: 2px solid black;">
			  <tr>
			  <th>Norma</th>
			  <th>Variedad</th>
			  <th>Calibre</th>
			  <th>Kg Embalado</th>
			  
		
			  <th>Retorno Neto Productor</th>
			  
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

				  $totalmargenl=0;

				  $totalcostosl=0;

				  $totalcostopacking=0;
				  $globaltotalmateriales=0;

				  $totalpesonetol=0;

				  $globaltotalotroscostos=0;

				  $totalemb=0;
				  
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
					
					@if (($masa->calibre_real=='JUP') && $masa->variedad==$variedad)
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
					
					
					
					
					<td>JUP</td>
					<td style="text-align:right; padding-right:30px; border-left: 1px solid #ddd; " >{{number_format($pesonetol,0,',','.')}} KGS</td>
				
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
					
					<td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format(($retornol+$margenl+$costosl),2,',','.')}} USD 
					
					
				  </td>
					<td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format(($retornol+$margenl+$costosl)/($pesonetol),2,',','.')}} USD/KG</td>
					
				  </tr>
				@endif
				  @php
					$totalemb+=(($retornol+$margenl+$costosl));
					$variedadcount+=1;
				  @endphp
				
	  
			  @endforeach
			
			  @if ($pesonetototal>0)
				
			  <tr style="background-color: #ddd;">
					
				
			  
				  <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">Total Fuera de Norma</td>
				
				
				  <td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
			  
				
				
				<td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"></td>
				<td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format($pesonetototal,0,',','.')}} KGS</td>
				
				<td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format($totalemb,2,',','.')}} USD 
			   
				</td>
				<td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format($totalemb/$pesonetototal,2,',','.')}} usd/kg </td>
				
			  </tr>
			  @endif
	  
			  @php
				
				$totalembalada=$totalemb;
			  @endphp
				
	  
			</tbody>
		</table>

		<div class="page-break"></div>

		<table style="width:100%;border-collapse: collapse; margin-bottom: 30px; margin-top: 30px;">
		
			<tr style="text-align: left;">
				<tr style="text-align: left; border-bottom: 0px solid #ddd;">
					<h1 style="color: red;margin: 0; line-height: 1.2;">
						INFORME ANALISIS MULTIRESIDUOS
					</h1>
					<h3 style="margin: 0; line-height: 1.2;">Productor: {{$razonsocial->name}}</h3>
				</td>
				
				<td>
					<img class="object-contain" style="height: 100px;" src="{{asset('image/logo.png')}}" alt="">
				</td>
			  </tr>
		</table>

		<table id="balance" style="width:100%; border-collapse: collapse; margin-top: 20px;">
			<thead style="border-top: 2px solid black; border-bottom: 2px solid black;">
			  <tr style="border: 1px solid black; font-weight: bold;">
				<th>Fecha</th>
				<th style="text-align:left;">Detalle</th>
				<th>Usd</th>
				
			  </tr>
			</thead>
			<tbody>
				@php
					$totalgastos=0;
				@endphp
				@foreach ($gastos as $gasto)
					@if ($gasto->familia->name=='Cuenta Corriente' && $gasto->item=='Analisis Multiresiduos')
						@foreach ($detalles as $detalle)
							@if (preg_replace('/[\.\-\s]+/', '', strtolower($detalle->item))==preg_replace('/[\.\-\s]+/', '', strtolower($gasto->item)))
								
								<tr>
								
									<td style="text-align: left; padding-left: 0px; padding-bottom: 4px; margin-top: 30px;">{{ substr($detalle->fecha, 0, 11) }}</td>
									<td style="text-align: left; padding-left: 0px; padding-bottom: 4px; margin-top: 10px;">{{$detalle->item}}</td>
									<td style="padding-bottom: 4px; margin-top: 10px;">{{number_format($detalle->cantidad,2,',','.')}} USD</td>
							
								</tr>
								@php
									$totalgastos+=floatval($detalle->cantidad);
								@endphp
								
							@endif
						@endforeach
						
					@endif
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
					<h3 style="margin: 0; line-height: 1.2;">Productor: {{$razonsocial->name}}</h3>
				</td>
				
				
			  </tr>
		</table>

		<table id="balance" style="width:100%; border-collapse: collapse; margin-top: 20px;">
			<thead style="border-top: 2px solid black; border-bottom: 2px solid black;">
			  <tr style="border: 1px solid black; font-weight: bold;">
				<th>Fecha</th>
				<th style="text-align:left;">Detalle</th>
				<th>Usd</th>
				
			  </tr>
			</thead>
			<tbody>
				@php
					$totalgastos=0;
				@endphp
				@foreach ($gastos as $gasto)
					@if ($gasto->familia->name=='Cuenta Corriente' && $gasto->item=='Certificaciones')
						@foreach ($detalles as $detalle)
							@if (preg_replace('/[\.\-\s]+/', '', strtolower($detalle->item))==preg_replace('/[\.\-\s]+/', '', strtolower($gasto->item)))
								
								<tr>
								
									<td style="text-align: left; padding-left: 0px; padding-bottom: 4px; margin-top: 30px;">{{ substr($detalle->fecha, 0, 11) }}</td>
									<td style="text-align: left; padding-left: 0px; padding-bottom: 4px; margin-top: 10px;">{{$detalle->item}}</td>
									<td style="padding-bottom: 4px; margin-top: 10px;">{{number_format($detalle->cantidad,2,',','.')}} USD</td>
							
								</tr>
								@php
									$totalgastos+=floatval($detalle->cantidad);
								@endphp
								
							@endif
						@endforeach
						
					@endif
				@endforeach
				<tr style="background-color: #ddd; " >
								
					<td style="font-weight: bold; padding-bottom: 4px; margin-top: 10px;">TOTAL</td>
					<td style="font-weight: bold; padding-bottom: 4px; margin-top: 10px;"></td>
					<td style="font-weight: bold; padding-bottom: 4px; margin-top: 10px;">{{number_format($totalgastos,2,',','.')}} USD</td>
			
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
					<h3 style="margin: 0; line-height: 1.2;">Productor: {{$razonsocial->name}}</h3>
				</td>
				
				
			  </tr>
		</table>

		<table id="balance" style="width:100%; border-collapse: collapse; margin-top: 20px;">
			<thead style="border-top: 2px solid black; border-bottom: 2px solid black;">
			  <tr style="border: 1px solid black; font-weight: bold;">
				<th>Fecha</th>
				<th style="text-align:left;">Detalle</th>
				<th>Usd</th>
				
			  </tr>
			</thead>
			<tbody>
				@php
					$totalgastos=0;
				@endphp
				@foreach ($gastos as $gasto)
					@if ($gasto->familia->name=='Cuenta Corriente' && $gasto->item=='Materiales de Cosecha')
						@foreach ($detalles as $detalle)
							@if (preg_replace('/[\.\-\s]+/', '', strtolower($detalle->item))==preg_replace('/[\.\-\s]+/', '', strtolower($gasto->item)))
								
								<tr>
								
									<td style="text-align: left; padding-left: 0px; padding-bottom: 4px; margin-top: 30px;">{{ substr($detalle->fecha, 0, 11) }}</td>
									<td style="text-align: left; padding-left: 0px; padding-bottom: 4px; margin-top: 10px;">{{$detalle->item}}</td>
									<td style="padding-bottom: 4px; margin-top: 10px;">{{number_format($detalle->cantidad,2,',','.')}} USD</td>
							
								</tr>
								@php
									$totalgastos+=floatval($detalle->cantidad);
								@endphp
								
							@endif
						@endforeach
						
					@endif
				@endforeach
				<tr style="background-color: #ddd; " >
								
					<td style="font-weight: bold; padding-bottom: 4px; margin-top: 10px;">TOTAL</td>
					<td style="font-weight: bold; padding-bottom: 4px; margin-top: 10px;"></td>
					<td style="font-weight: bold; padding-bottom: 4px; margin-top: 10px;">{{number_format($totalgastos,2,',','.')}} USD</td>
			
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
						Anticipos Otorgados
					</h1>
					<h3 style="margin: 0; line-height: 1.2;">Productor: {{$razonsocial->name}}</h3>
				</td>
				
				<td>
					<img class="object-contain" style="height: 100px;" src="{{asset('image/logo.png')}}" alt="">
				</td>
			  </tr>
		</table>

		<table id="balance" style="width:100%; border-collapse: collapse; margin-top: 20px;">
			<thead style="border-top: 2px solid black; border-bottom: 2px solid black;">
			  <tr style="border: 1px solid black; font-weight: bold;">
				<th>Fecha</th>
				<th>Item</th>
				<th>Usd</th>
				<th>Tipo de cambio</th>
				<th>CLP</th>
				
			  </tr>
			</thead>
			<tbody>
				@php
					$totalgastos=0;
				@endphp
				@foreach ($anticipos as $anticipo)
								
								<tr>
								
									<td style=" padding-bottom: 4px; margin-top: 10px;">{{ substr($anticipo->fecha, 0, 11) }}</td>
									<td style=" padding-bottom: 4px; margin-top: 10px;"> ANTICIPO PRODUCTOR</td>
									<td style=" padding-bottom: 4px; margin-top: 10px;">{{number_format(floatval($anticipo->cantidad),2,',','.')}} USD</td>
							
									<td style=" padding-bottom: 4px; margin-top: 10px;"> - </td>
									
									<td style=" padding-bottom: 4px; margin-top: 10px;">{{number_format(floatval($anticipo->cantidad),2,',','.')}} CLP</td>
							
								</tr>
								@php
									$totalgastos+=floatval($anticipo->cantidad);
								@endphp
							
				@endforeach
				<tr style="background-color: #ddd;">
								
					<td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">TOTAL</td>
					<td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;"></td>
					<td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format($totalgastos,2,',','.')}} USD</td>
					<td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">-</td>
					<td style="padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format($totalgastos,2,',','.')}} CLP</td>
			
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
						Resumen Liquidación
					</h1>
					<h3 style="margin: 0; line-height: 1.2;">Productor: {{$razonsocial->name}}</h3>
				</td>
				
				<td>
					<img class="object-contain" style="height: 100px;" src="{{asset('image/logo.png')}}" alt="">
				</td>
			  </tr>
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

			{{-- 
			@php
				$cat1=0;
				$kspcat1=0;
				$costoexportcat1=0;

				$cati=0;
				$kspcati=0;
				$costoexportcati=0;

				$costopacking=$packings->first()->total_usd;

			@endphp
			@foreach ($masas as $masa)
				@if ($masa->n_categoria=='Cat 1')
						@php
							if($masa->precio_fob){
								$cat1+=$masa->peso_caja*$masa->precio_fob;
							}else{
								$kspcat1+=$masa->peso_caja;
							}
							if ($masa->tipo_transporte=='AEREO') {
                                    if ($exportacions->where('type','aereo')->count()>0) {
                                      	$costoexportcat1+=$masa->peso_caja*$exportacions->where('type','aereo')->first()->precio_usd;
                                    }
                            }
                            if ($masa->tipo_transporte=='MARITIMO') {
                              	if ($exportacions->where('type','maritimo')->count()>0) {
									$costoexportcat1+=$masa->peso_caja*$exportacions->where('type','aereo')->first()->precio_usd;
                                }
                            }
						@endphp	
				@endif
				@if (strtolower($masa->n_categoria)=='cat i')
						@php
							if($masa->precio_fob){
								$cati+=$masa->peso_caja*$masa->precio_fob;
							}else{
								$kspcati+=$masa->peso_caja;
							}
							if ($masa->tipo_transporte=='AEREO') {
                                    if ($exportacions->where('type','aereo')->count()>0) {
                                      	$costoexportcati+=$masa->peso_caja*$exportacions->where('type','aereo')->first()->precio_usd;
                                    }
                            }
                            if ($masa->tipo_transporte=='MARITIMO') {
                              	if ($exportacions->where('type','maritimo')->count()>0) {
									$costoexportcati+=$masa->peso_caja*$exportacions->where('type','aereo')->first()->precio_usd;
                                }
                            }
						@endphp	
				@endif
			@endforeach
ent --}}
		

{{-- comm
		<h3 style="text-align: left;">Facturación (proformas)</h3>

		<table style="width:100%;border-collapse: collapse; margin-bottom: 30px;">
			@php
				$totalproforma=0;
			@endphp
			@foreach ($anticipos as $anticipo)
				@php
					$fechaprint=new DateTime($anticipo->fecha);
					$totalproforma+=floatval($anticipo->cantidad);
				@endphp
				<tr style="text-align: left;">
					<td style="text-align: left; width:60%;"></td>
					<td>{{$fechaprint->format('d-m-Y')}}</td>
					<td>USD$</td>
					<td>{{number_format($anticipo->cantidad,2)}}</td>
				</tr>
				
			@endforeach

			<tr>
				<td>

				</td>
			</tr>
			<tr>
			  <td style="text-align: left; border: 2px solid black;padding: 2px; margin-top: 5px;" colspan="2"> Total facturación (Proformas)</td>
			  
			  <td style="text-align: center; border: 2px solid black;padding: 2px; margin-top: 5px;"> USD$</td>
			  <td style="text-align: center; border: 2px solid black;padding: 2px; margin-top: 5px;"> {{number_format($totalproforma,2)}}</td>
			</tr>
		</table>

						@php
							
							$cantidadtotal=0;
							$pesonetototal=0;
						@endphp
	
						@foreach ($masas as $masa)
							@if ($masa->calibre=='Comercial' || $masa->calibre=='Precalibre' || $masa->calibre=='Desecho' || $masa->calibre=='Merma')
								
										@php
											$cantidadtotal+=$masa->peso_caja*1.092;
											$pesonetototal+=$masa->peso_caja;
										@endphp	
								
								
							@endif
							
						@endforeach

		<h3 style="text-align: left;">Otro cargos</h3>

		<table style="width:100%;border-collapse: collapse;">
		
			<tr style="text-align: left;">
				<td style="text-align: left; width:60%;">Gastos de fruta no exportable</td>
				<td>Kilos {{number_format($pesonetototal)}}</td>
				<td>USD$</td>
				<td>{{number_format($cantidadtotal)}}</td>
			  </tr>
			  @php
				  $totalgastos=$cantidadtotal;
			  @endphp

			@foreach ($gastos as $gasto)
				@if ($gasto->familia->name=='Cuenta Corriente')
			  		@foreach ($detalles as $detalle)
						@if (preg_replace('/[\.\-\s]+/', '', strtolower($detalle->item))==preg_replace('/[\.\-\s]+/', '', strtolower($gasto->item)))
							
							<tr style="text-align: left;">
										<td style="text-align: left; width:60%;">{{$gasto->item}}</td>
										<td></td>
										<td>USD$</td>
										<td>{{number_format($detalle->cantidad,2)}}</td>
							</tr>
							@php
								$totalgastos+=floatval($detalle->cantidad);
							@endphp
							
						@endif
					@endforeach
				@endif
			@endforeach

			


				<td>

				</td>
			</tr>
			<tr>
			  <td style="text-align: left; border: 2px solid black;padding: 2px; margin-top: 5px;" colspan="2"> Total cargos</td>
			  
			  <td style="text-align: center; border: 2px solid black;padding: 2px; margin-top: 5px;"> USD$</td>
			  <td style="text-align: center; border: 2px solid black;padding: 2px; margin-top: 5px;"> {{number_format($totalgastos,2)}}</td>
			</tr>
			<tr>
				<td style="text-align: left; border: 2px solid black;padding: 2px; margin-top: 5px;" colspan="2"> Saldo</td>
				
				<td style="text-align: center; border: 2px solid black;padding: 2px; margin-top: 5px;"> USD$</td>
				<td style="text-align: center; border: 2px solid black;padding: 2px; margin-top: 5px;"> {{number_format(($cat1+$cati)-($totalgastos+$totalproforma),2)}}</td>
			  </tr>

			
		
		</table>
		<table style="width: 100%;">
			<tr style="text-align: left;">
				<td style="text-align: left; width:60%;"></td>
				<td>T/C</td>
				@if ($razonsocial->tc)
					<td>${{$razonsocial->tc}}</td>
				@else
					<td>$814,75</td>
				@endif
				

				@if ($razonsocial->tc)
					<td>{{number_format((($cat1+$cati)-($totalgastos+$totalproforma))*$razonsocial->tc,0)}}</td>
				@else
					<td>{{number_format((($cat1+$cati)-($totalgastos+$totalproforma))*814.75,0)}}</td>
				@endif

			  </tr>
		</table>

		<table style="width: 100%; border: 2px solid black; border-collapse: collapse; margin-top: 20px;">
			<tr>
				<td colspan="6" style="font-weight: bold; font-size: 12pt;">
					Nota de Débito
				</td>
			</tr>
			<tr>
				<td colspan="4" style="text-align: left; padding: 2px; margin-top: 5px;">
					Ajuste final de precio de cereza exportación
				</td>
				<td style="font-weight: bold;border-left: 2px solid black; border-top: 2px solid black;">
					Neto
				</td>
				<td style="border-top: 2px solid black;">

					@if ($razonsocial->tc)
						${{number_format((($cat1+$cati)-($totalgastos+$totalproforma))*$razonsocial->tc,0)}}
					@else
						${{number_format((($cat1+$cati)-($totalgastos+$totalproforma))*814.75,0)}}
					@endif
					
				</td>
			</tr>
			<tr>
				<td colspan="4" style="text-align: left; padding: 2px; margin-top: 5px;">
					Temporada 2023-2024
				</td>
				<td style="font-weight: bold;border-left: 2px solid black;">
					Iva
				</td>
				<td>
					@if ($razonsocial->tc)
						${{number_format((($cat1+$cati)-($totalgastos+$totalproforma))*$razonsocial->tc*0.19,0)}}
					@else
						${{number_format((($cat1+$cati)-($totalgastos+$totalproforma))*814.75*0.19,0)}}
					@endif
				</td>
			</tr>
			<tr>
				<td colspan="4">
					
				</td>
				<td style="font-weight: bold;border-left: 2px solid black;">
					Total
				</td>
				<td>
					@if ($razonsocial->tc)
						${{number_format((($cat1+$cati)-($totalgastos+$totalproforma))*$razonsocial->tc*1.19,0)}}
					@else
						${{number_format((($cat1+$cati)-($totalgastos+$totalproforma))*814.75*1.19,0)}}
					@endif
				</td>
			</tr>
		</table>

		<table style="width: 100%; border: 2px solid black; border-collapse: collapse; margin-top: 20px;">
			<tr>
				<td colspan="6" style="font-weight: bold; font-size: 12pt;">
					Nota de Débito
				</td>
			</tr>
			<tr>
				<td colspan="4" style="text-align: left; padding: 2px; margin-top: 5px;">
					Ajuste final de precio de cereza nacional   
				</td>
				<td style="font-weight: bold;border-left: 2px solid black; border-top: 2px solid black;">
					Neto
				</td>
				<td style="border-top: 2px solid black;">
					$52.451.356
				</td>
			</tr>
			<tr>
				<td colspan="4" style="text-align: left; padding: 2px; margin-top: 5px;">
					Temporada 2023-2024
				</td>
				<td style="font-weight: bold;border-left: 2px solid black;">
					Iva
				</td>
				<td>
					$52.451.356
				</td>
			</tr>
			<tr>
				<td colspan="4">
					
				</td>
				<td style="font-weight: bold;border-left: 2px solid black;">
					Total
				</td>
				<td>
					$52.451.356
				</td>
			</tr>
		</table>

		<table style="width: 100%; border: 2px solid black; border-collapse: collapse; margin-top: 20px;">
		
			<tr>
				<td style="text-align: left; padding: 2px; margin-top: 5px; width:70%;">
					
				</td>
				<td style="font-weight: bold;border-left: 2px solid black; border-top: 2px solid black; width:15%;">
					Neto
				</td>
				<td style="border-top: 2px solid black; width:15%;">
					$52.451.356
				</td>
			</tr>
			<tr>
				<td style="text-align: right; padding: 2px; margin-top: 5px; width:70%; font-weight: bold; font-size:12pt; padding-right: 110px; ">
					Total Final
				</td>
				<td style="font-weight: bold;border-left: 2px solid black; width:15%;">
					Iva
				</td>
				<td style=" width:15%;">
					$52.451.356
				</td>
			</tr>
			<tr>
				<td style=" width:70%;">
					
				</td>
				<td style="font-weight: bold;border-left: 2px solid black; width:15%;">
					Total
				</td>
				<td style=" width:15%;">
					$52.451.356
				</td>
			</tr>
		</table>
	
			<img src="{{asset('image/footer.png')}}" class="fondo-abajo" style="margin-bottom: 30px;">
		
		<div class="page-break"></div>

		<img src="{{asset('image/cabecera.png')}}" style="margin-top: 30px; margin-bottom: 15px;" alt="">
		<h3 style="text-align: center; margin: 0; line-height: 1;">EXPORTACIÓN DENTRO DE NORMA</h3>
		<p style="text-align: center; margin: 0; line-height: 1;" >{{$razonsocial->name}}</p>
		
		<table id="balance" style="width:100%; border-collapse: collapse; margin-top: 20px;">
			<thead>
			  <tr>
				<th>Especie</th>
				<th>Variedad</th>
				<th>Categoría</th>
				<th>Serie</th>
				<th>% Curva<br>
					Calibre </th>
				<th>Cajas</th>
				<th>Peso Neto</th>
				<th>Retorno Neto<br> Total</th>
				<th>Retorno Kilo</th>
			  </tr>
			</thead>
			<tbody>
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
						@if ($masa->n_etiqueta!='Loica' || $masa->n_categoria=='Cat 1')
							@if (($masa->calibre=='4J' || $masa->calibre=='4JD' || $masa->calibre=='4JDD') && $masa->n_variedad==$variedad)
									@php
										$cantidad4j+=$masa->cantidad;
										$pesoneto4j+=$masa->peso_caja;
										foreach ($fobs->where('n_variedad',$masa->n_variedad)->where('semana',$masa->semana) as $fob){
											$retorno4j+=intval($masa->peso_caja)*intval($fob->fob_kilo_salida);
											$retornototal+=intval($masa->peso_caja)*intval($fob->fob_kilo_salida);
										break;
										}
										$cantidadtotal+=$masa->cantidad;
										$pesonetototal+=$masa->peso_caja;
									@endphp	
							@endif
							@if (($masa->calibre=='3J' || $masa->calibre=='3JD' || $masa->calibre=='3JDD') && $masa->n_variedad==$variedad)
									@php
										$cantidad3j+=$masa->cantidad;
										$pesoneto3j+=$masa->peso_caja;
										foreach ($fobs->where('n_variedad',$masa->n_variedad)->where('semana',$masa->semana) as $fob){
											$retorno3j+=intval($masa->peso_caja)*intval($fob->fob_kilo_salida);
											$retornototal+=intval($masa->peso_caja)*intval($fob->fob_kilo_salida);
										break;
										}
										$cantidadtotal+=$masa->cantidad;
										$pesonetototal+=$masa->peso_caja;
									@endphp	
							@endif
							@if (($masa->calibre=='2J' || $masa->calibre=='2JD' || $masa->calibre=='2JDD') && $masa->n_variedad==$variedad)
									@php
										$cantidad2j+=$masa->cantidad;
										$pesoneto2j+=$masa->peso_caja;
										foreach ($fobs->where('n_variedad',$masa->n_variedad)->where('semana',$masa->semana) as $fob){
											$retorno2j+=intval($masa->peso_caja)*intval($fob->fob_kilo_salida);
											$retornototal+=intval($masa->peso_caja)*intval($fob->fob_kilo_salida);
										break;
										}
										$cantidadtotal+=$masa->cantidad;
										$pesonetototal+=$masa->peso_caja;
									@endphp	
							@endif
							@if (($masa->calibre=='J' || $masa->calibre=='JD' || $masa->calibre=='JDD') && $masa->n_variedad==$variedad)
									@php
										$cantidadj+=$masa->cantidad;
											$pesonetoj+=$masa->peso_caja;
											foreach ($fobs->where('n_variedad',$masa->n_variedad)->where('semana',$masa->semana) as $fob){
												$retornoj+=intval($masa->peso_caja)*intval($fob->fob_kilo_salida);
												$retornototal+=intval($masa->peso_caja)*intval($fob->fob_kilo_salida);
											break;
										}
											$cantidadtotal+=$masa->cantidad;
										$pesonetototal+=$masa->peso_caja;
									@endphp	
							@endif
							@if (($masa->calibre=='XL' || $masa->calibre=='XLD' || $masa->calibre=='XLDD') && $masa->n_variedad==$variedad)
									@php
										$cantidadxl+=$masa->cantidad;
										$pesonetoxl+=$masa->peso_caja;
										foreach ($fobs->where('n_variedad',$masa->n_variedad)->where('semana',$masa->semana) as $fob){
											$retornoxl+=intval($masa->peso_caja)*intval($fob->fob_kilo_salida);
											$retornototal+=intval($masa->peso_caja)*intval($fob->fob_kilo_salida);
										break;
										}
										$cantidadtotal+=$masa->cantidad;
										$pesonetototal+=$masa->peso_caja;
									@endphp	
							@endif
						@endif
					@endforeach

						@if ($unique_calibres->contains('4J') || $unique_calibres->contains('4JD') || $unique_calibres->contains('4JDD'))
							<tr>
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
								
								
								
								<td>4J</td>
								<td>{{number_format($cantidad4j*100/($cantidad4j+$cantidad3j+$cantidad2j+$cantidadj+$cantidadxl),2)}}%</td>
								<td>{{$cantidad4j}}</td>
								<td>{{$pesoneto4j}} KGS</td>
								<td>{{$retorno4j}} USD</td>
								<td>
									@if ($pesoneto4j)
										{{number_format($retorno4j/$pesoneto4j,2)}} USD/kg
									@else
										0 USD/kg
									@endif
								</td>
								
							</tr>
							@php
								$calibrecount+=1;
							@endphp
						@endif
						@if ($unique_calibres->contains('3J') || $unique_calibres->contains('3JD') || $unique_calibres->contains('3JDD'))
							<tr>
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
								
								
								<td>3J</td>
								<td>{{number_format($cantidad3j*100/($cantidad4j+$cantidad3j+$cantidad2j+$cantidadj+$cantidadxl),2)}}%</td>
								
								<td>{{$cantidad3j}}</td>
								<td>{{$pesoneto3j}} KGS</td>
								<td>{{$retorno3j}} USD</td>
								<td>
									@if ($pesoneto3j)
										{{number_format($retorno3j/$pesoneto3j,2)}} USD/kg
									@else
										0 USD/kg
									@endif
								</td>
								
							</tr>
							@php
								$calibrecount+=1;
							@endphp
						@endif
						@if ($unique_calibres->contains('2J') || $unique_calibres->contains('2JD') || $unique_calibres->contains('2JDD'))
							<tr>
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
								
								
								<td>2J</td>
								<td>{{number_format($cantidad2j*100/($cantidad4j+$cantidad3j+$cantidad2j+$cantidadj+$cantidadxl),2)}}%</td>
								
								<td>{{$cantidad2j}}</td>
								<td>{{$pesoneto2j}} KGS</td>
								<td>{{$retorno2j}} USD</td>
								<td>
									@if ($pesoneto2j)
										{{number_format($retorno2j/$pesoneto2j,2)}} USD/kg
									@else
										0 USD/kg
									@endif
								</td>
								
							</tr>
							@php
								$calibrecount+=1;
							@endphp
						@endif
						@if ($unique_calibres->contains('J') || $unique_calibres->contains('JD') || $unique_calibres->contains('JDD'))
							<tr>
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
								
								
								
								<td>J</td>
								<td>{{number_format($cantidadj*100/($cantidad4j+$cantidad3j+$cantidad2j+$cantidadj+$cantidadxl),2)}}%</td>
								<td>{{$cantidadj}}</td>
								<td>{{$pesonetoj}} KGS</td>
								<td>{{$retornoj}} USD</td>
								<td>
									@if ($pesonetoj)
										{{number_format($retornoj/$pesonetoj,2)}} USD/kg
									@else
										0 USD/kg
									@endif
								</td>
	
								
							</tr>
							@php
								$calibrecount+=1;
							@endphp
						@endif
						@if ($unique_calibres->contains('XL') || $unique_calibres->contains('XLD') || $unique_calibres->contains('XLDD'))
							<tr>
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
								
								
								
								<td>XL</td>
								<td>{{number_format($cantidadxl*100/($cantidad4j+$cantidad3j+$cantidad2j+$cantidadj+$cantidadxl),2)}}%</td>
								<td>{{$cantidadxl}}</td>
								<td>{{$pesonetoxl}} KGS</td>
								<td>{{$retornoxl}} USD</td>
						  		<td>
									@if ($pesonetoxl)
										{{number_format($retornoxl/$pesonetoxl,2)}} USD/kg
									@else
										0 USD/kg
									@endif
								</td>
								
							</tr>
							@php
								$calibrecount+=1;
							@endphp
						@endif

						<tr>
							
								<td> </td>
						
						
								<td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;">Total {{$variedad}}</td>
							
							
								<td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
						
							
							
							
							<td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
							<td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;">100,00%</td>
							<td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{$cantidad4j+$cantidad3j+$cantidad2j+$cantidadj+$cantidadxl}}</td>
							<td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{$pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl}} KGS</td>
							<td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{$retorno4j+$retorno3j+$retorno2j+$retornoj+$retornoxl}} USD</td>
							<td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format(($retorno4j+$retorno3j+$retorno2j+$retornoj+$retornoxl)/($pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl),2)}} USD/KG</td>
							
						</tr>
						

						@php
							$variedadcount+=1;
						@endphp
					

				@endforeach

				<tr>
							
					
				
						<td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;">Total</td>
					
					
						<td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
				
						<td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
				
					
					
					<td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;"></td>
					<td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;"></td>
					<td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{$cantidadtotal}}</td>
					<td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{$pesonetototal}} KGS</td>
					<td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{$retornototal}} USD</td>
					<td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format($retornototal/$pesonetototal,2)}} usd/kg</td>
					
				</tr>
							<tr>
								<td>C-14</td>
								<td>Cherries</td>
								<td>Cat 1</td>
								<td>3J</td>
								<td>1,91%</td>
								<td>102</td>
								<td>510 Kg USD</td>
								<td>2.749 USD</td>
								<td>5,39</td>
								
							</tr>
							<tr>
								<td>C-14</td>
								<td>Cherries</td>
								<td>Cat 1</td>
								<td>2J</td>
								<td>14,05%</td>
								<td>750</td>
								<td>3.750 Kg USD</td>
								<td>16.466 USD</td>
								<td>4,39</td>
								
							</tr>
							<tr>
								<td>C-14</td>
								<td>Cherries</td>
								<td>Cat 1</td>
								<td>J</td>
								<td>33,21%</td>
								<td>1.773</td>
								<td>8.865 Kg USD</td>
								<td>25.663 USD</td>
								<td>2,89</td>
								
							</tr>
							<tr>
								<td>C-14</td>
								<td>Cherries</td>
								<td>Cat 1</td>
								<td>XL</td>
								<td>50,76%</td>
								<td>2.710</td>
								<td>13.550 Kg USD</td>
								<td>10.465 USD</td>
								<td>0,77</td>
								
							</tr>
					

			</tbody>
		</table>

		
		
			@php
				$n=1;
			@endphp
			@foreach ($graficos as $item)
				<table style="width:100%; margin: 50px auto;">
					<tr>
						
						
						<td>
							<img style="width:80%;" src="{{$item}}" alt="" >
						</td>
							
					</tr>
				</table>
				@if ($n==1 || $n==4 || $n==7)
					<div class="page-break"></div>
				@endif
				@php
					$n+=1;
				@endphp
				
			@endforeach
			
		

		@if ($n>2)
			
			<div class="page-break"></div>
		@endif
			
			<img src="{{asset('image/cabecera.png')}}" style="margin-top: 30px; margin-bottom: 15px;" alt="">

		<h3 style="text-align: center; margin: 0; line-height: 1;">EXPORTACIÓN DENTRO DE NORMA</h3>
		<p style="text-align: center; margin: 0; line-height: 1;" >Detalle por semana de embarque</p>
		<p style="text-align: center; margin: 0; line-height: 1;" >{{$razonsocial->name}}</p>


			<table id="balance" style="width:100%; border-collapse: collapse; margin-top: 15px;">
				<thead>
				  <tr>
				  <th>Especie</th>
				  <th>Variedad</th>
				  <th>Categoría</th>
				  <th>Semana embarque</th>
				  <th>Serie</th>
				  <th>Color </th>
				  <th>Cajas</th>
				  <th>Peso Neto</th>
				  <th>Retorno Neto<br> Total</th>
				  <th>Retorno Kilo</th>
				  </tr>
				</thead>
				<tbody>
				  @php
					$variedadcount=1;
					$cantidadtotal=0;
					$pesonetototal=0;
					$retornototal=0;
				  @endphp
				  @foreach ($unique_variedades as $variedad)
				   
					@php
						$calibrecount=1;
						
					@endphp
					 
					@foreach ($unique_semanas as $semana)

					  @php
						
					   
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
					  	@if ($masa->n_etiqueta!='Loica' || $masa->n_categoria=='Cat 1')
						  @if (($masa->calibre=='4J' || $masa->calibre=='4JD' || $masa->calibre=='4JDD') && $masa->n_variedad==$variedad && $masa->semana==$semana)
							  @php
								$cantidad4j+=$masa->cantidad;
								$pesoneto4j+=$masa->peso_caja;
								foreach ($fobs->where('n_variedad',$masa->n_variedad)->where('semana',$masa->semana) as $fob){
								  $retorno4j+=intval($masa->peso_caja)*intval($fob->fob_kilo_salida);
								  $retornototal+=intval($masa->peso_caja)*intval($fob->fob_kilo_salida);
								  break;
								}
								$cantidadtotal+=$masa->cantidad;
								$pesonetototal+=$masa->peso_caja;
							  @endphp	
						  @endif
						  @if (($masa->calibre=='3J' || $masa->calibre=='3JD' || $masa->calibre=='3JDD') && $masa->n_variedad==$variedad && $masa->semana==$semana)
							  @php
								$cantidad3j+=$masa->cantidad;
								$pesoneto3j+=$masa->peso_caja;
								foreach ($fobs->where('n_variedad',$masa->n_variedad)->where('semana',$masa->semana) as $fob){
								  $retorno3j+=intval($masa->peso_caja)*intval($fob->fob_kilo_salida);
								  $retornototal+=intval($masa->peso_caja)*intval($fob->fob_kilo_salida);
								  break;
								}
								$cantidadtotal+=$masa->cantidad;
								$pesonetototal+=$masa->peso_caja;
							  @endphp	
						  @endif
						  @if (($masa->calibre=='2J' || $masa->calibre=='2JD' || $masa->calibre=='2JDD') && $masa->n_variedad==$variedad && $masa->semana==$semana)
							  @php
								$cantidad2j+=$masa->cantidad;
								$pesoneto2j+=$masa->peso_caja;
								foreach ($fobs->where('n_variedad',$masa->n_variedad)->where('semana',$masa->semana) as $fob){
								  $retorno2j+=intval($masa->peso_caja)*intval($fob->fob_kilo_salida);
								  $retornototal+=intval($masa->peso_caja)*intval($fob->fob_kilo_salida);
								  break;
								}
								$cantidadtotal+=$masa->cantidad;
								$pesonetototal+=$masa->peso_caja;
							  @endphp	
						  @endif
						  @if (($masa->calibre=='J' || $masa->calibre=='JD' || $masa->calibre=='JDD') && $masa->n_variedad==$variedad && $masa->semana==$semana)
							  @php
								  $cantidadj+=$masa->cantidad;
								  $pesonetoj+=$masa->peso_caja;
								  foreach ($fobs->where('n_variedad',$masa->n_variedad)->where('semana',$masa->semana) as $fob){
									$retornoj+=intval($masa->peso_caja)*intval($fob->fob_kilo_salida);
									$retornototal+=intval($masa->peso_caja)*intval($fob->fob_kilo_salida);
									break;
								  }
								  $cantidadtotal+=$masa->cantidad;
								  $pesonetototal+=$masa->peso_caja;
							  @endphp	
						  @endif
						  @if (($masa->calibre=='XL' || $masa->calibre=='XLD' || $masa->calibre=='XLDD') && $masa->n_variedad==$variedad && $masa->semana==$semana)
							  @php
								$cantidadxl+=$masa->cantidad;
								$pesonetoxl+=$masa->peso_caja;
								foreach ($fobs->where('n_variedad',$masa->n_variedad)->where('semana',$masa->semana) as $fob){
								  $retornoxl+=intval($masa->peso_caja)*intval($fob->fob_kilo_salida);
								  $retornototal+=intval($masa->peso_caja)*intval($fob->fob_kilo_salida);
								  break;
								}
								$cantidadtotal+=$masa->cantidad;
								$pesonetototal+=$masa->peso_caja;
							  @endphp	
						  @endif
						@endif
					  @endforeach
					 
					  @php
						$semanacount=0;
					  @endphp

					  @if ($cantidad4j>0)
						<tr>
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
						  
						  
						  @if ($semanacount==0)
							<td>{{$semana}}</td>
						  @else
							<td> </td>
						  @endif

						  <td>4J</td>
						  <td>{{number_format($cantidad4j*100/($cantidad4j+$cantidad3j+$cantidad2j+$cantidadj+$cantidadxl),2)}}%</td>
						  <td>{{$cantidad4j}}</td>
						  <td>{{$pesoneto4j}} KGS</td>
						  <td>{{$retorno4j}} USD</td>
						  <td>
									@if ($pesoneto4j)
										{{number_format($retorno4j/$pesoneto4j,2)}} USD/kg
									@else
										0 USD/kg
									@endif
								</td>
						</tr>
						@php
						  $semanacount+=1;
						  $calibrecount+=1;
						@endphp
					  @endif
					  @if ($cantidad3j>0)
						<tr>
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
						  
						 @if ($semanacount==0)
							<td>{{$semana}}</td>
						  @else
							<td> </td>
						  @endif
						  
						  <td>3J</td>
						  <td>{{number_format($cantidad3j*100/($cantidad4j+$cantidad3j+$cantidad2j+$cantidadj+$cantidadxl),2)}}%</td>
						  
						  <td>{{$cantidad3j}}</td>
						  <td>{{$pesoneto3j}} KGS</td>
						  <td>{{$retorno3j}} USD</td>
						  <td>
									@if ($pesoneto3j)
										{{number_format($retorno3j/$pesoneto3j,2)}} USD/kg
									@else
										0 USD/kg
									@endif
								</td>
						</tr>
						@php
						  $calibrecount+=1;
						  $semanacount+=1;
						@endphp
					  @endif
					  @if ($cantidad2j>0)
						<tr>
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
						  
						  @if ($semanacount==0)
							<td>{{$semana}}</td>
						  @else
							<td> </td>
						  @endif
						  
						  <td>2J</td>
						  <td>{{number_format($cantidad2j*100/($cantidad4j+$cantidad3j+$cantidad2j+$cantidadj+$cantidadxl),2)}}%</td>
						  
						  <td>{{$cantidad2j}}</td>
						  <td>{{$pesoneto2j}} KGS</td>
						  <td>{{$retorno2j}} USD</td>
						  <td>
									@if ($pesoneto2j)
										{{number_format($retorno2j/$pesoneto2j,2)}} USD/kg
									@else
										0 USD/kg
									@endif
								</td>
						</tr>
						@php
						  $calibrecount+=1;
						  $semanacount+=1;
						@endphp
					  @endif
					  @if ($cantidadj>0)
						<tr>
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
						  
						  
						  @if ($semanacount==0)
							<td>{{$semana}}</td>
						  @else
							<td> </td>
						  @endif
						  
						  <td>J</td>
						  <td>{{number_format($cantidadj*100/($cantidad4j+$cantidad3j+$cantidad2j+$cantidadj+$cantidadxl),2)}}%</td>
						  <td>{{$cantidadj}}</td>
						  <td>{{$pesonetoj}} KGS</td>
						  <td>{{$retornoj}} USD</td>
						  <td>
									@if ($pesonetoj)
										{{number_format($retornoj/$pesonetoj,2)}} USD/kg
									@else
										0 USD/kg
									@endif
								</td>
						</tr>
						@php
						  $calibrecount+=1;
						  $semanacount+=1;
						@endphp
					  @endif
					  @if ($cantidadxl>0)
						<tr>
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
						  
						  
						  @if ($semanacount==0)
							<td>{{$semana}}</td>
						  @else
							<td> </td>
						  @endif
						  
						  <td>XL</td>
						  <td>{{number_format($cantidadxl*100/($cantidad4j+$cantidad3j+$cantidad2j+$cantidadj+$cantidadxl),2)}}%</td>
						  <td>{{$cantidadxl}}</td>
						  <td>{{$pesonetoxl}} KGS</td>
						  <td>{{$retornoxl}} USD</td>
						  <td>
									@if ($pesonetoxl)
										{{number_format($retornoxl/$pesonetoxl,2)}} USD/kg
									@else
										0 USD/kg
									@endif
								</td>
						</tr>
						@php
						  $calibrecount+=1;
						  $semanacount+=1;
						@endphp
					  @endif

					  @if ($cantidad4j>0 || $cantidad3j>0 || $cantidad2j>0 || $cantidadj>0 || $cantidadxl>0)
						<tr>
						  
						  <td> </td>
					  
					  
						  <td> </td>
						  <td> </td>
					  
						
						  <td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;">Total {{$semana}} </td>
					  
						
						
						
						  <td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
						  <td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
						  <td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{$cantidad4j+$cantidad3j+$cantidad2j+$cantidadj+$cantidadxl}}</td>
						  <td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{$pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl}} KGS</td>
						  <td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format($retorno4j+$retorno3j+$retorno2j+$retornoj+$retornoxl)}}  USD</td>
						  <td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format(($retorno4j+$retorno3j+$retorno2j+$retornoj+$retornoxl)/($pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl),2)}}  USD/KGS</td>
						  
						</tr>
					  @endif
					  @php
						  $semanacount+=1;
					  @endphp
					  
					@endforeach
					  @if ($cantidad4j>0 || $cantidad3j>0 || $cantidad2j>0 || $cantidadj>0 || $cantidadxl>0)
						<tr>
						  
							<td> </td>
						
						
							<td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;">Total {{$variedad}}</td>
						  
						  
							<td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
							<td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
						
						  
						  
						  
						  <td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
						  <td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;"></td>
						  <td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format($cantidad4j+$cantidad3j+$cantidad2j+$cantidadj+$cantidadxl)}}</td>
						  <td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format($pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl)}} KGS</td>
						  <td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format($retorno4j+$retorno3j+$retorno2j+$retornoj+$retornoxl)}}  USD</td>
						  <td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format(($retorno4j+$retorno3j+$retorno2j+$retornoj+$retornoxl)/($pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl))}}  USD/KG</td>
						  
						</tr>
					  @endif
		  
					  @php
						$variedadcount+=1;
					  @endphp
					
		  
				  @endforeach
		  
				  <tr>
						
					
				  
					  <td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;">Total General</td>
					
					  <td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
					
					  <td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
				  
					  <td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
				  
					
					
					<td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;"></td>
					<td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;"></td>
					<td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{$cantidadtotal}}</td>
					<td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{$pesonetototal}} KG</td>
					<td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{$retornototal}} USD</td>
					<td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format($retornototal/$pesonetototal,2)}} usd/kg</td>
					
				  </tr>
				 
				</tbody>
			</table>

			<div class="page-break"></div>
			<img src="{{asset('image/cabecera.png')}}" style="margin-top: 30px; margin-bottom: 15px;" alt="">
			<h3 style="text-align: center; margin: 0; line-height: 1;">EXPORTACIÓN FUERA DE NORMA</h3>
			<p style="text-align: center; margin: 0; line-height: 1;" >{{$razonsocial->name}}</p>
			
			<table id="balance" style="width:100%; border-collapse: collapse; margin-top: 20px;">
				<thead>
				  <tr>
					<th>Especie</th>
					<th>Categoría</th>
					<th>Variedad</th>
					
					<th>Serie</th>
					<th>% Curva<br>
						Calibre </th>
					<th>Cajas</th>
					<th>Peso Neto</th>
					<th>Retorno Neto<br> Total</th>
					<th>Retorno Kilo</th>
				  </tr>
				</thead>
				<tbody>
					@php
							$variedadcount=1;
							$supercantidadtotal=0;
							$superpesonetototal=0;
							$superretornototal=0;
						@endphp
					@foreach ($unique_categorias as $categoria)
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
							@endphp
		
							@foreach ($masas as $masa)
								@if (($masa->n_etiqueta=='Loica' || $masa->calibre=='L' || $masa->calibre=='LD') && $masa->n_categoria==$categoria && $categoria!='Vega')
								
									@if (($masa->calibre=='4J' || $masa->calibre=='4JD' || $masa->calibre=='4JDD') && $masa->n_variedad==$variedad)
											@php
												$cantidad4j+=$masa->cantidad;
												$pesoneto4j+=$masa->peso_caja;
												foreach ($fobs->where('n_variedad',$masa->n_variedad)->where('semana',$masa->semana) as $fob){
													$retorno4j+=intval($masa->peso_caja)*intval($fob->fob_kilo_salida);
													$retornototal+=intval($masa->peso_caja)*intval($fob->fob_kilo_salida);
												break;
												}
												$cantidadtotal+=$masa->cantidad;
												$pesonetototal+=$masa->peso_caja;
											@endphp	
									@endif
									@if (($masa->calibre=='3J' || $masa->calibre=='3JD' || $masa->calibre=='3JDD') && $masa->n_variedad==$variedad)
											@php
												$cantidad3j+=$masa->cantidad;
												$pesoneto3j+=$masa->peso_caja;
												foreach ($fobs->where('n_variedad',$masa->n_variedad)->where('semana',$masa->semana) as $fob){
													$retorno3j+=intval($masa->peso_caja)*intval($fob->fob_kilo_salida);
													$retornototal+=intval($masa->peso_caja)*intval($fob->fob_kilo_salida);
												break;
												}
												$cantidadtotal+=$masa->cantidad;
												$pesonetototal+=$masa->peso_caja;
											@endphp	
									@endif
									@if (($masa->calibre=='2J' || $masa->calibre=='2JD' || $masa->calibre=='2JDD') && $masa->n_variedad==$variedad)
											@php
												$cantidad2j+=$masa->cantidad;
												$pesoneto2j+=$masa->peso_caja;
												foreach ($fobs->where('n_variedad',$masa->n_variedad)->where('semana',$masa->semana) as $fob){
													$retorno2j+=intval($masa->peso_caja)*intval($fob->fob_kilo_salida);
													$retornototal+=intval($masa->peso_caja)*intval($fob->fob_kilo_salida);
												break;
												}
												$cantidadtotal+=$masa->cantidad;
												$pesonetototal+=$masa->peso_caja;
											@endphp	
									@endif
									@if (($masa->calibre=='J' || $masa->calibre=='JD' || $masa->calibre=='JDD') && $masa->n_variedad==$variedad)
											@php
												$cantidadj+=$masa->cantidad;
													$pesonetoj+=$masa->peso_caja;
													foreach ($fobs->where('n_variedad',$masa->n_variedad)->where('semana',$masa->semana) as $fob){
														$retornoj+=intval($masa->peso_caja)*intval($fob->fob_kilo_salida);
														$retornototal+=intval($masa->peso_caja)*intval($fob->fob_kilo_salida);
													break;
												}
													$cantidadtotal+=$masa->cantidad;
												$pesonetototal+=$masa->peso_caja;
											@endphp	
									@endif
									@if (($masa->calibre=='XL' || $masa->calibre=='XLD' || $masa->calibre=='XLDD') && $masa->n_variedad==$variedad)
											@php
												$cantidadxl+=$masa->cantidad;
												$pesonetoxl+=$masa->peso_caja;
												foreach ($fobs->where('n_variedad',$masa->n_variedad)->where('semana',$masa->semana) as $fob){
													$retornoxl+=intval($masa->peso_caja)*intval($fob->fob_kilo_salida);
													$retornototal+=intval($masa->peso_caja)*intval($fob->fob_kilo_salida);
												break;
												}
												$cantidadtotal+=$masa->cantidad;
												$pesonetototal+=$masa->peso_caja;
											@endphp	
									@endif
									@if (($masa->calibre=='L' || $masa->calibre=='LD') && $masa->n_variedad==$variedad)
											@php
												$cantidadl+=$masa->cantidad;
												$pesonetol+=$masa->peso_caja;
												foreach ($fobs->where('n_variedad',$masa->n_variedad)->where('semana',$masa->semana) as $fob){
													$retornol+=intval($masa->peso_caja)*intval($fob->fob_kilo_salida);
													$retornototal+=intval($masa->peso_caja)*intval($fob->fob_kilo_salida);
												break;
												}
												$cantidadtotal+=$masa->cantidad;
												$pesonetototal+=$masa->peso_caja;
											@endphp	
									@endif
								
								@endif
								
							@endforeach

							@if (($pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl+$pesonetol)>0)
								
								
									@if (($unique_calibres->contains('4J') || $unique_calibres->contains('4JD') || $unique_calibres->contains('4JDD')) && $pesoneto4j>0)
										<tr>
											@if ($variedadcount==1 && $calibrecount==1)
												<td>Cherries</td>
											@else
												<td> </td>
											@endif
											@if ($calibrecount==1)
												<td>{{$categoria}}</td>
											@else
												<td> </td>
											@endif
											@if ($calibrecount==1)
												<td>{{$variedad}}</td>
											@else
												<td> </td>
											@endif
											
											
											
											
											<td>4J</td>
											@if (($cantidad4j+$cantidad3j+$cantidad2j+$cantidadj+$cantidadxl+$cantidadl)>0)
												<td>{{number_format($cantidad4j*100/($cantidad4j+$cantidad3j+$cantidad2j+$cantidadj+$cantidadxl+$cantidadl),2)}}%</td>
											@else
												<td>0</td>
											@endif
												
											<td>{{$cantidad4j}}</td>
											<td>{{$pesoneto4j}} KGS</td>
											<td>{{$retorno4j}} USD</td>
											<td>
												@if ($pesoneto4j)
													{{number_format($retorno4j/$pesoneto4j,2)}} USD/kg
												@else
													0 USD/kg
												@endif
											</td>
											
										</tr>
										@php
											$calibrecount+=1;
										@endphp
									@endif
									
									@if (($unique_calibres->contains('3J') || $unique_calibres->contains('3JD') || $unique_calibres->contains('3JDD')) && $pesoneto3j>0)
										<tr>
											@if ($variedadcount==1 && $calibrecount==1)
												<td>Cherries</td>
											@else
												<td> </td>
											@endif
											@if ($calibrecount==1)
												<td>{{$categoria}}</td>
											@else
												<td> </td>
											@endif
											@if ($calibrecount==1)
												<td>{{$variedad}}</td>
											@else
												<td> </td>
											@endif
											
											
											
											<td>3J</td>
											@if (($cantidad4j+$cantidad3j+$cantidad2j+$cantidadj+$cantidadxl+$cantidadl)>0)
												<td>{{number_format($cantidad3j*100/($cantidad4j+$cantidad3j+$cantidad2j+$cantidadj+$cantidadxl+$cantidadl),2)}}%</td>
											@else
												<td>0</td>	
											@endif

											<td>{{$cantidad3j}}</td>
											<td>{{$pesoneto3j}} KGS</td>
											<td>{{$retorno3j}} USD</td>
											<td>
												@if ($pesoneto3j)
													{{number_format($retorno3j/$pesoneto3j,2)}} USD/kg
												@else
													0 USD/kg
												@endif
											</td>
											
										</tr>
										@php
											$calibrecount+=1;
										@endphp
									@endif
									
									@if (($unique_calibres->contains('2J') || $unique_calibres->contains('2JD') || $unique_calibres->contains('2JDD')) && $pesoneto2j>0)
										<tr>
											@if ($variedadcount==1 && $calibrecount==1)
												<td>Cherries</td>
											@else
												<td> </td>
											@endif
											@if ($calibrecount==1)
												<td>{{$categoria}}</td>
											@else
												<td> </td>
											@endif
											@if ($calibrecount==1)
												<td>{{$variedad}}</td>
											@else
												<td> </td>
											@endif
											
											
											
											<td>2J</td>

											@if (($cantidad4j+$cantidad3j+$cantidad2j+$cantidadj+$cantidadxl+$cantidadl)>0)
												<td>{{number_format($cantidad2j*100/($cantidad4j+$cantidad3j+$cantidad2j+$cantidadj+$cantidadxl+$cantidadl),2)}}%</td>
											@else
												<td>0</td>
											@endif
											
											<td>{{$cantidad2j}}</td>
											<td>{{$pesoneto2j}} KGS</td>
											<td>{{$retorno2j}} USD</td>
											<td>
												@if ($pesoneto2j)
													{{number_format($retorno2j/$pesoneto2j,2)}} USD/kg
												@else
													0 USD/kg
												@endif
											</td>
											
										</tr>
										@php
											$calibrecount+=1;
										@endphp
									@endif
									
									@if (($unique_calibres->contains('J') || $unique_calibres->contains('JD') || $unique_calibres->contains('JDD')) && $pesonetoj>0)
										<tr>
											@if ($variedadcount==1 && $calibrecount==1)
												<td>Cherries</td>
											@else
												<td> </td>
											@endif
											@if ($calibrecount==1)
												<td>{{$categoria}}</td>
											@else
												<td> </td>
											@endif
											@if ($calibrecount==1)
												<td>{{$variedad}}</td>
											@else
												<td> </td>
											@endif
											
											
											
											
											<td>J</td>
											@if (($cantidad4j+$cantidad3j+$cantidad2j+$cantidadj+$cantidadxl+$cantidadl)>0)
												<td>{{number_format($cantidadj*100/($cantidad4j+$cantidad3j+$cantidad2j+$cantidadj+$cantidadxl+$cantidadl),2)}}%</td>
											@else
												<td>0</td>
											@endif
											
											<td>{{$cantidadj}}</td>
											<td>{{$pesonetoj}} KGS</td>
											<td>{{$retornoj}} USD</td>
											<td>
												@if ($pesonetoj)
													{{number_format($retornoj/$pesonetoj,2)}} USD/kg
												@else
													0 USD/kg
												@endif
											</td>
				
											
										</tr>
										@php
											$calibrecount+=1;
										@endphp
									@endif
									
									@if (($unique_calibres->contains('XL') || $unique_calibres->contains('XLD') || $unique_calibres->contains('XLDD')) && $pesonetoxl>0)
										<tr>
											@if ($variedadcount==1 && $calibrecount==1)
												<td>Cherries</td>
											@else
												<td> </td>
											@endif
											@if ($calibrecount==1)
												<td>{{$categoria}}</td>
											@else
												<td> </td>
											@endif
											@if ($calibrecount==1)
												<td>{{$variedad}}</td>
											@else
												<td> </td>
											@endif
											
											
											
											
											<td>XL</td>
											@if (($cantidad4j+$cantidad3j+$cantidad2j+$cantidadj+$cantidadxl+$cantidadl)>0)
												<td>{{number_format($cantidadxl*100/($cantidad4j+$cantidad3j+$cantidad2j+$cantidadj+$cantidadxl+$cantidadl),2)}}%</td>
											@else
												<td>0</td>	
											@endif

											<td>{{$cantidadxl}}</td>
											<td>{{$pesonetoxl}} KGS</td>
											<td>{{$retornoxl}} USD</td>
											<td>
												@if ($pesonetoxl)
													{{number_format($retornoxl/$pesonetoxl,2)}} USD/kg
												@else
													0 USD/kg
												@endif
											</td>
											
										</tr>
										@php
											$calibrecount+=1;
										@endphp
									@endif
									
									@if (($unique_calibres->contains('L') || $unique_calibres->contains('LD')) && $pesonetol>0)
										<tr>
											@if ($variedadcount==1 && $calibrecount==1)
												<td>Cherries</td>
											@else
												<td> </td>
											@endif
											@if ($calibrecount==1)
												<td>{{$categoria}}</td>
											@else
												<td> </td>
											@endif
											@if ($calibrecount==1)
												<td>{{$variedad}}</td>
											@else
												<td> </td>
											@endif
											
											
											
											
											<td>L</td>
											@if (($cantidadl+$cantidad4j+$cantidad3j+$cantidad2j+$cantidadj+$cantidadxl)>0)
												<td>{{number_format($cantidadl*100/($cantidadl+$cantidad4j+$cantidad3j+$cantidad2j+$cantidadj+$cantidadxl),2)}}%</td>
											@else
												<td>0</td>	
											@endif

											<td>{{$cantidadl}}</td>
											<td>{{$pesonetol}} KGS</td>
											<td>{{$retornol}} USD</td>
											<td>
												@if ($pesonetol)
													{{number_format($retornol/$pesonetol,2)}} USD/kg
												@else
													0 USD/kg
												@endif
											</td>
											
										</tr>
										@php
											$calibrecount+=1;
										@endphp
									@endif
		
									
									<tr>
										
											<td> </td>
											<td> </td>
									
									
											<td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;">Total {{$variedad}}</td>
										
										
											
										
										
										
										<td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
										<td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;">100,00%</td>
										<td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{$cantidad4j+$cantidad3j+$cantidad2j+$cantidadj+$cantidadxl+$cantidadl}}</td>
										<td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{$pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl+$pesonetol}} KGS</td>
										<td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{$retorno4j+$retorno3j+$retorno2j+$retornoj+$retornoxl+$retornol}} USD</td>
										@if (($pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl+$pesonetol)>0)
											<td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format(($retorno4j+$retorno3j+$retorno2j+$retornoj+$retornoxl+$retornol)/($pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj+$pesonetoxl+$pesonetol),2)}} USD/KG</td>
										@else
											<td>0</td>	
										@endif
									</tr>
								
		
								@php
									$variedadcount+=1;
									
							
									$supercantidadtotal+=$cantidadtotal;
									$superpesonetototal+=$pesonetototal;
									$superretornototal+=$retornototal; 
						
								@endphp
							
							@endif
		
						@endforeach

						@if (($cantidadtotal+$pesonetototal)>0)
							<tr>
										
								
									<td></td>
									<td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;">Total {{$categoria}}</td>
								
								
								
									<td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
							
								
								
								<td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;"></td>
								<td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;"></td>
								<td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{$cantidadtotal}}</td>
								<td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{$pesonetototal}} KGS</td>
								<td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{$retornototal}} USD</td>
								@if ($pesonetototal>0)
									<td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format($retornototal/$pesonetototal,2)}} usd/kg</td>
								@else
									<td>0</td>
								@endif
							</tr>
						@endif

					@endforeach

					<tr>
											
									
								
							<td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;">Total</td>
						
						
							<td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
					
							<td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;"> </td>
					
						
						
						<td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;"></td>
						<td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;"></td>
						<td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{$supercantidadtotal}}</td>
						<td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{$superpesonetototal}} KGS</td>
						<td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{$superretornototal}} USD</td>
						@if ($superpesonetototal>0)
							<td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{number_format($superretornototal/$superpesonetototal,2)}} usd/kg</td>
						@else
							<td>0</td>
						@endif
					</tr>
	
				</tbody>
			</table>

			<div class="page-break"></div>
			<img src="{{asset('image/cabecera.png')}}" style="margin-top: 30px; margin-bottom: 15px;" alt="">
			<h3 style="text-align: center; margin: 0; line-height: 1;">FRUTA COMERCIAL</h3>
			<p style="text-align: center; margin: 0; line-height: 1;" >{{$razonsocial->name}}</p>

			<table id="balance" style="width:70%; border-collapse: collapse; margin-top: 20px;">
				<thead>
				  <tr>
					
					<th>Variedad</th>
					
					<th>Serie</th>
					
				
					<th>Peso Neto</th>
					<th>Ingreso Comercial</th>
					
				  </tr>
				</thead>
				<tbody>
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
							@if ($masa->calibre=='Comercial' || $masa->calibre=='Precalibre' || $masa->calibre=='Desecho' || $masa->calibre=='Merma')
								@if (($masa->calibre=='Comercial') && $masa->n_variedad==$variedad)
										@php
											$cantidad4j+=$masa->cantidad;
											$pesoneto4j+=$masa->peso_caja;
											foreach ($fobs->where('n_variedad',$masa->n_variedad)->where('semana',$masa->semana) as $fob){
												$retorno4j+=intval($masa->peso_caja)*intval($fob->fob_kilo_salida);
												$retornototal+=intval($masa->peso_caja)*intval($fob->fob_kilo_salida);
											break;
											}
											$cantidadtotal+=$masa->cantidad;
											$pesonetototal+=$masa->peso_caja;
										@endphp	
								@endif
								@if (($masa->calibre=='Precalibre') && $masa->n_variedad==$variedad)
										@php
											$cantidad3j+=$masa->cantidad;
											$pesoneto3j+=$masa->peso_caja;
											foreach ($fobs->where('n_variedad',$masa->n_variedad)->where('semana',$masa->semana) as $fob){
												$retorno3j+=intval($masa->peso_caja)*intval($fob->fob_kilo_salida);
												$retornototal+=intval($masa->peso_caja)*intval($fob->fob_kilo_salida);
											break;
											}
											$cantidadtotal+=$masa->cantidad;
											$pesonetototal+=$masa->peso_caja;
										@endphp	
								@endif
								@if (($masa->calibre=='Desecho') && $masa->n_variedad==$variedad)
										@php
											$cantidad2j+=$masa->cantidad;
											$pesoneto2j+=$masa->peso_caja;
											foreach ($fobs->where('n_variedad',$masa->n_variedad)->where('semana',$masa->semana) as $fob){
												$retorno2j+=intval($masa->peso_caja)*intval($fob->fob_kilo_salida);
												$retornototal+=intval($masa->peso_caja)*intval($fob->fob_kilo_salida);
											break;
											}
											$cantidadtotal+=$masa->cantidad;
											$pesonetototal+=$masa->peso_caja;
										@endphp	
								@endif
								@if (($masa->calibre=='Merma') && $masa->n_variedad==$variedad)
										@php
											$cantidadj+=$masa->cantidad;
											$pesonetoj+=$masa->peso_caja;
											foreach ($fobs->where('n_variedad',$masa->n_variedad)->where('semana',$masa->semana) as $fob){
												$retornoj+=intval($masa->peso_caja)*intval($fob->fob_kilo_salida);
												$retornototal+=intval($masa->peso_caja)*intval($fob->fob_kilo_salida);
												break;
											}
											$cantidadtotal+=$masa->cantidad;
											$pesonetototal+=$masa->peso_caja;
										@endphp	
								@endif
								
								
							@endif
							
						@endforeach
	
							@if ($pesoneto4j>0)
								<tr>
									
									@if ($calibrecount==1)
										<td>{{$variedad}}</td>
									@else
										<td> </td>
									@endif
									
									
									
									
									<td>Comercial</td>
									
									<td>{{$pesoneto4j}} KGS</td>
									<td>{{$retorno4j}} USD</td>
									
									
								</tr>
								@php
									$calibrecount+=1;
								@endphp
							@endif
							@if ($pesoneto3j>0)
								<tr>
									
									@if ($calibrecount==1)
										<td>{{$variedad}}</td>
									@else
										<td> </td>
									@endif
									
									
									
									<td>Precalibre</td>
									
									
									<td>{{$pesoneto3j}} KGS</td>
									<td>{{$retorno3j}} USD</td>
									
									
								</tr>
								@php
									$calibrecount+=1;
								@endphp
							@endif
							@if ($pesoneto2j>0)
								<tr>
								
									@if ($calibrecount==1)
										<td>{{$variedad}}</td>
									@else
										<td> </td>
									@endif
									
									
									
									<td>Desecho</td>
									
								
									<td>{{$pesoneto2j}} KGS</td>
									<td>{{$retorno2j}} USD</td>
									
									
								</tr>
								@php
									$calibrecount+=1;
								@endphp
							@endif
							@if ($pesonetoj>0)
								<tr>
								
									@if ($calibrecount==1)
										<td>{{$variedad}}</td>
									@else
										<td> </td>
									@endif
									
									
									
									<td>Merma</td>
									
								
									<td>{{$pesonetoj}} KGS</td>
									<td>{{$retornoj}} USD</td>
									
									
								</tr>
								@php
									$calibrecount+=1;
								@endphp
							@endif

							
	
							<tr>
								
									
							
								<td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;">Total {{$variedad}}</td>
								
								<td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;"></td>
								<td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{$pesoneto4j+$pesoneto3j+$pesoneto2j+$pesonetoj}} KGS</td>
								<td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{$retorno4j+$retorno3j+$retorno2j+$retornoj}} USD</td>
								
							</tr>
							
	
							@php
								$variedadcount+=1;
							@endphp
						
	
					@endforeach
	
					<tr>
								
						
					
							<td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;">Total</td>
						
						
						
						
						
						<td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;"></td>
						<td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{$pesonetototal}} KGS</td>
						<td style="border-top: 2px solid black; border-bottom: 2px solid black; padding-bottom: 4px; margin-top: 10px; font-weight: bold;">{{$retornototal}} USD</td>
						
					</tr>
							
	
				</tbody>
			</table>
 --}}
		
	</body>
</html>