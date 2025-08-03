<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/assets/img/logo.png" type="image/png">
    <title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<header id="site-header">
    <div class="header-container">
        <!-- Logo -->
        <div class="logo">
            <a href="<?php echo home_url(); ?>">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.png" alt="Logo <?php bloginfo('name'); ?>">
            </a>
        </div>

        <div class="burger" id="burger">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <!-- Navigation -->
        <nav class="main-nav" id="main-nav">
            <ul class="nav-list">
                <li><a href="#accueil">Accueil</a></li>
                <li><a href="#menu">Menu</a></li>
                <li><a href="#gallery">Galerie</a></li>
                <li><a href="#about">À propos</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </nav>

        <!-- Sélecteur de langue -->
        <div class="language-switcher">
            <?php
            if (function_exists('pll_the_languages')) {
                pll_the_languages(array(
                    'dropdown' => 0,
                    'show_flags' => 1,
                    'show_names' => 0,
                    'hide_if_no_translation' => 1
                ));
            }
            ?>
        </div>
    </div>
</header>