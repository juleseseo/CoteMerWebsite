<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    /* Footer styles */
    footer {
      background-color: #060C64; /* Primary color from logo */
      color: #FFFFFF;
      padding: 40px 20px;
      font-family: 'Arial', sans-serif;
      text-align: center;
      width: 100%;
      margin: 0; /* Ensure no margins interfere */
      box-sizing: border-box; /* Include padding in width calculation */
      position: relative;
      bottom: 0;
    }

    .footer-section {
      margin-bottom: 20px;
    }

    .footer-section h3 {
      font-size: 1.5em;
      margin-bottom: 15px;
      color: #F5F5F5; /* Slightly lighter for contrast */
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .footer-section p {
      margin: 5px 0;
      font-size: 1em;
      line-height: 1.6;
    }

    .footer-bottom {
      border-top: 1px solid rgba(255, 255, 255, 0.2);
      padding-top: 15px;
      font-size: 0.9em;
      color: #D3D3D3;
    }

    /* Responsive design */
    @media (max-width: 600px) {
      .footer-section h3 {
        font-size: 1.2em;
      }

      .footer-section p {
        font-size: 0.9em;
      }

      .footer-bottom {
        font-size: 0.8em;
      }
    }
  </style>
</head>
<body>
<footer>
    <div class="footer-section">
        <h3>Contact</h3>
        <p><?php echo get_theme_mod('cotemer_footer_address', '20 RUE DU GENERAL DE GAULLE, 56640 ARZON, France'); ?></p>
        <p>📞 <?php echo get_theme_mod('cotemer_footer_phone', '+33 2 97 53 63 67'); ?></p>
    </div>
  <script>
    document.getElementById('current-year').textContent = new Date().getFullYear();
  </script>
</footer>

</body>
</html>