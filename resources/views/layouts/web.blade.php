<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-white antialiased">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $globalSettings->school_name ?? config('app.name', 'Akademika') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia(
                '(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>

<body class="font-sans text-gray-900 bg-white antialiased dark:bg-gray-900 dark:text-gray-100 transition-colors">
    <div x-data="{
        sidebarOpen: window.innerWidth >= 1024,
        currentTheme: localStorage.theme || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'),
    
        // FUNGSI INI HARUS ADA DAN TIDAK ADA SALAH KETIK
        toggleTheme() {
            this.currentTheme = this.currentTheme === 'dark' ? 'light' : 'dark';
            localStorage.setItem('theme', this.currentTheme);
            document.documentElement.classList.toggle('dark', this.currentTheme === 'dark');
        }
    }" x-init="document.documentElement.classList.toggle('dark', currentTheme === 'dark');
    
    
    $watch('currentTheme', value => {
        if (value === 'dark') {
            document.documentElement.classList.add('dark')
            localStorage.theme = 'dark'
        } else {
            document.documentElement.classList.remove('dark')
            localStorage.theme = 'light'
        }
    });">
        {{-- Navbar Publik --}}
        <header class="bg-white dark:bg-gray-800 shadow-sm transition-colors sticky top-0 z-40">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="{{ route('web.home') }}"
                        class="text-xl font-bold dark:text-white">{{ $globalSettings->school_name ?? config('app.name', 'Akademika') }}</a>
                </div>
                <nav class="hidden md:flex space-x-6 items-center">
                    <a href="{{ route('web.home') }}"
                        class="text-gray-600 dark:text-gray-300 px-3 py-2 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Beranda</a>
                    <a href="{{ route('web.news.index') }}"
                        class="text-gray-600 dark:text-gray-300 px-3 py-2 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Berita</a>
                    <a href="{{ route('login') }}"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 transition ease-in-out duration-150">Login</a>
                    {{-- Toggle Dark/Light Mode --}}
                    <button @click="toggleTheme()" aria-label="Toggle dark mode"
                        class="p-2 rounded-md text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors focus:outline-none">
                        <svg class="h-6 w-6"
                            :class="{ 'hidden': currentTheme === 'dark', 'block': currentTheme === 'light' }"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z">
                            </path>
                        </svg>
                        <svg class="h-6 w-6"
                            :class="{ 'hidden': currentTheme === 'light', 'block': currentTheme === 'dark' }"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 3v1m0 16v1m9-9h1M4 12H3m15.325 3.325l-.707.707M5.388 5.388l-.707-.707M18.325 8.675l.707-.707M5.388 18.325l-.707.707M12 7a5 5 0 100 10 5 5 0 000-10z">
                            </path>
                        </svg>
                    </button>
                </nav>

                {{-- Mobile Menu --}}
                <div class="flex items-center md:hidden">
                    <button @click="open = !open" type="button"
                        class="inline-flex items-center p-2 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-700 transition-colors">
                        <svg class="h-6 w-6" :class="{ 'hidden': open, 'block': !open }" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg class="h-6 w-6" :class="{ 'hidden': !open, 'block': open }" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Responsive Mobile Menu --}}
            <div x-show="open" x-collapse
                class="md:hidden bg-gray-50 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
                <nav class="flex flex-col p-4 space-y-2">
                    <a href="{{ route('web.home') }}"
                        class="block px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors">Beranda</a>
                    <a href="{{ route('web.news.index') }}"
                        class="block px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors">Berita</a>
                    <a href="{{ route('login') }}"
                        class="block px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors">Login</a>

                    {{-- Toggle Dark/Light Mode Mobile --}}
                    <button @click="toggleTheme()"
                        class="block w-full text-left px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors">
                        <div class="flex items-center">
                            <svg class="h-5 w-5 mr-2" :class="{ 'block': currentTheme === 'dark' }" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 3v1m0 16v1m9-9h1M4 12H3m15.325 3.325l-.707.707M5.388 5.388l-.707-.707M18.325 8.675l.707-.707M5.388 18.325l-.707.707M12 7a5 5 0 100 10 5 5 0 000-10z">
                                </path>
                            </svg>
                            <span x-text="currentTheme === 'dark' ? 'Tema Terang' : 'Tema Gelap'"></span>
                        </div>
                    </button>
                </nav>
            </div>
        </header>

        <main class="pt-16">
            @yield('content')
        </main>

        <footer class="bg-gray-800 dark:bg-gray-900 text-gray-300 py-6 mt-12 transition-colors">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                &copy; {{ date('Y') }} {{ $globalSettings->school_name ?? config('app.name', 'Akademika') }}. All
                rights reserved.
            </div>
        </footer>
    </div>
</body>

</html>
