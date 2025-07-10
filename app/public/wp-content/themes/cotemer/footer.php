
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
    <p>123 Rue du Bord de Mer, 75000 Paris</p>
    <p>📞 01 23 45 67 89</p>
    <p>Email: <a href="mailto:contact@cotemer.fr">contact@cotemer.fr</a></p>
    <p>Horaires : Du lundi au vendredi, 12h - 23h</p>
  </div>

  <div class="footer-section">
    <h3>Suivez-nous</h3>
    <ul>
      <li><a href="https://facebook.com/cotemer">Facebook</a></li>
      <li><a href="https://instagram.com/cotemer">Instagram</a></li>
      <li><a href="https://twitter.com/cotemer">Twitter</a></li>
    </ul>
  </div>

  <div class="footer-section">
    <h3>Informations</h3>
    <ul>
      <li><a href="/menu">Menu</a></li>
      <li><a href="/about">À propos</a></li>
      <li><a href="/contact">Contact</a></li>
      <li><a href="/reservation">Réserver</a></li>
      <li><a href="/privacy-policy">Politique de confidentialité</a></li>
      <li><a href="/mentions-legales">Mentions légales</a></li>
    </ul>
  </div>

  <div class="footer-section">
    <p>Inscrivez-vous à notre newsletter :</p>
    <form>
      <input type="email" placeholder="Votre email" />
      <button type="submit">S'inscrire</button>
    </form>
  </div>

  <div class="footer-bottom">
    <p>© 2025 Côté Mer – Tous droits réservés</p>
  </div>
</footer>
