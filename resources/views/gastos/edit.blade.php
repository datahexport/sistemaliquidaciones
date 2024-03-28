<x-app-layout>
  
    @if(session('info'))
        <div class="flex justify-center">
            <div class="justify-center" x-data="{notificacion: true}" x-show="notificacion">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded justify-center w-full flex my-2 mx-2 items-center" role="alert">
                <strong class="font-bold mx-2 my-auto">Felicidades!</strong>
                <span class="flex">{{session('info')}}</span>
                <span class="mx-3 top-0 bottom-0 right-0">
                <svg x-on:click="notificacion=false" class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                </span>
            </div>
            </div>
        </div>
    @endif

    <div class="pb-8 pt-2">
        
        <div class="card">
         
                
                <h1 class="text-2xl font-bold">Temporada {{$temporada->name}}</h1>
                <hr class="mt-2 mb-6">
                <div class="flex w-full bg-gray-300" x-data="{openMenu:1}">
                    
                    @livewire('menu-aside',['temporada'=>$temporada->id])
                   
                    {!! Form::model($gasto, ['route'=>['gastos.update',$gasto],'method' => 'put', 'autocomplete'=>'off']) !!}    
                    <div class="flex justify-center">
                    <table class="min-w-full leading-normal">
                        <thead>
                          <tr>
                            <th
                              class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                              Familia
                            </th>
                            <th
                              class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                              Item
                            </th>
                            <th
                              class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            n_categoria
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                              Descuenta
                              </th>
                              <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Unidad
                                </th>
                          
                          
                        
                        </tr>
                        </thead>
                        <tbody>
                      
                         
                              <tr>
                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                 
                          {!! Form::label('familia_id','') !!}
                          {!! Form::select('familia_id', $familias, null, ['class'=>'mt-1 block w-full rounded-lg', 'placeholder'=>'¿Función?']) !!}
          
                                </td>
                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                  <div class="flex items-center">
                                 
                                      <div class="ml-3">
                                        <p class="text-gray-900 whitespace-no-wrap">
                                          {{$gasto->item}}
                                        </p>
                                      </div>
                                    </div>
                                </td>

                                  <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                    @php
                                    $etiquetas = [
                                      'nacional' => 'Nacional',
                                      'exportacion' => 'Exportación',
                                      'todas' => 'Todas'
                                      // Agrega más opciones según sea necesario
                                  ];
                               @endphp
                                {!! Form::label('categoria','') !!}
                                {!! Form::select('categoria', $etiquetas, null, ['class'=>'mt-1 block w-full rounded-lg', 'placeholder'=>'¿Función?']) !!}
                
                                  </td>

                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                  @php
                                    $descuenta = [
                                      'fob' => 'Fob',
                                      'ctacorriente' => 'Cuenta Corriente'
                                      // Agrega más opciones según sea necesario
                                  ];
                               @endphp
                                {!! Form::label('descuenta','') !!}
                                {!! Form::select('descuenta', $descuenta, null, ['class'=>'mt-1 block w-full rounded-lg', 'placeholder'=>'¿Función?']) !!}
                             </td>

                             <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                              @php
                                $unidad = [
                                      'caja' => 'Caja',
                                      'kg' => 'KG'
                                      // Agrega más opciones según sea necesario
                                  ];
                              @endphp
                                {!! Form::label('unidad','') !!}
                                {!! Form::select('unidad', $unidad, null, ['class'=>'mt-1 block w-full rounded-lg', 'placeholder'=>'¿Unidad?']) !!}
                            </td>
                            
                            
    
                                <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                    {!! Form::submit('Guardar', ['class'=>'text-white font-bold mx-4 text-sm focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 mt-4 sm:mt-0 inline-flex items-start justify-start px-3 py-2 bg-gray-500 hover:bg-gray-500 focus:outline-none rounded']) !!}
                            
                                </td>
                               
                              </tr>
                             
                  
                        </tbody>
                    </table>
                  </div>
                    {!! Form::close() !!}
                  
                        
                </div>

           
        </div>

    </div>



</x-app-layout>