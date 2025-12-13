// Recherche côté client sur les titres des livres
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.querySelector('[data-search-books]');
    const bookLinks = Array.from(document.querySelectorAll('[data-books-grid] .tt-book-link'));
    const emptyMessage = document.querySelector('.tt-search-empty');

    if (!searchInput || bookLinks.length === 0) return;

    const form = searchInput.closest('form');

    // Normalisation de la chaîne : minuscules, sans accents, sans espaces inutiles
    const normalize = (value = '') => value
        .toLocaleLowerCase('fr')
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '')
        .trim();

    // Cache des titres normalisés pour éviter de recalculer à chaque frappe
    const booksCache = bookLinks.map((link) => {
        const rawTitle = link.dataset.title
            || link.querySelector('.tt-book-card h3')?.textContent
            || '';

        return {
            link,
            normalizedTitle: normalize(rawTitle),
        };
    });

    // Empêche l'envoi du formulaire
    if (form) {
        form.addEventListener('submit', (event) => event.preventDefault());
    }

    const updateBooks = () => {
        const query = normalize(searchInput.value);
        let visibleCount = 0;

        booksCache.forEach(({ link, normalizedTitle }) => {
            const matches = !query || normalizedTitle.includes(query);
            link.style.display = matches ? '' : 'none';

            if (matches) visibleCount += 1;
        });

        if (emptyMessage) {
            emptyMessage.hidden = visibleCount !== 0;
        }
    };

    // Mise à jour à chaque frappe
    searchInput.addEventListener('input', updateBooks);

    // Premier passage pour l'état initial
    updateBooks();
});