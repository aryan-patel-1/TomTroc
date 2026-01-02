// attend que le DOM soit prêt pour manipuler les éléments
document.addEventListener('DOMContentLoaded', () => {
    // fonction utilitaire pour lier un input file à une image cible
    const bindPreview = (input, targetImg) => {
        // si l'input ou l'image est manquant on arrête
        if (!input || !targetImg) return;
        // écoute le changement de fichier
        input.addEventListener('change', () => {
            // récupère le premier fichier sélectionné
            const file = input.files?.[0];
            // si aucun fichier on arrête
            if (!file) return;
            // crée une URL temporaire pour prévisualiser
            const previewUrl = URL.createObjectURL(file);
            // met à jour la source de l'image
            targetImg.src = previewUrl;
            // libère l'URL une fois l'image chargée
            targetImg.onload = () => URL.revokeObjectURL(previewUrl);
        });
    };

    // input et image pour l'avatar du compte
    const avatarInput = document.querySelector('#avatar_file');
    const avatarImg = document.querySelector('.tt-account-avatar img');
    bindPreview(avatarInput, avatarImg);

    // input et image pour la couverture de livre
    const coverInput = document.querySelector('#cover_file');
    const coverImg = document.querySelector('.tt-book-edit-cover img');
    bindPreview(coverInput, coverImg);
});