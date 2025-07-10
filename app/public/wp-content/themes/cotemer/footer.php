
<script>
    // Burger menu
    document.getElementById("burger").addEventListener("click", function() {
        document.getElementById("main-nav").classList.toggle("active");
    });

    // Smooth scroll
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener("click", function(e) {
            e.preventDefault();
            document.querySelector(this.getAttribute("href")).scrollIntoView({
                behavior: "smooth"
            });
            document.getElementById("main-nav").classList.remove("active"); // Ferme le menu mobile
        });
    });
</script>
<footer>
  <div class="footer-section">
    <h3>Contact</h3>
    <p>20 RUE DU GENERAL DE GAULLE</p>
    <p>56640 ARZON</p>
    <p>France</p>
    <p>📞 +33 2 97 53 63 67</p>
  </div>

  <div class="footer-bottom">
    <p>© 2025 Côté Mer – Tous droits réservés</p>
  </div>
</footer>
