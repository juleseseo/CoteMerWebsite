<!-- Animation d'accueil -->
<div id="intro">
  <div class="intro-images">
    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/homard.jpg" alt="">
    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/hormard_mer.jpg" alt="">
    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/vue.jpg" alt="">
    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.png" alt="">
    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/huitre.jpg" alt="">
  </div>
  <h1 class="intro-text">Bienvenue chez Côté Mer !</h1>
</div>

<style>
  #intro {
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: black;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    z-index: 9999;
    overflow: hidden;
  }

  .intro-images {
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
  }

  .intro-images img {
    position: absolute;
    width: 200px;
    opacity: 0;
    animation: showImage 3s forwards;
  }

  @keyframes showImage {
    0% { opacity: 0; transform: scale(0.5); }
    50% { opacity: 1; transform: scale(1.1); }
    100% { opacity: 0; transform: scale(1); }
  }

  .intro-text {
    color: white;
    font-size: 3rem;
    opacity: 0;
    animation: fadeInText 2s ease forwards;
    animation-delay: 3s;
  }

  @keyframes fadeInText {
    to { opacity: 1; }
  }
</style>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    const images = document.querySelectorAll(".intro-images img");
    images.forEach((img, index) => {
      img.style.top = `${Math.random() * 80}%`;
      img.style.left = `${Math.random() * 80}%`;
      img.style.animationDelay = `${index * 0.5}s`;
    });

    // Après 6 secondes on cache l'intro
    setTimeout(() => {
      document.getElementById("intro").style.display = "none";
    }, 6000);
  });
</script>
