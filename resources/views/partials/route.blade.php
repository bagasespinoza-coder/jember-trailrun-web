<section id="route" class="bg-[#E2E2E2] px-4 py-10 lg:py-16 lg:px-8">
    <div class="mx-auto max-w-[1000px]">
        
        <!-- Bagian Header & Deskripsi (Centered) -->
        <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-14r">
            <h2 class="mt-2 text-xl font-bold uppercase tracking-[-0.03em] text-[#000C28] sm:text-2xl lg:text-3xl">
                Explore The <span class="text-[#FD4801]">Route</span>
            </h2>
            <!-- Garis pemisah oranye kecil di bawah judul -->
            <div class="mx-auto mt-4 h-0.5 w-12 rounded-full bg-[#FD4801]"></div>
            
                        <p class="mt-3 text-sm leading-6 text-[#000C28] sm:text-base">
                Navigate through varying elevations and terrains designed to test your limits in the heart of Jember’s highlands.
            </p>
        </div>

        <!-- 3 Statistic Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-6">
            <!-- Card 1: Total Distance -->
            <div class="bg-[#011638] border border-gray-800 rounded-lg py-2.5 px-4 text-center shadow-md">
                <span class="block text-[10px] font-semibold tracking-wider text-gray-400 uppercase mb-0.5 font-race">Total Distance</span>
                <span id="stat-distance" class="text-xl sm:text-2xl font-normal text-orange-500 font-race">-- KM</span>
            </div>
            <!-- Card 2: Elevation Gain -->
            <div class="bg-[#011638] border border-gray-800 rounded-lg py-2.5 px-4 text-center shadow-md">
                <span class="block text-[10px] font-semibold tracking-wider text-gray-400 uppercase mb-0.5 font-race">Elevation Gain</span>
                <span id="stat-elevation" class="text-xl sm:text-2xl font-normal text-orange-500 font-race">+-- M</span>
            </div>
            <!-- Card 3: Difficulty -->
            <div class="bg-[#011638] border border-gray-800 rounded-lg py-2.5 px-4 text-center shadow-md">
                <span class="block text-[10px] font-semibold tracking-wider text-gray-400 uppercase mb-0.5 font-race">Difficulty</span>
                <span class="text-xl sm:text-2xl font-normal text-orange-500 font-race">Medium</span>
            </div>
        </div>

<!-- Large Dark Navy Course Card -->
        <div class="bg-[#011638] border border-gray-800 rounded-2xl p-6 sm:p-8 shadow-2xl">
            <!-- Header Kecil -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b border-gray-800 pb-4 mb-6 gap-2">
                <span class="text-xs font-bold tracking-widest text-[#E2E2E2] uppercase">10K Trail Run Jember</span>
                <div class="text-xs text-gray-400 space-x-3">
                </div>
            </div>

            <!-- Area Route/Map Besar -->
            <div class="relative w-full h-[320px] sm:h-[420px] rounded-xl overflow-hidden border border-gray-800 bg-[#00091d] mb-6">
                <div id="gpx-map" class="w-full h-full z-10"></div>
                <!-- Fallback jika gagal muat -->
                <div id="map-fallback" class="absolute inset-hidden flex items-center justify-center text-gray-400 text-sm hidden">
                    Route map is currently unavailable.
                </div>
            </div>

                        <!-- Elevation Profile Section -->
                <div class="w-full bg-[#000511] border border-gray-800/80 rounded-xl p-5 shadow-lg mb-8">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-3 gap-2">
                        <h3 class="text-xs font-bold tracking-wider text-gray-300 uppercase flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 17l6-6 4 4 8-8"></path>
                        </svg>
                        Elevation Profile
                        </h3>
                    <!-- Min/Max Elevation Display -->
                    <div class="text-xs text-gray-400 font-mono bg-[#011638] px-3 py-1 rounded-md border border-gray-800">
                        Min: <span id="min-elev" class="text-orange-400 font-semibold">-</span> | Max: <span id="max-elev" class="text-orange-400 font-semibold">-</span>
                    </div>
                </div>
                
                <!-- Bagan SVG  -->
            <div class="relative w-full h-[110px] sm:h-[130px] bg-[#00091d] rounded-lg p-2 border border-gray-800/60 overflow-hidden flex items-center justify-center">
                    <svg id="elevation-svg" class="w-full h-full overflow-visible" preserveAspectRatio="none"></svg>
                </div>
            </div>


            <!-- Location Badge & Action Buttons -->
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4 pt-2">
                <!-- Location Badge -->
                <div class="flex items-center space-x-2 text-gray-300 text-sm font-medium">
                    <svg class="w-5 h-5 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                    </svg>
                    <span>Jember, Jawa Timur, Indonesia</span>
                </div>

<!-- Buttons Group (View Start Point & Download GPX) -->
<div class="flex flex-col sm:flex-row gap-2.5 w-full sm:w-auto">
    <!-- View Start Point Button -->
    <a id="btn-view-start" href="#" target="_blank" rel="noopener noreferrer"
    class="inline-flex items-center justify-center px-4 py-2 bg-orange-600 hover:bg-orange-500 text-white text-xs font-semibold rounded-lg transition-all shadow-md hover:shadow-orange-500/20">
        VIEW START POINT
    </a>

<!-- Download GPX Button -->
    <a href="{{ asset('routes/trail-run-10k.gpx') }}" download="trail-run-10k.gpx" 
    class="inline-flex items-center justify-center px-4 py-2 bg-[#01217C] hover:bg-[#01217C]/80 border border-orange-500/30 text-white text-xs font-semibold rounded-lg transition-all">
        <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
        </svg>
        DOWNLOAD GPX
    </a>
</div>
            </div>
        </div>


        </div>

    </div>
</section>