<?php
get_header();
$projects_query = function_exists('creactive_woo_category_posts_query') ? creactive_woo_category_posts_query('realisations', 9) : new WP_Query(['post_type' => 'post', 'posts_per_page' => 9]);
$project_posts = $projects_query instanceof WP_Query ? $projects_query->posts : [];
$featured_post = $project_posts[0] ?? null;
$remaining_posts = array_slice($project_posts, 1);
$reassurance_points = [
    'Références hôtelières, résidentielles et ERP à forte exigence esthétique',
    'Articles pensés pour rassurer architectes, décorateurs et prescripteurs',
    'Mise en avant des contextes d’usage, des finitions et des bénéfices projet',
];
?>
<section class="page-hero page-hero--projects">
    <div class="container page-hero__inner">
        <p class="section-kicker">Réalisations</p>
        <h1>Des références concrètes pour sécuriser la décision et valoriser votre offre</h1>
        <p>Hôtels, résidences premium, programmes résidentiels et établissements recevant du public : Créactive Paris accompagne des lieux où la qualité perçue, la robustesse et la cohérence esthétique doivent être irréprochables. Retrouvez ici des références concrètes, des ambiances installées et des solutions déjà déployées sur le terrain.</p>
    </div>
</section>

<section class="section page-section">
    <div class="container editorial-grid editorial-grid--projects">
        <div class="editorial-copy">
            <?php while (have_posts()) : the_post(); ?>
                <article <?php post_class(); ?>>
                    <div class="entry-content entry-content--premium"><?php the_content(); ?></div>
                </article>
            <?php endwhile; ?>
        </div>
        <aside class="editorial-aside">
            <div class="info-card">
                <p class="info-card__label">Impact commercial</p>
                <h2>Des références qui aident à se projeter rapidement</h2>
                <p>Les réalisations présentées ici montrent comment les collections Créactive Paris valorisent un projet, structurent l’expérience dans la salle de bain et répondent aux contraintes de lieux exigeants.</p>
                <ul class="editorial-bullets">
                    <?php foreach ($reassurance_points as $point) : ?>
                        <li><?php echo esc_html($point); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </aside>
    </div>
</section>

<section class="section section--soft">
    <div class="container">
        <div class="section-heading section-heading--centered">
            <p class="section-kicker">Référence à la une</p>
            <h2>Le projet le plus récent, présenté dans son intégralité</h2>
        </div>
        <?php if ($featured_post instanceof WP_Post) : ?>
            <?php
            setup_postdata($featured_post);
            $featured_image = get_the_post_thumbnail_url($featured_post, 'full');
            ?>
            <article class="featured-editorial-article">
                <?php if ($featured_image) : ?>
                    <div class="featured-editorial-article__media" style="background-image:url('<?php echo esc_url($featured_image); ?>');"></div>
                <?php endif; ?>
                <div class="featured-editorial-article__body">
                    <p class="featured-editorial-article__meta"><?php echo esc_html(get_the_date('j F Y', $featured_post)); ?></p>
                    <h3><?php echo esc_html(get_the_title($featured_post)); ?></h3>
                    <div class="entry-content entry-content--premium featured-editorial-article__content">
                        <?php echo apply_filters('the_content', $featured_post->post_content); ?>
                    </div>
                    <div class="featured-editorial-article__actions">
                        <a class="button button--filled" href="<?php echo esc_url(creactive_woo_contact_url()); ?>">Demander un devis pour un projet similaire</a>
                        <a class="button button--outline" href="<?php echo esc_url(get_permalink($featured_post)); ?>">Ouvrir l’article</a>
                    </div>
                </div>
            </article>
            <?php wp_reset_postdata(); ?>
        <?php else : ?>
            <div class="empty-state"><p>Aucun article n’est encore classé dans la catégorie réalisations.</p></div>
        <?php endif; ?>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-heading section-heading--centered">
            <p class="section-kicker">Autres contenus</p>
            <h2>Autres réalisations, références et mises en situation</h2>
        </div>
        <?php
        if (function_exists('creactive_woo_render_editorial_post_cards_from_array')) {
            creactive_woo_render_editorial_post_cards_from_array(
                $remaining_posts,
                'Aucun autre article n’est disponible pour le moment dans la catégorie réalisations.'
            );
        }
        ?>
    </div>
</section>

<section class="section section--dark-band">
    <div class="container checklist-panel">
        <div>
            <p class="section-kicker">Approche projet</p>
            <h2>Montrer des projets réels, donner envie, puis déclencher le contact</h2>
        </div>
        <ul class="checklist-panel__list">
            <li><strong>Mettre en scène les lieux :</strong> hôtel, résidence premium, programme résidentiel ou ERP.</li>
            <li><strong>Nommer les produits installés :</strong> collections, finitions, zones équipées, bénéfices d’usage.</li>
            <li><strong>Conclure commercialement :</strong> inviter à demander une sélection produit ou un devis projet.</li>
        </ul>
    </div>
</section>
<?php get_footer(); ?>
