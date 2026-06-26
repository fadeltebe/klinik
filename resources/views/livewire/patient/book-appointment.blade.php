<div>
    <div class="mb-6 flex items-center gap-4">
        <a href="{{ route('patient.dashboard') }}" wire:navigate class="w-10 h-10 rounded-full bg-white/80 backdrop-blur flex items-center justify-center border border-mint/20 shadow-sm text-mint-dark hover:bg-mint/10 transition-colors">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-mint-dark">Buat Janji Temu</h1>
            <p class="text-sm text-gray-500">Isi formulir untuk mengambil antrean</p>
        </div>
    </div>

    @if (session()->has('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-600 rounded-xl flex items-start gap-3 shadow-sm">
            <i data-lucide="alert-circle" class="w-5 h-5 flex-shrink-0 mt-0.5"></i>
            <span class="text-sm font-medium">{{ session('error') }}</span>
        </div>
    @endif

    <div class="canva-card bg-white/80 backdrop-blur rounded-2xl shadow-sm border border-white/60 p-6 queue-card">
        @if($step == 1)
            <div class="space-y-6">
                <!-- Select Date -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Tanggal Berobat</label>
                    <div class="grid grid-cols-3 sm:grid-cols-4 gap-3">
                        @foreach($availableDates as $date)
                            <label class="cursor-pointer relative">
                                <input type="radio" wire:model="appointmentDate" value="{{ $date['value'] }}" class="peer sr-only" name="appointmentDate">
                                <div class="rounded-xl border border-gray-200 bg-white p-3 text-center hover:bg-gray-50 peer-checked:border-mint peer-checked:bg-mint/10 peer-checked:ring-1 peer-checked:ring-mint transition-all">
                                    <span class="block text-xs font-semibold text-gray-700 peer-checked:text-mint-dark">{{ explode(',', $date['label'])[0] }}</span>
                                    <span class="block text-[10px] text-gray-500 mt-1">{{ isset(explode(',', $date['label'])[1]) ? trim(explode(',', $date['label'])[1]) : '' }}</span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    @error('appointmentDate') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Select Polyclinic -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Poli Tujuan</label>
                    <div class="grid grid-cols-2 gap-3">
                        @foreach($polyclinics as $poli)
                            <label class="cursor-pointer relative">
                                <input type="radio" wire:model.live="polyclinicId" value="{{ $poli->id }}" class="peer sr-only" name="polyclinicId">
                                <div class="rounded-xl border border-gray-200 bg-white p-3 flex flex-col items-center gap-2 hover:bg-gray-50 peer-checked:border-mint peer-checked:bg-mint/10 peer-checked:ring-1 peer-checked:ring-mint transition-all text-center">
                                    <div class="w-10 h-10 rounded-full bg-mint/10 flex items-center justify-center text-mint">
                                        <i data-lucide="{{ $poli->icon ?? 'stethoscope' }}" class="w-5 h-5"></i>
                                    </div>
                                    <span class="block text-xs font-semibold text-gray-700 peer-checked:text-mint-dark">{{ $poli->name }}</span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    @error('polyclinicId') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Select Doctor -->
                @if($polyclinicId && count($doctors) > 0)
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Dokter</label>
                    <div class="space-y-3">
                        @foreach($doctors as $doctor)
                            <label class="cursor-pointer relative block">
                                <input type="radio" wire:model="doctorId" value="{{ $doctor->id }}" class="peer sr-only" name="doctorId">
                                <div class="rounded-xl border border-gray-200 bg-white p-4 flex items-center gap-4 hover:bg-gray-50 peer-checked:border-mint peer-checked:bg-mint/10 peer-checked:ring-1 peer-checked:ring-mint transition-all">
                                    <div class="w-12 h-12 rounded-full bg-gray-100 flex-shrink-0 overflow-hidden border border-gray-200">
                                        @if($doctor->photo)
                                            <img src="{{ Storage::url($doctor->photo) }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                <i data-lucide="user" class="w-6 h-6"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-bold text-gray-800 peer-checked:text-mint-dark">{{ $doctor->name }}</h3>
                                        <p class="text-xs text-gray-500">{{ $doctor->specialization }}</p>
                                    </div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    @error('doctorId') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>
                @elseif($polyclinicId)
                <div class="p-4 bg-gray-50 rounded-xl text-center border border-gray-200">
                    <p class="text-sm text-gray-500">Tidak ada dokter yang tersedia di poli ini.</p>
                </div>
                @endif

                <button wire:click="nextStep" class="w-full bg-mint hover:bg-mint-dark text-white font-semibold py-3.5 rounded-xl transition-colors shadow-sm flex items-center justify-center gap-2 mt-6">
                    Lanjut
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </button>
            </div>
        @elseif($step == 2)
            <div class="space-y-6">
                <div class="text-center mb-6">
                    <div class="w-16 h-16 bg-mint/10 text-mint rounded-full flex items-center justify-center mx-auto mb-3">
                        <i data-lucide="check-circle" class="w-8 h-8"></i>
                    </div>
                    <h2 class="text-lg font-bold text-gray-800">Konfirmasi Janji Temu</h2>
                    <p class="text-sm text-gray-500">Periksa kembali data pendaftaran Anda</p>
                </div>

                <div class="bg-gray-50 rounded-xl p-5 border border-gray-100 space-y-4">
                    <div class="flex justify-between items-center border-b border-gray-200 pb-3">
                        <span class="text-xs text-gray-500 font-medium">Tanggal</span>
                        <span class="text-sm font-bold text-gray-800">{{ \Carbon\Carbon::parse($appointmentDate)->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center border-b border-gray-200 pb-3">
                        <span class="text-xs text-gray-500 font-medium">Poli Tujuan</span>
                        <span class="text-sm font-bold text-gray-800">{{ collect($polyclinics)->firstWhere('id', $polyclinicId)?->name }}</span>
                    </div>
                    <div class="flex justify-between items-center pb-1">
                        <span class="text-xs text-gray-500 font-medium">Dokter</span>
                        <span class="text-sm font-bold text-mint-dark text-right">{{ collect($doctors)->firstWhere('id', $doctorId)?->name }}</span>
                    </div>
                </div>

                <div class="flex gap-3 mt-6">
                    <button wire:click="$set('step', 1)" class="w-1/3 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-semibold py-3.5 rounded-xl transition-colors shadow-sm">
                        Kembali
                    </button>
                    <button wire:click="submit" class="w-2/3 bg-mint hover:bg-mint-dark text-white font-semibold py-3.5 rounded-xl transition-colors shadow-sm flex items-center justify-center gap-2">
                        <i data-lucide="check" class="w-5 h-5"></i>
                        Konfirmasi
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>
