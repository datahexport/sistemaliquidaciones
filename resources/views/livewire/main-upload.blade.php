<div>
        <main class="relative z-0 flex-1 pb-8 px-6 bg-white">
            <div class="grid pb-10  mt-4 " x-data="{@if($vista=='packing') packing: true @else packing: false @endif, @if($vista=='materiales') materiales: true @else materiales: false @endif, @if($vista=='comision') comision: true @else comision: false @endif, @if($vista=='exportacion') exportacion: true @else exportacion: false @endif, @if($vista=='fletes') fletes: true @else fletes: false @endif, @if($vista=='masas') masas: true @else masas: false @endif, @if($vista=='anticipos') anticipos: true @else anticipos: false @endif ,  @if($vista=='fob') fob: true @else fob: false @endif , @if($vista=='gastos') gastos: true @else gastos: false @endif  }">
                <!-- Start Content-->
                <div class="mb-2 grid grid-cols-12 items-center">
                    <div class="col-span-12 sm:col-span-5 md:col-span-5 lg:col-span-5 xxl:col-span-5">
                        <p class="text-lg font-semibold text-gray-400">Información pendiente de subir</p>
                    </div>
                    <div>

                    </div>
                    <div class="col-span-12 sm:col-span-12 md:col-span-6 lg:col-span-6 xxl:col-span-6">
                        <div class="p-4">
                            <p class="text-sm text-gray-400">Información base de datos</p>
                            <div class="shadow w-full bg-gray-100 mt-2">
                                <div class="bg-indigo-600 text-xs leading-none py-1 text-center text-white" style="width: 55%"></div>
                            </div>
                            <p class="text-xs font-semibold text-gray-400 mt-2">45,941 Registros</p>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-12 gap-6 border-b-2 pb-2 mb-3">
                    <div class="col-span-12 sm:col-span-12 md:col-span-12 lg:col-span-12 xxl:col-span-12">
                    <div class="grid grid-cols-1 gap-2 sm:grid-cols-2 md:grid-cols-6 lg:grid-cols-6 xl:grid-cols-6 mt-3 gap-x-2">
                        
                        <div class="p-4 hover:bg-gray-100 hover:rounded-2xl" :class="{'bg-gray-100 rounded-2xl': packing, 'bg-white': ! packing}" @click="packing = true; materiales = false; comision = false; exportacion = false; fletes = false; masas = false; anticipos = false ;  fob= false ; gastos = false">
                            
                                @if ($CostosPackings->count()>0)
                                <p class="text-xl font-bold"> {{$CostosPackings->count()}} </p>
                                @else 
                                <p class="text-lg font-bold">  PENDIENTE  </p>
                                @endif
                                
                            
                            <p class="text-xs font-semibold text-gray-400">Costos Packing</p>
                        </div>
                        <div class="p-4 hover:bg-gray-100 hover:rounded-2xl" :class="{'bg-gray-100 rounded-2xl': materiales, 'bg-white': ! materiales}" @click="packing = false; materiales = true; comision = false; exportacion = false; fletes = false; masas = false; anticipos = false ;  fob= false ; gastos = false">
                                @if ($materiales->count()>0)
                                <p class="text-xl font-bold"> {{$materiales->count()}} </p>
                                @else 
                                <p class="text-lg font-bold">  PENDIENTE  </p>
                                @endif
                            <p class="text-xs font-semibold text-gray-400">Materiales</p>
                        </div>
                        <div class="p-4 hover:bg-gray-100 hover:rounded-2xl" :class="{'bg-gray-100 rounded-2xl': exportacion, 'bg-white': ! exportacion}" @click="packing = false; materiales = false; comision = false; exportacion = true; fletes = false; masas = false; anticipos = false ;  fob= false ; gastos = false">
                                @if ($exportacions->count()>0)
                                    <p class="text-xl font-bold"> {{$exportacions->count()}} </p>
                                @else 
                                    <p class="text-lg font-bold">  PENDIENTE  </p>
                                @endif
                            <p class="text-xs font-semibold text-gray-400">Gastos de Exportación</p>
                        </div>

                        <div class=" p-4 hover:bg-gray-100 hover:rounded-2xl" :class="{'bg-gray-100 rounded-2xl': fletes, 'bg-white': ! fletes}" @click="packing = false; materiales = false; comision = false; exportacion = false; fletes = true; masas = false; anticipos = false ;  fob= false ; gastos = false">
                            @if ($fletes->count()>0)
                                <p class="text-xl font-bold"> {{$fletes->count()}} </p>
                            @else 
                                <p class="text-lg font-bold">  PENDIENTE  </p>
                            @endif
                            <p class="text-xs font-semibold text-gray-400">Flete a Huerto</p>
                        </div>

                        <div class=" p-4 hover:bg-gray-100 hover:rounded-2xl" :class="{'bg-gray-100 rounded-2xl': comision, 'bg-white': ! comision}" @click="packing = false; materiales = false; comision = true; exportacion = false; fletes = false; masas = false; anticipos = false ;  fob= false ; gastos = false">
                            @if ($comisions->count()>0)
                                <p class="text-xl font-bold"> {{$comisions->count()}} </p>
                            @else 
                                <p class="text-lg font-bold">  PENDIENTE  </p>
                            @endif
                            <p class="text-xs font-semibold text-gray-400">Comisión</p>
                        </div>
                        
                    
                        <div class=" p-4 hover:bg-gray-100 hover:rounded-2xl" :class="{'bg-gray-100 rounded-2xl': masas, 'bg-white': ! masas}" @click="packing = false; materiales = false; comision = false; exportacion = false; fletes = false; masas = true ; anticipos = false ;  fob= false ; gastos = false">
                                <p class="text-xl font-bold">5,700</p>
                                <p class="text-xs font-semibold text-gray-400">Balance de masas</p>
                        </div>

                        <div class=" p-4 hover:bg-gray-100 hover:rounded-2xl" :class="{'bg-gray-100 rounded-2xl': anticipos, 'bg-white': ! anticipos}" @click="packing = false; materiales = false; comision = false; exportacion = false; fletes = false; masas = false ; anticipos = true  ; fob = false ; gastos = false">
                            <p class="text-xl font-bold">
                                @if ($temporada->anticipos->count()>0)
                                    {{$temporada->anticipos->count()}}
                                @else
                                    PENDIENTE
                                @endif
                            </p>
                            <p class="text-xs font-semibold text-gray-400">Anticipos</p>
                        </div>

                        <div class=" p-4 hover:bg-gray-100 hover:rounded-2xl" :class="{'bg-gray-100 rounded-2xl': fob , 'bg-white': ! fob }" @click="packing = false; materiales = false; comision = false; exportacion = false; fletes = false; masas = false ; anticipos = false  ; fob = true ; gastos = false">
                            <p class="text-xl font-bold">
                                @if ($temporada->fobs->count()>0)
                                    {{$temporada->fobs->count()}}
                                @else
                                    PENDIENTE
                                @endif
                            </p>
                            <p class="text-xs font-semibold text-gray-400">FOB</p>
                        </div>
                        <div class=" p-4 hover:bg-gray-100 hover:rounded-2xl" :class="{'bg-gray-100 rounded-2xl': gastos , 'bg-white': ! gastos }" @click="packing = false; materiales = false; comision = false; exportacion = false; fletes = false; masas = false ; anticipos = false  ; fob = false ; gastos = true">
                            <p class="text-xl font-bold">
                                @if ($temporada->gastos->count()>0)
                                    {{$temporada->gastos->count()}}
                                @else
                                    PENDIENTE
                                @endif
                            </p>
                            <p class="text-xs font-semibold text-gray-400">GASTOS</p>
                        </div>
                    </div>
                    </div>
                
                </div>

                {{-- Seccción formulario --}}

                <div class="flex justify-center" x-show="packing">
                    <div>
                    <h1 class="text-xl font-semibold mb-4">
                        Por favor selecione el archivo de "Costos de packing" que desea importar
                    </h1>
                    <div class="flex">
                        
                        <form action="{{route('temporada.importCostosPacking')}}"
                            method="POST"
                            class="bg-white rounded p-8 shadow"
                            enctype="multipart/form-data">
                            
                            @csrf

                            <input type="hidden" name="temporada" value={{$temporada->id}}>

                            <x-validation-errors class="errors">

                            </x-validation-errors>

                            <input type="file" name="file" accept=".csv,.xlsx">

                            <x-button class="ml-4">
                                Importar
                            </x-button>
                        </form>
                    </div>
                    </div>
                </div>

                <div class="flex justify-center" x-show="materiales">
                    <div>
                        <h1 class="text-xl font-semibold mb-4">
                            Por favor selecione el archivo de "Materiales" que desea importar
                        </h1>
                        <div class="flex">
                            
                            <form action="{{route('temporada.importMateriales')}}"
                                method="POST"
                                class="bg-white rounded p-8 shadow"
                                enctype="multipart/form-data">
                                
                                @csrf

                                <input type="hidden" name="temporada" value={{$temporada->id}}>

                                <x-validation-errors class="errors">

                                </x-validation-errors>

                                <input type="file" name="file" accept=".csv,.xlsx">

                                <x-button class="ml-4">
                                    Importar
                                </x-button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="flex justify-center" x-show="comision">
                    <div>
                        <h1 class="text-xl font-semibold mb-4">
                            Por favor selecione el archivo de "Comision" que desea importar
                        </h1>
                        <div class="flex">
                            
                            <form action="{{route('temporada.importComision')}}"
                                method="POST"
                                class="bg-white rounded p-8 shadow"
                                enctype="multipart/form-data">
                                
                                @csrf

                                <input type="hidden" name="temporada" value={{$temporada->id}}>

                                <x-validation-errors class="errors">

                                </x-validation-errors>

                                <input type="file" name="file" accept=".csv,.xlsx">

                                <x-button class="ml-4">
                                    Importar
                                </x-button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-center" x-show="exportacion">
                    <div> 
                        <div class="grid grid-cols-3 gap-x-4 items-center mb-6">

                            <select wire:model="type" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                <option value="" class="text-center">Selecciona una categoría</option>
                                <option value="maritimo" class="text-center">Maritimo</option>
                                <option value="aereo" class="text-center">Aereo</option>
                                <option value="terrestre" class="text-center">Terrestre</option>

                                

                            </select>

                            <input wire:model="precio_usd" type="number" class="form-input flex-1 w-full shadow-sm  border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg focus:outline-none" autocomplete="off">
                            
                            <button wire:click="exportacion_store" class="focus:ring-2 focus:ring-offset-2 focus:ring-green-300 text-sm leading-none text-green-600 py-3 px-5 bg-green-600 rounded hover:bg-green-500 focus:outline-none">

                                <h1 style="font-size: 1rem;white-space: nowrap;" class="text-center text-white font-bold inline w-full" >
                                Agregar
                                    
                                </h1>
                            </button>
                        </div>
                        @if ($temporada->exportacions->count()>0)
                        <table class="min-w-full leading-normal">
                            <thead>
                              <tr>
                                <th
                                  class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                  Tipo
                                </th>
                                <th
                                  class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Precio USD
                                </th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                  Acción
                                  </th>
                              
                              
                            
                            </tr>
                            </thead>
                            <tbody>
                          
                                @foreach ($temporada->exportacions as $exportacion)
                                  <tr>
                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                      <div class="flex items-center">
                                        <div class="flex-shrink-0 w-10 h-10 hidden">
                                          <img class="w-full h-full rounded-full"
                                                                    src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2.2&w=160&h=160&q=80"
                                                                    alt="" />
                                                            </div>
                                          <div class="ml-3">
                                            <p class="text-gray-900 whitespace-no-wrap">
                                              {{$exportacion->type}}
                                            </p>
                                          </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                      <p class="text-gray-900 whitespace-no-wrap"> {{$exportacion->precio_usd}}</p>
                                    </td>
                                
                                
        
                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                        <a href="{{route('exportacion.edit',['exportacion'=>$exportacion,'temporada'=>$temporada])}}">
                                          <span class="relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                              <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full"></span>
                                              <span class="relative">Editar</span>
                                          </span>
                                        </a>
                                    </td>
                                  </tr>
                                @endforeach
                      
                            </tbody>
                          </table>
                        @endif


                        <h1 class="text-xl font-semibold mb-4 hidden">
                            Por favor selecione el archivo de "Gastos de Exportación" que desea importar
                        </h1>
                        <div class="flex hidden">
                            
                            <form action="{{route('temporada.importExportacion')}}"
                                method="POST"
                                class="bg-white rounded p-8 shadow"
                                enctype="multipart/form-data">
                                
                                @csrf

                                <input type="hidden" name="temporada" value={{$temporada->id}}>

                                <x-validation-errors class="errors">

                                </x-validation-errors>

                                <input type="file" name="file" accept=".csv,.xlsx">

                                <x-button class="ml-4">
                                    Importar
                                </x-button>
                            </form>
                        </div>

                    </div>
                </div>

                <h1 class="text-xl text-center font-semibold mb-4 ml-4" x-show="fletes">
                    Por favor selecione el archivo de "Flete a huerto" que desea importar
                  
                </h1>
                <div class="flex justify-center" x-show="fletes">


                  
                  
  
  
                    <form action="{{route('temporada.importFlete')}}"
                        method="POST"
                        class="bg-white rounded p-8 shadow"
                        enctype="multipart/form-data">
                        
                        @csrf
  
                        <input type="hidden" name="temporada" value={{$temporada->id}}>
  
                        <x-validation-errors class="errors">
  
                        </x-validation-errors>
  
                        <input type="file" name="file" accept=".csv,.xlsx">
  
                        <x-button class="ml-4">
                            Importar
                        </x-button>
                    </form>
                    
                </div>
                
                    <div class="grid grid-cols-1 gap-2 sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3 mt-3 hidden">
                        <div class="relative w-full h-52 bg-cover bg-center group rounded-lg overflow-hidden shadow-lg transition duration-300 ease-in-out"
                            style="background-image: url('https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/f/f868ecef-4b4a-4ddf-8239-83b2568b3a6b/de7hhu3-3eae646a-9b2e-4e42-84a4-532bff43f397.jpg?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ1cm46YXBwOjdlMGQxODg5ODIyNjQzNzNhNWYwZDQxNWVhMGQyNmUwIiwiaXNzIjoidXJuOmFwcDo3ZTBkMTg4OTgyMjY0MzczYTVmMGQ0MTVlYTBkMjZlMCIsIm9iaiI6W1t7InBhdGgiOiJcL2ZcL2Y4NjhlY2VmLTRiNGEtNGRkZi04MjM5LTgzYjI1NjhiM2E2YlwvZGU3aGh1My0zZWFlNjQ2YS05YjJlLTRlNDItODRhNC01MzJiZmY0M2YzOTcuanBnIn1dXSwiYXVkIjpbInVybjpzZXJ2aWNlOmZpbGUuZG93bmxvYWQiXX0.R0h-BS0osJSrsb1iws4-KE43bUXHMFvu5PvNfoaoi8o');">
                            <div class="absolute inset-0 bg-pink-900 bg-opacity-75 transition duration-300 ease-in-out"></div>
                            <div class="relative w-full h-full px-4 sm:px-6 lg:px-4 flex items-center justify-center">
                                <div>
                                <h3 class="text-center text-white text-lg">
                                    Total Balance
                                </h3>
                                <h3 class="text-center text-white text-3xl mt-2 font-bold">
                                    RM 27,580
                                </h3>
                                <div class="flex space-x-4 mt-4">
                                    <button class="block uppercase mx-auto shadow bg-white text-indigo-600 focus:shadow-outline 
                                    focus:outline-none text-xs py-3 px-4 rounded font-bold">
                                    Transfer
                                    </button>
                                    <button class="block uppercase mx-auto shadow bg-indigo-800 hover:bg-indigo-700 focus:shadow-outline 
                                    focus:outline-none text-white text-xs py-3 px-4 rounded font-bold">
                                    Request
                                    </button>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="relative w-full h-52 bg-cover bg-center group rounded-lg overflow-hidden shadow-lg transition duration-300 ease-in-out"
                            style="background-image: url('https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/f/f868ecef-4b4a-4ddf-8239-83b2568b3a6b/de7hhu3-3eae646a-9b2e-4e42-84a4-532bff43f397.jpg?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ1cm46YXBwOjdlMGQxODg5ODIyNjQzNzNhNWYwZDQxNWVhMGQyNmUwIiwiaXNzIjoidXJuOmFwcDo3ZTBkMTg4OTgyMjY0MzczYTVmMGQ0MTVlYTBkMjZlMCIsIm9iaiI6W1t7InBhdGgiOiJcL2ZcL2Y4NjhlY2VmLTRiNGEtNGRkZi04MjM5LTgzYjI1NjhiM2E2YlwvZGU3aGh1My0zZWFlNjQ2YS05YjJlLTRlNDItODRhNC01MzJiZmY0M2YzOTcuanBnIn1dXSwiYXVkIjpbInVybjpzZXJ2aWNlOmZpbGUuZG93bmxvYWQiXX0.R0h-BS0osJSrsb1iws4-KE43bUXHMFvu5PvNfoaoi8o');">
                            <div class="absolute inset-0 bg-yellow-600 bg-opacity-75 transition duration-300 ease-in-out"></div>
                                <div class="relative w-full h-full px-4 sm:px-6 lg:px-4 flex items-center">
                                <div>
                                <div class="text-white text-lg flex space-x-2 items-center">
                                    <div class="bg-white rounded-md p-2 flex items-center">
                                    <i class="fas fa-toggle-off fa-sm text-yellow-300"></i>
                                    </div>
                                    <p>Finished Appt</p>
                                </div>
                                <h3 class="text-white text-3xl mt-2 font-bold">
                                    120
                                </h3>
                                <h3 class="text-white text-lg mt-2 text-yellow-100 ">
                                    4 not confirmed
                                </h3>
                                </div>
                            </div>
                        </div>
                        <div class="relative w-full h-52 bg-cover bg-center group rounded-lg overflow-hidden shadow-lg transition duration-300 ease-in-out"
                            style="background-image: url('https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/f/f868ecef-4b4a-4ddf-8239-83b2568b3a6b/de7hhu3-3eae646a-9b2e-4e42-84a4-532bff43f397.jpg?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ1cm46YXBwOjdlMGQxODg5ODIyNjQzNzNhNWYwZDQxNWVhMGQyNmUwIiwiaXNzIjoidXJuOmFwcDo3ZTBkMTg4OTgyMjY0MzczYTVmMGQ0MTVlYTBkMjZlMCIsIm9iaiI6W1t7InBhdGgiOiJcL2ZcL2Y4NjhlY2VmLTRiNGEtNGRkZi04MjM5LTgzYjI1NjhiM2E2YlwvZGU3aGh1My0zZWFlNjQ2YS05YjJlLTRlNDItODRhNC01MzJiZmY0M2YzOTcuanBnIn1dXSwiYXVkIjpbInVybjpzZXJ2aWNlOmZpbGUuZG93bmxvYWQiXX0.R0h-BS0osJSrsb1iws4-KE43bUXHMFvu5PvNfoaoi8o');">
                            <div class="absolute inset-0 bg-blue-900 bg-opacity-75 transition duration-300 ease-in-out"></div>
                            <div class="relative w-full h-full px-4 sm:px-6 lg:px-4 flex items-center">
                                <div>
                                <div class="text-white text-lg flex space-x-2 items-center">
                                    <div class="bg-white rounded-md p-2 flex items-center">
                                    <i class="fas fa-clipboard-check fa-sm text-blue-800"></i>
                                    </div>
                                    <p>Finished Appt</p>
                                </div>
                                <h3 class="text-white text-3xl mt-2 font-bold">
                                    72
                                </h3>
                                <h3 class="text-white text-lg mt-2 ">
                                    3.4% <span class='font-semibold text-blue-200'>vs last month</span>
                                </h3>
                                </div>
                            </div>
                        </div>        
                    </div>

                <div class="flex justify-center" x-show="masas">
                    <div>
                        <h1 class="text-xl font-semibold mb-4">
                            Por favor selecione el archivo de "Balance de masas" que desea importar
                        </h1>
                        <div class="">
                            <form action="{{route('temporada.importBalance')}}"
                                method="POST"
                                class="bg-white rounded p-8 shadow"
                                enctype="multipart/form-data">
                                
                                @csrf

                                <input type="hidden" name="temporada" value={{$temporada->id}}>

                                <x-validation-errors class="errors">

                                </x-validation-errors>

                                <input type="file" name="file" accept=".csv,.xlsx">

                                <x-button class="ml-4">
                                    Importar
                                </x-button>
                            </form>

                        </div>
                    </div>
                </div>

                <div class="flex justify-center" x-show="anticipos">
                    <div>
                        <h1 class="text-xl font-semibold mb-4">
                            Por favor selecione el archivo de "Anticipos" que desea importar
                        </h1>
                        <div class="">
                            <form action="{{route('temporada.importAnticipo')}}"
                                method="POST"
                                class="bg-white rounded p-8 shadow"
                                enctype="multipart/form-data">
                                
                                @csrf

                                <input type="hidden" name="temporada" value={{$temporada->id}}>

                                <x-validation-errors class="errors">

                                </x-validation-errors>

                                <input type="file" name="file" accept=".csv,.xlsx">

                                <x-button class="ml-4">
                                    Importar
                                </x-button>
                            </form>

                        </div>
                    </div>
                </div>
                <div class="flex justify-center" x-show="fob">
                    <div>
                        <h1 class="text-xl font-semibold mb-4">
                            Por favor selecione el archivo de "FOB" que desea importar
                        </h1>
                        <div class="">
                            <form action="{{route('temporada.importFob')}}"
                                method="POST"
                                class="bg-white rounded p-8 shadow"
                                enctype="multipart/form-data">
                                
                                @csrf

                                <input type="hidden" name="temporada" value={{$temporada->id}}>

                                <x-validation-errors class="errors">

                                </x-validation-errors>

                                <input type="file" name="file" accept=".csv,.xlsx">

                                <x-button class="ml-4">
                                    Importar
                                </x-button>
                            </form>

                        </div>
                    </div>
                </div>

                <div class="flex justify-center" x-show="gastos">
                    <div> 
                        <div class="grid grid-cols-6 gap-x-4 items-center mb-6">

                            <select wire:model="familia" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                <option value="1" class="text-center">Selecciona una familia</option>
                                 
                                @foreach ($familias as $familia)
                                    <option value="{{$familia->id}}" class="text-center">{{$familia->name}}</option>
                                @endforeach
                                

                            </select>

                            
                            <select wire:model="categoria" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                <option value="" class="text-center">Selecciona una categoria</option>
                                 
                               
                                    <option value="nacional" class="text-center">Nacional</option>
                                    <option value="exportacion" class="text-center">Exportación</option>
                                    <option value="todas" class="text-center">Todas</option>
                               
                            </select>

                            <input wire:model="item" type="text" class="form-input flex-1 w-full shadow-sm  border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg focus:outline-none" autocomplete="off">
                           

                            <select wire:model="descuenta" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                <option value="" class="text-center">¿Donde Descuenta?</option>
                                    <option value="fob" class="text-center">Fob</option>
                                    <option value="ctacorriente" class="text-center">Cuenta Corriente</option>
                            </select>

                            <select wire:model="unidad" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                <option value="" class="text-center">¿Unidad?</option>
                                    <option value="caja" class="text-center">Caja</option>
                                    <option value="kg" class="text-center">KG</option>
                              </select>

                            <button wire:click="gasto_store" class="focus:ring-2 focus:ring-offset-2 focus:ring-green-300 text-sm leading-none text-green-600 py-3 px-5 bg-green-600 rounded hover:bg-green-500 focus:outline-none">

                                <h1 style="font-size: 1rem;white-space: nowrap;" class="text-center text-white font-bold inline w-full" >
                                Agregar
                                    
                                </h1>
                            </button>
                        </div>
                        @if ($temporada->gastos->count()>0)
                            <table class="min-w-full leading-normal">
                            <thead>
                              <tr>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Familia
                                    </th>
                                <th
                                  class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                  item
                                </th>
                               
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Categoria
                                        </th>
                                <th
                                  class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Descuenta
                                </th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                              Unidad
                              </th>
                               
                              
                              
                            
                            </tr>
                            </thead>
                            <tbody>
                          
                                @foreach ($temporada->gastos as $gasto)
                                  <tr>
                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap"> {{$gasto->familia->name}}</p>
                                      </td>
                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                      <div class="flex items-center">
                                        <div class="flex-shrink-0 w-10 h-10 hidden">
                                          <img class="w-full h-full rounded-full"
                                                                    src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2.2&w=160&h=160&q=80"
                                                                    alt="" />
                                                            </div>
                                          <div class="ml-3">
                                            <p class="text-gray-900 whitespace-no-wrap">
                                              {{$gasto->item}}
                                            </p>
                                          </div>
                                        </div>
                                    </td>
                                  
                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap"> {{$gasto->categoria}}</p>
                                      </td>
                                      <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap"> {{$gasto->descuenta}}</p>
                                      </td>
                                      <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap"> {{$gasto->unidad}}</p>
                                      </td>
                                
                                
        
                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                        <a href="">
                                          <span class="relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                              <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full"></span>
                                              <span class="relative">Editar</span>
                                          </span>
                                        </a>
                                    </td>
                                  </tr>
                                @endforeach
                      
                            </tbody>
                          </table>
                        @endif


                        <h1 class="text-xl font-semibold mb-4 hidden">
                            Por favor selecione el archivo de "Gastos de Exportación" que desea importar
                        </h1>
                        <div class="flex hidden">
                            
                            <form action="{{route('temporada.importExportacion')}}"
                                method="POST"
                                class="bg-white rounded p-8 shadow"
                                enctype="multipart/form-data">
                                
                                @csrf

                                <input type="hidden" name="temporada" value={{$temporada->id}}>

                                <x-validation-errors class="errors">

                                </x-validation-errors>

                                <input type="file" name="file" accept=".csv,.xlsx">

                                <x-button class="ml-4">
                                    Importar
                                </x-button>
                            </form>
                        </div>

                    </div>
                </div>
                
                
                <!-- End Content-->
            </div>
        </main>
</div>
