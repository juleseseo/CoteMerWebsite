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
