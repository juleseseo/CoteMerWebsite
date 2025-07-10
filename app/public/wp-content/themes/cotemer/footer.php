<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Modern Footer Styles */
        footer {
            width: 100vw; /* Assure la largeur totale de la fenêtre */
            margin: 0; /* Supprime toute marge externe */
            padding: 30px 20px; /* Réduit l’espace interne pour moins de hauteur */
            box-sizing: border-box;
            background: linear-gradient(135deg, #060C64, #1A1F71);
            color: #FFFFFF;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 20px; /* Réduit l’espace entre colonnes */
        }

        .footer-column {
            flex: 1;
            min-width: 200px; /* Plus petit pour éviter qu’elles s’étirent trop */
        }

        .footer-column h3 {
            font-size: 1.2em; /* Légèrement plus petit */
            margin-bottom: 15px;
            border-left: 3px solid #E0E0E0;
            padding-left: 8px;
        }

        .footer-column p {
            margin: 6px 0;
            font-size: 0.95em; /* Plus petit texte */
            line-height: 1.5;
            color: #E0E0E0;
        }

        .social-icons {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .social-icons a {
            font-size: 1.5em; /* Réduit taille icônes */
        }

        .footer-bottom {
            width: 100%;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            text-align: center;
            padding-top: 10px;
            margin-top: 20px;
            font-size: 0.9em;
            color: #CCCCCC;
        }

        /* Responsive */
        @media (max-width: 768px) {
            footer {
                flex-direction: column;
                text-align: center;
            }

            .footer-column {
                min-width: 100%;
            }

            .social-icons {
                justify-content: center;
            }
        }

    </style>
</head>
<body>
<footer>
    <!-- Colonne 1 : À propos -->
    <div class="footer-column">
        <h3>À propos</h3>
        <p>Découvrez Côté Mer, votre partenaire pour des séjours inoubliables sur la côte. Hébergements confortables et services d’exception.</p>
    </div>

    <!-- Colonne 2 : Contact -->
    <div class="footer-column">
        <h3>Contact</h3>
        <p><?php echo get_theme_mod('cotemer_footer_address', '20 RUE DU GENERAL DE GAULLE, 56640 ARZON, France'); ?></p>
        <p>📞 <?php echo get_theme_mod('cotemer_footer_phone', '+33 2 97 53 63 67'); ?></p>
        <p>✉️ contact@cotemer.fr</p>
    </div>

    <!-- Colonne 3 : Réseaux sociaux -->
    <div class="footer-column">
        <h3>Suivez-nous</h3>
        <div class="social-icons">
            <a href="https://facebook.com" target="_blank" aria-label="Facebook">🌐</a>
            <a href="https://instagram.com" target="_blank" aria-label="Instagram">📸</a>
            <a href="https://twitter.com" target="_blank" aria-label="Twitter">🐦</a>
        </div>
    </div>

    <!-- Bas de page -->
    <div class="footer-bottom">
        <p>© <span id="current-year"></span> Côté Mer – Tous droits réservés</p>
    </div>
</footer>

<script>
    document.getElementById('current-year').textContent = new Date().getFullYear();
</script>
</body>
</html>
