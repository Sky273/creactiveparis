# Creactive Paris WooCommerce starter

Ce dépôt contient une base WooCommerce inspirée du site https://www.creactive-paris.fr/.

Ce qui est inclus :
- un thème WordPress personnalisé `creactive-woo`
- une configuration Docker Compose pour WordPress + MariaDB + WP-CLI
- un import CSV WooCommerce généré depuis le catalogue public existant
- un mode catalogue élégant : si un produit n'a pas de prix, le site affiche `Tarif sur demande` avec un bouton `Demander un devis`
- des pages WordPress prêtes à l'emploi avec contenu initial : `Accueil`, `La marque`, `Contact`, `Réalisations`
- un formulaire de contact natif via shortcode `[creactive_contact_form]`

## Démarrage local

1. Copier l'environnement :
   `cp .env.example .env`
2. Lancer WordPress :
   `docker compose up -d`
3. Installer WordPress depuis le navigateur :
   `http://localhost:8080`
4. Installer et activer WooCommerce dans l'admin.
5. Activer le thème :
   `docker compose run --rm wpcli wp theme activate creactive-woo`

## Pages starter prêtes à l'emploi

Après activation du thème, exécuter :

`docker compose run --rm wpcli wp eval-file /opt/project-scripts/seed-starter-pages.php`

Ce script :
- crée ou met à jour les pages `Accueil`, `La marque`, `Contact`, `Réalisations`
- affecte `Accueil` comme page d'accueil statique
- crée les menus `Menu principal` et `Menu footer`
- ajoute automatiquement les liens de base dans les menus

Templates inclus dans le thème :
- `front-page.php` pour l'accueil premium
- `page-la-marque.php`
- `page-contact.php`
- `page-realisations.php`

## Import du catalogue

1. Dans WordPress admin > Produits > Importer
2. Importer le fichier `data/products-import.csv`
3. Mapper les colonnes si WooCommerce le demande :
   - Type -> type
   - SKU -> sku
   - Nom -> name
   - Description -> description
   - Description courte -> short_description
   - Catégories -> categories
   - Images -> images
   - Attributs -> Attributes 1..5
4. Après l'import, définir quelques produits `mis en avant` pour alimenter la home.

## Menus et pages recommandées

Créer les pages :
- Accueil
- La marque
- Contact
- Nos réalisations
- Catalogue PDF

Puis définir :
- Réglages > Lecture > page d'accueil statique = Accueil
- Apparence > Menus > menu principal

## Remarques importantes

- Le repo GitHub fourni était vide au moment de la génération, donc cette base a été créée from scratch.
- Le site source n'affiche pas publiquement les prix. Les produits importés sont donc en mode catalogue / devis tant qu'aucun prix n'est saisi dans WooCommerce.
- Les images produits pointent vers les médias publics existants du site source, ce qui permet un import rapide. Vous pourrez ensuite les rapatrier localement si besoin.

## Structure

- `wp-content/themes/creactive-woo` : thème principal
- `wp-content/mu-plugins/creactive-catalog-mode.php` : comportements catalogue/devis
- `scripts/seed-starter-pages.php` : création automatique des pages et menus WordPress
- `data/products-import.csv` : catalogue WooCommerce
- `data/scraped-products.json` : données sources structurées
