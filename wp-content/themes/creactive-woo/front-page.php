<?php
get_header();
$featured_products = function_exists('WC') ? creactive_woo_featured_products_query() : new WP_Query(['post_type' => 'post', 'posts_per_page' => 0]);
$hero_image = 'https://www.creactive-paris.fr/wp-content/uploads/2023/08/visuel-derouleur-vide-1536x640.jpg';
$shop_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/boutique/');
?>
<section class="hero" style="background-image:url('<?php echo esc_url($hero_image); ?>');">
    <div class="hero__overlay"></div>
    <div class="container hero__content">
        <p class="hero__eyebrow">Créactive Paris</p>
        <h1>Spécialiste de l'accastillage pour salles de bain</h1>
        <p class="hero__lead">Créateur et fabricant français d'accessoires de salle de bain originaux, robustes et éco-conçus pour l'hôtellerie et les collectivités.</p>
        <div class="hero__actions">
            <a class="button button--filled" href="<?php echo esc_url($shop_url); ?>">Découvrir nos gammes</a>
            <a class="button button--ghost" href="<?php echo esc_url(home_url('/contact/')); ?>">Demander un devis</a>
        </div>
    </div>
</section>

<section class="section section--intro">
    <div class="container intro-grid">
        <div>
            <p class="section-kicker">Créateur et fabricant français</p>
            <h2>Accessoires de salle de bain originaux et éco-conçus</h2>
        </div>
        <div>
            <p>CREACTIVE PARIS collabore avec des designers pour développer des accessoires de salle de bain originaux, robustes et adaptés aux marchés de l’hôtellerie et des collectivités.</p>
            <p>Le choix des matériaux, des techniques de production et des finitions vise à optimiser l’impact environnemental des produits et à assurer un contrôle qualité rigoureux.</p>
        </div>
    </div>
</section>

<section class="section section--collections">
    <div class="container">
        <div class="section-heading">
            <p class="section-kicker">Nos collections</p>
            <h2>Une présentation fidèle à l'univers Créactive Paris</h2>
        </div>
        <div class="cards cards--collections">
            <?php foreach (creactive_woo_collection_cards() as $card) : ?>
                <article class="card collection-card">
                    <p class="collection-card__eyebrow"><?php echo esc_html($card['title']); ?></p>
                    <h3><?php echo esc_html($card['description']); ?></h3>
                    <p><?php echo esc_html($card['subtitle']); ?></p>
                    <a href="<?php echo esc_url(creactive_woo_term_link($card['slug'])); ?>">Découvrir la sélection</a>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section section--usage">
    <div class="container">
        <div class="section-heading">
            <p class="section-kicker">Des produits de chaque usage</p>
            <h2>Vasque, WC, douche et PMR</h2>
        </div>
        <div class="cards cards--usage">
            <?php foreach (creactive_woo_usage_cards() as $card) : ?>
                <article class="card usage-card">
                    <h3><?php echo esc_html($card['title']); ?></h3>
                    <p><?php echo esc_html($card['description']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section section--featured">
    <div class="container">
        <div class="section-heading">
            <p class="section-kicker">Nos incontournables</p>
            <h2>Produits mis en avant</h2>
        </div>
        <?php if ($featured_products->have_posts()) : ?>
            <div class="products-grid">
                <?php while ($featured_products->have_posts()) : $featured_products->the_post(); ?>
                    <?php global $product; ?>
                    <article <?php wc_product_class('product-card', $product); ?>>
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
            <p>Importez le catalogue puis marquez certains produits comme “mis en avant” pour alimenter cette section.</p>
        <?php endif; ?>
    </div>
</section>

<section class="section section--savoir-faire">
    <div class="container savoir-faire-grid">
        <div>
            <p class="section-kicker">Notre savoir-faire</p>
            <h2>Design, suivi de production, pose et service après-vente</h2>
        </div>
        <div class="savoir-faire-list">
            <article><h3>Design</h3><p>Collections élégantes pensées pour l'hôtellerie, le résidentiel premium et les collectivités.</p></article>
            <article><h3>Suivi de production</h3><p>Fabrication locale et contrôle qualité rigoureux.</p></article>
            <article><h3>Pose</h3><p>Produits compatibles avec les projets standards et sur-mesure.</p></article>
            <article><h3>Service après vente</h3><p>Accompagnement dans la durée sur les projets d'aménagement.</p></article>
        </div>
    </div>
</section>
<?php get_footer(); ?>
