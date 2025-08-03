jQuery(document).ready(function($) {
    // Fonction pour initialiser les contrôles de galerie
    function initGalleryControl(controlId) {
        const container = $('#gallery-items-' + controlId);
        const input = $('input[data-customize-setting-link="' + controlId + '"]');
        const addButton = $('.add-gallery-item[data-control-id="' + controlId + '"]');

        // Charger les données existantes
        function loadGalleryData() {
            const data = input.val();
            if (data) {
                try {
                    const items = JSON.parse(data);
                    items.forEach(function(item, index) {
                        addGalleryItem(item.image, item.caption, index);
                    });
                } catch (e) {
                    console.error('Erreur lors du chargement des données de galerie:', e);
                }
            }
        }

        // Ajouter un élément à la galerie
        function addGalleryItem(imageUrl = '', caption = '', index = null) {
            if (index === null) {
                index = container.children().length;
            }

            const itemHtml = `
                <div class="gallery-item" data-index="${index}">
                    <div class="gallery-item-preview">
                        ${imageUrl ? `<img src="${imageUrl}" alt="" style="max-width: 100px; height: auto;">` : '<div class="no-image">Aucune image</div>'}
                    </div>
                    <div class="gallery-item-controls">
                        <input type="text" class="gallery-caption" placeholder="Légende" value="${caption}">
                        <button type="button" class="button select-image">
                            ${imageUrl ? 'Changer l\'image' : 'Sélectionner une image'}
                        </button>
                        <button type="button" class="button remove-item">Supprimer</button>
                        <div class="gallery-item-actions">
                            <button type="button" class="button move-up" ${index === 0 ? 'disabled' : ''}>↑</button>
                            <button type="button" class="button move-down">↓</button>
                        </div>
                    </div>
                    <input type="hidden" class="gallery-image-url" value="${imageUrl}">
                </div>
            `;

            container.append(itemHtml);
            updateMoveButtons();
        }

        // Mettre à jour les données
        function updateGalleryData() {
            const items = [];
            container.find('.gallery-item').each(function() {
                const image = $(this).find('.gallery-image-url').val();
                const caption = $(this).find('.gallery-caption').val();
                if (image) {
                    items.push({ image: image, caption: caption });
                }
            });

            input.val(JSON.stringify(items)).trigger('change');
        }

        // Mettre à jour les boutons de déplacement
        function updateMoveButtons() {
            container.find('.gallery-item').each(function(index) {
                const $item = $(this);
                $item.attr('data-index', index);
                $item.find('.move-up').prop('disabled', index === 0);
                $item.find('.move-down').prop('disabled', index === container.find('.gallery-item').length - 1);
            });
        }

        // Événement pour ajouter une nouvelle image
        addButton.on('click', function() {
            addGalleryItem();
        });

        // Événements délégués pour les contrôles des éléments
        container.on('click', '.select-image', function() {
            const $item = $(this).closest('.gallery-item');
            const $preview = $item.find('.gallery-item-preview');
            const $urlInput = $item.find('.gallery-image-url');

            const mediaUploader = wp.media({
                title: 'Sélectionner une image',
                button: { text: 'Utiliser cette image' },
                multiple: false,
                library: { type: 'image' }
            });

            mediaUploader.on('select', function() {
                const attachment = mediaUploader.state().get('selection').first().toJSON();
                $urlInput.val(attachment.url);
                $preview.html(`<img src="${attachment.url}" alt="" style="max-width: 100px; height: auto;">`);
                $(this).text('Changer l\'image');
                updateGalleryData();
            }.bind(this));

            mediaUploader.open();
        });

        container.on('click', '.remove-item', function() {
            $(this).closest('.gallery-item').remove();
            updateMoveButtons();
            updateGalleryData();
        });

        container.on('input', '.gallery-caption', function() {
            updateGalleryData();
        });

        container.on('click', '.move-up', function() {
            const $item = $(this).closest('.gallery-item');
            const $prev = $item.prev();
            if ($prev.length) {
                $item.insertBefore($prev);
                updateMoveButtons();
                updateGalleryData();
            }
        });

        container.on('click', '.move-down', function() {
            const $item = $(this).closest('.gallery-item');
            const $next = $item.next();
            if ($next.length) {
                $item.insertAfter($next);
                updateMoveButtons();
                updateGalleryData();
            }
        });

        // Charger les données existantes au démarrage
        loadGalleryData();
    }

    // Initialiser tous les contrôles de galerie
    $('.gallery-control-container').each(function() {
        const controlId = $(this).find('.add-gallery-item').attr('data-control-id');
        if (controlId) {
            initGalleryControl(controlId);
        }
    });
});