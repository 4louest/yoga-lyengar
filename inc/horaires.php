<?php
/**
 * Chargement / sauvegarde du planning + helpers partagés.
 * Aucune dépendance : compatible hébergement mutualisé OVH (PHP natif).
 */

const HORAIRES_PATH = __DIR__ . '/../data/horaires.json';
const CONFIG_PATH   = __DIR__ . '/../config.php';

/** Échappement HTML pour tout affichage. */
function h(string $s): string
{
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

/** Structure vide par défaut (sert aussi de garde-fou). */
function horaires_defaults(): array
{
    return ['cours' => [], 'tarifs' => []];
}

/** Lit data/horaires.json et renvoie toujours un tableau valide. */
function load_horaires(): array
{
    $raw = @file_get_contents(HORAIRES_PATH);
    if ($raw === false) {
        return horaires_defaults();
    }
    $data = json_decode($raw, true);
    if (!is_array($data)) {
        return horaires_defaults();
    }
    return $data + horaires_defaults();
}

/**
 * Écrit le planning sur le disque (avec sauvegarde .bak et verrou).
 * Renvoie false si l'écriture échoue (droits insuffisants par ex.).
 */
function save_horaires(array $data): bool
{
    if (file_exists(HORAIRES_PATH)) {
        @copy(HORAIRES_PATH, HORAIRES_PATH . '.bak');
    }
    $json = json_encode(
        $data,
        JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
    );
    if ($json === false) {
        return false;
    }
    return file_put_contents(HORAIRES_PATH, $json . "\n", LOCK_EX) !== false;
}
