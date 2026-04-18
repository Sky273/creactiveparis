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
        'content' => '<!-- wp:paragraph --><p>Créactive Paris accompagne des projets hôteliers, résidentiels et collectifs où la qualité perçue, la résistance à l’usage et la cohérence d’ensemble sont essentielles.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Retrouvez des réalisations, des ambiances livrées, des références d’établissements et des produits installés pour vous projeter plus facilement dans un projet comparable au vôtre.</p><!-- /wp:paragraph -->',
    ],
    [
        'title'   => 'Blog',
        'slug'    => 'blog',
        'content' => '<!-- wp:paragraph --><p>Le blog Créactive Paris rassemble des actualités, des conseils d’aménagement, des focus produits et des contenus d’inspiration destinés aux décideurs, architectes et prescripteurs.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Vous y trouverez des repères utiles pour comparer les options, affiner vos choix et avancer plus sereinement avant une sélection produit ou une demande de devis.</p><!-- /wp:paragraph -->',
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

$primary_items = ['accueil', 'la-marque', 'realisations', 'blog', 'contact'];
$footer_items  = ['la-marque', 'realisations', 'blog', 'contact'];

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

$categories = [
    'realisations' => 'Réalisations',
    'blog'         => 'Blog',
];

$category_ids = [];
foreach ($categories as $slug => $name) {
    $term = get_term_by('slug', $slug, 'category');

    if (! $term) {
        $term = wp_insert_term($name, 'category', ['slug' => $slug]);
    }

    if (is_wp_error($term)) {
        WP_CLI::error(sprintf('Failed to create/update category %s: %s', $name, $term->get_error_message()));
    }

    $category_ids[$slug] = (int) (is_array($term) ? $term['term_id'] : $term->term_id);
}

$posts = [
    [
        'title'      => 'Projet test – Hôtel signature',
        'slug'       => 'projet-test-hotel-signature',
        'category'   => 'realisations',
        'excerpt'    => 'Une première réalisation pour découvrir l’esprit d’un projet équipé par Créactive Paris.',
        'content'    => '<!-- wp:paragraph --><p>Découvrez une première réalisation illustrant la manière dont les collections Créactive Paris peuvent structurer une salle de bain, renforcer l’identité d’un lieu et répondre à des exigences élevées en matière d’usage comme d’esthétique.</p><!-- /wp:paragraph -->',
    ],
    [
        'title'      => 'Article test – Tendances salle de bain 2026',
        'slug'       => 'article-test-tendances-salle-de-bain-2026',
        'category'   => 'blog',
        'excerpt'    => 'Un premier contenu éditorial pour mieux comparer les options et nourrir la réflexion projet.',
        'content'    => '<!-- wp:paragraph --><p>Ce premier article partage des repères utiles pour réfléchir aux finitions, à l’ambiance recherchée et au niveau d’exigence attendu dans un projet hôtelier, résidentiel ou collectif.</p><!-- /wp:paragraph -->',
    ],
];

foreach ($posts as $post_data) {
    $existing = get_page_by_path($post_data['slug'], OBJECT, 'post');

    $postarr = [
        'post_type'     => 'post',
        'post_title'    => $post_data['title'],
        'post_name'     => $post_data['slug'],
        'post_status'   => 'publish',
        'post_excerpt'  => $post_data['excerpt'],
        'post_content'  => $post_data['content'],
        'post_category' => [$category_ids[$post_data['category']]],
    ];

    if ($existing instanceof WP_Post) {
        $postarr['ID'] = $existing->ID;
        $post_id = wp_update_post($postarr, true);
        $action = 'updated';
    } else {
        $post_id = wp_insert_post($postarr, true);
        $action = 'created';
    }

    if (is_wp_error($post_id)) {
        WP_CLI::error(sprintf('Failed to create/update post %s: %s', $post_data['title'], $post_id->get_error_message()));
    }

    WP_CLI::log(sprintf('%s post: %s (%d)', ucfirst($action), $post_data['title'], $post_id));
}

$locations = get_theme_mod('nav_menu_locations', []);
$locations['primary'] = (int) $primary_menu->term_id;
$locations['footer']  = (int) $footer_menu->term_id;
set_theme_mod('nav_menu_locations', $locations);

WP_CLI::success('Starter pages, menus, categories, and test posts are ready.');
