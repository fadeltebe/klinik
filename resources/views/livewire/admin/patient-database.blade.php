<div>
    <div class="mb-6 flex flex-col gap-3 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Database Pasien</h1>
            <p class="text-sm text-gray-500 mt-1">Semua data diri pasien yang telah mendaftar dan menyimpan profil.</p>
        </div>

        <div class="w-full lg:w-80">
            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari pasien</label>
            <input wire:model.live.debounce.300ms="search" id="search" type="text" placeholder="Nama, NIK, atau telepon" class="w-full px-3 py-2 border border-gray-200 rounded-xl shadow-sm focus:border-mint-dark focus:ring-mint-dark focus:outline-none">
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Nama</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">NIK</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Kontak</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Jenis Kelamin</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Tanggal Lahir</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse($patients as $patient)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">
                            <div class="font-semibold text-gray-800">{{ $patient->full_name }}</div>
                            <div class="text-xs text-gray-500">{{ $patient->user->email ?? '-' }}</div>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $patient->nik }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">
                            <div>{{ $patient->phone ?? '-' }}</div>
                            <div class="text-xs text-gray-500">{{ $patient->address ?? '-' }}</div>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $patient->gender_label }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ \Carbon\Carbon::parse($patient->date_of_birth)->translatedFormat('d M Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-10 text-center text-sm text-gray-500">
                            Belum ada data pasien yang tersimpan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>