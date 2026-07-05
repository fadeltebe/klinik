<div>
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-mint-dark">Layanan Dokter</h1>
            <p class="text-sm text-gray-500">Kelola layanan yang dapat dipilih pasien saat booking.</p>
        </div>
    </div>

    @if (session()->has('success'))
    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl flex items-start gap-3 shadow-sm">
        <i data-lucide="check-circle" class="w-5 h-5 flex-shrink-0 mt-0.5"></i>
        <span class="text-sm font-medium">{{ session('success') }}</span>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1">
            <div class="canva-card rounded-2xl p-6 shadow-sm border border-white/60 bg-white/80 backdrop-blur sticky top-24">
                <h2 class="font-bold text-lg mb-4 text-gray-800">Tambah / Ubah Layanan</h2>

                <form wire:submit.prevent="saveService" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Layanan</label>
                        <input type="text" wire:model="name" class="w-full rounded-xl border-gray-200 shadow-sm focus:border-mint focus:ring focus:ring-mint focus:ring-opacity-50 text-sm" placeholder="Contoh: Tambal Gigi">
                        @error('name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <textarea wire:model="description" rows="3" class="w-full rounded-xl border-gray-200 shadow-sm focus:border-mint focus:ring focus:ring-mint focus:ring-opacity-50 text-sm" placeholder="Optional: detail tindakan..."></textarea>
                        @error('description') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Durasi (menit)</label>
                            <input type="number" wire:model="estimated_duration_minutes" min="1" class="w-full rounded-xl border-gray-200 shadow-sm focus:border-mint focus:ring focus:ring-mint focus:ring-opacity-50 text-sm">
                            @error('estimated_duration_minutes') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Harga</label>
                            <input type="number" wire:model="price" min="0" step="0.01" class="w-full rounded-xl border-gray-200 shadow-sm focus:border-mint focus:ring focus:ring-mint focus:ring-opacity-50 text-sm" placeholder="Optional">
                            @error('price') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <input type="checkbox" wire:model="is_active" id="is_active" class="rounded border-gray-300 text-mint focus:ring-mint">
                        <label for="is_active" class="text-sm text-gray-700">Aktifkan layanan</label>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full bg-mint hover:bg-mint-dark text-white font-semibold py-2.5 rounded-xl transition-colors flex items-center justify-center gap-2 shadow-sm">
                            <i data-lucide="save" class="w-4 h-4"></i>
                            {{ $serviceId ? 'Perbarui Layanan' : 'Simpan Layanan' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="canva-card rounded-2xl p-6 shadow-sm border border-white/60 bg-white/80 backdrop-blur">
                <h2 class="font-bold text-lg mb-4 text-gray-800">Daftar Layanan</h2>

                @if($services->isEmpty())
                <div class="text-center py-8">
                    <p class="text-gray-500">Belum ada layanan yang ditambahkan untuk dokter ini.</p>
                </div>
                @else
                <div class="space-y-4">
                    @foreach($services as $service)
                    <div class="p-4 rounded-2xl border border-gray-100 bg-white shadow-sm flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h3 class="font-bold text-gray-800">{{ $service->name }}</h3>
                            <p class="text-sm text-gray-500 mt-1">{{ $service->description ?? '-' }}</p>
                            <div class="mt-2 text-xs text-gray-500 flex flex-wrap gap-2">
                                @if($service->estimated_duration_minutes)
                                <span>Durasi: {{ $service->estimated_duration_minutes }} menit</span>
                                @endif
                                @if($service->price)
                                <span>Harga: Rp {{ number_format($service->price, 0, ',', '.') }}</span>
                                @endif
                                <span>Status: {{ $service->is_active ? 'Aktif' : 'Non-aktif' }}</span>
                            </div>
                        </div>
                        <div class="flex gap-2 items-center">
                            <button wire:click="editService({{ $service->id }})" class="px-4 py-2 rounded-xl bg-mint/10 text-mint font-semibold hover:bg-mint/20">Edit</button>
                            <button wire:click="deleteService({{ $service->id }})" class="px-4 py-2 rounded-xl bg-red-50 text-red-600 font-semibold hover:bg-red-100">Hapus</button>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</div>