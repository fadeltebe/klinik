<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KlinikQ - Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-canvas text-text-primary antialiased min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    
    <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
        <h1 class="text-3xl font-bold text-primary-dark tracking-tight">KlinikQ</h1>
        <p class="mt-2 text-sm text-text-secondary">
            Manajemen Klinik Multi-Spesialis
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10 border border-gray-100">
            {{ $slot }}
        </div>
    </div>

    @livewireScripts
</body>
</html>
