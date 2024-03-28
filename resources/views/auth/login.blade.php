<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif
        <h1 class="text-center text-white text-3xl my-5 px-4 font-serif">Acceso Sistema Liquidaciones</h1>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="my-6  px-6">
                <x-label for="email" value="{{ __('Email o Usuario') }}" class="text-white text-center text-lg my-2" />
                <x-input id="email" class="block mt-1 w-full" type="text" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="mt-4 my-6  px-6">
                <x-label for="password" value="{{ __('Contraseña') }}" class="text-white text-center text-lg my-2" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>
            {{--
            <div class="block mt-4">
                <label for="remember_me" class="flex items-center text-white">
                    <x-jet-checkbox id="remember_me" name="remember" />
                    <span class="ml-2 text-sm text-white">{{ __('Remember me') }}</span>
                </label>
            </div>
            --}}
            <div class="flex justify-center">
                <x-button class="text-white">
                    {{ __('Ingresar') }}
                </x-button>
            </div>
            
            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                  <a class="hidden underline text-sm text-white hover:text-gray-400  mr-auto" href="{{ route('register') }}">
                    {{ __('Registrarme') }}
                    </a>
                    <a class="underline text-sm text-white hover:text-gray-400" href="{{ route('password.request') }}">
                        {{ __('¿Olvidaste tu clave?') }}
                    </a>
                @endif

                
            </div>
           
        </form>
    </x-authentication-card>
</x-guest-layout>
