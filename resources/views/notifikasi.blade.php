@auth
<x-landing-layout>
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main>
                <div class="bg-white mt-8 mx-8 shadow-md">
                    <h1 class="text-2xl font-medium m-2 text-black">Halo DEAR</h1>
                    <p class="text-2xl font-light text-black m-2">
                        Terima kasih atas pesanan anda!, Kami ...
                    </p>
                </div>
            </main>
        </div>
    </div>
</x-landing-layout>
@endauth

@guest
<x-admin.home-layout>
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main>
                <div class="bg-white mt-8 mx-8 rounded-lg shadow-md">
                    <h1 class="text-2xl font-medium m-2 text-black">Halo DEAR</h1>
                    <p class="text-2xl font-light text-black m-2">
                        Terima kasih atas pesanan anda!, Kami ...
                    </p>
                </div>
            </main>
        </div>
    </div>
</x-admin.home-layout>
@endguest