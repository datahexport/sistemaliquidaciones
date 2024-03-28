<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lista de Filtros') }}
        </h2>
    </x-slot>
 
    <div class="pb-12 pt-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-end mb-6">
                <a href="{{route('razonsync')}}">
                    <button  class="items-center focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 px-6 py-3 bg-gray-500 hover:bg-gray-500 focus:outline-none rounded">
                        <p class="text-sm font-medium leading-none text-white">CREAR PRODUCTORES</p>
                    </button>
                </a>
            </div>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

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
                                  Rut
                                </th>
                                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                  Csg
                                </th>
                              </tr>
                            </thead>
                            <tbody>
                                @foreach ($razons as $razon)
                                    <tr class="bg-gray-100 border-b">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{$razon->id}}</td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                        {{$razon->name}}
                                        </td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                        {{$razon->rut}}
                                        </td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                        {{$razon->csg}}
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
