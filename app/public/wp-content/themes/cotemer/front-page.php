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
    padding-top: 20px; /* Ajout optionnel pour descendre un peu le contenu */
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


    <!-- Menu -->
    <section id="menu">
        <h2>Notre carte</h2>
        <div class="menu-content">
            <?php
            $menu_page = get_page_by_path('menu');
            if ($menu_page) {
                echo apply_filters('the_content', $menu_page->post_content);
            } else {
                echo '<p>Découvrez notre sélection de fruits de mer frais, nos poissons du jour et nos spécialités bretonnes préparées avec passion par notre chef.</p>';
            }
            ?>
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
    $about_page = get_page_by_path('a-propos');
    if ($about_page) {
      echo apply_filters('the_content', $about_page->post_content);
    } else {
      ?>
      <div class="about-block">
        <div class="about-image" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/hormard_mer.jpg');"></div>
        <div class="about-content">
          <h3>Des Produits d'Excellence</h3>
          <p>
            Nous travaillons exclusivement avec des produits frais, de saison et essentiellement français sélectionnés avec soin auprès de producteurs locaux et artisans passionnés. Notre chef revisite la gastronomie bretonne avec une touche créative, mêlant tradition et modernité.
          </p>
        </div>
      </div>
      <div class="about-block">
        <div class="about-image" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/homard.jpg');"></div>
        <div class="about-content">
          <h3>Une Cuisine Inspirée</h3>
          <p>
            Au cœur de Port Navalo, à l'entrée majestueuse du Golfe du Morbihan, notre restaurant bistronomique vous invite à une expérience culinaire authentique. Ici, chaque assiette célèbre les saveurs de la mer et du terroir français, dans un cadre d'exception avec une vue imprenable sur la mer.
          </p>
        </div>
      </div>
      <div class="about-block">
        <div class="about-image" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/huitre.jpg');"></div>
        <div class="about-content">
          <h3>Des Saveurs Authentiques</h3>
          <p>
            Chaque bouchée révèle la richesse de notre terroir et la passion de notre équipe. Des huîtres fraîches aux plats les plus sophistiqués, nous mettons tout en œuvre pour vous offrir une expérience gustative inoubliable.
          </p>
        </div>
      </div>
      <?php
    }
    ?>
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
