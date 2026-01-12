<?php

class EditPictures
{
    public static function upload(string $fieldName): array
    {
        // 1 vérifier que le champ existe
        if (empty($_FILES[$fieldName]) || ($_FILES[$fieldName]['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
            return ['path' => null, 'error' => null];
        }

        $file = $_FILES[$fieldName];

        // 2 vérifier les erreurs php d'upload
        if (($file['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
            return ['path' => null, 'error' => "Erreur lors du téléchargement du fichier."];
        }

        // 3 vérifier le dossier uploads
        $targetDir = dirname(__DIR__) . '/uploads/';
        if (!is_dir($targetDir)) {
            return ['path' => null, 'error' => "Le dossier uploads/ est introuvable."];
        }
        if (!is_writable($targetDir)) {
            return ['path' => null, 'error' => "Le dossier uploads/ n'est pas accessible en écriture."];
        }

        // 4 limiter la taille
        $maxSize = 2 * 1024 * 1024; // 2 mo
        if (($file['size'] ?? 0) > $maxSize) {
            return ['path' => null, 'error' => "Image trop volumineuse."];
        }

        // 5 vérifier que c'est une vraie image
        // exif_imagetype lit le contenu réel du fichier
        $imageType = @exif_imagetype($file['tmp_name']);
        if (!$imageType) {
            return ['path' => null, 'error' => "Le fichier n'est pas une image."];
        }

        // 6 autoriser seulement certains formats
        $allowed = [
            IMAGETYPE_JPEG => 'jpg',
            IMAGETYPE_PNG  => 'png',
            IMAGETYPE_WEBP => 'webp',
        ];

        if (!isset($allowed[$imageType])) {
            return ['path' => null, 'error' => "Format d'image non autorisé."];
        }

        // 7 renommer le fichier pour éviter collisions et noms dangereux
        $ext = $allowed[$imageType];
        $safeName = bin2hex(random_bytes(16)) . '.' . $ext;
        $targetPath = $targetDir . $safeName;

        // 8 déplacer le fichier
        if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
            return ['path' => null, 'error' => "Impossible de déplacer l'image."];
        }

        // 9 retourner un chemin relatif exploitable dans l'app
        return ['path' => 'uploads/' . $safeName, 'error' => null];
    }
}