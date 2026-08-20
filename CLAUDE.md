# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Vue d'ensemble

Site vitrine (landing page) pour un studio de **yoga Iyengar® à Valence** (Salle Parallèle, 82 rue Génissieux). Contenu en français. La proposition de design retenue par le client (« proposition 1 ») est désormais le site de production, servi par **PHP** : le HTML est dans `index.php`, le CSS dans `css/style.css`, et les données du planning sont externalisées en JSON et éditables via une interface d'admin. Cible d'hébergement : **mutualisé OVH** (PHP natif, pas de Node, pas de build) → priorité légèreté + SEO.

## Lancer / prévisualiser

Pas de `package.json`, pas de build, pas de tests. Le site n'est plus du HTML pur → il faut PHP.

Avec **Docker** (recommandé, rien à installer) :

```sh
docker compose up        # puis http://localhost:8000/index.php
```

Ou avec un **PHP local** :

```sh
php -S localhost:8000    # puis http://localhost:8000/index.php
```

Le conteneur (`php:8.3-cli`, serveur intégré) tourne en root → il peut créer `config.php` et écrire `data/` sans souci de permissions. `docker-compose.yml` monte le dossier en volume (édition à chaud). En prod, OVH est sous Apache/mod_php — le Docker ne sert qu'au dev local.

Les maquettes non retenues (`v2.html`, `v3.html`, `choix.html`) restent du HTML statique ouvrable directement.

## Architecture (production)

- `index.php` — la landing page. Inclut `inc/horaires.php`, charge `data/horaires.json` et rend **2 blocs dynamiques** : la grille `#cours` et la rangée de tarifs. Le hero affiche une citation statique de B.K.S. Iyengar (en surimpression sur la photo). Le reste (méthode, enseignantes, contact) est statique en dur. Contient aussi meta description + JSON-LD `SportsActivityLocation` pour le SEO local.
- `data/horaires.json` — source de vérité du planning : `cours[]` (niveau, tag, titre, description, `creneaux[]`) et `tarifs[]`.
- `inc/horaires.php` — helpers partagés : `h()` (échappement), `load_horaires()`, `save_horaires()` (avec `.bak` + verrou). Définit les constantes `HORAIRES_PATH` et `CONFIG_PATH`.
- `admin.php` — interface d'admin autonome. Flux : **1er lancement** → page « Première configuration » qui crée `config.php` (hash `password_hash`) ; puis **login** par session ; puis **édition** du planning (ajout/suppression de lignes en vanilla JS, indices uniques via compteur, jeton CSRF). `build_from_post()` reconstruit le JSON et ignore les lignes vides.
- `config.php` — généré au 1er lancement, **gitignoré** (contient le hash du mot de passe admin). `config.sample.php` documente le format.

Charte dans `css/style.css` : variables CSS dans `:root` (palette argile/parchemin `--clay`/`--parch`/`--ink`, polices *Cormorant Garamond* + *Jost*). `index.php` la référence via `<link>` avec cache-busting `?v=<?= filemtime() ?>`. Apparition au scroll via `IntersectionObserver` (classe `.visible` sur `[data-reveal]`), responsive `@media (max-width: 900px)`. Toute modif de design doit rester cohérente avec ces variables/classes.

## Déploiement (OVH mutualisé)

Upload FTP des fichiers. **`data/` doit être inscriptible** par PHP (sauvegarde du planning) et le dossier racine inscriptible au 1er lancement (création de `config.php`) — sinon l'admin affiche une erreur de droits. `config.php` et `data/*.bak` ne sont pas versionnés.

Le remote git historique est `github.com:4louest/yoga-lyengar-v1`. `robots.txt` interdit actuellement toute indexation (`Disallow: /`) — **à retirer avant la mise en ligne publique.**

## Pistes SEO / perf encore à faire

Auto-héberger les polices Google et la photo hero (actuellement Unsplash distant) pour la vitesse + RGPD ; lazy-load des images ; fiche Google Business Profile (réf. local). Voir aussi `todo.md` (retours client sur la proposition 1 : retirer le bouton « essayer un cours », changer photo + citation, renommer le titre, photos d'enseignantes — `assets/` contient déjà les visuels Clara/Delphine non encore intégrés).

## Données métier (réelles, à ne pas inventer)

Informations factuelles présentes dans les maquettes — coordonnées, planning, tarifs et enseignantes (Delphine Oyarzabal Saury, Clara Bâtie) sont des données réelles. Les reporter à l'identique d'une version à l'autre ; ne pas en fabriquer.
