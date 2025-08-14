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
    const modal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');
    const imageCaption = document.getElementById('imageCaption');
    const closeBtn = document.querySelector('#imageModal .close-btn');

    // Fonction pour fermer la modale
    function closeModal() {
        if (modal) {
            modal.style.display = 'none';
            modalImage.src = '';
            imageCaption.textContent = '';
            document.body.style.overflow = ''; // Restaurer le scroll
        }
    }

    // Fonction pour ouvrir la modale avec l'image
    function openModal(imageUrl, title) {
        if (modal && modalImage) {
            // Précharger l'image
            const img = new Image();

            // Afficher un loading pendant le chargement
            modalImage.style.opacity = '0';
            imageCaption.innerHTML = '<div class="loading-text">Chargement...</div>';
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden'; // Empêcher le scroll de la page

            img.onload = function() {
                modalImage.src = imageUrl;
                modalImage.alt = title;
                imageCaption.innerHTML = `<h3>${title}</h3>`;
                modalImage.style.opacity = '1';

                // Animation d'apparition
                modalImage.style.transform = 'scale(0.8)';
                setTimeout(() => {
                    modalImage.style.transform = 'scale(1)';
                }, 50);
            };

            img.onerror = function() {
                imageCaption.innerHTML = `
                    <div class="error-message">
                        <h3>${title}</h3>
                        <p>Erreur lors du chargement de l'image</p>
                    </div>
                `;
                modalImage.style.opacity = '1';
            };

            img.src = imageUrl;
        }
    }

    // Gestionnaire d'événements pour les éléments du menu
    menuItems.forEach(item => {
        // Ajouter des effets de survol
        item.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px) scale(1.02)';
        });

        item.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });

        // Gestionnaire de clic
        item.addEventListener('click', function(e) {
            e.preventDefault();

            const imageUrl = this.getAttribute('data-image');
            const title = this.getAttribute('data-title') || 'Menu';

            if (imageUrl) {
                // Animation de clic
                this.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    this.style.transform = '';
                    openModal(imageUrl, title);
                }, 100);
            }
        });

        // Accessibilité : permettre l'ouverture avec Entrée ou Espace
        item.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                this.click();
            }
        });

        // Rendre les éléments focusables et accessibles
        item.setAttribute('tabindex', '0');
        item.setAttribute('role', 'button');
        item.setAttribute('aria-label', `Agrandir ${item.getAttribute('data-title') || 'l\'image du menu'}`);
    });

    // Fermer la modale avec le bouton de fermeture
    if (closeBtn) {
        closeBtn.addEventListener('click', closeModal);
    }

    // Fermer la modale en cliquant à l'extérieur de l'image
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === this || e.target.classList.contains('image-modal-body')) {
                closeModal();
            }
        });
    }

    // Fermer la modale avec Échap
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal && modal.style.display === 'block') {
            closeModal();
        }
    });

    // Navigation avec les flèches (optionnel - pour naviguer entre les images)
    document.addEventListener('keydown', function(e) {
        if (modal && modal.style.display === 'block') {
            const currentImage = modalImage.src;
            const menuItemsArray = Array.from(menuItems);
            const currentIndex = menuItemsArray.findIndex(item =>
                item.getAttribute('data-image') === currentImage
            );

            if (e.key === 'ArrowRight' && currentIndex < menuItemsArray.length - 1) {
                const nextItem = menuItemsArray[currentIndex + 1];
                const nextImageUrl = nextItem.getAttribute('data-image');
                const nextTitle = nextItem.getAttribute('data-title');
                if (nextImageUrl) {
                    openModal(nextImageUrl, nextTitle);
                }
            } else if (e.key === 'ArrowLeft' && currentIndex > 0) {
                const prevItem = menuItemsArray[currentIndex - 1];
                const prevImageUrl = prevItem.getAttribute('data-image');
                const prevTitle = prevItem.getAttribute('data-title');
                if (prevImageUrl) {
                    openModal(prevImageUrl, prevTitle);
                }
            }
        }
    });

    // Zoom sur l'image avec la molette (optionnel)
    if (modalImage) {
        let scale = 1;
        const maxScale = 3;
        const minScale = 0.5;

        modalImage.addEventListener('wheel', function(e) {
            if (modal.style.display === 'block') {
                e.preventDefault();

                const delta = e.deltaY > 0 ? -0.1 : 0.1;
                scale += delta;
                scale = Math.max(minScale, Math.min(maxScale, scale));

                this.style.transform = `scale(${scale})`;

                // Réinitialiser le zoom si on double-clique
                this.addEventListener('dblclick', function() {
                    scale = 1;
                    this.style.transform = 'scale(1)';
                });
            }
        });
    }

    // Support pour les gestes tactiles (pincement pour zoomer) sur mobile
    if (modalImage && 'ontouchstart' in window) {
        let initialDistance = 0;
        let scale = 1;

        modalImage.addEventListener('touchstart', function(e) {
            if (e.touches.length === 2) {
                const touch1 = e.touches[0];
                const touch2 = e.touches[1];
                initialDistance = Math.sqrt(
                    Math.pow(touch2.clientX - touch1.clientX, 2) +
                    Math.pow(touch2.clientY - touch1.clientY, 2)
                );
            }
        });

        modalImage.addEventListener('touchmove', function(e) {
            if (e.touches.length === 2 && modal.style.display === 'block') {
                e.preventDefault();

                const touch1 = e.touches[0];
                const touch2 = e.touches[1];
                const currentDistance = Math.sqrt(
                    Math.pow(touch2.clientX - touch1.clientX, 2) +
                    Math.pow(touch2.clientY - touch1.clientY, 2)
                );

                if (initialDistance > 0) {
                    const scaleChange = currentDistance / initialDistance;
                    scale = Math.max(0.5, Math.min(3, scaleChange));
                    this.style.transform = `scale(${scale})`;
                }
            }
        });
    }

    // Amélioration de l'accessibilité : annonce du nombre d'éléments
    const menuCount = menuItems.length;
    if (menuCount > 0) {
        const menuSection = document.getElementById('menu');
        if (menuSection) {
            menuSection.setAttribute('aria-label', `Section menu avec ${menuCount} carte${menuCount > 1 ? 's' : ''}`);
        }
    }
});