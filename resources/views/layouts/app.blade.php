<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- <title>{{ config('app.name', 'Laravel') }}</title> --}}

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</head>

<body class="font-sans antialiased">
    <div id="app">
        <div class="main-wrapper">
            <div class="navbar-bg"></div>
            {{-- Header --}}
            @include('layouts.header')
            {{-- Sidebar --}}
            @include('layouts.sidebar')

            <!-- Main Content -->
            <div class="main-content">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        {{-- Content Title --}}
                        <h1 class="m-0">@yield('content-title')</h1>
                    </div>
                </div>
                <section class="content-section">
                    {{-- Main Content --}}
                    @yield('content')
                </section>
            </div>
        </div>
        <footer class="main-footer">
            <div class="footer-left">
                Copyright &copy; {{ date('Y') }} <div class="bullet"></div> Created With <a
                    href="https://www.linkedin.com/in/rizki-hanif/">Mohamad Rizki
                    Hanif</a>
            </div>
            <div class="footer-right">
                SMK Walang Jaya
            </div>
        </footer>
    </div>
</body>

</html>
