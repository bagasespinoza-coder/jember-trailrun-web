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
    const rangeEle = maxEle - minEle || 1;

    const padding = 15;
    const innerHeight = height - padding * 2;
    const innerWidth = width;

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

    svg.innerHTML = `
        <defs>
            <linearGradient id="eleGrad" x1="0%" y1="0%" x2="0%" y2="100%">
                <stop offset="0%" stop-color="#f97316" stop-opacity="0.3"/>
                <stop offset="100%" stop-color="#f97316" stop-opacity="0.0"/>
            </linearGradient>
        </defs>
        <polygon points="${polygonPoints}" fill="url(#eleGrad)" />
        <polyline fill="none" stroke="#f97316" stroke-width="2.5" points="${points}" />
    `;
}
