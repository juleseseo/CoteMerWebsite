
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<header id="site-header">
    <div class="header-container">

        <!-- Logo -->
        <div class="logo">
            <a href="#accueil">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.png" alt="Logo du restaurant">
            </a>
        </div>

        <!-- Burger icon (mobile) -->
        <div class="burger" id="burger">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <!-- Navigation -->
        <nav class="main-nav" id="main-nav">
            <ul class="nav-list">
                <li><a href="#accueil">Accueil</a></li>
                <li><a href="#about">Présentation</a> </li>
                <li><a href="#menu">Menu</a></li>
                <li><a href="#galerie">Galerie</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </nav>

    </div>
</header>
