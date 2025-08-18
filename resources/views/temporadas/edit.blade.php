<x-app-layout>
  

    <div class="py-8 ">
        
        <div class="card">
            <div class="card-body">
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
                <h1 class="text-2xl font-bold">Actualizar temporada</h1>
                <hr class="mt-2 mb-6">

                {!! Form::model($temporada, ['route'=>['temporadas.update',$temporada],'method' => 'put', 'autocomplete'=>'off']) !!}    
                   
                    {!! Form::hidden('user_id',auth()->user()->id) !!}

                    @csrf
                    
                        <div class="mb-4">
                            {!! Form::label('name', 'Nombre') !!}
                            {!! Form::text('name', null , ['class' => 'form-input block w-full mt-1'.($errors->has('name')?' border-red-600':'')]) !!}
    
                            @error('name')
                                <strong class="text-xs text-red-600">{{$message}}</strong>
                            @enderror
                        </div>

                         <div class="mb-4">
                            {!! Form::label('tc', 'Tarifa de cambio:') !!}
                            {!! Form::text('tc', null , ['class' => 'form-input block w-full mt-1'.($errors->has('tc')?' border-red-600':'')]) !!}
    
                            @error('tc')
                                <strong class="text-xs text-red-600">{{$message}}</strong>
                            @enderror
                        </div>

                    <div class="mb-4">
                        {!! Form::label('comision', 'Comisión (%)') !!}
                        {!! Form::select(
                            'comision',
                            collect(range(1, 15))->mapWithKeys(fn($i) => [$i => $i.' %']),
                            $temporada->comision ?? 8, // 👈 si no hay valor, usa 8
                            ['class' => 'form-select block w-full mt-1'.($errors->has('comision')?' border-red-600':'')]
                        ) !!}

                        @error('comision')
                            <strong class="text-xs text-red-600">{{$message}}</strong>
                        @enderror
                    </div>


    
                  

                    <div class="flex justify-end">
                        {!! Form::submit('Actualizar temporada', ['class'=>'font-bold py-2 px-4 rounded bg-blue-500 text-white cursor-pointer']) !!}
                    </div>

                {!! Form::close() !!}
            </div>
        </div>

    </div>

</x-app-layout>