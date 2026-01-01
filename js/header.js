document.addEventListener('DOMContentLoaded', () => {
    const header = document.querySelector('[data-header]');
    const toggle = document.querySelector('[data-header-toggle]');
    const navWrapper = document.querySelector('[data-header-nav]');
    const MOBILE_BREAKPOINT = 900;

    if (!header || !toggle || !navWrapper) {
        return;
    }

    const closeMenu = () => {
        header.classList.remove('is-open');
        toggle.setAttribute('aria-expanded', 'false');
    };

    toggle.addEventListener('click', () => {
        const isOpen = header.classList.toggle('is-open');
        toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });

    navWrapper.addEventListener('click', (event) => {
        if (event.target instanceof HTMLAnchorElement) {
            closeMenu();
        }
    });

    window.addEventListener('resize', () => {
        if (window.innerWidth > MOBILE_BREAKPOINT && header.classList.contains('is-open')) {
            closeMenu();
        }
    });
});
