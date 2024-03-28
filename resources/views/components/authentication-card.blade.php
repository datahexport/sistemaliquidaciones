<div class="min-h-screen flex flex-col sm:justify-center items-center sm:pt-14" style="background-image: url({{asset('image/bg_hexport.jpeg')}});background-size: cover;box-shadow: inset 0 0 0 2000px rgba(0, 0, 0, 0.4);">
    <div class="pt-16  mt-10">
        {{ $logo }}
    </div>

    <div class="sm:max-w-md mt-6 px-6 py-4 shadow-md overflow-hidden sm:rounded-lg" style="background-color: rgb(0,0,0,0.5); width: 95%;">
        {{ $slot }}
    </div>
</div>
