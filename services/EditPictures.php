<?php

class EditPictures
{
    public static function upload(string $fieldName): array
    {
        $targetDir = __DIR__ . '/uploads/';
        if (empty($_FILES[$fieldName]) || $_FILES[$fieldName]['error'] === UPLOAD_ERR_NO_FILE) {
            return ['path' => null, 'error' => null];
        }

        $file = $_FILES[$fieldName];

        if ($file['error'] !== UPLOAD_ERR_OK) {
            return ['path' => null, 'error' => 'Erreur lors du téléchargement du fichier.'];
        }

        $imageType = exif_imagetype($file['tmp_name']);
        if (!$imageType) {
            return ['path' => null, 'error' => "Le fichier n'est pas une image."];
        }

        $fileName = basename($file['name']);
        $targetDir = dirname(__DIR__) . '/uploads/';
        $targetPath = $targetDir . $fileName;

        // si le dossier est absent ou non accessible, on renvoie l'erreur
        if (!is_dir($targetDir)) {
            return ['path' => null, 'error' => "Le dossier uploads/ est introuvable."];
        }
        if (!is_writable($targetDir)) {
            return ['path' => null, 'error' => "Le dossier uploads/ n'est pas accessible en écriture."];
        }

        if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
            return ['path' => null, 'error' => "Impossible de déplacer l'image."];
        }

        return ['path' => 'uploads/' . $fileName, 'error' => null];
        
    }
}