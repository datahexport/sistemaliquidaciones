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
            @if ($finanzas->count()>0)
            
                @livewire('temporada-show', ['temporada' => $temporada, 'vista' => 'FINANZAS'], key($temporada->id))
                    
            @else
                <h1 class="text-2xl font-bold">Temporada {{$temporada->name}}</h1>
                <hr class="mt-2 mb-6">
                <div class="flex w-full bg-gray-300" x-data="{openMenu:1}">

                    @livewire('menu-aside',['temporada'=>$temporada->id])

                    @livewire('main-upload', ['temporada' => $temporada], key($temporada->id))
                        
                </div>
            @endif
        </div>

    </div>

</x-app-layout>