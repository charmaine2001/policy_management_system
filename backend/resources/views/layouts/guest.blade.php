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

        <!-- Scripts -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            zimnat: {
                                blue: '#004a99',
                                'blue-dark': '#002d6b',
                                'blue-light': '#1a6abf',
                                green: '#7fb13b',
                                'green-dark': '#5f8a27',
                            }
                        },
                        fontFamily: {
                            sans: ['Figtree', 'ui-sans-serif', 'system-ui']
                        }
                    }
                }
            }
        </script>
    </head>
    <body class="font-sans text-gray-900 antialiased" style="background: #ffffff;">
        <div class="min-h-screen flex flex-col sm:justify-center items-center p-6">
            <div class="w-full sm:max-w-md">
                <div class="bg-white px-10 py-12 shadow-[0_32px_64px_-12px_rgba(0,74,153,0.1)] border border-gray-100 sm:rounded-[32px] relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mr-16 -mt-16 w-48 h-48 bg-zimnat-green/5 rounded-full blur-3xl"></div>
                    <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-48 h-48 bg-zimnat-blue/5 rounded-full blur-3xl"></div>
                    
                    {{ $slot }}
                </div>
                
                <div class="mt-10 flex flex-col items-center gap-6">
                    <div class="flex items-center gap-3">
                        <div class="w-6 h-6 rounded-lg bg-gray-900 flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="none"><path d="M12 2L3 7V17L12 22L21 17V7L12 2Z" fill="currentColor"/></svg>
                        </div>
                        <span class="text-xs font-black text-gray-900 uppercase tracking-widest">Zimnat Life</span>
                    </div>
                    <p class="text-[10px] font-black text-gray-300 uppercase tracking-[0.3em]">
                        Professional Policy Management System
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>
