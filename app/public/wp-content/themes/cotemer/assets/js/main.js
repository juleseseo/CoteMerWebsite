document.addEventListener('DOMContentLoaded', function() {
    // Année actuelle dans le footer
    const currentYear = document.getElementById('current-year');
    if (currentYear) {
        currentYear.textContent = new Date().getFullYear();
    }

    // Menu burger
    const burger = document.getElementById('burger');
    const mainNav = document.getElementById('main-nav');

    if (burger && mainNav) {
        burger.addEventListener('click', function() {
            burger.classList.toggle('active');
            mainNav.classList.toggle('active');
        });

        // Fermer le menu au clic sur un lien
        const navLinks = document.querySelectorAll('.nav-list a');
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                burger.classList.remove('active');
                mainNav.classList.remove('active');
            });
        });
    }

    // Carousel
    const carousel = document.getElementById('carousel');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const items = document.querySelectorAll('.carousel-item');

    if (carousel && items.length > 0) {
        let index = 0;
        const total = items.length;

        function updateCarousel() {
            carousel.style.transform = `translateX(-${index * 100}%)`;
        }

        function showNext() {
            index = (index + 1) % total;
            updateCarousel();
        }

        function showPrev() {
            index = (index - 1 + total) % total;
            updateCarousel();
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', showNext);
        }

        if (prevBtn) {
            prevBtn.addEventListener('click', showPrev);
        }

        // Auto-play
        let autoPlay = setInterval(showNext, 4000);

        // Pause au survol
        const carouselWrapper = document.querySelector('.carousel-wrapper');
        if (carouselWrapper) {
            carouselWrapper.addEventListener('mouseenter', function() {
                clearInterval(autoPlay);
            });

            carouselWrapper.addEventListener('mouseleave', function() {
                autoPlay = setInterval(showNext, 4000);
            });
        }
    }

    // Navigation fluide
    const anchorLinks = document.querySelectorAll('a[href^="#"]');
    anchorLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);

            if (targetElement) {
                const offsetTop = targetElement.offsetTop - 100; // Compensation pour le header fixe
                window.scrollTo({
                    top: offsetTop,
                    behavior: 'smooth'
                });
            }
        });
    });
});

document.addEventListener('DOMContentLoaded', function () {
  const menuItems = document.querySelectorAll('.menu-item');
  const modal = document.getElementById('menuModal');
  const modalBody = document.querySelector('.modal-body');
  const closeBtn = document.querySelector('.close-btn');

  // Lorsque l'utilisateur clique sur un élément du menu
  menuItems.forEach(item => {
    item.addEventListener('click', function () {
      const fileUrl = item.getAttribute('data-file-url');
      if (fileUrl) {
        modalBody.innerHTML = `<iframe src="https://docs.google.com/viewer?url=${fileUrl}&embedded=true" width="100%" height="400px" style="border: none;"></iframe>`;
        modal.style.display = 'block';
      }
    });
  });

  // Fermer la modale lorsque le bouton de fermeture est cliqué
  closeBtn.addEventListener('click', function () {
    modal.style.display = 'none';
  });

  // Fermer la modale si l'utilisateur clique en dehors de la modale
  window.addEventListener('click', function (event) {
    if (event.target === modal) {
      modal.style.display = 'none';
    }
  });
});
