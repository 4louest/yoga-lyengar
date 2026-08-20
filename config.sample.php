<?php
/**
 * Modèle de configuration.
 *
 * NE PAS éditer ce fichier à la main pour la mise en production :
 * au tout premier accès à admin.php, une page « Première configuration »
 * vous demande un mot de passe et génère automatiquement config.php
 * (avec un hash sécurisé). config.php est ignoré par Git (.gitignore).
 *
 * Ce modèle sert uniquement de documentation sur le format attendu.
 */

return [
    // Hash généré via password_hash('votre-mot-de-passe', PASSWORD_DEFAULT)
    'admin_password_hash' => '$2y$10$exempledehasharemplacerparunvraihashgenereparphp',
];
