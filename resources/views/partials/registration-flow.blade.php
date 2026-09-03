<section id="register-flow" class="bg-[#000C28] px-4 py-8 lg:px-8">
    <div class="mx-auto max-w-[900px]">
        <div class="max-w-xl">
            <h2 class="mt-2 text-xl font-bold uppercase tracking-[-0.03em] text-[#E2E2E2] sm:text-2xl lg:text-3xl">
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
        <div class="hidden lg:block mt-10 relative">
            <div class="grid grid-cols-5 gap-4 relative z-10">
                @foreach ($steps as $index => $step)
                    <div class="relative flex flex-col items-center text-center">
                        
                        <!-- Garis Penghubung (Presisi Tengah Lingkaran) -->
                        @if ($index < count($steps) - 1)
                            <div class="absolute top-[15px] left-1/2 w-full h-[2px] bg-white/20 z-0"></div>
                        @endif

                        <!-- Nomor Step / Icon -->
                        <div class="relative z-10 flex h-8 w-8 items-center justify-center rounded-xl text-xs font-bold shadow-md {{ $index === 0 ? 'bg-[#FD4801] text-white shadow-[#FD4801]/30' : 'bg-blue-600 text-white shadow-blue-600/30' }}">
                            {{ $step[0] }}
                        </div>
                        
                        <!-- Teks Konten -->
                        <h3 class="mt-3 text-xs font-bold text-white">{{ $step[1] }}</h3>
                        <p class="mt-1 text-[11px] leading-4 text-white/70 px-1">{{ $step[2] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- MOBILE: VERTICAL TIMELINE -->
        <div class="lg:hidden mt-6 relative pl-2 space-y-6">
            @foreach ($steps as $index => $step)
                <div class="relative flex items-start space-x-4">
                    
                    <!-- Garis Penghubung Vertikal (Hanya dirender untuk Step 1-4) -->
                    @if ($index < count($steps) - 1)
                        <div class="absolute top-3 left-[13px] w-[2px] h-[calc(100%+1.5rem)] bg-white/20 z-0"></div>
                    @endif

                    <!-- Nomor Step / Icon -->
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

        <!-- REGISTRATION FEE INFO -->
        <div class="mt-8 rounded-2xl border border-white/10 bg-white/[0.03] p-5 backdrop-blur-sm lg:mt-10">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <span class="text-xs font-medium uppercase tracking-[0.1em] text-white/60">Registration Fee</span>
                    <div class="mt-1 flex items-baseline gap-2">
                        <span class="text-2xl font-extrabold tracking-tight text-white sm:text-3xl">Rp190.000</span>
                        <span class="text-xs text-white/50">/ participant</span>
                    </div>
                    <p class="mt-1 text-[11px] text-white/60">Payment processing fee may apply.</p>
                </div>
                
                <!-- CTA Button -->
                <div class="order-2 sm:order-none">
                    <a href="/register" aria-label="Register Now" class="inline-flex items-center justify-center rounded-full border border-white/20 bg-[#FD4801] px-5 py-3 lg:py-2 text-xs font-semibold uppercase tracking-[0.12em] text-white transition duration-300 hover:scale-105 shadow-lg shadow-[#FD4801]/30 w-full sm:w-auto">
                        Register Now
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>