<?php
if (! defined('ABSPATH')) {
    exit;
}
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php
$shop_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/boutique/');
$cart_url = function_exists('wc_get_cart_url') ? wc_get_cart_url() : home_url('/panier/');
?>
<header class="site-header">
    <div class="container site-header__inner">
        <div class="site-branding">
            <?php echo creactive_woo_logo_markup(); ?>
        </div>
        <nav class="site-nav" aria-label="Menu principal">
            <?php
            wp_nav_menu([
                'theme_location' => 'primary',
                'container'      => false,
                'fallback_cb'    => 'creactive_woo_menu_fallback',
            ]);
            ?>
        </nav>
        <div class="site-actions">
            <a class="site-actions__link" href="<?php echo esc_url($shop_url); ?>">Produits</a>
            <a class="site-actions__link site-actions__cart" href="<?php echo esc_url($cart_url); ?>">Panier</a>
        </div>
    </div>
</header>
<main class="site-main">
