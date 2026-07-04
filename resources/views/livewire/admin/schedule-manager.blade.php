<div>
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-mint-dark">Jadwal Dokter</h1>
            <p class="text-sm text-gray-500">Kelola jadwal praktik dan kuota dokter</p>
        </div>
    </div>

    @if (session()->has('success'))
    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl flex items-start gap-3 shadow-sm">
        <i data-lucide="check-circle" class="w-5 h-5 flex-shrink-0 mt-0.5"></i>
        <span class="text-sm font-medium">{{ session('success') }}</span>
    </div>
    @endif

    @if (session()->has('error'))
    <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-600 rounded-xl flex items-start gap-3 shadow-sm">
        <i data-lucide="alert-circle" class="w-5 h-5 flex-shrink-0 mt-0.5"></i>
        <span class="text-sm font-medium">{{ session('error') }}</span>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Form Tambah Jadwal -->
        <div class="lg:col-span-1">
            <div class="canva-card rounded-2xl p-6 shadow-sm border border-white/60 bg-white/80 backdrop-blur sticky top-24">
                <h2 class="font-bold text-lg mb-4 text-gray-800 flex items-center gap-2">
                    <i data-lucide="calendar-plus" class="w-5 h-5 text-mint-dark"></i>
                    Tambah Jadwal Baru
                </h2>

                <form wire:submit.prevent="saveSchedule" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Dokter</label>
                        <input type="text" disabled value="{{ $doctors->first()->name }}" class="w-full bg-gray-50 rounded-xl border-gray-200 shadow-sm text-sm text-gray-500 cursor-not-allowed">
                        <input type="hidden" wire:model="formDoctorId">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                        <input type="date" wire:model="schedule_date" class="w-full rounded-xl border-gray-200 shadow-sm focus:border-mint focus:ring focus:ring-mint focus:ring-opacity-50 text-sm">
                        @error('schedule_date') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jam Mulai</label>
                            <input type="time" wire:model="start_time" class="w-full rounded-xl border-gray-200 shadow-sm focus:border-mint focus:ring focus:ring-mint focus:ring-opacity-50 text-sm">
                            @error('start_time') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jam Selesai</label>
                            <input type="time" wire:model="end_time" class="w-full rounded-xl border-gray-200 shadow-sm focus:border-mint focus:ring focus:ring-mint focus:ring-opacity-50 text-sm">
                            @error('end_time') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kuota Pasien</label>
                            <input type="number" wire:model="quota" min="1" class="w-full rounded-xl border-gray-200 shadow-sm focus:border-mint focus:ring focus:ring-mint focus:ring-opacity-50 text-sm">
                            @error('quota') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Interval (Menit)</label>
                            <input type="number" wire:model="interval_minutes" min="5" step="5" class="w-full rounded-xl border-gray-200 shadow-sm focus:border-mint focus:ring focus:ring-mint focus:ring-opacity-50 text-sm">
                            @error('interval_minutes') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full bg-mint hover:bg-mint-dark text-white font-semibold py-2.5 rounded-xl transition-colors flex items-center justify-center gap-2 shadow-sm">
                            <i data-lucide="save" class="w-4 h-4"></i>
                            Simpan Jadwal
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Daftar Jadwal -->
        <div class="lg:col-span-2">
            <div class="canva-card rounded-2xl p-6 shadow-sm border border-white/60 bg-white/80 backdrop-blur">
                <h2 class="font-bold text-lg mb-4 text-gray-800">Jadwal Mendatang</h2>
                
                @if(!$selectedDoctorId)
                    <div class="text-center py-8">
                        <p class="text-gray-500">Pilih dokter untuk melihat jadwal.</p>
                    </div>
                @elseif(count($schedules) === 0)
                    <div class="text-center py-10 border-2 border-dashed border-gray-200 rounded-xl">
                        <div class="w-12 h-12 bg-gray-50 text-gray-400 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i data-lucide="calendar-x" class="w-6 h-6"></i>
                        </div>
                        <p class="text-gray-500 font-medium">Tidak ada jadwal mendatang untuk dokter ini.</p>
                        <p class="text-sm text-gray-400 mt-1">Gunakan formulir di samping untuk menambahkan jadwal.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="text-xs text-gray-500 uppercase bg-gray-50/50 rounded-t-lg">
                                <tr>
                                    <th class="px-4 py-3 font-semibold rounded-tl-lg">Tanggal</th>
                                    <th class="px-4 py-3 font-semibold">Waktu Praktik</th>
                                    <th class="px-4 py-3 font-semibold text-center">Kuota</th>
                                    <th class="px-4 py-3 font-semibold rounded-tr-lg text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($schedules as $schedule)
                                @php
                                    $date = \Carbon\Carbon::parse($schedule->schedule_date);
                                    $isToday = $date->isToday();
                                @endphp
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-4 py-3">
                                        <div class="font-medium {{ $isToday ? 'text-mint-dark' : 'text-gray-800' }}">
                                            {{ $isToday ? 'Hari Ini' : $date->isoFormat('dddd, D MMM Y') }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-2 text-gray-600">
                                            <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                                            {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - 
                                            {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="bg-mint/10 text-mint-dark px-2 py-1 rounded text-xs font-bold">
                                            {{ $schedule->quota }} Pasien
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <button wire:click="deleteSchedule({{ $schedule->id }})" wire:confirm="Apakah Anda yakin ingin menghapus jadwal ini?" class="text-red-500 hover:text-red-700 hover:bg-red-50 p-1.5 rounded-lg transition-colors inline-flex" title="Hapus Jadwal">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
