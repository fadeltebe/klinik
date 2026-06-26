<div class="min-h-[80vh] flex flex-col justify-center items-center py-10 relative">
    <!-- Decorative background elements -->
    <div class="absolute top-10 left-10 w-32 h-32 bg-mint/20 rounded-full blur-3xl -z-10"></div>
    <div class="absolute bottom-10 right-10 w-40 h-40 bg-teal-300/20 rounded-full blur-3xl -z-10"></div>

    <div class="text-center mb-10">
        <h1 class="text-3xl font-bold text-mint-dark tracking-tight">Siapa yang akan diperiksa?</h1>
        <p class="text-gray-500 mt-2 font-medium">Pilih atau tambah profil anggota keluarga</p>
    </div>

    <div class="grid grid-cols-2 gap-8 max-w-md w-full px-4">
        @foreach($profiles as $index => $profile)
            @php
                // Use a soft, elegant gradient palette
                $colors = ['from-teal-400 to-emerald-500', 'from-blue-400 to-indigo-500', 'from-purple-400 to-fuchsia-500', 'from-orange-400 to-rose-500', 'from-cyan-400 to-blue-500'];
                $color = $colors[$index % count($colors)];
            @endphp
            <button wire:click="selectProfile({{ $profile->id }})" class="flex flex-col items-center gap-4 group transition-all duration-300 hover:-translate-y-2">
                <div class="w-28 h-28 rounded-3xl bg-gradient-to-br {{ $color }} text-white flex items-center justify-center text-4xl font-bold shadow-lg shadow-gray-200/50 group-hover:shadow-xl group-hover:shadow-mint/20 relative overflow-hidden">
                    <div class="absolute inset-0 bg-white/20 backdrop-blur-sm opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <span class="relative z-10 drop-shadow-md">{{ strtoupper(substr($profile->full_name, 0, 1)) }}</span>
                </div>
                <span class="font-semibold text-gray-700 group-hover:text-mint-dark transition-colors">{{ $profile->full_name }}</span>
            </button>
        @endforeach

        <a href="{{ route('patient.profiles.create') }}" class="flex flex-col items-center gap-4 group transition-all duration-300 hover:-translate-y-2">
            <div class="w-28 h-28 rounded-3xl border-2 border-dashed border-mint/40 bg-mint/5 flex items-center justify-center text-mint group-hover:bg-mint group-hover:border-mint group-hover:text-white transition-all shadow-sm">
                <i data-lucide="plus" class="w-10 h-10"></i>
            </div>
            <span class="font-semibold text-gray-500 group-hover:text-mint-dark transition-colors">Tambah Baru</span>
        </a>
    </div>
</div>
