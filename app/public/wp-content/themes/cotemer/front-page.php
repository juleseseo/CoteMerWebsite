<?php get_header(); ?>

<!-- Hero / Slider -->
<section id="hero">
  <h1>Bienvenue chez Côté Mer</h1>
  <p>Votre restaurant de fruits de mer préféré.</p>
  <a href="#menu">Voir la carte</a>
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
