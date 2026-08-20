<?php
require __DIR__ . "/inc/horaires.php";
$data = load_horaires();

// Données structurées pour le SEO local (Google).
$jsonLd = [
    "@context" => "https://schema.org",
    "@type" => "SportsActivityLocation",
    "name" => "Yoga Iyengar Valence — Salle Parallèle",
    "description" =>
        "Studio de yoga Iyengar® à Valence : alignement, précision et progression adaptée. Cours tous niveaux, débutants bienvenus.",
    "address" => [
        "@type" => "PostalAddress",
        "streetAddress" => "82 rue Génissieux",
        "postalCode" => "26000",
        "addressLocality" => "Valence",
        "addressCountry" => "FR",
    ],
    "telephone" => "+33769611435",
    "email" => "delpil@orange.fr",
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Yoga Iyengar Valence — Salle Parallèle</title>
<meta name="description" content="Studio de yoga Iyengar® à Valence (Salle Parallèle, 82 rue Génissieux). Cours tous niveaux, débutants bienvenus.">
<meta property="og:title" content="Yoga Iyengar Valence — Salle Parallèle">
<meta property="og:description" content="Cours de yoga Iyengar® à Valence avec Clara et Delphine. Alignement, précision, bienveillance. Débutants bienvenus.">
<meta property="og:type" content="website">
<meta property="og:locale" content="fr_FR">
<script type="application/ld+json"><?= json_encode(
    $jsonLd,
    JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES,
) ?></script>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Jost:wght@200;300;400&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/style.css?v=<?= @filemtime(__DIR__ . "/css/style.css") ?>">
</head>
<body>

<!-- NAV -->
<nav>
  <div class="nav-logo">Yoga <span>Iyengar</span> · Valence</div>
  <button class="nav-toggle" id="nav-toggle" aria-label="Ouvrir le menu" aria-expanded="false" aria-controls="nav-menu">
    <span></span><span></span><span></span>
  </button>
  <ul id="nav-menu">
    <li><a href="#accueil">Accueil</a></li>
    <li><a href="#methode">La méthode</a></li>
    <li><a href="#cours">Cours</a></li>
    <li><a href="#enseignantes">Enseignantes</a></li>
    <li><a href="#contact">Contact</a></li>
  </ul>
</nav>

<!-- HERO -->
<section id="accueil" class="hero">
  <div class="hero-text">
    <div class="hero-eyebrow">Valence · Salle Parallèle</div>
    <h1 class="hero-title">
      Yoga <em>Iyengar®</em><br>
      à Valence
    </h1>
    <p class="hero-sub">
      Alignement, précision, présence. Clara et Delphine vous accueillent
      dans un espace dédié à la pratique rigoureuse et bienveillante —
      débutants bienvenus.
    </p>
    <!--<a href="#contact" class="btn-primary">Essayer un cours <span class="arrow">→</span></a>-->
  </div>
  <div class="hero-visual">
    <img
      class="hero-photo"
      src="assets/bks_iyengar.jpg"
      alt="B.K.S. Iyengar en Utthita Trikonasana (posture du triangle)"
      loading="eager"
    >
    <span class="photo-credit">B.K.S. Iyengar · Utthita Trikonasana</span>
    <div class="hero-quote">
      <p>« Le yoga est une lumière — une fois allumée, elle ne s'éteint jamais. »
        <cite>— B.K.S. Iyengar</cite></p>
    </div>
  </div>
</section>

<!-- MÉTHODE -->
<section id="methode" data-reveal>
  <div class="text">
    <div class="section-label">La méthode</div>
    <h2 class="section-title">Une pratique <em>précise</em><br>et progressive</h2>
    <div class="divider"></div>
    <p>Le yoga Iyengar® est fondé sur la pratique approfondie des <em>asanas</em> (postures) et du <em>pranayama</em> (respiration). L'accent est mis sur l'alignement rigoureux de chaque partie du corps, l'utilisation de supports pédagogiques et une progression adaptée à chacun.</p>
    <p>Accessible à tous les âges, y compris aux débutants et aux personnes fragilisées, cet enseignement se déploie dans le respect de l'anatomie et sans esprit de compétition.</p>
    <p>En France, plus de 500 enseignants certifiés perpétuent la méthode selon les standards établis par l'Association Française de Yoga Iyengar.</p>
  </div>
  <div class="feature-grid">
    <div class="feature-card">
      <div class="icon">⟁</div>
      <h4>Alignement</h4>
      <p>Attention précise portée à chaque partie du corps dans l'espace.</p>
    </div>
    <div class="feature-card">
      <div class="icon">◈</div>
      <h4>Supports</h4>
      <p>Briques, sangles, chaises — pour faciliter l'apprentissage à tout niveau.</p>
    </div>
    <div class="feature-card">
      <div class="icon">◎</div>
      <h4>Progression</h4>
      <p>Apprentissage structuré par niveaux, adapté au rythme de chacun.</p>
    </div>
    <div class="feature-card">
      <div class="icon">❋</div>
      <h4>Accessibilité</h4>
      <p>Enfants, seniors, grossesse — le yoga peut accompagner toutes les étapes de la vie.</p>
    </div>
  </div>
</section>

<!-- COURS -->
<section id="cours" data-reveal>
  <div class="section-label">Planning</div>
  <h2 class="section-title">Cours &amp; <em>Horaires</em></h2>
  <div class="divider"></div>
  <div class="cours-grid">
    <?php foreach ($data["cours"] as $c): ?>
    <div class="cours-card" data-level="<?= h($c["niveau"]) ?>">
      <span class="tag"><?= h($c["tag"]) ?></span>
      <h3><?= h($c["titre"]) ?></h3>
      <ul class="slot-list">
        <?php foreach ($c["creneaux"] as $cr): ?>
        <li><span class="day"><?= h($cr["jour"]) ?></span><span><?= h(
    $cr["horaire"],
) ?></span><span><?= h($cr["enseignante"]) ?></span></li>
        <?php endforeach; ?>
      </ul>
      <?php if (!empty($c["description"])): ?>
      <p class="cours-desc"><?= h($c["description"]) ?></p>
      <?php endif; ?>
    </div>
    <?php endforeach; ?>
  </div>
  <div class="tarifs-row">
    <?php foreach ($data["tarifs"] as $t): ?>
    <div class="tarif-pill"><strong><?= h($t["montant"]) ?></strong><?= h(
    $t["libelle"],
) ?></div>
    <?php endforeach; ?>
  </div>
</section>

<!-- ENSEIGNANTES -->
<section id="enseignantes" data-reveal>
  <div>
    <div class="section-label">L'équipe</div>
    <h2 class="section-title">Vos <em>enseignantes</em></h2>
    <div class="divider"></div>
    <p class="enseignantes-intro">Deux professeures passionnées, certifiées ou en formation de certification, pour vous accompagner dans votre pratique avec rigueur et bienveillance.</p>
  </div>
  <div class="prof-cards">
    <div class="prof-card">
      <div class="prof-avatar">
        <img src="assets/enseignante-yoga-lyengar-delphine.avif" alt="Delphine Oyarzabal Saury, enseignante de yoga Iyengar à Valence" width="104" height="104" loading="lazy" decoding="async">
      </div>
      <div>
        <h3>Delphine Oyarzabal Saury</h3>
        <div class="role">Professeure certifiée Yoga Iyengar®</div>
        <p>Pratique depuis 2004, enseignement depuis 2017. Formation à Lyon et Marseille auprès de Stéphane Lalo. Également éducatrice sportive, formée en Activité Physique Adaptée et Marche Nordique.</p>
        <div class="contact">✉ delpil@orange.fr · 07 69 61 14 35</div>
      </div>
    </div>
    <div class="prof-card">
      <div class="prof-avatar">
        <img src="assets/enseignante-yoga-lyengar-clara.webp" alt="Clara Bâtie, enseignante de yoga Iyengar à Valence" width="104" height="104" loading="lazy" decoding="async">
      </div>
      <div>
        <h3>Clara Bâtie</h3>
        <div class="role">Professeure en formation mentorat</div>
        <p>Certifiée Hatha &amp; Vinyasa (200h, One Yoga School Thailand, 2022). Pratique Iyengar depuis 2021, en formation/mentorat Iyengar depuis 2023. Enseigne à Valence et Crest depuis 2024.</p>
        <div class="contact">✉ clara.batie.ei@outlook.fr · 06 77 89 17 37</div>
      </div>
    </div>
  </div>
</section>

<!-- CONTACT -->
<section id="contact" data-reveal>
  <div>
    <div class="section-label">Nous rejoindre</div>
    <h2 class="section-title">Prêt·e à <em>essayer</em> ?</h2>
    <div class="divider"></div>
    <p>Rejoignez-nous pour découvrir la méthode Iyengar® dans un groupe à taille humaine, avec une attention individuelle. Arrivez 10 à 15 minutes avant le début.</p>
    <div class="contact-infos">
      <div class="info-item">
        <span class="icon">📍</span>
        <div><strong>Adresse</strong>Salle Parallèle — 82 rue Génissieux, 26000 Valence</div>
      </div>
      <div class="info-item">
        <span class="icon">📧</span>
        <div><strong>Email</strong>delpil@orange.fr · clara.batie.ei@outlook.fr</div>
      </div>
      <div class="info-item">
        <span class="icon">📞</span>
        <div><strong>Téléphone</strong>Delphine : 07 69 61 14 35 · Clara : 06 77 89 17 37</div>
      </div>
    </div>
    <a href="mailto:delpil@orange.fr" class="btn-white">Contacter une enseignante <span>→</span></a>
  </div>
  <div class="map-embed">
    <iframe
      title="Salle Parallèle — 82 rue Génissieux, 26000 Valence"
      src="https://www.google.com/maps?q=Salle+Parall%C3%A8le+82+rue+G%C3%A9nissieux+26000+Valence&output=embed"
      loading="lazy"
      referrerpolicy="no-referrer-when-downgrade"
      allowfullscreen
    ></iframe>
  </div>
</section>

<!-- FOOTER -->
<footer>
  <span>© <?= date("Y") ?> Yoga Iyengar Valence · Salle Parallèle</span>
  <span>82 rue Génissieux · 26000 Valence</span>
  <span>Membre AFYI</span>
</footer>

<script>
  // Menu sandwich (mobile)
  const navToggle = document.getElementById('nav-toggle');
  const navMenu = document.getElementById('nav-menu');
  const setMenu = (open) => {
    navMenu.classList.toggle('open', open);
    navToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    navToggle.setAttribute('aria-label', open ? 'Fermer le menu' : 'Ouvrir le menu');
  };
  navToggle.addEventListener('click', () => setMenu(!navMenu.classList.contains('open')));
  navMenu.querySelectorAll('a').forEach(a => a.addEventListener('click', () => setMenu(false)));
  document.addEventListener('keydown', (e) => { if (e.key === 'Escape') setMenu(false); });

  const reveals = document.querySelectorAll('[data-reveal]');
  const obs = new IntersectionObserver((entries) => {
    entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); obs.unobserve(e.target); } });
  }, { threshold: 0.12 });
  reveals.forEach(el => obs.observe(el));
</script>
</body>
</html>
