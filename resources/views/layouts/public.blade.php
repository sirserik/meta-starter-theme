<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('theme.brand.name'))</title>

    {{-- SEO --}}
    <meta name="description" content="@yield('description', config('theme.brand.tagline'))">
    @hasSection('keywords')<meta name="keywords" content="@yield('keywords')">@endif
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Open Graph --}}
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', config('theme.brand.name'))">
    <meta property="og:description" content="@yield('description', config('theme.brand.tagline'))">
    <meta property="og:image" content="@yield('og_image', asset(config('theme.brand.og_image')))">
    <meta property="og:locale" content="{{ app()->getLocale() }}">
    <meta property="og:site_name" content="{{ config('theme.brand.name') }}">

    {{-- Twitter --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', config('theme.brand.name'))">
    <meta name="twitter:description" content="@yield('description', config('theme.brand.tagline'))">
    <meta name="twitter:image" content="@yield('og_image', asset(config('theme.brand.og_image')))">

    {{-- Canonical & hreflang. `lang=` is the locale switch used by
         App\Http\Middleware\SetLocale equivalent — keep canonical
         locale-agnostic, alternates carry the param. --}}
    @php
        $currentUrl     = url()->current();
        $queryParams    = request()->except('lang');
        $canonicalQuery = $queryParams ? '?' . http_build_query($queryParams) : '';
        $availableLocales = config('app.available_locales', ['ru', 'kk', 'en']);
    @endphp
    <link rel="canonical" href="{{ $currentUrl . $canonicalQuery }}">
    @foreach ($availableLocales as $hrefLocale)
        <link rel="alternate" hreflang="{{ $hrefLocale }}"
              href="{{ $currentUrl . '?' . http_build_query(array_merge($queryParams, ['lang' => $hrefLocale])) }}">
    @endforeach
    <link rel="alternate" hreflang="x-default" href="{{ $currentUrl . $canonicalQuery }}">

    {{-- Favicons --}}
    <link rel="icon" type="image/x-icon" href="{{ asset(config('theme.brand.favicon', 'favicon.ico')) }}">

    {{-- Vite bundle from the consumer site (theme has no own bundle) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Design tokens — `:root { --theme-…: … }` — composed by
         ThemeServiceProvider from config('theme.tokens'). --}}
    @isset($themeTokens)<style>{!! $themeTokens !!}</style>@endisset

    {{-- Accessibility prefs — applied BEFORE first paint to avoid FOUC --}}
    <script>
        (function () {
            try {
                var s = function (k) { return localStorage.getItem(k); };
                document.documentElement.classList.add('font-' + (s('accessibility-font-size') || 'normal'));
                if (s('accessibility-dark-mode')      === 'true') document.documentElement.classList.add('dark-mode');
                if (s('accessibility-high-contrast')  === 'true') document.documentElement.classList.add('high-contrast');
            } catch (e) { /* localStorage unavailable */ }
        })();
    </script>

    {{-- Site-specific extras (JSON-LD, GA, etc.) go here. --}}
    @stack('head')
    @stack('styles')
</head>
<body class="font-sans antialiased">
    {{-- Skip-link for keyboard users --}}
    <a href="#main-content"
       class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 focus:z-[9999] focus:bg-white focus:text-[var(--theme-primary)] focus:px-4 focus:py-2 focus:rounded focus:shadow-lg focus:font-semibold">
        {{ __('theme::accessibility.skip_to_content') ?: 'Перейти к содержимому' }}
    </a>

    {{-- Header. Override locally at resources/views/components/header.blade.php
         or in a child theme at <theme>/components/header.blade.php. --}}
    @includeIf('components.header')

    <main id="main-content">
        @yield('content')
    </main>

    @includeIf('components.footer')

    {{-- Optional widgets — toggle in config('theme.features'). --}}
    @if (config('theme.features.apply_form', true) || config('theme.features.info_form', true))
        @includeIf('components.modals')
    @endif

    @includeIf('components.whatsapp-widget')
    @includeIf('components.ai-chat-widget')

    @stack('scripts')
</body>
</html>
