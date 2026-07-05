<div>
    <!-- Header -->
    <div class="px-6 pt-12 pb-6 relative z-10">
        <h1 class="text-2xl font-bold text-gray-800">Riwayat Janji Temu</h1>
        <p class="text-sm text-gray-500 mt-1">Daftar appointment untuk semua anggota keluarga</p>
    </div>

    <!-- Filters -->
    <div class="px-6 mb-4 space-y-3 relative z-10">
        <div class="flex gap-2 overflow-x-auto pb-2 scrollbar-hide">
            <select wire:model.live="profileId" class="bg-white/70 backdrop-blur border border-white/60 rounded-full px-4 py-2 text-sm text-gray-700 shadow-sm focus:ring-mint focus:border-mint min-w-max">
                <option value="">Semua Profil</option>
                @foreach($profiles as $profile)
                <option value="{{ $profile->id }}">{{ $profile->full_name }}</option>
                @endforeach
            </select>

            <select wire:model.live="status" class="bg-white/70 backdrop-blur border border-white/60 rounded-full px-4 py-2 text-sm text-gray-700 shadow-sm focus:ring-mint focus:border-mint min-w-max">
                <option value="">Semua Status</option>
                <option value="pending">Menunggu</option>
                <option value="approved">Disetujui</option>
                <option value="checked_in">Hadir</option>
                <option value="calling">Dipanggil</option>
                <option value="processing">Diperiksa</option>
                <option value="completed">Selesai</option>
                <option value="cancelled">Dibatalkan</option>
            </select>

            <select wire:model.live="dateRange" class="bg-white/70 backdrop-blur border border-white/60 rounded-full px-4 py-2 text-sm text-gray-700 shadow-sm focus:ring-mint focus:border-mint min-w-max">
                <option value="">Semua Waktu</option>
                <option value="upcoming">Akan Datang</option>
                <option value="past">Berlalu</option>
            </select>
        </div>
    </div>

    <!-- List -->
    <div class="px-6 pb-28 space-y-4 relative z-10">
        @forelse($appointments as $appointment)
        <div class="bg-white/80 backdrop-blur border border-white/60 rounded-2xl p-4 shadow-sm relative overflow-hidden group">
            <!-- Status Badge & Date -->
            <div class="flex justify-between items-center mb-3">
                @php
                    $statusColors = [
                        'pending' => 'bg-gray-100 text-gray-700',
                        'approved' => 'bg-amber-100 text-amber-700',
                        'checked_in' => 'bg-blue-100 text-blue-700',
                        'calling' => 'bg-orange-100 text-orange-700 animate-pulse',
                        'processing' => 'bg-purple-100 text-purple-700',
                        'completed' => 'bg-mint-light text-mint-dark',
                        'cancelled' => 'bg-red-100 text-red-700',
                    ];
                    $statusLabels = [
                        'pending' => 'Menunggu Approval',
                        'approved' => 'Disetujui',
                        'checked_in' => 'Sudah Hadir',
                        'calling' => 'Sedang Dipanggil',
                        'processing' => 'Sedang Diperiksa',
                        'completed' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                    ];
                    $badgeClass = $statusColors[$appointment->status] ?? 'bg-gray-100 text-gray-700';
                    $badgeText = $statusLabels[$appointment->status] ?? ucfirst($appointment->status);
                @endphp
                <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $badgeClass }}">
                    {{ $badgeText }}
                </span>
                
                <span class="text-xs font-medium text-gray-500">
                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->locale('id')->isoFormat('D MMM YYYY') }}
                </span>
            </div>

            <div class="flex items-start gap-3">
                <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center shrink-0">
                    @if($appointment->doctor->photo)
                        <img src="{{ Storage::url($appointment->doctor->photo) }}" alt="Dr." class="w-full h-full object-cover rounded-xl">
                    @else
                        <i data-lucide="user-md" class="w-6 h-6 text-gray-400"></i>
                    @endif
                </div>
                
                <div class="flex-1 min-w-0">
                    <h3 class="font-bold text-gray-800 text-sm truncate">{{ $appointment->doctor->name }}</h3>
                    <p class="text-xs text-gray-500">{{ $appointment->doctor->polyclinic->name }}</p>
                    
                    <div class="flex items-center gap-1 mt-2 text-xs text-gray-600 bg-gray-50 p-1.5 rounded-lg inline-flex">
                        <i data-lucide="user" class="w-3.5 h-3.5 text-mint-dark"></i>
                        <span class="font-medium truncate">{{ $appointment->patientProfile->full_name }}</span>
                    </div>
                </div>

                @if($appointment->queue_number)
                <div class="text-center shrink-0 bg-mint/10 px-3 py-2 rounded-xl">
                    <span class="block text-[10px] font-semibold text-mint-dark">Antrian</span>
                    <span class="block text-xl font-black text-gray-800">{{ $appointment->queue_number }}</span>
                </div>
                @endif
            </div>

            @if($appointment->service)
            <div class="mt-3 pt-3 border-t border-gray-100">
                <p class="text-xs text-gray-600 flex items-center gap-1.5">
                    <i data-lucide="stethoscope" class="w-3.5 h-3.5"></i>
                    {{ $appointment->service->name }}
                </p>
            </div>
            @endif
        </div>
        @empty
        <div class="text-center py-12">
            <div class="w-20 h-20 bg-white/50 rounded-full flex items-center justify-center mx-auto mb-4">
                <i data-lucide="inbox" class="w-10 h-10 text-gray-400"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-800">Tidak ada riwayat</h3>
            <p class="text-sm text-gray-500 mt-1">Belum ada janji temu yang sesuai filter.</p>
        </div>
        @endforelse

        <div class="mt-4">
            {{ $appointments->links() }}
        </div>
    </div>
</div>
