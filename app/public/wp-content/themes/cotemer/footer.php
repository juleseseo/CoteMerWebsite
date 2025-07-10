<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<footer>
    <div class="footer-column">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.png" alt="Logo du restaurant">
    </div>

    <div class="footer-column">
        <h3>Contact</h3>
        <p>
            📍
            <a href="https://www.google.com/maps/place/20+Rue+du+G%C3%A9n%C3%A9ral+de+Gaulle,+56640+Arzon,+France" target="_blank">
                <?php echo get_theme_mod('cotemer_footer_address', '20 RUE DU GENERAL DE GAULLE, 56640 ARZON, France'); ?>
            </a>
        </p>
        <p>📞
            <a href="tel:<?php echo get_theme_mod('cotemer_footer_phone', '+33 2 97 53 63 67'); ?>">
                <?php echo get_theme_mod('cotemer_footer_phone', '+33 2 97 53 63 67'); ?>
            </a>
        </p>
        <p>✉️
            <a href="mailto:contact@cotemer.fr">contact@cotemer.fr</a>
        </p>
    </div>

    <div class="footer-column">
        <h3>Nos réseaux sociaux</h3>
        <div class="social-icons">
            <a href="https://www.facebook.com/p/Coté-Mer-Arzon-100087090858733/?locale=fr_FR" target="_blank" aria-label="Facebook">
                <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/Facebook_f_logo_%282019%29.svg" alt="Facebook" class="social-logo">
            </a>
            <a href="https://www.instagram.com/cote_mer_restaurant/" target="_blank" aria-label="Instagram">
                <img src="https://upload.wikimedia.org/wikipedia/commons/a/a5/Instagram_icon.png" alt="Instagram" class="social-logo">
            </a>
        </div>
    </div>

    <div class="footer-bottom">
        <p>© <span id="current-year"></span> Côté Mer – Tous droits réservés</p>
    </div>
</footer>

<script>
    document.getElementById('current-year').textContent = new Date().getFullYear();
</script>
</body>
</html>
