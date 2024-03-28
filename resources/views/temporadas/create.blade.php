<x-app-layout>
  

    <div class="py-8 ">
        
        <div class="card">
            <div class="card-body">
                <h1 class="text-2xl font-bold">Crear nueva temporada</h1>
                <hr class="mt-2 mb-6">

                {!! Form::open(['route'=>'temporadas.store','files'=>true , 'autocomplete'=>'off']) !!}
                    
                    {!! Form::hidden('user_id',auth()->user()->id) !!}

                    @csrf
                    
                        <div class="mb-4">
                            {!! Form::label('name', 'Nombre') !!}
                            {!! Form::text('name', null , ['class' => 'form-input block w-full mt-1'.($errors->has('name')?' border-red-600':'')]) !!}
    
                            @error('name')
                                <strong class="text-xs text-red-600">{{$message}}</strong>
                            @enderror
                        </div>
    
                  

                    <div class="flex justify-end">
                        {!! Form::submit('Crear nueva temporada', ['class'=>'font-bold py-2 px-4 rounded bg-blue-500 text-white cursor-pointer']) !!}
                    </div>

                {!! Form::close() !!}
            </div>
        </div>

    </div>

</x-app-layout>