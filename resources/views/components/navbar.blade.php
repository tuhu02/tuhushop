<!-- Navbar -->
<nav class="bg-gray-900 fixed w-full z-20 h-fit top-0 left-0">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        <a href="{{ route('dashboard')}}" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="{{asset('image/logo-baru.png')}}" class="w-28" alt="Logo">
        </a>
        <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
            <button type="button" class="text-white bg-aqua hover:bg-opacity-80 focus:ring-4 focus:outline-none focus:ring-aqua font-medium rounded-lg text-sm px-4 py-2 text-center">
                Daftar
            </button>
            <button type="button" class="text-aqua focus:ring-4 focus:outline-none focus:ring-aqua font-medium rounded-lg text-sm px-4 py-2 text-center">
                Masuk
            </button>
            <button data-collapse-toggle="navbar-sticky" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-400 rounded-lg md:hidden hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-600"
                aria-controls="navbar-sticky" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
                </svg>
            </button>
        </div>
        <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
            <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-700 rounded-lg bg-gray-800 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-gray-900">
                <li>
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-3 py-2 text-white rounded hover:bg-gray-700 md:hover:bg-transparent md:hover:text-aqua md:p-0">
                        <img src="{{ asset('image/dashboard.svg') }}" class="w-6 h-6 block" alt="">
                        <span>Home</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-3 py-2 text-white rounded hover:bg-gray-700 md:hover:bg-transparent md:hover:text-aqua md:p-0">
                        <img src="{{ asset('image/Tag.svg') }}" class="w-6 h-6 block" alt="">
                        <span>Topup</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('cekTransaksi') }}" class="flex items-center gap-2 px-3 py-2 text-gray-300 rounded hover:bg-gray-700 md:hover:bg-transparent md:hover:text-aqua md:p-0">
                        <img src="{{ asset('image/Search.svg') }}" class="w-6 h-6 block" alt="">
                        <span>Cek Transaksi</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('kontak') }} " class="flex items-center gap-2 px-3 py-2 text-gray-300 rounded hover:bg-gray-700 md:hover:bg-transparent md:hover:text-aqua md:p-0">
                        <img src="{{ asset('image/Man.svg')}}" class="w-6 h-6 block" alt="">
                        <span>FAQ</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>