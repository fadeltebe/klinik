<div>
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Daftar Dokter</h1>
            <p class="text-sm text-gray-500 mt-1">Pilih dokter untuk mengelola jadwal praktik.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($doctors as $doctor)
        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 bg-mint/20 text-mint-dark rounded-full flex items-center justify-center font-bold text-lg">
                    {{ substr($doctor->name, 0, 1) }}
                </div>
                <div>
                    <h3 class="font-bold text-gray-800">{{ $doctor->name }}</h3>
                    <p class="text-sm text-gray-500">{{ $doctor->specialization }}</p>
                </div>
            </div>

            <div class="flex justify-between items-center pt-4 border-t border-gray-50">
                <span class="text-sm text-gray-600 bg-gray-50 px-3 py-1 rounded-full">
                    Poli: {{ $doctor->polyclinic->name ?? 'Umum' }}
                </span>
                <div class="flex flex-col sm:flex-row sm:items-center sm:gap-2">
                    <a wire:navigate href="{{ route('admin.doctors.schedule', ['doctor' => $doctor->id]) }}" class="text-sm text-mint-dark font-medium hover:underline flex items-center gap-1">
                        Atur Jadwal
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                    <a wire:navigate href="{{ route('admin.doctors.services', ['doctor' => $doctor->id]) }}" class="text-sm text-mint-dark font-medium hover:underline flex items-center gap-1">
                        Kelola Layanan
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>
        </div>
        @endforeach

        @if($doctors->isEmpty())
        <div class="col-span-full py-12 text-center text-gray-500 bg-white rounded-2xl border border-gray-100">
            <i data-lucide="user-x" class="w-12 h-12 mx-auto mb-3 text-gray-400"></i>
            <p>Tidak ada dokter yang tersedia atau Anda tidak memiliki akses.</p>
        </div>
        @endif
    </div>
</div>