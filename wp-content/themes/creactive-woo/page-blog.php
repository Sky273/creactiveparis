<?php
get_header();
$blog_query = function_exists('creactive_woo_category_posts_query') ? creactive_woo_category_posts_query('blog', 9) : new WP_Query(['post_type' => 'post', 'posts_per_page' => 9]);
?>
<section class="page-hero page-hero--projects">
    <div class="container page-hero__inner">
        <p class="section-kicker">Blog</p>
        <h1>Actualités, conseils et inspirations autour de l’univers Créactive Paris</h1>
        <p>Cette page rassemble automatiquement les articles de la catégorie blog pour publier vos nouveautés, vos conseils d’aménagement et vos prises de parole de marque.</p>
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
                <p class="info-card__label">Contenu affiché</p>
                <h2>Les articles de la catégorie blog alimentent cette page</h2>
                <p>Ajoutez simplement un article dans la catégorie <strong>blog</strong> pour le faire apparaître ici et nourrir votre visibilité éditoriale.</p>
            </div>
        </aside>
    </div>
</section>

<section class="section section--soft">
    <div class="container">
        <div class="section-heading section-heading--centered">
            <p class="section-kicker">Derniers articles</p>
            <h2>Le blog de la marque</h2>
        </div>
        <?php
        if (function_exists('creactive_woo_render_editorial_post_grid')) {
            creactive_woo_render_editorial_post_grid(
                $blog_query,
                'Aucun article n’est encore classé dans la catégorie blog.'
            );
        }
        ?>
    </div>
</section>
<?php get_footer(); ?>
