<?php get_header(); ?>

<?php include get_template_directory() . '/intro.php'; ?>

    <section id="banner" class="hero-banner">
        <div class="banner-overlay"></div>
        <div class="banner-content">
            <h1 class="hero-title">Bienvenue chez Côté Mer</h1>
            <p class="hero-subtitle">Venez découvrir nos plats en bord de mer</p>
            <p class="opening-hours">
                Aujourd'hui nous sommes <?php
                $closing = cotemer_get_today_closing_hour();
                echo $closing === 'fermé' ? 'fermés' : "ouverts jusqu'à $closing";
                ?>.
            </p>
        </div>
        <style>
            .hero-banner{
                background-image: url('<?php echo get_template_directory_uri(); ?>/assets/img/vue.jpg');
            }
        </style>
    </section>

    <section id="menu" class="menu-section">
        <!-- Modale pour afficher l'image en grand -->
        <div id="imageModal" class="modal">
            <span class="close-btn">&times;</span>
            <img class="modal-content" id="modalImage" alt="Image agrandie">
            <div id="imageCaption"></div>
        </div>

        <?php
        // Titre depuis le customizer
        $menu_title = get_theme_mod('cotemer_menu_title', 'Notre carte');
        ?>
        <div class="container">
            <h2 class="section-title"><?php echo esc_html($menu_title); ?></h2>

            <div class="menu-grid">
                <?php
                $max_menu_cards = 5;
                for ($i = 1; $i <= $max_menu_cards; $i++) {
                    $card_title = get_theme_mod("cotemer_menu_card_{$i}_title", '');
                    $card_image_id = get_theme_mod("cotemer_menu_card_{$i}_image", '');

                    if ($card_title && $card_image_id) {
                        $image_url = wp_get_attachment_url($card_image_id);
                        if ($image_url): ?>
                            <div class="menu-item"
                                 data-image="<?php echo esc_url($image_url); ?>"
                                 data-title="<?php echo esc_attr($card_title); ?>">
                                <div class="menu-item-content">
                                    <p class="menu-item-title"><strong><?php echo esc_html($card_title); ?></strong></p>
                                    <div class="menu-item-image">
                                        <img src="<?php echo esc_url($image_url); ?>"
                                             alt="<?php echo esc_attr($card_title); ?>"
                                             oncontextmenu="return false;">
                                    </div>
                                </div>
                            </div>
                        <?php endif;
                    }
                }

                $args = array(
                    'post_type'      => 'restaurant_menu',
                    'posts_per_page' => -1,
                    'orderby'        => 'title',
                    'order'          => 'ASC',
                );
                $menus = new WP_Query($args);

                if ($menus->have_posts()):
                    while ($menus->have_posts()): $menus->the_post();
                        $image_id = get_post_meta(get_the_ID(), '_cotemer_menu_image', true);

                        if ($image_id) {
                            if (is_numeric($image_id)) {
                                $image_url = wp_get_attachment_url($image_id);
                            } else {
                                $image_url = esc_url($image_id);
                            }

                            if ($image_url): ?>
                                <div class="menu-item"
                                     data-image="<?php echo esc_url($image_url); ?>"
                                     data-title="<?php the_title_attribute(); ?>">
                                    <div class="menu-item-content">
                                        <p class="menu-item-title"><strong><?php the_title(); ?></strong></p>
                                        <div class="menu-item-image">
                                            <img src="<?php echo esc_url($image_url); ?>"
                                                 alt="<?php the_title_attribute(); ?>"
                                                 oncontextmenu="return false;">
                                        </div>
                                    </div>
                                </div>
                            <?php endif;
                        }
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>
        </div>
    </section>

    <section id="gallery" class="gallery-section">
        <div class="container">
            <h2 class="section-title">Galerie</h2>
            <div class="carousel-wrapper">
                <button class="carousel-btn prev" id="prevBtn" aria-label="Image précédente">&larr;</button>
                <div class="carousel" id="carousel">
                    <?php
                    $gallery_data = get_theme_mod('cotemer_gallery_images', '');
                    $has_gallery = false;

                    if (!empty($gallery_data)) {
                        $images = json_decode($gallery_data, true);

                        if (is_array($images) && !empty($images)) {
                            $has_gallery = true;
                            foreach ($images as $item) {
                                if (!empty($item['image'])) {
                                    echo '<div class="carousel-item">';
                                    echo '<img src="' . esc_url($item['image']) . '" alt="' . esc_attr($item['caption']) . '">';
                                    if (!empty($item['caption'])) {
                                        echo '<p class="carousel-caption">' . esc_html($item['caption']) . '</p>';
                                    }
                                    echo '</div>';
                                }
                            }
                        }
                    }
                    ?>
                </div>
                <button class="carousel-btn next" id="nextBtn" aria-label="Image suivante">&rarr;</button>
            </div>
        </div>
    </section>

    <section id="about" class="about-section">
        <div class="container">
            <h2 class="section-title">À propos</h2>
            <div class="about-container">
                <?php
                for ($i = 1; $i <= 3; $i++) :
                    $title = get_theme_mod("cotemer_about_title_$i");
                    $text = get_theme_mod("cotemer_about_text_$i");
                    $image = get_theme_mod("cotemer_about_image_$i");

                    if ($title || $text || $image): ?>
                        <div class="about-block">
                            <?php if ($image): ?>
                                <div class="about-image" style="background-image: url('<?php echo esc_url($image); ?>');"></div>
                            <?php endif; ?>
                            <div class="about-content">
                                <?php if ($title): ?>
                                    <h3><?php echo esc_html($title); ?></h3>
                                <?php endif; ?>
                                <?php if ($text): ?>
                                    <p><?php echo nl2br(esc_html($text)); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif;
                endfor; ?>
            </div>
        </div>
    </section>

    <section id="contact" class="contact-section">
        <div class="container">
            <h2 class="section-title">Contactez-nous</h2>
            <div class="contact-content">
                <div class="contact-info">
                    <?php
                    $contact_page = get_page_by_path('contact');
                    if ($contact_page) {
                        echo apply_filters('the_content', $contact_page->post_content);
                    } else {
                        echo '<div class="contact-details">';
                        echo '<p class="contact-item">📍 <a class="hover-link" href="https://www.google.com/maps/place/20+Rue+du+G%C3%A9n%C3%A9ral+de+Gaulle,+56640+Arzon,+France" target="_blank">20 RUE DU GENERAL DE GAULLE, 56640 ARZON, France</a></p>';
                        echo '<p class="contact-item">📞 <a class="hover-link" href="tel:+33297536367">+33 2 97 53 63 67</a></p>';
                        echo '<p class="contact-item">✉️ <a class="hover-link" href="mailto:cotemer.portnavalo@gmail.com">cotemer.portnavalo@gmail.com</a></p>';
                        echo '</div>';
                    }
                    ?>
                </div>

                <!-- Google Maps -->
                <div class="map-container">
                    <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2693.360196136136!2d-2.8942341844228183!3d47.54404879936627!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x48101a46d1a69ff5%3A0x257c822f9605fc71!2s20%20Rue%20du%20G%C3%A9n%C3%A9ral%20de%20Gaulle%2C%2056640%20Arzon%2C%20France!5e0!3m2!1sfr!2sfr!4v1686929205178!5m2!1sfr!2sfr"
                            width="100%"
                            height="400"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </section>

<?php get_footer(); ?>