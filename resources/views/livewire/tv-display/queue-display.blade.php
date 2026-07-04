<div wire:poll.3s="loadQueueData" class="min-h-screen flex flex-col items-center justify-center relative overflow-hidden font-sans w-full bg-[#F8F7F3]">
    <!-- Animated Background Gradients -->
    <div class="absolute top-[-10%] left-[-10%] w-[50%] h-[50%] bg-orange-400/20 blur-[100px] rounded-full"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[60%] h-[60%] bg-teal-400/20 blur-[120px] rounded-full"></div>

    <style>
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 40px rgba(234, 88, 12, 0.15); }
            50% { box-shadow: 0 0 80px rgba(234, 88, 12, 0.3); }
        }
        .glass-panel {
            background: rgba(255, 255, 255, 0.65);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.9);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05);
        }
        .text-glow {
            text-shadow: 0 0 30px rgba(234, 88, 12, 0.3);
        }
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(243, 244, 246, 0.5);
            border-radius: 8px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(156, 163, 175, 0.5);
            border-radius: 8px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(156, 163, 175, 0.8);
        }
    </style>

    <!-- Header -->
    <div class="w-full px-8 py-6 flex justify-between items-center z-10">
        <div class="flex flex-col">
            <h1 class="text-3xl font-bold text-gray-800 tracking-wider flex items-center gap-3">
                <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                KLINIKQ
            </h1>
            <p class="text-gray-500 mt-1 font-medium">{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}</p>
        </div>
        <div class="text-2xl font-semibold text-gray-700 bg-white/70 px-6 py-2 rounded-full border border-white shadow-sm">
            <span id="live-clock">{{ \Carbon\Carbon::now()->format('H:i') }}</span>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 w-full px-8 pb-10 grid grid-cols-1 lg:grid-cols-12 gap-8 z-10 min-h-0">
        
        <!-- Active Queue (Left Side) -->
        <div class="lg:col-span-7 h-full flex flex-col">
            <div class="glass-panel rounded-3xl flex-1 flex flex-col items-center justify-center p-12 relative transition-all duration-500 {{ $activeAppointment ? 'ring-4 ring-orange-400/30' : '' }}" style="{{ $activeAppointment ? 'animation: pulse-glow 3s infinite;' : '' }}">
                @if ($activeAppointment)
                    <div class="absolute top-8 bg-orange-100 text-orange-600 px-6 py-2 rounded-full font-bold tracking-widest text-sm uppercase border border-orange-200 shadow-[0_0_15px_rgba(234,88,12,0.15)]">
                        Sedang Dipanggil
                    </div>
                    
                    <div class="text-[12rem] xl:text-[16rem] font-black text-orange-600 leading-none mt-8 text-glow select-none">
                        {{ str_pad($activeAppointment['queue_number'], 3, '0', STR_PAD_LEFT) }}
                    </div>
                    
                    <div class="mt-8 text-center bg-white/60 w-full py-8 rounded-2xl border border-white/80 shadow-sm">
                        <h2 class="text-5xl font-extrabold text-gray-800 mb-3">{{ $activeAppointment['patient_profile']['full_name'] ?? 'N/A' }}</h2>
                        <div class="flex items-center justify-center gap-3 text-2xl text-gray-600 mt-2 font-medium">
                            <svg class="w-7 h-7 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            <span>{{ $activeAppointment['doctor']['name'] ?? 'N/A' }}</span>
                            <span class="mx-2 text-gray-300">•</span>
                            <span class="text-teal-600">{{ $activeAppointment['doctor']['polyclinic']['name'] ?? 'Poli Umum' }}</span>
                        </div>
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center opacity-40">
                        <svg class="w-32 h-32 text-gray-400 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <p class="text-3xl text-gray-500 font-medium tracking-wide">Belum Ada Antrean Aktif</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Next in Line (Right Side) -->
        <div class="lg:col-span-5 h-full flex flex-col">
            <div class="glass-panel rounded-3xl flex-1 p-8 flex flex-col min-h-0">
                <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-3 pb-4 border-b border-gray-200">
                    <svg class="w-6 h-6 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    Antrean Berikutnya
                </h3>

                <div class="flex-1 overflow-y-auto space-y-4 pr-2 custom-scrollbar">
                    @if (count($nextAppointments) > 0)
                        @foreach ($nextAppointments as $index => $appointment)
                            <div class="bg-white/60 rounded-2xl p-5 border border-white/80 shadow-sm flex items-center gap-5 transition-transform hover:-translate-y-1 hover:shadow-md">
                                <div class="bg-white w-16 h-16 rounded-xl flex items-center justify-center text-2xl font-bold text-gray-800 border border-gray-100 shadow-sm">
                                    {{ str_pad($appointment['queue_number'], 3, '0', STR_PAD_LEFT) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xl font-bold text-gray-800 mb-1 truncate">{{ $appointment['patient_profile']['full_name'] ?? 'N/A' }}</p>
                                    <p class="text-sm text-gray-500 font-medium flex items-center gap-2 truncate">
                                        <svg class="w-4 h-4 flex-shrink-0 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        <span class="truncate">{{ $appointment['doctor']['name'] ?? 'N/A' }}</span>
                                    </p>
                                </div>
                                @if($appointment['status'] === 'checked_in' || $appointment['status'] === 'approved')
                                    <div class="text-xs font-bold px-3 py-1 bg-emerald-100 text-emerald-600 rounded-full border border-emerald-200 whitespace-nowrap shadow-sm">Hadir</div>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <div class="h-full flex flex-col items-center justify-center opacity-30">
                            <svg class="w-24 h-24 text-gray-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                            <p class="text-xl text-gray-600 font-medium">Tidak ada antrean tersisa</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Simple script to keep clock ticking without relying on livewire poll for seconds -->
    <script>
        setInterval(() => {
            const now = new Date();
            document.getElementById('live-clock').innerText = now.getHours().toString().padStart(2, '0') + ':' + now.getMinutes().toString().padStart(2, '0');
        }, 10000);
    </script>
</div>