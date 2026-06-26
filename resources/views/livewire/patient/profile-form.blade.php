<div class="pb-6">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('patient.profiles.index') }}" class="p-2 rounded-full hover:bg-gray-100 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <h1 class="text-xl font-bold text-text-primary">{{ $isEdit ? 'Edit Profil' : 'Tambah Profil Baru' }}</h1>
    </div>

    <form wire:submit="save" class="space-y-4">
        <div>
            <label for="full_name" class="block text-sm font-medium text-text-secondary mb-1">Nama Lengkap</label>
            <input wire:model="full_name" type="text" id="full_name" class="w-full px-3 py-2 bg-white border-2 border-orange-400 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 focus:outline-none transition-colors">
            @error('full_name') <span class="text-danger text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="nik" class="block text-sm font-medium text-text-secondary mb-1">NIK (16 Digit)</label>
            <input wire:model="nik" type="text" id="nik" class="w-full px-3 py-2 bg-white border-2 border-orange-400 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 focus:outline-none transition-colors">
            @error('nik') <span class="text-danger text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="date_of_birth" class="block text-sm font-medium text-text-secondary mb-1">Tanggal Lahir</label>
                <input wire:model="date_of_birth" type="date" id="date_of_birth" class="w-full px-3 py-2 bg-white border-2 border-orange-400 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 focus:outline-none transition-colors">
                @error('date_of_birth') <span class="text-danger text-xs mt-1">{{ $message }}</span> @enderror
            </div>
            <div>
                <label for="gender" class="block text-sm font-medium text-text-secondary mb-1">Jenis Kelamin</label>
                <select wire:model="gender" id="gender" class="w-full px-3 py-2 border-2 border-orange-400 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 focus:outline-none transition-colors bg-white">
                    <option value="">Pilih...</option>
                    <option value="male">Laki-laki</option>
                    <option value="female">Perempuan</option>
                </select>
                @error('gender') <span class="text-danger text-xs mt-1">{{ $message }}</span> @enderror
            </div>
        </div>

        <div>
            <label for="blood_type" class="block text-sm font-medium text-text-secondary mb-1">Golongan Darah</label>
            <select wire:model="blood_type" id="blood_type" class="w-full px-3 py-2 border-2 border-orange-400 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 focus:outline-none transition-colors bg-white">
                <option value="">Tidak Diketahui</option>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="AB">AB</option>
                <option value="O">O</option>
            </select>
            @error('blood_type') <span class="text-danger text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="phone" class="block text-sm font-medium text-text-secondary mb-1">No. Telepon (Opsional)</label>
            <input wire:model="phone" type="text" id="phone" placeholder="08xxxxxxxxxx" class="w-full px-3 py-2 bg-white border-2 border-orange-400 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 focus:outline-none transition-colors">
            @error('phone') <span class="text-danger text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="address" class="block text-sm font-medium text-text-secondary mb-1">Alamat (Opsional)</label>
            <textarea wire:model="address" id="address" rows="2" class="w-full px-3 py-2 bg-white border-2 border-orange-400 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 focus:outline-none transition-colors"></textarea>
            @error('address') <span class="text-danger text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="allergies" class="block text-sm font-medium text-text-secondary mb-1">Alergi Obat/Makanan (Opsional)</label>
            <textarea wire:model="allergies" id="allergies" rows="2" class="w-full px-3 py-2 bg-white border-2 border-orange-400 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500 focus:outline-none transition-colors"></textarea>
            @error('allergies') <span class="text-danger text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-white font-medium py-3 rounded-lg transition-colors mt-6">
            Simpan Profil
        </button>
    </form>
</div>