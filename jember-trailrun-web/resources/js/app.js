import L from "leaflet";

document.addEventListener("DOMContentLoaded", function () {
    const navbar = document.querySelector("[data-navbar]");
    const mobileMenu = document.querySelector("[data-mobile-menu]");
    const menuOverlay = document.querySelector("[data-menu-overlay]");
    const toggleButton = document.querySelector("[data-menu-toggle]");
    const closeButton = document.querySelector("[data-menu-close]");

    // Tambahkan selektor untuk logo
    const logoWhite = document.getElementById("nav-logo-white");
    const logoBlack = document.getElementById("nav-logo-black");

    const updateNavbar = () => {
        if (window.scrollY > 24) {
            navbar.classList.add("bg-white", "shadow-sm");
            navbar.classList.remove("text-white");
            navbar.querySelectorAll("a").forEach((link) => {
                link.classList.add("text-[#000C28]");
                link.classList.remove("text-white");
            });

            if (logoWhite && logoBlack) {
                logoWhite.classList.remove("block");
                logoWhite.classList.add("hidden");
                logoBlack.classList.remove("hidden");
                logoBlack.classList.add("block");
            }
        } else {
            navbar.classList.remove("bg-white", "shadow-sm");
            navbar.querySelectorAll("a").forEach((link) => {
                link.classList.add("text-white");
                link.classList.remove("text-[#000C28]");
            });

            if (logoWhite && logoBlack) {
                logoWhite.classList.remove("hidden");
                logoWhite.classList.add("block");
                logoBlack.classList.remove("block");
                logoBlack.classList.add("hidden");
            }
        }
    };

    const openMenu = () => {
        mobileMenu.classList.remove("-translate-x-full");
        menuOverlay.classList.remove("hidden");
    };

    const closeMenu = () => {
        mobileMenu.classList.add("-translate-x-full");
        menuOverlay.classList.add("hidden");
    };

    toggleButton?.addEventListener("click", openMenu);
    closeButton?.addEventListener("click", closeMenu);
    menuOverlay?.addEventListener("click", closeMenu);
    window.addEventListener("scroll", updateNavbar);
    updateNavbar();

    if (mobileMenu) {
        const mobileLinks = mobileMenu.querySelectorAll("a");
        mobileLinks.forEach((link) => {
            link.addEventListener("click", () => {
                closeMenu();
            });
        });
    }

    // ==========================================
    // INTERACTIVE GPX MAP & ELEVATION PROFILE
    // ==========================================
    const mapContainer = document.getElementById("gpx-map");
    if (mapContainer) {
        const map = L.map("gpx-map", {
            zoomControl: false,
            attributionControl: false,
        }).setView([-8.1331, 113.7494], 13);

        L.control.zoom({ position: "topright" }).addTo(map);

        L.tileLayer(
            "https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png",
            {
                maxZoom: 19,
                subdomains: "abcd",
            },
        ).addTo(map);

        fetch("/routes/trail-run-10k.gpx")
            .then((response) => {
                if (!response.ok)
                    throw new Error("Network response was not ok");
                return response.text();
            })
            .then((data) => {
                const parser = new DOMParser();
                const xmlDoc = parser.parseFromString(data, "text/xml");

                const trackPoints = xmlDoc.getElementsByTagName("trkpt");
                if (trackPoints.length === 0)
                    throw new Error("No track points found in GPX");

                let latLngs = [];
                let elevations = [];
                let totalDistance = 0;
                let elevationGain = 0;

                for (let i = 0; i < trackPoints.length; i++) {
                    const pt = trackPoints[i];
                    const lat = parseFloat(pt.getAttribute("lat"));
                    const lon = parseFloat(pt.getAttribute("lon"));
                    const eleEl = pt.getElementsByTagName("ele")[0];
                    const ele = eleEl ? parseFloat(eleEl.textContent) : 0;

                    latLngs.push([lat, lon]);
                    elevations.push(ele);

                    if (i > 0) {
                        const prevLat = latLngs[i - 1][0];
                        const prevLon = latLngs[i - 1][1];
                        totalDistance += getDistanceFromLatLonInKm(
                            prevLat,
                            prevLon,
                            lat,
                            lon,
                        );

                        const eleDiff = ele - elevations[i - 1];
                        if (eleDiff > 0) {
                            elevationGain += eleDiff;
                        }
                    }
                }

                // Update Statistic Cards
                const distEl = document.getElementById("stat-distance");
                const eleEl = document.getElementById("stat-elevation");

                if (distEl)
                    distEl.textContent = totalDistance.toFixed(2) + " KM";
                if (eleEl)
                    eleEl.textContent = "+" + Math.round(elevationGain) + " M";

                // Render Route Polyline (Orange Accent)
                const routePolyline = L.polyline(latLngs, {
                    color: "#f97316",
                    weight: 4,
                    opacity: 0.9,
                    smoothFactor: 1.2,
                }).addTo(map);

                map.fitBounds(routePolyline.getBounds(), { padding: [40, 40] });

                // Start & Finish Markers
                const startPoint = latLngs[0];
                const endPoint = latLngs[latLngs.length - 1];

                const startIcon = L.divIcon({
                    className: "custom-marker",
                    html: '<div style="background-color: #22c55e; color: white; font-size: 9px; font-weight: bold; padding: 3px 6px; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.4); white-space: nowrap;">START</div>',
                    iconSize: [40, 20],
                    iconAnchor: [20, 10],
                });

                const finishIcon = L.divIcon({
                    className: "custom-marker",
                    html: '<div style="background-color: #ef4444; color: white; font-size: 9px; font-weight: bold; padding: 3px 6px; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.4); white-space: nowrap;">FINISH</div>',
                    iconSize: [45, 20],
                    iconAnchor: [20, 10],
                });

                L.marker(startPoint, { icon: startIcon }).addTo(map);
                L.marker(endPoint, { icon: finishIcon }).addTo(map);

                // Render Elevation Profile SVG
                renderElevationSvg(elevations);
            })
            .catch((error) => {
                console.error("Error loading GPX:", error);
                const fallback = document.getElementById("map-fallback");
                if (fallback) fallback.classList.remove("hidden");
            });
    }
});

// Helper Haversine untuk kalkulasi jarak
function getDistanceFromLatLonInKm(lat1, lon1, lat2, lon2) {
    const R = 6371;
    const dLat = deg2rad(lat2 - lat1);
    const dLon = deg2rad(lon2 - lon1);
    const a =
        Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos(deg2rad(lat1)) *
            Math.cos(deg2rad(lat2)) *
            Math.sin(dLon / 2) *
            Math.sin(dLon / 2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    return R * c;
}

function deg2rad(deg) {
    return deg * (Math.PI / 180);
}

// Render Elevation Profile menggunakan SVG murni (Zero-dependency)
function renderElevationSvg(elevations) {
    const svg = document.getElementById("elevation-svg");
    if (!svg || elevations.length === 0) return;

    const width = 800;
    const height = 120;
    svg.setAttribute("viewBox", `0 0 ${width} ${height}`);

    const minEle = Math.min(...elevations);
    const maxEle = Math.max(...elevations);
    const midEle = Math.round((minEle + maxEle) / 2);

    // Update teks info Min & Max di HTML
    const minEleEl = document.getElementById("min-elev");
    const maxEleEl = document.getElementById("max-elev");
    if (minEleEl) minEleEl.textContent = Math.round(minEle) + "M";
    if (maxEleEl) maxEleEl.textContent = Math.round(maxEle) + "M";

    const padding = 20;
    const innerHeight = height - padding * 2;
    const innerWidth = width;
    const rangeEle = maxEle - minEle || 1;

    let points = "";
    const step = innerWidth / (elevations.length - 1);

    elevations.forEach((ele, index) => {
        const x = index * step;
        const y = height - padding - ((ele - minEle) / rangeEle) * innerHeight;
        points += `${x},${y} `;
    });

    const firstX = 0;
    const lastX = innerWidth;
    const bottomY = height;
    const polygonPoints = `${firstX},${bottomY} ${points} ${lastX},${bottomY}`;

    // Render SVG dengan tambahan garis grid tipis dan elemen hover
    svg.innerHTML = `
        <defs>
            <linearGradient id="eleGrad" x1="0%" y1="0%" x2="0%" y2="100%">
                <stop offset="0%" stop-color="#f97316" stop-opacity="0.4"/>
                <stop offset="100%" stop-color="#f97316" stop-opacity="0.0"/>
            </linearGradient>
        </defs>
        
        <!-- Garis Grid Horizontal Tipis (Background) -->
        <line x1="0" y1="${padding}" x2="${width}" y2="${padding}" stroke="#334155" stroke-dasharray="4" stroke-width="0.5" opacity="0.5"/>
        <line x1="0" y1="${height / 2}" x2="${width}" y2="${height / 2}" stroke="#334155" stroke-dasharray="4" stroke-width="0.5" opacity="0.5"/>
        <line x1="0" y1="${height - padding}" x2="${width}" y2="${height - padding}" stroke="#334155" stroke-dasharray="4" stroke-width="0.5" opacity="0.5"/>

        <!-- Label Angka Grid di dalam SVG (Opsional) -->
        <text x="5" y="${padding - 4}" fill="#64748b" font-size="8" font-family="monospace">${Math.round(maxEle)}m</text>
        <text x="5" y="${height - padding + 10}" fill="#64748b" font-size="8" font-family="monospace">${Math.round(minEle)}m</text>

        <!-- Grafik Utama -->
        <polygon points="${polygonPoints}" fill="url(#eleGrad)" />
        <polyline fill="none" stroke="#f97316" stroke-width="2.5" points="${points}" />

        <!-- Garis Indikator Hover (Awalnya disembunyikan) -->
        <g id="hover-group" style="display: none;">
            <line id="hover-line" x1="0" y1="0" x2="0" y2="${height}" stroke="#ffffff" stroke-width="1" stroke-dasharray="2"/>
            <circle id="hover-circle" cx="0" cy="0" r="4" fill="#f97316" stroke="#ffffff" stroke-width="1.5"/>
        </g>
    `;

    // Tambahkan Event Listener untuk Interaksi Hover Mouse
    svg.onmousemove = function (evt) {
        const rect = svg.getBoundingClientRect();
        const mouseX = ((evt.clientX - rect.left) / rect.width) * width;

        // Cari index data terdekat berdasarkan posisi X kursor
        const index = Math.min(
            Math.max(0, Math.round(mouseX / step)),
            elevations.length - 1,
        );
        const currentEle = elevations[index];
        const cx = index * step;
        const cy =
            height - padding - ((currentEle - minEle) / rangeEle) * innerHeight;

        const hoverGroup = document.getElementById("hover-group");
        const hoverLine = document.getElementById("hover-line");
        const hoverCircle = document.getElementById("hover-circle");

        if (hoverGroup && hoverLine && hoverCircle) {
            hoverGroup.style.display = "block";
            hoverLine.setAttribute("x1", cx);
            hoverLine.setAttribute("x2", cx);
            hoverCircle.setAttribute("cx", cx);
            hoverCircle.setAttribute("cy", cy);
        }

        // Jika Anda ingin menampilkan informasi dinamis saat hover di teks Min/Max atau elemen lain:
        if (maxEleEl)
            maxEleEl.textContent = Math.round(currentEle) + "M (Hover)";
    };

    svg.onmouseleave = function () {
        const hoverGroup = document.getElementById("hover-group");
        if (hoverGroup) hoverGroup.style.display = "none";
        // Kembalikan teks Max ke nilai semula
        if (maxEleEl) maxEleEl.textContent = Math.round(maxEle) + "M";
    };
}

fetch("/routes/trail-run-10k.gpx")
    .then((response) => {
        if (!response.ok) throw new Error("Network response was not ok");
        return response.text();
    })
    .then((data) => {
        const parser = new DOMParser();
        const xmlDoc = parser.parseFromString(data, "text/xml");

        const trackPoints = xmlDoc.getElementsByTagName("trkpt");
        if (trackPoints.length === 0)
            throw new Error("No track points found in GPX");

        const latlngs = [];
        const elevations = [];

        for (let i = 0; i < trackPoints.length; i++) {
            const lat = parseFloat(trackPoints[i].getAttribute("lat"));
            const lon = parseFloat(trackPoints[i].getAttribute("lon"));
            latlngs.push([lat, lon]);

            const eleTag = trackPoints[i].getElementsByTagName("ele")[0];
            elevations.push(eleTag ? parseFloat(eleTag.textContent) : 0);
        }

        // --- 1. AMBIL TITIK PERTAMA SEBAGAI START ---
        const startPoint = latlngs[0];

        // --- 2. SET URL GOOGLE MAPS KETIKA STARTPOINT SUDAH PASTI ADA ---
        const btnViewStart = document.getElementById("btn-view-start");
        if (btnViewStart && startPoint) {
            const startLat = startPoint[0];
            const startLng = startPoint[1];
            const googleMapsUrl = `https://www.google.com/maps?q=${startLat},${startLng}`;

            btnViewStart.href = googleMapsUrl;
            btnViewStart.setAttribute("target", "_blank");
            btnViewStart.setAttribute("rel", "noopener noreferrer");
            btnViewStart.style.opacity = "1";
            btnViewStart.style.pointerEvents = "auto";
            btnViewStart.onclick = null;
        }

        // ... (lanjutan kode render map, polyline, marker, dan elevation chart Anda di sini) ...
    })
    .catch((error) => {
        console.error("Error loading GPX:", error);
        document.getElementById("map-fallback")?.classList.remove("hidden");
    });
