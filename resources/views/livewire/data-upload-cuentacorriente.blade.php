<div>
    @php
        $totalAnalisis=0;
        $totalTransportes=0;

        foreach ($analisisall as $item) {
            $totalAnalisis+=$item->dolar;
        }
        foreach ($transportesall as $item) {
            $totalTransportes+=$item->dolar;
        }
    @endphp
        <div class="lg:mt-12 bg-gray-100 dark:bg-gray-800 md:mt-10 mt-8 lg:py-7 lg:px-6 md:p-6 py-6 px-4 lg:w-full w-full mx-auto">
            <div class="flex justify-between md:flex-row flex-col items-center">
                <div class="md:mb-0 mb-8 md:text-left text-center">
                    <h2 class="font-medium dark:text-white text-xl leading-5 text-gray-800 lg:mb-2 mb-4">{{$vista}}</h2>
                    
                        <!-- Input para seleccionar el archivo -->
                        
                
                        <!-- Botón para subir -->
                        <!-- Botón para subir y spinner de carga -->
                       
                            @if ($vista=="Analisis Multiresiduos")
                                <form wire:submit.prevent="importExcelMultiresiduos" class="space-y-6">
                                    <div class="flex justify-between items-center space-x-4 my-auto">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2 hidden">Seleccionar archivo:</label>
                                            <input type="file" wire:model="fileReciduos"  class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            @error('fileReciduos') 
                                                <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span> 
                                            @enderror
                                        </div>
                                        <!-- Indicador de carga -->
                                        <div wire:loading wire:target="fileReciduos" class="flex items-center my-auto">
                                            <svg class="animate-spin h-5 w-5 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                            </svg>
                                            <span class="ml-2 text-sm text-gray-600">Cargando...</span>
                                        </div>
                                        <!-- Botón para subir archivo -->
                                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                                    wire:loading.attr="disabled" wire:target="fileReciduos">
                                                Subir Excel
                                            </button>
                                    </div>
                                </form>
                            @endif
                            @if ($vista=="Transportes")
                                <form wire:submit.prevent="importExcelTransportes" class="space-y-6">
                                    <div class="flex justify-between items-center space-x-4 my-auto">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2 hidden">Seleccionar archivo:</label>
                                            <input type="file" wire:model="fileTransporte"  class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            @error('fileTransporte') 
                                                <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span> 
                                            @enderror
                                        </div>
                                        <!-- Indicador de carga -->
                                        <div wire:loading wire:target="fileTransporte" class="flex items-center my-auto">
                                            <svg class="animate-spin h-5 w-5 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                            </svg>
                                            <span class="ml-2 text-sm text-gray-600">Cargando...</span>
                                        </div>
                                        <!-- Botón para subir archivo -->
                                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                                    wire:loading.attr="disabled" wire:target="fileTransporte">
                                                Subir Excel
                                            </button>
                                    </div>
                                </form>
                            @endif
                            @if ($vista=="Certificaciones")
                                <form wire:submit.prevent="importExcelCertificaciones" class="space-y-6">
                                    <div class="flex justify-between items-center space-x-4 my-auto">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2 hidden">Seleccionar archivo:</label>
                                            <input type="file" wire:model="fileCertificaciones"  class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            @error('fileCertificaciones') 
                                                <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span> 
                                            @enderror
                                        </div>
                                        <!-- Indicador de carga -->
                                        <div wire:loading wire:target="fileCertificaciones" class="flex items-center my-auto">
                                            <svg class="animate-spin h-5 w-5 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                            </svg>
                                            <span class="ml-2 text-sm text-gray-600">Cargando...</span>
                                        </div>
                                        <!-- Botón para subir archivo -->
                                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                                    wire:loading.attr="disabled" wire:target="fileCertificaciones">
                                                Subir Excel
                                            </button>
                                    </div>
                                </form>
                            @endif
                            @if ($vista=="Materiales")
                                <form wire:submit.prevent="importExcelMateriales" class="space-y-6">
                                    <div class="flex justify-between items-center space-x-4 my-auto">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2 hidden">Seleccionar archivo:</label>
                                            <input type="file" wire:model="fileMateriales"  class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            @error('fileMateriales') 
                                                <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span> 
                                            @enderror
                                        </div>
                                        <!-- Indicador de carga -->
                                        <div wire:loading wire:target="fileMateriales" class="flex items-center my-auto">
                                            <svg class="animate-spin h-5 w-5 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                            </svg>
                                            <span class="ml-2 text-sm text-gray-600">Cargando...</span>
                                        </div>
                                        <!-- Botón para subir archivo -->
                                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                                    wire:loading.attr="disabled" wire:target="fileMateriales">
                                                Subir Excel
                                            </button>
                                    </div>
                                </form>
                            @endif
                         
                            
                      
        
                
                        <!-- Mensaje de éxito -->
                        @if (session()->has('message'))
                            <div class="text-green-500 text-sm text-center mt-4">
                                {{ session('message') }}
                            </div>
                        @endif
                   
                </div>

                <div class="my-auto items-center">
                    @if ($vista=="Analisis Multiresiduos")
                        <button class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            {{number_format($totalAnalisis,2,',','.')}}
                        </button>
                    @endif
                    @if ($vista=="Transportes")
                        <button class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            ${{number_format($totalTransportes,2)}}
                        </button>
                    @endif

                </div>

                <div class="flex justify-center items-center">
                        <select wire:model.live="vista" class="max-w-xl  mx-2 bg-gray-200 border border-gray-200 text-gray-700 py-3 px-6 rounded focus:outline-none focus:bg-white focus:border-gray-500">
                            <option value="Resumen" class="text-left px-10"> Resumen</option>
                            <option value="Analisis Multiresiduos" class="text-left px-10">Analisis Multiresiduos</option>
                            <option value="Transportes" class="text-left px-10">Transportes</option>
                            <option value="Certificaciones" class="text-left px-10">Certificaciones</option>
                            <option value="Materiales" class="text-left px-10"> Materiales</option>
                           
                            <option value="Hidrocooler" class="text-left px-10 hidden">Hidrocooler</option>
                            <option value="Intereses" class="text-left px-10 hidden">Intereses</option>
                            
                        </select>
                </div>
            </div>

            @if ($vista=="Analisis Multiresiduos")
                <div class="overflow-x-auto mt-8">
                    <table class="min-w-full table-auto border-collapse">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-4 py-2 text-left">Fecha</th>
                                <th class="px-4 py-2 text-left">Orden</th>
                                <th class="px-4 py-2 text-left">Precio</th>
                                <th class="px-4 py-2 text-left">UF</th>
                                <th class="px-4 py-2 text-left">Total</th>
                                <th class="px-4 py-2 text-left">T.C (Tipo de Cambio)</th>
                                <th class="px-4 py-2 text-left">Dólar</th>
                                <th class="px-4 py-2 text-left">Orden 2</th>
                                <th class="px-4 py-2 text-left">Productor</th>
                                <th class="px-4 py-2 text-left">Búsqueda</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($analisis as $item)
                                <tr class="border-t">
                                    <td class="px-4 py-2 whitespace-nowrap">{{ $item->fecha }}</td>
                                    <td class="px-4 py-2">{{ $item->orden }}</td>
                                    <td class="px-4 py-2">{{ number_format($item->precio,2,',','.')}}</td>
                                    <td class="px-4 py-2">{{ number_format($item->uf,0,',','.')}}</td>
                                    <td class="px-4 py-2 whitespace-nowrap">{{number_format($item->total,0,',','.')}}</td>
                                    <td class="px-4 py-2">{{ $item->t_c }}</td>
                                    <td class="px-4 py-2">{{number_format($item->dolar,2,',','.')}}</td>
                                    <td class="px-4 py-2">{{ $item->orden2 }}</td>
                                    <td class="px-4 py-2">{{ $item->productor }}</td>
                                    <td class="px-4 py-2">{{ $item->busqueda }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            
            @endif

            @if ($vista=="Transportes")
                <div class="overflow-x-auto  mt-8">
                    <table class="min-w-full table-auto border-collapse">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-4 py-2 text-left">Productor</th>
                                <th class="px-4 py-2 text-left">Fecha</th>
                                <th class="px-4 py-2 text-left">Monto</th>
                                <th class="px-4 py-2 text-left">T.C (Tipo de Cambio)</th>
                                <th class="px-4 py-2 text-left">Dólar</th>
                                <th class="px-4 py-2 text-left">Orden</th>
                                <th class="px-4 py-2 text-left">Búsqueda</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transportes as $item)
                                <tr class="border-t">
                                    <td class="px-4 py-2">{{ $item->productor }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap">{{ $item->fecha }}</td>
                                    <td class="px-4 py-2">{{ $item->monto }}</td>
                                    <td class="px-4 py-2">{{ $item->t_c }}</td>
                                    <td class="px-4 py-2">{{ $item->dolar }}</td>
                                    <td class="px-4 py-2">{{ $item->orden }}</td>
                                    <td class="px-4 py-2">{{ $item->busqueda }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
            @if ($vista=="Certificaciones")
                <div class="overflow-x-auto mt-8">
                    <table class="min-w-full table-auto border-collapse">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-4 py-2 text-left">Productor</th>
                                <th class="px-4 py-2 text-left">Fecha</th>
                                <th class="px-4 py-2 text-left">Material</th>
                                <th class="px-4 py-2 text-left">Cantidad</th>
                                <th class="px-4 py-2 text-left">Precio</th>
                                <th class="px-4 py-2 text-left">Precio 1</th>
                                <th class="px-4 py-2 text-left">T.C (Tipo de Cambio)</th>
                                <th class="px-4 py-2 text-left">Dólar</th>
                                <th class="px-4 py-2 text-left">Orden</th>
                                <th class="px-4 py-2 text-left">Búsqueda</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($certificacions as $item)
                                <tr class="border-t">
                                    <td class="px-4 py-2 whitespace-nowrap">{{ $item->productor }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap">{{ $item->fecha }}</td>
                                    <td class="px-4 py-2">{{ $item->material }}</td>
                                    <td class="px-4 py-2">{{ $item->cant }}</td>
                                    <td class="px-4 py-2">{{ $item->precio }}</td>
                                    <td class="px-4 py-2">{{ $item->precio_1 }}</td>
                                    <td class="px-4 py-2">{{ $item->tc }}</td>
                                    <td class="px-4 py-2">{{ $item->dolar }}</td>
                                    <td class="px-4 py-2">{{ $item->orden }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap">{{ $item->busqueda }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
            @if ($vista=="Materiales")
                <div class="overflow-x-auto mt-8">
                    <table class="min-w-full table-auto border-collapse">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-4 py-2 text-left">Productor</th>
                                <th class="px-4 py-2 text-left">Fecha</th>
                                <th class="px-4 py-2 text-left">Material</th>
                                <th class="px-4 py-2 text-left">Cantidad</th>
                                <th class="px-4 py-2 text-left">Precio</th>
                                <th class="px-4 py-2 text-left">Dólar</th>
                                <th class="px-4 py-2 text-left">Orden</th>
                                <th class="px-4 py-2 text-left">Búsqueda</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($materiales as $item)
                                <tr class="border-t">
                                    <td class="px-4 py-2">{{ $item->productor }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap">{{ $item->fecha }}</td>
                                    <td class="px-4 py-2">{{ $item->material }}</td>
                                    <td class="px-4 py-2">{{ $item->cantidad }}</td>
                                    <td class="px-4 py-2">{{ $item->precio }}</td>
                                    <td class="px-4 py-2">{{ $item->dolar }}</td>
                                    <td class="px-4 py-2">{{ $item->orden }}</td>
                                    <td class="px-4 py-2">{{ $item->busqueda }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
            @php
                $resumentotal=0;
                foreach ($finalResults as $item) {
                    $resumentotal+=$item->total;
                }
            @endphp
            @if ($vista=="Resumen")
                <div class="overflow-x-auto mt-8">
                    <table class="min-w-full table-auto border-collapse">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-4 py-2 text-left">Productor</th>
                                <th class="px-4 py-2 text-center">Total<br>{{ number_format($resumentotal, 2, ',', '.') }}</th>
                                <th class="px-4 py-2 text-center">Análisis<br>{{ number_format($totalAnalisis, 2, ',', '.') }}</th>
                                <th class="px-4 py-2 text-center">Transporte<br>{{ number_format($totalTransporte, 2, ',', '.') }}</th>
                                <th class="px-4 py-2 text-center">Certificación<br>{{ number_format($totalCertificacion, 2, ',', '.') }}</th>
                                <th class="px-4 py-2 text-center">Material<br>{{ number_format($totalMaterial, 2, ',', '.') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($finalResults as $item)
                                <tr class="border-t">
                                    <td class="px-4 py-2">{{ $item->productor }}</td>
                                    <td class="px-4 py-2 text-right">{{ number_format($item->total, 2, ',', '.') }}</td>
                                    <td class="px-4 py-2 text-right">{{ number_format($item->analisis, 2, ',', '.') }}</td>
                                    <td class="px-4 py-2 text-right">{{ number_format($item->transporte, 2, ',', '.') }}</td>
                                    <td class="px-4 py-2 text-right">{{ number_format($item->certificacion, 2, ',', '.') }}</td>
                                    <td class="px-4 py-2 text-right">{{ number_format($item->material, 2, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
            
            @endif

        </div>


       
        
    

    <script>
        let elements = document.querySelectorAll("[data-menu]");
        for (let i = 0; i < elements.length; i++) {
        let main = elements[i];

        main.addEventListener("click", function () {
            let element = main.parentElement.parentElement;
            let indicators = main.querySelectorAll("img");
            let child = element.querySelector("#menu");
            let h = element.querySelector("#mainHeading>div>p");

            h.classList.toggle("font-semibold");
            child.classList.toggle("hidden");
            // console.log(indicators[0]);
            indicators[0].classList.toggle("rotate-180");
        });
        }
    </script>
</div>
