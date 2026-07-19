
<!doctype html>
<html lang="th" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    @include('partials.seo-head')
    @php
        $imgBase = rtrim((string) config('schema.r2_base'), '/');
        $criticalCss = \App\Support\CriticalCss::contents();
    @endphp
    <link rel="preconnect" href="{{ $imgBase }}" crossorigin>
    @if (request()->routeIs('home'))
    <link rel="preload" as="image"
          href="{{ \App\Support\R2Image::url('images/about/194914_0.jpg', 600, 'webp', 75) }}"
          fetchpriority="high">
    @endif
    @if ($criticalCss !== '')
    <style>{!! $criticalCss !!}</style>
    @endif
    <link rel="preload" href="{{ asset('fonts/ibm-plex-sans-thai-400-thai.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="stylesheet" href="{{ asset('fonts/fonts.css') }}">
    @vite('resources/js/app.js')
    <link rel="preload" href="{{ Vite::asset('resources/css/app.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="{{ Vite::asset('resources/css/app.css') }}"></noscript>
    @stack('head')
</head>

<body class="font-sans text-ink bg-white antialiased [text-wrap:pretty] overflow-x-hidden">
@include('components.svg-sprite')

{{-- ============ UTILITY BAR ============ --}}
    <x-frontend.utility-bar />

    {{-- ============ NAV ============ --}}
    <x-frontend.nav />

    <main id="main-content">
    {{-- ============ BREADCRUMB ============ --}}
    @empty($hideLayoutBreadcrumb)
        <x-frontend.breadcrumb
            bar
            :current="$breadcrumbCurrent ?? null"
            :parents="$breadcrumbParents ?? []"
        />
    @endempty
    @yield('content')

    {{-- ============ FINANCE ============ --}}
    <x-frontend.finance />

    {{-- ============ CONTACT ============ --}}
    <x-frontend.contact />
    </main>

{{-- ============ FOOTER ============ --}}
<x-frontend.footer />

<x-frontend.to-top />

</body>
</html>
