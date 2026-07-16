@php
    $seoTitle = $seo['title'] ?? config('company.brand');
    $seoDescription = $seo['description'] ?? '';
    $seoKeywords = $seo['keywords'] ?? null;
    $seoCanonical = $seo['canonical'] ?? url()->current();
    $seoRobots = $seo['robots'] ?? 'index, follow';
    $og = $seo['og'] ?? [];
    $twitter = $seo['twitter'] ?? [];
@endphp

<title>{{ $seoTitle }}</title>
<meta name="description" content="{{ $seoDescription }}">
@if ($seoKeywords)
    <meta name="keywords" content="{{ $seoKeywords }}">
@endif
<meta name="author" content="{{ config('company.name') }}">
<meta name="robots" content="{{ $seoRobots }}">
<meta name="googlebot" content="{{ $seoRobots }}">
<link rel="canonical" href="{{ $seoCanonical }}">

<meta property="og:type" content="{{ $og['type'] ?? 'website' }}">
<meta property="og:url" content="{{ $og['url'] ?? $seoCanonical }}">
<meta property="og:title" content="{{ $og['title'] ?? $seoTitle }}">
<meta property="og:description" content="{{ $og['description'] ?? $seoDescription }}">
<meta property="og:site_name" content="{{ $og['site_name'] ?? config('company.brand') }}">
<meta property="og:locale" content="{{ $og['locale'] ?? 'th_TH' }}">
@if (! empty($og['image']))
    <meta property="og:image" content="{{ $og['image'] }}">
@endif

<meta name="twitter:card" content="{{ $twitter['card'] ?? 'summary_large_image' }}">
<meta name="twitter:title" content="{{ $twitter['title'] ?? $seoTitle }}">
<meta name="twitter:description" content="{{ $twitter['description'] ?? $seoDescription }}">
@if (! empty($twitter['image']))
    <meta name="twitter:image" content="{{ $twitter['image'] }}">
@endif
