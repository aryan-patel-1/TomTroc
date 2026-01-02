// attend que le DOM soit prêt avant d'initialiser le menu
document.addEventListener('DOMContentLoaded', () => {
    // récupère les éléments clés du header et le breakpoint mobile
    const header = document.querySelector('[data-header]');
    const toggle = document.querySelector('[data-header-toggle]');
    const navWrapper = document.querySelector('[data-header-nav]');
    const MOBILE_BREAKPOINT = 900;

    // si un des éléments est absent, on arrête
    if (!header || !toggle || !navWrapper) {
        return;
    }

    // ferme le menu burger et met à jour aria
    const closeMenu = () => {
        header.classList.remove('is-open');
        toggle.setAttribute('aria-expanded', 'false');
    };

    // toggle du menu au clic sur le burger
    toggle.addEventListener('click', () => {
        const isOpen = header.classList.toggle('is-open');
        toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });

    // ferme le menu quand on clique sur un lien
    navWrapper.addEventListener('click', (event) => {
        if (event.target instanceof HTMLAnchorElement) {
            closeMenu();
        }
    });

    // ferme le menu si on repasse au-dessus du breakpoint
    window.addEventListener('resize', () => {
        if (window.innerWidth > MOBILE_BREAKPOINT && header.classList.contains('is-open')) {
            closeMenu();
        }
    });
});