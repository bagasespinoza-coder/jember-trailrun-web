@extends('layouts.app')

@section('content')
    <!-- Script Midtrans Snap -->
    <script type="text/javascript"
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>

    <!-- Main Content -->
    <main class="py-6 bg-[#E2E2E2] min-h-screen text-[#000C28]">
        <div class="mx-auto max-w-5xl px-4 sm:px-6">

            <!-- Stepper Section (Minimalis & Rapat) -->
            <section class="mb-6">
                <div class="flex items-center justify-center max-w-xs mx-auto">
                    <!-- Step 1: Registration -->
                    <div class="flex flex-col items-center shrink-0">
                        <div class="flex items-center justify-center w-7 h-7 rounded-full bg-white border border-gray-300 text-gray-500 font-bold text-xs">
                            ✓
                        </div>
                        <span class="text-[9px] font-semibold uppercase tracking-wider text-gray-500 mt-1">Registration</span>
                    </div>

                    <!-- Connector 1 -->
                    <div class="flex-1 flex items-center justify-center px-1.5 mb-4">
                        <div class="h-0.5 w-full bg-[#FD4801]"></div>
                    </div>

                    <!-- Step 2: Payment (Active) -->
                    <div class="flex flex-col items-center shrink-0">
                        <div class="flex items-center justify-center w-7 h-7 rounded-full bg-[#FD4801] text-white font-bold text-xs">
                            2
                        </div>
                        <span class="text-[9px] font-semibold uppercase tracking-wider text-[#FD4801] mt-1">Payment</span>
                    </div>
                </div>
            </section>

            <!-- Main Layout Grid (Kembali Dua Kolom) -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-start">

                <!-- Left Column: Registration Summary Card -->
                <div class="lg:col-span-4 bg-white rounded-xl shadow-sm p-4 border border-gray-100 flex flex-col justify-between">
                    <div>
                        <h2 class="text-xs font-bold uppercase tracking-wider text-gray-500 mb-3">Registration Summary</h2>

                        <!-- Profile Box -->
                        <div class="flex items-center gap-2.5 bg-[#F5F7FA] rounded-lg p-2.5 mb-3.5">
                            <div class="w-8 h-8 rounded-full bg-gray-200 border border-gray-300 flex items-center justify-center text-gray-600 overflow-hidden shrink-0">
                                @if(isset($registration->gender) && strtolower($registration->gender) == 'p')
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                @else
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.654 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                @endif
                            </div>
                            <div class="overflow-hidden">
                                <h3 class="font-bold text-xs text-[#000C28] truncate">{{ $registration->full_name ?? 'Nama Peserta' }}</h3>
                                <p class="text-[10px] text-gray-500 truncate">{{ $registration->email ?? 'email@domain.com' }}</p>
                            </div>
                        </div>

                        <!-- Details List -->
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
                                <span class="font-medium text-xs text-[#000C28]">Rp2.500</span>
                            </div>
                            <div class="flex justify-between items-center pt-1.5 border-t border-dashed border-gray-200">
                                <span class="text-gray-500 text-[11px]">Total Amount</span>
                                <!-- Fallback disesuaikan ke 192500 (190.000 + 2.500) -->
                                <span class="font-semibold text-xs text-[#FD4801]">Rp{{ number_format($registration->gross_amount ?? 192500, 0, ',', '.') }}</span>
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

                <!-- Right Column: QRIS Payment Card & Info Rows -->
                <div class="lg:col-span-8 flex flex-col gap-4">
                    
                    <div class="bg-[#F5F7FA] rounded-xl shadow-sm p-4 sm:p-5 border border-gray-100">
                        <h2 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Payment via QRIS Only</h2>

                        <!-- Wadah Midtrans Snap Embed -->
                        <div class="bg-white rounded-xl p-2 border border-gray-100 flex justify-center items-center overflow-hidden min-h-[380px]">
                            <div id="snap-container" class="w-full h-full"></div>
                        </div>
                    </div>

                    <!-- Bottom Info Cards Row -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        <div class="bg-white rounded-xl shadow-xs border border-gray-100 p-3 flex flex-col gap-1">
                            <h3 class="font-bold text-xs text-[#000C28]">Payment Validity</h3>
                            <p class="text-[10px] text-gray-500 leading-relaxed">Valid for 24 hours. If it expires, re-register.</p>
                        </div>
                        <div class="bg-white rounded-xl shadow-xs border border-gray-100 p-3 flex flex-col gap-1">
                            <h3 class="font-bold text-xs text-[#000C28]">Change Methods</h3>
                            <p class="text-[10px] text-gray-500 leading-relaxed">You can change your method before expiration.</p>
                        </div>
                        <div class="bg-white rounded-xl shadow-xs border border-gray-100 p-3 flex flex-col gap-1">
                            <h3 class="font-bold text-xs text-[#000C28]">Success Proof</h3>
                            <p class="text-[10px] text-gray-500 leading-relaxed">Email & E-BIB sent once verified.</p>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </main>

    @include('partials.footer')
@endsection

@push('scripts')
<script>
    // 1. FITUR KUNCI HALAMAN (Cegah user iseng pencet Back/Refresh)
    let isLocked = true;
    window.addEventListener('beforeunload', function (e) {
        if (isLocked) {
            e.preventDefault();
            e.returnValue = 'Transaksi belum selesai. Yakin ingin meninggalkan halaman?';
        }
    });

    // 2. MESIN PEMBUAT MODAL 10 DETIK (Tanpa merusak HTML asli)
    function showDynamicModal(type) {
        isLocked = false; // Buka kunci layar biar bisa pindah halaman nanti
        
        const isSuccess = type === 'success';
        const bgColor = isSuccess ? '#10B981' : '#EF4444'; // Emerald buat sukses, Merah buat error
        const title = isSuccess ? 'Pembayaran Berhasil!' : 'Transaksi Gagal / Expired';
        const msg = isSuccess ? 'Mohon tunggu, E-Ticket Anda sedang diproses ke sistem.' : 'Waktu habis. Silakan mengulang pendaftaran kembali.';
        
        // Ciptakan elemen Overlay Hitam melayang di seluruh layar
        const overlay = document.createElement('div');
        overlay.style.cssText = 'position:fixed; inset:0; z-index:9999; background:rgba(0,12,40,0.85); display:flex; align-items:center; justify-content:center; backdrop-filter:blur(5px); font-family:sans-serif; padding:1rem; text-align:center;';
        
        // Ciptakan Kotak Putih Modal
        const box = document.createElement('div');
        box.style.cssText = 'background:#ffffff; padding:2rem; border-radius:1rem; max-width:320px; width:100%; box-shadow:0 20px 25px -5px rgba(0,0,0,0.1);';
        
        // Isi Kotak dengan Teks & Loading Bar
        box.innerHTML = `
            <h3 style="font-size:1.25rem; font-weight:800; color:#000C28; margin-bottom:0.5rem; letter-spacing:-0.025em;">${title}</h3>
            <p style="font-size:0.75rem; color:#4B5563; margin-bottom:1.5rem; line-height:1.5;">${msg}</p>
            <div style="background:#F3F4F6; border-radius:999px; height:6px; width:100%; overflow:hidden; margin-bottom:0.75rem;">
                <div id="loading-bar" style="height:100%; width:100%; background:${bgColor}; transition:width 1s linear;"></div>
            </div>
            <p style="font-size:0.65rem; font-weight:700; color:#9CA3AF; text-transform:uppercase; letter-spacing:0.05em;">Kembali ke awal dalam <span id="countdown-text" style="color:${bgColor};">10</span> detik...</p>
        `;
        
        // Tempel modal ini secara paksa ke dalam body HTML
        overlay.appendChild(box);
        document.body.appendChild(overlay);

        // 3. LOGIKA HITUNG MUNDUR & TENDANG BALIK KE REGISTER
        let timeLeft = 10;
        const bar = document.getElementById('loading-bar');
        const text = document.getElementById('countdown-text');
        
        const timer = setInterval(() => {
            timeLeft--;
            text.innerText = timeLeft;
            bar.style.width = (timeLeft * 10) + '%';
            
            if (timeLeft <= 0) {
                clearInterval(timer);
                window.location.href = '/register'; // Lempar balik ke titik nol
            }
        }, 1000);
    }

    // 4. EKSEKUSI MIDTRANS SNAP
    document.addEventListener("DOMContentLoaded", function() {
        var snapToken = "{{ $registration->snap_token }}";
        
        if (snapToken) {
            window.snap.embed(snapToken, {
                embedId: 'snap-container',
                onSuccess: function (result) {
                    showDynamicModal('success'); // Panggil modal sukses
                },
                onPending: function (result) {
                    // Biarkan user anteng milih metode bayar
                },
                onError: function (result) {
                    showDynamicModal('error'); // Panggil modal gagal
                },
                onClose: function () {
                    // Biarkan saja, user mungkin mau ganti bank
                }
            });
        }
    });
</script>
@endpush