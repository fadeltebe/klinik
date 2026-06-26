<nav class="fixed bottom-0 left-0 right-0 glass border-t border-white/40 px-6 py-3 z-50">
    <div class="flex justify-around items-center max-w-md mx-auto">
        <a href="{{ route('patient.dashboard') }}" class="mob-nav flex flex-col items-center gap-1 {{ request()->routeIs('patient.dashboard') ? 'text-mint-dark' : 'text-gray-400' }}">
            <i data-lucide="home" class="w-6 h-6"></i>
            <span class="text-[10px] font-medium">Beranda</span>
        </a>
        
        <a href="#" class="mob-nav flex flex-col items-center gap-1 text-gray-400">
            <i data-lucide="clipboard-list" class="w-6 h-6"></i>
            <span class="text-[10px] font-medium">Riwayat</span>
        </a>
        
        <a href="{{ route('patient.profiles.index') }}" class="mob-nav flex flex-col items-center gap-1 {{ request()->routeIs('patient.profiles.*') ? 'text-mint-dark' : 'text-gray-400' }}">
            <i data-lucide="user" class="w-6 h-6"></i>
            <span class="text-[10px] font-medium">Profil</span>
        </a>
    </div>
</nav>
