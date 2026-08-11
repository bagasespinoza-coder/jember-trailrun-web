<section id="register-flow" class="bg-[#000C28] px-4 py-8 lg:px-8">
    <div class="mx-auto max-w-[900px]">
        <div class="max-w-xl">
            <h2 class="mt-2 text-xl font-bold uppercase tracking-[-0.03em] text-[#E2E2E2] sm:text-2xl">
                Registration <span class="text-[#FD4801]">Flow</span>
            </h2>
            <!-- Garis pemisah oranye kecil di bawah judul -->
            <div class="mt-2.5 h-0.5 w-8 rounded-full bg-[#FD4801]"></div>
        </div>

        @php
            $steps = [
                ['1', 'Choose Category', 'Select 10K Trail Race or 10K City Run based on your available distance.'],
                ['2', 'Fill Information', 'Complete your personal data, jersey size, and emergency contact details.'],
                ['3', 'Secure Payment', 'Pay via QRIS Only. Process Payment.'],
                ['4', 'Confirmation', 'Pending admin review. Once confirmed, you will receive an email notification.'],
                ['5', 'Successfully', 'Ready to run']
            ];
        @endphp

<!-- DESKTOP: HORIZONTAL TIMELINE -->
        <div class="hidden lg:block mt-8 relative">
            <!-- Garis Penghubung Horizontal -->
            <div class="absolute top-4 left-8 right-8 h-[2px] bg-white/20 -z-0"></div>

            <div class="grid grid-cols-5 gap-4 relative z-10">
                @foreach ($steps as $index => $step)
                    <div class="flex flex-col items-start">
                        <!-- Nomor Step / Icon -->
                        <div class="flex h-8 w-8 items-center justify-center rounded-xl text-xs font-bold shadow-md {{ $index === 0 ? 'bg-[#FD4801] text-white shadow-[#FD4801]/30' : 'bg-blue-600 text-white shadow-blue-600/30' }}">
                            {{ $step[0] }}
                        </div>
                        
                        <!-- Teks Konten -->
                        <h3 class="mt-3 text-xs font-bold text-white">{{ $step[1] }}</h3>
                        <p class="mt-1 text-[11px] leading-4 text-white/70">{{ $step[2] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- MOBILE: VERTICAL TIMELINE -->
        <div class="lg:hidden mt-6 relative pl-2 space-y-6">
            <!-- Garis Penghubung Vertikal -->
            <div class="absolute top-2 bottom-2 left-[19px] w-[2px] bg-white/20"></div>

            @foreach ($steps as $index => $step)
                <div class="relative flex items-start space-x-4">
                    <!-- Nomor Step / Icon (Absolute Positioning untuk menimpa garis) -->
                    <div class="relative z-10 flex h-7 w-7 shrink-0 items-center justify-center rounded-lg text-xs font-bold shadow-md {{ $index === 0 ? 'bg-[#FD4801] text-white shadow-[#FD4801]/30' : 'bg-blue-600 text-white shadow-blue-600/30' }}">
                        {{ $step[0] }}
                    </div>

                    <!-- Teks Konten -->
                    <div>
                        <h3 class="text-xs font-bold text-white">{{ $step[1] }}</h3>
                        <p class="mt-0.5 text-[11px] leading-4 text-white/70">{{ $step[2] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>