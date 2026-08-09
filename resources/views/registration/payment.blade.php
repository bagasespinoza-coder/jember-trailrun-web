@extends('layouts.app')

@section('content')
    <!-- 🚀 WAJIB ADA: Script Midtrans Snap -->
    <script type="text/javascript"
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>

    <!-- Navbar -->
    @include('partials.navbar')

    <!-- Main Content -->
    <main class="pt-32 pb-16 bg-[#E2E2E2] min-h-screen text-[#000C28]">
        <div class="mx-auto max-w-6xl px-5 lg:px-10">

            <!-- Stepper Section (Tetap sama) -->
            <section class="mb-10">
                <div class="flex items-center justify-center gap-2 md:gap-4 max-w-2xl mx-auto flex-wrap">
                    <div class="flex items-center gap-2">
                        <div class="flex items-center justify-center w-8 h-8 rounded-full bg-[#D9E2EC] text-[#627D98] font-semibold text-sm">1</div>
                        <span class="text-sm font-medium text-[#627D98]">Registration</span>
                    </div>
                    <div class="h-[1px] w-12 md:w-16 bg-[#BCCCDC]"></div>
                    <div class="flex items-center gap-2">
                        <div class="flex items-center justify-center w-8 h-8 rounded-full bg-[#fd4801] text-white font-semibold text-sm">2</div>
                        <span class="text-sm font-bold text-[#fd4801]">Payment</span>
                    </div>
                    <div class="h-[1px] w-12 md:w-16 bg-[#BCCCDC]"></div>
                    <div class="flex items-center gap-2">
                        <div class="flex items-center justify-center w-8 h-8 rounded-full bg-[#E4E7EB] text-[#9AA5B1] font-semibold text-sm">3</div>
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
                            <div class="w-12 h-12 rounded-full bg-gray-200 border border-gray-300 flex items-center justify-center text-gray-600 overflow-hidden shrink-0">
                                @if(isset($registration->gender) && strtolower($registration->gender) == 'p')
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                @else
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.654 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                @endif
                            </div>
                            <div class="overflow-hidden">
                                <!-- 🚀 FIX: Menggunakan full_name -->
                                <h3 class="font-bold text-sm text-[#000C28] truncate">{{ $registration->full_name ?? 'Nama Peserta' }}</h3>
                                <p class="text-xs text-gray-500 truncate">{{ $registration->email ?? 'email@domain.com' }}</p>
                            </div>
                        </div>

                        <!-- Details List -->
                        <div class="space-y-4 text-sm border-b border-gray-100 pb-5 mb-5">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500 text-xs">Category</span>
                                <span class="font-bold text-xs text-[#000C28]">{{ $registration->category ?? '10K' }}</span>
                            </div>
                            <div class="flex justify-between items-center pt-2 border-t border-dashed border-gray-200">
                                <span class="text-gray-500 text-xs">Total Amount</span>
                                <!-- 🚀 FIX: Menggunakan gross_amount -->
                                <span class="font-semibold text-xs text-[#fd4801]">Rp{{ number_format($registration->gross_amount ?? 165000, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="space-y-4 text-sm mb-6">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500 uppercase tracking-wider text-[10px] font-semibold">Status</span>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-orange-50 text-[#fd4801] border border-orange-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#fd4801] animate-pulse"></span>
                                    {{ strtoupper($registration->payment_status ?? 'PENDING') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: QRIS Payment Card -->
                <div class="lg:col-span-8 flex flex-col gap-6">
                    
                    <div class="bg-[#F5F7FA] rounded-2xl shadow-sm p-6 md:p-8 border border-gray-100">
                        <h2 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-6">Payment via QRIS Only</h2>

                        <!-- 🚀 WADAH ASLI MIDTRANS SNAP EMBED -->
                        <!-- Kita buang SVG dummy temen lu, ganti pakai ini biar Snap nge-render di sini -->
                        <div class="bg-white rounded-xl p-2 border border-gray-100 flex justify-center items-center overflow-hidden min-h-[450px]">
                            <div id="snap-container" class="w-full h-full"></div>
                        </div>
                        
                    </div>

                    <!-- Bottom Info Cards Row (Tetap sama) -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-white rounded-2xl shadow-xs border border-gray-100 p-5 flex flex-col gap-3">
                            <h3 class="font-bold text-sm text-[#000C28]">Payment Validity</h3>
                            <p class="text-xs text-gray-500 leading-relaxed">Your payment link is valid for 24 hours. If it expires, you'll need to re-register.</p>
                        </div>
                        <div class="bg-white rounded-2xl shadow-xs border border-gray-100 p-5 flex flex-col gap-3">
                            <h3 class="font-bold text-sm text-[#000C28]">Change Methods</h3>
                            <p class="text-xs text-gray-500 leading-relaxed">You can change your payment method anytime before the countdown expires.</p>
                        </div>
                        <div class="bg-white rounded-2xl shadow-xs border border-gray-100 p-5 flex flex-col gap-3">
                            <h3 class="font-bold text-sm text-[#000C28]">Success Proof</h3>
                            <p class="text-xs text-gray-500 leading-relaxed">You will receive an automated confirmation email and E-BIB once payment is verified.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

    @include('partials.footer')
@endsection

@push('scripts')
<!-- 🚀 LOGIKA EKSEKUSI SNAP EMBED -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var snapToken = "{{ $registration->snap_token }}";
        
        if (snapToken) {
            window.snap.embed(snapToken, {
                embedId: 'snap-container',
                onSuccess: function (result) {
                    window.location.href = '/confirmation';
                },
                onPending: function (result) {
                    alert('Menunggu pembayaran Anda.');
                },
                onError: function (result) {
                    alert('Pembayaran gagal, silakan coba lagi.');
                }
            });
        }
    });
</script>
@endpush