// recherche côté client sur les titres des livres
document.addEventListener('DOMContentLoaded', () => {
  // 1 charger les éléments utiles
  const searchInput = document.querySelector('[data-search-books]');
  const bookLinks = Array.from(document.querySelectorAll('[data-books-grid] .tt-book-link'));
  const emptyMessage = document.querySelector('.tt-search-empty');

  // sécurité si rien à filtrer on stop
  if (!searchInput || bookLinks.length === 0) return;

  // 2 normaliser les textes pour comparer proprement
  // minuscule + suppression des accents + trim
  const normalize = (value = '') =>
    value
      .toLocaleLowerCase('fr')
      .normalize('NFD')
      .trim();

  // 3 créer un cache des titres normalisés
  // évite de refaire normalize sur chaque carte à chaque frappe
  const booksCache = bookLinks.map((link) => {
    const rawTitle =
      link.dataset.title ||
      link.querySelector('.tt-book-card h3')?.textContent ||
      '';

    return {
      link,
      normalizedTitle: normalize(rawTitle),
    };
  });

  // 4 empêcher l'envoi du formulaire avec entrée
  const form = searchInput.closest('form');
  if (form) form.addEventListener('submit', (e) => e.preventDefault());

  // 5 filtrer et afficher les résultats
  const updateBooks = () => {
    const query = normalize(searchInput.value);
    let visibleCount = 0;

    booksCache.forEach(({ link, normalizedTitle }) => {
      const matches = !query || normalizedTitle.includes(query);
      link.style.display = matches ? '' : 'none';
      if (matches) visibleCount += 1;
    });

    // 6 gérer le message aucun résultat
    if (emptyMessage) emptyMessage.hidden = visibleCount !== 0;
  };

  // 7 mise à jour en temps réel
  searchInput.addEventListener('input', updateBooks);

  // 8 état initial
  updateBooks();
});