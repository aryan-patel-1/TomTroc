// Recherche côté client sur les titres des livres
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.querySelector('[data-search-books]');
    const bookLinks = document.querySelectorAll('[data-books-grid] .tt-book-link');
    const emptyMessage = document.querySelector('.tt-search-empty');

    if (!searchInput || !bookLinks.length) return;

    const form = searchInput.closest('form');

    // Normalisation de la chaîne : minuscules, sans accents, sans espaces inutiles
    const normalize = (value = '') => value
        .toLocaleLowerCase('fr')
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '')
        .trim();

    // Empêche l'envoi du formulaire
    if (form) {
        form.addEventListener('submit', (event) => event.preventDefault());
    }

    const updateBooks = () => {
        const query = normalize(searchInput.value);
        let visibleCount = 0;

        bookLinks.forEach((link) => {
            // On récupère le titre directement à chaque fois
            const rawTitle =
                link.dataset.title ||
                link.querySelector('.tt-book-card h3')?.textContent ||
                '';

            const matches = !query || normalize(rawTitle).includes(query);
            link.hidden = !matches;

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