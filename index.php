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
        Alignement, précision, bienveillance. Clara et Delphine vous invitent à découvrir une pratique rigoureuse et
  accessible — débutants et tous niveaux.
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
      <p>
        L’enseignement du yoga selon B.K.S. Iyengar est basé sur la pratique approfondie des asana (les postures de yoga) et 
        du pranayama (la respiration yogique). Le tout s’effectue dans la recherche de la rigueur, de l’intensité, de l’alignement et
        de la précision.
      </p>
      <p>
        Cette méthode précise et rigoureuse, se caractérise par :
        <ul>
          <li>l’attention portée sur l’alignement des différentes parties du corps dans l’espace ;</li>
          <li>l’organisation des postures en séquences ;</li>
          <li>l’emploi de supports (sangles, briques, couvertures, chaises, cordes…).</li>
        </ul>
  </p>
  <p>
    Ces principes de base permettent de développer un meilleur équilibre physique et mental et apportent tous les bienfaits
  que le yoga promet. L’enseignement est progressif et adapté aux capacités physiques de chacun. L’utilisation des
  supports facilite l’apprentissage des postures.
  </p>
  <p>
    Accessible à tous les âges, y compris aux débutants et aux personnes fragilisées, cet enseignement se déploie dans le
    respect de l'anatomie et sans esprit de compétition.
  </p>
    </div>
    <div class="feature-grid">
      <div class="feature-card">
        <div class="icon">⟁</div>
        <h4>La force</h4>
        <p>La méthode Iyengar met l’accent sur le développement de la force, de l’endurance et de l’alignement correct du corps.
  Le corps est libéré des tensions par l’étirement et le mouvement.</p>
      </div>
      <div class="feature-card">
        <div class="icon">◈</div>
        <h4>Vitalité</h4>
        <p>L’importance de la pratique des postures debout rendent les jambes puissantes et augmente la vitalité générale et
  améliore la coordination et l’équilibre.</p>
      </div>
      <div class="feature-card">
        <div class="icon">◎</div>
        <h4>Santé</h4>
        <p>La pratique des asanas développe la force et la souplesse : elle aide à soulager des maux du dos, participe au bon
  fonctionnement de tous les organes, améliore la digestion et la circulation sanguine.
  Beaucoup d’élèves remarquent que leurs difficultés
  physiques décroissent avec la pratique.</p>
      </div>
      <div class="feature-card">
        <div class="icon">❋</div>
        <h4>Relaxation</h4>
        <p>A l’aide d’une pratique régulière, les postures chassent le stress et la fatigue. La capacité des élèves à se concentrer et à
  se relaxer augmente et la conscience intérieure s’améliore.</p>
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
          <p>
            Professeur certifiée la Méthode Iyengar® par le RIMYI (Ramamani Iyengar
            Memorial Yoga institute) Pratique depuis 2004 et enseigne depuis 2017. Formée à
            Lyon et à Marseille auprès de Stéphane Lalo et continue de se former dans
            l’enseignement du Yoga Iyengar® -.Educatrice sportive et certifiée en Activité
            Physiques Adaptées, Marche Active et Marche Nordique
          </p>
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

  <!-- AUTRES LIEUX -->
  <section id="autres-lieux" data-reveal>
    <div class="section-label">Aussi dans la région</div>
    <h3 class="autres-lieux-title">Autres lieux de pratique autour de Valence</h3>
    <div class="autres-lieux-grid">
      <div class="lieu-item">
        <strong>Châteaudouble</strong> — Les Petits Chapeneys, 2575 route de Chabeuil, 26120 Châteaudouble
        <span class="lieu-detail">Avec Delphine · débutant : mardi 18h-19h30 (niveau 1/2) · intermédiaire : mardi 19h35-20h55 et jeudi 18h30-20h (niveau 2)</span>
      </div>
      <div class="lieu-item">
        <strong>Crest</strong> — 41 rue Sadi Carnot, 26400 Crest
        <span class="lieu-detail">Avec Clara · <a href="https://www.yoga-crest26.com/horaires-des-cours/" target="_blank" rel="noopener">horaires des cours</a></span>
      </div>
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
