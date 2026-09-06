@extends('layouts.app')

@section('content')
    @php
        $basePrice = $registration->amount ?? 190000;
        $adminFee = 2500;
    @endphp

    <!-- Single Main Scope Alpine.js -->
    <div x-data="{ 
        midtransEnabled: @js($midtransEnabled),
        activeTab: @js($midtransEnabled ? 'midtrans' : 'manual'),
        basePrice: @js($basePrice),
        adminFee: @js($adminFee),
        formatRupiah(val) {
            return 'Rp' + new Intl.NumberFormat('id-ID').format(val);
        }
    }">

        <!-- Form Tersembunyi untuk Pembatalan / Edit Data -->
        <form id="edit-data-regist" action="{{ route('payment.edit', $registration->order_id) }}" method="POST" class="hidden">
            @csrf
        </form>

        <!-- Main Content -->
        <main class="py-6 sm:py-10 bg-[#E2E2E2] min-h-screen text-[#000C28]">
            <div class="mx-auto max-w-3xl px-4 sm:px-6">

                <!-- ================= HEADER HERO CARD ================= -->
                <header class="relative overflow-hidden rounded-3xl p-5 sm:p-6 text-white shadow-2xl mb-6" 
                        style="background: radial-gradient(ellipse at top right, #FD3801 0%, #011B63 40%, #000F3B 100%);">
                    
                    <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-[#FD3801]/30 rounded-full blur-2xl pointer-events-none"></div>

                    <div class="relative z-10 space-y-4">
                        <div class="flex items-center justify-between">
                            <a href="{{ url('/') }}" 
                                title="Kembali ke Beranda"
                                class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-white/10 hover:bg-white/20 text-white backdrop-blur-md border border-white/15 transition duration-200 hover:scale-105 shadow-2xs">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h7.5" />
                                </svg>
                            </a>

                            <div class="inline-flex items-center px-3.5 py-1.5 rounded-full bg-black/40 backdrop-blur-md border border-white/10 shadow-sm">
                                <span class="font-sporty font-black italic tracking-wider text-xs uppercase text-white">
                                    JEMBER TRAIL <span class="text-[#FD3801]">RUN</span> <span class="text-gray-300">2026</span>
                                </span>
                            </div>
                        </div>

                        <div class="text-center px-2 pt-1">
                            <h1 class="text-3xl sm:text-4xl font-black tracking-tight text-white mb-2">
                                Pembayaran Tiket
                            </h1>
                            <p class="text-xs sm:text-sm text-gray-200 max-w-sm mx-auto font-normal leading-relaxed opacity-85">
                                Selesaikan pembayaran Anda untuk mengamankan tiket Jember Trail Run 2026.
                            </p>
                        </div>

                        <!-- Stepper Progress Widget -->
                        <div class="bg-black/30 backdrop-blur-md rounded-2xl py-2 px-3.5 max-w-xs mx-auto shadow-xl border border-white/15">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2 opacity-80 cursor-pointer" onclick="showEditConfirmationModal()" title="Klik untuk edit data">
                                    <div class="flex items-center justify-center w-7 h-7 rounded-lg bg-emerald-500 text-white font-bold text-xs shadow-md shadow-emerald-500/30">
                                        ✓
                                    </div>
                                    <span class="text-xs font-semibold text-gray-200 underline decoration-dotted">Data Diri</span>
                                </div>

                                <div class="flex-1 mx-2.5 h-1 bg-gradient-to-r from-emerald-500 to-[#FD3801] rounded-full"></div>

                                <div class="flex items-center gap-2">
                                    <div class="flex items-center justify-center w-7 h-7 rounded-lg bg-[#FD3801] text-white font-black text-xs shadow-md shadow-[#FD3801]/40">
                                        2
                                    </div>
                                    <span class="text-xs font-extrabold text-white">Pembayaran</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Grid Content -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-start">

                    <!-- Ringkasan Pendaftaran -->
                    <div class="lg:col-span-5 flex flex-col gap-4">
                        <div class="bg-white/95 backdrop-blur-md rounded-2xl shadow-xl p-5 border border-gray-100 flex flex-col justify-between">
                            <div>
                                <div class="flex justify-between items-center mb-3">
                                    <h2 class="text-xs font-extrabold uppercase tracking-wider text-[#01217C]">Ringkasan Pendaftaran</h2>
                                    <button type="button" onclick="showEditConfirmationModal()" class="text-[10px] font-bold text-[#FD3801] hover:underline">
                                        Edit Data
                                    </button>
                                </div>

                                <div class="flex items-center gap-2.5 bg-gray-50/80 rounded-xl p-3 mb-4 border border-gray-100">
                                    <div class="w-9 h-9 rounded-full bg-[#FD3801]/10 border border-[#FD3801]/20 flex items-center justify-center text-[#FD3801] shrink-0 font-bold">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    </div>
                                    <div class="overflow-hidden">
                                        <h3 class="font-bold text-xs text-[#01217C] truncate">{{ $registration->full_name ?? 'Nama Peserta' }}</h3>
                                        <p class="text-[10px] text-gray-500 truncate">{{ $registration->email ?? 'email@domain.com' }}</p>
                                    </div>
                                </div>

                                <div class="space-y-2.5 text-xs border-b border-gray-100 pb-3.5 mb-3.5">
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-500 text-[11px]">Kategori</span>
                                        <span class="font-bold text-xs text-[#01217C]">{{ $registration->category ?? '10K Trail Run' }}</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-500 text-[11px]">Harga Tiket</span>
                                        <span class="font-medium text-xs text-[#000C28]" x-text="formatRupiah(basePrice)"></span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-500 text-[11px]">Biaya Admin</span>
                                        <span class="font-medium text-xs text-[#000C28]" x-text="activeTab === 'midtrans' ? formatRupiah(adminFee) : 'Rp0 (Gratis)'"></span>
                                    </div>
                                    <div class="flex justify-between items-center pt-2 border-t border-dashed border-gray-200">
                                        <span class="text-[#01217C] font-bold text-[11px]">Total Tagihan</span>
                                        <span class="font-extrabold text-sm text-[#FD3801]" x-text="formatRupiah(activeTab === 'midtrans' ? basePrice + adminFee : basePrice)"></span>
                                    </div>
                                </div>

                                <div class="pt-2 text-center border-t border-gray-100">
                                    <p class="text-[11px] text-gray-500 font-medium">
                                        Ada kesalahan data diri?
                                        <button type="button" 
                                                onclick="showEditConfirmationModal()" 
                                                class="font-bold text-[#FD3801] hover:text-[#ff4815] transition-all duration-200 hover:drop-shadow-[0_0_8px_rgba(253,56,1,0.6)] underline underline-offset-2 ml-0.5 cursor-pointer focus:outline-none">
                                            Edit data diri
                                        </button>
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- 3 Info Badges -->
                        <div class="grid grid-cols-3 gap-2">
                            <div class="bg-gray-50/80 rounded-xl p-2.5 border border-gray-100/80 flex flex-col items-center justify-center text-center">
                                <span class="text-[9px] font-extrabold uppercase tracking-wider text-gray-400 mb-0.5">Batas Waktu</span>
                                <span class="font-extrabold text-xs text-[#01217C]" x-text="activeTab === 'midtrans' ? '15 Menit' : '1x24 Jam'"></span>
                            </div>

                            <div class="bg-gray-50/80 rounded-xl p-2.5 border border-gray-100/80 flex flex-col items-center justify-center text-center">
                                <span class="text-[9px] font-extrabold uppercase tracking-wider text-gray-400 mb-0.5">Metode</span>
                                <span class="font-extrabold text-xs text-[#01217C]" x-text="activeTab === 'midtrans' ? 'QRIS' : 'Manual'"></span>
                            </div>

                            <div class="bg-gray-50/80 rounded-xl p-2.5 border border-gray-100/80 flex flex-col items-center justify-center text-center">
                                <span class="text-[9px] font-extrabold uppercase tracking-wider text-gray-400 mb-0.5">E-Ticket</span>
                                <span class="font-extrabold text-xs text-[#01217C]" x-text="activeTab === 'midtrans' ? 'Otomatis' : 'Verifikasi'"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Form Tab -->
                    <div class="lg:col-span-7 w-full">
                        <div class="bg-white/95 backdrop-blur-md rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            
                            <!-- Tab Header -->
                            <div class="flex border-b border-gray-100 bg-gray-50/60 p-1.5 gap-1.5">
                                <button 
                                    @click="if(midtransEnabled) activeTab = 'midtrans'" 
                                    :disabled="!midtransEnabled"
                                    :class="{
                                        'bg-white text-[#FD3801] font-extrabold shadow-sm rounded-xl': activeTab === 'midtrans',
                                        'text-gray-400 opacity-60 cursor-not-allowed': !midtransEnabled,
                                        'text-gray-500 hover:text-[#01217C] font-semibold': midtransEnabled && activeTab !== 'midtrans'
                                    }"
                                    class="flex-1 py-2.5 px-3 text-center text-xs transition-all outline-none flex flex-col items-center justify-center gap-0.5 rounded-xl">
                                    <span>Bayar Otomatis (QRIS)</span>
                                    <template x-if="midtransEnabled">
                                        <span class="text-[9px] bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded-md font-bold">Instan</span>
                                    </template>
                                    <template x-if="!midtransEnabled">
                                        <span class="text-[9px] bg-amber-100 text-amber-700 px-2 py-0.5 rounded-md font-bold">Maintenance</span>
                                    </template>
                                </button>

                                <button 
                                    @click="activeTab = 'manual'" 
                                    :class="activeTab === 'manual' ? 'bg-white text-[#FD3801] font-extrabold shadow-sm rounded-xl' : 'text-gray-500 hover:text-[#01217C] font-semibold'"
                                    class="flex-1 py-2.5 px-3 text-center text-xs transition-all outline-none flex flex-col items-center justify-center gap-0.5 rounded-xl">
                                    <span>Transfer Bank Manual</span>
                                    <span class="text-[9px] bg-gray-200/70 text-gray-700 px-2 py-0.5 rounded-md font-bold">Verifikasi 1x24 Jam</span>
                                </button>
                            </div>

                            <!-- Alert Midtrans -->
                            <template x-if="!midtransEnabled">
                                <div class="p-3.5 bg-amber-50/80 border-b border-amber-200/60 text-amber-900 text-xs flex items-center gap-2.5">
                                    <svg class="w-4 h-4 text-amber-600 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                    <span>Metode QRIS otomatis sedang pemeliharaan. Silakan gunakan <strong>Transfer Bank Manual</strong>.</span>
                                </div>
                            </template>

                            <!-- Tab Body -->
                            <div class="p-5 sm:p-6">
                                
                                <!-- TAB 1: MIDTRANS -->
                                <div x-show="activeTab === 'midtrans'" x-transition>
                                    <div class="mb-4">
                                        <h3 class="text-sm font-extrabold text-[#01217C]">Pembayaran QRIS Otomatis</h3>
                                        <p class="text-xs text-gray-500">Scan via Mobile Banking / E-Wallet favorit Anda.</p>
                                    </div>
                                    
                                    <div class="relative w-full min-h-[460px] rounded-xl bg-gray-50/60 border border-gray-200 overflow-hidden flex items-center justify-center">
                                        <div id="snap-loading" class="absolute inset-0 flex flex-col items-center justify-center bg-gray-50/90 z-10 transition-opacity">
                                            <div class="w-8 h-8 border-3 border-[#FD3801] border-t-transparent rounded-full animate-spin mb-2"></div>
                                            <span class="text-xs font-bold text-[#01217C]">Memuat QRIS Midtrans...</span>
                                        </div>
                                        <div id="snap-container" class="w-full h-full flex justify-center items-center"></div>
                                    </div>
                                </div>

                                <!-- TAB 2: MANUAL -->
                                <div x-show="activeTab === 'manual'" x-transition x-cloak>
                                    <h3 class="text-sm font-extrabold text-[#01217C] mb-1">Transfer Bank Manual</h3>
                                    <p class="text-xs text-gray-500 mb-4">Transfer tepat <b>Rp190.000</b> ke rekening resmi panitia.</p>
                                    
                                    <div class="bg-gray-50/80 p-4 rounded-xl border border-gray-200/80 mb-5 text-xs space-y-2">
                                        <div class="flex justify-between items-center">
                                            <span class="text-gray-500 font-medium">Total Transfer:</span>
                                            <span class="font-extrabold text-sm text-[#FD3801]">Rp190.000</span>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <span class="text-gray-500 font-medium">Bank Tujuan:</span>
                                            <span class="font-bold text-[#01217C]">BANK MANDIRI</span>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <span class="text-gray-500 font-medium">Nomor Rekening:</span>
                                            <span class="font-mono font-bold text-[#FD3801] bg-white px-2 py-0.5 rounded border border-gray-200 select-all">1710018413784</span>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <span class="text-gray-500 font-medium">Atas Nama:</span>
                                            <span class="font-bold text-[#01217C]">SITI UMMI NUR FADHILA</span>
                                        </div>
                                    </div>

                                    <form id="manual-payment-form" action="{{ url('/payment/manual/'.$registration->order_id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                        @csrf
                                        <div>
                                            <label for="payment_proof_input" class="block text-xs font-bold text-[#01217C] mb-1.5">
                                                Upload Bukti Transfer <span class="text-[#FD3801]">*</span>
                                            </label>
                                            <input type="file" name="payment_proof" id="payment_proof_input" required accept="image/jpeg, image/png" 
                                                class="w-full rounded-xl border border-gray-200 bg-gray-50/60 p-2 text-xs text-gray-700 file:mr-3 file:py-2 file:px-3.5 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-[#FD3801]/10 file:text-[#FD3801] hover:file:bg-[#FD3801]/20 transition cursor-pointer">
                                            <p class="text-[10px] text-gray-400 mt-1.5">*Format: JPG/PNG, Maksimal: 2MB.</p>
                                            <span id="manual-error-msg" class="text-red-500 text-[10px] font-medium mt-1 hidden"></span>
                                        </div>

                                        <button onclick="showCancelRegistrationModal('{{ $registration->order_id }}')" type="button" 
                                            class="w-full py-3.5 px-5 rounded-xl bg-gradient-to-r from-red-700 via-red-600 to-[#FD3801] text-white font-extrabold text-xs tracking-wide shadow-md hover:shadow-lg hover:scale-[1.005] active:scale-[0.995] transition duration-200 flex items-center justify-center gap-2">
                                            <span>Batalkan Pendaftaran</span>
                                        </button>

                                        <button type="submit" id="btn-submit-manual" 
                                            class="w-full py-3.5 px-5 rounded-xl bg-gradient-to-r from-[#01217C] via-[#01217C] to-[#FD3801] text-white font-extrabold text-xs tracking-wide shadow-md hover:shadow-lg hover:scale-[1.005] active:scale-[0.995] transition duration-200 flex items-center justify-center gap-2">
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
    </div>

    <style> [x-cloak] { display: none !important; } </style>
@endsection

@push('scripts')
    <!-- Script Midtrans Snap -->
    @if($midtransEnabled)
        <script type="text/javascript"
            src="{{ config('services.midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}"
            data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    @endif

    <script>
        window.addEventListener('pageshow', function (event) {
            var historyTraversal = event.persisted || 
                (typeof window.performance != 'undefined' && 
                window.performance.getEntriesByType("navigation")[0].type === "back_forward");

            if (historyTraversal) {
                // Jika user menekan tombol Back di browser, paksa halaman reload dari server
                window.location.reload();
            }
        });
        // Modal Konfirmasi Batalkan & Hapus Pendaftaran
        function showCancelRegistrationModal(orderId) {
            const overlay = document.createElement('div');
            overlay.style.cssText = 'position:fixed; inset:0; z-index:9999; background:rgba(0,12,40,0.85); display:flex; align-items:center; justify-content:center; backdrop-filter:blur(5px); font-family:sans-serif; padding:1rem; text-align:center;';

            const box = document.createElement('div');
            box.style.cssText = 'background:#ffffff; padding:1.75rem; border-radius:1.5rem; max-width:340px; width:100%; box-shadow:0 20px 25px -5px rgba(0,0,0,0.1);';

            box.innerHTML = `
                <div style="margin: 0 auto 1rem; width: 56px; height: 56px; background: #FEF2F2; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <svg style="width: 28px; height: 28px; color: #DC2626;" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </div>
                <h3 style="font-size:1.15rem; font-weight:800; color:#000C28; margin-bottom:0.5rem; letter-spacing:-0.025em;">Batalkan Pendaftaran?</h3>
                <p style="font-size:0.75rem; color:#4B5563; margin-bottom:1.5rem; line-height:1.5;">
                    Data pendaftaran dan NIK kamu akan dihapus permanen dari sistem. Kuota akan dibebaskan dan kamu harus mendaftar ulang dari awal jika ingin bergabung.
                </p>
                <div style="display:flex; gap:0.5rem;">
                    <button id="btn-modal-cancel" style="flex:1; padding:0.75rem; border-radius:0.75rem; background:#F3F4F6; color:#4B5563; font-weight:700; font-size:0.75rem; border:none; cursor:pointer;">Tidak</button>
                    <button id="btn-modal-confirm" style="flex:1; padding:0.75rem; border-radius:0.75rem; background:#DC2626; color:#ffffff; font-weight:800; font-size:0.75rem; border:none; cursor:pointer; box-shadow:0 4px 6px -1px rgba(220,38,38,0.3);">Ya, Batalkan</button>
                </div>
            `;

            overlay.appendChild(box);
            document.body.appendChild(overlay);

            box.querySelector('#btn-modal-cancel').onclick = () => overlay.remove();
            box.querySelector('#btn-modal-confirm').onclick = () => {
                const btnConfirm = box.querySelector('#btn-modal-confirm');
                btnConfirm.innerText = 'Memproses...';
                btnConfirm.disabled = true;

                // Nembak ke backend untuk hapus data berdasarkan orderId
                fetch(`/payment/${orderId}/cancel`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    overlay.remove();
                    if (data.status === 'success') {
                        // Lempar balik ke homepage/dashboard sesuai response backend
                        window.location.href = data.redirect_url;
                    } else {
                        alert('Gagal membatalkan pendaftaran.');
                    }
                })
                .catch(err => {
                    overlay.remove();
                    console.error('Error:', err);
                    alert('Terjadi kesalahan sistem.');
                });
            };
        }

        // Modal Konfirmasi Edit Data Registration
        function showEditConfirmationModal() {
            const cancelForm = document.getElementById('edit-data-regist');
            if (!cancelForm) return;

            const overlay = document.createElement('div');
            overlay.style.cssText = 'position:fixed; inset:0; z-index:9999; background:rgba(0,12,40,0.85); display:flex; align-items:center; justify-content:center; backdrop-filter:blur(5px); font-family:sans-serif; padding:1rem; text-align:center;';

            const box = document.createElement('div');
            box.style.cssText = 'background:#ffffff; padding:1.75rem; border-radius:1.5rem; max-width:340px; width:100%; box-shadow:0 20px 25px -5px rgba(0,0,0,0.1);';

            box.innerHTML = `
                <div style="margin: 0 auto 1rem; width: 56px; height: 56px; background: #FEF2F2; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <svg style="width: 28px; height: 28px; color: #DC2626;" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                    </svg>
                </div>
                <h3 style="font-size:1.15rem; font-weight:800; color:#000C28; margin-bottom:0.5rem; letter-spacing:-0.025em;">Edit Data Registration?</h3>
                <p style="font-size:0.75rem; color:#4B5563; margin-bottom:1.5rem; line-height:1.5;">
                    Pendaftaran saat ini akan dibatalkan agar Anda dapat memperbaiki data diri. Draft data sebelumnya akan otomatis terisi kembali di form.
                </p>
                <div style="display:flex; gap:0.5rem;">
                    <button id="btn-edit-cancel" style="flex:1; padding:0.75rem; border-radius:0.75rem; background:#F3F4F6; color:#4B5563; font-weight:700; font-size:0.75rem; border:none; cursor:pointer;">Batal</button>
                    <button id="btn-edit-confirm" style="flex:1; padding:0.75rem; border-radius:0.75rem; background:#DC2626; color:#ffffff; font-weight:800; font-size:0.75rem; border:none; cursor:pointer; box-shadow:0 4px 6px -1px rgba(220,38,38,0.3);">Ya, Edit Data</button>
                </div>
            `;

            overlay.appendChild(box);
            document.body.appendChild(overlay);

            box.querySelector('#btn-edit-cancel').onclick = () => overlay.remove();
            box.querySelector('#btn-edit-confirm').onclick = () => {
                overlay.remove();
                cancelForm.submit();
            };
        }

        // Modal Konfirmasi Sebelum Upload Bukti
        function showConfirmationModal(onConfirm) {
            const overlay = document.createElement('div');
            overlay.style.cssText = 'position:fixed; inset:0; z-index:9999; background:rgba(0,12,40,0.85); display:flex; align-items:center; justify-content:center; backdrop-filter:blur(5px); font-family:sans-serif; padding:1rem; text-align:center;';

            const box = document.createElement('div');
            box.style.cssText = 'background:#ffffff; padding:1.75rem; border-radius:1.5rem; max-width:340px; width:100%; box-shadow:0 20px 25px -5px rgba(0,0,0,0.1);';

            box.innerHTML = `
                <div style="margin: 0 auto 1rem; width: 56px; height: 56px; background: #EEF2FF; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <svg style="width: 28px; height: 28px; color: #01217C;" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M12 18h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 style="font-size:1.15rem; font-weight:800; color:#000C28; margin-bottom:0.5rem; letter-spacing:-0.025em;">Konfirmasi Pengiriman</h3>
                <p style="font-size:0.75rem; color:#4B5563; margin-bottom:1.5rem; line-height:1.5;">
                    Apakah data pendaftaran dan bukti transfer yang Anda unggah sudah benar?
                </p>
                <div style="display:flex; gap:0.5rem;">
                    <button id="btn-modal-cancel" style="flex:1; padding:0.75rem; border-radius:0.75rem; background:#F3F4F6; color:#4B5563; font-weight:700; font-size:0.75rem; border:none; cursor:pointer;">Cek Lagi</button>
                    <button id="btn-modal-confirm" style="flex:1; padding:0.75rem; border-radius:0.75rem; background:linear-gradient(to right, #01217C, #FD3801); color:#ffffff; font-weight:800; font-size:0.75rem; border:none; cursor:pointer; box-shadow:0 4px 6px -1px rgba(253,56,1,0.3);">Ya, Kirim</button>
                </div>
            `;

            overlay.appendChild(box);
            document.body.appendChild(overlay);

            box.querySelector('#btn-modal-cancel').onclick = () => overlay.remove();
            box.querySelector('#btn-modal-confirm').onclick = () => {
                overlay.remove();
                if (typeof onConfirm === 'function') onConfirm();
            };
        }

        // Modal Status Midtrans Dynamic (FIXED SCOPE QUERY)
        function showDynamicModal(type) {
            localStorage.removeItem('jtr_register_draft');
            
            const isSuccess = type === 'success';
            const bgColor = isSuccess ? '#10B981' : '#EF4444'; 
            const title = isSuccess ? 'Pembayaran Berhasil!' : 'Transaksi Gagal / Expired';
            const msg = isSuccess 
                ? 'Mohon tunggu, E-Ticket Anda sedang diproses ke sistem.' 
                : 'Waktu habis atau transaksi batal. Silakan mengulang pendaftaran kembali.';
                
            const targetUrl = isSuccess ? "{{ url('/') }}" : "{{ url('/register') }}";
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
                    <div class="modal-loading-bar" style="height:100%; width:100%; background:${bgColor}; transition:width 1s linear;"></div>
                </div>
                <p style="font-size:0.65rem; font-weight:700; color:#9CA3AF; text-transform:uppercase; letter-spacing:0.05em;">Kembali ke ${targetText} dalam <span class="modal-countdown-text" style="color:${bgColor};">10</span> detik...</p>
            `;
            
            overlay.appendChild(box);
            document.body.appendChild(overlay);

            let timeLeft = 10;
            const bar = box.querySelector('.modal-loading-bar');
            const text = box.querySelector('.modal-countdown-text');
            
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

        // Modal Sukses Transfer Manual
        function showManualSuccessModal() {
            localStorage.removeItem('jtr_register_draft');

            const overlay = document.createElement('div');
            overlay.style.cssText = 'position:fixed; inset:0; z-index:9999; background:rgba(0,12,40,0.85); display:flex; align-items:center; justify-content:center; backdrop-filter:blur(5px); font-family:sans-serif; padding:1rem; text-align:center;';

            const box = document.createElement('div');
            box.style.cssText = 'background:#ffffff; padding:2rem; border-radius:1.5rem; max-width:340px; width:100%; box-shadow:0 20px 25px -5px rgba(0,0,0,0.1);';

            box.innerHTML = `
                <div style="margin: 0 auto 1rem; width: 64px; height: 64px; background: #FEF3C7; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 6px -1px rgba(245, 158, 11, 0.2);">
                    <svg style="width: 32px; height: 32px; color: #D97706;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 style="font-size:1.2rem; font-weight:800; color:#000C28; margin-bottom:0.5rem;">Bukti Transfer Terkirim!</h3>
                <p style="font-size:0.75rem; color:#4B5563; margin-bottom:1.25rem; line-height:1.5;">
                    Terima kasih. Bukti pembayaran Anda telah berhasil diunggah. Tim kami sedang melakukan <b>verifikasi manual (maksimal 1x24 jam)</b>. E-Ticket akan dikirim ke email Anda.
                </p>
                <div style="background:#F3F4F6; border-radius:999px; height:6px; width:100%; overflow:hidden; margin-bottom:0.75rem;">
                    <div class="manual-bar" style="height:100%; width:100%; background:#D97706; transition:width 1s linear;"></div>
                </div>
                <p style="font-size:0.65rem; font-weight:700; color:#9CA3AF; text-transform:uppercase;">Kembali ke Halaman Utama dalam <span class="manual-countdown" style="color:#D97706;">10</span> detik...</p>
            `;

            overlay.appendChild(box);
            document.body.appendChild(overlay);

            let timeLeft = 10;
            const bar = box.querySelector('.manual-bar');
            const text = box.querySelector('.manual-countdown');

            const timer = setInterval(() => {
                timeLeft--;
                if (text) text.innerText = timeLeft;
                if (bar) bar.style.width = (timeLeft * 10) + '%';

                if (timeLeft <= 0) {
                    clearInterval(timer);
                    window.location.href = "{{ url('/') }}";
                }
            }, 1000);
        }

        // Eksekusi Submit Manual
        function executeManualSubmit(formElement) {
            const btn = document.getElementById('btn-submit-manual');
            const errorMsg = document.getElementById('manual-error-msg');
            errorMsg.classList.add('hidden');

            btn.disabled = true;
            btn.innerHTML = `
                <div class="w-3.5 h-3.5 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                <span>Mengirim Bukti...</span>
            `;

            const formData = new FormData(formElement);

            fetch(formElement.action, {
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
                }
            })
            .catch(err => {
                console.error('Upload error:', err);
                errorMsg.innerText = 'Gagal terhubung ke server. Periksa koneksi internet Anda dan coba lagi.';
                errorMsg.classList.remove('hidden');

                btn.disabled = false;
                btn.innerHTML = '<span>Kirim Bukti Transfer</span>';
            });
        }

        document.addEventListener("DOMContentLoaded", function() {
            var paymentStatus = "{{ $registration->payment_status }}";
            if (paymentStatus === 'paid') {
                showDynamicModal('success');
                return;
            }

            @if($midtransEnabled)
                var snapToken = "{{ $registration->snap_token }}";
                const loadingEl = document.getElementById('snap-loading');
                
                if (snapToken && typeof window.snap !== 'undefined') {
                    window.snap.embed(snapToken, {
                        embedId: 'snap-container',
                        onSuccess: function (result) {
                            fetch("{{ url('/payment/verify/'.$registration->order_id) }}", {
                                method: 'GET',
                                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                            })
                            .then(res => {
                                if (res.ok) {
                                    showDynamicModal('success');
                                } else {
                                    showDynamicModal('error');
                                }
                            })
                            .catch(() => {
                                showDynamicModal('error');
                            });
                        },
                        onPending: function (result) {},
                        onError: function (result) {
                            showDynamicModal('error');
                        },
                        onClose: function () {}
                    });

                    let checks = 0;
                    const checkSnapLoaded = setInterval(() => {
                        checks++;
                        const snapIframe = document.querySelector('#snap-container iframe');
                        if (snapIframe) {
                            if (loadingEl) {
                                loadingEl.style.opacity = '0';
                                setTimeout(() => loadingEl.remove(), 300);
                            }
                            clearInterval(checkSnapLoaded);
                        } else if (checks > 25) { 
                            clearInterval(checkSnapLoaded);
                            if (loadingEl) {
                                loadingEl.innerHTML = '<span class="text-xs font-bold text-red-500 text-center px-4">Gagal memuat QRIS. Silakan pilih metode Transfer Bank Manual.</span>';
                            }
                        }
                    }, 200);
                } else {
                    if (window.Alpine) {
                        const alpineEl = document.querySelector('[x-data]');
                        if (alpineEl && alpineEl._x_dataStack) {
                            alpineEl._x_dataStack[0].activeTab = 'manual';
                            alpineEl._x_dataStack[0].midtransEnabled = false;
                        }
                    }
                    if (loadingEl) {
                        loadingEl.innerHTML = '<span class="text-xs font-bold text-amber-600 text-center px-4">Layanan QRIS tidak dapat dimuat. Dialihkan ke Transfer Manual...</span>';
                    }
                }
            @endif

            const manualForm = document.getElementById('manual-payment-form');
            if (manualForm) {
                manualForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const fileInput = document.getElementById('payment_proof_input');
                    const errorMsg = document.getElementById('manual-error-msg');

                    if (!fileInput.files || fileInput.files.length === 0) {
                        errorMsg.innerText = 'Silakan pilih file bukti transfer terlebih dahulu.';
                        errorMsg.classList.remove('hidden');
                        return;
                    }

                    const file = fileInput.files[0];
                    if (file.size > 2 * 1024 * 1024) {
                        errorMsg.innerText = 'Ukuran file melebihi batas maksimal (2MB).';
                        errorMsg.classList.remove('hidden');
                        return;
                    }

                    showConfirmationModal(() => {
                        executeManualSubmit(manualForm);
                    });
                });
            }
        });
    </script>
@endpush