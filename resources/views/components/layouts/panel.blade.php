<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Harthora' }}</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="min-h-screen bg-white text-slate-800 antialiased">

<header class="border-b border-cyan-100">
    <x-nav />
</header>

<main>
    {{ $slot }}
</main>

<x-footer />

</body>
</html>
