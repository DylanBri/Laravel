<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />

        <!-- Styles -->
        {{--<link rel="stylesheet" href="{{ mix('css/bootstrap.min.css') }}" />--}}
        <link rel="stylesheet" href="{{ mix('css/bootstrap.css') }}" />
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <link rel="stylesheet" href="{{ mix('css/profile.css') }}">
        @yield('style')

        @livewireStyles

        <!-- Scripts -->
        <script src="{{ mix('js/functions.js') }}" defer></script>
        <script src="{{ mix('js/app.js') }}" defer></script>
        <script src="{{ mix('js/profile.js') }}" defer></script>
        @yield('script')
    </head>
    <body class="font-sans antialiased">
        <x-jet-banner />

        <div class="min-h-screen bg-gray-100">

            @livewire('profile::layouts.navigation-menu')

            <div class="md:grid md:grid-cols-6 {{--min-h-screen--}}" style="min-height: 93vh">
                @livewire('profile::layouts.sidenav')

                <div class="mt-5 md:mt-0 md:col-span-5">
                    <!-- Page Heading -->
                    @if (isset($header))
                        <header class="bg-white shadow">
                            <div class="{{--max-w-7xl--}} mx-auto py-3 px-4 sm:px-6 lg:px-8">
                                {{ $header }}
                            </div>
                        </header>
                    @endif

                    {{--@yield('content')--}}
                    <!-- Page Content -->
                    <main>
                        {{ $slot }}
                    </main>
                </div>
            </div>

        </div>

        @livewireScripts

    </body>
</html>
