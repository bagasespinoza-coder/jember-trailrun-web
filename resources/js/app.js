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

            // Ubah logo ke hitam saat di-scroll
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

            // Kembalikan logo ke putih saat di posisi paling atas
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
});
