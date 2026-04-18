<?php
get_header();
$blog_query = function_exists('creactive_woo_category_posts_query') ? creactive_woo_category_posts_query('blog', 9) : new WP_Query(['post_type' => 'post', 'posts_per_page' => 9]);
$blog_posts = $blog_query instanceof WP_Query ? $blog_query->posts : [];
$featured_post = $blog_posts[0] ?? null;
$remaining_posts = array_slice($blog_posts, 1);
$blog_angles = [
    'Actualités produits et nouvelles finitions',
    'Conseils d’aménagement pour hôtels, résidences et collectivités',
    'Articles utiles pour nourrir la visibilité organique et la réassurance commerciale',
];
?>
<section class="page-hero page-hero--projects">
    <div class="container page-hero__inner">
        <p class="section-kicker">Blog</p>
        <h1>Un blog utile pour attirer, éduquer et convertir vos futurs clients</h1>
        <p>Nouveautés produit, conseils d’aménagement, choix de finitions, contraintes d’usage, inspirations hospitality : retrouvez ici les contenus qui aident les décideurs à mieux équiper leurs projets et à comprendre la valeur de l’offre Créactive Paris.</p>
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
                <p class="info-card__label">Rôle de la page</p>
                <h2>Des contenus utiles pour nourrir la réflexion et la décision</h2>
                <p>Les articles publiés ici prolongent le discours commercial de la marque : ils apportent de la matière, répondent aux questions fréquentes et créent un contexte favorable à la prise de contact.</p>
                <ul class="editorial-bullets">
                    <?php foreach ($blog_angles as $angle) : ?>
                        <li><?php echo esc_html($angle); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </aside>
    </div>
</section>

<section class="section section--soft">
    <div class="container">
        <div class="section-heading section-heading--centered">
            <p class="section-kicker">Article à la une</p>
            <h2>Le contenu le plus récent, affiché intégralement</h2>
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
                        <a class="button button--filled" href="<?php echo esc_url(creactive_woo_contact_url()); ?>">Parler de votre projet</a>
                        <a class="button button--outline" href="<?php echo esc_url(get_permalink($featured_post)); ?>">Ouvrir l’article</a>
                    </div>
                </div>
            </article>
            <?php wp_reset_postdata(); ?>
        <?php else : ?>
            <div class="empty-state"><p>Aucun article n’est encore classé dans la catégorie blog.</p></div>
        <?php endif; ?>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-heading section-heading--centered">
            <p class="section-kicker">Autres contenus</p>
            <h2>Articles, conseils et prises de parole de la marque</h2>
        </div>
        <?php
        if (function_exists('creactive_woo_render_editorial_post_cards_from_array')) {
            creactive_woo_render_editorial_post_cards_from_array(
                $remaining_posts,
                'Aucun autre article n’est disponible pour le moment dans la catégorie blog.'
            );
        }
        ?>
    </div>
</section>

<section class="section section--dark-band">
    <div class="container checklist-panel">
        <div>
            <p class="section-kicker">Orientation éditoriale</p>
            <h2>Publier des sujets qui parlent vraiment aux décideurs</h2>
        </div>
        <ul class="checklist-panel__list">
            <li><strong>Répondre à des besoins précis :</strong> choix de finition, logique d’équipement, contraintes de lieux recevant du public.</li>
            <li><strong>Montrer la valeur de l’offre :</strong> qualité perçue, robustesse, cohérence de collection, accompagnement projet.</li>
            <li><strong>Faire le lien avec le commerce :</strong> finir chaque article par un CTA vers la sélection produit ou la demande de devis.</li>
        </ul>
    </div>
</section>
<?php get_footer(); ?>
