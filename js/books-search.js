// Recherche côté client sur les titres des livres
// Tout le script est exécuté une fois que le DOM est entièrement chargé
document.addEventListener('DOMContentLoaded', () => {

    // Champ input utilisé pour la recherche (via attribut data-search-books)
    const searchInput = document.querySelector('[data-search-books]');

    // Liste de tous les liens de livres présents dans la grille
    // Array.from permet d'obtenir un vrai tableau pour utiliser map / forEach
    const bookLinks = Array.from(
        document.querySelectorAll('[data-books-grid] .tt-book-link')
    );

    // Message affiché lorsque aucun résultat n’est trouvé
    const emptyMessage = document.querySelector('.tt-search-empty');

    // Sécurité : si le champ de recherche n’existe pas
    // ou s’il n’y a aucun livre à filtrer, on arrête le script
    if (!searchInput || bookLinks.length === 0) return;

    // Récupération du formulaire de l’input 
    const form = searchInput.closest('form');

    // Fonction de normalisation d’une chaîne de caractères
    //Permet de comparer les titres et la recherche utilisateur
    const normalize = (value = '') => value
        // Passage en minuscule
        .toLocaleLowerCase('fr')
        // Décomposition (é → e)
        .normalize('NFD')
        // Suppression des espaces inutiles en début et fin
        .trim();

    // Création d’un cache des livres
    // pour éviter de recalculer la normalisation à chaque frappe clavier
    const booksCache = bookLinks.map((link) => {

        // Récupération du titre brut du livre :
        // depuis un data-attribute si présent
        // sinon depuis le h3 de la carte
        // sinon chaîne vide par sécurité
        const rawTitle =
            link.dataset.title ||
            link.querySelector('.tt-book-card h3')?.textContent ||
            '';

        // On retourne un objet contenant :
        // - le lien du livre
        // - le titre déjà normalisé
        return {
            link,
            normalizedTitle: normalize(rawTitle),
        };
    });

    // Empêche l’envoi du formulaire lorsqu’on appuie sur Entrée
    if (form) {
        form.addEventListener('submit', (event) => event.preventDefault());
    }

    // Fonction de filtrage des livres
    const updateBooks = () => {

        // Normalisation de la valeur saisie par l’utilisateur
        const query = normalize(searchInput.value);

        // Compteur de livres visibles ( si aucun résultat )
        let visibleCount = 0;

        // Parcours de tous les livres en cache
        booksCache.forEach(({ link, normalizedTitle }) => {

            // Un livre est affiché si :
            // - la recherche est vide
            // - ou si le titre contient la recherche
            const matches = !query || normalizedTitle.includes(query);

            // Affichage ou masquage du livre
            link.style.display = matches ? '' : 'none';

            // Incrémentation du compteur si le livre est visible
            if (matches) visibleCount += 1;
        });

        // Gestion de l’affichage du message aucun résultat
        if (emptyMessage) {
            // Le message est visible uniquement si aucun livre ne correspond
            emptyMessage.hidden = visibleCount !== 0;
        }
    };

    // Mise à jour de la liste à chaque frappe dans la barre de recherche
    searchInput.addEventListener('input', updateBooks);

    // Exécution au chargement de la page
    updateBooks();
});