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
?>
<section class="hero hero--premium">
    <div class="hero__media" style="background-image:url('<?php echo esc_url($hero_image); ?>');"></div>
    <div class="hero__veil"></div>
    <div class="container hero__grid">
        <div class="hero__copy">
            <p class="hero__eyebrow">Créactive Paris</p>
            <h1>Un univers e-commerce plus premium pour l’accastillage de salle de bain</h1>
            <p class="hero__lead">Un thème WooCommerce retravaillé dans un esprit éditorial, haut de gamme et contemporain, fidèle au territoire visuel de la marque et à ses collections iconiques.</p>
            <div class="hero__actions">
                <a class="button button--filled" href="<?php echo esc_url($shop_url); ?>">Découvrir les collections</a>
                <a class="button button--ghost" href="<?php echo esc_url($contact_url); ?>">Parler d’un projet</a>
            </div>
        </div>
        <aside class="hero__panel">
            <p class="hero-panel__label">Signature</p>
            <h2>Créateur et fabricant français</h2>
            <p>Accessoires de salle de bain originaux, robustes et éco-conçus pour l’hôtellerie, les résidences premium et les collectivités.</p>
            <ul class="hero-panel__stats">
                <li><strong>292</strong><span>produits importés</span></li>
                <li><strong>11</strong><span>gammes structurées</span></li>
                <li><strong>3</strong><span>collections principales</span></li>
            </ul>
        </aside>
    </div>
</section>

<section class="section section--metrics">
    <div class="container metrics-strip">
        <article><span>Design français</span><strong>Élégance fonctionnelle</strong></article>
        <article><span>Finitions soignées</span><strong>Bronze, doré, noir, inox</strong></article>
        <article><span>Approche projet</span><strong>Standard & sur-mesure</strong></article>
        <article><span>Positionnement</span><strong>Hospitality & premium living</strong></article>
    </div>
</section>

<section class="section section--story">
    <div class="container story-grid">
        <div class="story-copy">
            <p class="section-kicker">Maison & savoir-faire</p>
            <h2>Une direction artistique plus luxueuse, plus éditoriale, plus persuasive</h2>
            <p>Cette nouvelle home adopte un langage visuel plus premium : surfaces profondes, typographie plus noble, grands aplats, hiérarchie renforcée et cartes produits plus sophistiquées.</p>
            <p>Le résultat conserve l’ADN Créactive Paris tout en rapprochant l’expérience d’achat d’un site de marque haut de gamme.</p>
        </div>
        <div class="story-card">
            <p class="story-card__label">Ce qui change</p>
            <ul>
                <li>Hero immersif à double lecture marque / conversion</li>
                <li>Collections présentées comme des univers éditoriaux</li>
                <li>Contraste renforcé entre sections claires et sombres</li>
                <li>Cartes produits et CTA plus premium</li>
            </ul>
        </div>
    </div>
</section>

<section class="section section--collections-premium">
    <div class="container">
        <div class="section-heading section-heading--split">
            <div>
                <p class="section-kicker">Nos collections</p>
                <h2>Trois signatures pour structurer l’offre</h2>
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
            <p class="section-kicker">Des produits pour chaque usage</p>
            <h2>Une lecture plus claire du catalogue</h2>
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

<section class="section section--featured-premium">
    <div class="container">
        <div class="section-heading section-heading--split section-heading--light">
            <div>
                <p class="section-kicker">Nos incontournables</p>
                <h2>Produits mis en scène pour favoriser la conversion</h2>
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
                <p>Marquez quelques produits comme “mis en avant” après l’import WooCommerce pour enrichir cette section premium.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<section class="section section--craftsmanship">
    <div class="container craftsmanship-grid">
        <div class="craftsmanship-copy">
            <p class="section-kicker">Notre savoir-faire</p>
            <h2>Design, production, sur-mesure, accompagnement</h2>
            <p>Le thème met mieux en valeur la promesse de la marque : un partenaire design et technique capable de livrer des pièces durables, élégantes et adaptées à des projets exigeants.</p>
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

<section class="section section--cta-premium">
    <div class="container cta-banner">
        <div>
            <p class="section-kicker">Hospitality, résidences, collectivités</p>
            <h2>Prêt à transformer cette base en véritable boutique de marque ?</h2>
            <p>Le thème est désormais plus premium. La prochaine étape idéale consiste à peaufiner les templates WooCommerce internes, les pages de collection et le tunnel de demande de devis.</p>
        </div>
        <div class="cta-banner__actions">
            <a class="button button--filled" href="<?php echo esc_url($contact_url); ?>">Demander un devis</a>
            <a class="button button--outline" href="<?php echo esc_url($shop_url); ?>">Voir la boutique</a>
        </div>
    </div>
</section>
<?php get_footer(); ?>
