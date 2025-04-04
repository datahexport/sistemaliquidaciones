<x-app-layout>

    <div>
       @livewire('new-nav')
        
        <div class="flex overflow-hidden bg-white pt-16">
           <aside id="sidebar" class="fixed hidden z-20 h-full top-0 left-0 pt-16 flex lg:flex flex-shrink-0 flex-col w-64 transition-width duration-75" aria-label="Sidebar">
              @livewire('aside-liquidaciones', ['temporada' => $temporada->id])
           </aside>
           <div class="bg-gray-900 opacity-50 hidden fixed inset-0 z-10" id="sidebarBackdrop"></div>
           <div id="main-content" class="h-full w-full bg-gray-50 relative overflow-y-auto lg:ml-64">
              <main>
                    @if ($temporada->masasdos)
                        <div class="py-8">
                            <div class="max-w-7xl mx-auto sm:px-6 lg:px-4">
                                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                                    <div class="flex flex-col justify-center items-center h-[100vh]">
                                        @if(session('info'))
                                            <div class="flex justify-center mt-12">
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
                                        <div class="relative flex flex-col items-center rounded-[20px] w-[700px] max-w-[95%] mx-auto bg-white bg-clip-border shadow-3xl shadow-lg  dark:!bg-navy-800 dark:text-white dark:!shadow-none p-3">
                                            <div class="mt-2 mb-2 w-full">
                                                <h4 class="px-2 text-xl font-bold text-navy-700 dark:text-white">
                                                Base Liquidaciones
                                                </h4>
                                                <p class="mt-2 px-2 text-base text-gray-600">
                                                As we live, our hearts turn colder. Cause pain is what we go through
                                                as we become older. We get insulted by others, lose trust for those
                                                others. We get back stabbed by friends. It becomes harder for us to
                                                give others a hand. We get our heart broken by people we love, even
                                                that we give them all...
                                                </p>
                                            </div> 
                                            <div class="">
                                                <form action="{{route('temporada.importBalance2')}}"
                                                    method="POST"
                                                    class="bg-white rounded px-8 shadow my-4"
                                                    enctype="multipart/form-data">
                                                    
                                                    @csrf
                    
                                                    <input type="hidden" name="temporada" value={{$temporada->id}}>
                    
                                                    <x-validation-errors class="errors">
                    
                                                    </x-validation-errors>
                    
                                                    <input type="file" name="file" accept=".csv,.xlsx">
                    
                                                    <x-button class="">
                                                        Importar
                                                    </x-button>
                                                </form>
                    
                                            </div>
                                            <div class="grid grid-cols-2 gap-4 px-2 w-full">
                                                <div class="flex flex-col items-start justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                                                <p class="text-sm text-gray-600">Education</p>
                                                <p class="text-base font-medium text-navy-700 dark:text-white">
                                                    Stanford University
                                                </p>
                                                </div>
                            
                                                <div class="flex flex-col justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                                                <p class="text-sm text-gray-600">Languages</p>
                                                <p class="text-base font-medium text-navy-700 dark:text-white">
                                                    English, Spanish, Italian
                                                </p>
                                                </div>
                            
                                                <div class="flex flex-col items-start justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                                                <p class="text-sm text-gray-600">Department</p>
                                                <p class="text-base font-medium text-navy-700 dark:text-white">
                                                    Product Design
                                                </p>
                                                </div>
                            
                                                <div class="flex flex-col justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                                                <p class="text-sm text-gray-600">Work History</p>
                                                <p class="text-base font-medium text-navy-700 dark:text-white">
                                                    English, Spanish, Italian
                                                </p>
                                                </div>
                            
                                                <div class="flex flex-col items-start justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                                                <p class="text-sm text-gray-600">Organization</p>
                                                <p class="text-base font-medium text-navy-700 dark:text-white">
                                                    Simmmple Web LLC
                                                </p>
                                                </div>
                            
                                                <div class="flex flex-col justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                                                <p class="text-sm text-gray-600">Birthday</p>
                                                <p class="text-base font-medium text-navy-700 dark:text-white">
                                                    20 July 1986
                                                </p>
                                                </div>
                                            </div>
                                        </div>  
                                        <p class="font-normal text-navy-700 mt-20 mx-auto w-max">Profile Card component from <a href="https://horizon-ui.com?ref=tailwindcomponents.com" target="_blank" class="text-brand-500 font-bold">Horizon UI Tailwind React</a></p>  
                                    </div>
                            
                                    <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
                                        <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                                            <table class="min-w-full leading-normal">
                                                <thead>
                                                <tr>
                                                    @php
                                                    $columnas = [
                                                        'Contenedor',
                                                        'Fecha',
                                                        'Nave',
                                                        'DESTINO',
                                                        'Cliente',
                                                        'Sales_City',
                                                        'Tipo',
                                                        'Total_Venta',
                                                        'Flete_Maritimo_AEREO',
                                                        'Impuestos',
                                                        'Entrada_al_Mercado',
                                                        'Costos_logisticos',
                                                        'Flete_interior',
                                                        'Costos_en_mercado',
                                                        'Ajuste_de_Impuestos',
                                                        'Costo_Extra',
                                                        'REBATE',
                                                        'MAERK',
                                                        'Comisiones',
                                                        'Comision',
                                                        'Costos_Totales',
                                                        'Tipo_de_Cambio',
                                                        'Liq_RMB',
                                                        'Liq_USD',
                                                        'Nuevo_TC',
                                                        'Ajuste_Dif_TC',
                                                        'Liquidacion_USD',
                                                        'TC_FINAL',
                                                        'Cant_Cajas',
                                                        'KG_CONTENEDOR',
                                                        'OTROS_GASTOS',
                                                        'OTROS_COSTOS_SIN_MAERSK',
                                                        'Mes_Facturacion',
                                                        'No_Factura',
                                                        'Otros_Costos',
                                                        'Liq_sin_Maersk',
                                                        'Columna1',
                                                    ];
                                            
                                                    foreach ($columnas as $columna) {
                                                        echo '<th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase whitespace-no-wrap">';
                                                        echo ucfirst(str_replace('_', ' ', $columna));
                                                        echo '</th>';
                                                    }
                                                    @endphp
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ($temporada->masasdos as $masa)
                                                    <tr>
                                                    @foreach ($columnas as $columna)
                                                        <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                                        <p class="text-gray-900 whitespace-nowrap">{{ $masa->{$columna} }}</p>
                                                        </td>
                                                    @endforeach
                                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                                    
                                                        <p class="text-gray-900 whitespace-no-wrap">
                                                            @if ($masa->fob > 0)
                                                            {{ $masa->fob }}
                                                            @else
                                                            {{ $masa->fob_nacional }}
                                                            @endif
                                                        </p>
                                                    
                                                    </td>
                                                    <td class="px-5 py-2 border-b border-gray-200 bg-white text-sm">
                                                    
                                                        <span wire:click='set_masaid({{$masa->id}})' class="cursor-pointer relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                                            <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full"></span>
                                                            <span class="relative">Editar</span>
                                                        </span>
                                                    
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
                    @else
                        <div class="flex flex-col justify-center items-center h-[100vh]">
                            @if(session('info'))
                                <div class="flex justify-center mt-12">
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
                            <div class="relative flex flex-col items-center rounded-[20px] w-[700px] max-w-[95%] mx-auto bg-white bg-clip-border shadow-3xl shadow-lg  dark:!bg-navy-800 dark:text-white dark:!shadow-none p-3">
                                <div class="mt-2 mb-2 w-full">
                                    <h4 class="px-2 text-xl font-bold text-navy-700 dark:text-white">
                                    Base Liquidaciones
                                    </h4>
                                    <p class="mt-2 px-2 text-base text-gray-600">
                                    As we live, our hearts turn colder. Cause pain is what we go through
                                    as we become older. We get insulted by others, lose trust for those
                                    others. We get back stabbed by friends. It becomes harder for us to
                                    give others a hand. We get our heart broken by people we love, even
                                    that we give them all...
                                    </p>
                                </div> 
                                <div class="">
                                    <form action="{{route('temporada.importBalance2')}}"
                                        method="POST"
                                        class="bg-white rounded px-8 shadow my-4"
                                        enctype="multipart/form-data">
                                        
                                        @csrf
        
                                        <input type="hidden" name="temporada" value={{$temporada->id}}>
        
                                        <x-validation-errors class="errors">
        
                                        </x-validation-errors>
        
                                        <input type="file" name="file" accept=".csv,.xlsx">
        
                                        <x-button class="">
                                            Importar
                                        </x-button>
                                    </form>
        
                                </div>
                                <div class="grid grid-cols-2 gap-4 px-2 w-full">
                                    <div class="flex flex-col items-start justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                                    <p class="text-sm text-gray-600">Education</p>
                                    <p class="text-base font-medium text-navy-700 dark:text-white">
                                        Stanford University
                                    </p>
                                    </div>
                
                                    <div class="flex flex-col justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                                    <p class="text-sm text-gray-600">Languages</p>
                                    <p class="text-base font-medium text-navy-700 dark:text-white">
                                        English, Spanish, Italian
                                    </p>
                                    </div>
                
                                    <div class="flex flex-col items-start justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                                    <p class="text-sm text-gray-600">Department</p>
                                    <p class="text-base font-medium text-navy-700 dark:text-white">
                                        Product Design
                                    </p>
                                    </div>
                
                                    <div class="flex flex-col justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                                    <p class="text-sm text-gray-600">Work History</p>
                                    <p class="text-base font-medium text-navy-700 dark:text-white">
                                        English, Spanish, Italian
                                    </p>
                                    </div>
                
                                    <div class="flex flex-col items-start justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                                    <p class="text-sm text-gray-600">Organization</p>
                                    <p class="text-base font-medium text-navy-700 dark:text-white">
                                        Simmmple Web LLC
                                    </p>
                                    </div>
                
                                    <div class="flex flex-col justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                                    <p class="text-sm text-gray-600">Birthday</p>
                                    <p class="text-base font-medium text-navy-700 dark:text-white">
                                        20 July 1986
                                    </p>
                                    </div>
                                </div>
                            </div>  
                            <p class="font-normal text-navy-700 mt-20 mx-auto w-max">Profile Card component from <a href="https://horizon-ui.com?ref=tailwindcomponents.com" target="_blank" class="text-brand-500 font-bold">Horizon UI Tailwind React</a></p>  
                        </div>
                    @endif
              
                
              </main>
           
           </div>
        </div>
        <script async defer src="https://buttons.github.io/buttons.js"></script>
        <script src="https://demo.themesberg.com/windster/app.bundle.js"></script>
     </div>

    
</x-app-layout>