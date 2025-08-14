<!-- Animation d'accueil -->
<div id="intro">
    <div class="intro-images">
        <?php
        // Récupération des images de la galerie
        $gallery_data = get_theme_mod('cotemer_gallery_images', '');
        if (!empty($gallery_data)) {
            $images = json_decode($gallery_data, true);
            if (is_array($images) && !empty($images)) {
                foreach ($images as $item) {
                    if (!empty($item['image'])) {
                        echo '<img src="' . esc_url($item['image']) . '" alt="' . esc_attr($item['caption']) . '">';
                    }
                }
            }
        }

        // Ajout du logo en dernier
        echo '<img class="logo" src="' . esc_url(get_template_directory_uri() . '/assets/img/logo.png') . '" alt="Logo Côté Mer">';
        ?>
    </div>
    <h1 class="intro-text">Bienvenue chez Côté Mer</h1>
</div>

<style>
    /* Fond noir avec effet dégradé */
    #intro {
        position: fixed;
        inset: 0;
        background: radial-gradient(circle at center, #000 60%, #111);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        overflow: hidden;
        animation: fadeOutIntro 1s ease forwards;
        animation-delay: 5s;
    }

    /* Conteneur d'images */
    .intro-images {
        position: absolute;
        inset: 0;
        overflow: hidden;
    }

    /* Images flottantes */
    .intro-images img {
        position: absolute;
        opacity: 0;
        transform: scale(0.5) rotate(0deg);
        animation: showImage 3s ease-in-out forwards;
    }

    /* Logo centré et plus grand */
    .intro-images img.logo {
        position: relative;
        width: 180px;
        transform: none;
        opacity: 1;
        animation: popIn 1.5s ease forwards;
        animation-delay: 2s;
        z-index: 10;
    }

    /* Texte de bienvenue */
    .intro-text {
        color: white;
        font-size: 2.5rem;
        font-family: 'Playfair Display', serif;
        text-align: center;
        margin-top: 20px;
        opacity: 0;
        animation: fadeInText 1.5s ease forwards;
        animation-delay: 3s;
    }

    /* Apparition des images */
    @keyframes showImage {
        0% { opacity: 0; transform: scale(0.5) rotate(0deg); }
        40% { opacity: 1; transform: scale(1.1) rotate(5deg); }
        70% { opacity: 1; transform: scale(1) rotate(-5deg); }
        100% { opacity: 0; transform: scale(0.8) rotate(0deg); }
    }

    /* Pop du logo */
    @keyframes popIn {
        0% { transform: scale(0.5); opacity: 0; }
        60% { transform: scale(1.2); opacity: 1; }
        100% { transform: scale(1); opacity: 1; }
    }

    /* Texte en fondu */
    @keyframes fadeInText {
        to { opacity: 1; }
    }

    /* Fondu de sortie global */
    @keyframes fadeOutIntro {
        to { opacity: 0; visibility: hidden; }
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const images = document.querySelectorAll(".intro-images img:not(.logo)");

        images.forEach((img, index) => {
            // Position aléatoire
            img.style.top = `${Math.random() * 80}%`;
            img.style.left = `${Math.random() * 80}%`;

            // Taille aléatoire
            const size = Math.random() * 100 + 100; // entre 100px et 200px
            img.style.width = `${size}px`;

            // Délai d'apparition
            img.style.animationDelay = `${index * 0.4}s`;
        });

        // Supprimer le DOM après l'animation pour alléger
        setTimeout(() => {
            document.getElementById("intro").remove();
        }, 6000);
    });
</script>
