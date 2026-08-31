@extends('layouts.app')

@section('content')
    <!-- Script Midtrans Snap (Hanya di-load jika Midtrans Aktif) -->
    @if($midtransEnabled)
        <script type="text/javascript"
            src="{{ config('services.midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}"
            data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    @endif

    <!-- Main Content -->
    <main class="py-6 bg-[#E2E2E2] min-h-screen text-[#000C28]">
        <!-- Inisialisasi State Alpine.js dengan Feature Toggle $midtransEnabled -->
        <div x-data="{ 
            midtransEnabled: {{ json_encode($midtransEnabled) }},
            activeTab: '{{ $midtransEnabled ? 'midtrans' : 'manual' }}' 
        }" class="mx-auto max-w-5xl px-4 sm:px-6">

            <!-- Stepper Section -->
            <section class="mb-6">
                <div class="flex items-center justify-center max-w-xs mx-auto">
                    <div class="flex flex-col items-center shrink-0">
                        <div class="flex items-center justify-center w-7 h-7 rounded-full bg-white border border-gray-300 text-gray-500 font-bold text-xs">✓</div>
                        <span class="text-[9px] font-semibold uppercase tracking-wider text-gray-500 mt-1">Registration</span>
                    </div>
                    <div class="flex-1 flex items-center justify-center px-1.5 mb-4">
                        <div class="h-0.5 w-full bg-[#FD4801]"></div>
                    </div>
                    <div class="flex flex-col items-center shrink-0">
                        <div class="flex items-center justify-center w-7 h-7 rounded-full bg-[#FD4801] text-white font-bold text-xs">2</div>
                        <span class="text-[9px] font-semibold uppercase tracking-wider text-[#FD4801] mt-1">Payment</span>
                    </div>
                </div>
            </section>

            <!-- Main Layout Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-start">

                <!-- KIRI: Summary Card Dinamis -->
                <div class="lg:col-span-4 flex flex-col gap-4">
                    <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 flex flex-col justify-between">
                        <div>
                            <h2 class="text-xs font-bold uppercase tracking-wider text-gray-500 mb-3">Registration Summary</h2>

                            <!-- Profile Box -->
                            <div class="flex items-center gap-2.5 bg-[#F5F7FA] rounded-lg p-2.5 mb-3.5">
                                <div class="w-8 h-8 rounded-full bg-gray-200 border border-gray-300 flex items-center justify-center text-gray-600 overflow-hidden shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.654 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div class="overflow-hidden">
                                    <h3 class="font-bold text-xs text-[#000C28] truncate">{{ $registration->full_name ?? 'Nama Peserta' }}</h3>
                                    <p class="text-[10px] text-gray-500 truncate">{{ $registration->email ?? 'email@domain.com' }}</p>
                                </div>
                            </div>

                            <!-- Details List dengan Respon Dinamis Alpine -->
                            <div class="space-y-2 text-xs border-b border-gray-100 pb-3 mb-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-500 text-[11px]">Category</span>
                                    <span class="font-bold text-xs text-[#000C28]">{{ $registration->category ?? '10K Trail Run' }}</span>
                                </div>
                                <div class="flex justify-between items-center pt-1">
                                    <span class="text-gray-500 text-[11px]">Ticket Price</span>
                                    <span class="font-medium text-xs text-[#000C28]">Rp190.000</span>
                                </div>
                                <div class="flex justify-between items-center pt-1">
                                    <span class="text-gray-500 text-[11px]">Admin Fee</span>
                                    <span class="font-medium text-xs text-[#000C28]" x-text="activeTab === 'midtrans' ? 'Rp2.500' : 'Rp0 (Gratis)'"></span>
                                </div>
                                <div class="flex justify-between items-center pt-1.5 border-t border-dashed border-gray-200">
                                    <span class="text-gray-500 text-[11px]">Total Amount</span>
                                    <span class="font-bold text-xs text-[#FD4801]" x-text="activeTab === 'midtrans' ? 'Rp192.500' : 'Rp190.000'"></span>
                                </div>
                            </div>

                            <div class="flex justify-between items-center">
                                <span class="text-gray-500 uppercase tracking-wider text-[10px] font-semibold">Status</span>
                                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-orange-50 text-[#FD4801] border border-orange-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#FD4801] animate-pulse"></span>
                                    {{ strtoupper($registration->payment_status ?? 'PENDING') }}
                                </span>
                            </div>
                        </div>
                    </div>

                <!-- 2. Info Cards (Mobile: 3 Horizontal, Desktop: Vertikal ke Bawah) -->
                    <div class="grid grid-cols-3 lg:grid-cols-1 gap-2 sm:gap-3">
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 border-t-[3px] border-t-[#FD4801] p-2.5 flex flex-col justify-center items-center lg:flex-row lg:justify-between text-center lg:text-left">
                            <div class="w-full">
                                <h3 class="font-black text-[8px] sm:text-[9px] text-[#FD4801] uppercase tracking-wider mb-0.5">Validity</h3>
                                <p class="font-bold text-[10px] sm:text-xs text-[#000C28] leading-none" x-text="activeTab === 'midtrans' ? '15 Mins' : '1x24 Jam'"></p>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 border-t-[3px] border-t-[#FD4801] p-2.5 flex flex-col justify-center items-center lg:flex-row lg:justify-between text-center lg:text-left">
                            <div class="w-full">
                                <h3 class="font-black text-[8px] sm:text-[9px] text-[#FD4801] uppercase tracking-wider mb-0.5">Method</h3>
                                <p class="font-bold text-[10px] sm:text-xs text-[#000C28] leading-none" x-text="activeTab === 'midtrans' ? 'QRIS / Instant' : 'Manual Transfer'"></p>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 border-t-[3px] border-t-[#FD4801] p-2.5 flex flex-col justify-center items-center lg:flex-row lg:justify-between text-center lg:text-left">
                            <div class="w-full">
                                <h3 class="font-black text-[8px] sm:text-[9px] text-[#FD4801] uppercase tracking-wider mb-0.5">Ticket</h3>
                                <p class="font-bold text-[10px] sm:text-xs text-[#000C28] leading-none" x-text="activeTab === 'midtrans' ? 'Instant Email' : 'After Verification'"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- KANAN: Payment Tab Container -->
                <div class="lg:col-span-8 w-full">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        
                        <!-- Tab Navigation Header dengan Feature Toggle -->
                        <div class="flex border-b border-gray-200 bg-gray-50">
                            <!-- Tab Midtrans (QRIS) -->
                            <button 
                                @click="if(midtransEnabled) activeTab = 'midtrans'" 
                                :disabled="!midtransEnabled"
                                :class="{
                                    'border-b-2 border-[#FD4801] text-[#FD4801] font-bold bg-white': activeTab === 'midtrans',
                                    'text-gray-400 opacity-60 cursor-not-allowed': !midtransEnabled,
                                    'text-gray-500 hover:text-gray-700': midtransEnabled && activeTab !== 'midtrans'
                                }"
                                class="flex-1 py-3 px-3 text-center text-xs sm:text-sm font-semibold transition-colors outline-none flex flex-col sm:flex-row items-center justify-center gap-1.5">
                                <span>Bayar Otomatis (QRIS)</span>
                                
                                <template x-if="midtransEnabled">
                                    <span class="text-[9px] bg-green-100 text-green-700 px-1.5 py-0.5 rounded font-bold">Tiket Instant</span>
                                </template>
                                <template x-if="!midtransEnabled">
                                    <span class="text-[9px] bg-amber-100 text-amber-700 px-1.5 py-0.5 rounded font-bold">Segera Hadir</span>
                                </template>
                            </button>

                            <!-- Tab Manual -->
                            <button 
                                @click="activeTab = 'manual'" 
                                :class="activeTab === 'manual' ? 'border-b-2 border-[#FD4801] text-[#FD4801] font-bold bg-white' : 'text-gray-500 hover:text-gray-700'"
                                class="flex-1 py-3 px-3 text-center text-xs sm:text-sm font-semibold transition-colors outline-none flex flex-col sm:flex-row items-center justify-center gap-1.5">
                                <span>Transfer Manual</span>
                                <span class="text-[9px] bg-gray-200 text-gray-700 px-1.5 py-0.5 rounded font-bold">Proses 1x24 Jam</span>
                            </button>
                        </div>

                        <!-- Alert Informasi jika Midtrans Belum Aktif -->
                        <template x-if="!midtransEnabled">
                            <div class="p-3 bg-amber-50 border-b border-amber-200 text-amber-800 text-xs flex items-center gap-2">
                                <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                <span>Metode Pembayaran Otomatis (QRIS) sedang dalam pemeliharaan sistem. Silakan lakukan pembayaran via <b>Transfer Bank Manual</b> di bawah ini.</span>
                            </div>
                        </template>

                        <!-- Tab Content Body -->
                        <div class="p-4 sm:p-6">
                            
                            <!-- TAB 1: MIDTRANS -->
                            <div x-show="activeTab === 'midtrans'" x-transition>
                                <div class="mb-4">
                                    <h3 class="text-sm sm:text-base font-bold text-[#000C28]">Pembayaran Otomatis QRIS</h3>
                                    <p class="text-xs text-gray-500">Scan QRIS menggunakan Mobile Banking / E-Wallet. Tiket otomatis terbit setelah bayar.</p>
                                </div>
                                
                                <div class="relative w-full min-h-[520px] rounded-xl bg-gray-50 border border-gray-200 overflow-hidden flex items-center justify-center">
                                    <div id="snap-loading" class="absolute inset-0 flex flex-col items-center justify-center bg-gray-50 z-10 transition-opacity duration-300">
                                        <div class="w-7 h-7 border-3 border-[#FD4801] border-t-transparent rounded-full animate-spin mb-2"></div>
                                        <span class="text-xs font-semibold text-gray-500">Memuat QRIS Midtrans...</span>
                                    </div>
                                    <div id="snap-container" class="w-full h-full flex justify-center items-center"></div>
                                </div>
                            </div>

                            <!-- TAB 2: MANUAL -->
                            <div x-show="activeTab === 'manual'" x-transition x-cloak>
                                <h3 class="text-sm sm:text-base font-bold text-[#000C28] mb-1">Transfer Bank Manual</h3>
                                <p class="text-xs text-gray-500 mb-4">Transfer pas <b>Rp190.000</b> (bebas biaya admin) ke rekening panitia di bawah ini.</p>
                                
                                <div class="bg-[#F5F7FA] p-3.5 rounded-lg border border-gray-200 mb-4 text-xs space-y-2">
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-500">Total Transfer:</span>
                                        <span class="font-bold text-sm text-[#FD4801]">Rp190.000</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Bank Tujuan:</span>
                                        <span class="font-bold text-[#000C28]">BCA</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">No. Rekening:</span>
                                        <span class="font-mono font-bold text-[#FD4801] select-all">1234567890</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Atas Nama:</span>
                                        <span class="font-bold text-[#000C28]">Panitia Jember 10K</span>
                                    </div>
                                </div>

                                <form id="manual-payment-form" action="{{ url('/payment/manual/'.$registration->order_id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                    @csrf
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Upload Bukti Transfer (JPG/PNG, Max 2MB)</label>
                                        <input type="file" name="payment_proof" id="payment_proof_input" required accept="image/jpeg, image/png" 
                                            class="w-full border border-gray-300 rounded-lg p-2 text-xs text-gray-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-orange-50 file:text-[#FD4801] hover:file:bg-orange-100">
                                        <span id="manual-error-msg" class="text-red-500 text-[10px] mt-1 hidden block"></span>
                                    </div>
                                    <button type="submit" id="btn-submit-manual" class="w-full bg-[#FD4801] text-white font-bold py-2.5 px-4 rounded-lg hover:bg-[#e03f00] transition shadow-sm text-xs flex items-center justify-center gap-2">
                                        <span>Kirim Bukti Transfer</span>
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <style> [x-cloak] { display: none !important; } </style>

    @include('partials.footer')
@endsection

@push('scripts')
<script>
    let isLocked = true;

    // Protection handler saat menutup/mengisi ulang halaman
    window.addEventListener('beforeunload', function (e) {
        if (isLocked) {
            e.preventDefault();
            e.returnValue = 'Transaksi belum selesai. Yakin ingin meninggalkan halaman?';
        }
    });

    // 1. MODAL OTOMATIS (MIDTRANS)
    function showDynamicModal(type) {
        isLocked = false;
        localStorage.removeItem('jtr_register_draft');
        
        const isSuccess = type === 'success';
        const bgColor = isSuccess ? '#10B981' : '#EF4444'; 
        const title = isSuccess ? 'Pembayaran Berhasil!' : 'Transaksi Gagal / Expired';
        const msg = isSuccess 
            ? 'Mohon tunggu, E-Ticket Anda sedang diproses ke sistem.' 
            : 'Waktu habis atau transaksi batal. Silakan mengulang pendaftaran kembali.';
            
        const targetUrl = isSuccess ? '/' : '/register';
        const targetText = isSuccess ? 'dashboard utama' : 'halaman pendaftaran';

        const iconHtml = isSuccess 
            ? `<div style="margin: 0 auto 1rem; width: 64px; height: 64px; background: #D1FAE5; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.2);">
                <svg style="width: 32px; height: 32px; color: #10B981;" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
               </div>`
            : `<div style="margin: 0 auto 1rem; width: 64px; height: 64px; background: #FEE2E2; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 6px -1px rgba(239, 68, 68, 0.2);">
                <svg style="width: 32px; height: 32px; color: #EF4444;" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
               </div>`;
        
        const overlay = document.createElement('div');
        overlay.style.cssText = 'position:fixed; inset:0; z-index:9999; background:rgba(0,12,40,0.85); display:flex; align-items:center; justify-content:center; backdrop-filter:blur(5px); font-family:sans-serif; padding:1rem; text-align:center;';
        
        const box = document.createElement('div');
        box.style.cssText = 'background:#ffffff; padding:2rem; border-radius:1.5rem; max-width:320px; width:100%; box-shadow:0 20px 25px -5px rgba(0,0,0,0.1);';
        
        box.innerHTML = `
            ${iconHtml}
            <h3 style="font-size:1.25rem; font-weight:800; color:#000C28; margin-bottom:0.5rem; letter-spacing:-0.025em;">${title}</h3>
            <p style="font-size:0.75rem; color:#4B5563; margin-bottom:1.5rem; line-height:1.5;">${msg}</p>
            <div style="background:#F3F4F6; border-radius:999px; height:6px; width:100%; overflow:hidden; margin-bottom:0.75rem;">
                <div id="loading-bar" style="height:100%; width:100%; background:${bgColor}; transition:width 1s linear;"></div>
            </div>
            <p style="font-size:0.65rem; font-weight:700; color:#9CA3AF; text-transform:uppercase; letter-spacing:0.05em;">Kembali ke ${targetText} dalam <span id="countdown-text" style="color:${bgColor};">10</span> detik...</p>
        `;
        
        overlay.appendChild(box);
        document.body.appendChild(overlay);

        let timeLeft = 10;
        const bar = document.getElementById('loading-bar');
        const text = document.getElementById('countdown-text');
        
        const timer = setInterval(() => {
            timeLeft--;
            if (text) text.innerText = timeLeft;
            if (bar) bar.style.width = (timeLeft * 10) + '%';
            
            if (timeLeft <= 0) {
                clearInterval(timer);
                window.location.href = targetUrl; 
            }
        }, 1000);
    }

    // 2. MODAL KONFIRMASI TRANSFER MANUAL (Khusus Verifikasi 1x24 jam)
    function showManualSuccessModal() {
        isLocked = false;
        localStorage.removeItem('jtr_register_draft');

        const overlay = document.createElement('div');
        overlay.style.cssText = 'position:fixed; inset:0; z-index:9999; background:rgba(0,12,40,0.85); display:flex; align-items:center; justify-content:center; backdrop-filter:blur(5px); font-family:sans-serif; padding:1rem; text-align:center;';

        const box = document.createElement('div');
        box.style.cssText = 'background:#ffffff; padding:2rem; border-radius:1.5rem; max-width:340px; width:100%; box-shadow:0 20px 25px -5px rgba(0,0,0,0.1);';

        const iconHtml = `<div style="margin: 0 auto 1rem; width: 64px; height: 64px; background: #FEF3C7; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 6px -1px rgba(245, 158, 11, 0.2);">
            <svg style="width: 32px; height: 32px; color: #D97706;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>`;

        box.innerHTML = `
            ${iconHtml}
            <h3 style="font-size:1.2rem; font-weight:800; color:#000C28; margin-bottom:0.5rem;">Bukti Transfer Terkirim!</h3>
            <p style="font-size:0.75rem; color:#4B5563; margin-bottom:1.25rem; line-height:1.5;">
                Terima kasih. Bukti pembayaran Anda telah berhasil diunggah. Tim kami sedang melakukan <b>verifikasi manual (maksimal 1x24 jam)</b>. E-Ticket akan dikirim ke email Anda.
            </p>
            <div style="background:#F3F4F6; border-radius:999px; height:6px; width:100%; overflow:hidden; margin-bottom:0.75rem;">
                <div id="manual-bar" style="height:100%; width:100%; background:#D97706; transition:width 1s linear;"></div>
            </div>
            <p style="font-size:0.65rem; font-weight:700; color:#9CA3AF; text-transform:uppercase;">Kembali ke Halaman Utama dalam <span id="manual-countdown" style="color:#D97706;">10</span> detik...</p>
        `;

        overlay.appendChild(box);
        document.body.appendChild(overlay);

        let timeLeft = 10;
        const bar = document.getElementById('manual-bar');
        const text = document.getElementById('manual-countdown');

        const timer = setInterval(() => {
            timeLeft--;
            if (text) text.innerText = timeLeft;
            if (bar) bar.style.width = (timeLeft * 10) + '%';

            if (timeLeft <= 0) {
                clearInterval(timer);
                window.location.href = '/';
            }
        }, 1000);
    }

    // 3. EVENT HANDLER & SUBMIT AJAX
    document.addEventListener("DOMContentLoaded", function() {
        
        var paymentStatus = "{{ $registration->payment_status }}";
        if (paymentStatus === 'paid') {
            showDynamicModal('success');
            return;
        }

        // Embed Snap HANYA jika Midtrans Aktif
        @if($midtransEnabled)
            var snapToken = "{{ $registration->snap_token }}";
            if (snapToken && typeof window.snap !== 'undefined') {
                window.snap.embed(snapToken, {
                    embedId: 'snap-container',
                    onSuccess: function (result) {
                        fetch('/payment/verify/' + "{{ $registration->order_id }}", {
                            method: 'GET',
                            headers: { 'Accept': 'application/json' }
                        }).finally(() => {
                            showDynamicModal('success');
                        });
                    },
                    onPending: function (result) {},
                    onError: function (result) {
                        showDynamicModal('error');
                    },
                    onClose: function () {}
                });

                const checkSnapLoaded = setInterval(() => {
                    const snapIframe = document.querySelector('#snap-container iframe');
                    if (snapIframe) {
                        const loadingEl = document.getElementById('snap-loading');
                        if (loadingEl) {
                            loadingEl.style.opacity = '0';
                            setTimeout(() => loadingEl.remove(), 300);
                        }
                        clearInterval(checkSnapLoaded);
                    }
                }, 200);
            }
        @endif

        // Manual Payment Form Submission (AJAX & No Reload)
        const manualForm = document.getElementById('manual-payment-form');
        if (manualForm) {
            manualForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                isLocked = false; 

                const btn = document.getElementById('btn-submit-manual');
                const errorMsg = document.getElementById('manual-error-msg');
                errorMsg.classList.add('hidden');

                btn.disabled = true;
                btn.innerHTML = `
                    <div class="w-3.5 h-3.5 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                    <span>Mengirim Bukti...</span>
                `;

                const formData = new FormData(this);

                fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(async response => {
                    if (response.ok) {
                        showManualSuccessModal();
                    } else {
                        const data = await response.json().catch(() => ({}));
                        const message = data.message || (data.errors && data.errors.payment_proof ? data.errors.payment_proof[0] : 'Gagal mengunggah bukti transfer.');
                        
                        errorMsg.innerText = message;
                        errorMsg.classList.remove('hidden');
                        
                        btn.disabled = false;
                        btn.innerHTML = '<span>Kirim Bukti Transfer</span>';
                        isLocked = true;
                    }
                })
                .catch(err => {
                    showManualSuccessModal();
                });
            });
        }
    });
</script>
@endpush