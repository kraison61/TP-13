
<!doctype html>
<html lang="th" class="scroll-smooth">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    @include('partials.seo-head')
    <link rel="preconnect" href="https://pub-68154224aa0d447b83de9bf218e76277.r2.dev" crossorigin>
    @if (request()->routeIs('home'))
    <link rel="preload" as="image"
          href="{{ \App\Support\R2Image::url('images/about/194914_0.jpg', 800) }}"
          fetchpriority="high">
    @endif
    @php
        $fontsUrl = 'https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Thai:wght@400;600;700&family=IBM+Plex+Sans:wght@500;600;700&display=swap';
        $thaiFontWoff2 = 'https://fonts.gstatic.com/s/ibmplexsansthai/v11/m8JPje1VVIzcq1HzJq2AEdo2Tj_qvLqMHdYgVcM.woff2';
        $criticalCss = \App\Support\CriticalCss::contents();
    @endphp
    @if ($criticalCss !== '')
    <link rel="stylesheet" href="{{ asset('build/critical.css') }}">
    @endif
    <link rel="preload" as="font" type="font/woff2" href="{{ $thaiFontWoff2 }}" crossorigin>
    <link rel="preload" as="style" href="{{ $fontsUrl }}">
    <link rel="stylesheet" href="{{ $fontsUrl }}" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="{{ $fontsUrl }}"></noscript>
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

{{-- ============ FOOTER ============ --}}
<x-frontend.footer />

<x-frontend.to-top />

</body>
</html>
