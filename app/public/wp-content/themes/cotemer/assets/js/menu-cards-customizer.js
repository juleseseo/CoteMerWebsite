jQuery(document).ready(function($) {
  // Initialise un contrôle (un seul) identifié par controlId
  function initMenuCardsControl(controlId) {
    const $container = $('#menu-cards-' + controlId);
    const $input = $('input[data-customize-setting-link="' + controlId + '"]');
    const $addButton = $('.add-menu-card[data-control-id="' + controlId + '"]');

    // Charge les cartes existantes depuis le hidden input
    function loadMenuCardsData() {
      const data = $input.val();
      if (!data) return;
      try {
        const cards = JSON.parse(data);
        cards.forEach(function(card, index) {
          addMenuCard(card.title, card.pdf_url, card.pdf_id, index);
        });
      } catch (e) {
        console.error('Erreur lors du chargement des données des cartes:', e);
      }
    }

    // Ajoute une carte dans l'UI
    function addMenuCard(title = '', pdfUrl = '', pdfId = '', index = null) {
      if (index === null) {
        index = $container.children('.menu-card-item').length;
      }

      const filename = pdfUrl ? (pdfUrl.split('/').pop() || '') : '';
      const cardHtml = `
        <div class="menu-card-item" data-index="${index}">
          <div class="menu-card-header">
            <h4>Carte ${index + 1}</h4>
            <button type="button" class="button remove-card">Supprimer</button>
          </div>
          <div class="menu-card-content">
            <div class="menu-card-field">
              <label>Titre de la carte :</label>
              <input type="text" class="menu-card-title" placeholder="Ex: Carte des vins" value="${escapeHtml(title)}">
            </div>
            <div class="menu-card-field">
              <label>Fichier PDF :</label>
              <div class="menu-card-pdf-control">
                <div class="pdf-preview">
                  ${pdfUrl ? `<span class="pdf-name">📄 ${escapeHtml(filename)}</span>` : '<span class="no-pdf">Aucun PDF sélectionné</span>'}
                </div>
                <button type="button" class="button select-pdf">
                  ${pdfUrl ? 'Changer le PDF' : 'Sélectionner un PDF'}
                </button>
              </div>
            </div>
            <div class="menu-card-actions">
              <button type="button" class="button move-up" ${index === 0 ? 'disabled' : ''}>↑ Monter</button>
              <button type="button" class="button move-down">↓ Descendre</button>
            </div>
          </div>
          <input type="hidden" class="menu-card-pdf-url" value="${escapeHtml(pdfUrl)}">
          <input type="hidden" class="menu-card-pdf-id" value="${escapeHtml(pdfId)}">
        </div>
      `;

      $container.append(cardHtml);
      updateMoveButtons();
      updateCardNumbers();
    }

    // Sauvegarde le JSON dans le champ hidden
    function updateMenuCardsData() {
      const cards = [];
      $container.find('.menu-card-item').each(function() {
        const title = $(this).find('.menu-card-title').val();
        const pdfUrl = $(this).find('.menu-card-pdf-url').val();
        const pdfId = $(this).find('.menu-card-pdf-id').val();
        if (title || pdfUrl) {
          cards.push({
            title: title,
            pdf_url: pdfUrl,
            pdf_id: pdfId
          });
        }
      });
      $input.val(JSON.stringify(cards)).trigger('change');
    }

    function updateMoveButtons() {
      const $items = $container.find('.menu-card-item');
      $items.each(function(i) {
        const $card = $(this);
        $card.attr('data-index', i);
        $card.find('.move-up').prop('disabled', i === 0);
        $card.find('.move-down').prop('disabled', i === $items.length - 1);
      });
    }

    function updateCardNumbers() {
      $container.find('.menu-card-item').each(function(i) {
        $(this).find('.menu-card-header h4').text('Carte ' + (i + 1));
      });
    }

    // Ajout : ouvre une nouvelle carte vide et sauvegarde
    $addButton.on('click', function(e) {
      e.preventDefault();
      addMenuCard();
      updateMenuCardsData();
    });

    // Delegation : sélectionner un PDF (WP media)
    $container.on('click', '.select-pdf', function(e) {
      e.preventDefault();
      const $btn = $(this);
      const $card = $btn.closest('.menu-card-item');
      const $preview = $card.find('.pdf-preview');
      const $urlInput = $card.find('.menu-card-pdf-url');
      const $idInput = $card.find('.menu-card-pdf-id');

      const frame = wp.media({
        title: 'Sélectionner un fichier PDF',
        button: { text: 'Utiliser ce PDF' },
        library: { type: 'application/pdf' },
        multiple: false
      });

      frame.on('select', function() {
        const attachment = frame.state().get('selection').first().toJSON();
        $urlInput.val(attachment.url || '');
        $idInput.val(attachment.id || '');
        const name = attachment.filename || (attachment.url ? attachment.url.split('/').pop() : '');
        $preview.html(`<span class="pdf-name">📄 ${escapeHtml(name)}</span>`);
        $btn.text('Changer le PDF');
        updateMenuCardsData();
      });

      frame.open();
    });

    // Supprimer une carte
    $container.on('click', '.remove-card', function() {
      if (!confirm('Êtes-vous sûr de vouloir supprimer cette carte ?')) return;
      $(this).closest('.menu-card-item').remove();
      updateMoveButtons();
      updateCardNumbers();
      updateMenuCardsData();
    });

    // Titre modifié => sauvegarde
    $container.on('input', '.menu-card-title', function() {
      updateMenuCardsData();
    });

    // Monter / descendre
    $container.on('click', '.move-up', function(e) {
      e.preventDefault();
      const $card = $(this).closest('.menu-card-item');
      const $prev = $card.prev('.menu-card-item');
      if ($prev.length) {
        $card.insertBefore($prev);
        updateMoveButtons();
        updateCardNumbers();
        updateMenuCardsData();
      }
    });

    $container.on('click', '.move-down', function(e) {
      e.preventDefault();
      const $card = $(this).closest('.menu-card-item');
      const $next = $card.next('.menu-card-item');
      if ($next.length) {
        $card.insertAfter($next);
        updateMoveButtons();
        updateCardNumbers();
        updateMenuCardsData();
      }
    });

    // helper escape pour éviter d'injecter du HTML
    function escapeHtml(str) {
      if (!str) return '';
      return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
    }

    // initial load
    loadMenuCardsData();
  }

  // Initialiser tous les contrôles présents
  $('.menu-cards-control-container').each(function() {
    const controlId = $(this).find('.add-menu-card').attr('data-control-id');
    if (controlId) {
      initMenuCardsControl(controlId);
    }
  });
});
