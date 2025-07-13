<?php get_header(); ?>

<section id="banner" style="
  position: relative;
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
  <?php
  $menu_page = get_page_by_path('menu');
  echo apply_filters('the_content', $menu_page->post_content);
  ?>
</section>

<!-- À propos -->
<section id="about">
  <h2>À propos</h2>
  <?php
  $about_page = get_page_by_path('a-propos');
  echo apply_filters('the_content', $about_page->post_content);
  ?>
</section>

<!-- Galerie -->
<section id="gallery">
  <h2>Galerie</h2>
  <?php
  $gallery_page = get_page_by_path('galerie');
  echo apply_filters('the_content', $gallery_page->post_content);
  ?>
</section>

<!-- Contact -->
<section id="contact">
  <h2>Contactez-nous</h2>
  <?php
  $contact_page = get_page_by_path('contact');
  echo apply_filters('the_content', $contact_page->post_content);
  ?>
</section>

<?php get_footer(); ?>
