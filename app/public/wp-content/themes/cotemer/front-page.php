<?php get_header(); ?>

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
      Aujourd'hui nous sommes ouverts jusqu'à
    </p>
  </div>
</section>

<section id="menu">
  <h2>Notre carte</h2>
  <div class="menu-grid">
    <?php
    // Requête pour récupérer tous les menus du CPT 'restaurant_menu'
    $args = array(
      'post_type'      => 'restaurant_menu',
      'posts_per_page' => -1, // Récupérer tous les menus
      'orderby'        => 'title',
      'order'          => 'ASC',
    );
    $menus = new WP_Query($args);

    // Variable pour savoir si on a affiché quelque chose
    $has_content = false;

    if ($menus->have_posts()):
      while ($menus->have_posts()): $menus->the_post();
        $file_url = get_post_meta(get_the_ID(), '_cotemer_menu_file', true);
        if ($file_url): ?>
          <div class="menu-item">
            <p><strong><?php the_title(); ?></strong></p>
            <iframe src="https://docs.google.com/viewer?url=<?php echo esc_url($file_url); ?>&embedded=true"
                    width="600"
                    height="400"
                    style="border: none;"></iframe>
          </div>
          <?php $has_content = true; ?>
        <?php endif;
      endwhile;
      wp_reset_postdata();
    endif;

    // Ajouter aussi la carte du Customizer si présente
    $customizer_pdf_url = get_theme_mod('cotemer_menu_pdf_upload');
    $customizer_pdf_title = get_theme_mod('cotemer_menu_pdf_title');

    if ($customizer_pdf_url): ?>
      <div class="menu-item">
        <p><strong><?php echo esc_html($customizer_pdf_title ?: 'Carte du restaurant'); ?></strong></p>
        <iframe src="https://docs.google.com/viewer?url=<?php echo esc_url($customizer_pdf_url); ?>&embedded=true"
                width="600"
                height="400"
                style="border: none;"></iframe>
      </div>
      <?php $has_content = true; ?>
    <?php endif;

    // Si aucun contenu n’a été trouvé
    if (!$has_content): ?>
      <p>Aucune carte disponible pour le moment.</p>
    <?php endif; ?>
  </div>
</section>







<!-- Galerie -->
    <section id="gallery">
        <h2>Galerie</h2>
        <div class="carousel-wrapper">
            <button class="carousel-btn prev" id="prevBtn">&larr;</button>
            <div class="carousel" id="carousel">
                <?php
                $gallery_dir = get_template_directory() . '/assets/galerie/';
                $gallery_url = get_template_directory_uri() . '/assets/galerie/';

                if (is_dir($gallery_dir)) {
                    $files = glob($gallery_dir . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);

                    if (!empty($files)) {
                        foreach ($files as $file) {
                            $filename = basename($file);
                            $url = $gallery_url . $filename;
                            echo '<div class="carousel-item"><img src="' . esc_url($url) . '" alt="Galerie ' . esc_attr($filename) . '"></div>';
                        }
                    } else {
                        // Images par défaut si pas d'images trouvées
                        echo '<div class="carousel-item"><img src="' . get_template_directory_uri() . '/assets/img/placeholder1.jpg" alt="Restaurant"></div>';
                        echo '<div class="carousel-item"><img src="' . get_template_directory_uri() . '/assets/img/placeholder2.jpg" alt="Plats"></div>';
                        echo '<div class="carousel-item"><img src="' . get_template_directory_uri() . '/assets/img/placeholder3.jpg" alt="Terrasse"></div>';
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
        <h2>Ou nous trouver ?</h2>
        <div class="section-content">
            <?php
            $contact_page = get_page_by_path('contact');
            if ($contact_page) {
                echo apply_filters('the_content', $contact_page->post_content);
            } else {
                echo '<p>📍 20 RUE DU GENERAL DE GAULLE, 56640 ARZON, France</p>';
                echo '<p>📞 +33 2 97 53 63 67</p>';
                echo '<p>✉️ cotemer.portnavalo@gmail.com</p>';
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

<?php get_footer(); ?>
