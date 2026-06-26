<div>
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-mint-dark">Dashboard Admin</h1>
        <p class="text-sm text-gray-500">Ringkasan antrian klinik hari ini</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <!-- Card: Pending -->
        <div class="canva-card rounded-2xl p-5 border border-orange-100/60 shadow-sm queue-card bg-white/80 backdrop-blur">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-urgency/10 flex items-center justify-center">
                    <i data-lucide="clock" class="w-5 h-5 text-urgency"></i>
                </div>
                <span class="text-2xl font-bold text-urgency">{{ $stats['pending'] }}</span>
            </div>
            <p class="text-sm font-medium text-gray-500">Pending</p>
        </div>

        <!-- Card: Approved -->
        <div class="canva-card rounded-2xl p-5 border border-amber-100/60 shadow-sm queue-card bg-white/80 backdrop-blur">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-success/10 flex items-center justify-center">
                    <i data-lucide="calendar-check" class="w-5 h-5 text-success"></i>
                </div>
                <span class="text-2xl font-bold text-success">{{ $stats['approved'] }}</span>
            </div>
            <p class="text-sm font-medium text-gray-500">Disetujui</p>
        </div>

        <!-- Card: Completed -->
        <div class="canva-card rounded-2xl p-5 border border-emerald-100/60 shadow-sm queue-card bg-white/80 backdrop-blur">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-mint/20 flex items-center justify-center">
                    <i data-lucide="check-circle" class="w-5 h-5 text-mint-dark"></i>
                </div>
                <span class="text-2xl font-bold text-mint-dark">{{ $stats['completed'] }}</span>
            </div>
            <p class="text-sm font-medium text-gray-500">Selesai</p>
        </div>

        <!-- Card: Total -->
        <div class="canva-card rounded-2xl p-5 shadow-sm queue-card bg-mint-dark text-white">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                    <i data-lucide="users" class="w-5 h-5 text-white"></i>
                </div>
                <span class="text-2xl font-bold text-white">{{ $stats['total'] }}</span>
            </div>
            <p class="text-sm font-medium text-mint-50">Total Pasien</p>
        </div>
    </div>

    <!-- Aksi Cepat -->
    <div class="canva-card rounded-2xl p-6 border border-white/60 shadow-sm bg-white/80 backdrop-blur">
        <h2 class="font-bold text-lg mb-4 text-gray-800">Aksi Cepat</h2>
        <div class="flex gap-4">
            <a href="{{ route('admin.queue.index') }}" wire:navigate class="px-5 py-2.5 bg-mint text-white hover:bg-mint-dark rounded-xl text-sm font-semibold transition-colors shadow-sm inline-block">
                Kelola Antrian
            </a>
            <button class="px-5 py-2.5 bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 rounded-xl text-sm font-semibold transition-colors shadow-sm">
                Jadwal Dokter
            </button>
        </div>
    </div>
</div>
