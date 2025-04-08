<div class="relative flex-1 flex flex-col min-h-0 border-r border-gray-200 bg-white pt-0">
  
    <div class="flex-1 flex flex-col pt-5 pb-4 overflow-y-auto">
       <div class="flex-1 px-3 bg-white divide-y space-y-1">
        <div class="block px-4 py-2 text-xs text-gray-400">
            {{ __('Liquidación: '.$temporada->name) }}
        </div>
         
          <div class="space-y-2 pt-2">
             <a href="#" class="hidden text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 group transition duration-75 flex items-center p-2">
                <svg class="w-5 h-5 text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="gem" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                   <path fill="currentColor" d="M378.7 32H133.3L256 182.7L378.7 32zM512 192l-107.4-141.3L289.6 192H512zM107.4 50.67L0 192h222.4L107.4 50.67zM244.3 474.9C247.3 478.2 251.6 480 256 480s8.653-1.828 11.67-5.062L510.6 224H1.365L244.3 474.9z"></path>
                </svg>
                <span class="ml-4">Upgrade to Pro</span>
             </a>
            <a href="{{route('temporada.dataupload',$temporada)}}" class="text-base text-gray-900 font-normal rounded-lg flex items-center p-2 @if(Route::currentRouteName() == 'temporada.dataupload') bg-red-500 text-white font-bold @else hover:bg-gray-100  @endif group">
               <svg class="w-6 h-6 @if(Route::currentRouteName() == 'temporada.dataupload') bg-red-500 text-white @else  text-gray-500 group-hover:text-gray-900 @endif  transition duration-75" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                  <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                  <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
               </svg>
               <span class="ml-3">Carga de Archivos</span>

               @if (Route::currentRouteName() == 'temporada.dataupload' || Route::currentRouteName() == 'temporada.datauploadliq' || Route::currentRouteName() == 'temporada.datauploaddesp' || Route::currentRouteName() == 'temporada.datauploaddet')
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 ml-auto justify-end text-right">
                     <path fill-rule="evenodd" d="M12.53 16.28a.75.75 0 0 1-1.06 0l-7.5-7.5a.75.75 0 0 1 1.06-1.06L12 14.69l6.97-6.97a.75.75 0 1 1 1.06 1.06l-7.5 7.5Z" clip-rule="evenodd" />
                  </svg>
                
               @else
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 ml-auto justify-end text-right">
                     <path fill-rule="evenodd" d="M16.28 11.47a.75.75 0 0 1 0 1.06l-7.5 7.5a.75.75 0 0 1-1.06-1.06L14.69 12 7.72 5.03a.75.75 0 0 1 1.06-1.06l7.5 7.5Z" clip-rule="evenodd" />
                  </svg>
               @endif
              
                
                  
            </a>
            @if (Route::currentRouteName() == 'temporada.anticipos' || Route::currentRouteName() == 'temporada.datauploadcuentacorriente' || Route::currentRouteName() == 'temporada.datauploadcomercial' || Route::currentRouteName() == 'temporada.fobdespacho' || Route::currentRouteName() == 'temporada.dataupload' || Route::currentRouteName() == 'temporada.precio.original' || Route::currentRouteName() == 'temporada.datauploadliq' || Route::currentRouteName() == 'temporada.datauploaddesp' || Route::currentRouteName() == 'temporada.datauploaddet')
               <a href="{{route('temporada.datauploadliq',$temporada)}}" class="hidden text-base text-gray-900 font-normal rounded-lg flex items-center p-2 @if(Route::currentRouteName() == 'temporada.datauploadliq') bg-red-500 text-white font-bold @else hover:bg-gray-100  @endif group">
                     <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 ml-3 @if(Route::currentRouteName() == 'temporada.datauploadliq') bg-red-500 text-white @else  text-gray-500 group-hover:text-gray-900 @endif  transition duration-75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4.5h14.25M3 9h9.75M3 13.5h5.25m5.25-.75L17.25 9m0 0L21 12.75M17.25 9v12" />
                      </svg>
                      
                  <span class="ml-3">Base Liquidaciones</span>
               </a>
              
               <a href="{{route('temporada.datauploaddet',$temporada)}}" class="text-base text-gray-900 font-normal rounded-lg flex items-center p-2 @if(Route::currentRouteName() == 'temporada.datauploaddet') bg-red-500 text-white font-bold @else hover:bg-gray-100  @endif group">
                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"  class="w-4 h-4 ml-3 @if(Route::currentRouteName() == 'temporada.datauploaddet') bg-red-500 text-white @else  text-gray-500 group-hover:text-gray-900 @endif  transition duration-75">
                        <path d="M21.721 12.752a9.711 9.711 0 0 0-.945-5.003 12.754 12.754 0 0 1-4.339 2.708 18.991 18.991 0 0 1-.214 4.772 17.165 17.165 0 0 0 5.498-2.477ZM14.634 15.55a17.324 17.324 0 0 0 .332-4.647c-.952.227-1.945.347-2.966.347-1.021 0-2.014-.12-2.966-.347a17.515 17.515 0 0 0 .332 4.647 17.385 17.385 0 0 0 5.268 0ZM9.772 17.119a18.963 18.963 0 0 0 4.456 0A17.182 17.182 0 0 1 12 21.724a17.18 17.18 0 0 1-2.228-4.605ZM7.777 15.23a18.87 18.87 0 0 1-.214-4.774 12.753 12.753 0 0 1-4.34-2.708 9.711 9.711 0 0 0-.944 5.004 17.165 17.165 0 0 0 5.498 2.477ZM21.356 14.752a9.765 9.765 0 0 1-7.478 6.817 18.64 18.64 0 0 0 1.988-4.718 18.627 18.627 0 0 0 5.49-2.098ZM2.644 14.752c1.682.971 3.53 1.688 5.49 2.099a18.64 18.64 0 0 0 1.988 4.718 9.765 9.765 0 0 1-7.478-6.816ZM13.878 2.43a9.755 9.755 0 0 1 6.116 3.986 11.267 11.267 0 0 1-3.746 2.504 18.63 18.63 0 0 0-2.37-6.49ZM12 2.276a17.152 17.152 0 0 1 2.805 7.121c-.897.23-1.837.353-2.805.353-.968 0-1.908-.122-2.805-.353A17.151 17.151 0 0 1 12 2.276ZM10.122 2.43a18.629 18.629 0 0 0-2.37 6.49 11.266 11.266 0 0 1-3.746-2.504 9.754 9.754 0 0 1 6.116-3.985Z" />
                      </svg>
                      
                  <span class="ml-3">Base Detalle Liquidaciones</span>
               </a>
               
               <a href="{{route('temporada.fobdespacho',$temporada)}}" class="text-base text-gray-900 font-normal rounded-lg flex items-center p-2 @if(Route::currentRouteName() == 'temporada.fobdespacho') bg-red-500 text-white font-bold @else hover:bg-gray-100  @endif group">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 ml-3 @if(Route::currentRouteName() == 'temporada.fobdespacho') bg-red-500 text-white @else  text-gray-500 group-hover:text-gray-900 @endif  transition duration-75">
                     <path stroke-linecap="round" stroke-linejoin="round" d="M3 4.5h14.25M3 9h9.75M3 13.5h5.25m5.25-.75L17.25 9m0 0L21 12.75M17.25 9v12" />
                   </svg>
                     
                  <span class="ml-3">FOB Despacho</span>
               </a>

               <a href="{{route('temporada.datauploaddesp',$temporada)}}" class="text-base text-gray-900 font-normal rounded-lg flex items-center p-2 @if(Route::currentRouteName() == 'temporada.datauploaddesp') bg-red-500 text-white font-bold @else hover:bg-gray-100  @endif group">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 ml-3 @if(Route::currentRouteName() == 'temporada.datauploaddesp') bg-red-500 text-white @else  text-gray-500 group-hover:text-gray-900 @endif  transition duration-75">
                           <path fill-rule="evenodd" d="M3 2.25a.75.75 0 0 1 .75.75v.54l1.838-.46a9.75 9.75 0 0 1 6.725.738l.108.054A8.25 8.25 0 0 0 18 4.524l3.11-.732a.75.75 0 0 1 .917.81 47.784 47.784 0 0 0 .005 10.337.75.75 0 0 1-.574.812l-3.114.733a9.75 9.75 0 0 1-6.594-.77l-.108-.054a8.25 8.25 0 0 0-5.69-.625l-2.202.55V21a.75.75 0 0 1-1.5 0V3A.75.75 0 0 1 3 2.25Z" clip-rule="evenodd" />
                         </svg>
                         
                      
                  <span class="ml-3">Base Despachos</span>
               </a>
             
              
               <a href="{{route('temporada.datauploadcomercial',$temporada)}}" class="text-base text-gray-900 font-normal rounded-lg flex items-center p-2 @if(Route::currentRouteName() == 'temporada.datauploadcomercial') bg-red-500 text-white font-bold @else hover:bg-gray-100  @endif group">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 ml-3 @if(Route::currentRouteName() == 'temporada.datauploadcomercial') bg-red-500 text-white @else  text-gray-500 group-hover:text-gray-900 @endif  transition duration-75">
                           <path fill-rule="evenodd" d="M3 2.25a.75.75 0 0 1 .75.75v.54l1.838-.46a9.75 9.75 0 0 1 6.725.738l.108.054A8.25 8.25 0 0 0 18 4.524l3.11-.732a.75.75 0 0 1 .917.81 47.784 47.784 0 0 0 .005 10.337.75.75 0 0 1-.574.812l-3.114.733a9.75 9.75 0 0 1-6.594-.77l-.108-.054a8.25 8.25 0 0 0-5.69-.625l-2.202.55V21a.75.75 0 0 1-1.5 0V3A.75.75 0 0 1 3 2.25Z" clip-rule="evenodd" />
                        </svg>
                        
                     
                  <span class="ml-3">Venta Comercial</span>
               </a>
               <a href="{{route('temporada.datauploadcuentacorriente',$temporada)}}" class="text-base text-gray-900 font-normal rounded-lg flex items-center p-2 @if(Route::currentRouteName() == 'temporada.datauploadcuentacorriente') bg-red-500 text-white font-bold @else hover:bg-gray-100  @endif group">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 ml-3 @if(Route::currentRouteName() == 'temporada.datauploadcuentacorriente') bg-red-500 text-white @else  text-gray-500 group-hover:text-gray-900 @endif  transition duration-75">
                     <path fill-rule="evenodd" d="M3 2.25a.75.75 0 0 1 .75.75v.54l1.838-.46a9.75 9.75 0 0 1 6.725.738l.108.054A8.25 8.25 0 0 0 18 4.524l3.11-.732a.75.75 0 0 1 .917.81 47.784 47.784 0 0 0 .005 10.337.75.75 0 0 1-.574.812l-3.114.733a9.75 9.75 0 0 1-6.594-.77l-.108-.054a8.25 8.25 0 0 0-5.69-.625l-2.202.55V21a.75.75 0 0 1-1.5 0V3A.75.75 0 0 1 3 2.25Z" clip-rule="evenodd" />
                  </svg>
                     
                     
                  <span class="ml-3">Cuenta Corriente</span>
               </a>

               <a href="{{route('temporada.anticipos',$temporada)}}" class="text-base text-gray-900 font-normal rounded-lg flex items-center p-2 @if(Route::currentRouteName() == 'temporada.anticipos') bg-red-500 text-white font-bold @else hover:bg-gray-100  @endif group">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 ml-3 @if(Route::currentRouteName() == 'temporada.anticipos') bg-red-500 text-white @else  text-gray-500 group-hover:text-gray-900 @endif  transition duration-75">
                     <path fill-rule="evenodd" d="M3 2.25a.75.75 0 0 1 .75.75v.54l1.838-.46a9.75 9.75 0 0 1 6.725.738l.108.054A8.25 8.25 0 0 0 18 4.524l3.11-.732a.75.75 0 0 1 .917.81 47.784 47.784 0 0 0 .005 10.337.75.75 0 0 1-.574.812l-3.114.733a9.75 9.75 0 0 1-6.594-.77l-.108-.054a8.25 8.25 0 0 0-5.69-.625l-2.202.55V21a.75.75 0 0 1-1.5 0V3A.75.75 0 0 1 3 2.25Z" clip-rule="evenodd" />
                  </svg>
                     
                     
                  <span class="ml-3">Anticipos</span>
               </a>
                  
               

              

            @endif
            <a href="{{route('temporada.precio.original',$temporada)}}" class="text-base text-gray-900 font-normal rounded-lg flex items-center p-2 @if(Route::currentRouteName() == 'temporada.precio.original') bg-red-500 text-white font-bold @else hover:bg-gray-100  @endif group">
               <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"  class="w-6 h-6 @if(Route::currentRouteName() == 'temporada.precio.original') bg-red-500 text-white @else  text-gray-500 group-hover:text-gray-900 @endif  transition duration-75">
                  <path d="M21.721 12.752a9.711 9.711 0 0 0-.945-5.003 12.754 12.754 0 0 1-4.339 2.708 18.991 18.991 0 0 1-.214 4.772 17.165 17.165 0 0 0 5.498-2.477ZM14.634 15.55a17.324 17.324 0 0 0 .332-4.647c-.952.227-1.945.347-2.966.347-1.021 0-2.014-.12-2.966-.347a17.515 17.515 0 0 0 .332 4.647 17.385 17.385 0 0 0 5.268 0ZM9.772 17.119a18.963 18.963 0 0 0 4.456 0A17.182 17.182 0 0 1 12 21.724a17.18 17.18 0 0 1-2.228-4.605ZM7.777 15.23a18.87 18.87 0 0 1-.214-4.774 12.753 12.753 0 0 1-4.34-2.708 9.711 9.711 0 0 0-.944 5.004 17.165 17.165 0 0 0 5.498 2.477ZM21.356 14.752a9.765 9.765 0 0 1-7.478 6.817 18.64 18.64 0 0 0 1.988-4.718 18.627 18.627 0 0 0 5.49-2.098ZM2.644 14.752c1.682.971 3.53 1.688 5.49 2.099a18.64 18.64 0 0 0 1.988 4.718 9.765 9.765 0 0 1-7.478-6.816ZM13.878 2.43a9.755 9.755 0 0 1 6.116 3.986 11.267 11.267 0 0 1-3.746 2.504 18.63 18.63 0 0 0-2.37-6.49ZM12 2.276a17.152 17.152 0 0 1 2.805 7.121c-.897.23-1.837.353-2.805.353-.968 0-1.908-.122-2.805-.353A17.151 17.151 0 0 1 12 2.276ZM10.122 2.43a18.629 18.629 0 0 0-2.37 6.49 11.266 11.266 0 0 1-3.746-2.504 9.754 9.754 0 0 1 6.116-3.985Z" />
                </svg>
                  
               <span class="ml-3">Precio FOB</span>
            </a>

        

          
            @if ($temporada->procesos->count()>0)
               <a href="{{route('temporada.costocaja',$temporada)}}" class="text-base text-gray-900 font-normal rounded-lg flex items-center p-2 @if(Route::currentRouteName() == 'temporada.costocaja') bg-red-500 text-white font-bold @else hover:bg-gray-100  @endif group">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"  class="w-6 h-6 @if(Route::currentRouteName() == 'temporada.costocaja') bg-red-500 text-white @else  text-gray-500 group-hover:text-gray-900 @endif  transition duration-75">
                     <path d="M21.721 12.752a9.711 9.711 0 0 0-.945-5.003 12.754 12.754 0 0 1-4.339 2.708 18.991 18.991 0 0 1-.214 4.772 17.165 17.165 0 0 0 5.498-2.477ZM14.634 15.55a17.324 17.324 0 0 0 .332-4.647c-.952.227-1.945.347-2.966.347-1.021 0-2.014-.12-2.966-.347a17.515 17.515 0 0 0 .332 4.647 17.385 17.385 0 0 0 5.268 0ZM9.772 17.119a18.963 18.963 0 0 0 4.456 0A17.182 17.182 0 0 1 12 21.724a17.18 17.18 0 0 1-2.228-4.605ZM7.777 15.23a18.87 18.87 0 0 1-.214-4.774 12.753 12.753 0 0 1-4.34-2.708 9.711 9.711 0 0 0-.944 5.004 17.165 17.165 0 0 0 5.498 2.477ZM21.356 14.752a9.765 9.765 0 0 1-7.478 6.817 18.64 18.64 0 0 0 1.988-4.718 18.627 18.627 0 0 0 5.49-2.098ZM2.644 14.752c1.682.971 3.53 1.688 5.49 2.099a18.64 18.64 0 0 0 1.988 4.718 9.765 9.765 0 0 1-7.478-6.816ZM13.878 2.43a9.755 9.755 0 0 1 6.116 3.986 11.267 11.267 0 0 1-3.746 2.504 18.63 18.63 0 0 0-2.37-6.49ZM12 2.276a17.152 17.152 0 0 1 2.805 7.121c-.897.23-1.837.353-2.805.353-.968 0-1.908-.122-2.805-.353A17.151 17.151 0 0 1 12 2.276ZM10.122 2.43a18.629 18.629 0 0 0-2.37 6.49 11.266 11.266 0 0 1-3.746-2.504 9.754 9.754 0 0 1 6.116-3.985Z" />
                  </svg>
                     
                  <span class="ml-3">Costo Caja</span>
               </a>
               <a href="{{route('temporada.precioajustado',$temporada)}}" class="text-base text-gray-900 font-normal rounded-lg flex items-center p-2 @if(Route::currentRouteName() == 'temporada.precioajustado') bg-red-500 text-white font-bold @else hover:bg-gray-100  @endif group">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"  class="w-6 h-6 @if(Route::currentRouteName() == 'temporada.precioajustado') bg-red-500 text-white @else  text-gray-500 group-hover:text-gray-900 @endif  transition duration-75">
                     <path d="M21.721 12.752a9.711 9.711 0 0 0-.945-5.003 12.754 12.754 0 0 1-4.339 2.708 18.991 18.991 0 0 1-.214 4.772 17.165 17.165 0 0 0 5.498-2.477ZM14.634 15.55a17.324 17.324 0 0 0 .332-4.647c-.952.227-1.945.347-2.966.347-1.021 0-2.014-.12-2.966-.347a17.515 17.515 0 0 0 .332 4.647 17.385 17.385 0 0 0 5.268 0ZM9.772 17.119a18.963 18.963 0 0 0 4.456 0A17.182 17.182 0 0 1 12 21.724a17.18 17.18 0 0 1-2.228-4.605ZM7.777 15.23a18.87 18.87 0 0 1-.214-4.774 12.753 12.753 0 0 1-4.34-2.708 9.711 9.711 0 0 0-.944 5.004 17.165 17.165 0 0 0 5.498 2.477ZM21.356 14.752a9.765 9.765 0 0 1-7.478 6.817 18.64 18.64 0 0 0 1.988-4.718 18.627 18.627 0 0 0 5.49-2.098ZM2.644 14.752c1.682.971 3.53 1.688 5.49 2.099a18.64 18.64 0 0 0 1.988 4.718 9.765 9.765 0 0 1-7.478-6.816ZM13.878 2.43a9.755 9.755 0 0 1 6.116 3.986 11.267 11.267 0 0 1-3.746 2.504 18.63 18.63 0 0 0-2.37-6.49ZM12 2.276a17.152 17.152 0 0 1 2.805 7.121c-.897.23-1.837.353-2.805.353-.968 0-1.908-.122-2.805-.353A17.151 17.151 0 0 1 12 2.276ZM10.122 2.43a18.629 18.629 0 0 0-2.37 6.49 11.266 11.266 0 0 1-3.746-2.504 9.754 9.754 0 0 1 6.116-3.985Z" />
                   </svg>
                     
                  <span class="ml-3">Ajuste de costos</span>
               </a>
            @else
               <a href="" class="text-base text-gray-300 font-normal rounded-lg flex items-center p-2 @if(Route::currentRouteName() == 'temporada.costocaja') bg-red-500 text-white font-bold @else   @endif group">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"  class="w-6 h-6 @if(Route::currentRouteName() == 'temporada.costocaja') bg-red-500 text-white @else  text-gray-300 @endif  transition duration-75">
                     <path d="M21.721 12.752a9.711 9.711 0 0 0-.945-5.003 12.754 12.754 0 0 1-4.339 2.708 18.991 18.991 0 0 1-.214 4.772 17.165 17.165 0 0 0 5.498-2.477ZM14.634 15.55a17.324 17.324 0 0 0 .332-4.647c-.952.227-1.945.347-2.966.347-1.021 0-2.014-.12-2.966-.347a17.515 17.515 0 0 0 .332 4.647 17.385 17.385 0 0 0 5.268 0ZM9.772 17.119a18.963 18.963 0 0 0 4.456 0A17.182 17.182 0 0 1 12 21.724a17.18 17.18 0 0 1-2.228-4.605ZM7.777 15.23a18.87 18.87 0 0 1-.214-4.774 12.753 12.753 0 0 1-4.34-2.708 9.711 9.711 0 0 0-.944 5.004 17.165 17.165 0 0 0 5.498 2.477ZM21.356 14.752a9.765 9.765 0 0 1-7.478 6.817 18.64 18.64 0 0 0 1.988-4.718 18.627 18.627 0 0 0 5.49-2.098ZM2.644 14.752c1.682.971 3.53 1.688 5.49 2.099a18.64 18.64 0 0 0 1.988 4.718 9.765 9.765 0 0 1-7.478-6.816ZM13.878 2.43a9.755 9.755 0 0 1 6.116 3.986 11.267 11.267 0 0 1-3.746 2.504 18.63 18.63 0 0 0-2.37-6.49ZM12 2.276a17.152 17.152 0 0 1 2.805 7.121c-.897.23-1.837.353-2.805.353-.968 0-1.908-.122-2.805-.353A17.151 17.151 0 0 1 12 2.276ZM10.122 2.43a18.629 18.629 0 0 0-2.37 6.49 11.266 11.266 0 0 1-3.746-2.504 9.754 9.754 0 0 1 6.116-3.985Z" />
                  </svg>
                     
                  <span class="ml-3">Costo Caja</span>
               </a>
               <a href="" class="text-base text-gray-300 font-normal rounded-lg flex items-center p-2 @if(Route::currentRouteName() == 'temporada.precioajustado') bg-red-500 text-white font-bold @else hover:bg-gray-100  @endif group">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"  class="w-6 h-6 @if(Route::currentRouteName() == 'temporada.precioajustado') bg-red-500 text-white @else  text-gray-500 group-hover:text-gray-900 @endif  transition duration-75">
                     <path d="M21.721 12.752a9.711 9.711 0 0 0-.945-5.003 12.754 12.754 0 0 1-4.339 2.708 18.991 18.991 0 0 1-.214 4.772 17.165 17.165 0 0 0 5.498-2.477ZM14.634 15.55a17.324 17.324 0 0 0 .332-4.647c-.952.227-1.945.347-2.966.347-1.021 0-2.014-.12-2.966-.347a17.515 17.515 0 0 0 .332 4.647 17.385 17.385 0 0 0 5.268 0ZM9.772 17.119a18.963 18.963 0 0 0 4.456 0A17.182 17.182 0 0 1 12 21.724a17.18 17.18 0 0 1-2.228-4.605ZM7.777 15.23a18.87 18.87 0 0 1-.214-4.774 12.753 12.753 0 0 1-4.34-2.708 9.711 9.711 0 0 0-.944 5.004 17.165 17.165 0 0 0 5.498 2.477ZM21.356 14.752a9.765 9.765 0 0 1-7.478 6.817 18.64 18.64 0 0 0 1.988-4.718 18.627 18.627 0 0 0 5.49-2.098ZM2.644 14.752c1.682.971 3.53 1.688 5.49 2.099a18.64 18.64 0 0 0 1.988 4.718 9.765 9.765 0 0 1-7.478-6.816ZM13.878 2.43a9.755 9.755 0 0 1 6.116 3.986 11.267 11.267 0 0 1-3.746 2.504 18.63 18.63 0 0 0-2.37-6.49ZM12 2.276a17.152 17.152 0 0 1 2.805 7.121c-.897.23-1.837.353-2.805.353-.968 0-1.908-.122-2.805-.353A17.151 17.151 0 0 1 12 2.276ZM10.122 2.43a18.629 18.629 0 0 0-2.37 6.49 11.266 11.266 0 0 1-3.746-2.504 9.754 9.754 0 0 1 6.116-3.985Z" />
                   </svg>
                     
                  <span class="ml-3">Ajuste de costos</span>
               </a>
            @endif
           
            <a href="{{route('temporada.datauploadprod',$temporada)}}" class="text-base text-gray-900 font-normal rounded-lg flex items-center p-2 @if(Route::currentRouteName() == 'temporada.datauploadprod') bg-red-500 text-white font-bold @else hover:bg-gray-100  @endif group">
               <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"  class="w-6 h-6 @if(Route::currentRouteName() == 'temporada.datauploadprod') bg-red-500 text-white @else  text-gray-500 group-hover:text-gray-900 @endif  transition duration-75">
                  <path d="M21.721 12.752a9.711 9.711 0 0 0-.945-5.003 12.754 12.754 0 0 1-4.339 2.708 18.991 18.991 0 0 1-.214 4.772 17.165 17.165 0 0 0 5.498-2.477ZM14.634 15.55a17.324 17.324 0 0 0 .332-4.647c-.952.227-1.945.347-2.966.347-1.021 0-2.014-.12-2.966-.347a17.515 17.515 0 0 0 .332 4.647 17.385 17.385 0 0 0 5.268 0ZM9.772 17.119a18.963 18.963 0 0 0 4.456 0A17.182 17.182 0 0 1 12 21.724a17.18 17.18 0 0 1-2.228-4.605ZM7.777 15.23a18.87 18.87 0 0 1-.214-4.774 12.753 12.753 0 0 1-4.34-2.708 9.711 9.711 0 0 0-.944 5.004 17.165 17.165 0 0 0 5.498 2.477ZM21.356 14.752a9.765 9.765 0 0 1-7.478 6.817 18.64 18.64 0 0 0 1.988-4.718 18.627 18.627 0 0 0 5.49-2.098ZM2.644 14.752c1.682.971 3.53 1.688 5.49 2.099a18.64 18.64 0 0 0 1.988 4.718 9.765 9.765 0 0 1-7.478-6.816ZM13.878 2.43a9.755 9.755 0 0 1 6.116 3.986 11.267 11.267 0 0 1-3.746 2.504 18.63 18.63 0 0 0-2.37-6.49ZM12 2.276a17.152 17.152 0 0 1 2.805 7.121c-.897.23-1.837.353-2.805.353-.968 0-1.908-.122-2.805-.353A17.151 17.151 0 0 1 12 2.276ZM10.122 2.43a18.629 18.629 0 0 0-2.37 6.49 11.266 11.266 0 0 1-3.746-2.504 9.754 9.754 0 0 1 6.116-3.985Z" />
               </svg>
                  
               <span class="ml-3">Base Producción</span>
            </a>

             <a href="#" target="_blank" class="hidden text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 group transition duration-75 flex items-center p-2">
                <svg class="w-6 h-6 text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                   <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path>
                </svg>
                <span class="ml-3">Components</span>
             </a>
          
          </div>

          <ul class="space-y-2 pb-2">
            <li>
               <form action="#" method="GET" class="lg:hidden">
                  <label for="mobile-search" class="sr-only">Search</label>
                  <div class="relative">
                     <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                           <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                        </svg>
                     </div>
                     <input type="text" name="email" id="mobile-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-cyan-600 focus:ring-cyan-600 block w-full pl-10 p-2.5" placeholder="Search">
                  </div>
               </form>
            </li>
            <li>
               <a href="{{route('temporadas.show',$temporada)}}" class="text-base text-gray-900 font-normal rounded-lg flex items-center p-2 @if(Route::currentRouteName() == 'temporadas.show' || Route::currentRouteName() == 'razonsocial.show') bg-red-500 text-white @else hover:bg-gray-100  @endif group">
                  <svg class="w-6 h-6 @if(Route::currentRouteName() == 'temporadas.show' || Route::currentRouteName() == 'razonsocial.show') bg-red-500 text-white @else  text-gray-500 group-hover:text-gray-900 @endif  transition duration-75" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                     <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                     <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                  </svg>
                  <span class="ml-3">Lista de productores</span>
               </a>
            </li>

            <li>
              <a href="{{route('temporada.grafico',$temporada)}}" class="text-base text-gray-900 font-normal rounded-lg flex items-center p-2 @if(Route::currentRouteName() == 'temporada.grafico'  || Route::currentRouteName() == 'temporada.graficovariedad') bg-red-500 text-white @else hover:bg-gray-100  @endif group">
                 <svg class="w-6 h-6 @if(Route::currentRouteName() == 'temporada.grafico' || Route::currentRouteName() == 'temporada.graficovariedad') bg-red-500 text-white @else  text-gray-500 group-hover:text-gray-900 @endif  transition duration-75" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                    <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                 </svg>
                 <span class="ml-3">Gráfico</span>
              </a>
           </li>
          
               <li>
                   <a href="{{route('temporada.saldoaliquidar',$temporada)}}" class="text-base text-gray-900 font-normal rounded-lg flex items-center p-2 @if(Route::currentRouteName() == 'temporada.saldoaliquidar') bg-red-500 text-white @else hover:bg-gray-100  @endif group">
                       <svg class="w-6 h-6 @if(Route::currentRouteName() == 'temporada.saldoaliquidar') bg-red-500 text-white @else  text-gray-500 group-hover:text-gray-900 @endif  transition duration-75" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                           <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                       </svg>
                       <span class="ml-3 flex-1 whitespace-nowrap">Saldo a Liquidar</span>
                    </a>

                   
               </li>
               <li>
                  <a href="{{route('temporada.saldoaliquidar2',$temporada)}}" class="text-base text-gray-900 font-normal rounded-lg flex items-center p-2 @if(Route::currentRouteName() == 'temporada.saldoaliquidar2') bg-red-500 text-white @else hover:bg-gray-100  @endif group">
                      <svg class="w-6 h-6 @if(Route::currentRouteName() == 'temporada.saldoaliquidar2') bg-red-500 text-white @else  text-gray-500 group-hover:text-gray-900 @endif  transition duration-75" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                          <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                      </svg>
                      <span class="ml-3 flex-1 whitespace-nowrap">Saldo a Liquidar 2</span>
                   </a>

                  
              </li>

               <li>
                  <a href="{{route('temporada.gastos',$temporada)}}" class="hidden text-base text-gray-900 font-normal rounded-lg flex items-center p-2 @if(Route::currentRouteName() == 'temporada.gastos') bg-red-500 text-white @else hover:bg-gray-100  @endif group">
                      <svg class="w-6 h-6 @if(Route::currentRouteName() == 'temporada.gastos') bg-red-500 text-white @else  text-gray-500 group-hover:text-gray-900 @endif  transition duration-75" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                          <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                      </svg>
                      <span class="ml-3 flex-1 whitespace-nowrap">Mercados</span>
                   </a>

                  
              </li>
              <li>
                  <a href="{{route('temporada.resume',$temporada)}}" class="hidden text-base text-gray-900 font-normal rounded-lg flex items-center p-2 @if(Route::currentRouteName() == 'temporada.resume') bg-red-500 text-white @else hover:bg-gray-100  @endif group">
                     <svg class="w-6 h-6 @if(Route::currentRouteName() == 'temporada.resume') bg-red-500 text-white @else  text-gray-500 group-hover:text-gray-900 @endif  transition duration-75" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                     </svg>
                     <span class="ml-3 flex-1 whitespace-nowrap">Liq. Estimada</span>
                  </a>

                  
               </li>
               <li>
                  <a href="{{route('temporada.clientes',$temporada)}}" class="text-base text-gray-900 font-normal rounded-lg flex items-center p-2 @if(Route::currentRouteName() == 'temporada.clientes') bg-red-500 text-white @else hover:bg-gray-100  @endif group">
                     <svg class="w-6 h-6 @if(Route::currentRouteName() == 'temporada.clientes') bg-red-500 text-white @else  text-gray-500 group-hover:text-gray-900 @endif  transition duration-75" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                     </svg>
                     <span class="ml-3 flex-1 whitespace-nowrap">Comparativo Clientes</span>
                  </a>

                  
               </li>
               <li>
                  <a href="{{route('temporada.finanzas',$temporada)}}" class="text-base text-gray-900 font-normal rounded-lg flex items-center p-2 @if(Route::currentRouteName() == 'temporada.finanzas') bg-red-500 text-white @else hover:bg-gray-100  @endif group">
                     <svg class="w-6 h-6 @if(Route::currentRouteName() == 'temporada.finanzas') bg-red-500 text-white @else  text-gray-500 group-hover:text-gray-900 @endif  transition duration-75" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                     </svg>
                     <span class="ml-3 flex-1 whitespace-nowrap">Finanzas y Facturación</span>
                  </a>

                  
               </li>
               
             
           
         </ul>

       </div>
    </div>
 </div>