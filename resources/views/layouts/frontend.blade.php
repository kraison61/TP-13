
<!doctype html>
<html lang="th" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>ธีรพงษ์การช่าง — รับเหมาก่อสร้างครบวงจร</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Thai:wght@300;400;500;600;700&family=IBM+Plex+Sans:wght@500;600;700&display=swap" rel="stylesheet">
    {{-- npm install bootstrap-icons, then import in app.css: @import "bootstrap-icons/font/bootstrap-icons.css" --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-ink bg-white antialiased [text-wrap:pretty] overflow-x-hidden">

{{-- ============ UTILITY BAR ============ --}}
    <x-frontend.utililty-bar />

    {{-- ============ NAV ============ --}}
    <x-frontend.nav />
@yield('content')

{{-- ============ FINANCE ============ --}}
<x-frontend.finance />

{{-- ============ CONTACT ============ --}}
<x-frontend.contact />

{{-- ============ FOOTER ============ --}}
<x-frontend.footer />

<x-frontend.to-top />

@stack('scripts')
</body>
</html>
