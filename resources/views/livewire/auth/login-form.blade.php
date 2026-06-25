<div>
    <form wire:submit="login" class="space-y-6">
        <div>
            <label for="email_or_phone" class="block text-sm font-medium text-text-primary">Email atau Nomor Telepon</label>
            <div class="mt-1">
                <input wire:model="email_or_phone" id="email_or_phone" type="text" required autofocus
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
            </div>
            @error('email_or_phone') <span class="text-sm text-danger mt-1">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-text-primary">Password</label>
            <div class="mt-1">
                <input wire:model="password" id="password" type="password" required
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
            </div>
            @error('password') <span class="text-sm text-danger mt-1">{{ $message }}</span> @enderror
        </div>

        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <input wire:model="remember" id="remember" type="checkbox" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                <label for="remember" class="ml-2 block text-sm text-text-secondary">
                    Ingat saya
                </label>
            </div>
        </div>

        <div>
            <button type="submit"
                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-gray-900 bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                Masuk
            </button>
        </div>
    </form>

    <div class="mt-6 text-center text-sm text-text-secondary">
        Belum punya akun? 
        <a href="{{ route('register') }}" class="font-medium text-primary-dark hover:text-primary">
            Daftar Sekarang
        </a>
    </div>
</div>
