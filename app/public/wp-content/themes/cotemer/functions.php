<?php
function cotemer_enqueue_styles() {
    wp_enqueue_style('cotemer-style', get_stylesheet_uri());
    wp_enqueue_script('cotemer-main', get_template_directory_uri() . '/assets/js/main.js', array(), '1.0', true);
}
add_action('wp_enqueue_scripts', 'cotemer_enqueue_styles');

// Fonction de nettoyage des données de galerie
function cotemer_sanitize_gallery_images($input) {
    if (empty($input)) {
        return '';
    }

    $data = json_decode($input, true);
    if (!is_array($data)) {
        return '';
    }

    $sanitized = array();
    foreach ($data as $item) {
        if (isset($item['image']) && isset($item['caption'])) {
            $sanitized[] = array(
                'image' => esc_url_raw($item['image']),
                'caption' => sanitize_text_field($item['caption'])
            );
        }
    }

    return json_encode($sanitized);
}

function cotemer_customize_register($wp_customize) {

    // Définir la classe de contrôle personnalisé DANS la fonction customize_register
    if (!class_exists('Cotemer_Gallery_Control')) {
        class Cotemer_Gallery_Control extends WP_Customize_Control {
            public $type = 'gallery';

            public function enqueue() {
                wp_enqueue_media();
                wp_enqueue_script('cotemer-gallery-control', get_template_directory_uri() . '/assets/js/gallery-control.js', array('jquery', 'customize-controls'), '1.0.0', true);
                wp_enqueue_style('cotemer-gallery-control', get_template_directory_uri() . '/assets/css/gallery-control.css', array(), '1.0.0');
            }

            public function render_content() {
                ?>
                <label>
                    <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                    <div class="gallery-control-container">
                        <div class="gallery-items" id="gallery-items-<?php echo $this->id; ?>"></div>
                        <button type="button" class="button add-gallery-item" data-control-id="<?php echo $this->id; ?>">
                            <?php _e('Ajouter une image', 'cotemer'); ?>
                        </button>
                    </div>
                    <input type="hidden" <?php $this->link(); ?> value="<?php echo esc_attr($this->value()); ?>" />
                </label>
                <?php
            }
        }
    }

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

    // Section Carte du restaurant
    $wp_customize->add_section('cotemer_menu_section', array(
        'title'    => __('Carte du restaurant', 'cotemer'),
        'priority' => 32,
    ));

    // Titre de la carte
    $wp_customize->add_setting('cotemer_menu_title', array(
        'default'   => 'Notre carte',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('cotemer_menu_title', array(
        'label'    => __('Titre de la carte', 'cotemer'),
        'section'  => 'cotemer_menu_section',
        'type'     => 'text',
    ));

    // Fichier PDF
    $wp_customize->add_setting('cotemer_menu_pdf', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Upload_Control($wp_customize, 'cotemer_menu_pdf', array(
        'label'    => __('Fichier PDF de la carte', 'cotemer'),
        'section'  => 'cotemer_menu_section',
        'settings' => 'cotemer_menu_pdf',
    )));

    // Section galerie
    $wp_customize->add_section('cotemer_gallery_section', array(
        'title'    => __('Galerie photos', 'cotemer'),
        'priority' => 33,
    ));

    // Contrôle personnalisé pour gérer la galerie dynamique
    $wp_customize->add_setting('cotemer_gallery_images', array(
        'default' => '',
        'sanitize_callback' => 'cotemer_sanitize_gallery_images',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control(new Cotemer_Gallery_Control($wp_customize, 'cotemer_gallery_images', array(
        'label'    => __('Images de la galerie', 'cotemer'),
        'section'  => 'cotemer_gallery_section',
        'settings' => 'cotemer_gallery_images',
    )));
}
add_action('customize_register', 'cotemer_customize_register');

// Support pour les images à la une
add_theme_support('post-thumbnails');

// Nettoyage du head WordPress
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');
function cotemer_get_today_closing_hour() {
  $default_hours = "Lundi - Vendredi : 8h30 - 21h30\nDimanche : 8h30 - 18h";
  $hours_string = get_theme_mod('cotemer_footer_hours', $default_hours);

  // Convertit en tableau ligne par ligne
  $lines = explode("\n", $hours_string);
  $today = strtolower(date('l')); // ex: monday

  // Correspondance des jours français => anglais
  $jours = [
    'lundi' => 'monday',
    'mardi' => 'tuesday',
    'mercredi' => 'wednesday',
    'jeudi' => 'thursday',
    'vendredi' => 'friday',
    'samedi' => 'saturday',
    'dimanche' => 'sunday'
  ];

  foreach ($lines as $line) {
    // Nettoyage de la ligne
    $line = trim($line);

    if (empty($line)) continue;

    // Vérification si fermé
    if (stripos($line, 'fermé') !== false) {
      foreach ($jours as $fr => $en) {
        if (strpos(strtolower($line), $fr) !== false && $today === $en) {
          return "fermé";
        }
      }
      continue;
    }

    // Regex améliorée pour capturer les plages de jours et les jours seuls
    if (preg_match('/^(.*?)\s*:\s*(\d{1,2}h\d{0,2})\s*-\s*(\d{1,2}h\d{0,2})$/i', $line, $matches)) {
      $jours_partie = trim($matches[1]);
      $heure_ouverture = $matches[2];
      $heure_fermeture = $matches[3];

      // Vérifier si c'est une plage de jours (ex: "Lundi - Samedi")
      if (preg_match('/^(.*?)\s*-\s*(.*?)$/i', $jours_partie, $plage_matches)) {
        $jour_debut = strtolower(trim($plage_matches[1]));
        $jour_fin = strtolower(trim($plage_matches[2]));

        // Trouver le jour actuel en français
        $jour_actuel_fr = array_search($today, $jours);

        if ($jour_actuel_fr !== false) {
          $jours_ordre = array_keys($jours);
          $index_debut = array_search($jour_debut, $jours_ordre);
          $index_fin = array_search($jour_fin, $jours_ordre);
          $index_actuel = array_search($jour_actuel_fr, $jours_ordre);

          // Vérifier si le jour actuel est dans la plage
          if ($index_debut !== false && $index_fin !== false && $index_actuel !== false) {
            // Gérer le cas où la plage traverse la semaine (ex: vendredi - lundi)
            if ($index_debut <= $index_fin) {
              // Plage normale
              if ($index_actuel >= $index_debut && $index_actuel <= $index_fin) {
                return $heure_fermeture;
              }
            } else {
              // Plage qui traverse la semaine
              if ($index_actuel >= $index_debut || $index_actuel <= $index_fin) {
                return $heure_fermeture;
              }
            }
          }
        }
      } else {
        // Jour unique (ex: "Dimanche")
        $jour_unique = strtolower(trim($jours_partie));
        $jour_actuel_fr = array_search($today, $jours);

        if ($jour_actuel_fr === $jour_unique) {
          return $heure_fermeture;
        }
      }
    }
  }

  return "fermé"; // Valeur par défaut
}

function cotemer_remove_customizer_sections($wp_customize) {
    $wp_customize->remove_section('nav_menus');
    $wp_customize->remove_section('custom_css');
    $wp_customize->remove_section('static_front_page');
    $wp_customize->remove_section('nav_menus-content');
}
add_action('customize_register', 'cotemer_remove_customizer_sections', 20);
?>