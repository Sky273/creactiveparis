<?php
/**
 * Plugin Name: Creactive Catalog Mode
 * Description: Ajustements catalogue pour les produits sans prix.
 */

if (! defined('ABSPATH')) {
    exit;
}

add_filter('woocommerce_is_purchasable', function (bool $purchasable, WC_Product $product): bool {
    if ($product->get_price() === '') {
        return false;
    }

    return $purchasable;
}, 10, 2);
