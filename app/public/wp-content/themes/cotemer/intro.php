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
        padding: 20px;
    }

    /* Conteneur d'images */
    .intro-images {
        position: absolute;
        inset: 0;
        overflow: hidden;
    }

    /* Images flottantes - Desktop */
    .intro-images img {
        position: absolute;
        opacity: 0;
        transform: scale(0.5) rotate(0deg);
        animation: showImage 3s ease-in-out forwards;
        max-width: none;
        height: auto;
    }

    /* Logo centré et plus grand - Desktop */
    .intro-images img.logo {
        position: relative;
        width: 180px;
        max-width: 90vw;
        transform: none;
        opacity: 1;
        animation: popIn 1.5s ease forwards;
        animation-delay: 2s;
        z-index: 10;
    }

    /* Texte de bienvenue - Desktop */
    .intro-text {
        color: white;
        font-size: clamp(1.5rem, 4vw, 2.5rem);
        font-family: 'Playfair Display', serif;
        text-align: center;
        margin-top: 20px;
        opacity: 0;
        animation: fadeInText 1.5s ease forwards;
        animation-delay: 3s;
        padding: 0 20px;
        max-width: 90vw;
        line-height: 1.2;
    }

    /* Tablettes (768px et moins) */
    @media (max-width: 768px) {
        #intro {
            padding: 15px;
        }

        .intro-images img.logo {
            width: 140px;
            max-width: 80vw;
        }

        .intro-text {
            font-size: clamp(1.2rem, 5vw, 2rem);
            margin-top: 15px;
            padding: 0 15px;
        }
    }

    /* Mobiles (480px et moins) */
    @media (max-width: 480px) {
        #intro {
            padding: 10px;
        }

        .intro-images img.logo {
            width: 120px;
            max-width: 75vw;
        }

        .intro-text {
            font-size: clamp(1rem, 6vw, 1.5rem);
            margin-top: 10px;
            padding: 0 10px;
            line-height: 1.1;
        }

        /* Réduction de la durée d'animation sur mobile */
        #intro {
            animation-delay: 4s;
        }

        .intro-images img {
            animation-duration: 2.5s;
        }

        .intro-images img.logo {
            animation-duration: 1.2s;
            animation-delay: 1.5s;
        }

        .intro-text {
            animation-delay: 2.5s;
            animation-duration: 1.2s;
        }
    }

    /* Très petits écrans (320px et moins) */
    @media (max-width: 320px) {
        .intro-images img.logo {
            width: 100px;
        }

        .intro-text {
            font-size: clamp(0.9rem, 7vw, 1.2rem);
        }
    }

    /* Écrans très larges (1200px et plus) */
    @media (min-width: 1200px) {
        .intro-images img.logo {
            width: 220px;
        }

        .intro-text {
            font-size: 3rem;
        }
    }

    /* Préférence pour les animations réduites */
    @media (prefers-reduced-motion: reduce) {
        #intro {
            animation-duration: 0.3s;
            animation-delay: 2s;
        }

        .intro-images img {
            animation-duration: 1s;
        }

        .intro-images img.logo {
            animation-duration: 0.5s;
            animation-delay: 0.5s;
        }

        .intro-text {
            animation-duration: 0.5s;
            animation-delay: 1s;
        }
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
        const isMobile = window.innerWidth <= 480;
        const isTablet = window.innerWidth <= 768;

        images.forEach((img, index) => {
            // Position aléatoire adaptée à la taille d'écran
            const marginTop = isMobile ? 10 : isTablet ? 15 : 20;
            const marginSide = isMobile ? 5 : isTablet ? 10 : 15;

            img.style.top = `${Math.random() * (100 - marginTop * 2) + marginTop}%`;
            img.style.left = `${Math.random() * (100 - marginSide * 2) + marginSide}%`;

            // Taille adaptée à l'écran
            let minSize, maxSize;
            if (isMobile) {
                minSize = 12; maxSize = 20; // Plus grandes sur mobile
            } else if (isTablet) {
                minSize = 10; maxSize = 18;
            } else {
                minSize = 8; maxSize = 15; // Tailles originales sur desktop
            }

            const sizeVW = Math.random() * (maxSize - minSize) + minSize;
            img.style.width = `${sizeVW}vw`;
            img.style.height = 'auto';

            // Délai d'apparition adapté
            const baseDelay = isMobile ? 0.3 : 0.4;
            img.style.animationDelay = `${index * baseDelay}s`;
        });

        // Supprimer le DOM après l'animation
        const totalDuration = isMobile ? 5000 : 6000;
        setTimeout(() => {
            document.getElementById("intro")?.remove();
        }, totalDuration);
    });

    // Gestion du redimensionnement de fenêtre
    window.addEventListener('resize', () => {
        // Recalcul uniquement si le changement est significatif
        const intro = document.getElementById("intro");
        if (intro) {
            clearTimeout(window.resizeTimeout);
            window.resizeTimeout = setTimeout(() => {
                location.reload(); // Rechargement simple pour éviter les bugs d'animation
            }, 150);
        }
    });
</script>