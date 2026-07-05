<div>
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white/80 backdrop-blur border border-white/60 p-6 rounded-2xl shadow-sm relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-blue-500/10 rounded-full group-hover:scale-110 transition-transform"></div>
            <div class="flex justify-between items-start relative z-10">
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">Total Pasien Hari Ini</p>
                    <h3 class="text-3xl font-black text-gray-800">{{ $stats['total'] }}</h3>
                </div>
                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center">
                    <i data-lucide="users" class="w-6 h-6"></i>
                </div>
            </div>
        </div>

        <div class="bg-white/80 backdrop-blur border border-white/60 p-6 rounded-2xl shadow-sm relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-mint/10 rounded-full group-hover:scale-110 transition-transform"></div>
            <div class="flex justify-between items-start relative z-10">
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">Selesai Diperiksa</p>
                    <h3 class="text-3xl font-black text-gray-800">{{ $stats['completed'] }}</h3>
                </div>
                <div class="w-12 h-12 bg-mint/20 text-mint-dark rounded-xl flex items-center justify-center">
                    <i data-lucide="check-circle" class="w-6 h-6"></i>
                </div>
            </div>
        </div>

        <div class="bg-white/80 backdrop-blur border border-white/60 p-6 rounded-2xl shadow-sm relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-orange-500/10 rounded-full group-hover:scale-110 transition-transform"></div>
            <div class="flex justify-between items-start relative z-10">
                <div>
                    <p class="text-sm font-medium text-gray-500 mb-1">Belum Diperiksa</p>
                    <h3 class="text-3xl font-black text-gray-800">{{ $stats['remaining'] }}</h3>
                </div>
                <div class="w-12 h-12 bg-orange-50 text-orange-600 rounded-xl flex items-center justify-center">
                    <i data-lucide="clock" class="w-6 h-6"></i>
                </div>
            </div>
        </div>
    </div>

    @if(!$doctorId)
        <div class="bg-red-50 text-red-600 p-4 rounded-xl flex items-center gap-3">
            <i data-lucide="alert-circle" class="w-5 h-5"></i>
            <p class="font-medium">Akun Anda belum ditautkan ke profil Dokter. Hubungi Admin.</p>
        </div>
    @else
        <!-- Daftar Pasien Hari Ini -->
        <div class="bg-white/80 backdrop-blur border border-white/60 rounded-2xl shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <h3 class="font-bold text-gray-800 text-lg flex items-center gap-2">
                    <i data-lucide="list-ordered" class="w-5 h-5 text-mint-dark"></i>
                    Daftar Antrean Hari Ini
                </h3>
                <button wire:click="$refresh" class="text-gray-400 hover:text-mint-dark transition-colors">
                    <i data-lucide="refresh-cw" class="w-5 h-5"></i>
                </button>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/80 text-gray-500 text-xs uppercase tracking-wider">
                            <th class="p-4 font-semibold">No.</th>
                            <th class="p-4 font-semibold">Pasien</th>
                            <th class="p-4 font-semibold">Layanan</th>
                            <th class="p-4 font-semibold">Estimasi</th>
                            <th class="p-4 font-semibold">Status</th>
                            <th class="p-4 font-semibold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($appointments as $appointment)
                            <tr class="hover:bg-gray-50/50 transition-colors {{ $appointment->status == 'calling' ? 'bg-orange-50/50' : ($appointment->status == 'processing' ? 'bg-purple-50/50' : '') }}">
                                <td class="p-4 text-gray-800 font-bold text-lg">
                                    {{ $appointment->queue_number }}
                                </td>
                                <td class="p-4">
                                    <p class="font-bold text-gray-800">{{ $appointment->patientProfile->full_name }}</p>
                                    <p class="text-xs text-gray-500">{{ $appointment->patientProfile->gender == 'male' ? 'L' : 'P' }} • {{ \Carbon\Carbon::parse($appointment->patientProfile->date_of_birth)->age }} thn</p>
                                    @if($appointment->complaint)
                                    <p class="text-xs text-gray-500 mt-1 italic w-48 truncate" title="{{ $appointment->complaint }}">"{{ $appointment->complaint }}"</p>
                                    @endif
                                </td>
                                <td class="p-4 text-sm text-gray-600">
                                    {{ $appointment->service->name ?? '-' }}
                                </td>
                                <td class="p-4 text-sm font-medium text-gray-600">
                                    {{ \Carbon\Carbon::parse($appointment->estimated_service_time)->format('H:i') }}
                                </td>
                                <td class="p-4">
                                    @php
                                        $statusColors = [
                                            'approved' => 'bg-gray-100 text-gray-600',
                                            'checked_in' => 'bg-blue-100 text-blue-700',
                                            'calling' => 'bg-orange-100 text-orange-700 font-bold animate-pulse',
                                            'processing' => 'bg-purple-100 text-purple-700 font-bold',
                                            'completed' => 'bg-mint/20 text-mint-dark',
                                        ];
                                        $statusLabels = [
                                            'approved' => 'Belum Hadir',
                                            'checked_in' => 'Menunggu',
                                            'calling' => 'Dipanggil',
                                            'processing' => 'Diperiksa',
                                            'completed' => 'Selesai',
                                        ];
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusColors[$appointment->status] ?? 'bg-gray-100' }}">
                                        {{ $statusLabels[$appointment->status] ?? $appointment->status }}
                                    </span>
                                </td>
                                <td class="p-4 text-right space-x-1">
                                    @if(in_array($appointment->status, ['approved', 'checked_in', 'calling']))
                                        <button wire:click="callPatient({{ $appointment->id }})" class="p-2 bg-orange-100 text-orange-600 hover:bg-orange-200 rounded-lg transition-colors inline-flex" title="Panggil Pasien">
                                            <i data-lucide="megaphone" class="w-4 h-4"></i>
                                        </button>
                                    @endif
                                    
                                    @if(in_array($appointment->status, ['checked_in', 'calling']))
                                        <button wire:click="processPatient({{ $appointment->id }})" class="p-2 bg-purple-100 text-purple-600 hover:bg-purple-200 rounded-lg transition-colors inline-flex" title="Mulai Periksa">
                                            <i data-lucide="stethoscope" class="w-4 h-4"></i>
                                        </button>
                                    @endif

                                    @if(in_array($appointment->status, ['processing']))
                                        <button wire:click="completePatient({{ $appointment->id }})" class="p-2 bg-mint/20 text-mint-dark hover:bg-mint/30 rounded-lg transition-colors inline-flex" title="Selesai">
                                            <i data-lucide="check" class="w-4 h-4"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-8 text-center text-gray-500">
                                    Tidak ada jadwal pasien hari ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
