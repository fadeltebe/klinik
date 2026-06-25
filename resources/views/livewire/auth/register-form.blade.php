<div>
    <form wire:submit="register" class="space-y-6">
        <div>
            <label for="name" class="block text-sm font-medium text-text-primary">Nama Lengkap</label>
            <div class="mt-1">
                <input wire:model="name" id="name" type="text" required autofocus
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
            </div>
            @error('name') <span class="text-sm text-danger mt-1">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-text-primary">Email</label>
            <div class="mt-1">
                <input wire:model="email" id="email" type="email" required
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
            </div>
            @error('email') <span class="text-sm text-danger mt-1">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="phone" class="block text-sm font-medium text-text-primary">No. Telepon (Awali dengan 08...)</label>
            <div class="mt-1">
                <input wire:model="phone" id="phone" type="text" required
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
            </div>
            @error('phone') <span class="text-sm text-danger mt-1">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-text-primary">Password</label>
            <div class="mt-1">
                <input wire:model="password" id="password" type="password" required
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
            </div>
            @error('password') <span class="text-sm text-danger mt-1">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-text-primary">Konfirmasi Password</label>
            <div class="mt-1">
                <input wire:model="password_confirmation" id="password_confirmation" type="password" required
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
            </div>
        </div>

        <div>
            <button type="submit"
                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-gray-900 bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                Daftar Akun
            </button>
        </div>
    </form>

    <div class="mt-6 text-center text-sm text-text-secondary">
        Sudah punya akun? 
        <a href="{{ route('login') }}" class="font-medium text-primary-dark hover:text-primary">
            Masuk di sini
        </a>
    </div>
</div>
