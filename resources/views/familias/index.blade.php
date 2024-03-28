<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lista de Filtros') }}
        </h2>
    </x-slot>
 
    <div class="pb-12 pt-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {!! Form::open(['route'=>'familias.store','files'=>true , 'autocomplete'=>'off']) !!}
                    
                    {!! Form::hidden('status', 'active') !!}

                    @csrf
                    
                        <div class="mb-4">
                            {!! Form::label('name', 'Nombre') !!}
                            {!! Form::text('name', null , ['class' => 'form-input block w-full mt-1'.($errors->has('name')?' border-red-600':'')]) !!}
    
                            @error('name')
                                <strong class="text-xs text-red-600">{{$message}}</strong>
                            @enderror
                        </div>
                        
                        @php
                             $opciones = [
                        'DESCUENTA' => 'DESCUENTA',
                        'SUMA' => 'SUMA'
                        // Agrega más opciones según sea necesario
                    ];
                        @endphp
                   <div class="form-group my-2">
                    {!! Form::label('funcion','Funcion:') !!}
                    {!! Form::select('funcion', $opciones, null, ['class'=>'mt-1 block w-full rounded-lg', 'placeholder'=>'¿Función?']) !!}
     
                    @error('funcion')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                  </div>

                    <div class="flex justify-end">
                        {!! Form::submit('Crear Familia', ['class'=>'font-bold py-2 px-4 rounded bg-blue-500 text-white cursor-pointer']) !!}
                    </div>

                {!! Form::close() !!}

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-4">

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
                                  Status
                                </th>
                                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                  Funcion
                                </th>
                              </tr>
                            </thead>
                            <tbody>
                                @foreach ($familias as $familia)
                                    <tr class="bg-gray-100 border-b">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{$familia->id}}</td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                        {{$familia->name}}
                                        </td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                        {{$familia->status}}
                                        </td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                        {{$familia->funcion}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    
</x-app-layout>
