<div>
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-mint-dark">Halo, {{ $activeProfile ? $activeProfile->full_name : auth()->user()->name }}</h1>
            <p class="text-sm text-gray-500">Selamat datang di KlinikQ</p>
        </div>
        <div class="flex items-center gap-3">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-10 h-10 rounded-full bg-white/80 backdrop-blur flex items-center justify-center border border-red-100 shadow-sm text-urgency hover:bg-red-50 transition-colors" title="Logout">
                    <i data-lucide="log-out" class="w-5 h-5"></i>
                </button>
            </form>
            <div class="h-10 w-10 bg-mint/20 rounded-full flex items-center justify-center text-mint-dark font-bold shadow-sm cursor-pointer" onclick="window.location.href='{{ route('patient.profiles.index') }}'" title="Ganti Profil">
                {{ substr($activeProfile ? $activeProfile->full_name : auth()->user()->name, 0, 1) }}
            </div>
        </div>
    </div>

    <div class="canva-card bg-white/80 backdrop-blur rounded-2xl shadow-sm border border-white/60 p-5 mb-6 queue-card">
        <h2 class="font-bold text-lg mb-2 text-gray-800">Daftar Periksa</h2>
        <p class="text-sm text-gray-500 mb-4">Buat janji temu dengan dokter spesialis kami untuk Anda atau keluarga.</p>
        <!-- The button will route to the booking page which we will create shortly -->
        <a href="{{ route('patient.book-appointment') }}" wire:navigate class="w-full bg-mint hover:bg-mint-dark text-white font-semibold py-3 rounded-xl transition-colors flex items-center justify-center gap-2 shadow-sm block text-center">
            <i data-lucide="calendar-plus" class="w-5 h-5"></i>
            Buat Janji Temu
        </a>
    </div>

    @if(count($upcomingAppointments) > 0)
        @foreach($upcomingAppointments as $appt)
            <div class="canva-card bg-gradient-to-br from-orange-50 to-white border border-orange-100/60 rounded-2xl p-5 mb-6 queue-card shadow-sm">
                <div class="flex items-center gap-3 mb-3">
                    <span class="bg-urgency/10 text-urgency text-[10px] font-bold px-2.5 py-1 rounded-lg uppercase tracking-wide">
                        {{ $appt->status === 'pending' ? 'Menunggu Konfirmasi' : ucfirst($appt->status) }}
                    </span>
                    <span class="font-semibold text-sm text-gray-800">{{ $appt->doctor->name }}</span>
                </div>
                <div class="flex justify-between items-end">
                    <div>
                        <p class="text-xs text-gray-500 font-medium">Poli: {{ $appt->doctor->polyclinic->name ?? '-' }}</p>
                        <p class="text-xs text-gray-500 font-medium mt-0.5">Jadwal: {{ \Carbon\Carbon::parse($appt->appointment_date)->format('d M Y') }}</p>
                    </div>
                    <div class="text-center">
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-1">Antrian</p>
                        <p class="text-4xl font-bold text-urgency leading-none">{{ $appt->queue_number ?? '-' }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="text-center py-10 bg-white/50 backdrop-blur rounded-2xl border border-white/60 shadow-sm">
            <div class="w-16 h-16 bg-mint/10 text-mint rounded-full flex items-center justify-center mx-auto mb-3">
                <i data-lucide="calendar" class="w-8 h-8"></i>
            </div>
            <p class="text-gray-500 font-medium">Belum ada janji temu aktif.</p>
        </div>
    @endif
</div>
