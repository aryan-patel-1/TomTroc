<?php

class FormUserAccountValidator
{
    /**
     * Valide les champs du formulaire de compte utilisateur.
     *
     * @param string $username    Pseudo saisi
     * @param string $email       Email saisi
     * @param array  $upload      Résultat de l'upload (path/error)
     * @param string $newPassword Nouveau mot de passe (optionnel)
     *
     * @return array{isValid: bool, error: ?string}
     */
    public static function validate(string $username, string $email, array $upload, string $newPassword = ''): array
    {
        if ($username === '' || $email === '') {
            return ['isValid' => false, 'error' => 'Pseudo et email sont obligatoires'];
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['isValid' => false, 'error' => 'Adresse email invalide'];
        }

        if (!empty($upload['error'])) {
            return ['isValid' => false, 'error' => $upload['error']];
        }

        return ['isValid' => true, 'error' => null];
    }
}