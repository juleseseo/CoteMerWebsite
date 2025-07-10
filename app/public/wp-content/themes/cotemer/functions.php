<?php
function cotemer_enqueue_styles() {
    wp_enqueue_style('cotemer-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'cotemer_enqueue_styles');
