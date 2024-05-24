<nav class="bg-white fixed z-30 w-full">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
       <div class="flex items-center justify-between">
          <div class="flex items-center justify-start">
             <button id="toggleSidebarMobile" aria-expanded="true" aria-controls="sidebar" class="lg:hidden mr-2 text-gray-600 hover:text-gray-900 cursor-pointer p-2 hover:bg-gray-100 focus:bg-gray-100 focus:ring-2 focus:ring-gray-100 rounded">
                <svg id="toggleSidebarMobileHamburger" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                   <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                </svg>
                <svg id="toggleSidebarMobileClose" class="w-6 h-6 hidden" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                   <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
             </button>
             
             <a href="{{ route('dashboard') }}" class="text-xl font-bold flex items-center lg:ml-2.5">

                 <img src="{{asset('image/logo.png')}}" class="h-16 mr-2 ml-6 object-contain" alt="h-export Logo">

                 <span class="hidden self-center whitespace-nowrap">Windster</span>
             </a>

             <form action="#" method="GET" class="hidden lg:block lg:pl-32">
                <label for="topbar-search" class="sr-only">Search</label>
                <div class="mt-1 relative lg:w-64">
                   <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                      <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                         <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                      </svg>
                   </div>
                   <input type="text" name="email" id="topbar-search" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full pl-10 p-2.5" placeholder="Search">
                </div>
             </form>
          </div>
          <div class="flex items-center">
             <button id="toggleSidebarMobileSearch" type="button" class="lg:hidden text-gray-500 hover:text-gray-900 hover:bg-gray-100 p-2 rounded-lg">
                <span class="sr-only">Search</span>
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                   <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                </svg>
             </button>
            

             <div class="hidden sm:flex sm:items-center sm:ms-6">
                 <!-- Teams Dropdown -->
                 @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                     <div class="ms-3 relative">
                         <x-dropdown align="right" width="60">
                             <x-slot name="trigger">
                                 <span class="inline-flex rounded-md">
                                     <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                         {{ Auth::user()->currentTeam->name }}
 
                                         <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                             <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                         </svg>
                                     </button>
                                 </span>
                             </x-slot>
 
                             <x-slot name="content">
                                 <div class="w-60">
                                     <!-- Team Management -->
                                     <div class="block px-4 py-2 text-xs text-gray-400">
                                         {{ __('Manage Team') }}
                                     </div>
 
                                     <!-- Team Settings -->
                                     <x-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                                         {{ __('Team Settings') }}
                                     </x-dropdown-link>
 
                                     @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                         <x-dropdown-link href="{{ route('teams.create') }}">
                                             {{ __('Create New Team') }}
                                         </x-dropdown-link>
                                     @endcan
 
                                     <!-- Team Switcher -->
                                     @if (Auth::user()->allTeams()->count() > 1)
                                         <div class="border-t border-gray-200"></div>
 
                                         <div class="block px-4 py-2 text-xs text-gray-400">
                                             {{ __('Switch Teams') }}
                                         </div>
 
                                         @foreach (Auth::user()->allTeams() as $team)
                                             <x-switchable-team :team="$team" />
                                         @endforeach
                                     @endif
                                 </div>
                             </x-slot>
                         </x-dropdown>
                     </div>
                 @endif
 
                 <!-- Settings Dropdown -->
                 <div class="ms-3 relative">
                     <x-dropdown align="right" width="48">
                         <x-slot name="trigger">
                             @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                 <button class="flex items-center text-sm border-2 rounded-full focus:outline-none border-gray-200 focus:border-gray-300 transition pl-2">
                                    {{ Auth::user()->name }}
                                     <img class="h-8 w-8 ml-2 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                 </button>
                             @else
                                 <span class="inline-flex rounded-md">
                                     <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                         {{ Auth::user()->name }}
 
                                         <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                             <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                         </svg>
                                     </button>
                                 </span>
                             @endif
                         </x-slot>
 
                         <x-slot name="content">
                             
                             <x-dropdown-link href="{{ route('razonsocial.index') }}">
                                 {{ __('Lista Productores') }}
                             </x-dropdown-link>
 
                             <x-dropdown-link href="{{ route('familias.index') }}">
                                 {{ __('Lista de familias') }}
                             </x-dropdown-link>
 
                             <!-- Account Management -->
                             <div class="block px-4 py-2 text-xs text-gray-400">
                                 {{ __('Manage Account') }}
                             </div>
 
                             <x-dropdown-link href="{{ route('profile.show') }}">
                                 {{ __('Profile') }}
                             </x-dropdown-link>
 
                             @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                 <x-dropdown-link href="{{ route('api-tokens.index') }}">
                                     {{ __('API Tokens') }}
                                 </x-dropdown-link>
                             @endif
 
                             <div class="border-t border-gray-200"></div>
 
                             <!-- Authentication -->
                             <form method="POST" action="{{ route('logout') }}" x-data>
                                 @csrf
 
                                 <x-dropdown-link href="{{ route('logout') }}"
                                          @click.prevent="$root.submit();">
                                     {{ __('Salir') }}
                                 </x-dropdown-link>
                             </form>
                         </x-slot>
                     </x-dropdown>
                 </div>
             </div>
          </div>
       </div>
    </div>
 </nav>