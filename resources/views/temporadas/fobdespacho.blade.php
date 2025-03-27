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
            
                <div class="pb-8 pt-2">
                    
                    <div class="card">
                        
                        
                            @livewire('fob-despacho', ['temporada' => $temporada], key($temporada->id))
                        
                        
                    </div>
            
                </div>
                
              </main>
           
           </div>
        </div>
        <script async defer src="https://buttons.github.io/buttons.js"></script>
        <script src="https://demo.themesberg.com/windster/app.bundle.js"></script>
     </div>

    
</x-app-layout>

