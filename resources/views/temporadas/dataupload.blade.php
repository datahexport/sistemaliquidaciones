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
               <div class="py-16 bg-gray-50 overflow-hidden">
                  <div class="container m-auto px-6 space-y-8 text-gray-500 md:px-12">
                      <div>
                          <span class="text-gray-600 text-lg font-semibold">Main features</span>
                          <h2 class="mt-4 text-2xl text-gray-900 font-bold md:text-4xl">A technology-first approach to payments <br class="lg:block" hidden> and finance</h2>
                      </div>
                      <div class="mt-16 grid border divide-x divide-y rounded-xl overflow-hidden sm:grid-cols-2 lg:divide-y-0 lg:grid-cols-4 xl:grid-cols-4">
                        <div class="relative group bg-white transition hover:z-[1] hover:shadow-2xl">
                           <div class="relative p-8 space-y-8">
                               <img src="https://images.vexels.com/media/users/3/261301/isolated/preview/c7683a822fb4f6d5fb21e9493caf35a3-lana-ar-silhueta-de-transporte-de-barco.png" class="w-10" width="512" height="512" alt="burger illustration">
                               
                               <div class="space-y-2">
                                    <a href="{{route('temporada.datauploadliq',$temporada)}}">
                                        <h5 class="text-xl text-gray-800 font-medium transition group-hover:text-yellow-600 cursor-pointer">Base de Liquidaciones</h5>
                                    </a>
                                   <p class="text-sm text-gray-600">Neque Dolor, fugiat non cum doloribus aperiam voluptates nostrum.</p>
                               </div>
                               <a href="{{route('temporada.datauploadliq',$temporada)}}" class="flex justify-between items-center group-hover:text-yellow-600">
                                   <span class="text-sm">Read more</span>
                                   <span class="-translate-x-4 opacity-0 text-2xl transition duration-300 group-hover:opacity-100 group-hover:translate-x-0">&RightArrow;</span>
                               </a>
                           </div>
                       </div>
                          <div class="relative group bg-white transition hover:z-[1] hover:shadow-2xl">
                              <div class="relative p-8 space-y-8">
                                  <img src="https://tailus.io/sources/blocks/stacked/preview/images/avatars/trowel.png" class="w-10" width="512" height="512" alt="burger illustration">
                                  
                                  <div class="space-y-2">
                                        <a href="{{route('temporada.datauploaddesp',$temporada)}}">
                                        <h5 class="text-xl text-gray-800 font-medium transition group-hover:text-yellow-600 cursor-pointer">Base de Despachos</h5>
                                        </a>
                                      <p class="text-sm text-gray-600">Neque Dolor, fugiat non cum doloribus aperiam voluptates nostrum.</p>
                                  </div>
                                  <a href="{{route('temporada.datauploaddesp',$temporada)}}" class="flex justify-between items-center group-hover:text-yellow-600">
                                      <span class="text-sm">Read more</span>
                                      <span class="-translate-x-4 opacity-0 text-2xl transition duration-300 group-hover:opacity-100 group-hover:translate-x-0">&RightArrow;</span>
                                  </a>
                              </div>
                          </div>
                          <div class="relative group bg-white transition hover:z-[1] hover:shadow-2xl">
                              <div class="relative p-8 space-y-8">
                                  <img src="https://tailus.io/sources/blocks/stacked/preview/images/avatars/package-delivery.png" class="w-10" width="512" height="512" alt="burger illustration">
                                  
                                  <div class="space-y-2">
                                    <a href="{{route('temporada.datauploaddet',$temporada)}}">
                                      <h5 class="text-xl text-gray-800 font-medium transition group-hover:text-yellow-600 cursor-pointer">Base Detalle Liquidaciones</h5>
                                    </a>
                                      <p class="text-sm text-gray-600">Neque Dolor, fugiat non cum doloribus aperiam voluptates nostrum.</p>
                                  </div>
                                  <a href="{{route('temporada.datauploaddet',$temporada)}}" class="flex justify-between items-center group-hover:text-yellow-600">
                                      <span class="text-sm">Read more</span>
                                      <span class="-translate-x-4 opacity-0 text-2xl transition duration-300 group-hover:opacity-100 group-hover:translate-x-0">&RightArrow;</span>
                                  </a>
                              </div>
                          </div>
                          <div class="relative group bg-white transition hover:z-[1] hover:shadow-2xl">
                                <div class="relative p-8 space-y-8">
                                    <img src="https://tailus.io/sources/blocks/stacked/preview/images/avatars/package-delivery.png" class="w-10" width="512" height="512" alt="burger illustration">
                                    
                                    <div class="space-y-2">
                                    <a href="{{route('temporada.datauploaddet',$temporada)}}">
                                        <h5 class="text-xl text-gray-800 font-medium transition group-hover:text-yellow-600 cursor-pointer">Base Producción</h5>
                                    </a>
                                        <p class="text-sm text-gray-600">Neque Dolor, fugiat non cum doloribus aperiam voluptates nostrum.</p>
                                    </div>
                                    <a href="{{route('temporada.datauploaddet',$temporada)}}" class="flex justify-between items-center group-hover:text-yellow-600">
                                        <span class="text-sm">Read more</span>
                                        <span class="-translate-x-4 opacity-0 text-2xl transition duration-300 group-hover:opacity-100 group-hover:translate-x-0">&RightArrow;</span>
                                    </a>
                                </div>
                            </div>
                         
                      </div>
                  </div>
              </div>
                
              </main>
           
           </div>
        </div>
        <script async defer src="https://buttons.github.io/buttons.js"></script>
        <script src="https://demo.themesberg.com/windster/app.bundle.js"></script>
     </div>

    
</x-app-layout>