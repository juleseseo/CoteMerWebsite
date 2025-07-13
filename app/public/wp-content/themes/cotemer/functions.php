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
}
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