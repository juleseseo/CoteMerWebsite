<?php get_header(); ?>

<?php include get_template_directory() . '/intro.php'; ?>


<section id="banner" style="
  position: relative;
  padding-top: 150px;
  background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/vue.jpg');
  background-size: cover;
  background-position: center;
  height: 500px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  text-align: center;
  ">
  <div style="
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background-color: rgba(0, 0, 0, 0.4);
    z-index: 1;
  "></div>

  <div class="banner-content" style="
    position: relative;
    z-index: 2;
    text-shadow: 2px 2px 8px rgba(0,0,0,0.7);
    max-width: 90%;
    padding-top: 20px;
  ">
    <h1 style="
      font-size: 3.2rem;
      margin-bottom: 1rem;
      font-weight: 700;
    ">
      Bienvenue chez Côté Mer
    </h1>
    <p style="
      font-size: 1.7rem;
      margin-bottom: 1.5rem;
      font-weight: 500;
    ">
      Venez découvrir nos plats en bord de mer
    </p>
      <p style="
  font-size: 1.2rem;
  margin-bottom: 1.5rem;
  font-weight: 500;
">
          Aujourd'hui nous sommes <?php
          $closing = cotemer_get_today_closing_hour();
          echo $closing === 'fermé' ? 'fermés' : "ouverts jusqu'à $closing";
          ?>.
      </p>
  </div>
</section>

<section id="menu">
  <!-- Modale pour afficher l'image en grand -->
  <div id="imageModal" class="modal">
    <span class="close-btn">&times;</span>
    <img class="modal-content" id="modalImage" alt="Image agrandie">
    <div id="caption"></div>
  </div>

  <?php
  // Récupérer le titre depuis le customizer (cartes multiples)
  $menu_title = get_theme_mod('cotemer_menu_cards_title', 'Notre carte');
  ?>
  <h2><?php echo esc_html($menu_title); ?></h2>

  <div class="menu-grid">
    <?php
    // Fonction pour convertir un PDF en image
    function convert_pdf_to_image($pdf_url) {
      if (!$pdf_url) return false;

      $upload_dir = wp_upload_dir();
      $pdf_path = str_replace($upload_dir['baseurl'], $upload_dir['basedir'], $pdf_url);
      $output_path = str_replace('.pdf', '.jpg', $pdf_path);
      $output_url  = str_replace('.pdf', '.jpg', $pdf_url);

      // Si l'image n'existe pas déjà, on la crée
      if (!file_exists($output_path)) {
        try {
          $imagick = new Imagick();
          $imagick->setResolution(150, 150); // Qualité
          $imagick->readImage($pdf_path . '[0]'); // Première page
          $imagick->setImageFormat('jpg');
          $imagick->writeImage($output_path);
          $imagick->clear();
          $imagick->destroy();
        } catch (Exception $e) {
          return false;
        }
      }
      return $output_url;
    }

    // --- CPT restaurant_menu (garde ton système existant) ---
    $args = array(
      'post_type'      => 'restaurant_menu',
      'posts_per_page' => -1,
      'orderby'        => 'title',
      'order'          => 'ASC',
    );
    $menus = new WP_Query($args);

    if ($menus->have_posts()):
      while ($menus->have_posts()): $menus->the_post();
        $pdf_url = get_post_meta(get_the_ID(), '_cotemer_menu_file', true);

        if ($pdf_url) {
          if (is_numeric($pdf_url)) {
            $pdf_url = wp_get_attachment_url($pdf_url);
          }

          $image_url = convert_pdf_to_image($pdf_url);

          if ($image_url): ?>
            <div class="menu-item" data-pdf="<?php echo esc_url($pdf_url); ?>">
              <p><strong><?php the_title(); ?></strong></p>
              <img src="<?php echo esc_url($image_url); ?>" alt="<?php the_title(); ?>" style="max-width:100%;" oncontextmenu="return false;">
              <div class="menu-item-overlay">
                <a href="<?php echo esc_url($pdf_url); ?>" target="_blank" class="view-pdf-btn">
                  <span>📄</span> Voir le PDF
                </a>
              </div>
            </div>
          <?php endif;
        }
      endwhile;
      wp_reset_postdata();
    endif;

    // --- Cartes multiples depuis le customizer (NOUVEAU SYSTÈME) ---
    $menu_cards = cotemer_get_menu_cards();

    if (!empty($menu_cards)) {
      foreach ($menu_cards as $card) {
        if (!empty($card['pdf_url'])) {
          $image_url = convert_pdf_to_image($card['pdf_url']);

          if ($image_url): ?>
            <div class="menu-item" data-pdf="<?php echo esc_url($card['pdf_url']); ?>">
              <p><strong><?php echo esc_html($card['title']); ?></strong></p>
              <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($card['title']); ?>" style="max-width:100%;" oncontextmenu="return false;">
              <div class="menu-item-overlay">
                <a href="<?php echo esc_url($card['pdf_url']); ?>" target="_blank" class="view-pdf-btn">
                  <span>📄</span> Voir le PDF
                </a>
              </div>
            </div>
          <?php endif;
        }
      }
    }

    // --- Ancien système customizer (pour compatibilité - OPTIONNEL) ---
    // Tu peux garder cette partie pour la transition ou la supprimer si tu n'en as plus besoin
    $customizer_pdf_id = get_theme_mod('cotemer_menu_pdf');
    $customizer_pdf_title = get_theme_mod('cotemer_menu_title');

    // Seulement si il n'y a pas de cartes multiples configurées
    if ($customizer_pdf_id && empty($menu_cards)) {
      $customizer_pdf_url = wp_get_attachment_url($customizer_pdf_id);
      $image_url = convert_pdf_to_image($customizer_pdf_url);

      if ($image_url): ?>
        <div class="menu-item" data-pdf="<?php echo esc_url($customizer_pdf_url); ?>">
          <p><strong><?php echo esc_html($customizer_pdf_title ?: 'Carte du restaurant'); ?></strong></p>
          <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($customizer_pdf_title ?: 'Carte du restaurant'); ?>" style="max-width:100%;" oncontextmenu="return false;">
          <div class="menu-item-overlay">
            <a href="<?php echo esc_url($customizer_pdf_url); ?>" target="_blank" class="view-pdf-btn">
              <span>📄</span> Voir le PDF
            </a>
          </div>
        </div>
      <?php endif;
    }

    // Message si aucune carte n'est disponible
    if (!$menus->have_posts() && empty($menu_cards) && !$customizer_pdf_id): ?>
      <div class="no-menu-message">
        <p>Aucune carte n'est disponible pour le moment.</p>
      </div>
    <?php endif; ?>
  </div>
</section>


<section id="gallery">
    <h2>Galerie</h2>
    <div class="carousel-wrapper">
        <button class="carousel-btn prev" id="prevBtn">&larr;</button>
        <div class="carousel" id="carousel">
            <?php
            $gallery_data = get_theme_mod('cotemer_gallery_images', '');
            $has_gallery = false;

            if (!empty($gallery_data)) {
                $images = json_decode($gallery_data, true);

                if (is_array($images) && !empty($images)) {
                    $has_gallery = true;
                    foreach ($images as $item) {
                        if (!empty($item['image'])) {
                            echo '<div class="carousel-item">';
                            echo '<img src="' . esc_url($item['image']) . '" alt="' . esc_attr($item['caption']) . '">';
                            if (!empty($item['caption'])) {
                                echo '<p class="carousel-caption">' . esc_html($item['caption']) . '</p>';
                            }
                            echo '</div>';
                        }
                    }
                }
            }

            ?>
        </div>
        <button class="carousel-btn next" id="nextBtn">&rarr;</button>
    </div>
</section>

<!-- A propos -->
<section id="about">
    <h2>À propos</h2>
    <div class="about-container">
        <?php
        for ($i = 1; $i <= 3; $i++) :
            $title = get_theme_mod("cotemer_about_title_$i");
            $text = get_theme_mod("cotemer_about_text_$i");
            $image = get_theme_mod("cotemer_about_image_$i");
            ?>
            <div class="about-block">
                <div class="about-image" style="background-image: url('<?php echo esc_url($image); ?>');"></div>
                <div class="about-content">
                    <h3><?php echo esc_html($title); ?></h3>
                    <p><?php echo nl2br(esc_html($text)); ?></p>
                </div>
            </div>
        <?php endfor; ?>
    </div>
</section>





    <!-- Contact -->
    <section id="contact">
        <h2>Contactez-nous</h2>
        <div class="section-content">
            <?php
            $contact_page = get_page_by_path('contact');
            if ($contact_page) {
                echo apply_filters('the_content', $contact_page->post_content);
            } else {
              echo '<p>📍 <a class="hover-link" href="https://www.google.com/maps/place/20+Rue+du+G%C3%A9n%C3%A9ral+de+Gaulle,+56640+Arzon,+France" target="_blank">20 RUE DU GENERAL DE GAULLE, 56640 ARZON, France</a></p>';
              echo '<p>📞 <a class="hover-link" href="tel:+33297536367">+33 2 97 53 63 67</a></p>';
              echo '<p>✉️ <a class="hover-link" href="mailto:cotemer.portnavalo@gmail.com">cotemer.portnavalo@gmail.com</a></p>';
            }

            ?>
        </div>
      <!-- Google Maps -->
      <div class="map-container" style="margin-top: 30px;">
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2693.360196136136!2d-2.8942341844228183!3d47.54404879936627!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x48101a46d1a69ff5%3A0x257c822f9605fc71!2s20%20Rue%20du%20G%C3%A9n%C3%A9ral%20de%20Gaulle%2C%2056640%20Arzon%2C%20France!5e0!3m2!1sfr!2sfr!4v1686929205178!5m2!1sfr!2sfr"
          width="100%"
          height="400"
          style="border:0; border-radius: 12px; box-shadow: 0 8px 30px rgba(0,0,0,0.1);"
          allowfullscreen=""
          loading="lazy"
          referrerpolicy="no-referrer-when-downgrade">
        </iframe>
      </div>

    </section>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('imageModal');
    const modalImg = document.getElementById('modalImage');
    const captionText = document.getElementById('caption');
    const closeBtn = document.querySelector('.close-btn');

    // Cibler toutes les images du menu
    document.querySelectorAll('.menu-item img').forEach(img => {
      img.addEventListener('click', () => {
        modal.style.display = 'block';
        modalImg.src = img.src;
        captionText.textContent = img.alt || '';
      });
    });

    // Fermer la modale au clic sur la croix
    closeBtn.addEventListener('click', () => {
      modal.style.display = 'none';
    });

    // Fermer la modale au clic en dehors de l'image
    modal.addEventListener('click', e => {
      if (e.target === modal) {
        modal.style.display = 'none';
      }
    });

    // Fermer au clic sur la touche Échap
    document.addEventListener('keydown', e => {
      if (e.key === 'Escape') {
        modal.style.display = 'none';
      }
    });
  });
</script>

<?php get_footer(); ?>
