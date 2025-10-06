<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Basic Meta Tags -->
    <title>{{ config('app.name', 'IncidentReport') }}</title>
    <meta name="description" content="Community-driven incident reporting system for better safety and awareness. Report incidents, view maps, and stay informed about your neighborhood.">
    <meta name="keywords" content="incident report, community safety, neighborhood watch, emergency reporting, safety awareness">
    <meta name="author" content="{{ config('app.name', 'IncidentReport') }}">
    <meta name="robots" content="index, follow">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="{{ config('app.name', 'IncidentReport') }} - Community Safety Platform">
    <meta property="og:description" content="Report and track incidents in your community. Stay informed and help keep your neighborhood safe.">
    <meta property="og:image" content="{{ config('app.url') }}/images/og/default.svg">
    <meta property="og:url" content="{{ config('app.url') }}">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ config('app.name', 'IncidentReport') }}">
    <meta property="og:locale" content="{{ str_replace('_', '-', app()->getLocale()) }}">
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ config('app.name', 'IncidentReport') }} - Community Safety Platform">
    <meta name="twitter:description" content="Report and track incidents in your community. Stay informed and help keep your neighborhood safe.">
    <meta name="twitter:image" content="{{ config('app.url') }}/images/og/default.svg">
    
    <!-- Additional Meta Tags -->
    <meta name="theme-color" content="#3366ff">
    <meta name="msapplication-TileColor" content="#3366ff">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="{{ config('app.name', 'IncidentReport') }}">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="{{ config('app.url') }}">
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ config('app.url') }}/favicon.svg">
    <link rel="icon" type="image/x-icon" href="{{ config('app.url') }}/favicon.ico">
    <link rel="apple-touch-icon" href="{{ config('app.url') }}/favicon.svg">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div id="app"></div>
</body>
</html>