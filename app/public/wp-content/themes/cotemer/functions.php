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

function cotemer_register_menu_post_type() {
  register_post_type('menu_item',
    array(
      'labels'      => array(
        'name'          => __('Menus', 'cotemer'),
        'singular_name' => __('Menu', 'cotemer'),
        'add_new'       => __('Ajouter un nouveau menu', 'cotemer'),
        'add_new_item'  => __('Ajouter un menu'),
        'edit_item'     => __('Modifier le menu'),
        'new_item'      => __('Nouveau menu'),
        'view_item'     => __('Voir le menu'),
        'search_items'  => __('Rechercher un menu'),
        'not_found'     => __('Aucun menu trouvé'),
      ),
      'public'      => true,
      'has_archive' => false,
      'supports'    => array('title', 'thumbnail', 'editor'),
      'menu_icon'   => 'dashicons-media-document',
      'show_in_rest'=> true,
    )
  );
}
add_action('init', 'cotemer_register_menu_post_type');

function cotemer_add_pdf_meta_box() {
  add_meta_box(
    'cotemer_pdf_meta_box',              // ID
    __('Fichier PDF du menu', 'cotemer'), // Titre
    'cotemer_pdf_meta_box_callback',     // Callback
    'menu_item',                         // Custom post type
    'normal',                            // Position
    'high'                               // Priority
  );
}
add_action('add_meta_boxes', 'cotemer_add_pdf_meta_box');

function cotemer_pdf_meta_box_callback($post) {
  wp_nonce_field('cotemer_save_pdf_meta_box', 'cotemer_pdf_meta_box_nonce');

  $pdf_url = get_post_meta($post->ID, '_cotemer_pdf_url', true);

  echo '<p>';
  echo '<label for="cotemer_pdf_url">' . __('URL du fichier PDF', 'cotemer') . '</label><br>';
  echo '<input type="text" id="cotemer_pdf_url" name="cotemer_pdf_url" value="' . esc_attr($pdf_url) . '" style="width:100%;" />';
  echo '</p>';
  echo '<p>';
  echo '<button class="button" id="cotemer_upload_pdf_button">' . __('Téléverser un PDF', 'cotemer') . '</button>';
  echo '</p>';

  // Script pour la librairie Media Uploader
  ?>
  <script>
    jQuery(document).ready(function($){
      var mediaUploader;
      $('#cotemer_upload_pdf_button').click(function(e){
        e.preventDefault();
        if(mediaUploader){
          mediaUploader.open();
          return;
        }
        mediaUploader = wp.media({
          title: '<?php echo __("Choisir un fichier PDF", "cotemer"); ?>',
          button: { text: '<?php echo __("Utiliser ce PDF", "cotemer"); ?>' },
          multiple: false
        });
        mediaUploader.on('select', function(){
          var attachment = mediaUploader.state().get('selection').first().toJSON();
          $('#cotemer_pdf_url').val(attachment.url);
        });
        mediaUploader.open();
      });
    });
  </script>
  <?php
}

function cotemer_save_pdf_meta_box($post_id) {
  if (!isset($_POST['cotemer_pdf_meta_box_nonce'])) {
    return;
  }
  if (!wp_verify_nonce($_POST['cotemer_pdf_meta_box_nonce'], 'cotemer_save_pdf_meta_box')) {
    return;
  }
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return;
  }
  if (!current_user_can('edit_post', $post_id)) {
    return;
  }
  if (isset($_POST['cotemer_pdf_url'])) {
    update_post_meta($post_id, '_cotemer_pdf_url', sanitize_text_field($_POST['cotemer_pdf_url']));
  }
}
add_action('save_post', 'cotemer_save_pdf_meta_box');


function cotemer_allow_pdf_uploads($mime_types) {
  $mime_types['pdf'] = 'application/pdf';
  return $mime_types;
}
add_filter('upload_mimes', 'cotemer_allow_pdf_uploads');
?>


