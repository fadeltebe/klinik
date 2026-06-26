<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'KlinikQ - Admin' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
</head>

<body class="bg-canvas text-text-primary antialiased min-h-screen font-sans">
    <!-- Desktop Sidebar -->
    <aside class="canva-sidebar hidden lg:flex fixed left-0 top-0 bottom-0 w-64 flex-col p-6 z-40 border-r border-gray-100/50 bg-white/50 backdrop-blur-xl">
        <div class="mb-10">
            <h1 class="text-2xl font-bold text-mint-dark tracking-tight">KlinikQ</h1>
            <span class="text-xs font-semibold text-urgency bg-orange-50 px-2 py-0.5 rounded-full mt-1 inline-block">ADMIN PANEL</span>
        </div>

        <nav class="flex-1 space-y-1 overflow-y-auto">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : 'text-gray-500 hover:bg-gray-50' }} flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all">
                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                <span>Dashboard</span>
            </a>
            <!-- More links -->
        </nav>

        <div class="pt-4 border-t border-gray-100/50 mt-auto">
            <div class="flex items-center gap-3 mb-4 px-2">
                <div class="h-10 w-10 bg-mint/20 rounded-full flex items-center justify-center text-mint-dark font-bold text-sm">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div class="overflow-hidden">
                    <p class="text-sm font-semibold truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-text-secondary truncate">{{ auth()->user()->email }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-sm text-danger hover:bg-red-50 rounded-xl font-medium transition-colors">
                    <i data-lucide="log-out" class="w-5 h-5"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="lg:ml-64 pb-24 lg:pb-8 min-h-screen flex flex-col">
        <!-- Header -->
        <header class="sticky top-0 glass z-30 px-5 py-4 lg:px-8 lg:py-5 border-b border-white/30 flex justify-between items-center">
            <div>
                <h2 class="font-bold text-lg lg:text-2xl text-gray-800">Welcome, {{ explode(' ', auth()->user()->name)[0] }}! 👋</h2>
                <p class="text-sm text-gray-500 mt-0.5">{{ now()->format('l, d F Y') }}</p>
            </div>
            <div class="flex items-center gap-3">
                <button class="w-10 h-10 rounded-full glass flex items-center justify-center border border-white/50 shadow-sm text-urgency lg:hidden" onclick="document.getElementById('logout-form-mobile').submit();">
                    <i data-lucide="log-out" class="w-5 h-5"></i>
                </button>
                <form id="logout-form-mobile" method="POST" action="{{ route('logout') }}" class="hidden">@csrf</form>

                <button class="w-10 h-10 rounded-full glass flex items-center justify-center border border-white/50 shadow-sm">
                    <i data-lucide="bell" class="w-5 h-5 text-urgency"></i>
                </button>
            </div>
        </header>

        <div class="flex-1 p-4 lg:p-8">
            <div class="max-w-7xl mx-auto">
                {{ $slot }}
            </div>
        </div>
    </main>

    <!-- Mobile Bottom Nav -->
    <nav class="lg:hidden fixed bottom-0 left-0 right-0 glass border-t border-white/40 px-6 py-3 z-50">
        <div class="flex justify-around items-center">
            <a href="{{ route('admin.dashboard') }}" class="mob-nav flex flex-col items-center gap-1 {{ request()->routeIs('admin.dashboard') ? 'text-mint-dark' : 'text-gray-400' }}">
                <i data-lucide="layout-dashboard" class="w-6 h-6"></i>
                <span class="text-[10px] font-medium">Dashboard</span>
            </a>
            <!-- Additional mobile nav items here -->
        </div>
    </nav>

    @livewireScripts
    <script>
        lucide.createIcons();
        document.addEventListener('livewire:navigated', () => {
            lucide.createIcons();
        });
        document.addEventListener('livewire:init', () => {
            Livewire.hook('commit', ({ succeed }) => {
                succeed(() => {
                    setTimeout(() => lucide.createIcons(), 10);
                });
            });
        });
    </script>
    @stack('scripts')
</body>

</html>