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


// JavaScript pour le modal du menu
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('imageModal');
    const modalImg = document.getElementById('modalImage');
    const caption = document.getElementById('imageCaption');
    const closeBtn = document.querySelector('.close-btn');
    const menuItems = document.querySelectorAll('.menu-item');

    // Fonction pour ouvrir le modal
    function openModal(imageSrc, imageTitle) {
        modal.style.display = 'block';
        modalImg.src = imageSrc;
        caption.textContent = imageTitle;

        // Animation d'entrée
        setTimeout(() => {
            modal.classList.add('show');
        }, 10);

        // Désactiver le scroll de la page
        document.body.style.overflow = 'hidden';

        // Focus sur le bouton de fermeture pour l'accessibilité
        closeBtn.focus();
    }

    // Fonction pour fermer le modal
    function closeModal() {
        modal.classList.remove('show');

        setTimeout(() => {
            modal.style.display = 'none';
            // Réactiver le scroll de la page
            document.body.style.overflow = '';
        }, 300);
    }

    // Ajouter les événements de clic sur chaque élément du menu
    menuItems.forEach(item => {
        item.addEventListener('click', function() {
            const imageSrc = this.dataset.image;
            const imageTitle = this.dataset.title;
            openModal(imageSrc, imageTitle);
        });

        // Support du clavier pour l'accessibilité
        item.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                const imageSrc = this.dataset.image;
                const imageTitle = this.dataset.title;
                openModal(imageSrc, imageTitle);
            }
        });

        // Rendre les éléments focusables
        item.setAttribute('tabindex', '0');
        item.setAttribute('role', 'button');
        item.setAttribute('aria-label', 'Voir l\'image en grand : ' + item.dataset.title);
    });

    // Fermer le modal en cliquant sur le bouton de fermeture
    closeBtn.addEventListener('click', closeModal);

    // Fermer le modal en cliquant en dehors de l'image
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeModal();
        }
    });

    // Fermer le modal avec la touche Échap
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal.style.display === 'block') {
            closeModal();
        }
    });

    // Empêcher la fermeture lors du clic sur l'image
    modalImg.addEventListener('click', function(e) {
        e.stopPropagation();
    });

    // Empêcher la fermeture lors du clic sur la caption
    caption.addEventListener('click', function(e) {
        e.stopPropagation();
    });

    // Gestion du redimensionnement de la fenêtre
    window.addEventListener('resize', function() {
        if (modal.style.display === 'block') {
            // Réajuster la position si nécessaire
            modalImg.style.maxWidth = '90%';
            modalImg.style.maxHeight = '80%';
        }
    });
});