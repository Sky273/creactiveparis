<?php
get_header();
$featured_products = function_exists('WC') ? creactive_woo_featured_products_query() : new WP_Query(['post_type' => 'post', 'posts_per_page' => 0]);
$shop_url          = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/boutique/');
$contact_url       = home_url('/contact/');
$catalogue_url     = 'https://www.creactive-paris.fr/wp-content/uploads/2025/03/catalogue-2025.pdf';
$hero_image        = 'https://www.creactive-paris.fr/wp-content/uploads/2023/08/visuel-derouleur-vide-1536x640.jpg';
$collections       = [
    [
        'slug'        => 'creasmart',
        'title'       => 'CreaSmart',
        'label'       => 'Collection signature',
        'description' => 'Des produits originaux, conçus par des designers et fabriqués localement pour conjuguer style, robustesse et faible impact environnemental.',
        'image'       => 'https://www.creactive-paris.fr/wp-content/uploads/2023/08/visuel-derouleur-1536x640.jpg',
    ],
    [
        'slug'        => 'creasoft',
        'title'       => 'CreaSoft',
        'label'       => 'Ligne intemporelle',
        'description' => 'Une gamme moderne et épurée, pensée pour les établissements exigeants à la recherche d’une esthétique sobre et durable.',
        'image'       => 'https://www.creactive-paris.fr/wp-content/uploads/2023/08/visuel-porte-savon-1536x640.jpg',
    ],
    [
        'slug'        => 'creamust',
        'title'       => 'CreaMust',
        'label'       => 'Univers premium',
        'description' => 'Des pièces massives aux finitions raffinées pour les projets haut de gamme, l’hôtellerie d’exception et les résidences prestigieuses.',
        'image'       => 'https://www.creactive-paris.fr/wp-content/uploads/2023/08/visuel-brosse-1536x640.jpg',
    ],
];
$usages = [
    ['title' => 'VASQUE', 'description' => 'Porte-savons, miroirs, patères et accessoires pour composer un plan vasque élégant et fonctionnel.'],
    ['title' => 'WC', 'description' => 'Dérouleurs, goupillons, réserves papier et accessoires cohérents avec l’ensemble du projet.'],
    ['title' => 'DOUCHE', 'description' => 'Parois, racks et équipements adaptés aux espaces humides standards ou sur-mesure.'],
    ['title' => 'PMR', 'description' => 'Solutions pensées pour l’accessibilité, les collectivités et les environnements à forte fréquentation.'],
];
$services = [
    ['title' => 'Design', 'description' => 'Des collections au dessin précis, issues d’une collaboration étroite avec des designers français.'],
    ['title' => 'Production', 'description' => 'Un suivi exigeant des matières, finitions et process pour garantir un rendu premium.'],
    ['title' => 'Sur-mesure', 'description' => 'Adaptation des dimensions, finitions et produits pour répondre au cahier des charges de chaque projet.'],
    ['title' => 'Accompagnement', 'description' => 'Support commercial et technique pour l’hôtellerie, les résidences services et les collectivités.'],
];
$markets = [
    ['title' => 'Hôtellerie', 'description' => 'Pour créer des salles de bain élégantes, cohérentes et durables dans les chambres, suites et espaces communs.'],
    ['title' => 'Résidentiel premium', 'description' => 'Pour valoriser des programmes haut de gamme grâce à des accessoires au dessin fort et aux finitions maîtrisées.'],
    ['title' => 'Collectivités & ERP', 'description' => 'Pour répondre aux contraintes d’usage intensif, de maintenance et d’accessibilité sans sacrifier l’esthétique.'],
];
$process = [
    ['title' => '1. Cadrer le besoin', 'description' => 'Nous identifions les usages, les contraintes techniques, les finitions souhaitées et le niveau de gamme visé.'],
    ['title' => '2. Sélectionner les références', 'description' => 'Nous proposons les collections, gammes et produits les plus pertinents pour construire une offre cohérente.'],
    ['title' => '3. Finaliser la réponse', 'description' => 'Nous accompagnons la demande de devis, les adaptations sur-mesure et la consolidation de votre sélection finale.'],
];
?>
<section class="hero hero--premium">
    <div class="hero__media" style="background-image:url('<?php echo esc_url($hero_image); ?>');"></div>
    <div class="hero__veil"></div>
    <div class="container hero__grid">
        <div class="hero__copy">
            <p class="hero__eyebrow">Créactive Paris</p>
            <h1>Accessoires de salle de bain design pour hôtels, résidences et collectivités</h1>
            <p class="hero__lead">Créactive Paris conçoit des collections d’accastillage pensées pour les projets où l’élégance, la durabilité et la cohérence d’ensemble font la différence. Une offre structurée pour équiper les espaces vasque, WC, douche et PMR avec le même niveau d’exigence.</p>
            <div class="hero__actions">
                <a class="button button--filled" href="<?php echo esc_url($shop_url); ?>">Découvrir les collections</a>
                <a class="button button--ghost" href="<?php echo esc_url($contact_url); ?>">Parler d’un projet</a>
            </div>
        </div>
        <aside class="hero__panel">
            <p class="hero-panel__label">Pour vos projets</p>
            <h2>Une offre complète, du standard au sur-mesure</h2>
            <p>Des lignes contemporaines, des finitions soignées et un accompagnement commercial pour aider architectes, prescripteurs et exploitants à composer un univers salle de bain cohérent.</p>
            <ul class="hero-panel__stats">
                <li><strong>292</strong><span>références pour construire votre offre</span></li>
                <li><strong>11</strong><span>gammes pour couvrir plusieurs usages</span></li>
                <li><strong>3</strong><span>collections pour trois positionnements</span></li>
            </ul>
        </aside>
    </div>
</section>

<section class="section section--metrics">
    <div class="container metrics-strip">
        <article><span>Design français</span><strong>Collections au style durable et identifiable</strong></article>
        <article><span>Finitions</span><strong>Bronze, doré, noir, inox et déclinaisons coordonnées</strong></article>
        <article><span>Approche projet</span><strong>Références catalogue et adaptations sur-mesure</strong></article>
        <article><span>Marchés adressés</span><strong>Hôtellerie, premium living, résidences et ERP</strong></article>
    </div>
</section>

<section class="section section--story">
    <div class="container story-grid">
        <div class="story-copy">
            <p class="section-kicker">Entreprise & offre</p>
            <h2>Une marque pensée pour équiper les salles de bain avec cohérence</h2>
            <p>Créactive Paris ne vend pas seulement des pièces unitaires. La marque construit des ensembles complets capables d’unifier les zones vasque, WC, douche et accessibilité autour d’un même langage formel.</p>
            <p>L’objectif est simple : aider les porteurs de projet à créer des espaces plus lisibles, plus élégants et plus robustes, avec un niveau de finition compatible avec les environnements premium ou intensifs.</p>
        </div>
        <div class="story-card">
            <p class="story-card__label">Pourquoi choisir Créactive Paris</p>
            <ul>
                <li>Une offre lisible, organisée par collections, gammes et usages</li>
                <li>Des accessoires conçus pour durer dans le temps et à l’usage</li>
                <li>Des finitions premium pour valoriser chaque projet</li>
                <li>Un accompagnement pour les besoins standards ou sur-mesure</li>
            </ul>
        </div>
    </div>
</section>

<section class="section section--collections-premium">
    <div class="container">
        <div class="section-heading section-heading--split">
            <div>
                <p class="section-kicker">Nos collections</p>
                <h2>Trois collections pour répondre à chaque niveau de gamme</h2>
            </div>
            <a class="text-link" href="<?php echo esc_url($shop_url); ?>">Voir tout le catalogue</a>
        </div>
        <div class="collection-panels">
            <?php foreach ($collections as $card) : ?>
                <article class="collection-panel" style="background-image:url('<?php echo esc_url($card['image']); ?>');">
                    <div class="collection-panel__overlay"></div>
                    <div class="collection-panel__content">
                        <p class="collection-panel__label"><?php echo esc_html($card['label']); ?></p>
                        <h3><?php echo esc_html($card['title']); ?></h3>
                        <p><?php echo esc_html($card['description']); ?></p>
                        <a class="button button--ghost-dark" href="<?php echo esc_url(creactive_woo_term_link($card['slug'])); ?>">Explorer <?php echo esc_html($card['title']); ?></a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section section--usage-premium">
    <div class="container">
        <div class="section-heading section-heading--centered">
            <p class="section-kicker">Par zone d’usage</p>
            <h2>Une offre conçue pour couvrir chaque moment de la salle de bain</h2>
        </div>
        <div class="usage-grid-premium">
            <?php foreach ($usages as $item) : ?>
                <article class="usage-card-premium">
                    <p class="usage-card-premium__index"><?php echo esc_html($item['title']); ?></p>
                    <h3><?php echo esc_html($item['title']); ?></h3>
                    <p><?php echo esc_html($item['description']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section section--soft">
    <div class="container">
        <div class="section-heading section-heading--centered">
            <p class="section-kicker">Marchés adressés</p>
            <h2>Une réponse claire pour trois grands univers de prescription</h2>
        </div>
        <div class="premium-card-grid premium-card-grid--three">
            <?php foreach ($markets as $market) : ?>
                <article class="premium-card">
                    <h3><?php echo esc_html($market['title']); ?></h3>
                    <p><?php echo esc_html($market['description']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section section--featured-premium">
    <div class="container">
        <div class="section-heading section-heading--split section-heading--light">
            <div>
                <p class="section-kicker">Sélection produits</p>
                <h2>Quelques références pour démarrer votre prescription</h2>
            </div>
            <a class="text-link text-link--light" href="<?php echo esc_url($shop_url); ?>">Accéder à la boutique</a>
        </div>
        <?php if ($featured_products->have_posts()) : ?>
            <div class="products-grid products-grid--premium">
                <?php while ($featured_products->have_posts()) : $featured_products->the_post(); ?>
                    <?php global $product; ?>
                    <article <?php wc_product_class('product-card product-card--premium', $product); ?>>
                        <a href="<?php the_permalink(); ?>" class="product-card__image"><?php echo woocommerce_get_product_thumbnail('woocommerce_thumbnail'); ?></a>
                        <div class="product-card__content">
                            <p class="product-card__category"><?php echo wp_kses_post(wc_get_product_category_list(get_the_ID(), ', ')); ?></p>
                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <div class="product-card__price"><?php echo wp_kses_post($product->get_price_html()); ?></div>
                            <a class="product-card__link" href="<?php the_permalink(); ?>">Voir le produit</a>
                        </div>
                    </article>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        <?php else : ?>
            <div class="empty-state">
                <p>Ajoutez quelques références “mises en avant” pour guider immédiatement vos visiteurs vers les produits phares de votre offre.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<section class="section section--craftsmanship">
    <div class="container craftsmanship-grid">
        <div class="craftsmanship-copy">
            <p class="section-kicker">Notre savoir-faire</p>
            <h2>Design, production, sur-mesure, accompagnement</h2>
            <p>Créactive Paris accompagne les professionnels qui recherchent une offre à la fois désirable, fiable et simple à déployer. La marque associe intention décorative, solidité d’usage et capacité d’adaptation aux contraintes réelles du chantier.</p>
            <a class="button button--filled" href="<?php echo esc_url($catalogue_url); ?>" target="_blank" rel="noopener">Télécharger le catalogue</a>
        </div>
        <div class="craftsmanship-list">
            <?php foreach ($services as $service) : ?>
                <article>
                    <h3><?php echo esc_html($service['title']); ?></h3>
                    <p><?php echo esc_html($service['description']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section section--dark-band">
    <div class="container checklist-panel">
        <div>
            <p class="section-kicker">Méthode commerciale</p>
            <h2>Une approche simple pour transformer un besoin en sélection produit</h2>
        </div>
        <ul class="checklist-panel__list">
            <?php foreach ($process as $step) : ?>
                <li>
                    <strong><?php echo esc_html($step['title']); ?></strong><br>
                    <?php echo esc_html($step['description']); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>

<section class="section section--cta-premium">
    <div class="container cta-banner">
        <div>
            <p class="section-kicker">Hospitality, résidences, collectivités</p>
            <h2>Parlons de votre prochain projet d’aménagement</h2>
            <p>Besoin d’une sélection produit, d’une finition spécifique ou d’un accompagnement sur une opération complète ? L’équipe Créactive Paris vous aide à construire une réponse adaptée à votre cahier des charges.</p>
        </div>
        <div class="cta-banner__actions">
            <a class="button button--filled" href="<?php echo esc_url($contact_url); ?>">Demander un devis</a>
            <a class="button button--outline" href="<?php echo esc_url($shop_url); ?>">Voir le catalogue</a>
        </div>
    </div>
</section>
<?php get_footer(); ?>
