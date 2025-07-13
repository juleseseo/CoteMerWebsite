<?php get_header(); ?>

<section id="accueil" style="
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

    <!-- Contenu texte -->
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

<!-- Menu -->
<section id="menu">
  <h2>Notre carte</h2>
  <?php
  $menu_page = get_page_by_path('menu');
  echo apply_filters('the_content', $menu_page->post_content);
  ?>
</section>

    <!-- À propos -->
    <section id="about">
        <h2>À propos</h2>
        <div class="section-content">
            <?php
            $about_page = get_page_by_path('a-propos');
            if ($about_page) {
                echo apply_filters('the_content', $about_page->post_content);
            } else {
                echo '<p>Restaurant familial depuis 1985, Côté Mer vous accueille dans un cadre chaleureux avec vue imprenable sur le golfe du Morbihan. </p>';
            }
            ?>
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
                echo '<p>📍 20 RUE DU GENERAL DE GAULLE, 56640 ARZON, France</p>';
                echo '<p>📞 +33 2 97 53 63 67</p>';
                echo '<p>✉️ contact@cotemer.fr</p>';
            }
            ?>
        </div>
    </section>

<?php get_footer(); ?>
