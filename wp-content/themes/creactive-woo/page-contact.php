<?php
get_header();
$contact_cards = [
    ['title' => 'Téléphone', 'value' => '+33 (0)2 53 61 88 29', 'link' => 'tel:+33253618829'],
    ['title' => 'E-mail', 'value' => 'contact@creactive-paris.fr', 'link' => 'mailto:contact@creactive-paris.fr'],
    ['title' => 'Adresse', 'value' => '6 rue de la Chanterie, 49124 Saint-Barthélémy-d’Anjou, France', 'link' => 'https://maps.google.com/?q=6+rue+de+la+Chanterie+49124+Saint-Barth%C3%A9lemy-d%E2%80%99Anjou'],
];
$services = [
    'Demande de devis pour équipement complet',
    'Question sur une gamme ou une finition',
    'Projet sur-mesure ou adaptation dimensionnelle',
    'Accompagnement architecte, hôtelier ou collectivité',
];
?>
<section class="page-hero page-hero--contact">
    <div class="container page-hero__inner">
        <p class="section-kicker">Contact</p>
        <h1>Un point d’entrée prêt à l’emploi pour les demandes commerciales</h1>
        <p>Cette page est pensée pour capter les demandes de devis, les questions produit et les besoins liés aux projets hospitality, résidentiels ou collectivités.</p>
    </div>
</section>

<section class="section page-section">
    <div class="container contact-layout">
        <div class="contact-layout__main">
            <?php while (have_posts()) : the_post(); ?>
                <article <?php post_class(); ?>>
                    <div class="entry-content entry-content--premium"><?php the_content(); ?></div>
                </article>
            <?php endwhile; ?>
        </div>
        <aside class="contact-layout__aside">
            <div class="info-card">
                <p class="info-card__label">Coordonnées</p>
                <h2>Parlez-nous de votre projet</h2>
                <div class="contact-card-list">
                    <?php foreach ($contact_cards as $card) : ?>
                        <a class="contact-mini-card" href="<?php echo esc_url($card['link']); ?>" target="_blank" rel="noopener">
                            <span><?php echo esc_html($card['title']); ?></span>
                            <strong><?php echo esc_html($card['value']); ?></strong>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </aside>
    </div>
</section>

<section class="section section--soft">
    <div class="container">
        <div class="section-heading section-heading--centered">
            <p class="section-kicker">Demandes fréquentes</p>
            <h2>Les sujets que cette page peut absorber dès aujourd’hui</h2>
        </div>
        <div class="premium-card-grid premium-card-grid--four">
            <?php foreach ($services as $service) : ?>
                <article class="premium-card premium-card--compact">
                    <h3><?php echo esc_html($service); ?></h3>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php get_footer(); ?>
