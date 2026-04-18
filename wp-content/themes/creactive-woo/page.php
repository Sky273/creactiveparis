<?php get_header(); ?>
<div class="container page-shell">
    <?php while (have_posts()) : the_post(); ?>
        <article <?php post_class(); ?>>
            <header class="page-header">
                <h1><?php the_title(); ?></h1>
            </header>
            <div class="entry-content"><?php the_content(); ?></div>
        </article>
    <?php endwhile; ?>
</div>
<?php get_footer(); ?>
