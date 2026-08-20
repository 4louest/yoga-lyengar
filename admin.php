<?php
/**
 * Mini-interface d'administration du planning.
 * Flux : 1) 1er lancement -> définir le mot de passe (crée config.php)
 *        2) connexion par mot de passe (session)
 *        3) édition du planning -> data/horaires.json
 * Aucune base de données, aucune dépendance : OK sur mutualisé OVH.
 */

session_start();
require __DIR__ . '/inc/horaires.php';

$error  = '';
$notice = '';

/* ───────────────────────── 1. SETUP INITIAL ───────────────────────── */
if (!file_exists(CONFIG_PATH)) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['setup_password'])) {
        $pw  = (string) $_POST['setup_password'];
        $pw2 = (string) ($_POST['setup_password2'] ?? '');
        if (strlen($pw) < 8) {
            $error = 'Le mot de passe doit faire au moins 8 caractères.';
        } elseif ($pw !== $pw2) {
            $error = 'Les deux mots de passe ne correspondent pas.';
        } else {
            $hash    = password_hash($pw, PASSWORD_DEFAULT);
            $content = "<?php\n// Généré automatiquement — ne pas committer.\nreturn [\n    'admin_password_hash' => " . var_export($hash, true) . ",\n];\n";
            if (file_put_contents(CONFIG_PATH, $content, LOCK_EX) !== false) {
                session_regenerate_id(true);
                $_SESSION['auth'] = true;
                header('Location: admin.php');
                exit;
            }
            $error = "Impossible d'écrire config.php (vérifiez les droits d'écriture du dossier).";
        }
    }
    render_setup($error);
    exit;
}

$config = require CONFIG_PATH;

/* ───────────────────────── 2. DÉCONNEXION ───────────────────────── */
if (isset($_GET['logout'])) {
    $_SESSION = [];
    session_destroy();
    header('Location: admin.php');
    exit;
}

/* ───────────────────────── 3. CONNEXION ───────────────────────── */
if (empty($_SESSION['auth'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'])) {
        if (password_verify((string) $_POST['password'], $config['admin_password_hash'])) {
            session_regenerate_id(true);
            $_SESSION['auth'] = true;
            header('Location: admin.php');
            exit;
        }
        $error = 'Mot de passe incorrect.';
    }
    render_login($error);
    exit;
}

/* ───────────────────────── 4. CSRF ───────────────────────── */
if (empty($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(16));
}

/* ───────────────────────── 5. ENREGISTREMENT ───────────────────────── */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
    if (!hash_equals($_SESSION['csrf'], (string) ($_POST['csrf'] ?? ''))) {
        $error = 'Session expirée, merci de renvoyer le formulaire.';
    } elseif (save_horaires(build_from_post($_POST))) {
        $notice = 'Modifications enregistrées avec succès.';
    } else {
        $error = "Échec de l'enregistrement — vérifiez les droits d'écriture sur le dossier data/.";
    }
}

render_admin(load_horaires(), $notice, $error, $_SESSION['csrf']);


/* ════════════════════════ TRAITEMENT ════════════════════════ */

/** Reconstruit la structure du planning à partir des champs POST (lignes vides ignorées). */
function build_from_post(array $post): array
{
    $out = horaires_defaults();

    foreach ($post['cours'] ?? [] as $c) {
        $titre    = trim($c['titre'] ?? '');
        $creneaux = [];
        foreach ($c['creneaux'] ?? [] as $cr) {
            $jour = trim($cr['jour'] ?? '');
            $hor  = trim($cr['horaire'] ?? '');
            $ens  = trim($cr['enseignante'] ?? '');
            if ($jour === '' && $hor === '' && $ens === '') {
                continue;
            }
            $creneaux[] = ['jour' => $jour, 'horaire' => $hor, 'enseignante' => $ens];
        }
        if ($titre === '' && !$creneaux) {
            continue;
        }
        $out['cours'][] = [
            'niveau'      => trim($c['niveau'] ?? ''),
            'tag'         => trim($c['tag'] ?? ''),
            'titre'       => $titre,
            'description' => trim($c['description'] ?? ''),
            'creneaux'    => $creneaux,
        ];
    }

    foreach ($post['tarifs'] ?? [] as $t) {
        $montant = trim($t['montant'] ?? '');
        $libelle = trim($t['libelle'] ?? '');
        if ($montant === '' && $libelle === '') {
            continue;
        }
        $out['tarifs'][] = ['montant' => $montant, 'libelle' => $libelle];
    }

    return $out;
}


/* ════════════════════════ GABARITS ════════════════════════ */

function admin_head(string $title): void
{
    ?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="robots" content="noindex, nofollow">
<title><?= h($title) ?> — Administration</title>
<style>
  :root { --clay:#C8785A; --ink:#2A221A; --parch:#F5EFE6; --cream:#FBF7F2; --stone:#9E8E7E; }
  * { box-sizing: border-box; }
  body { font-family: system-ui, 'Segoe UI', sans-serif; background: var(--parch); color: var(--ink); margin: 0; line-height: 1.5; }
  .topbar { display:flex; justify-content:space-between; align-items:center; padding:1rem 1.5rem; background:var(--ink); color:#fff; }
  .topbar a { color:#fff; text-decoration:none; font-size:.85rem; opacity:.85; }
  .topbar a:hover { opacity:1; }
  .wrap { max-width: 920px; margin: 2rem auto; padding: 0 1.5rem; }
  h1 { font-size:1.3rem; margin:.2rem 0; }
  h2 { font-size:1.05rem; margin:2.2rem 0 .8rem; padding-bottom:.4rem; border-bottom:2px solid var(--clay); }
  .banner { padding:.8rem 1rem; border-radius:6px; margin-bottom:1rem; font-size:.9rem; }
  .ok  { background:#e7f3e7; border:1px solid #9cc79c; color:#2c662c; }
  .err { background:#f7e4e1; border:1px solid #d99; color:#a33; }
  .block { background:#fff; border:1px solid #e3d8c9; border-radius:8px; padding:1.2rem; margin-bottom:1rem; }
  .row { display:flex; gap:.6rem; align-items:center; margin-bottom:.5rem; flex-wrap:wrap; }
  label { font-size:.72rem; text-transform:uppercase; letter-spacing:.08em; color:var(--stone); display:block; margin-bottom:.2rem; }
  input, textarea { font:inherit; padding:.5rem .6rem; border:1px solid #cdbfae; border-radius:5px; background:var(--cream); width:100%; }
  textarea { resize:vertical; min-height:3rem; }
  .field { flex:1; min-width:120px; }
  .field-sm { width:90px; flex:none; }
  .creneau-list { margin:.6rem 0; }
  button { font:inherit; cursor:pointer; border:none; border-radius:5px; padding:.5rem .9rem; }
  .btn { background:var(--clay); color:#fff; }
  .btn:hover { background:var(--ink); }
  .btn-ghost { background:transparent; color:var(--clay); border:1px solid var(--clay); padding:.35rem .7rem; font-size:.85rem; }
  .btn-del { background:transparent; color:#b44; border:1px solid #d9aaaa; padding:.35rem .6rem; font-size:.8rem; }
  .btn-del:hover { background:#fbecec; }
  .save-bar { position:sticky; bottom:0; background:var(--parch); padding:1rem 0; margin-top:1.5rem; border-top:1px solid #d9cdbb; }
  .save-bar button { padding:.7rem 1.6rem; font-size:1rem; }
  .login-card { max-width:380px; margin:5rem auto; background:#fff; padding:2rem; border-radius:10px; border:1px solid #e3d8c9; }
  .login-card h1 { margin-bottom:1rem; }
  .login-card input { margin-bottom:1rem; }
  .hint { font-size:.8rem; color:var(--stone); margin-bottom:1rem; }
</style>
</head>
<body>
<?php
}

function render_setup(string $error): void
{
    admin_head('Configuration');
    ?>
<div class="login-card">
  <h1>Première configuration</h1>
  <p class="hint">Définissez le mot de passe d'administration. Il sera stocké de façon chiffrée dans <code>config.php</code>.</p>
  <?php if ($error): ?><div class="banner err"><?= h($error) ?></div><?php endif; ?>
  <form method="post">
    <label>Mot de passe (8 caractères min.)</label>
    <input type="password" name="setup_password" autocomplete="new-password" required>
    <label>Confirmer</label>
    <input type="password" name="setup_password2" autocomplete="new-password" required>
    <button class="btn" type="submit" style="width:100%">Enregistrer</button>
  </form>
</div>
</body></html>
<?php
}

function render_login(string $error): void
{
    admin_head('Connexion');
    ?>
<div class="login-card">
  <h1>Administration</h1>
  <?php if ($error): ?><div class="banner err"><?= h($error) ?></div><?php endif; ?>
  <form method="post">
    <label>Mot de passe</label>
    <input type="password" name="password" autocomplete="current-password" required autofocus>
    <button class="btn" type="submit" style="width:100%">Se connecter</button>
  </form>
</div>
</body></html>
<?php
}

function render_admin(array $data, string $notice, string $error, string $csrf): void
{
    admin_head('Planning');
    ?>
<div class="topbar">
  <strong>Yoga Iyengar · Planning</strong>
  <span><a href="index.php" target="_blank">Voir le site ↗</a> &nbsp;·&nbsp; <a href="admin.php?logout=1">Déconnexion</a></span>
</div>
<div class="wrap">
  <h1>Modifier le planning</h1>
  <p class="hint">Les champs laissés entièrement vides sont automatiquement supprimés à l'enregistrement.</p>
  <?php if ($notice): ?><div class="banner ok"><?= h($notice) ?></div><?php endif; ?>
  <?php if ($error): ?><div class="banner err"><?= h($error) ?></div><?php endif; ?>

  <form method="post">
    <input type="hidden" name="csrf" value="<?= h($csrf) ?>">

    <!-- ───── COURS ───── -->
    <h2>Cours &amp; créneaux</h2>
    <div id="cours-list">
      <?php foreach ($data['cours'] as $i => $c): ?>
      <div class="cours-block block" data-cidx="<?= $i ?>">
        <div class="row">
          <div class="field"><label>Titre</label><input name="cours[<?= $i ?>][titre]" value="<?= h($c['titre'] ?? '') ?>"></div>
          <div class="field"><label>Étiquette</label><input name="cours[<?= $i ?>][tag]" value="<?= h($c['tag'] ?? '') ?>"></div>
          <div class="field-sm"><label>Niveau</label><input name="cours[<?= $i ?>][niveau]" value="<?= h($c['niveau'] ?? '') ?>"></div>
        </div>
        <div class="row"><div class="field"><label>Description</label><textarea name="cours[<?= $i ?>][description]"><?= h($c['description'] ?? '') ?></textarea></div></div>
        <label>Créneaux</label>
        <div class="creneau-list">
          <?php foreach ($c['creneaux'] as $j => $cr): ?>
          <div class="row creneau-row">
            <input class="field-sm" name="cours[<?= $i ?>][creneaux][<?= $j ?>][jour]" value="<?= h($cr['jour'] ?? '') ?>" placeholder="Mer.">
            <input class="field" name="cours[<?= $i ?>][creneaux][<?= $j ?>][horaire]" value="<?= h($cr['horaire'] ?? '') ?>" placeholder="9h15 – 10h30">
            <input class="field" name="cours[<?= $i ?>][creneaux][<?= $j ?>][enseignante]" value="<?= h($cr['enseignante'] ?? '') ?>" placeholder="Clara">
            <button type="button" class="btn-del" onclick="removeEl(this,'.creneau-row')">✕</button>
          </div>
          <?php endforeach; ?>
        </div>
        <div class="row">
          <button type="button" class="btn-ghost" onclick="addCreneau(this)">+ Créneau</button>
          <button type="button" class="btn-del" onclick="removeEl(this,'.cours-block')">Supprimer ce cours</button>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <button type="button" class="btn-ghost" onclick="addCours()">+ Ajouter un cours</button>

    <!-- ───── TARIFS ───── -->
    <h2>Tarifs</h2>
    <div id="tarif-list">
      <?php foreach ($data['tarifs'] as $i => $t): ?>
      <div class="row tarif-row">
        <input class="field-sm" name="tarifs[<?= $i ?>][montant]" value="<?= h($t['montant'] ?? '') ?>" placeholder="380 €">
        <input class="field" name="tarifs[<?= $i ?>][libelle]" value="<?= h($t['libelle'] ?? '') ?>" placeholder="Forfait annuel · cours 1h30">
        <button type="button" class="btn-del" onclick="removeEl(this,'.tarif-row')">✕</button>
      </div>
      <?php endforeach; ?>
    </div>
    <button type="button" class="btn-ghost" onclick="addTarif()">+ Ajouter un tarif</button>

    <div class="save-bar">
      <button class="btn" type="submit" name="save" value="1">Enregistrer les modifications</button>
    </div>
  </form>
</div>

<script>
  // Indices uniques pour les lignes ajoutées (n'entrent pas en collision avec ceux rendus côté serveur).
  let uid = <?= time() ?>;
  const nextId = () => ++uid;

  function removeEl(btn, selector) { btn.closest(selector).remove(); }

  function addCours() {
    const id = nextId();
    const html = `
      <div class="cours-block block" data-cidx="${id}">
        <div class="row">
          <div class="field"><label>Titre</label><input name="cours[${id}][titre]"></div>
          <div class="field"><label>Étiquette</label><input name="cours[${id}][tag]"></div>
          <div class="field-sm"><label>Niveau</label><input name="cours[${id}][niveau]"></div>
        </div>
        <div class="row"><div class="field"><label>Description</label><textarea name="cours[${id}][description]"></textarea></div></div>
        <label>Créneaux</label>
        <div class="creneau-list"></div>
        <div class="row">
          <button type="button" class="btn-ghost" onclick="addCreneau(this)">+ Créneau</button>
          <button type="button" class="btn-del" onclick="removeEl(this,'.cours-block')">Supprimer ce cours</button>
        </div>
      </div>`;
    document.getElementById('cours-list').insertAdjacentHTML('beforeend', html);
  }

  function addCreneau(btn) {
    const block = btn.closest('.cours-block');
    const c = block.dataset.cidx, r = nextId();
    const html = `
      <div class="row creneau-row">
        <input class="field-sm" name="cours[${c}][creneaux][${r}][jour]" placeholder="Mer.">
        <input class="field" name="cours[${c}][creneaux][${r}][horaire]" placeholder="9h15 – 10h30">
        <input class="field" name="cours[${c}][creneaux][${r}][enseignante]" placeholder="Clara">
        <button type="button" class="btn-del" onclick="removeEl(this,'.creneau-row')">✕</button>
      </div>`;
    block.querySelector('.creneau-list').insertAdjacentHTML('beforeend', html);
  }

  function addTarif() {
    const id = nextId();
    const html = `
      <div class="row tarif-row">
        <input class="field-sm" name="tarifs[${id}][montant]" placeholder="380 €">
        <input class="field" name="tarifs[${id}][libelle]" placeholder="Forfait annuel · cours 1h30">
        <button type="button" class="btn-del" onclick="removeEl(this,'.tarif-row')">✕</button>
      </div>`;
    document.getElementById('tarif-list').insertAdjacentHTML('beforeend', html);
  }
</script>
</body></html>
<?php
}
