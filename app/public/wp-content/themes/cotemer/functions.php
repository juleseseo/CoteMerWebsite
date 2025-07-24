<?php
function cotemer_enqueue_styles() {
    wp_enqueue_style('cotemer-style', get_stylesheet_uri());
    wp_enqueue_script('cotemer-main', get_template_directory_uri() . '/assets/js/main.js', array(), '1.0', true);
}
add_action('wp_enqueue_scripts', 'cotemer_enqueue_styles');


function cotemer_customize_register($wp_customize) {
  // Section Footer
  $wp_customize->add_section('cotemer_footer_section', array(
    'title'    => __('Information bas de page', 'cotemer'),
    'priority' => 30,
  ));

  // Adresse
  $wp_customize->add_setting('cotemer_footer_address', array(
    'default'   => '20 RUE DU GENERAL DE GAULLE, 56640 ARZON, France',
    'sanitize_callback' => 'sanitize_textarea_field',
  ));
  $wp_customize->add_control('cotemer_footer_address', array(
    'label'    => __('Adresse', 'cotemer'),
    'section'  => 'cotemer_footer_section',
    'type'     => 'textarea',
  ));

  // Téléphone
  $wp_customize->add_setting('cotemer_footer_phone', array(
    'default'   => '+33 2 97 53 63 67',
    'sanitize_callback' => 'sanitize_text_field',
  ));
  $wp_customize->add_control('cotemer_footer_phone', array(
    'label'    => __('Téléphone', 'cotemer'),
    'section'  => 'cotemer_footer_section',
    'type'     => 'text',
  ));

    // Mail
  $wp_customize->add_setting('cotemer_footer_mail', array(
    'default'   => 'cotemer.portnavalo@gmail.com',
    'sanitize_callback' => 'sanitize_text_field',
  ));

  $wp_customize->add_control('cotemer_footer_mail', array(
    'label'    => __('Mail', 'cotemer'),
    'section'  => 'cotemer_footer_section',
    'type'     => 'text',
  ));

  // Horaires
  $wp_customize->add_setting('cotemer_footer_hours', array(
    'default'   => 'Lundi - Samedi\n 9h - 21h30 \nFermé le dimanche',
    'sanitize_callback' => 'sanitize_textarea_field',
  ));
  $wp_customize->add_control('cotemer_footer_hours', array(
    'label'    => __('Horaires', 'cotemer'),
    'section'  => 'cotemer_footer_section',
    'type'     => 'textarea',
  ));

    // Section "À propos"
    $wp_customize->add_section('cotemer_about_section', array(
        'title'    => __('Section À propos', 'cotemer'),
        'priority' => 31,
    ));

// Bloc 1
    $wp_customize->add_setting('cotemer_about_title_1', array(
        'default' => 'Des Produits d\'Excellence',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('cotemer_about_title_1', array(
        'label'    => __('Titre bloc 1', 'cotemer'),
        'section'  => 'cotemer_about_section',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('cotemer_about_text_1', array(
        'default' => 'Nous travaillons exclusivement avec des produits frais, de saison...',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('cotemer_about_text_1', array(
        'label'    => __('Texte bloc 1', 'cotemer'),
        'section'  => 'cotemer_about_section',
        'type'     => 'textarea',
    ));

    $wp_customize->add_setting('cotemer_about_image_1', array(
        'default' => get_template_directory_uri() . '/assets/img/hormard_mer.jpg',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'cotemer_about_image_1', array(
        'label'    => __('Image bloc 1', 'cotemer'),
        'section'  => 'cotemer_about_section',
        'settings' => 'cotemer_about_image_1',
    )));

    // Bloc 2
    $wp_customize->add_setting('cotemer_about_title_2', array(
        'default' => 'Des Produits d\'Excellence',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('cotemer_about_title_2', array(
        'label'    => __('Titre bloc 2', 'cotemer'),
        'section'  => 'cotemer_about_section',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('cotemer_about_text_2', array(
        'default' => 'Nous travaillons exclusivement avec des produits frais, de saison...',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('cotemer_about_text_2', array(
        'label'    => __('Texte bloc 2', 'cotemer'),
        'section'  => 'cotemer_about_section',
        'type'     => 'textarea',
    ));

    $wp_customize->add_setting('cotemer_about_image_2', array(
        'default' => get_template_directory_uri() . '/assets/img/hormard_mer.jpg',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'cotemer_about_image_2', array(
        'label'    => __('Image bloc 2', 'cotemer'),
        'section'  => 'cotemer_about_section',
        'settings' => 'cotemer_about_image_2',
    )));
    // Bloc 3
    $wp_customize->add_setting('cotemer_about_title_3', array(
        'default' => 'Des Produits d\'Excellence',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('cotemer_about_title_3', array(
        'label'    => __('Titre bloc 3', 'cotemer'),
        'section'  => 'cotemer_about_section',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('cotemer_about_text_3', array(
        'default' => 'Nous travaillons exclusivement avec des produits frais, de saison...',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('cotemer_about_text_3', array(
        'label'    => __('Texte bloc 3', 'cotemer'),
        'section'  => 'cotemer_about_section',
        'type'     => 'textarea',
    ));

    $wp_customize->add_setting('cotemer_about_image_3', array(
        'default' => get_template_directory_uri() . '/assets/img/hormard_mer.jpg',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'cotemer_about_image_3', array(
        'label'    => __('Image bloc 3', 'cotemer'),
        'section'  => 'cotemer_about_section',
        'settings' => 'cotemer_about_image_3',
    )));
}
function cotemer_register_menu_post_type() {
  $labels = array(
    'name'               => 'Cartes du restaurant',
    'singular_name'      => 'Carte',
    'menu_name'          => 'Cartes du restaurant',
    'add_new'            => 'Ajouter une nouvelle carte',
    'add_new_item'       => 'Ajouter une nouvelle carte',
    'edit_item'          => 'Modifier la carte',
    'all_items'          => 'Toutes les cartes',
  );

  $args = array(
    'labels'             => $labels,
    'public'             => true,
    'show_in_rest'       => true, // Support Gutenberg
    'menu_icon'          => 'dashicons-media-document',
    'supports'           => array('title', 'thumbnail'),
  );

  register_post_type('restaurant_menu', $args);
}
add_action('init', 'cotemer_register_menu_post_type');

add_action('customize_register', 'cotemer_customize_register');

// Support pour les images à la une
add_theme_support('post-thumbnails');

// Support pour les menus
add_theme_support('menus');

// Nettoyage du head WordPress
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');
?>