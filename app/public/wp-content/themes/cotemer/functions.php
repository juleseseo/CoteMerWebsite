<?php
function cotemer_enqueue_styles() {
    wp_enqueue_style('cotemer-style', get_stylesheet_uri());
    wp_enqueue_script('cotemer-main', get_template_directory_uri() . '/assets/js/main.js', array(), '1.0', true);
}
add_action('wp_enqueue_scripts', 'cotemer_enqueue_styles');

// Charge le JS/CSS du control dans la Customizer (back-end)
function cotemer_customize_controls_assets() {
  // nécessaire pour wp.media()
  wp_enqueue_media();

  wp_enqueue_script(
    'cotemer-menu-cards-customizer',
    get_template_directory_uri() . '/assets/js/menu-cards-customizer.js',
    array('jquery', 'customize-controls'),
    '1.0.0',
    true
  );

  wp_enqueue_style(
    'cotemer-menu-cards-customizer-css',
    get_template_directory_uri() . '/assets/css/menu-cards-customizer.css',
    array(),
    '1.0.0'
  );
}
add_action('customize_controls_enqueue_scripts', 'cotemer_customize_controls_assets');

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

  $wp_customize->add_setting('cotemer_menu_pdf', array(
    'default' => '',
    'sanitize_callback' => 'absint', // Valide que c'est un entier (ID)
  ));
  $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'cotemer_menu_pdf', array(
    'label'    => __('Fichier PDF de la carte', 'cotemer'),
    'section'  => 'cotemer_menu_section',
    'mime_type' => 'application/pdf', // Limite aux PDFs seulement
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


function custom_language_buttons() {
  if (!function_exists('pll_the_languages')) {
    return '';
  }

  // Récupérer toutes les langues disponibles
  $languages = pll_the_languages(array(
    'raw' => 1,
    'hide_if_empty' => 0,  // Afficher même si pas de contenu traduit
    'show_flags' => 1,
    'show_names' => 1
  ));

  $current_lang = pll_current_language();

  if (empty($languages)) {
    return '';
  }

  $buttons_html = '<div class="language-switcher language-buttons">';

  foreach ($languages as $lang) {
    $active_class = ($lang['slug'] === $current_lang) ? ' active' : '';
    $flag_img = !empty($lang['flag']) ? '<img src="' . esc_url($lang['flag']) . '" alt="' . esc_attr($lang['name']) . '" width="20" height="15"> ' : '';

    $buttons_html .= '<a href="' . esc_url($lang['url']) . '" class="lang-button' . $active_class . '" data-lang="' . esc_attr($lang['slug']) . '">';
    $buttons_html .= $flag_img . esc_html($lang['name']);
    $buttons_html .= '</a>';
  }

  $buttons_html .= '</div>';

  return $buttons_html;
}

// Fonction pour créer un dropdown des langues
function custom_language_dropdown() {
  if (!function_exists('pll_the_languages')) {
    return '';
  }

  $languages = pll_the_languages(array(
    'raw' => 1,
    'hide_if_empty' => 0,
    'show_flags' => 1,
    'show_names' => 1
  ));

  $current_lang = pll_current_language();

  if (empty($languages)) {
    return '';
  }

  $dropdown_html = '<div class="language-switcher">';
  $dropdown_html .= '<select id="language-dropdown" class="custom-lang-dropdown">';

  foreach ($languages as $lang) {
    $selected = ($lang['slug'] === $current_lang) ? ' selected' : '';
    $dropdown_html .= '<option value="' . esc_url($lang['url']) . '"' . $selected . '>';
    $dropdown_html .= esc_html($lang['name']);
    $dropdown_html .= '</option>';
  }

  $dropdown_html .= '</select>';
  $dropdown_html .= '</div>';

  return $dropdown_html;
}
/**
 * TRANSLATEPRESS - Configuration complète
 * Remplace le code Polylang dans functions.php
 */

// Fonction pour créer un sélecteur de langue personnalisé avec boutons
function custom_translatepress_buttons() {
    // Vérifier si TranslatePress est actif
    if (!class_exists('TRP_Translate_Press')) {
        return '';
    }

    // Obtenir l'instance de TranslatePress
    $trp = TRP_Translate_Press::get_trp_instance();
    $trp_languages = $trp->get_component('languages');
    $trp_settings = $trp->get_component('settings')->get_settings();

    // Obtenir les langues configurées
    $published_languages = $trp_settings['publish-languages'];
    $default_language = $trp_settings['default-language'];
    $current_language = $trp->get_component('languages')->get_current_language();

    if (empty($published_languages)) {
        return '';
    }

    $buttons_html = '<div class="trp-language-switcher trp-language-buttons">';

    foreach ($published_languages as $language_code) {
        $language_name = $trp_languages->get_language_names(array($language_code), 'english_name');
        $language_name = $language_name[$language_code];

        $active_class = ($language_code === $current_language) ? ' trp-current-language' : '';

        // URL pour la langue
        $language_url = $trp_languages->add_language_to_home_url($language_code);
        if (!is_front_page() && !is_home()) {
            $language_url = $trp_languages->get_url_for_language($language_code);
        }

        // Drapeau (si disponible)
        $flag_path = TRP_PLUGIN_URL . 'assets/images/flags/' . $language_code . '.png';
        $flag_img = '<img src="' . esc_url($flag_path) . '" alt="' . esc_attr($language_name) . '" width="20" height="15"> ';

        $buttons_html .= '<a href="' . esc_url($language_url) . '" class="trp-lang-button' . $active_class . '" data-trp-language="' . esc_attr($language_code) . '">';
        $buttons_html .= $flag_img . esc_html($language_name);
        $buttons_html .= '</a>';
    }

    $buttons_html .= '</div>';
    return $buttons_html;
}

// Fonction pour créer un dropdown personnalisé
function custom_translatepress_dropdown() {
    if (!class_exists('TRP_Translate_Press')) {
        return '';
    }

    $trp = TRP_Translate_Press::get_trp_instance();
    $trp_languages = $trp->get_component('languages');
    $trp_settings = $trp->get_component('settings')->get_settings();

    $published_languages = $trp_settings['publish-languages'];
  $current_language = function_exists('trp_get_current_language') ? trp_get_current_language() : '';

    if (empty($published_languages)) {
        return '';
    }

    $dropdown_html = '<div class="trp-language-switcher trp-language-dropdown">';
    $dropdown_html .= '<select id="trp-language-select" class="trp-custom-dropdown">';

    foreach ($published_languages as $language_code) {
        $language_name = $trp_languages->get_language_names(array($language_code), 'english_name');
        $language_name = $language_name[$language_code];

        $selected = ($language_code === $current_language) ? ' selected' : '';

      $language_url = function_exists('trp_get_url_for_language') ? trp_get_url_for_language($language_code) : '';
        if (!is_front_page() && !is_home()) {
            $language_url = $trp_languages->get_url_for_language($language_code);
        }

        $dropdown_html .= '<option value="' . esc_url($language_url) . '"' . $selected . '>';
        $dropdown_html .= esc_html($language_name);
        $dropdown_html .= '</option>';
    }

    $dropdown_html .= '</select>';
    $dropdown_html .= '</div>';

    return $dropdown_html;
}

// Script JavaScript pour auto-détection et gestion des sélecteurs
function add_translatepress_script() {
    if (!class_exists('TRP_Translate_Press')) {
        return;
    }

    $trp = TRP_Translate_Press::get_trp_instance();
    $trp_settings = $trp->get_component('settings')->get_settings();
    $published_languages = $trp_settings['publish-languages'];
  $current_language = function_exists('trp_get_current_language') ? trp_get_current_language() : '';
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // === AUTO-DÉTECTION DE LANGUE ===
        if (!sessionStorage.getItem('trp_user_language_selected')) {
            const browserLang = navigator.language.substring(0, 2);
            const availableLanguages = <?php echo json_encode($published_languages); ?>;
            const currentLang = '<?php echo $current_language; ?>';

            // Si la langue du navigateur est disponible et différente
            if (availableLanguages.includes(browserLang) && browserLang !== currentLang) {
                sessionStorage.setItem('trp_user_language_selected', 'auto');

                // Construire l'URL pour la nouvelle langue
                let newUrl = window.location.href;

                // Si on est déjà sur une version traduite, remplacer
                const urlParts = window.location.pathname.split('/');
                if (availableLanguages.includes(urlParts[1])) {
                    newUrl = newUrl.replace('/' + urlParts[1] + '/', '/' + browserLang + '/');
                } else {
                    // Ajouter la langue à l'URL
                    newUrl = window.location.origin + '/' + browserLang + window.location.pathname + window.location.search;
                }

                window.location.href = newUrl;
                return;
            }
        }

        // === GESTION DU DROPDOWN ===
        const dropdown = document.getElementById('trp-language-select');
        if (dropdown) {
            dropdown.addEventListener('change', function(e) {
                sessionStorage.setItem('trp_user_language_selected', 'manual');
                if (e.target.value) {
                    window.location.href = e.target.value;
                }
            });
        }

        // === GESTION DES BOUTONS ===
        const langButtons = document.querySelectorAll('.trp-lang-button');
        langButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                sessionStorage.setItem('trp_user_language_selected', 'manual');

                // Animation de chargement
                this.style.opacity = '0.6';
                this.style.pointerEvents = 'none';

                window.location.href = this.href;
            });
        });
    });
    </script>

    <style>
    /* === STYLES POUR TRANSLATEPRESS === */

    /* Container principal */
    .trp-language-switcher {
        display: inline-block;
        margin: 10px 0;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    /* === STYLES BOUTONS === */
    .trp-language-buttons {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        align-items: center;
    }

    .trp-lang-button {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 10px 14px;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border: 1px solid #dee2e6;
        border-radius: 6px;
        text-decoration: none;
        color: #495057;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        white-space: nowrap;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .trp-lang-button:hover {
        background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);
        border-color: #adb5bd;
        text-decoration: none;
        color: #495057;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }

    .trp-lang-button.trp-current-language {
        background: linear-gradient(135deg, #007cba 0%, #005a87 100%);
        color: #fff;
        border-color: #005a87;
        cursor: default;
        box-shadow: 0 2px 4px rgba(0,124,186,0.3);
    }

    .trp-lang-button.trp-current-language:hover {
        transform: none;
        background: linear-gradient(135deg, #007cba 0%, #005a87 100%);
    }

    .trp-lang-button img {
        border-radius: 3px;
        flex-shrink: 0;
        box-shadow: 0 1px 2px rgba(0,0,0,0.2);
    }

    /* === STYLES DROPDOWN === */
    .trp-custom-dropdown {
        background: #fff;
        border: 1px solid #dee2e6;
        border-radius: 6px;
        padding: 10px 14px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        min-width: 160px;
        transition: all 0.3s ease;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .trp-custom-dropdown:hover {
        border-color: #adb5bd;
        box-shadow: 0 2px 6px rgba(0,0,0,0.15);
    }

    .trp-custom-dropdown:focus {
        outline: none;
        border-color: #007cba;
        box-shadow: 0 0 0 3px rgba(0,124,186,0.1);
    }

    /* === RESPONSIVE === */
    @media (max-width: 768px) {
        .trp-language-buttons {
            justify-content: center;
            gap: 6px;
        }

        .trp-lang-button {
            padding: 8px 12px;
            font-size: 13px;
        }

        .trp-custom-dropdown {
            width: 100%;
            max-width: 200px;
        }
    }

    /* === ANIMATION DE CHARGEMENT === */
    .trp-language-switcher.loading {
        opacity: 0.7;
        pointer-events: none;
    }

    .trp-lang-button[style*="opacity"] {
        transition: opacity 0.2s ease;
    }

    /* === INTEGRATION AVEC THEMES POPULAIRES === */

    /* Astra */
    .ast-header-break-point .trp-language-switcher {
        margin: 5px 0;
    }

    /* GeneratePress */
    .main-navigation .trp-language-switcher {
        margin: 0 10px;
    }

    /* OceanWP */
    #site-navigation-wrap .trp-language-switcher {
        display: inline-flex;
        align-items: center;
    }
    </style>
    <?php
}
add_action('wp_head', 'add_translatepress_script');

// Fonction principale pour afficher le sélecteur
function display_translatepress_switcher($type = 'buttons') {
    if ($type === 'dropdown') {
        echo custom_translatepress_dropdown();
    } else {
        echo custom_translatepress_buttons();
    }
}

// Shortcode pour utiliser dans le contenu
function translatepress_switcher_shortcode($atts) {
    $atts = shortcode_atts(array(
        'type' => 'buttons'
    ), $atts);

    if ($atts['type'] === 'dropdown') {
        return custom_translatepress_dropdown();
    } else {
        return custom_translatepress_buttons();
    }
}
add_shortcode('trp_language_switcher', 'translatepress_switcher_shortcode');

// Désactiver le sélecteur par défaut de TranslatePress (optionnel)
function hide_default_translatepress_switcher() {
    return false;
}
add_filter('trp_ls_shortcode_show_disabled_language', 'hide_default_translatepress_switcher');

// Debug TranslatePress (décommentez pour debug)
/*
function debug_translatepress() {
    if (!is_admin() && class_exists('TRP_Translate_Press') && current_user_can('administrator')) {
        $trp = TRP_Translate_Press::get_trp_instance();
        $trp_settings = $trp->get_component('settings')->get_settings();
        $current_language = $trp->get_component('languages')->get_current_language();

        echo '<div style="position: fixed; top: 10px; right: 10px; background: #333; color: #fff; padding: 10px; border-radius: 5px; font-size: 12px; z-index: 9999; max-width: 300px;">';
        echo '<strong>TranslatePress Debug:</strong><br>';
        echo 'Langue courante: ' . $current_language . '<br>';
        echo 'Langues publiées: ' . implode(', ', $trp_settings['publish-languages']) . '<br>';
        echo 'URL courante: ' . $_SERVER['REQUEST_URI'] . '<br>';
        echo '</div>';
    }
}
add_action('wp_footer', 'debug_translatepress');
*/

// Fonction pour ajouter la classe du contrôle personnalisé
function cotemer_customize_register_controls() {
    // Classe pour le contrôle des cartes multiples
    class Cotemer_Menu_Cards_Control extends WP_Customize_Control {
    public $type = 'menu_cards';

    public function enqueue() {
        wp_enqueue_script(
            'cotemer-menu-cards-control',
            get_template_directory_uri() . '/js/menu-cards-customizer.js',
            array('jquery', 'customize-controls'),
            '1.0.0',
            true
        );

        wp_enqueue_style(
            'cotemer-menu-cards-control',
            get_template_directory_uri() . '/css/menu-cards-customizer.css',
            array(),
            '1.0.0'
        );
    }

    public function render_content() {
        ?>
        <label>
            <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
            <?php if (!empty($this->description)) : ?>
                <span class="description customize-control-description"><?php echo $this->description; ?></span>
            <?php endif; ?>
        </label>

        <div class="menu-cards-control-container">
            <div id="menu-cards-<?php echo esc_attr($this->id); ?>" class="menu-cards-container">
                <!-- Les cartes seront ajoutées ici par JavaScript -->
            </div>

            <button type="button" class="button add-menu-card" data-control-id="<?php echo esc_attr($this->id); ?>">
                Ajouter une carte
            </button>

            <input type="hidden" <?php $this->link(); ?> value="<?php echo esc_attr($this->value()); ?>">
        </div>

        <style>
        .menu-cards-container {
            margin: 10px 0;
        }

        .menu-card-item {
            border: 1px solid #ddd;
            margin-bottom: 15px;
            background: #fff;
            border-radius: 4px;
        }

        .menu-card-header {
            background: #f9f9f9;
            padding: 10px;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .menu-card-header h4 {
            margin: 0;
            font-size: 14px;
            font-weight: 600;
        }

        .menu-card-content {
            padding: 15px;
        }

        .menu-card-field {
            margin-bottom: 15px;
        }

        .menu-card-field label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            font-size: 12px;
        }

        .menu-card-field input[type="text"] {
            width: 100%;
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 3px;
        }

        .menu-card-pdf-control {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .pdf-preview {
            flex: 1;
            padding: 5px;
            background: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 3px;
            font-size: 12px;
        }

        .pdf-name {
            color: #0073aa;
        }

        .no-pdf {
            color: #666;
            font-style: italic;
        }

        .menu-card-actions {
            display: flex;
            gap: 5px;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid #eee;
        }

        .menu-card-actions .button {
            font-size: 11px;
            padding: 3px 8px;
            height: auto;
            line-height: 1.4;
        }

        .add-menu-card {
            width: 100%;
            text-align: center;
            margin-top: 10px;
        }

        .remove-card {
            font-size: 11px !important;
            padding: 3px 8px !important;
            height: auto !important;
            line-height: 1.4 !important;
        }
        </style>
        <?php
    }
    }
}

// Fonction pour ajouter les contrôles au customizer
function cotemer_customize_register_menu_cards($wp_customize) {
    // S'assurer que la classe est définie
    if (!class_exists('Cotemer_Menu_Cards_Control')) {
        cotemer_customize_register_controls();
    }
    // Section Cartes du restaurant
    $wp_customize->add_section('cotemer_menu_cards_section', array(
        'title'    => __('Cartes du restaurant', 'cotemer'),
        'priority' => 32,
    ));

    // Titre de la section
    $wp_customize->add_setting('cotemer_menu_cards_title', array(
        'default'   => 'Nos cartes',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('cotemer_menu_cards_title', array(
        'label'    => __('Titre de la section', 'cotemer'),
        'section'  => 'cotemer_menu_cards_section',
        'type'     => 'text',
    ));

    // Contrôle pour les cartes multiples
    $wp_customize->add_setting('cotemer_menu_cards_data', array(
        'default' => '[]',
        'sanitize_callback' => 'cotemer_sanitize_menu_cards',
    ));

    $wp_customize->add_control(new Cotemer_Menu_Cards_Control($wp_customize, 'cotemer_menu_cards_data', array(
        'label'    => __('Cartes du restaurant', 'cotemer'),
        'description' => __('Ajoutez autant de cartes que nécessaire (carte des vins, menu du jour, etc.)', 'cotemer'),
        'section'  => 'cotemer_menu_cards_section',
    )));
}
add_action('customize_register', 'cotemer_customize_register_menu_cards');



// Fonction de validation/nettoyage des données
function cotemer_sanitize_menu_cards($input) {
    $cards = json_decode($input, true);
    if (!is_array($cards)) {
        return '[]';
    }

    $sanitized_cards = array();
    foreach ($cards as $card) {
        if (is_array($card)) {
            $sanitized_card = array(
                'title' => sanitize_text_field($card['title'] ?? ''),
                'pdf_url' => esc_url_raw($card['pdf_url'] ?? ''),
                'pdf_id' => absint($card['pdf_id'] ?? 0),
            );
            $sanitized_cards[] = $sanitized_card;
        }
    }

    return json_encode($sanitized_cards);
}

function autoriser_pdf($mimes) {
  $mimes['pdf'] = 'application/pdf';
  return $mimes;
}
add_filter('upload_mimes', 'autoriser_pdf');

// Fonction helper pour récupérer les cartes
function cotemer_get_menu_cards() {
    $cards_data = get_theme_mod('cotemer_menu_cards_data', '[]');
    $cards = json_decode($cards_data, true);
    return is_array($cards) ? $cards : array();
}

// Fonction helper pour afficher les cartes (exemple d'utilisation)
function cotemer_display_menu_cards() {
    $title = get_theme_mod('cotemer_menu_cards_title', 'Nos cartes');
    $cards = cotemer_get_menu_cards();

    if (empty($cards)) {
        return;
    }
    ?>
    <section class="menu-cards-section">
        <div class="container">
            <h2><?php echo esc_html($title); ?></h2>
            <div class="menu-cards-grid">
                <?php foreach ($cards as $card) : ?>
                    <?php if (!empty($card['pdf_url'])) : ?>
                        <div class="menu-card">
                            <h3><?php echo esc_html($card['title']); ?></h3>
                            <a href="<?php echo esc_url($card['pdf_url']); ?>" target="_blank" class="menu-card-link">
                                <span class="pdf-icon">📄</span>
                                Consulter la carte
                            </a>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php
}
?>

    <style>
      .menu-cards-container {
        margin: 10px 0;
      }

      .menu-card-item {
        border: 1px solid #ddd;
        margin-bottom: 15px;
        background: #fff;
        border-radius: 4px;
      }

      .menu-card-header {
        background: #f9f9f9;
        padding: 10px;
        border-bottom: 1px solid #ddd;
        display: flex;
        justify-content: space-between;
        align-items: center;
      }

      .menu-card-header h4 {
        margin: 0;
        font-size: 14px;
        font-weight: 600;
      }

      .menu-card-content {
        padding: 15px;
      }

      .menu-card-field {
        margin-bottom: 15px;
      }

      .menu-card-field label {
        display: block;
        margin-bottom: 5px;
        font-weight: 600;
        font-size: 12px;
      }

      .menu-card-field input[type="text"] {
        width: 100%;
        padding: 5px;
        border: 1px solid #ddd;
        border-radius: 3px;
      }

      .menu-card-pdf-control {
        display: flex;
        align-items: center;
        gap: 10px;
      }

      .pdf-preview {
        flex: 1;
        padding: 5px;
        background: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 3px;
        font-size: 12px;
      }

      .pdf-name {
        color: #0073aa;
      }

      .no-pdf {
        color: #666;
        font-style: italic;
      }

      .menu-card-actions {
        display: flex;
        gap: 5px;
        margin-top: 10px;
        padding-top: 10px;
        border-top: 1px solid #eee;
      }

      .menu-card-actions .button {
        font-size: 11px;
        padding: 3px 8px;
        height: auto;
        line-height: 1.4;
      }

      .add-menu-card {
        width: 100%;
        text-align: center;
        margin-top: 10px;
      }

      .remove-card {
        font-size: 11px !important;
        padding: 3px 8px !important;
        height: auto !important;
        line-height: 1.4 !important;
      }
    </style>

