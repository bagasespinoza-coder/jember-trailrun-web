@extends('layouts.app')

@section('content')
    <!-- Navbar -->
    @include('partials.navbar')

    <!-- Main Content -->
    <main class="pt-32 pb-16 bg-[#E2E2E2] min-h-screen text-[#000C28]">
        <div class="mx-auto max-w-6xl px-5 lg:px-10">

            <!-- Stepper Section -->
            <section class="mb-10">
                <div class="flex items-center justify-center gap-2 md:gap-4 max-w-2xl mx-auto flex-wrap">
                    <!-- Step 1: Registration -->
                    <div class="flex items-center gap-2">
                        <div class="flex items-center justify-center w-8 h-8 rounded-full bg-[#D9E2EC] text-[#627D98] font-semibold text-sm">
                            1
                        </div>
                        <span class="text-sm font-medium text-[#627D98]">Registration</span>
                    </div>

                    <!-- Connector -->
                    <div class="h-[1px] w-12 md:w-16 bg-[#BCCCDC]"></div>

                    <!-- Step 2: Payment (Active) -->
                    <div class="flex items-center gap-2">
                        <div class="flex items-center justify-center w-8 h-8 rounded-full bg-[#fd4801] text-white font-semibold text-sm">
                            2
                        </div>
                        <span class="text-sm font-bold text-[#fd4801]">Payment</span>
                    </div>

                    <!-- Connector -->
                    <div class="h-[1px] w-12 md:w-16 bg-[#BCCCDC]"></div>

                    <!-- Step 3: Confirmation -->
                    <div class="flex items-center gap-2">
                        <div class="flex items-center justify-center w-8 h-8 rounded-full bg-[#E4E7EB] text-[#9AA5B1] font-semibold text-sm">
                            3
                        </div>
                        <span class="text-sm font-medium text-[#9AA5B1]">Confirmation</span>
                    </div>
                </div>
            </section>

            <!-- Main Layout Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

                <!-- Left Column: Registration Summary Card -->
                <div class="lg:col-span-4 bg-white rounded-2xl shadow-sm p-6 border border-gray-100 flex flex-col justify-between min-h-[500px]">
                    <div>
                        <h2 class="text-lg font-bold text-[#000C28] mb-5">Registration Summary</h2>

                        <!-- Profile Box -->
                        <div class="flex items-center gap-4 bg-[#F5F7FA] rounded-xl p-4 mb-6">
                            <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=150&h=150&q=80" 
                                 alt="Adrian Wijaya" 
                                 class="w-12 h-12 rounded-full object-cover border border-gray-200">
                            <div>
                                <h3 class="font-bold text-sm text-[#000C28]">Adrian Wijaya</h3>
                                <p class="text-xs text-gray-500">adrian.wijaya@email.com</p>
                            </div>
                        </div>

                        <!-- Details List -->
                        <div class="space-y-4 text-sm border-b border-gray-100 pb-5 mb-5">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500 text-xs">Category</span>
                                <span class="font-bold text-xs text-[#000C28]">10 KM Trail Elite</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500 text-xs">Race Date</span>
                                <span class="font-semibold text-xs text-[#000C28]">Nov 24, 2024</span>
                            </div>
                            <div class="flex justify-between items-center pt-2 border-t border-dashed border-gray-200">
                                <span class="text-gray-500 text-xs">Registration Fee</span>
                                <span class="font-semibold text-xs text-[#000C28]">Rp150.000</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500 text-xs">Service Fee</span>
                                <span class="font-semibold text-xs text-[#000C28]">Rp2.500</span>
                            </div>
                        </div>

                        <div class="space-y-4 text-sm mb-6">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500 uppercase tracking-wider text-[10px] font-semibold">Payment Status</span>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-orange-50 text-[#fd4801] border border-orange-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#fd4801] animate-pulse"></span>
                                    Pending
                                </span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500 uppercase tracking-wider text-[10px] font-semibold">Registration Time</span>
                                <span class="text-xs text-gray-600 font-medium text-right">Oct 24, 2024 | 14:30 WIB</span>
                            </div>
                        </div>
                    </div>

                    <!-- Coupon Input & Info Footer -->
                    <div>
                        <div class="flex gap-2 mb-6">
                            <input type="text" placeholder="Coupon Code" aria-label="Coupon Code" 
                                class="flex-1 bg-[#F5F7FA] rounded-xl border border-gray-200 px-4 py-2.5 text-xs focus:outline-none focus:ring-1 focus:ring-[#fd4801] placeholder-gray-400">
                            <button aria-label="Apply Coupon" class="bg-[#000C28] text-white px-5 py-2.5 rounded-xl text-xs font-bold hover:bg-[#fd4801] transition duration-300">
                                Apply
                            </button>
                        </div>

                        <div class="flex items-center justify-center gap-4 text-[10px] text-gray-400 font-semibold border-t border-gray-100 pt-4">
                            <span class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"></path>
                                </svg>
                                PCI DSS SECURE
                            </span>
                            <span class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"></path>
                                </svg>
                                256-BIT AES
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Right Column: QRIS Payment Card -->
                <div class="lg:col-span-8 flex flex-col gap-6">
                    
                    <div class="bg-[#F5F7FA] rounded-2xl shadow-sm p-6 md:p-8 border border-gray-100">
                        <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-6">Payment via QRIS Only</h2>

                        <!-- Main Inner QRIS Container -->
                        <div class="bg-white rounded-xl p-6 border border-gray-100 flex flex-col md:flex-row gap-8 items-center">
                            
                            <!-- Left: QR Code & Buttons -->
                            <div class="flex flex-col items-center gap-4 w-full md:w-auto">
                                <div class="w-48 h-48 bg-white border border-gray-200 rounded-xl p-3 flex items-center justify-center shadow-xs">
                                    <!-- Clean inline SVG QR Code structure representing QRIS mockup -->
                                    <svg class="w-full h-full text-black" viewBox="0 0 100 100" shape-rendering="crispEdges">
                                        <path fill="#ffffff" d="M0 0h100v100H0z"/>
                                        <!-- Top Left Position Block -->
                                        <path fill="currentColor" d="M0 0h30v30H0zm5 5v20h20V5zm5 5h10v10H10z"/>
                                        <!-- Top Right Position Block -->
                                        <path fill="currentColor" d="M70 0h30v30H70zm5 5v20h20V5zm5 5h10v10H80z"/>
                                        <!-- Bottom Left Position Block -->
                                        <path fill="currentColor" d="M0 70h30v30H0zm5 5v20h20V75zm5 5h10v10H10z"/>
                                        <!-- Scattered bits to mimic real QR code design -->
                                        <path fill="currentColor" d="M35 5h5v5h-5zM45 0h5v10h-5zM55 5h5v5h-5zM35 15h15v5H35zM40 25h10v5H40zM55 20h10v10H55zM60 0h5v15h-5zM0 35h5v10H0zM15 35h10v5H15zM10 45h20v5H10zM35 35h10v10H35zM50 35h5v5h-5zM65 35h15v5H65zM85 35h15v10H85zM0 55h15v5H0zM25 55h10v15H25zM40 50h5v10h-5zM50 55h20v5H50zM75 55h5v5h-5zM85 50h10v5H85zM10 65h5v5h-5zM35 65h10v10H35zM50 65h5v5h-5zM60 65h10v10H60zM75 65h5v15h-5zM85 65h15v5H85zM35 80h5v10h-5zM45 85h15v5H45zM65 80h5v5h-5zM90 75h10v15H90z"/>
                                        <!-- Dummy QRIS logo style center marker -->
                                        <rect x="42" y="42" width="16" height="16" rx="3" fill="#01217C"/>
                                        <text x="50" y="52" fill="#ffffff" font-size="8" font-weight="bold" text-anchor="middle" font-family="sans-serif">QRIS</text>
                                    </svg>
                                </div>

                                <div class="flex gap-3 w-full">
                                    <button aria-label="Download QR Code" class="flex-1 inline-flex items-center justify-center gap-1.5 border border-gray-200 hover:bg-gray-50 bg-white rounded-xl py-2.5 px-3 text-xs font-semibold transition">
                                        <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"></path>
                                        </svg>
                                        Download QR
                                    </button>
                                    <button aria-label="Copy Reference Number" class="flex-1 inline-flex items-center justify-center gap-1.5 border border-gray-200 hover:bg-gray-50 bg-white rounded-xl py-2.5 px-3 text-xs font-semibold transition">
                                        <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 01-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H5.25m11.9-3.664A2.251 2.251 0 0015 2.25h-1.5a2.251 2.251 0 00-2.15 1.588m5.8 0c.065.21.1.433.1.664v.75h-6V4.5c0-.231.035-.454.1-.664M6.75 7.375c0-.621.504-1.125 1.125-1.125h9.75c.621 0 1.125.504 1.125 1.125V16.5c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 01-1.125-1.125V7.375z"></path>
                                        </svg>
                                        Copy Reference
                                    </button>
                                </div>
                            </div>

                            <!-- Right: Amount, Countdown & Scan Box -->
                            <div class="flex-1 w-full space-y-5">
                                <div>
                                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block">Total Amount to Pay</span>
                                    <span class="text-3xl font-extrabold text-[#000C28]">Rp152.500</span>
                                </div>

                                <!-- Countdown Box -->
                                <div>
                                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block mb-2">Payment Expires In</span>
                                    <div class="flex items-center gap-1.5">
                                        <!-- Hours -->
                                        <div id="hour-box" class="flex items-center justify-center w-10 h-10 rounded-lg bg-[#000C28] text-white font-extrabold text-sm">
                                            23
                                        </div>
                                        <span class="font-bold text-gray-400">:</span>
                                        <!-- Minutes -->
                                        <div id="minute-box" class="flex items-center justify-center w-10 h-10 rounded-lg bg-[#000C28] text-white font-extrabold text-sm">
                                            59
                                        </div>
                                        <span class="font-bold text-gray-400">:</span>
                                        <!-- Seconds -->
                                        <div id="second-box" class="flex items-center justify-center w-10 h-10 rounded-lg bg-[#fd4801] text-white font-extrabold text-sm">
                                            46
                                        </div>
                                    </div>
                                </div>

                                <!-- Info Scan Box -->
                                <div class="bg-[#F8FAFC] border-l-4 border-[#01217C] rounded-r-xl p-4 text-xs text-gray-500 leading-relaxed">
                                    Scan the QR code using GoPay, OVO, DANA, ShopeePay or your mobile banking app. This is the final step; once paid, our admin will verify your transaction within 24 hours.
                                </div>
                            </div>

                        </div>

                        <!-- Simulation Action Buttons at the Bottom -->
                        <div class="mt-6 flex flex-col sm:flex-row gap-4">
                            <a href="/confirmation" aria-label="Confirm Payment" class="flex-1 inline-flex items-center justify-center rounded-full bg-[#fd4801] px-6 py-3.5 text-sm font-bold uppercase tracking-[0.18em] text-white transition duration-300 hover:scale-[1.02] shadow-sm hover:shadow-md">
                                Saya Sudah Membayar
                            </a>
                            <a href="/confirmation" aria-label="Check Payment Status" class="flex-1 inline-flex items-center justify-center rounded-full bg-[#000C28] px-6 py-3.5 text-sm font-bold uppercase tracking-[0.18em] text-white transition duration-300 hover:scale-[1.02] shadow-sm hover:shadow-md">
                                Cek Status Pembayaran
                            </a>
                        </div>
                    </div>

                    <!-- Bottom Info Cards Row -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        
                        <!-- Card 1: Payment Validity -->
                        <div class="bg-white rounded-2xl shadow-xs border border-gray-100 p-5 flex flex-col gap-3">
                            <div class="text-[#01217C] w-9 h-9 rounded-full bg-blue-50 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="font-bold text-sm text-[#000C28]">Payment Validity</h3>
                            <p class="text-xs text-gray-500 leading-relaxed">Your payment link is valid for 24 hours. If it expires, you'll need to re-register.</p>
                        </div>

                        <!-- Card 2: Change Methods -->
                        <div class="bg-white rounded-2xl shadow-xs border border-gray-100 p-5 flex flex-col gap-3">
                            <div class="text-[#01217C] w-9 h-9 rounded-full bg-blue-50 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5"></path>
                                </svg>
                            </div>
                            <h3 class="font-bold text-sm text-[#000C28]">Change Methods</h3>
                            <p class="text-xs text-gray-500 leading-relaxed">You can change your payment method anytime before the countdown expires.</p>
                        </div>

                        <!-- Card 3: Success Proof -->
                        <div class="bg-white rounded-2xl shadow-xs border border-gray-100 p-5 flex flex-col gap-3">
                            <div class="text-[#01217C] w-9 h-9 rounded-full bg-blue-50 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0110 21a3.745 3.745 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.745 3.745 0 013.296-1.043A3.745 3.745 0 0114 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z"></path>
                                </svg>
                            </div>
                            <h3 class="font-bold text-sm text-[#000C28]">Success Proof</h3>
                            <p class="text-xs text-gray-500 leading-relaxed">You will receive an automated confirmation email and E-BIB once payment is verified.</p>
                        </div>

                    </div>

                </div>

            </div>

        </div>
    </main>

    <!-- Footer -->
    @include('partials.footer')

    <!-- Simple Countdown Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Set initial timer values (23 hours, 59 minutes, 46 seconds)
            let hours = 23;
            let minutes = 59;
            let seconds = 46;

            const hourBox = document.getElementById('hour-box');
            const minuteBox = document.getElementById('minute-box');
            const secondBox = document.getElementById('second-box');

            function updateDisplay() {
                if (hourBox) hourBox.textContent = String(hours).padStart(2, '0');
                if (minuteBox) minuteBox.textContent = String(minutes).padStart(2, '0');
                if (secondBox) secondBox.textContent = String(seconds).padStart(2, '0');
            }

            const timerInterval = setInterval(() => {
                if (seconds > 0) {
                    seconds--;
                } else {
                    if (minutes > 0) {
                        minutes--;
                        seconds = 59;
                    } else {
                        if (hours > 0) {
                            hours--;
                            minutes = 59;
                            seconds = 59;
                        } else {
                            // Timer has expired
                            clearInterval(timerInterval);
                            window.location.href = '/payment-expired';
                            return;
                        }
                    }
                }
                updateDisplay();
            }, 1000);

            // Initial display setup
            updateDisplay();
        });
    </script>
@endsection
