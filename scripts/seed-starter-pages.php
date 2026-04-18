<?php
if (! defined('ABSPATH')) {
    exit("This script must be run through WP-CLI with `wp eval-file`.\n");
}

$pages = [
    [
        'title'   => 'Accueil',
        'slug'    => 'accueil',
        'content' => '<!-- wp:paragraph --><p>Créactive Paris conçoit des accessoires de salle de bain design pour l’hôtellerie, les résidences premium, les collectivités et les projets architecturaux exigeants.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Découvrez nos collections, nos univers d’usage et notre accompagnement sur les projets standards ou sur-mesure.</p><!-- /wp:paragraph -->',
    ],
    [
        'title'   => 'La marque',
        'slug'    => 'la-marque',
        'content' => '<!-- wp:paragraph --><p>Créactive Paris imagine des accessoires de salle de bain au design précis, pensés pour durer et s’intégrer naturellement aux projets hôteliers, résidentiels haut de gamme et aux collectivités.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>La marque collabore avec des designers, sélectionne ses matières avec exigence et développe des collections capables d’allier élégance, robustesse et cohérence d’ensemble.</p><!-- /wp:paragraph --><!-- wp:heading {"level":3} --><h3>Notre approche</h3><!-- /wp:heading --><!-- wp:list --><ul><li>Collections à forte identité visuelle</li><li>Fabrication adaptée aux usages intensifs</li><li>Finitions soignées et personnalisables</li><li>Accompagnement des projets standards et sur-mesure</li></ul><!-- /wp:list -->',
    ],
    [
        'title'   => 'Contact',
        'slug'    => 'contact',
        'content' => '<!-- wp:paragraph --><p>Vous avez un projet d’aménagement, une demande de devis ou une question sur une finition ? Utilisez le formulaire ci-dessous pour nous transmettre votre besoin.</p><!-- /wp:paragraph --><!-- wp:shortcode -->[creactive_contact_form]<!-- /wp:shortcode -->',
    ],
    [
        'title'   => 'Réalisations',
        'slug'    => 'realisations',
        'content' => '<!-- wp:paragraph --><p>Créactive Paris accompagne des projets hôteliers, résidentiels et collectifs où la qualité perçue, la résistance à l’usage et la cohérence d’ensemble sont essentielles.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Cette page peut mettre en avant des réalisations, des références d’établissements, des partenariats avec architectes et des focus sur les produits installés.</p><!-- /wp:paragraph -->',
    ],
];

$created_ids = [];

foreach ($pages as $page) {
    $existing = get_page_by_path($page['slug']);

    $postarr = [
        'post_type'    => 'page',
        'post_title'   => $page['title'],
        'post_name'    => $page['slug'],
        'post_status'  => 'publish',
        'post_content' => $page['content'],
    ];

    if ($existing instanceof WP_Post) {
        $postarr['ID'] = $existing->ID;
        $page_id = wp_update_post($postarr, true);
        $action = 'updated';
    } else {
        $page_id = wp_insert_post($postarr, true);
        $action = 'created';
    }

    if (is_wp_error($page_id)) {
        WP_CLI::error(sprintf('Failed to create/update page %s: %s', $page['title'], $page_id->get_error_message()));
    }

    $created_ids[$page['slug']] = (int) $page_id;
    WP_CLI::log(sprintf('%s page: %s (%d)', ucfirst($action), $page['title'], $page_id));
}

if (isset($created_ids['accueil'])) {
    update_option('show_on_front', 'page');
    update_option('page_on_front', $created_ids['accueil']);
    WP_CLI::log('Assigned “Accueil” as static front page.');
}

$primary_menu = wp_get_nav_menu_object('Menu principal');
if (! $primary_menu) {
    $menu_id = wp_create_nav_menu('Menu principal');
    $primary_menu = wp_get_nav_menu_object($menu_id);
    WP_CLI::log('Created menu: Menu principal');
}

$footer_menu = wp_get_nav_menu_object('Menu footer');
if (! $footer_menu) {
    $menu_id = wp_create_nav_menu('Menu footer');
    $footer_menu = wp_get_nav_menu_object($menu_id);
    WP_CLI::log('Created menu: Menu footer');
}

$primary_items = ['accueil', 'la-marque', 'contact', 'realisations'];
$footer_items  = ['la-marque', 'contact', 'realisations'];

$assign_menu_items = static function (WP_Term $menu, array $slugs, array $ids): void {
    $existing_items = wp_get_nav_menu_items($menu->term_id) ?: [];
    $existing_map = [];
    foreach ($existing_items as $item) {
        $existing_map[(int) $item->object_id] = true;
    }

    foreach ($slugs as $slug) {
        if (empty($ids[$slug])) {
            continue;
        }
        $object_id = (int) $ids[$slug];
        if (isset($existing_map[$object_id])) {
            continue;
        }
        wp_update_nav_menu_item($menu->term_id, 0, [
            'menu-item-title'     => get_the_title($object_id),
            'menu-item-object'    => 'page',
            'menu-item-object-id' => $object_id,
            'menu-item-type'      => 'post_type',
            'menu-item-status'    => 'publish',
        ]);
    }
};

$assign_menu_items($primary_menu, $primary_items, $created_ids);
$assign_menu_items($footer_menu, $footer_items, $created_ids);

$locations = get_theme_mod('nav_menu_locations', []);
$locations['primary'] = (int) $primary_menu->term_id;
$locations['footer']  = (int) $footer_menu->term_id;
set_theme_mod('nav_menu_locations', $locations);

WP_CLI::success('Starter pages, front page assignment, and menus are ready.');
