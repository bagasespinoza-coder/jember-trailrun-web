@extends('layouts.app')

@section('content')
<main class="py-10 bg-[#E2E2E2] min-h-screen flex items-center justify-center text-[#000C28]">
    <div class="bg-white rounded-xl shadow-md p-6 max-w-md w-full mx-4 border border-gray-100">
        
        <h2 class="text-lg font-black text-center text-[#000C28] mb-1">Transfer Manual</h2>
        <p class="text-xs text-center text-gray-500 mb-6">Order ID: {{ $registration->order_id }}</p>

        <!-- Info Rekening -->
        <div class="bg-[#F5F7FA] p-4 rounded-lg border border-gray-200 mb-6 text-center">
            <p class="text-[11px] text-gray-500 uppercase tracking-widest mb-1">Transfer Tepat Sesuai Nominal</p>
            <p class="text-2xl font-black text-[#FD4801] mb-3">Rp{{ number_format($registration->gross_amount, 0, ',', '.') }}</p>
            
            <div class="bg-white border border-gray-200 rounded p-3 text-sm">
                <p class="font-bold text-[#000C28]">BCA - 1234567890</p>
                <p class="text-xs text-gray-500">a.n Panitia Jember 10K</p>
            </div>
        </div>

        <!-- Form Upload -->
        <form action="{{ route('payment.manual.process', $registration->order_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-5">
                <label class="block text-xs font-bold text-[#000C28] mb-2">Upload Bukti Transfer</label>
                <input type="file" name="payment_proof" accept="image/png, image/jpeg, image/jpg" required
                    class="block w-full text-xs text-gray-500 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-l-lg file:border-0 file:text-xs file:font-semibold file:bg-[#000C28] file:text-white hover:file:bg-gray-800 transition">
                @error('payment_proof')
                    <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p>
                @enderror
                <p class="text-[10px] text-gray-400 mt-1">*Format: JPG/PNG, Maksimal: 2MB.</p>
            </div>

            <button type="submit" class="w-full bg-[#FD4801] hover:bg-[#e03f00] text-white font-bold py-2.5 rounded-lg text-sm transition">
                Kirim Bukti Pembayaran
            </button>
        </form>

    </div>
</main>
@endsection