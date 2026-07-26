<section id="register-flow" class="bg-[#000C28] px-5 py-24 lg:px-10">
    <div class="mx-auto max-w-[1200px]">
        <div class="max-w-3xl">
            <h2 class="mt-4 text-3xl font-bold uppercase tracking-[-0.03em] text-[#E2E2E2] sm:text-4xl lg:text-5xl">
                Registration <span class="text-[#FD4801]">Flow</span>
            </h2>
            <!-- Garis pemisah oranye kecil di bawah judul (diratakan ke kiri agar sejajar dengan teks) -->
            <div class="mt-6 h-1 w-16 rounded-full bg-[#FD4801]"></div>
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
        <div class="hidden lg:block mt-20 relative">
            <!-- Garis Penghubung Horizontal -->
            <div class="absolute top-6 left-12 right-12 h-[2px] bg-white/20 -z-0"></div>

            <div class="grid grid-cols-5 gap-6 relative z-10">
                @foreach ($steps as $index => $step)
                    <div class="flex flex-col items-start">
                        <!-- Nomor Step / Icon -->
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl text-lg font-bold shadow-lg {{ $index === 0 ? 'bg-[#FD4801] text-white shadow-[#FD4801]/30' : 'bg-blue-600 text-white shadow-blue-600/30' }}">
                            {{ $step[0] }}
                        </div>
                        
                        <!-- Teks Konten -->
                        <h3 class="mt-6 text-lg font-bold text-white">{{ $step[1] }}</h3>
                        <p class="mt-2 text-sm leading-6 text-white/70">{{ $step[2] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- MOBILE: VERTICAL TIMELINE -->
        <div class="lg:hidden mt-14 relative pl-2 space-y-10">
            <!-- Garis Penghubung Vertikal -->
            <div class="absolute top-3 bottom-3 left-[23px] w-[2px] bg-white/20"></div>

            @foreach ($steps as $index => $step)
                <div class="relative flex items-start space-x-6">
                    <!-- Nomor Step / Icon (Absolute Positioning untuk menimpa garis) -->
                    <div class="relative z-10 flex h-10 w-10 shrink-0 items-center justify-center rounded-xl text-sm font-bold shadow-lg {{ $index === 0 ? 'bg-[#FD4801] text-white shadow-[#FD4801]/30' : 'bg-blue-600 text-white shadow-blue-600/30' }}">
                        {{ $step[0] }}
                    </div>

                    <!-- Teks Konten -->
                    <div>
                        <h3 class="text-base font-bold text-white">{{ $step[1] }}</h3>
                        <p class="mt-1 text-sm leading-6 text-white/70">{{ $step[2] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>