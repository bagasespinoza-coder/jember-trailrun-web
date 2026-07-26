document.addEventListener('DOMContentLoaded', function () {
    const navbar = document.querySelector('[data-navbar]');
    const mobileMenu = document.querySelector('[data-mobile-menu]');
    const menuOverlay = document.querySelector('[data-menu-overlay]');
    const toggleButton = document.querySelector('[data-menu-toggle]');
    const closeButton = document.querySelector('[data-menu-close]');

    const updateNavbar = () => {
        if (window.scrollY > 24) {
            navbar.classList.add('bg-white', 'shadow-sm');
            navbar.classList.remove('text-white');
            navbar.querySelectorAll('a').forEach((link) => {
                link.classList.add('text-[#000C28]');
                link.classList.remove('text-white');
            });
        } else {
            navbar.classList.remove('bg-white', 'shadow-sm');
            navbar.querySelectorAll('a').forEach((link) => {
                link.classList.add('text-white');
                link.classList.remove('text-[#000C28]');
            });
        }
    };

    const openMenu = () => {
        mobileMenu.classList.remove('-translate-x-full');
        menuOverlay.classList.remove('hidden');
    };

    const closeMenu = () => {
        mobileMenu.classList.add('-translate-x-full');
        menuOverlay.classList.add('hidden');
    };

    toggleButton?.addEventListener('click', openMenu);
    closeButton?.addEventListener('click', closeMenu);
    menuOverlay?.addEventListener('click', closeMenu);
    window.addEventListener('scroll', updateNavbar);
    updateNavbar();
});

