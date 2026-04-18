<?php get_header(); ?>
<section class="archive-hero">
    <div class="container">
        <?php woocommerce_breadcrumb(); ?>
        <h1><?php woocommerce_page_title(); ?></h1>
        <p>Retrouvez l'ensemble du catalogue Créactive Paris dans une expérience WooCommerce moderne.</p>
    </div>
</section>
<div class="container shop-shell">
    <?php if (woocommerce_product_loop()) : ?>
        <?php do_action('woocommerce_before_shop_loop'); ?>
        <?php woocommerce_product_loop_start(); ?>
            <?php while (have_posts()) : the_post(); ?>
                <?php wc_get_template_part('content', 'product'); ?>
            <?php endwhile; ?>
        <?php woocommerce_product_loop_end(); ?>
        <?php do_action('woocommerce_after_shop_loop'); ?>
    <?php else : ?>
        <?php do_action('woocommerce_no_products_found'); ?>
    <?php endif; ?>
</div>
<?php get_footer(); ?>
