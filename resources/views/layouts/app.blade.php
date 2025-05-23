<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

         <!-- Animacion -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet" />
        

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <script src="https://code.highcharts.com/highcharts.js"></script>

        
        @livewireStyles
              
    </head>
    <body class="font-sans antialiased">
        <x-banner />

        <div class="min-h-screen bg-gray-100">
            @if(Route::currentRouteName() != 'temporada.clientes' && Route::currentRouteName() != 'temporada.finanzas' && Route::currentRouteName() != 'temporada.saldoaliquidar2' && Route::currentRouteName() != 'temporada.saldoaliquidar' && Route::currentRouteName() != 'temporada.graficovariedad' && Route::currentRouteName() != 'temporada.grafico' && Route::currentRouteName() != 'temporada.anticipos' && Route::currentRouteName() != 'temporada.precioajustado' && Route::currentRouteName() != 'temporada.datauploadcomercial'&& Route::currentRouteName() != 'temporada.datauploadcuentacorriente' && Route::currentRouteName() != 'temporada.resume' && Route::currentRouteName() != 'temporada.costocaja' && Route::currentRouteName() != 'temporada.fobdespacho' && Route::currentRouteName() != 'temporada.datauploadprod' && Route::currentRouteName() != 'temporada.precio.original' && Route::currentRouteName() != 'users.index' && Route::currentRouteName() != 'temporada.gastos' && Route::currentRouteName() != 'temporada.dataupload' && Route::currentRouteName() != 'temporada.datauploadliq' && Route::currentRouteName() != 'temporada.datauploaddesp' && Route::currentRouteName() != 'temporada.datauploaddet' && Route::currentRouteName() != 'dashboard' && Route::currentRouteName() != 'home' && Route::currentRouteName() != 'temporadas.show')
                @livewire('navigation-menu')
            @endif
            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

        @livewireScripts
        
        @stack('js')
    </body>
</html>
