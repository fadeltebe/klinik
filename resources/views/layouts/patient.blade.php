<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'KlinikQ - Pasien' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-canvas text-text-primary antialiased min-h-screen flex flex-col font-sans pb-20">
    <main class="flex-grow w-full max-w-md mx-auto relative px-4 py-6">
        {{ $slot }}
    </main>

    <x-bottom-nav />

    @livewireScripts
    <script>
        lucide.createIcons();
        document.addEventListener('livewire:navigated', () => {
            lucide.createIcons();
        });
    </script>
</body>
</html>
