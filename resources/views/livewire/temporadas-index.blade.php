<div class="bg-white p-8 rounded-md w-full" x-data="{alert:true}">
    <div class="flex justify-center">
        @if (session('info'))
            <div x-show="alert" class="font-regular relative block w-full max-w-screen-md rounded-lg bg-green-500 px-4 py-4 text-base text-white mb-4" data-dismissible="alert">
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
        @if (session('delete'))
            <div x-show="alert" class="font-regular relative block w-full max-w-screen-md rounded-lg bg-red-500 px-4 py-4 text-base text-white mb-4" data-dismissible="alert">
                <div class="absolute top-4 left-4">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" class="mt-px h-6 w-6">
                        <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-8 mr-12">
                    <h5 class="block font-sans text-xl font-semibold leading-snug tracking-normal text-white antialiased">
                        {{ session('delete') }}
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

    <div class=" flex items-center justify-between pb-6">
      <div>
        <h2 class="text-gray-600 font-semibold">Listado de Temporadas</h2>
        <span class="text-xs">Ordenadas por ultima fecha de modificación</span>
      </div>
      
      <div class="flex items-center justify-between">
        <div class="flex bg-gray-50 items-center p-2 rounded-md">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20"
            fill="currentColor">
            <path fill-rule="evenodd"
              d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
              clip-rule="evenodd" />
          </svg>
         
          <input wire:model.live="search" class="bg-gray-50 outline-none ml-1" placeholder="search...">

            </div>
          <div class="lg:ml-40 ml-10 space-x-8">
            <a href="{{route('temporadas.create')}}">
              <button class="bg-indigo-600 px-4 py-2 rounded-md text-white font-semibold tracking-wide cursor-pointer">Agregar Temporada</button>
            </a>
            <button class="bg-indigo-600 px-4 py-2 rounded-md text-white font-semibold tracking-wide cursor-pointer hidden">Agregar</button>
          </div>
        </div>
      </div>

      {{$search}}

      <div>
        <ul role="list" class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
          @foreach ($temporadas as $temporada)
           
                <li class="col-span-1 divide-y divide-gray-200 rounded-lg bg-white shadow cursor-pointer">
                        <div class="flex w-full items-center justify-between space-x-6 p-6">
                          <a href="{{route('temporadas.destroy',$temporada)}}"
                          wire:navigate >
                   
                            <div class="flex-1 truncate">
                              <div class="flex items-center space-x-3">
                                  <h3 class="truncate text-sm font-medium text-gray-900">{{$temporada->name}}</h3>
                                  <span class="inline-flex flex-shrink-0 items-center rounded-full bg-green-50 px-1.5 py-0.5 text-xs font-medium text-green-600 ring-1 ring-inset ring-green-600/20">Activa</span>
                              </div>
                              <p class="mt-1 truncate text-sm text-gray-500">Temporada cerezas</p>
                            </div>
                          </a>
                            <img class="h-10 w-10 flex-shrink-0 bg-gray-300" src="https://img.freepik.com/vector-gratis/vector-aislado-cereza-roja-vibrante_1308-133424.jpg" alt="">
                         
                          </div>
                        <div>
                            <div class="-mt-px flex divide-x divide-gray-200">
                            <div class="flex w-0 flex-1">
                                <a href="{{route('temporadas.destroy',$temporada)}}" 
                                wire:navigate 
                                class="relative -mr-px inline-flex w-0 flex-1 items-center justify-center gap-x-3 rounded-bl-lg border border-transparent py-4 text-sm font-semibold text-gray-900">
                                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                  </svg>
                                  
                                Editar
                                </a>
                            </div>
                            <div class="-ml-px flex w-0 flex-1">

                                <a wire:click="$dispatch('deletetemporada',{{$temporada->id}})" class="relative inline-flex w-0 flex-1 items-center justify-center gap-x-3 rounded-br-lg border border-transparent py-4 text-sm font-semibold text-gray-900">
                                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                  </svg>
                                  
                                  Eliminar
                                </a>
                            </div>
                            </div>
                        </div>
                  
                </li>
            
          @endforeach
     
          <!-- More people... -->
        </ul>

    
      </div>
    </div>

    @push('js')
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <script>
        document.addEventListener('livewire:initialized',function(){
          Livewire.on('deletetemporada', temporadaId => {
            
            Swal.fire({
            title: "¿Eliminar temporada?",
            text: "No podras revertir esta acción!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, eliminarla!"
            }).then((result) => {
              if (result.isConfirmed) {

                  Livewire.dispatchTo('temporadas-index', 'confirmDelete', { temporada: temporadaId })
                
                  
              }
            });
            
          });
        });
      </script>
    @endpush
</div>
