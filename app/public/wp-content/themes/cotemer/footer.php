<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Footer styles */
        footer {
            background-color: #060C64; /* Primary color */
            color: #FFFFFF;
            padding: 40px 20px;
            font-family: 'Arial', sans-serif;
            width: 100%;
            box-sizing: border-box;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
        }

        .footer-column {
            flex: 1;
            min-width: 200px;
            margin: 10px;
        }

        .footer-column h3 {
            font-size: 1.5em;
            margin-bottom: 15px;
            color: #F5F5F5;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .footer-column p {
            margin: 5px 0;
            font-size: 1em;
            line-height: 1.6;
        }

        .social-icons {
            display: flex;
            gap: 15px;
            margin-top: 10px;
        }

        .social-icons a {
            color: #FFFFFF;
            font-size: 1.5em;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .social-icons a:hover {
            color: #FFCC00; /* Hover color */
        }

        .footer-bottom {
            width: 100%;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            text-align: center;
            padding-top: 15px;
            font-size: 0.9em;
            color: #D3D3D3;
            margin-top: 20px;
        }

        /* Responsive design */
        @media (max-width: 800px) {
            footer {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .footer-column {
                margin: 15px 0;
            }

            .social-icons {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
<footer>
    <!-- Colonne 1 : Logo -->
    <div class="footer-column">
        <h3>Logo</h3>
    </div>

    <!-- Colonne 2 : Infos contact -->
    <div class="footer-section">
        <h3>Contact</h3>
        <p><?php echo get_theme_mod('cotemer_footer_address', '20 RUE DU GENERAL DE GAULLE, 56640 ARZON, France'); ?></p>
        <p>📞 <?php echo get_theme_mod('cotemer_footer_phone', '+33 2 97 53 63 67'); ?></p>
    </div>
    <!-- Colonne 3 : Réseaux sociaux -->
    <div class="footer-column">
        <h3>Suivez-nous</h3>
        <div class="social-icons">
            <a href="https://facebook.com" target="_blank" aria-label="Facebook">📘</a>
            <a href="https://instagram.com" target="_blank" aria-label="Instagram">📸</a>
        </div>
    </div>

    <!-- Bas de page -->
    <div class="footer-bottom">
        <p>© <span id="current-year"></span> COTE MER – Tous droits réservés</p>
    </div>
</footer>

<script>
    document.getElementById('current-year').textContent = new Date().getFullYear();
</script>
</body>
</html>
