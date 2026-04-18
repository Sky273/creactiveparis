<?php
get_header();
$projects_query = function_exists('creactive_woo_category_posts_query') ? creactive_woo_category_posts_query('realisations', 9) : new WP_Query(['post_type' => 'post', 'posts_per_page' => 9]);
$project_posts = $projects_query instanceof WP_Query ? $projects_query->posts : [];
$featured_post = $project_posts[0] ?? null;
$remaining_posts = array_slice($project_posts, 1);
$reassurance_points = [
    'Des lieux exigeants où l’esthétique, la durabilité et la cohérence comptent vraiment',
    'Des réalisations qui permettent d’évaluer le niveau de finition et l’esprit des collections',
    'Des exemples concrets pour imaginer plus facilement un projet comparable au vôtre',
];
?>
<section class="page-hero page-hero--projects">
    <div class="container page-hero__inner">
        <p class="section-kicker">Réalisations</p>
        <h1>Des références concrètes pour sécuriser la décision et valoriser votre offre</h1>
        <p>Hôtels, résidences premium, programmes résidentiels et établissements recevant du public : découvrez des références concrètes où la qualité perçue, la robustesse et la cohérence esthétique jouent un rôle décisif dans l’expérience du lieu.</p>
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
                <p class="info-card__label">Références & crédibilité</p>
                <h2>Des réalisations qui donnent une vision concrète du résultat</h2>
                <p>Chaque projet aide à mesurer la présence des collections dans l’espace, la qualité des finitions et la manière dont l’ensemble contribue à l’image du lieu comme au confort d’usage.</p>
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
            <h2>La réalisation la plus récente, dans le détail</h2>
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
                        <a class="button button--filled" href="<?php echo esc_url(creactive_woo_contact_url()); ?>">Étudier un projet similaire</a>
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
            <h2>Autres réalisations et références à découvrir</h2>
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
            <p class="section-kicker">Pour aller plus loin</p>
            <h2>Vous souhaitez retrouver cette exigence sur votre propre projet ?</h2>
        </div>
        <ul class="checklist-panel__list">
            <li><strong>Choisir une ambiance :</strong> contemporaine, intemporelle, premium ou adaptée à un usage intensif.</li>
            <li><strong>Comparer les solutions :</strong> collections, finitions, équipements et zones à traiter.</li>
            <li><strong>Passer à l’action :</strong> demander une sélection adaptée à votre établissement, résidence ou programme.</li>
        </ul>
    </div>
</section>
<?php get_footer(); ?>
