<?php
get_header();
$projects = [
    [
        'title' => 'Hôtellerie haut de gamme',
        'description' => 'Valorisez des chambres et suites avec des finitions coordonnées, une écriture design cohérente et une durabilité adaptée à l’usage intensif.',
        'image' => 'https://www.creactive-paris.fr/wp-content/uploads/2023/08/visuel-brosse-1536x640.jpg',
    ],
    [
        'title' => 'Résidences services & premium living',
        'description' => 'Composez des salles de bain élégantes, contemporaines et faciles à maintenir grâce à une sélection d’accessoires harmonisés.',
        'image' => 'https://www.creactive-paris.fr/wp-content/uploads/2023/08/visuel-porte-savon-1536x640.jpg',
    ],
    [
        'title' => 'Collectivités & établissements recevant du public',
        'description' => 'Des solutions robustes, lisibles et fonctionnelles pour les environnements à forte fréquentation, y compris les besoins PMR.',
        'image' => 'https://www.creactive-paris.fr/wp-content/uploads/2023/08/visuel-derouleur-1536x640.jpg',
    ],
];
?>
<section class="page-hero page-hero--projects">
    <div class="container page-hero__inner">
        <p class="section-kicker">Réalisations</p>
        <h1>Une page éditoriale pour raconter les univers de pose</h1>
        <p>Cette page sert de vitrine inspirationnelle pour montrer comment les collections Créactive Paris s’intègrent à des environnements de prestige ou à forte exigence d’exploitation.</p>
    </div>
</section>

<section class="section page-section">
    <div class="container editorial-grid editorial-grid--projects">
        <div class="editorial-copy">
            <?php while (have_posts()) : the_post(); ?>
                <article <?php post_class(); ?>>
                    <div class="entry-content entry-content--premium"><?php the_content(); ?></div>
                </article>
            <?php endwhile; ?>
        </div>
        <aside class="editorial-aside">
            <div class="info-card">
                <p class="info-card__label">Usage conseillé</p>
                <h2>Page parfaite pour rassurer et inspirer</h2>
                <p>Ajoutez ensuite vos vraies références client, photos d’ambiance, architectes partenaires et fiches projet pour transformer cette base en outil commercial.</p>
            </div>
        </aside>
    </div>
</section>

<section class="section section--soft">
    <div class="container">
        <div class="section-heading section-heading--centered">
            <p class="section-kicker">Typologies de projets</p>
            <h2>Trois mises en situation premium</h2>
        </div>
        <div class="project-showcase-grid">
            <?php foreach ($projects as $project) : ?>
                <article class="project-showcase-card">
                    <div class="project-showcase-card__image" style="background-image:url('<?php echo esc_url($project['image']); ?>');"></div>
                    <div class="project-showcase-card__content">
                        <h3><?php echo esc_html($project['title']); ?></h3>
                        <p><?php echo esc_html($project['description']); ?></p>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php get_footer(); ?>
