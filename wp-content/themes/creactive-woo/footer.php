<?php
if (! defined('ABSPATH')) {
    exit;
}
?>
</main>
<footer class="site-footer">
    <div class="container site-footer__grid">
        <div>
            <?php echo creactive_woo_logo_markup('light'); ?>
            <p>Spécialiste de l'accastillage pour salles de bain</p>
            <p>6 rue de la Chanterie, 49124 Saint-Barthélémy-d'Anjou, France</p>
            <p><a href="tel:+33253618829">+33 (0)2 53 61 88 29</a></p>
        </div>
        <div>
            <h3>Navigation</h3>
            <?php
            wp_nav_menu([
                'theme_location' => 'footer',
                'container'      => false,
                'fallback_cb'    => 'creactive_woo_menu_fallback',
            ]);
            ?>
        </div>
        <div>
            <h3>Newsletter</h3>
            <p>Inscrivez-vous à notre newsletter pour suivre nos nouveautés.</p>
            <?php if (is_active_sidebar('footer-newsletter')) : ?>
                <?php dynamic_sidebar('footer-newsletter'); ?>
            <?php else : ?>
                <p>Ajoutez ici un formulaire newsletter via un widget ou un shortcode.</p>
            <?php endif; ?>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
