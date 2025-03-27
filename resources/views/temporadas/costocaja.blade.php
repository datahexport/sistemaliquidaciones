<x-app-layout>

    <div>
       @livewire('new-nav')
        
        <div class="flex overflow-hidden bg-white pt-16">
           <aside id="sidebar" class="fixed hidden z-20 h-full top-0 left-0 pt-16 flex lg:flex flex-shrink-0 flex-col w-64 transition-width duration-75" aria-label="Sidebar">
              @livewire('aside-liquidaciones', ['temporada' => $temporada->id])
           </aside>
           <div class="bg-gray-900 opacity-50 hidden fixed inset-0 z-10" id="sidebarBackdrop"></div>
           <div id="main-content" class="h-full w-full bg-gray-50 relative overflow-y-auto lg:ml-64" x-data="{alert:true}">
              <main class="max-w-6xl m-4">
               <h1 class="text-center mt-8 mb-4 font-bold">Tarifas Costos Caja</h1>
               <div class="flex justify-center">
                  @if (session('info'))
                        <div x-show="alert" class="font-regular relative block w-full max-w-screen-md rounded-lg bg-green-500 px-4 py-4 text-base text-white my-2" data-dismissible="alert">
                           <div class="absolute top-4 left-4">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" class="mt-px h-6 w-6">
                                    <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd"></path>
                              </svg>
                           </div>
                           <div class="ml-8 mr-12">
                              <h5 class="block font-sans text-xl font-semibold leading-snug tracking-normal text-white antialiased">
                                    {{ session('info') }}
                              </h5>
                           </div>
                           <div data-dismissible-target="alert" x-on:click="alert=false" data-ripple-dark="true" class="absolute top-3 right-3 w-max rounded-lg transition-all hover:bg-white hover:bg-opacity-20">
                              <div role="button" class="w-max rounded-lg p-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                       <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                              </div>
                           </div>
                        </div>
                  @endif
               </div>
                        @php
                              $totalotroscostos= $temporada->pti +
                                          $temporada->tecomex +
                                          $temporada->coface +
                                          $temporada->safe_cargo +
                                          $temporada->transportes +
                                          $temporada->gastos_de_exportacion +
                                          $temporada->fedex +
                                          $temporada->seguro_carga_fester +
                                          $temporada->seguro_carga_maerk +
                                          $temporada->asoex;
                              $pesocom=0;
                              $peso2=0;
                              $peso25=0;
                              $peso5=0;
                              $peso10=0;
                        @endphp
               @foreach ($procesosall as $proceso)
               @if ($proceso->PESO_CAJA=="2.2")
                  @php
                     $peso2+=$proceso->PESO_PRORRATEADO;
                  @endphp
               @elseif ($proceso->PESO_CAJA=="2.5")
                  @php
                     $peso25+=$proceso->PESO_PRORRATEADO;
                  @endphp

               @elseif ($proceso->PESO_CAJA=="5")
                  @php
                     $peso5+=$proceso->PESO_PRORRATEADO;
                  @endphp

               @elseif ($proceso->PESO_CAJA=="10")
                  @php
                     $peso10+=$proceso->PESO_PRORRATEADO;
                  @endphp

               @elseif ($proceso->CRITERIO=="COMERCIAL")
                  @php
                     $pesocom+=$proceso->PESO_PRORRATEADO;
                  @endphp
                     
               @endif
               @endforeach
               <div class="overflow-x-auto mb-4">
                  {!! Form::model($temporada, ['route'=>['temporadas.update',$temporada],'method' => 'put', 'autocomplete'=>'off']) !!}    

                     <table class="min-w-full bg-white border border-gray-200">
                        <thead class="bg-gray-200">
                           <tr>
                                 <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">EMBALAJE</th>
                                 <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">KG.</th>
                                 <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">OTROS COSTOS</th>
                                 <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">T. MATERIALES</th>
                                 <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">MATERIALES</th>
                                 <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">T. PROCESO</th>
                                 <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">PROCESO</th>
                                 <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">TOTAL COSTOS</th>
                           </tr>
                        </thead>
                        <tbody class="bg-white">
                           <tr>
                                 <td class="px-6 py-4 border-b border-gray-200">COSTO COMERCIAL</td>
                                 <td class="px-6 py-4 border-b border-gray-200">{{number_format($pesocom)}}</td>
                                 <td class="px-6 py-4 border-b border-gray-200 whitespace-nowrap"></td>
                                 <td class="px-6 py-4 border-b border-gray-200"></td>
                                 <td class="px-6 py-4 border-b border-gray-200"></td>
                                 <td class="px-6 py-4 border-b border-gray-200 whitespace-nowrap">
                                 
                                       {!! Form::label('procesocom', 'Proceso', ['class' => 'hidden']) !!}
                                       {!! Form::number('procesocom', null, ['step' => '0.00001', 'class' => 'text-right w-28 mt-1 rounded-lg' . ($errors->has('seguro_carga_maerk') ? ' border-red-600' : '')]) !!}
                                 </td>
                                 <td class="px-6 py-4 border-b border-gray-200 whitespace-nowrap">USD {{number_format($temporada->procesocom*$pesocom,2)}}</td>
                                 <td class="px-6 py-4 border-b border-gray-200 whitespace-nowrap">USD {{number_format($temporada->procesocom*$pesocom,2)}}</td>
                           </tr>
                           <tr>
                                 <td class="px-6 py-4 border-b border-gray-200">COSTO COMERCIAL ELEGIDO</td>
                                 <td class="px-6 py-4 border-b border-gray-200">{{number_format($peso10)}}</td>
                                 <td class="px-6 py-4 border-b border-gray-200 whitespace-nowrap">USD {{number_format(($totalotroscostos*$peso10)/($peso2+$peso25+$peso5+$peso10),2)}}</td>
                                 <td class="px-6 py-4 border-b border-gray-200 whitespace-nowrap">
                                    {!! Form::label('materiales10', 'materiales', ['class' => 'hidden']) !!}
                                    {!! Form::number('materiales10', null, ['step' => '0.0001', 'class' => 'text-right w-24 mt-1 rounded-lg']) !!}
                                 </td>
                                 <td class="px-6 py-4 border-b border-gray-200 whitespace-nowrap">USD {{number_format($temporada->materiales10*$peso10,2)}}</td>
                                 <td class="px-6 py-4 border-b border-gray-200 whitespace-nowrap">
                                    
                                       {!! Form::label('proceso10', 'Proceso', ['class' => 'hidden']) !!}
                                       {!! Form::number('proceso10', null, ['step' => '0.00001', 'class' => 'text-right block w-full mt-1 rounded-lg' . ($errors->has('seguro_carga_maerk') ? ' border-red-600' : '')]) !!}
                                 </td>
                                 <td class="px-6 py-4 border-b border-gray-200 whitespace-nowrap">USD {{number_format($temporada->proceso10*$peso10,2)}}</td>

                                 <td class="px-6 py-4 border-b border-gray-200 whitespace-nowrap">USD {{number_format(((($totalotroscostos)*$peso10)/($peso2+$peso25+$peso5+$peso10))+($temporada->materiales10+$temporada->proceso10)*$peso10,2)}}</td>
                              
                           </tr>
                           <tr>
                                 <td class="px-6 py-4 border-b border-gray-200">COSTO EXPORTACIÓN 5 KG</td>
                                 <td class="px-6 py-4 border-b border-gray-200">{{number_format($peso5)}}</td>
                                 <td class="px-6 py-4 border-b border-gray-200 whitespace-nowrap">USD {{number_format(($totalotroscostos*$peso5)/($peso2+$peso25+$peso5+$peso10),2)}}</td>
                                 <td class="px-6 py-4 border-b border-gray-200 whitespace-nowrap">
                                    {!! Form::label('materiales5', 'materiales', ['class' => 'hidden']) !!}
                                    {!! Form::number('materiales5', null, ['step' => '0.0001', 'class' => 'text-right block w-full mt-1 rounded-lg']) !!}
                                 </td>
                                 <td class="px-6 py-4 border-b border-gray-200 whitespace-nowrap">USD {{number_format($temporada->materiales5*$peso5,2)}}</td>
                                 <td class="px-6 py-4 border-b border-gray-200 whitespace-nowrap">
                                    
                                    {!! Form::label('proceso5', 'Proceso', ['class' => 'hidden']) !!}
                                    {!! Form::number('proceso5', null, ['step' => '0.00001', 'class' => 'text-right block w-full mt-1 rounded-lg' . ($errors->has('seguro_carga_maerk') ? ' border-red-600' : '')]) !!}
                                 </td>
                                 <td class="px-6 py-4 border-b border-gray-200 whitespace-nowrap">USD {{number_format($temporada->proceso5*$peso5,2)}}</td>

                                 <td class="px-6 py-4 border-b border-gray-200 whitespace-nowrap">USD {{number_format(((($totalotroscostos)*$peso5)/($peso2+$peso25+$peso5+$peso10))+($temporada->materiales5+$temporada->proceso5)*$peso5,2)}}</td>
                              
                           </tr>
                           <tr>
                                 <td class="px-6 py-4 border-b border-gray-200">COSTO EXPORTACIÓN 2,5 KG</td>
                                 <td class="px-6 py-4 border-b border-gray-200">{{number_format($peso25)}}</td>
                                 <td class="px-6 py-4 border-b border-gray-200 whitespace-nowrap">USD {{number_format(($totalotroscostos*$peso25)/($peso2+$peso25+$peso5+$peso10),2)}}</td>
                                 <td class="px-6 py-4 border-b border-gray-200 whitespace-nowrap">
                                    {!! Form::label('materiales25', 'materiales', ['class' => 'hidden']) !!}
                                    {!! Form::number('materiales25', null, ['step' => '0.0001', 'class' => 'text-right block w-full mt-1 rounded-lg']) !!}
                                 </td>
                                 <td class="px-6 py-4 border-b border-gray-200 whitespace-nowrap">USD {{number_format($temporada->materiales25*$peso25,2)}}</td>
                                 <td class="px-6 py-4 border-b border-gray-200 whitespace-nowrap">
                                    
                                    {!! Form::label('proceso25', 'Proceso', ['class' => 'hidden']) !!}
                                    {!! Form::number('proceso25', null, ['step' => '0.00001', 'class' => 'text-right block w-full mt-1 rounded-lg' . ($errors->has('seguro_carga_maerk') ? ' border-red-600' : '')]) !!}
                                 </td>
                                 <td class="px-6 py-4 border-b border-gray-200 whitespace-nowrap">USD {{number_format($temporada->proceso25*$peso25,2)}}</td>

                                 <td class="px-6 py-4 border-b border-gray-200 whitespace-nowrap">USD {{number_format(((($totalotroscostos)*$peso25)/($peso2+$peso25+$peso5+$peso10))+($temporada->materiales25+$temporada->proceso5)*$peso25,2)}}</td>
                           </tr>
                           <tr>
                                 <td class="px-6 py-4 border-b border-gray-200">COSTO EXPORTACIÓN 2,2 KG</td>
                                 <td class="px-6 py-4 border-b border-gray-200">{{number_format($peso2)}}</td>
                                 <td class="px-6 py-4 border-b border-gray-200 whitespace-nowrap">USD {{number_format(($totalotroscostos*$peso2)/($peso2+$peso25+$peso5+$peso10),2)}}</td>
                                 <td class="px-6 py-4 border-b border-gray-200 whitespace-nowrap">
                                    {!! Form::label('materiales22', 'materiales', ['class' => 'hidden']) !!}
                                    {!! Form::number('materiales22', null, ['step' => '0.0001', 'class' => 'text-right block w-full mt-1 rounded-lg']) !!}
                                 </td>
                                 <td class="px-6 py-4 border-b border-gray-200 whitespace-nowrap">USD {{number_format($temporada->materiales22*$peso2,2)}}</td>
                                 <td class="px-6 py-4 border-b border-gray-200 whitespace-nowrap">
                                    
                                    {!! Form::label('proceso22', 'Proceso', ['class' => 'hidden']) !!}
                                    {!! Form::number('proceso22', null, ['step' => '0.00001', 'class' => 'text-right block w-full mt-1 rounded-lg' . ($errors->has('seguro_carga_maerk') ? ' border-red-600' : '')]) !!}
                                 </td>
                                 <td class="px-6 py-4 border-b border-gray-200 whitespace-nowrap">USD {{number_format($temporada->proceso22*$peso2,2)}}</td>

                                 <td class="px-6 py-4 border-b border-gray-200 whitespace-nowrap">USD {{number_format(((($totalotroscostos)*$peso2)/($peso2+$peso25+$peso5+$peso10))+($temporada->materiales22+$temporada->proceso22)*$peso2,2)}}</td>
                           </tr>
                           @php
                               $totalmateriales=$temporada->materiales10*$peso10+$temporada->materiales5*$peso5+$temporada->materiales25*$peso25+$temporada->materiales22*$peso2;
                               $totalprocesos=$temporada->procesocom*$pesocom+$temporada->proceso10*$peso10+$temporada->proceso5*$peso5+$temporada->proceso25*$peso25+$temporada->proceso22*$peso2;
                           @endphp
                           <tr class="bg-gray-100">
                                 <td class="px-6 py-4 border-b border-gray-200">COSTO CAJA/KG</td>
                                 <td class="px-6 py-4 border-b border-gray-200">{{number_format($pesocom+$peso2+$peso25+$peso5+$peso10,1)}}</td>
                                 <td class="px-6 py-4 border-b border-gray-200 whitespace-nowrap">USD {{number_format($totalotroscostos,2)}}</td>
                                 <td></td>
                                 <td class="px-6 py-4 border-b border-gray-200">USD {{number_format($totalmateriales,2)}}</td>
                                 <td></td>
                                 <td class="px-6 py-4 border-b border-gray-200">USD {{number_format($totalprocesos,2)}}</td>
                                 <td class="px-6 py-4 border-b border-gray-200 whitespace-nowrap">USD {{number_format($totalotroscostos+($temporada->materiales10*$peso10+$temporada->materiales5*$peso5+$temporada->materiales25*$peso25+$temporada->materiales22*$peso2)+($temporada->procesocom*$pesocom+$temporada->proceso10*$peso10+$temporada->proceso5*$peso5+$temporada->proceso25*$peso25+$temporada->proceso22*$peso2),2)}}</td>
                           </tr>
                        </tbody>
                     </table>
                     <div class="flex justify-end">
                        {!! Form::submit('Actualizar Datos', ['class' => 'font-bold py-2 px-4 rounded bg-blue-500 text-white cursor-pointer']) !!}
                     </div>
                  {!! Form::close() !!}
               </div>

               <h1 class="text-center mb-4 font-bold">Costos Caja</h1>

               {!! Form::model($temporada, ['route'=>['temporadas.update',$temporada],'method' => 'put', 'autocomplete'=>'off']) !!}    
                     <div class="grid grid-cols-2 p-4 gap-x-4">
                        <style>
                           .form-label {
                                 width: 150px;
                                 min-width: 150px;
                           }
                           .form-input {
                                 width: calc(100% - 150px);
                           }
                        </style>
                        <div>
                           @csrf
                          
                           
                           <div class="mb-2 flex items-center bg-red-300 px-2 rounded-md">
                                 {!! Form::label('pti', 'PTI', ['class' => 'form-label']) !!}
                                 {!! Form::number('pti', null, ['step' => '0.01', 'class' => 'form-input text-right block w-full my-1 rounded-lg' . ($errors->has('pti') ? ' border-red-600' : '')]) !!}
                                 @error('pti')
                                    <strong class="text-xs text-red-600">{{$message}}</strong>
                                 @enderror
                           </div>
                           <div class="mb-2 flex items-center bg-red-300 px-2 rounded-md">
                                 {!! Form::label('pti_terceros', 'PTI Terceros', ['class' => 'form-label']) !!}
                                 {!! Form::number('pti_terceros', null, ['step' => '0.01', 'class' => 'form-input text-right block w-full my-1 rounded-lg' . ($errors->has('pti_terceros') ? ' border-red-600' : '')]) !!}
                                 @error('pti_terceros')
                                    <strong class="text-xs text-red-600">{{$message}}</strong>
                                 @enderror
                           </div>
                          

                           <div class="mb-2 flex items-center bg-red-300 px-2 rounded-md">
                              {!! Form::label('tecomex', 'Tecomex', ['class' => 'form-label']) !!}
                              {!! Form::number('tecomex', null, ['step' => '0.01', 'class' => 'form-input text-right block w-full my-1 rounded-lg' . ($errors->has('tecomex') ? ' border-red-600' : '')]) !!}
                              @error('tecomex')
                                 <strong class="text-xs text-red-600">{{$message}}</strong>
                              @enderror
                           </div>
                          
                           <div class="mb-2 flex items-center bg-red-300 px-2 rounded-md">
                              {!! Form::label('safe_cargo', 'Safe Cargo', ['class' => 'form-label']) !!}
                              {!! Form::number('safe_cargo', null, ['step' => '0.01', 'class' => 'form-input text-right block w-full my-1 rounded-lg' . ($errors->has('tecomex') ? ' border-red-600' : '')]) !!}
                              @error('safe_cargo')
                                 <strong class="text-xs text-red-600">{{$message}}</strong>
                              @enderror
                           </div>
                           <div class="mb-2 flex items-center bg-red-300 px-2 rounded-md">
                              {!! Form::label('transportes', 'Transportes', ['class' => 'form-label']) !!}
                              {!! Form::number('transportes', null, ['step' => '0.01', 'class' => 'form-input text-right block w-full my-1 rounded-lg' . ($errors->has('transportes') ? ' border-red-600' : '')]) !!}
                              @error('transportes')
                                 <strong class="text-xs text-red-600">{{$message}}</strong>
                              @enderror
                           </div>
                           <div class="mb-2 flex items-center bg-red-300 px-2 rounded-md">
                              {!! Form::label('coface', 'Coface', ['class' => 'form-label']) !!}
                              {!! Form::number('coface', null, ['step' => '0.01', 'class' => 'form-input text-right block w-full my-1 rounded-lg' . ($errors->has('coface') ? ' border-red-600' : '')]) !!}
                              @error('coface')
                                 <strong class="text-xs text-red-600">{{$message}}</strong>
                              @enderror
                           </div>
                           <div class="mb-2 flex items-center bg-red-300 px-2 rounded-md">
                                 {!! Form::label('gastos_de_exportacion', 'Gastos de Exportación', ['class' => 'form-label']) !!}
                                 {!! Form::number('gastos_de_exportacion', null, ['step' => '0.01', 'class' => 'form-input text-right block w-full my-1 rounded-lg' . ($errors->has('gastos_de_exportacion') ? ' border-red-600' : '')]) !!}
                                 @error('gastos_de_exportacion')
                                    <strong class="text-xs text-red-600">{{$message}}</strong>
                                 @enderror
                           </div>
                           <div class="mb-2 flex items-center bg-red-300 px-2 rounded-md">
                              {!! Form::label('fedex', 'Fedex', ['class' => 'form-label']) !!}
                              {!! Form::number('fedex', null, ['step' => '0.01', 'class' => 'form-input text-right block w-full my-1 rounded-lg' . ($errors->has('fedex') ? ' border-red-600' : '')]) !!}
                              @error('fedex')
                                 <strong class="text-xs text-red-600">{{$message}}</strong>
                              @enderror
                           </div>
                           
                         
                        </div>
                        <div>
                          
                           
                           <div class="mb-2 flex items-center bg-red-300 px-2 rounded-md">
                                 {!! Form::label('seguro_carga_fester', 'Seguro Carga Fester', ['class' => 'form-label']) !!}
                                 {!! Form::number('seguro_carga_fester', null, ['step' => '0.01', 'class' => 'form-input text-right block w-full my-1 rounded-lg' . ($errors->has('seguro_carga_fester') ? ' border-red-600' : '')]) !!}
                                 @error('seguro_carga_fester')
                                    <strong class="text-xs text-red-600">{{$message}}</strong>
                                 @enderror
                           </div>
                           <div class="mb-2 flex items-center bg-red-300 px-2 rounded-md">
                                 {!! Form::label('seguro_carga_maerk', 'Seguro Carga Maerk', ['class' => 'form-label']) !!}
                                 {!! Form::number('seguro_carga_maerk', null, ['step' => '0.01', 'class' => 'form-input text-right block w-full my-1 rounded-lg' . ($errors->has('seguro_carga_maerk') ? ' border-red-600' : '')]) !!}
                                 @error('seguro_carga_maerk')
                                    <strong class="text-xs text-red-600">{{$message}}</strong>
                                 @enderror
                           </div>
                           <div class="mb-2 flex items-center bg-red-300 px-2 rounded-md">
                                 {!! Form::label('asoex', 'Asoex', ['class' => 'form-label']) !!}
                                 {!! Form::number('asoex', null, ['step' => '0.01', 'class' => 'form-input text-right block w-full my-1 rounded-lg' . ($errors->has('asoex') ? ' border-red-600' : '')]) !!}
                                 @error('asoex')
                                    <strong class="text-xs text-red-600">{{$message}}</strong>
                                 @enderror
                           </div>
                           <div class="mb-2 flex items-center bg-red-500 px-2 rounded-md">
                              @php
                                 $subtotal = $temporada->pti +
                                          $temporada->pti_terceros +
                                          $temporada->tecomex +
                                          $temporada->safe_cargo +
                                          $temporada->transportes +
                                          $temporada->coface +
                                          $temporada->gastos_de_exportacion +
                                          $temporada->fedex +
                                          $temporada->seguro_carga_fester +
                                          $temporada->seguro_carga_maerk +
                                          $temporada->asoex;
                              @endphp
                              <h1 class="form-label">Total Otros Costos:</h1>
                              <div class="text-center form-input block w-full my-1 rounded-lg">
                                 {{ number_format($subtotal, 2, ',', '.') }}
                              </div>
                           </div>
                           <div class="my-2 flex items-center bg-orange-300 px-2 rounded-md">
                              <h1 class="form-label">Proceso:</h1>
                              <div class="text-center form-input block w-full my-1 rounded-lg">
                                 {{ number_format($totalprocesos, 2, ',', '.') }}
                              </div>
                           </div>
                           <div class="my-2 flex items-center bg-orange-300 px-2 rounded-md">
                              <h1 class="form-label">Materiales:</h1>
                              <div class="text-center form-input block w-full my-1 rounded-lg">
                                 {{ number_format($totalmateriales, 2, ',', '.') }}
                              </div>
                           </div>
                           <div class="mb-2 flex items-center px-2">
                                 @php
                                    $total =  $totalmateriales + $totalprocesos +
                                             $temporada->pti +
                                             $temporada->pti_terceros +
                                             $temporada->tecomex +
                                             $temporada->safe_cargo +
                                             $temporada->transportes +
                                             $temporada->coface +
                                             $temporada->gastos_de_exportacion +
                                             $temporada->fedex +
                                             $temporada->seguro_carga_fester +
                                             $temporada->seguro_carga_maerk +
                                             $temporada->asoex;
                                 @endphp
                                 <h1 class="form-label">Total:</h1>
                                 <div class="text-center form-input block w-full my-1 rounded-lg">
                                    {{ number_format($total, 2, ',', '.') }}
                                 </div>
                           </div>
                           <div class="flex justify-end">
                                 {!! Form::submit('Actualizar Datos', ['class' => 'font-bold py-2 px-4 rounded bg-blue-500 text-white cursor-pointer']) !!}
                           </div>
                        </div>
                     </div>
               {!! Form::close() !!}
                  
           
            </div>
               </div>
              
                
              </main>
           
           </div>
        </div>
        <script async defer src="https://buttons.github.io/buttons.js"></script>
        <script src="https://demo.themesberg.com/windster/app.bundle.js"></script>
     </div>

    
</x-app-layout>