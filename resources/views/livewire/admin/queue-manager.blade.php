<div wire:poll.10s="refreshQueue" class="space-y-3">
    <!-- Header Section -->
    <div class="mb-3">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-2">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-mint-dark">Manajemen Antrean</h1>
                <p class="text-xs sm:text-sm text-gray-500">Kelola persetujuan dan alur antrean pasien</p>
            </div>
            <!-- Date Filter (compact on mobile) -->
            <div class="flex items-center gap-2 bg-white border border-gray-200 rounded-xl px-3 py-2 shadow-sm w-full sm:w-auto">
                <i data-lucide="calendar" class="w-4 h-4 text-mint flex-shrink-0"></i>
                <label for="filterDate" class="sr-only">Tanggal</label>
                <input type="date" wire:model.live="filterDate" id="filterDate" class="flex-1 sm:flex-none border border-transparent bg-transparent text-xs sm:text-sm text-gray-700 focus:border-mint focus:outline-none focus:ring-0 w-full">
            </div>
        </div>

        <!-- Doctor Selection (full width on mobile, 2-col on desktop) -->
        @if($isGlobalAdmin)
        <div class="flex items-center gap-2 bg-white border border-gray-200 rounded-xl px-3 py-2 shadow-sm">
            <i data-lucide="user-check" class="w-4 h-4 text-mint flex-shrink-0"></i>
            <label for="doctorSelect" class="sr-only">Dokter</label>
            <select wire:model.live="selectedDoctorId" id="doctorSelect" class="flex-1 border border-transparent bg-transparent text-xs sm:text-sm text-gray-700 focus:border-mint focus:outline-none focus:ring-0">
                @foreach($doctors as $doc)
                <option value="{{ $doc->id }}">{{ $doc->name }} ({{ $doc->polyclinic->name ?? '-' }})</option>
                @endforeach
            </select>
        </div>
        @endif
    </div>

    @if (session()->has('success'))
    <div class="fixed top-4 left-1/2 -translate-x-1/2 max-w-sm z-50 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl flex items-start gap-3 shadow-lg animate-in fade-in slide-in-from-top-4 duration-300">
        <i data-lucide="check-circle" class="w-5 h-5 flex-shrink-0 mt-0.5"></i>
        <span class="text-sm font-medium">{{ session('success') }}</span>
    </div>
    @endif

    <!-- Tabs -->
    <div class="overflow-x-auto scroll-smooth -mx-4 sm:mx-0 px-4 sm:px-0">
        <div class="inline-flex gap-2 rounded-2xl border border-gray-200 bg-white p-2 shadow-sm">
            <button wire:click="setTab('pending')" class="whitespace-nowrap rounded-2xl px-3 sm:px-4 py-2 text-xs sm:text-sm font-semibold transition-colors flex items-center gap-1.5 {{ $activeTab === 'pending' ? 'bg-mint text-white shadow-sm' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}">
                <i data-lucide="clock" class="w-3.5 h-3.5 sm:w-4 sm:h-4"></i>
                <span class="hidden sm:inline">Menunggu</span><span class="sm:hidden">Tunggu</span>
                @if(count($pendingAppointments) > 0)
                <span class="{{ $activeTab === 'pending' ? 'bg-white/20 text-white' : 'bg-orange-500 text-white' }} text-[9px] px-1.5 py-0.5 rounded-full">{{ count($pendingAppointments) }}</span>
                @endif
            </button>
            <button wire:click="setTab('active')" class="whitespace-nowrap rounded-2xl px-3 sm:px-4 py-2 text-xs sm:text-sm font-semibold transition-colors flex items-center gap-1.5 {{ $activeTab === 'active' ? 'bg-mint text-white shadow-sm' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}">
                <i data-lucide="users" class="w-3.5 h-3.5 sm:w-4 sm:h-4"></i>
                <span class="hidden sm:inline">Aktif</span><span class="sm:hidden">Aktif</span>
                @if(count($activeAppointments) > 0)
                <span class="{{ $activeTab === 'active' ? 'bg-white/20 text-white' : 'bg-orange-500 text-white' }} text-[9px] px-1.5 py-0.5 rounded-full">{{ count($activeAppointments) }}</span>
                @endif
            </button>
            <button wire:click="setTab('completed')" class="whitespace-nowrap rounded-2xl px-3 sm:px-4 py-2 text-xs sm:text-sm font-semibold transition-colors flex items-center gap-1.5 {{ $activeTab === 'completed' ? 'bg-mint text-white shadow-sm' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}">
                <i data-lucide="check-square" class="w-3.5 h-3.5 sm:w-4 sm:h-4"></i>
                <span class="hidden sm:inline">Selesai</span><span class="sm:hidden">Selesai</span>
                @if(count($completedAppointments) > 0)
                <span class="{{ $activeTab === 'completed' ? 'bg-white/20 text-white' : 'bg-gray-400 text-white' }} text-[9px] px-1.5 py-0.5 rounded-full">{{ count($completedAppointments) }}</span>
                @endif
            </button>
        </div>
    </div>

    @if(!$selectedDoctorId)
    <div class="text-center py-12 bg-white/50 backdrop-blur rounded-2xl border border-white/60 shadow-sm">
        <p class="text-gray-500 font-medium">Pilih dokter terlebih dahulu untuk melihat antrean.</p>
    </div>
    @else
    <!-- Tab Content: Pending -->
    @if($activeTab === 'pending')
    <div class="space-y-4">
        @forelse($pendingAppointments as $appt)
        <div class="canva-card bg-white/80 backdrop-blur rounded-2xl shadow-sm border border-orange-100 p-5">
            <div class="grid gap-4">
                <div class="grid grid-cols-[auto_1fr_auto] gap-4 items-start">
                    <div class="w-14 h-14 rounded-2xl bg-orange-50 text-orange-500 flex items-center justify-center">
                        <i data-lucide="user" class="w-6 h-6"></i>
                    </div>
                    <div class="min-w-0">
                        <h3 class="font-bold text-gray-800 truncate">{{ $appt->patientProfile->full_name }}</h3>
                        <p class="text-xs text-gray-500 mt-1 truncate">NIK: {{ $appt->patientProfile->nik ?? '-' }}</p>
                        <p class="text-xs text-gray-500 mt-2">Mendaftar pada: {{ $appt->created_at->format('H:i') }}</p>
                    </div>
                    <div class="text-right">
                        <span class="inline-flex items-center rounded-full bg-orange-100 px-3 py-1 text-[10px] font-bold uppercase tracking-wide text-orange-700">Pending</span>
                    </div>
                </div>

                <div class="flex gap-2">
                    <button wire:click="reject({{ $appt->id }})" class="flex-1 px-4 py-3 border border-red-200 text-red-600 hover:bg-red-50 rounded-2xl text-sm font-semibold transition-colors flex items-center justify-center gap-2 shadow-sm">
                        <i data-lucide="x" class="w-4 h-4 text-red-500"></i>
                        Tolak
                    </button>
                    <button wire:click="approve({{ $appt->id }})" class="flex-1 px-4 py-3 bg-mint hover:bg-mint-dark text-white rounded-2xl text-sm font-semibold transition-colors flex items-center justify-center gap-2 shadow-sm">
                        <i data-lucide="check" class="w-4 h-4"></i>
                        Terima
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-12 bg-white/50 backdrop-blur rounded-2xl border border-white/60 shadow-sm">
            <div class="w-16 h-16 bg-gray-50 text-gray-400 rounded-full flex items-center justify-center mx-auto mb-3">
                <i data-lucide="check-circle" class="w-8 h-8"></i>
            </div>
            <p class="text-gray-500 font-medium">Tidak ada permohonan antrean baru pada tanggal ini.</p>
        </div>
        @endforelse
    </div>
    @endif

    <!-- Tab Content: Active -->
    @if($activeTab === 'active')
    <div id="sortable-queue" class="space-y-4">
        @forelse($activeAppointments as $appt)
        @php
        $statusColors = [
        'approved' => 'bg-amber-100 text-amber-700',
        'checked_in' => 'bg-blue-100 text-blue-700',
        'calling' => 'bg-purple-100 text-purple-700',
        'processing' => 'bg-emerald-100 text-emerald-700',
        ];
        $statusLabels = [
        'approved' => 'Menunggu Kehadiran',
        'checked_in' => 'Hadir di Klinik',
        'calling' => 'Dipanggil',
        'processing' => 'Diperiksa Dokter',
        ];
        $colorClass = $statusColors[$appt->status] ?? 'bg-gray-100 text-gray-700';
        $label = $statusLabels[$appt->status] ?? ucfirst($appt->status);
        @endphp

        <div data-id="{{ $appt->id }}" class="canva-card bg-white/80 backdrop-blur rounded-2xl shadow-sm border border-gray-100 p-3 sm:p-4 grid grid-cols-[auto_1fr_auto] gap-3 items-center {{ $appt->status === 'calling' ? 'ring-2 ring-purple-300' : '' }}">
            <!-- Left: Queue Number with Drag Handle -->
            <div class="flex items-center gap-2 flex-shrink-0">
                <i data-lucide="grip-vertical" class="w-4 h-4 text-gray-300 cursor-grab hover:text-gray-500 drag-handle"></i>
                <div class="text-center">
                    <span class="block text-[9px] text-gray-400 font-bold uppercase">Antrean</span>
                    <span class="block text-2xl sm:text-3xl font-bold text-mint-dark">{{ $appt->queue_number }}</span>
                </div>
            </div>

            <!-- Middle: Patient Name (top) and Status (bottom) -->
            <div class="min-w-0">
                <h3 class="font-bold text-gray-800 truncate text-sm sm:text-base">{{ $appt->patientProfile->full_name }}</h3>
                <span class="{{ $colorClass }} text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-wide whitespace-nowrap inline-block mt-1">{{ $label }}</span>
            </div>

            <!-- Right: Action Button -->
            <div class="flex-shrink-0">
                @if($appt->status === 'approved')
                <button wire:click="updateStatus({{ $appt->id }}, 'checked_in')" class="px-3 sm:px-4 py-2 bg-blue-100 text-blue-700 hover:bg-blue-200 rounded-xl text-[11px] sm:text-xs font-semibold transition-colors flex items-center justify-center gap-1.5 shadow-sm whitespace-nowrap">
                    <i data-lucide="user-check" class="w-4 h-4"></i> <span class="hidden sm:inline">Hadir</span><span class="sm:hidden">Hadir</span>
                </button>
                @elseif($appt->status === 'checked_in')
                <button wire:click="updateStatus({{ $appt->id }}, 'calling')" class="px-3 sm:px-4 py-2 bg-purple-100 text-purple-700 hover:bg-purple-200 rounded-xl text-[11px] sm:text-xs font-semibold transition-colors flex items-center justify-center gap-1.5 shadow-sm whitespace-nowrap">
                    <i data-lucide="mic" class="w-4 h-4"></i> <span class="hidden sm:inline">Panggil</span><span class="sm:hidden">Panggil</span>
                </button>
                @elseif($appt->status === 'calling')
                <button wire:click="updateStatus({{ $appt->id }}, 'processing')" class="px-3 sm:px-4 py-2 bg-emerald-100 text-emerald-700 hover:bg-emerald-200 rounded-xl text-[11px] sm:text-xs font-semibold transition-colors flex items-center justify-center gap-1.5 shadow-sm whitespace-nowrap">
                    <i data-lucide="door-open" class="w-4 h-4"></i> <span class="hidden sm:inline">Masuk</span><span class="sm:hidden">Masuk</span>
                </button>
                @elseif($appt->status === 'processing')
                <button wire:click="updateStatus({{ $appt->id }}, 'completed')" class="px-3 sm:px-4 py-2 bg-mint hover:bg-mint-dark text-white rounded-xl text-[11px] sm:text-xs font-semibold transition-colors flex items-center justify-center gap-1.5 shadow-sm whitespace-nowrap" title="Biasanya dilakukan oleh Dokter">
                    <i data-lucide="check-check" class="w-4 h-4"></i> <span class="hidden sm:inline">Selesai</span><span class="sm:hidden">Selesai</span>
                </button>
                @endif
            </div>
        </div>
        @empty
        <div class="text-center py-12 bg-white/50 backdrop-blur rounded-2xl border border-white/60 shadow-sm">
            <div class="w-16 h-16 bg-gray-50 text-gray-400 rounded-full flex items-center justify-center mx-auto mb-3">
                <i data-lucide="users" class="w-8 h-8"></i>
            </div>
            <p class="text-gray-500 font-medium">Tidak ada antrean aktif pada tanggal ini.</p>
        </div>
        @endforelse
    </div>
    @endif

    <!-- Tab Content: Completed -->
    @if($activeTab === 'completed')
    <div class="space-y-4">
        @forelse($completedAppointments as $appt)
        <div class="canva-card bg-white/60 backdrop-blur rounded-2xl shadow-sm border border-gray-100 p-3 sm:p-4 grid grid-cols-[auto_1fr_auto] gap-3 items-center opacity-75">
            <!-- Left: Queue Number -->
            <div class="text-center flex-shrink-0">
                <span class="block text-[9px] text-gray-400 font-bold uppercase">Antrean</span>
                <span class="block text-2xl sm:text-3xl font-bold text-gray-400">{{ $appt->queue_number }}</span>
            </div>

            <!-- Middle: Patient Name (top) and Status (bottom) -->
            <div class="min-w-0">
                <h3 class="font-bold text-gray-600 truncate text-sm sm:text-base">{{ $appt->patientProfile->full_name }}</h3>
                <div class="flex flex-col sm:flex-row sm:items-center gap-1 mt-1 text-[10px]">
                    @if($appt->status === 'completed')
                    <span class="bg-gray-200 text-gray-600 font-bold px-2 py-0.5 rounded uppercase tracking-wide whitespace-nowrap inline-block">Selesai</span>
                    @elseif($appt->status === 'cancelled')
                    <span class="bg-red-100 text-red-600 font-bold px-2 py-0.5 rounded uppercase tracking-wide whitespace-nowrap inline-block">Dibatalkan</span>
                    @endif
                    <span class="text-gray-400">Jam: {{ $appt->updated_at->format('H:i') }}</span>
                </div>
            </div>

            <!-- Right: Empty or can add action buttons later -->
            <div class="flex-shrink-0"></div>
        </div>
        @empty
        <div class="text-center py-12 bg-white/50 backdrop-blur rounded-2xl border border-white/60 shadow-sm">
            <div class="w-16 h-16 bg-gray-50 text-gray-400 rounded-full flex items-center justify-center mx-auto mb-3">
                <i data-lucide="check-square" class="w-8 h-8"></i>
            </div>
            <p class="text-gray-500 font-medium">Tidak ada data pasien yang selesai pada tanggal ini.</p>
        </div>
        @endforelse
    </div>
    @endif
    @endif
</div>

@script
<script>
    function initSortable() {
        let el = document.getElementById('sortable-queue');
        if (el) {
            // Destroy previous instance if exists
            if (el.sortable) {
                el.sortable.destroy();
            }
            el.sortable = Sortable.create(el, {
                handle: '.drag-handle',
                animation: 150,
                ghostClass: 'opacity-50',
                onEnd: function (evt) {
                    let order = Array.from(el.children).map(child => child.dataset.id);
                    $wire.updateQueueOrder(order);
                }
            });
        }
    }

    initSortable();

    Livewire.hook('commit', ({ succeed }) => {
        succeed(() => {
            setTimeout(() => initSortable(), 50);
        });
    });
</script>
@endscript