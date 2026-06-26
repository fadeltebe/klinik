<div>
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-mint-dark">Manajemen Antrean</h1>
            <p class="text-sm text-gray-500">Kelola persetujuan dan alur antrean pasien hari ini</p>
        </div>

        @if($isGlobalAdmin)
        <div class="flex items-center gap-3">
            <label for="doctorSelect" class="text-sm font-semibold text-gray-700">Pilih Dokter:</label>
            <select wire:model.live="selectedDoctorId" id="doctorSelect" class="rounded-xl border-gray-200 bg-white shadow-sm focus:border-mint focus:ring focus:ring-mint focus:ring-opacity-50 text-sm">
                @foreach($doctors as $doc)
                <option value="{{ $doc->id }}">{{ $doc->name }} ({{ $doc->polyclinic->name ?? '-' }})</option>
                @endforeach
            </select>
        </div>
        @endif
    </div>

    @if (session()->has('success'))
    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl flex items-start gap-3 shadow-sm">
        <i data-lucide="check-circle" class="w-5 h-5 flex-shrink-0 mt-0.5"></i>
        <span class="text-sm font-medium">{{ session('success') }}</span>
    </div>
    @endif

    <!-- Tabs -->
    <div class="flex gap-2 mb-6 border-b border-gray-200 pb-2 overflow-x-auto">
        <button wire:click="setTab('pending')" class="px-5 py-2.5 rounded-t-xl text-sm font-semibold transition-colors flex items-center gap-2 {{ $activeTab === 'pending' ? 'bg-mint text-white shadow-sm' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}">
            <i data-lucide="clock" class="w-4 h-4"></i>
            Menunggu Persetujuan
            @if(count($pendingAppointments) > 0)
            <span class="{{ $activeTab === 'pending' ? 'bg-white/20 text-white' : 'bg-orange-500 text-white' }} text-[10px] px-2 py-0.5 rounded-full">{{ count($pendingAppointments) }}</span>
            @endif
        </button>
        <button wire:click="setTab('active')" class="px-5 py-2.5 rounded-t-xl text-sm font-semibold transition-colors flex items-center gap-2 {{ $activeTab === 'active' ? 'bg-mint text-white shadow-sm' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}">
            <i data-lucide="users" class="w-4 h-4"></i>
            Antrean Aktif
            @if(count($activeAppointments) > 0)
            <span class="{{ $activeTab === 'active' ? 'bg-white/20 text-white' : 'bg-orange-500 text-white' }} text-[10px] px-2 py-0.5 rounded-full">{{ count($activeAppointments) }}</span>
            @endif
        </button>
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
        <div class="canva-card bg-white/80 backdrop-blur rounded-2xl shadow-sm border border-orange-100 p-5 flex items-center justify-between gap-4">
            <div class="flex-1 flex items-start gap-4">
                <div class="w-12 h-12 bg-orange-50 text-orange-500 rounded-full flex items-center justify-center flex-shrink-0">
                    <i data-lucide="user" class="w-6 h-6"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800">{{ $appt->patientProfile->full_name }}</h3>
                    <p class="text-xs text-gray-500 mt-1">NIK: {{ $appt->patientProfile->nik ?? '-' }}</p>
                    <div class="flex items-center gap-2 mt-2">
                        <span class="bg-orange-100 text-orange-700 text-[10px] font-bold px-2 py-0.5 rounded uppercase">Pending</span>
                        <span class="text-xs text-gray-500">Mendaftar pada: {{ $appt->created_at->format('H:i') }}</span>
                    </div>
                </div>
            </div>
            <div class="flex gap-2 flex-shrink-0 items-center">
                <button wire:click="reject({{ $appt->id }})" class="px-4 py-2 border border-red-200 text-red-600 hover:bg-red-50 rounded-xl text-sm font-semibold transition-colors flex items-center gap-2 shadow-sm">
                    <i data-lucide="x" class="w-4 h-4 text-red-500"></i> Tolak
                </button>
                <button wire:click="approve({{ $appt->id }})" class="px-4 py-2 bg-mint hover:bg-mint-dark text-white rounded-xl text-sm font-semibold transition-colors flex items-center gap-2 shadow-sm">
                    <i data-lucide="check" class="w-4 h-4 text-base"></i> Setujui
                </button>
            </div>
        </div>
        @empty
        <div class="text-center py-12 bg-white/50 backdrop-blur rounded-2xl border border-white/60 shadow-sm">
            <div class="w-16 h-16 bg-gray-50 text-gray-400 rounded-full flex items-center justify-center mx-auto mb-3">
                <i data-lucide="check-circle" class="w-8 h-8"></i>
            </div>
            <p class="text-gray-500 font-medium">Tidak ada permohonan antrean baru.</p>
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

        <div data-id="{{ $appt->id }}" class="canva-card bg-white/80 backdrop-blur rounded-2xl shadow-sm border border-gray-100 p-5 flex items-center justify-between gap-4 {{ $appt->status === 'calling' ? 'ring-2 ring-purple-300' : '' }}">
            <div class="flex-1 flex items-center gap-5">
                <i data-lucide="grip-vertical" class="w-5 h-5 text-gray-300 cursor-grab hover:text-gray-500 drag-handle flex-shrink-0"></i>
                <div class="text-center w-14">
                    <span class="block text-[10px] text-gray-400 font-bold uppercase">Antrean</span>
                    <span class="block text-3xl font-bold text-mint-dark">{{ $appt->queue_number }}</span>
                </div>
                <div class="h-10 w-px bg-gray-200"></div>
                <div>
                    <h3 class="font-bold text-gray-800">{{ $appt->patientProfile->full_name }}</h3>
                    <div class="flex items-center gap-2 mt-1.5">
                        <span class="{{ $colorClass }} text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-wide">{{ $label }}</span>
                    </div>
                </div>
            </div>
            <div class="flex gap-2 flex-shrink-0 items-center">
                @if($appt->status === 'approved')
                <button wire:click="updateStatus({{ $appt->id }}, 'checked_in')" class="px-4 py-2 border border-blue-200 text-blue-600 hover:bg-blue-50 rounded-xl text-xs font-semibold transition-colors flex items-center gap-2 shadow-sm">
                    <i data-lucide="user-check" class="w-4 h-4"></i> Pasien Hadir
                </button>
                @elseif($appt->status === 'checked_in')
                <button wire:click="updateStatus({{ $appt->id }}, 'calling')" class="px-4 py-2 bg-purple-100 text-purple-700 hover:bg-purple-200 rounded-xl text-xs font-semibold transition-colors flex items-center gap-2 shadow-sm">
                    <i data-lucide="mic" class="w-4 h-4"></i> Panggil
                </button>
                @elseif($appt->status === 'calling')
                <button wire:click="updateStatus({{ $appt->id }}, 'processing')" class="px-4 py-2 bg-emerald-100 text-emerald-700 hover:bg-emerald-200 rounded-xl text-xs font-semibold transition-colors flex items-center gap-2 shadow-sm">
                    <i data-lucide="door-open" class="w-4 h-4"></i> Masuk Ruangan
                </button>
                @elseif($appt->status === 'processing')
                <button wire:click="updateStatus({{ $appt->id }}, 'completed')" class="px-4 py-2 bg-mint hover:bg-mint-dark text-white rounded-xl text-xs font-semibold transition-colors flex items-center gap-2 shadow-sm" title="Biasanya dilakukan oleh Dokter">
                    <i data-lucide="check-check" class="w-4 h-4"></i> Selesai
                </button>
                @endif
            </div>
        </div>
        @empty
        <div class="text-center py-12 bg-white/50 backdrop-blur rounded-2xl border border-white/60 shadow-sm">
            <div class="w-16 h-16 bg-gray-50 text-gray-400 rounded-full flex items-center justify-center mx-auto mb-3">
                <i data-lucide="users" class="w-8 h-8"></i>
            </div>
            <p class="text-gray-500 font-medium">Tidak ada antrean aktif saat ini.</p>
        </div>
        @endforelse
    </div>
    @endif
    @endif
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:init', () => {
        function initSortable() {
            let el = document.getElementById('sortable-queue');
            if(el) {
                // Destroy previous instance if exists
                if(el.sortable) {
                    el.sortable.destroy();
                }
                el.sortable = Sortable.create(el, {
                    handle: '.drag-handle',
                    animation: 150,
                    ghostClass: 'opacity-50',
                    onEnd: function (evt) {
                        let order = Array.from(el.children).map(child => child.dataset.id);
                        @this.updateQueueOrder(order);
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
    });
</script>
@endpush