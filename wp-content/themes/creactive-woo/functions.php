<?php
if (! defined('ABSPATH')) {
    exit;
}

function creactive_woo_setup(): void
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', [
        'height'      => 80,
        'width'       => 280,
        'flex-height' => true,
        'flex-width'  => true,
    ]);
    add_theme_support('woocommerce');
    add_theme_support('html5', ['search-form', 'gallery', 'caption', 'style', 'script']);

    register_nav_menus([
        'primary' => __('Menu principal', 'creactive-woo'),
        'footer'  => __('Menu footer', 'creactive-woo'),
    ]);
}
add_action('after_setup_theme', 'creactive_woo_setup');

function creactive_woo_enqueue_assets(): void
{
    wp_enqueue_style(
        'creactive-woo-fonts',
        'https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;600;700&family=Yeseva+One&display=swap',
        [],
        null
    );

    wp_enqueue_style(
        'creactive-woo-main',
        get_template_directory_uri() . '/assets/css/main.css',
        ['woocommerce-general', 'creactive-woo-fonts'],
        filemtime(get_template_directory() . '/assets/css/main.css')
    );
}
add_action('wp_enqueue_scripts', 'creactive_woo_enqueue_assets');

function creactive_woo_register_sidebars(): void
{
    register_sidebar([
        'name'          => __('Footer newsletter', 'creactive-woo'),
        'id'            => 'footer-newsletter',
        'before_widget' => '<div class="footer-widget">',
        'after_widget'  => '</div>',
    ]);
}
add_action('widgets_init', 'creactive_woo_register_sidebars');

function creactive_woo_menu_fallback(): void
{
    echo '<ul class="menu-fallback">';
    echo '<li><a href="' . esc_url(home_url('/')) . '">Accueil</a></li>';
    echo '<li><a href="' . esc_url(home_url('/boutique/')) . '">Produits</a></li>';
    echo '<li><a href="' . esc_url(home_url('/la-marque/')) . '">La marque</a></li>';
    echo '<li><a href="' . esc_url(home_url('/realisations/')) . '">Réalisations</a></li>';
    echo '<li><a href="' . esc_url(creactive_woo_contact_url()) . '">Contact</a></li>';
    echo '</ul>';
}

function creactive_woo_contact_url(): string
{
    return home_url('/?page_id=7');
}

function creactive_woo_term_link(string $slug): string
{
    $term = get_term_by('slug', $slug, 'product_cat');

    if ($term && ! is_wp_error($term)) {
        return (string) get_term_link($term);
    }

    return home_url('/boutique/');
}

function creactive_woo_collection_cards(): array
{
    return [
        [
            'slug'        => 'creasmart',
            'title'       => 'CreaSmart',
            'subtitle'    => 'Des produits originaux, conçus par nos designers et fabriqués localement en cherchant à minimiser l\'impact environnemental.',
            'description' => 'Nos solutions design, originales et responsables.',
        ],
        [
            'slug'        => 'creasoft',
            'title'       => 'CreaSoft',
            'subtitle'    => 'Nos solutions intemporelles, modernes et épurées.',
            'description' => 'Une ligne accessible pensée pour les hôtels, résidences et collectivités.',
        ],
        [
            'slug'        => 'creamust',
            'title'       => 'CreaMust',
            'subtitle'    => 'Des produits massifs et des finitions soignées pour vos univers d\'exception.',
            'description' => 'Une collection premium inspirée du site original.',
        ],
    ];
}

function creactive_woo_usage_cards(): array
{
    return [
        ['title' => 'VASQUE', 'description' => 'Porte-savons, miroirs, patères et accessoires pour le plan vasque.'],
        ['title' => 'WC', 'description' => 'Dérouleurs, goupillons, réserves papier et équipements assortis.'],
        ['title' => 'DOUCHE', 'description' => 'Parois, barres, racks et accessoires pour univers humides.'],
        ['title' => 'PMR', 'description' => 'Produits fonctionnels pensés pour l\'accessibilité et les collectivités.'],
    ];
}

function creactive_woo_featured_products_query(): WP_Query
{
    $args = [
        'post_type'      => 'product',
        'posts_per_page' => 8,
        'post_status'    => 'publish',
        'meta_query'     => WC()->query->get_meta_query(),
        'tax_query'      => WC()->query->get_tax_query(),
    ];

    $featured_ids = wc_get_featured_product_ids();
    if (! empty($featured_ids)) {
        $args['post__in'] = $featured_ids;
        $args['orderby']  = 'post__in';
    }

    return new WP_Query($args);
}

function creactive_woo_quote_url(?WC_Product $product = null): string
{
    $product = $product ?: wc_get_product(get_the_ID());
    $title   = $product ? $product->get_name() : get_the_title();

    return add_query_arg(
        ['product' => rawurlencode($title)],
        creactive_woo_contact_url()
    );
}

function creactive_woo_price_html(string $price, WC_Product $product): string
{
    if ($product->get_price() === '') {
        return '<span class="price price--quote">Tarif sur demande</span>';
    }

    return $price;
}
add_filter('woocommerce_get_price_html', 'creactive_woo_price_html', 20, 2);

function creactive_woo_single_quote_button(): void
{
    global $product;

    if (! $product instanceof WC_Product) {
        return;
    }

    if ($product->get_price() !== '') {
        return;
    }

    echo '<a class="button alt creactive-quote-button" href="' . esc_url(creactive_woo_quote_url($product)) . '">Demander un devis</a>';
}
add_action('woocommerce_single_product_summary', 'creactive_woo_single_quote_button', 31);

function creactive_woo_loop_quote_button(string $html, WC_Product $product): string
{
    if ($product->get_price() !== '') {
        return $html;
    }

    return '<a class="button creactive-loop-quote" href="' . esc_url(creactive_woo_quote_url($product)) . '">Demander un devis</a>';
}
add_filter('woocommerce_loop_add_to_cart_link', 'creactive_woo_loop_quote_button', 10, 2);

function creactive_woo_logo_markup(string $variant = 'dark'): string
{
    $filename = $variant === 'light' ? 'creactive-logo-light.svg' : 'creactive-logo-dark.svg';
    $asset    = get_template_directory_uri() . '/assets/images/' . $filename;

    return '<a class="site-logo-link" href="' . esc_url(home_url('/')) . '"><img class="site-logo-image" src="' . esc_url($asset) . '" alt="Créactive Paris"></a>';
}

function creactive_woo_contact_form_shortcode(): string
{
    $status = isset($_GET['contact_status']) ? sanitize_text_field(wp_unslash($_GET['contact_status'])) : '';
    $message = '';

    if ($status === 'success') {
        $message = '<p class="contact-form__notice contact-form__notice--success">Merci, votre demande a bien été envoyée.</p>';
    } elseif ($status === 'error') {
        $message = '<p class="contact-form__notice contact-form__notice--error">Une erreur est survenue lors de l’envoi. Merci de réessayer.</p>';
    }

    ob_start();
    ?>
    <div class="contact-form-block">
        <?php echo $message; ?>
        <form class="contact-form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
            <input type="hidden" name="action" value="creactive_contact_form_submit">
            <?php wp_nonce_field('creactive_contact_form'); ?>
            <div class="contact-form__grid">
                <label>
                    <span>Nom</span>
                    <input type="text" name="contact_name" required>
                </label>
                <label>
                    <span>Email</span>
                    <input type="email" name="contact_email" required>
                </label>
                <label>
                    <span>Téléphone</span>
                    <input type="text" name="contact_phone">
                </label>
                <label>
                    <span>Société / établissement</span>
                    <input type="text" name="contact_company">
                </label>
            </div>
            <label>
                <span>Votre message</span>
                <textarea name="contact_message" rows="6" required></textarea>
            </label>
            <button class="button button--filled" type="submit">Envoyer la demande</button>
        </form>
    </div>
    <?php
    return (string) ob_get_clean();
}
add_shortcode('creactive_contact_form', 'creactive_woo_contact_form_shortcode');

function creactive_woo_handle_contact_form(): void
{
    check_admin_referer('creactive_contact_form');

    $name    = isset($_POST['contact_name']) ? sanitize_text_field(wp_unslash($_POST['contact_name'])) : '';
    $email   = isset($_POST['contact_email']) ? sanitize_email(wp_unslash($_POST['contact_email'])) : '';
    $phone   = isset($_POST['contact_phone']) ? sanitize_text_field(wp_unslash($_POST['contact_phone'])) : '';
    $company = isset($_POST['contact_company']) ? sanitize_text_field(wp_unslash($_POST['contact_company'])) : '';
    $body    = isset($_POST['contact_message']) ? sanitize_textarea_field(wp_unslash($_POST['contact_message'])) : '';

    $admin_email = (string) get_option('admin_email');
    $subject     = sprintf('Nouvelle demande depuis le site - %s', $name ?: 'Contact');
    $message     = "Nom : {$name}\n";
    $message    .= "Email : {$email}\n";
    $message    .= "Téléphone : {$phone}\n";
    $message    .= "Société : {$company}\n\n";
    $message    .= "Message :\n{$body}\n";

    $headers = [];
    if ($email) {
        $headers[] = 'Reply-To: ' . $email;
    }

    $redirect = wp_get_referer() ?: creactive_woo_contact_url();
    $sent     = wp_mail($admin_email, $subject, $message, $headers);

    wp_safe_redirect(add_query_arg('contact_status', $sent ? 'success' : 'error', $redirect));
    exit;
}
add_action('admin_post_nopriv_creactive_contact_form_submit', 'creactive_woo_handle_contact_form');
add_action('admin_post_creactive_contact_form_submit', 'creactive_woo_handle_contact_form');
