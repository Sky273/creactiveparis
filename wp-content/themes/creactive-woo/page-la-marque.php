<?php
get_header();
$catalogue_url = 'https://www.creactive-paris.fr/wp-content/uploads/2025/03/catalogue-2025.pdf';
$pillars = [
    [
        'title' => 'Design utile',
        'description' => 'Créactive Paris collabore avec des designers pour créer des accessoires de salle de bain sobres, identifiables et pensés pour durer.',
    ],
    [
        'title' => 'Fabrication maîtrisée',
        'description' => 'Le choix des matières, des finitions et des procédés vise à garantir un rendu premium, robuste et compatible avec l’hôtellerie et les collectivités.',
    ],
    [
        'title' => 'Approche projet',
        'description' => 'Les produits peuvent être adaptés en dimensions, finitions ou configurations pour répondre à des projets standards ou sur-mesure.',
    ],
];
$commitments = [
    'Conception de collections au style intemporel et professionnel',
    'Recherche de matériaux adaptés aux environnements intensifs',
    'Personnalisation de finitions selon le projet',
    'Accompagnement des architectes, prescripteurs et exploitants',
];
?>
<section class="page-hero page-hero--brand">
    <div class="container page-hero__inner">
        <p class="section-kicker">La marque</p>
        <h1>Une marque française dédiée à l’accastillage de salle de bain</h1>
        <p>Créactive Paris développe des accessoires design, robustes et cohérents pour les projets hôteliers, résidentiels et collectifs à forte exigence esthétique.</p>
    </div>
</section>

<section class="section page-section">
    <div class="container editorial-grid">
        <div class="editorial-copy">
            <?php while (have_posts()) : the_post(); ?>
                <article <?php post_class(); ?>>
                    <div class="entry-content entry-content--premium"><?php the_content(); ?></div>
                </article>
            <?php endwhile; ?>
        </div>
        <aside class="editorial-aside">
            <div class="info-card">
                <p class="info-card__label">Positionnement</p>
                <h2>Hospitality, premium living et collectivités</h2>
                <p>Une offre structurée pour les univers où la résistance, l’élégance et la cohérence d’ensemble sont essentielles.</p>
                <a class="button button--filled" href="<?php echo esc_url($catalogue_url); ?>" target="_blank" rel="noopener">Télécharger le catalogue</a>
            </div>
        </aside>
    </div>
</section>

<section class="section section--soft">
    <div class="container">
        <div class="section-heading section-heading--centered">
            <p class="section-kicker">Trois piliers</p>
            <h2>Un discours de marque prêt à l’emploi</h2>
        </div>
        <div class="premium-card-grid premium-card-grid--three">
            <?php foreach ($pillars as $pillar) : ?>
                <article class="premium-card">
                    <h3><?php echo esc_html($pillar['title']); ?></h3>
                    <p><?php echo esc_html($pillar['description']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section section--dark-band">
    <div class="container checklist-panel">
        <div>
            <p class="section-kicker">Ce que la page raconte</p>
            <h2>Une base de contenu pensée pour convaincre</h2>
        </div>
        <ul class="checklist-panel__list">
            <?php foreach ($commitments as $commitment) : ?>
                <li><?php echo esc_html($commitment); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>
<?php get_footer(); ?>
