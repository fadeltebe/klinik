<div>
    <div class="mb-6 flex items-center gap-4">
        <a href="{{ route('patient.dashboard') }}" wire:navigate class="w-10 h-10 rounded-full bg-white/80 backdrop-blur flex items-center justify-center border border-mint/20 shadow-sm text-mint-dark hover:bg-mint/10 transition-colors">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-mint-dark">Buat Janji Temu</h1>
            <p class="text-sm text-gray-500">Langkah {{ $step }} dari 6</p>
        </div>
    </div>

    @if (session()->has('error'))
    <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-600 rounded-xl flex items-start gap-3 shadow-sm">
        <i data-lucide="alert-circle" class="w-5 h-5 flex-shrink-0 mt-0.5"></i>
        <span class="text-sm font-medium">{{ session('error') }}</span>
    </div>
    @endif

    @if ($errors->any())
    <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-600 rounded-xl flex items-start gap-3 shadow-sm">
        <i data-lucide="alert-circle" class="w-5 h-5 flex-shrink-0 mt-0.5"></i>
        <div class="text-sm font-medium">
            <p class="font-bold mb-1">Terdapat kesalahan:</p>
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <!-- Progress Bar -->
    <div class="mb-8">
        <div class="flex gap-2 mb-3">
            @for($i = 1; $i <= 6; $i++) <div class="flex-1">
                <div class="h-1.5 bg-gray-200 rounded-full overflow-hidden">
                    <div class="h-full bg-mint transition-all duration-300" style="{{ $step >= $i ? 'width:100%;' : 'width:0%;' }}"></div>
                </div>
        </div>
        @endfor
    </div>
    <div class="flex justify-between text-xs text-gray-500">
        <span>Tanggal</span>
        <span>Poli</span>
        <span>Dokter</span>
        <span>Layanan</span>
        <span>Keluhan</span>
        <span>Konfirmasi</span>
    </div>
</div>

<div class="canva-card bg-white/80 backdrop-blur rounded-2xl shadow-sm border border-white/60 p-6 queue-card">

    <!-- Step 1: Select Date -->
    @if($step == 1)
    <div wire:key="step-1" class="space-y-6">
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-mint/10 text-mint rounded-full flex items-center justify-center mx-auto mb-3">
                <i data-lucide="calendar" class="w-8 h-8"></i>
            </div>
            <h2 class="text-lg font-bold text-gray-800">Pilih Tanggal Berobat</h2>
            <p class="text-sm text-gray-500 mt-1">Pilih hari yang sesuai dengan jadwal Anda</p>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-3">Tanggal Berobat</label>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                @foreach($availableDates as $date)
                <label class="cursor-pointer relative">
                    <input type="radio" wire:model="appointmentDate" value="{{ $date['value'] }}" class="peer sr-only" name="appointmentDate">
                    <div class="rounded-xl border border-gray-200 bg-white p-4 text-center hover:bg-gray-50 peer-checked:border-mint peer-checked:bg-mint/10 peer-checked:ring-2 peer-checked:ring-mint transition-all">
                        <span class="block text-sm font-semibold text-gray-700 peer-checked:text-mint-dark">{{ $date['label'] }}</span>
                    </div>
                </label>
                @endforeach
            </div>
            @error('appointmentDate') <span class="text-xs text-red-500 mt-2 block">{{ $message }}</span> @enderror
        </div>

        <button wire:click="nextStep" class="w-full bg-mint hover:bg-mint-dark text-white font-semibold py-3.5 rounded-xl transition-colors shadow-sm flex items-center justify-center gap-2 mt-8">
            Lanjut
            <i data-lucide="arrow-right" class="w-4 h-4"></i>
        </button>
    </div>

    <!-- Step 2: Select Polyclinic -->
    @elseif($step == 2)
    <div wire:key="step-2" class="space-y-6">
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-mint/10 text-mint rounded-full flex items-center justify-center mx-auto mb-3">
                <i data-lucide="home" class="w-8 h-8"></i>
            </div>
            <h2 class="text-lg font-bold text-gray-800">Pilih Poli Tujuan</h2>
            <p class="text-sm text-gray-500 mt-1">Pilih poli sesuai keluhan Anda</p>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-3">Poli</label>
            <div class="grid grid-cols-2 gap-3">
                @foreach($polyclinics as $poli)
                <label class="cursor-pointer relative">
                    <input type="radio" wire:model="polyclinicId" value="{{ $poli->id }}" class="peer sr-only" name="polyclinicId">
                    <div class="rounded-xl border border-gray-200 bg-white p-4 flex flex-col items-center gap-3 hover:bg-gray-50 peer-checked:border-mint peer-checked:bg-mint/10 peer-checked:ring-2 peer-checked:ring-mint transition-all text-center">
                        <div class="w-10 h-10 rounded-full bg-mint/10 flex items-center justify-center text-mint">
                            <i data-lucide="{{ $poli->icon ?? 'stethoscope' }}" class="w-5 h-5"></i>
                        </div>
                        <span class="block text-sm font-semibold text-gray-700 peer-checked:text-mint-dark">{{ $poli->name }}</span>
                    </div>
                </label>
                @endforeach
            </div>
            @error('polyclinicId') <span class="text-xs text-red-500 mt-2 block">{{ $message }}</span> @enderror
        </div>

        <div class="flex gap-3">
            <button wire:click="previousStep" class="w-1/3 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-semibold py-3.5 rounded-xl transition-colors shadow-sm flex items-center justify-center gap-2">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
            </button>
            <button wire:click="nextStep" class="w-2/3 bg-mint hover:bg-mint-dark text-white font-semibold py-3.5 rounded-xl transition-colors shadow-sm flex items-center justify-center gap-2">
                Lanjut
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </button>
        </div>
    </div>

    <!-- Step 3: Select Doctor -->
    @elseif($step == 3)
    <div wire:key="step-3" class="space-y-6">
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-mint/10 text-mint rounded-full flex items-center justify-center mx-auto mb-3">
                <i data-lucide="user-md" class="w-8 h-8"></i>
            </div>
            <h2 class="text-lg font-bold text-gray-800">Pilih Dokter</h2>
            <p class="text-sm text-gray-500 mt-1">Pilih dokter yang sesuai dengan preferensi Anda</p>
        </div>

        @if($polyclinicId && count($doctors) > 0)
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-3">Dokter</label>
            <div class="space-y-3">
                @foreach($doctors as $doctor)
                <label class="cursor-pointer relative block">
                    <input type="radio" wire:model="doctorId" value="{{ $doctor->id }}" class="peer sr-only" name="doctorId">
                    <div class="rounded-xl border border-gray-200 bg-white p-4 flex items-center gap-4 hover:bg-gray-50 peer-checked:border-mint peer-checked:bg-mint/10 peer-checked:ring-2 peer-checked:ring-mint transition-all">
                        <div class="w-12 h-12 rounded-full bg-gray-100 flex-shrink-0 overflow-hidden border border-gray-200">
                            @if($doctor->photo)
                            <img src="{{ Storage::url($doctor->photo) }}" class="w-full h-full object-cover">
                            @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <i data-lucide="user" class="w-6 h-6"></i>
                            </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <h3 class="text-sm font-bold text-gray-800 peer-checked:text-mint-dark">{{ $doctor->name }}</h3>
                            <p class="text-xs text-gray-500">{{ $doctor->specialization }}</p>
                        </div>
                    </div>
                </label>
                @endforeach
            </div>
            @error('doctorId') <span class="text-xs text-red-500 mt-2 block">{{ $message }}</span> @enderror
        </div>
        @elseif($polyclinicId)
        <div class="p-4 bg-gray-50 rounded-xl text-center border border-gray-200">
            <p class="text-sm text-gray-500">Tidak ada dokter yang tersedia di poli ini.</p>
        </div>
        @endif

        <div class="flex gap-3">
            <button wire:click="previousStep" class="w-1/3 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-semibold py-3.5 rounded-xl transition-colors shadow-sm flex items-center justify-center gap-2">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
            </button>
            <button wire:click="nextStep" class="w-2/3 bg-mint hover:bg-mint-dark text-white font-semibold py-3.5 rounded-xl transition-colors shadow-sm flex items-center justify-center gap-2">
                Lanjut
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </button>
        </div>
    </div>

    <!-- Step 4: Select Service -->
    @elseif($step == 4)
    <div wire:key="step-4-{{ $doctorId }}" class="space-y-6">
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-mint/10 text-mint rounded-full flex items-center justify-center mx-auto mb-3">
                <i data-lucide="clipboard-list" class="w-8 h-8"></i>
            </div>
            <h2 class="text-lg font-bold text-gray-800">Pilih Layanan</h2>
            <p class="text-sm text-gray-500 mt-1">Pilih layanan yang sesuai dengan kebutuhan pemeriksaan Anda</p>
        </div>

        @if($doctorId && count($services) > 0)
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-3">Layanan Dokter</label>
            <div class="space-y-3">
                @foreach($services as $service)
                <label class="cursor-pointer relative block">
                    <input type="radio" wire:model="serviceId" value="{{ $service->id }}" class="peer sr-only" name="serviceId">
                    <div class="rounded-xl border border-gray-200 bg-white p-4 hover:bg-gray-50 peer-checked:border-mint peer-checked:bg-mint/10 peer-checked:ring-2 peer-checked:ring-mint transition-all">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <h3 class="text-sm font-bold text-gray-800 peer-checked:text-mint-dark">{{ $service->name }}</h3>
                                @if($service->description)
                                <p class="text-xs text-gray-500 mt-1">{{ $service->description }}</p>
                                @endif
                            </div>
                            @if($service->estimated_duration_minutes)
                            <span class="text-xs text-mint-dark font-semibold">{{ $service->estimated_duration_minutes }} menit</span>
                            @endif
                        </div>
                    </div>
                </label>
                @endforeach
            </div>
            @error('serviceId') <span class="text-xs text-red-500 mt-2 block">{{ $message }}</span> @enderror
        </div>
        @elseif($doctorId)
        <div class="p-4 bg-gray-50 rounded-xl text-center border border-gray-200">
            <p class="text-sm text-gray-500">Dokter ini belum menambahkan layanan yang tersedia.</p>
        </div>
        @endif

        <div class="flex gap-3">
            <button wire:click="previousStep" class="w-1/3 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-semibold py-3.5 rounded-xl transition-colors shadow-sm flex items-center justify-center gap-2">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
            </button>
            <button wire:click="nextStep" class="w-2/3 bg-mint hover:bg-mint-dark text-white font-semibold py-3.5 rounded-xl transition-colors shadow-sm flex items-center justify-center gap-2">
                Lanjut
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </button>
        </div>
    </div>

    <!-- Step 5: Input Complaint -->
    @elseif($step == 5)
    <div wire:key="step-5" class="space-y-6">
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-mint/10 text-mint rounded-full flex items-center justify-center mx-auto mb-3">
                <i data-lucide="message-circle" class="w-8 h-8"></i>
            </div>
            <h2 class="text-lg font-bold text-gray-800">Jelaskan Keluhan Anda</h2>
            <p class="text-sm text-gray-500 mt-1">Informasi ini membantu dokter mempersiapkan pemeriksaan</p>
        </div>

        <div>
            <label for="complaint" class="block text-sm font-semibold text-gray-700 mb-2">Keluhan</label>
            <textarea id="complaint" wire:model.defer="complaint" placeholder="Jelaskan keluhan Anda secara lengkap (minimal 10 karakter)..." rows="5" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-mint focus:border-transparent resize-none bg-white/50"></textarea>
            <div class="flex justify-between mt-2">
                <p class="text-xs text-gray-500">
                    @if($complaint)
                    {{ strlen($complaint) }} / 500 karakter
                    @else
                    0 / 500 karakter
                    @endif
                </p>
            </div>
            @error('complaint') <span class="text-xs text-red-500 mt-2 block">{{ $message }}</span> @enderror
        </div>

        <div class="flex gap-3">
            <button wire:click="previousStep" class="w-1/3 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-semibold py-3.5 rounded-xl transition-colors shadow-sm flex items-center justify-center gap-2">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
            </button>
            <button wire:click="nextStep" class="w-2/3 bg-mint hover:bg-mint-dark text-white font-semibold py-3.5 rounded-xl transition-colors shadow-sm flex items-center justify-center gap-2">
                Lanjut
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </button>
        </div>
    </div>

    <!-- Step 6: Summary -->
    @elseif($step == 6)
    <div wire:key="step-6" class="space-y-6">
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-mint/10 text-mint rounded-full flex items-center justify-center mx-auto mb-3">
                <i data-lucide="check-circle" class="w-8 h-8"></i>
            </div>
            <h2 class="text-lg font-bold text-gray-800">Ringkasan Janji Temu</h2>
            <p class="text-sm text-gray-500 mt-1">Pastikan semua data sudah benar sebelum mengonfirmasi</p>
        </div>

        <div class="bg-gray-50 rounded-xl p-6 border border-gray-100 space-y-5">
            <!-- Tanggal -->
            <div class="flex items-start justify-between border-b border-gray-200 pb-4">
                <div>
                    <span class="text-xs text-gray-500 font-medium block mb-1">📅 Tanggal Berobat</span>
                    <span class="text-sm font-bold text-gray-800">
                        <!-- DEBUG: {{ var_export($appointmentDate, true) }} -->
                        @if($appointmentDate && preg_match('/^\d{4}-\d{2}-\d{2}$/', $appointmentDate))
                        {{ \Carbon\Carbon::parse($appointmentDate)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                        @else
                        TIDAK VALID: "{{ $appointmentDate }}"
                        @endif
                    </span>
                </div>
            </div>

            <!-- Poli -->
            <div class="flex items-start justify-between border-b border-gray-200 pb-4">
                <div>
                    <span class="text-xs text-gray-500 font-medium block mb-1">🏥 Poli Tujuan</span>
                    <span class="text-sm font-bold text-gray-800">{{ collect($polyclinics)->firstWhere('id', $polyclinicId)?->name }}</span>
                </div>
            </div>

            <!-- Dokter -->
            <div class="flex items-start justify-between border-b border-gray-200 pb-4">
                <div>
                    <span class="text-xs text-gray-500 font-medium block mb-1">👨‍⚕️ Dokter</span>
                    <span class="text-sm font-bold text-mint-dark">{{ collect($doctors)->firstWhere('id', $doctorId)?->name }}</span>
                </div>
            </div>

            <!-- Layanan -->
            <div class="flex items-start justify-between border-b border-gray-200 pb-4">
                <div>
                    <span class="text-xs text-gray-500 font-medium block mb-1">🩺 Layanan</span>
                    <span class="text-sm font-bold text-gray-800">{{ $serviceName ?? '-' }}</span>
                </div>
            </div>

            <!-- Keluhan -->
            <div class="flex items-start justify-between">
                <div class="w-full">
                    <span class="text-xs text-gray-500 font-medium block mb-1">💬 Keluhan</span>
                    <p class="text-sm text-gray-800 bg-white rounded-lg p-3 border border-gray-200">{{ $complaint }}</p>
                </div>
            </div>
        </div>

        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
            <div class="flex gap-3">
                <i data-lucide="info" class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5"></i>
                <p class="text-xs text-blue-700">Janji temu Anda akan diteruskan ke dokter. Silakan tunggu konfirmasi dari pihak klinik.</p>
            </div>
        </div>

        <div class="flex gap-3">
            <button wire:click="previousStep" class="w-1/3 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-semibold py-3.5 rounded-xl transition-colors shadow-sm flex items-center justify-center gap-2">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                Ubah
            </button>
            <button wire:click="submit" class="w-2/3 bg-mint hover:bg-mint-dark text-white font-semibold py-3.5 rounded-xl transition-colors shadow-sm flex items-center justify-center gap-2">
                <i data-lucide="check" class="w-5 h-5"></i>
                Konfirmasi & Buat Janji
            </button>
        </div>
    </div>
    @endif

</div>
</div>